<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projet_piscine"; 

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $rowIndex = $_POST['rowIndex'];
    $colIndex = $_POST['colIndex'];
    $id_agent = $_POST['id_agent'];

    $hours = ['09:00:00', '13:30:00'];
    $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
    $date = date('Y-m-d', strtotime("next " . $days[$colIndex]));

    if ($action === 'save') {
        try {
            // Insérer les données dans la table Consultation
            $stmt = $conn->prepare("INSERT INTO Consultation (id_client, date, heure, id_agent) VALUES (:id_client, :date, :heure, :id_agent)");
            $stmt->execute([
                'id_client' => 1, // Remplacez par l'ID du client connecté
                'date' => $date,
                'heure' => $hours[$rowIndex],
                'id_agent' => $id_agent
            ]);

            // Insérer les données dans la table RDV
            $stmt = $conn->prepare("INSERT INTO RDV (id_agent, id_client, date, heure) VALUES (:id_agent, :id_client, :date, :heure)");
            $stmt->execute([
                'id_agent' => $id_agent,
                'id_client' => 1, // Remplacez par l'ID du client connecté
                'date' => $date,
                'heure' => $hours[$rowIndex]
            ]);

            echo "Rendez-vous enregistré avec succès.";
        } catch (PDOException $e) {
            die("Erreur lors de l'enregistrement du rendez-vous: " . $e->getMessage());
        }
    } elseif ($action === 'cancel') {
        try {
            // Supprimer les données de la table Consultation
            $stmt = $conn->prepare("DELETE FROM Consultation WHERE date = :date AND heure = :heure AND id_agent = :id_agent");
            $stmt->execute([
                'date' => $date,
                'heure' => $hours[$rowIndex],
                'id_agent' => $id_agent
            ]);

            // Supprimer les données de la table RDV
            $stmt = $conn->prepare("DELETE FROM RDV WHERE date = :date AND heure = :heure AND id_agent = :id_agent");
            $stmt->execute([
                'date' => $date,
                'heure' => $hours[$rowIndex],
                'id_agent' => $id_agent
            ]);

            echo "Rendez-vous annulé avec succès.";
        } catch (PDOException $e) {
            die("Erreur lors de l'annulation du rendez-vous: " . $e->getMessage());
        }
    }
}
?>
