<?php
session_start();

// Vérifie si les variables de session sont définies
if (isset($_SESSION['name']) && isset($_SESSION['surname'])) {
    // Récupère les valeurs des variables de session
    $Nom = $_SESSION['name'];
    $Prénom = $_SESSION['surname'];
} else {
    // Redirige vers identification.php si les variables de session ne sont pas définies
    header("Location: identification.php");
    exit();
}

// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connexion à la base de données
    $servername = "localhost";
    $username = "root"; // Remplacez par votre nom d'utilisateur
    $password = ""; // Remplacez par votre mot de passe
    $dbname = "projet_piscine";
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifiez la connexion
    if ($conn->connect_error) {
        die("Connexion échouée: " . $conn->connect_error);
    }

    $Mot_de_passe = $_POST['password'];
    $Mot_de_passe = $conn->real_escape_string($Mot_de_passe);
    $sql = "SELECT * FROM clients WHERE Nom = '$Nom' AND Prénom = '$Prénom' AND Mot_de_passe = '$Mot_de_passe'";
    $result = $conn->query($sql);

    // Vérifie si la requête a retourné des résultats
    if ($result->num_rows > 0) {
        // Définir les variables de session
        $_SESSION['logged_in'] = true;
        $_SESSION['user_type'] = 'client';
        $_SESSION['user_id'] = $result->fetch_assoc()['id']; // Assurez-vous que la colonne 'id' existe dans votre table

        header("Location: espace_client.php");
        exit();
    } else {
        // Affiche le message d'erreur si le mot de passe est incorrect
        $error_message = "Mot de passe incorrect.";
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
                if (isset($error_message)) {
                    echo "<p class='error-message'>$error_message</p>";
                }
                ?>
            </div>
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
    </div>
</body>
</html>