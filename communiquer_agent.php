<?php
session_start();

// Assurez-vous que l'utilisateur et l'agent sont définis
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = rand(1, 1000000);  // Remplacez par votre logique pour générer ou obtenir un user_id unique
}
if (!isset($_GET['agent_id'])) {
    die("Agent ID non spécifié");
}

$user_id = $_SESSION['user_id'];
$agent_id = $_GET['agent_id'];

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projet_piscine";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Vérifiez si la colonne 'message' existe
$columnExistsQuery = "SHOW COLUMNS FROM AGENT_IMMO LIKE 'message'";
$columnExistsResult = $conn->query($columnExistsQuery);

if ($columnExistsResult->num_rows == 0) {
    // Ajouter la colonne 'message'
    $addColumnQuery = "ALTER TABLE AGENT_IMMO ADD COLUMN message INT";
    if ($conn->query($addColumnQuery) === TRUE) {
        // Mettre à jour chaque agent avec un nombre à 2 chiffres aléatoire
        $updateMessageQuery = "UPDATE AGENT_IMMO SET message = FLOOR(10 + RAND() * 90)";
        $conn->query($updateMessageQuery);
    } else {
        die("Erreur lors de l'ajout de la colonne 'message': " . $conn->error);
    }
}

// Création de la table des messages si elle n'existe pas
$tableCreationQuery = "
CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    agent_id INT NOT NULL,
    message TEXT NOT NULL,
    sender ENUM('user', 'agent') NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (agent_id) REFERENCES AGENT_IMMO(numero_identification)
)";

if ($conn->query($tableCreationQuery) === FALSE) {
    die("Error creating table: " . $conn->error);
}

// Traitement du formulaire d'envoi de message
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['message'];

    if (!empty($message)) {
        $stmt = $conn->prepare("INSERT INTO messages (user_id, agent_id, message, sender) VALUES (?, ?, ?, 'user')");
        $stmt->bind_param("iis", $user_id, $agent_id, $message);
        $stmt->execute();
        $stmt->close();

        // Ajouter une réponse automatique de l'agent
        $autoResponse = "Merci pour votre message. Nous reviendrons vers vous sous peu.";
        $stmt = $conn->prepare("INSERT INTO messages (user_id, agent_id, message, sender) VALUES (?, ?, ?, 'agent')");
        $stmt->bind_param("iis", $user_id, $agent_id, $autoResponse);
        $stmt->execute();
        $stmt->close();
    }
}

// Récupération des messages
$stmt = $conn->prepare("SELECT * FROM messages WHERE user_id = ? AND agent_id = ? ORDER BY timestamp ASC");
$stmt->bind_param("ii", $user_id, $agent_id);
$stmt->execute();
$result = $stmt->get_result();
$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="communiquer_agent.css">
    <title>Chat avec Agent</title>
</head>
<body>
    <div class="chat-container">
        <header>
            <h2>Chat avec Agent</h2>
        </header>
        <div class="chat-window" id="chat-window">
            <div class="messages" id="messages">
                <?php foreach ($messages as $message): ?>
                    <div class="message <?= $message['sender'] === 'agent' ? 'message-agent' : '' ?>">
                        <?= htmlspecialchars($message['message']) ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <form class="chat-input" method="post" action="">
            <input type="text" id="message-input" name="message" placeholder="Tapez votre message...">
            <button type="submit">Envoyer</button>
        </form>
        <div class="communication-options">
            <button type="button" onclick="startAudioCall()">Appel Audio</button>
            <button type="button" onclick="startVideoCall()">Appel Vidéo</button>
            <button type="button" onclick="sendEmail()">Envoyer Email</button>
        </div>
    </div>
    <script src="communiquer_agent.js"></script>
</body>
</html>
