<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "immobilier";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer les données POST
$action = $_POST['action'];
$rowIndex = $_POST['rowIndex'];
$colIndex = $_POST['colIndex'];

if ($action === 'save') {
    // Mettre à jour l'emploi du temps dans la base de données pour enregistrer le rendez-vous
    $sql = "UPDATE schedule SET status='busy' WHERE agent_id=1 AND row_index=$rowIndex AND col_index=$colIndex";
    if ($conn->query($sql) === TRUE) {
        echo "Rendez-vous enregistré avec succès";
    } else {
        echo "Erreur: " . $conn->error;
    }
} elseif ($action === 'cancel') {
    // Mettre à jour l'emploi du temps dans la base de données pour annuler le rendez-vous
    $sql = "UPDATE schedule SET status='free' WHERE agent_id=1 AND row_index=$rowIndex AND col_index=$colIndex";
    if ($conn->query($sql) === TRUE) {
        echo "Rendez-vous annulé avec succès";
    } else {
        echo "Erreur: " . $conn->error;
    }
}

$conn->close();
?>
