<?php
session_start();
/*
// Vérifier si l'agent est connecté, sinon rediriger vers la page d'identification
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['user_type'] !== 'agent') {
    header("Location: identification.php"); // Rediriger vers la page d'identification
    exit;
}
*/
// Simulation des données de l'agent (à remplacer par les données de votre base de données)
$agent_name = "John Doe";
$agent_email = "john.doe@example.com";

// Simulation des consultations (à remplacer par les données de votre base de données)
$consultations = array(
    array("date" => "2024-06-01 10:00:00", "client_name" => "Alice", "client_email" => "alice@example.com"),
    array("date" => "2024-06-02 11:30:00", "client_name" => "Bob", "client_email" => "bob@example.com"),
    array("date" => "2024-06-03 09:15:00", "client_name" => "Charlie", "client_email" => "charlie@example.com")
);
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
    <!-- En-tête -->
    <div class="header">
        <h1>OMNES IMMOBILIER</h1>
        <p>444 N. Rue Principale, Charlotte | +33 01 23 45 67 89</p>
    </div>

    <!-- Navigation -->
    <div class="navigation">
        <a href="accueil.php">Accueil</a>
        <a href="tout_parcourir.php">Tout Parcourir</a>
        <a href="recherche.php">Recherche</a>
        <a href="rendezvous.php">Rendez-vous</a>
        <a href="espace_agent.php">Votre Compte</a>
    </div>
    
    <!-- Contenu de la page -->
    <div class="container">
        <h1>Espace Agent</h1>
        <!-- Informations de l'agent -->
        <div class="agent-info">
            <p>Nom et prénom : <?php echo htmlspecialchars($agent_name); ?></p>
            <p>Courriel : <?php echo htmlspecialchars($agent_email); ?></p>
        </div>
        <!-- Consultations courantes ou à venir -->
        <h2>Consultations</h2>
        <div class="consultations">
            <?php if (count($consultations) > 0): ?>
                <ul>
                    <?php foreach ($consultations as $consultation): ?>
                        <li>Date/Heure : <?php echo htmlspecialchars($consultation['date']); ?> - Client : <?php echo htmlspecialchars($consultation['client_name']); ?> (<?php echo htmlspecialchars($consultation['client_email']); ?>)</li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Aucune consultation prévue.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Pied de page -->
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
