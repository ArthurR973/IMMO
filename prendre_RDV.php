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

// Vérifier si 'agent_id' est défini dans $_GET
if (!isset($_GET['agent_id']) || empty($_GET['agent_id'])) {
    die("Erreur : l'ID de l'agent n'est pas spécifié.");
}

$agent_id = $_GET['agent_id'];

// Requête pour récupérer les disponibilités de l'agent
$sql = "SELECT date, heure FROM RDV WHERE id_agent = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $agent_id);
$stmt->execute();
$result = $stmt->get_result();

$scheduleData = [
    ['free', 'free', 'free', 'free', 'free', 'free'],
    ['free', 'free', 'free', 'free', 'free', 'free']
];

while ($row = $result->fetch_assoc()) {
    $rowIndex = $row['heure'] == '09:00:00' ? 0 : 1;
    $colIndex = date('N', strtotime($row['date'])) - 1;
    $scheduleData[$rowIndex][$colIndex] = 'busy';
}

$stmt->close();
$conn->close();
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
    <div class="header">
        <h1>Omnes Immobilier</h1>
    </div>

    <div class="container">
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
                        $class = $cell == 'busy' ? 'unavailable' : 'available';
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

    <div class="footer">
        <p>Contactez-nous : <a href="mailto:contact@omnesimmobilier.fr">contact@omnesimmobilier.fr</a></p>
        <p>Téléphone : +33 01 23 45 67 89</p>
    </div>

    <script>
        document.querySelectorAll('.availability-table td').forEach(td => {
            td.addEventListener('click', () => {
                td.classList.toggle('available');
                td.classList.toggle('unavailable');
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

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "manage_appointment.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                    selected.classList.remove('selected');
                    selected.classList.add('busy');
                }
            };
            xhr.send(`action=save&rowIndex=${rowIndex}&colIndex=${colIndex}&agent_id=<?php echo $agent_id; ?>`);
        }

        function cancelAppointment() {
            const selected = document.querySelector('.selected');
            if (!selected) {
                alert('Veuillez sélectionner un créneau horaire à annuler.');
                return;
            }
            
            const rowIndex = selected.dataset.row;
            const colIndex = selected.dataset.col;

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "manage_appointment.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                    selected.classList.remove('selected');
                    selected.classList.remove('busy');
                    selected.classList.add('free');
                }
            };
            xhr.send(`action=cancel&rowIndex=${rowIndex}&colIndex=${colIndex}&agent_id=<?php echo $agent_id; ?>`);
        }
    </script>
</body>
</html>
