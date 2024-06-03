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
    <style>
        body {
            font-family: 'Lora', serif;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .header, .footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px;
            width: 100%;
        }
        .header h1, .footer p {
            font-family: 'Montserrat', sans-serif;
        }
        .navigation {
            background-color: #f8f9fa;
            padding: 10px;
            text-align: center;
            width: 100%;
        }
        .navigation a {
            margin: 0 15px;
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
        .navigation a:hover {
            background-color: #ddd;
            color: black;
        }
        .container {
            padding: 50px 20px;
            width: 100%;
            max-width: 1200px;
            text-align: center;
        }
        .agent-profile img {
            max-width: 200px;
            height: auto;
            border-radius: 50%;
        }
        .agent-profile h2 {
            margin: 10px 0;
        }
        .agent-profile table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 80%;
        }
        .agent-profile th, .agent-profile td {
            border: 1px solid #ccc;
            padding: 10px;
        }
        .buttons {
            margin-top: 20px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Omnes Immobilier</h1>
    </div>

    <div class="navigation">
        <a href="accueil.php">Accueil</a>
        <a href="tout_parcourir.php">Tout Parcourir</a>
        <a href="recherche.php">Recherche</a>
        <a href="rendez_vous.html">Rendez-vous</a>
        <a href="identification.php">Votre Compte</a>
    </div>

    <div class="container">
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
                <a href="prendre_RDV.php" class="button">Prendre un RDV</a>
                <a href="communiquer_agent.php?agent_id=<?php echo $agent['numero_identification']; ?>" class="button">Communiquer avec l'agent immobilier</a>
                <a href="<?php echo $agent['cv']; ?>" class="button">Voir son CV</a>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>© 2024 Omnes Immobilier - Tous droits réservés</p>
        <p>Mail : <a href="mailto:omnes.immobilier@gmail.com">email@omnesimmobilier.fr</a></p>
        <p>Téléphone : <a href="tel:+33102030405">+33 01 23 45 67 89</a></p> 
        <p>Adresse : <a href="https://www.google.fr/maps/place/4+Rue+Principale,+67300+Schiltigheim">444 N. Rue Principale, Charlotte</a></p>
    </div>
</div>
</body>
</html> 
