<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projet_piscine"; // Remplacez par le nom correct de votre base de données

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Fonction pour récupérer les disponibilités de l'agent en fonction de son identifiant
function getScheduleData($conn, $agent_id) {
    try {
        $stmt = $conn->prepare("SELECT lundi_matin, lundi_apres_midi, mardi_matin, mardi_apres_midi, mercredi_matin, mercredi_apres_midi, jeudi_matin, jeudi_apres_midi, vendredi_matin, vendredi_apres_midi FROM AGENT_IMMO WHERE numero_identification = :agent_id");
        $stmt->bindParam(':agent_id', $agent_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Créer un tableau pour stocker les disponibilités
        $scheduleData = array();

        // Ajouter les disponibilités de chaque jour de la semaine dans le tableau
        $scheduleData[] = array($row['lundi_matin'], $row['lundi_apres_midi']);
        $scheduleData[] = array($row['mardi_matin'], $row['mardi_apres_midi']);
        $scheduleData[] = array($row['mercredi_matin'], $row['mercredi_apres_midi']);
        $scheduleData[] = array($row['jeudi_matin'], $row['jeudi_apres_midi']);
        $scheduleData[] = array($row['vendredi_matin'], $row['vendredi_apres_midi']);

        return $scheduleData;
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}

// Identifiant de l'agent récupéré depuis l'URL
$agent_id = $_GET['agent_id'];

// Récupérer les disponibilités de l'agent
$scheduleData = getScheduleData($conn, $agent_id);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prendre un RDV</title>
    <link rel="stylesheet" href="prendre_RDV.css">
    <script src="prendre_RDV.js" defer></script>
</head>
<body>
    <div class="agent-card">
        <h2>Emploi du temps</h2>
        <table class="schedule large">
            <thead>
                <tr>
                    <th>Horaires</th>
                    <th>Lundi</th>
                    <th>Mardi</th>
                    <th>Mercredi</th>
                    <th>Jeudi</th>
                    <th>Vendredi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $hours = ['9H - 12H', '13H30 - 15H30'];
                $hourValues = array_values($hours);
                foreach ($scheduleData as $rowIndex => $row) {
                    echo "<tr>";
                    echo "<td>" . ($rowIndex === 0 ? '9H - 12H' : '13H30 - 15H30') . "</td>";
                    foreach ($row as $colIndex => $cell) {
                        $class = $cell === 'indispo' ? 'busy' : 'free';
                        echo "<td class='{$class}' data-row='{$rowIndex}' data-col='{$colIndex}'></td>";
                    }
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="buttons">
            <button class="btn" onclick="saveAppointment()">Enregistrer le RDV</button>
            <button class="btn" onclick="cancelAppointment()">Annuler le RDV</button>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const scheduleCells = document.querySelectorAll('.schedule td.free');
            scheduleCells.forEach(cell => {
                cell.addEventListener('click', () => {
                    if (document.querySelector('.selected')) {
                        document.querySelector('.selected').classList.remove('selected');
                    }
                    cell.classList.add('selected');
                });
            });
        });
        
        function saveAppointment() {
            const selected = document.querySelector('.selected');
            if (!selected) {
                alert('Veuillez sélectionner un créneau horaire.');
                return;
            }
            
            const rowIndex = selected.dataset.row;
            const colIndex = selected.dataset.col;
            
            fetch('manage_appointment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `action=save&rowIndex=${rowIndex}&colIndex=${colIndex}&id_agent=<?php echo $agent_id; ?>`
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                selected.classList.remove('selected');
                selected.classList.add('busy');
            })
            .catch(error => {
                alert('Erreur lors de la sauvegarde du rendez-vous.');
                console.error(error);
            });
        }
        
        function cancelAppointment() {
            const selected = document.querySelector('.selected');
            if (!selected) {
                alert('Veuillez sélectionner un créneau horaire à annuler.');
                return;
            }
            
            const rowIndex = selected.dataset.row;
            const colIndex = selected.dataset.col;
            
            fetch('manage_appointment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `action=cancel&rowIndex=${rowIndex}&colIndex=${colIndex}&id_agent=<?php echo $agent_id; ?>`
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                selected.classList.remove('selected');
                selected.classList.remove('busy');
                selected.classList.add('free');
            })
            .catch(error => {
                alert('Erreur lors de l\'annulation du rendez-vous.');
                console.error(error);
            });
        }
    </script>
</body>
</html>

