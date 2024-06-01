<?php
session_start();

// Connexion à la base de données
try {
    $bdd = new PDO('mysql:host=localhost;dbname=projet_piscine;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Vérifier si le client est connecté, sinon rediriger vers la page d'identification
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['user_type'] !== 'client') {
    header("Location: identification.php");
    exit;
}

// Sélectionner les consultations de l'utilisateur connecté
$id_client = $_SESSION['user_id']; // Supposons que 'user_id' contienne l'ID du client connecté

$stmt = $bdd->prepare("SELECT * FROM Consultation WHERE id_client = :id_client");
$stmt->execute(array(':id_client' => $id_client));
$consultations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Client - Omnes Immobilier</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Lora', serif;
            color: #333;
        }
        .header, .footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px;
        }
        .header h1, .footer p {
            font-family: 'Montserrat', sans-serif;
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
        .navigation a:hover {
            background-color: #ddd;
            color: black;
        }
        .container {
            padding: 50px 20px;
        }
        .results img {
            max-width: 200px;
            height: auto;
        }
        .results h3 {
            margin: 10px 0;
        }
        .logout-btn {
            float: right;
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
        <a href="espace_client.php">Votre compte</a>
        <a href="deconnexion.php" class="logout-btn">Déconnexion</a>
    </div>
    
    <div class="container">
        <h1>Espace Client</h1>
        <h2>Historique des Consultations Immobilières</h2>
        <div class="consultation-history">
            <?php if (!empty($consultations)): ?>
                <ul>
                    <?php foreach ($consultations as $consultation): ?>
                        <li>Date: <?php echo $consultation['date']; ?>, Heure: <?php echo $consultation['heure']; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Aucune consultation pour le moment.</p>
            <?php endif; ?>
        </div>
        <h2>Rendez-vous à venir</h2>
        <div class="upcoming-appointments">
            <!-- Afficher ici les rendez-vous à venir du client -->
            <p>Aucun rendez-vous à venir pour le moment.</p>
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
