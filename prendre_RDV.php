<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nom_de_votre_base_de_donnees";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

function getScheduleData($conn) {
    $stmt = $conn->prepare("SELECT date, heure FROM Consultation WHERE id_agent = :id_agent");
    $stmt->execute(['id_agent' => 14]); // Remplacez 14 par l'ID de l'agent concerné
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $scheduleData = [
        ['busy', 'free', 'free', 'busy', 'busy', 'busy'],
        ['free', 'busy', 'free', 'busy', 'free', 'busy']
    ];
    
    foreach ($results as $row) {
        // Convertir la date et l'heure en indices de ligne et de colonne
        // Par exemple, si 9H - 12H est en rowIndex 0 et 13H30 - 15H30 est en rowIndex 1
        $rowIndex = $row['heure'] == '09:00:00' ? 0 : 1;
        $colIndex = date('N', strtotime($row['date'])) - 1;
        $scheduleData[$rowIndex][$colIndex] = 'busy';
    }
    
    return $scheduleData;
}

$scheduleData = getScheduleData($conn);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prendre un RDV - Thierry MARX</title>
    <link rel="stylesheet" href="prendre_RDV.css">
    <script src="prendre_RDV.js" defer></script>
</head>
<body>
    <div class="agent-card">
        <h2>Emploi du temps de Thierry MARX</h2>
        <table class="schedule large">
            <thead>
                <tr>
                    <th>Horaires</th>
                    <th>Lundi</th>
                    <th>Mardi</th>
                    <th>Mercredi</th>
                    <th>Jeudi</th>
                    <th>Vendredi</th>
                    <th>Samedi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $hours = ['9H - 12H', '13H30 - 15H30'];
                foreach ($scheduleData as $rowIndex => $row) {
                    echo "<tr>";
                    echo "<td>{$hours[$rowIndex]}</td>";
                    foreach ($row as $colIndex => $cell) {
                        $class = $cell;
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
                body: `action=save&rowIndex=${rowIndex}&colIndex=${colIndex}&id_agent=14`
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
                body: `action=cancel&rowIndex=${rowIndex}&colIndex=${colIndex}&id_agent=14`
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
