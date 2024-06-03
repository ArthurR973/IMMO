<?php
session_start();

// Connexion à la base de données
try {
    $bdd = new PDO('mysql:host=localhost;dbname=projet_piscine;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Récupérer le nom et le prénom du client depuis les variables de session
$nom = $_SESSION['name'];
$prenom = $_SESSION['surname'];
?>


<!--// Vérifier si le client est connecté, sinon rediriger vers la page d'identification
//if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['user_type'] !== 'client') {
//    header("Location: identification.php");
//    exit;
//}

// Sélectionner les consultations de l'utilisateur connecté
//$id_client = $_SESSION['user_id']; // Supposons que 'user_id' contienne l'ID du client connecté

//$stmt = $bdd->prepare("SELECT * FROM Consultation WHERE id_client = :id_client");
//$stmt->execute(array(':id_client' => $id_client));
//$consultations = $stmt->fetchAll(PDO::FETCH_ASSOC);
//?>
-->
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
        <a href="identification.php">Votre Compte</a>
        <!--<a href="deconnexion.php" class="logout-btn">Déconnexion</a>-->
    </div>
    <div class="container">
        <h1>Bienvenue, <?php echo $prenom . ' ' . $nom; ?></h1>
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
