<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projet_piscine";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$action = $_POST['action'];
$rowIndex = $_POST['rowIndex'];
$colIndex = $_POST['colIndex'];
$id_agent = $_POST['id_agent'];

// Convertir rowIndex et colIndex en date et heure
$days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];
$date = date('Y-m-d', strtotime("next " . $days[$colIndex]));
$time = $rowIndex == 0 ? '09:00:00' : '13:30:00';

if ($action == 'save') {
    $stmt = $conn->prepare("INSERT INTO RDV (id_agent, id_client, date, heure) VALUES (?, ?, ?, ?)");
    $id_client = 1; // Vous pouvez récupérer l'ID du client connecté ici
    $stmt->bind_param("iiss", $id_agent, $id_client, $date, $time);
    if ($stmt->execute()) {
        echo "Rendez-vous enregistré.";
    } else {
        echo "Erreur lors de l'enregistrement du rendez-vous.";
    }
} elseif ($action == 'cancel') {
    $stmt = $conn->prepare("DELETE FROM RDV WHERE id_agent = ? AND date = ? AND heure = ?");
    $stmt->bind_param("iss", $id_agent, $date, $time);
    if ($stmt->execute()) {
        echo "Rendez-vous annulé.";
    } else {
        echo "Erreur lors de l'annulation du rendez-vous.";
    }
}

$conn->close();
?>
