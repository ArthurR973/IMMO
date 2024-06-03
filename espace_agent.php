<?php
session_start();
/*
// Vérifier si l'agent est connecté, sinon rediriger vers la page d'identification
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['user_type'] !== 'agent') {
    header("Location: identification.php");
    exit;
}
*/

// Connexion à la base de données
try {
    $bdd = new PDO('mysql:host=localhost;dbname=projet_piscine;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Récupérer le nom et le prénom de l'agent depuis les variables de session
$nom = $_SESSION['name'];
$prenom = $_SESSION['surname'];

// Requête pour récupérer les informations de l'agent
$query = $bdd->prepare("SELECT nom, prenom, courriel, tel FROM agent_immo WHERE nom = :nom AND prenom = :prenom");
$query->execute(['nom' => $nom, 'prenom' => $prenom]);
$agent = $query->fetch(PDO::FETCH_ASSOC);
?>

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Agent - Omnes Immobilier</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Lora', serif;
            color: #333;
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
            padding: 20px;
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
        <a href="rendezvous.php">Rendez-vous</a>
        <a href="espace_agent.php">Votre Compte</a>
        <a href="deconnexion.php" class="logout-btn">Déconnexion</a>
    </div>
   
    <div class="container">
    <?php if ($agent): ?>
        <h1>Bienvenue, <?php echo htmlspecialchars($agent['prenom'] . ' ' . $agent['nom']); ?></h1>
        <div class="agent-info">
            <p>Nom et prénom : <?php echo htmlspecialchars($agent['nom'] . ' ' . $agent['prenom']); ?></p>
            <p>Courriel : <?php echo htmlspecialchars($agent['courriel']); ?></p>
            <p>Téléphone : <?php echo htmlspecialchars($agent['tel']); ?></p>
        </div>
    <?php else: ?>
        <p>Aucune information sur l'agent n'a été trouvée.</p>
    <?php endif; ?>
</div>
        <h2>Historique des Consultations</h2>
        <div class="consultation-history">
            <?php if (!empty($consultations)): ?>
                <ul>
                    <?php foreach ($consultations as $consultation): ?>
                        <li>Date: <?php echo htmlspecialchars($consultation['date']); ?>, Client: <?php echo htmlspecialchars($consultation['client_name']); ?> (<?php echo htmlspecialchars($consultation['client_email']); ?>)</li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Aucune consultation pour le moment.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="footer">
        <p>© 2024 Omnes Immobilier - Tous droits réservés</p>
        <p>Mail : <a href="mailto:omnes.immobilier@gmail.com">email@omnesimmobilier.fr</a></p>
        <p>Téléphone : <a href="tel:+33102030405">+33 01 23 45 67 89</a></p> 
        <p>Adresse : <a href="https://www.google.fr/maps/place/4+Rue+Principale,+67300+Schiltigheim">444 N. Rue Principale, Charlotte</a></p>
    </div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>