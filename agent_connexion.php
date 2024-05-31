<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Agent Immobilier - Omnes Immobilier</title>
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
        <h2 class="form-title">Connexion Agent Immobilier</h2>
        <form method="post" action="agent_connexion.php">
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
   <?php
session_start();

// Vérifie si les variables de session sont définies
if (isset($_SESSION['name']) && isset($_SESSION['surname'])) {
    // Récupère les valeurs des variables de session
    $nom = $_SESSION['name'];
    $prenom = $_SESSION['surname'];
} else {
    // Redirige vers identification.php si les variables de session ne sont pas définies
    //header("Location: identification.php");
    exit();
}

// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Inclure la connexion à la base de données
    $servername = "localhost";
    $username = "root"; // Remplacez par votre nom d'utilisateur
    $password = ""; // Remplacez par votre mot de passe
    $dbname = "projet_piscine";
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier si l'utilisateur est redirigé depuis identification.php
    if (isset($_SESSION['name']) && isset($_SESSION['surname'])) {
        $nom = $_SESSION['name'];
        $prenom = $_SESSION['surname'];
    } else {
        echo "<p class='error-message'>Erreur : Veuillez vous identifier d'abord.</p>";
        exit();
    }

    $mot_de_passe = $_POST['password'];
    $mot_de_passe = $conn->real_escape_string($mot_de_passe);
    $sql = "SELECT * FROM agent_immo WHERE nom = '$nom' AND prenom = '$prenom' AND mot_de_passe = '$mot_de_passe'";
    $result = $conn->query($sql);

    // Vérifie si la requête a retourné des résultats
    if ($result->num_rows > 0) {
        header("Location: espace_agent.php");
        exit();
    } else {
        // Affiche le message d'erreur si le mot de passe est incorrect
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
