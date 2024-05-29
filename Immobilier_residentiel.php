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
$sql = "SELECT BIEN.numero, BIEN.photo, BIEN.description, BIEN.adresse, AGENT_IMMO.prenom, AGENT_IMMO.nom, AGENT_IMMO.courriel, AGENT_IMMO.tel
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
    <link rel="stylesheet" href="style_toutparcourir.css">
</head>
<body>
    <header>
        <h1>Omnes Immobilier</h1>
        <nav>
            <ul>
                <li><a href="accueil.php">Accueil</a></li>
                <li><a href="tout_parcourir.php">Tout Parcourir</a></li>
                <li><a href="recherche.html">Recherche</a></li>
                <li><a href="rendez_vous.html">Rendez-vous</a></li>
                <li><a href="votre_compte.html">Votre Compte</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Immobilier Résidentiel</h2>
        <div class="property-list">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='property-card'>";
                    echo "<img src='" . $row["photo"] . "' alt='Photo du bien'>";
                    echo "<h3>" . $row["description"] . "</h3>";
                    echo "<p>Adresse : " . $row["adresse"] . "</p>";
                    echo "<p>Agent : " . $row["prenom"] . " " . $row["nom"] . "</p>";
                    echo "<p>Email : <a href='mailto:" . $row["courriel"] . "'>" . $row["courriel"] . "</a></p>";
                    echo "<p>Téléphone : " . $row["tel"] . "</p>";
                    echo "<a href='agent.html'>Contactez l'agent</a>";
                    echo "</div>";
                }
            } else {
                echo "<p>Aucun bien immobilier résidentiel trouvé.</p>";
            }
            $conn->close();
            ?>
        </div>
    </main>

    <footer>
        <p>Contactez-nous : <a href="mailto:contact@omnesimmobilier.fr">contact@omnesimmobilier.fr</a></p>
        <p>Téléphone : +33 01 23 45 67 89</p>
        <div id="map"></div>
    </footer>

    <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 44.8378, lng: -0.5792},
                zoom: 12
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script>
</body>
</html>
