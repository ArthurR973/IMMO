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

function getScheduleData($conn) {
    try {
        $stmt = $conn->prepare("SELECT date, heure FROM Consultation WHERE id_agent = :id_agent");
        $stmt->execute(['id_agent' => 14]); // Remplacez 14 par l'ID de l'agent concerné
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
    
    $scheduleData = [
        ['busy', 'free', 'free', 'busy', 'busy', 'busy'],
        ['free', 'busy', 'free', 'busy', 'free', 'busy']
    ];
    
    foreach ($results as $row) {
        // Convertir la date et l'heure en indices de ligne et de colonne
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
    <title>Prendre un RDV - Omnes Immobilier</title>
    <link rel="stylesheet" href="style_agent.css">
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
        .available {
            background-color: white;
        }
        .unavailable {
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
        document.querySelectorAll('.availability-table td').forEach(td => {
            td.addEventListener('click', () => {
                td.classList.toggle('available');
                td.classList.toggle('unavailable');
                let input = td.querySelector('input[type="hidden"]');
                input.value = td.classList.contains('available') ? 'dispo' : 'indispo';
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

