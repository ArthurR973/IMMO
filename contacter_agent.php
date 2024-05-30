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

$agent_id = $_GET['agent_id'];

// Requête pour récupérer les détails de l'agent
$sql = "SELECT * FROM AGENT_IMMO WHERE numero_identification = $agent_id";

$result = $conn->query($sql);
if ($result === FALSE) {
    die("Erreur dans la requête SQL : " . $conn->error);
}

$agent = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $agent['prenom'] . " " . $agent['nom']; ?> - Omnes Immobilier</title>
    <link rel="stylesheet" href="style_agent.css">
</head>
<body>
    <header>
        <h1>Omnes Immobilier</h1>
        <nav>
            <ul>
                <li><a href="accueil.php">Accueil</a></li>
                <li><a href="tout_parcourir.php">Tout Parcourir</a></li>
                <li><a href="recherche.php">Recherche</a></li>
                <li><a href="rendez_vous.html">Rendez-vous</a></li>
                <li><a href="identification.php">Votre Compte</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="agent-profile">
            <img src="<?php echo $agent['photo']; ?>" alt="Photo de <?php echo $agent['prenom'] . " " . $agent['nom']; ?>">
            <h2><?php echo $agent['prenom'] . " " . $agent['nom']; ?></h2>
            <p><strong>Agent Immobilier agréé</strong></p>
            <p><strong>Téléphone :</strong> <?php echo $agent['tel']; ?></p>
            <p><strong>Email :</strong> <a href="mailto:<?php echo $agent['courriel']; ?>"><?php echo $agent['courriel']; ?></a></p>
            <p><strong>Bureau :</strong> <?php echo $agent['bureau']; ?></p>
            <table>
                <tr>
                    <th>Jour</th>
                    <th>Matin</th>
                    <th>Après-midi</th>
                </tr>
                <tr>
                    <td>Lundi</td>
                    <td><?php echo $agent['lundi_matin']; ?></td>
                    <td><?php echo $agent['lundi_apres_midi']; ?></td>
                </tr>
                <tr>
                    <td>Mardi</td>
                    <td><?php echo $agent['mardi_matin']; ?></td>
                    <td><?php echo $agent['mardi_apres_midi']; ?></td>
                </tr>
                <tr>
                    <td>Mercredi</td>
                    <td><?php echo $agent['mercredi_matin']; ?></td>
                    <td><?php echo $agent['mercredi_apres_midi']; ?></td>
                </tr>
                <tr>
                    <td>Jeudi</td>
                    <td><?php echo $agent['jeudi_matin']; ?></td>
                    <td><?php echo $agent['jeudi_apres_midi']; ?></td>
                </tr>
                <tr>
                    <td>Vendredi</td>
                    <td><?php echo $agent['vendredi_matin']; ?></td>
                    <td><?php echo $agent['vendredi_apres_midi']; ?></td>
                </tr>
            </table>
            <div class="buttons">
                <a href="identification.php" class="button">Prendre un RDV</a>
                <a href="mailto:<?php echo $agent['courriel']; ?>" class="button">Communiquer avec l'agent immobilier</a>
                <a href="<?php echo $agent['cv']; ?>" class="button">Voir son CV</a>
            </div>
        </div>
    </main>

    <footer>
        <p>Contactez-nous : <a href="mailto:contact@omnesimmobilier.fr">contact@omnesimmobilier.fr</a></p>
        <p>Téléphone : +33 01 23 45 67 89</p>
    </footer>
</body>
</html>