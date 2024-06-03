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

// Lire l'ID de l'agent depuis l'URL
$id_agent = isset($_GET['id_agent']) ? intval($_GET['id_agent']) : 0;
if ($id_agent == 0) {
    die("ID de l'agent invalide.");
}

function getAgentAvailability($conn, $id_agent) {
    $stmt = $conn->prepare("SELECT lundi_matin, lundi_apres_midi, mardi_matin, mardi_apres_midi, mercredi_matin, mercredi_apres_midi, jeudi_matin, jeudi_apres_midi, vendredi_matin, vendredi_apres_midi FROM AGENT_IMMO WHERE numero_identification = ?");
    $stmt->bind_param("i", $id_agent);
    $stmt->execute();
    $result = $stmt->get_result();
    $availability = $result->fetch_assoc();
    
    $scheduleData = [
        [$availability['lundi_matin'], $availability['mardi_matin'], $availability['mercredi_matin'], $availability['jeudi_matin'], $availability['vendredi_matin']],
        [$availability['lundi_apres_midi'], $availability['mardi_apres_midi'], $availability['mercredi_apres_midi'], $availability['jeudi_apres_midi'], $availability['vendredi_apres_midi']]
    ];
    
    return $scheduleData;
}

function getScheduleData($conn, $id_agent) {
    $stmt = $conn->prepare("SELECT date, heure FROM RDV WHERE id_agent = ?");
    $stmt->bind_param("i", $id_agent);
    $stmt->execute();
    $result = $stmt->get_result();
    $results = $result->fetch_all(MYSQLI_ASSOC);
    
    $scheduleData = getAgentAvailability($conn, $id_agent);
    
    foreach ($results as $row) {
        $rowIndex = $row['heure'] == '09:00:00' ? 0 : 1;
        $colIndex = date('N', strtotime($row['date'])) - 1;
        if ($colIndex < 5) {
            $scheduleData[$rowIndex][$colIndex] = 'busy';
        }
    }
    
    return $scheduleData;
}

$scheduleData = getScheduleData($conn, $id_agent);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prendre un RDV - Omnes Immobilier</title>
    <link rel="stylesheet" href="prendre_RDV.css">
    <style>
        body {
            font-family: 'Lora', serif;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .header, .footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px;
            width: 100%;
        }
        .header h1, .footer p {
            font-family: 'Montserrat', sans-serif;
        }
        .container {
            padding: 50px 20px;
            width: 100%;
            max-width: 1200px;
            text-align: center;
        }
        .availability-table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 80%;
        }
        .availability-table th, .availability-table td {
            border: 1px solid #ccc;
            padding: 10px;
            cursor: pointer;
        }
        .free {
            background-color: white;
        }
        .busy {
            background-color: black;
        }
        .save-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: none;
        }
        .save-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="agent-card">
        <h2>Emploi du temps</h2>
        <table class="availability-table">
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
                foreach ($scheduleData as $rowIndex => $row) {
                    echo "<tr>";
                    echo "<td>{$hours[$rowIndex]}</td>";
                    foreach ($row as $colIndex => $cell) {
                        $class = $cell === 'dispo' ? 'free' : 'busy';
                        echo "<td class='{$class}' data-row='{$rowIndex}' data-col='{$colIndex}'></td>";
                    }
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="buttons">
            <button class="save-button" onclick="saveAppointment()">Enregistrer le RDV</button>
            <button class="save-button" onclick="cancelAppointment()">Annuler le RDV</button>
        </div>
    </div>

    <script>
        document.querySelectorAll('.availability-table td').forEach(td => {
            td.addEventListener('click', () => {
                if (td.classList.contains('free')) {
                    document.querySelectorAll('.availability-table td').forEach(cell => cell.classList.remove('selected'));
                    td.classList.add('selected');
                }
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
                body: `action=save&rowIndex=${rowIndex}&colIndex=${colIndex}&id_agent=<?php echo $id_agent; ?>`
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
                body: `action=cancel&rowIndex=${rowIndex}&colIndex=${colIndex}&id_agent=<?php echo $id_agent; ?>`
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
