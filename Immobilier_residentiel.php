<?php
$servername = "localhost";
$username = "root";  // Remplacez par votre nom d'utilisateur
$password = "";      // Remplacez par votre mot de passe
$dbname = "projet_piscine"; // Remplacez par le nom de votre base de données

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Requête pour récupérer les biens résidentiels et leurs agents
$sql = "SELECT BIEN.numero, BIEN.photo, BIEN.description, BIEN.adresse, AGENT_IMMO.numero_identification, AGENT_IMMO.prenom, AGENT_IMMO.nom, AGENT_IMMO.courriel, AGENT_IMMO.tel
        FROM BIEN
        JOIN AGENT_IMMO ON BIEN.id_agent = AGENT_IMMO.numero_identification
        WHERE BIEN.type = 'Immobilier résidentiel'";

$result = $conn->query($sql);
if ($result === FALSE) {
    die("Erreur dans la requête SQL : " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Immobilier Résidentiel - Omnes Immobilier</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Lora', serif;
            color: #333;
            background-color: #fff;
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
        .container {
            padding: 50px 20px;
        }
        .property-list {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .property-card {
            position: relative;
            width: 50%;
            margin: 20px 0;
            overflow: hidden;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .property-card img {
            width: 100%;
            height: auto;
            display: block;
        }
        .property-info {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            opacity: 0;
            transition: opacity 0.5s;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .property-card:hover .property-info {
            opacity: 1;
        }
        .property-info h3 {
            margin-bottom: 10px;
        }
        .property-info p {
            margin-bottom: 5px;
        }
        .property-info a {
            color: white;
            text-decoration: underline;
        }
        .footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="wrapper">
    <div class="header">
        <h1>OMNES IMMOBILIER</h1>
        <p>444 N. Rue Principale, Charlotte | +33 01 23 45 67 89</p>
    </div>

    <div class="navigation">
        <a href="accueil.php">Accueil</a>
        <a href="tout_parcourir.php">Tout Parcourir</a>
        <a href="recherche.php">Recherche</a>
        <a href="rendez_vous.php">Rendez-vous</a>
        <a href="identification.php">Votre Compte</a>
    </div>
    
    <div class="container">
        <h2 class="text-center">Immobilier Résidentiel</h2>
        <div class="property-list">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='property-card'>";
                    echo "<img src='" . $row["photo"] . "' alt='Photo du bien'>";
                    echo "<div class='property-info'>";
                    echo "<h3>" . $row["description"] . "</h3>";
                    echo "<p>Adresse : " . $row["adresse"] . "</p>";
                    echo "<p>Agent : " . $row["prenom"] . " " . $row["nom"] . "</p>";
                    echo "<p>Email : <a href='mailto:" . $row["courriel"] . "'>" . $row["courriel"] . "</a></p>";
                    echo "<p>Téléphone : " . $row["tel"] . "</p>";
                    echo "<a href='contacter_agent.php?agent_id=" . $row["numero_identification"] . "' class='btn btn-light'>Contactez l'agent</a>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>Aucun bien immobilier résidentiel trouvé.</p>";
            }
            $conn->close();
            ?>
        </div>
    </div>

    <div class="footer">
        <p>© 2024 Omnes Immobilier - Tous droits réservés</p>
        <p>Contactez-nous : email@omnesimmobilier.fr | +33 01 23 45 67 89</p>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>