<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Omnes Immobilier</title>
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
        .header {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            font-family: 'Montserrat', sans-serif;
            color: white;
            font-size: 2.5rem;
            margin: 0;
        }
        .navigation {
            background-color: #f8f9fa;
            padding: 10px;
            text-align: center;
        }
        .navigation a {
            margin: 0 15px;
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
        .welcome {
            background-color: #f8f9fa;
            color: #333;
            padding: 50px;
            text-align: center;
        }
        .welcome h2 {
            font-family: 'Montserrat', sans-serif;
            font-size: 2rem;
            margin-bottom: 20px;
        }
        .welcome p {
            font-size: 1rem;
        }
        .event-section {
            padding: 50px 20px;
            text-align: center;
        }
        .carousel-item img {
            width: 100%;
            height: auto;
        }
        .footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px;
        }
        .error {
            color: red;
        }
        p.terms {
            font-size: 12px;
            margin-top: 10px;
        }
        .error {
            color: red;
    </style>
</head>
<body>
    <div class="container">
        <img src="logotest.png" alt="Logo Omnes Immobilier" class="logo">

        <p>Saisis ton nom et ton prénom pour nous rejoindre ou te connecter.</p>
        <form id="name-form" method="post">
            <div class="form-group">
                <input type="text" class="form-control" id="surname" name="surname" placeholder="Prénom" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="name" name="name" placeholder="Nom" required>
            </div>
        <?php
            // Inclure la connexion à la base de données
            $servername = "localhost";
            $username = "root"; // Remplacez par votre nom d'utilisateur
            $password = ""; // Remplacez par votre mot de passe
            $dbname = "projet_piscine";
            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $Nom = $_POST['name'];
                $Prénom = $_POST['surname'];
                $Nom = $conn->real_escape_string($Nom);
                $Prénom = $conn->real_escape_string($Prénom);
                $sql = "SELECT * FROM clients WHERE Nom = '$Nom' AND Prénom = '$Prénom'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    header("Location: client_connexion.html");
                    exit();
                } else {
                    $sql_admin = "SELECT * FROM administrateur WHERE nom = '$Nom' AND prenom = '$Prénom'";
                    $result_admin = $conn->query($sql_admin);
                    if ($result_admin->num_rows > 0) {
                        header("Location: admin_connexion.html");
                        exit();
                    } else {
                        $sql_agent = "SELECT * FROM agent_immo WHERE nom = '$Nom' AND prenom = '$Prénom'";
                        $result_agent = $conn->query($sql_agent);
                        if ($result_agent->num_rows > 0) {
                            header("Location: agent_connexion.html");
                            exit();
                        } else {
                            echo "<p class='error' id='error-message'>Nom et prénom inconnus</p>";
                        }
                    }
                }
            }
        ?>
        <p class="terms">En continuant, tu acceptes les conditions d'utilisation et tu confirmes avoir lu la politique de confidentialité de OMNES IMMOBILIER.</p>
            <button type="submit" class="btn btn-primary">Continuer</button>
        </form> 
    </div>
    <div class="new-account"><br>
            <center><p class="terms">Nouveau chez OMNES IMMOBILIER ?</p></center>
            <center><a href="creationcompte.php" class="btn btn btn-primary">Créez votre compte OMNES</a></center>
        </div>
</body>
</html>
