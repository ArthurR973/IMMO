<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projet_piscine"; // Remplacez par le nom correct de votre base de données

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $courriel = $_POST['courriel'];
    $mot_de_passe = $_POST['mot_de_passe'];

    $stmt = $conn->prepare("SELECT * FROM clients WHERE courriel = :courriel AND Mot_de_passe = :mot_de_passe");
    $stmt->execute(['courriel' => $courriel, 'mot_de_passe' => $mot_de_passe]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['user_id'] = $user['ID'];
        $_SESSION['user_name'] = $user['Prénom'] . ' ' . $user['Nom'];
        header("Location: espace_client.php");
        exit();
    } else {
        echo "Identifiants incorrects. Veuillez réessayer.";
    }
}
?>




<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Client - Omnes Immobilier</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Lora', serif;
            color: #333;
        }
        .container {
            text-align: center;
            max-width: 400px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
        .logo {
            width: 100%;
            max-width: 200px;
            height: auto;
            display: block;
            margin: 0 auto 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="accueil.php">
            <img src="logotest.png" alt="Logo Omnes Immobilier" class="logo">
        </a>
        <h2 class="form-title">Connexion Client</h2>
        <form method="post" action="client_connexion.php">
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" required>
                <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Affiche le message d'erreur si le mot de passe est incorrect
            if (isset($Mot_de_passe) && $result->num_rows == 0) {
                echo "<p class='error-message'>Mot de passe incorrect.</p>";
            }
        }
    ?>
            </div>
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
    </div>
</body>
</html>
