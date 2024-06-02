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
        /* Vos styles CSS */
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
        <a href="espace_agent.php">Espace Agent</a>
        <a href="logout.php" class="logout-btn">Déconnexion</a>
    </div>
    
    <!-- Contenu de la page -->
    <div class="container">
        <h1>Espace Agent</h1>
        <!-- Informations de l'agent -->
        <div class="agent-info">
            <p>Nom et prénom : <?php echo $agent_name; ?></p>
            <p>Courriel : <?php echo $agent_email; ?></p>
        </div>
        <!-- Consultations courantes ou à venir -->
        <h2>Consultations</h2>
        <div class="consultations">
            <?php if (count($consultations) > 0): ?>
                <ul>
                    <?php foreach ($consultations as $consultation): ?>
                        <li>Date/Heure : <?php echo $consultation['date']; ?> - Client : <?php echo $consultation['client_name']; ?> (<?php echo $consultation['client_email']; ?>)</li>
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
