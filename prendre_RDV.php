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
if (!isset($_GET['agent_id'])) {
    die("Erreur : l'ID de l'agent n'est pas spécifié.");
}

$agent_id = $_GET['agent_id'];

// Débogage : Afficher l'agent_id
echo "Debug: agent_id = " . $agent_id . "<br>";

// Si la requête est POST, mettre à jour les disponibilités
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $disponibilites = [
        'lundi_matin' => $_POST['lundi_matin'],
        'lundi_apres_midi' => $_POST['lundi_apres_midi'],
        'mardi_matin' => $_POST['mardi_matin'],
        'mardi_apres_midi' => $_POST['mardi_apres_midi'],
        'mercredi_matin' => $_POST['mercredi_matin'],
        'mercredi_apres_midi' => $_POST['mercredi_apres_midi'],
        'jeudi_matin' => $_POST['jeudi_matin'],
        'jeudi_apres_midi' => $_POST['jeudi_apres_midi'],
        'vendredi_matin' => $_POST['vendredi_matin'],
        'vendredi_apres_midi' => $_POST['vendredi_apres_midi'],
    ];

    // Utiliser des déclarations préparées pour la mise à jour
    $stmt = $conn->prepare("UPDATE AGENT_IMMO SET 
        lundi_matin=?, lundi_apres_midi=?, mardi_matin=?, mardi_apres_midi=?, 
        mercredi_matin=?, mercredi_apres_midi=?, jeudi_matin=?, jeudi_apres_midi=?, 
        vendredi_matin=?, vendredi_apres_midi=? 
        WHERE numero_identification=?");
    $stmt->bind_param(
        'ssssssssssi', 
        $disponibilites['lundi_matin'], $disponibilites['lundi_apres_midi'], 
        $disponibilites['mardi_matin'], $disponibilites['mardi_apres_midi'], 
        $disponibilites['mercredi_matin'], $disponibilites['mercredi_apres_midi'], 
        $disponibilites['jeudi_matin'], $disponibilites['jeudi_apres_midi'], 
        $disponibilites['vendredi_matin'], $disponibilites['vendredi_apres_midi'], 
        $agent_id
    );

    if ($stmt->execute()) {
        echo "Disponibilités mises à jour avec succès";
    } else {
        echo "Erreur de mise à jour: " . $stmt->error;
    }

    $stmt->close();
}

// Utiliser des déclarations préparées pour la sélection
$stmt = $conn->prepare("SELECT * FROM AGENT_IMMO WHERE numero_identification = ?");
$stmt->bind_param('i', $agent_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result === FALSE) {
    die("Erreur dans la requête SQL : " . $conn->error);
}

$agent = $result->fetch_assoc();
$stmt->close();
$conn->close();
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
    <div class="header">
        <h1>Omnes Immobilier</h1>
    </div>

    <div class="container">
        <h2>Disponibilités de <?php echo $agent['prenom'] . " " . $agent['nom']; ?></h2>
        <form method="POST">
            <table class="availability-table">
                <tr>
                    <th>Jour</th>
                    <th>Matin</th>
                    <th>Après-midi</th>
                </tr>
                <tr>
                    <td>Lundi</td>
                    <td class="<?php echo $agent['lundi_matin'] == 'dispo' ? 'available' : 'unavailable'; ?>">
                        <input type="hidden" name="lundi_matin" value="<?php echo $agent['lundi_matin']; ?>">
                    </td>
                    <td class="<?php echo $agent['lundi_apres_midi'] == 'dispo' ? 'available' : 'unavailable'; ?>">
                        <input type="hidden" name="lundi_apres_midi" value="<?php echo $agent['lundi_apres_midi']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Mardi</td>
                    <td class="<?php echo $agent['mardi_matin'] == 'dispo' ? 'available' : 'unavailable'; ?>">
                        <input type="hidden" name="mardi_matin" value="<?php echo $agent['mardi_matin']; ?>">
                    </td>
                    <td class="<?php echo $agent['mardi_apres_midi'] == 'dispo' ? 'available' : 'unavailable'; ?>">
                        <input type="hidden" name="mardi_apres_midi" value="<?php echo $agent['mardi_apres_midi']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Mercredi</td>
                    <td class="<?php echo $agent['mercredi_matin'] == 'dispo' ? 'available' : 'unavailable'; ?>">
                        <input type="hidden" name="mercredi_matin" value="<?php echo $agent['mercredi_matin']; ?>">
                    </td>
                    <td class="<?php echo $agent['mercredi_apres_midi'] == 'dispo' ? 'available' : 'unavailable'; ?>">
                        <input type="hidden" name="mercredi_apres_midi" value="<?php echo $agent['mercredi_apres_midi']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Jeudi</td>
                    <td class="<?php echo $agent['jeudi_matin'] == 'dispo' ? 'available' : 'unavailable'; ?>">
                        <input type="hidden" name="jeudi_matin" value="<?php echo $agent['jeudi_matin']; ?>">
                    </td>
                    <td class="<?php echo $agent['jeudi_apres_midi'] == 'dispo' ? 'available' : 'unavailable'; ?>">
                        <input type="hidden" name="jeudi_apres_midi" value="<?php echo $agent['jeudi_apres_midi']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Vendredi</td>
                    <td class="<?php echo $agent['vendredi_matin'] == 'dispo' ? 'available' : 'unavailable'; ?>">
                        <input type="hidden" name="vendredi_matin" value="<?php echo $agent['vendredi_matin']; ?>">
                    </td>
                    <td class="<?php echo $agent['vendredi_apres_midi'] == 'dispo' ? 'available' : 'unavailable'; ?>">
                        <input type="hidden" name="vendredi_apres_midi" value="<?php echo $agent['vendredi_apres_midi']; ?>">
                    </td>
                </tr>
            </table>
            <button type="submit" class="save-button">Enregistrer les modifications</button>
        </form>
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
                let input = td.querySelector('input[type="hidden"]');
                input.value = td.classList.contains('available') ? 'dispo' : 'indispo';
            });
        });
    </script>
</body>
</html>
