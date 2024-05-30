<?php
$servername = "localhost";
$username = "root"; // Remplacez par votre nom d'utilisateur
$password = ""; // Remplacez par votre mot de passe
$dbname = "projet_piscine"; // Remplacez par le nom de votre base de données

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$agent_id = 11;

// Requête pour récupérer les informations de l'agent
$sql = "SELECT * FROM AGENT_IMMO WHERE numero_identification = $agent_id";
$result = $conn->query($sql);
if ($result === FALSE) {
    die("Erreur dans la requête SQL : " . $conn->error);
}

$agent = $result->fetch_assoc();
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Immobilier - <?php echo $agent['prenom'] . " " . $agent['nom']; ?></title>
    <link rel="stylesheet" href="agents.css">
    <script src="agents.js" defer></script>
</head>
<body>
    <div class="agent-card">
        <img src="<?php echo $agent['photo']; ?>" alt="Photo de l'agent">
        <div class="agent-details">
            <h2><?php echo $agent['prenom'] . " " . $agent['nom']; ?></h2>
            <p class="agent-title">Agent Immobilier agréé</p>
            <p><strong>Téléphone:</strong> <?php echo $agent['tel']; ?></p>
            <p><strong>Email:</strong> <a href="mailto:<?php echo $agent['courriel']; ?>"><?php echo $agent['courriel']; ?></a></p>
        </div>
        <table class="schedule">
            <thead>
                <tr>
                    <th>Lundi</th>
                    <th>Mardi</th>
                    <th>Mercredi</th>
                    <th>Jeudi</th>
                    <th>Vendredi</th>
                    <th>Samedi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $disponibilites = json_decode($agent['disponibilites'], true);
                foreach ($disponibilites as $day) {
                    echo "<tr>";
                    foreach ($day as $status) {
                        $class = $status ? 'busy' : 'free';
                        echo "<td class='$class'></td>";
                    }
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="buttons">
            <button class="btn" onclick="prendreRDV()">Prendre un RDV</button>
            <button class="btn" onclick="communiquerAgent()">Communiquer avec l'agent immobilier</button>
            <button class="btn" onclick="voirCV()">Voir son CV</button>
        </div>
    </div>
</body>
</html>
