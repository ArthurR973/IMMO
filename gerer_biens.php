<?php
session_start();

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projet_piscine";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}

// Suppression d'un bien immobilier
if (isset($_POST['delete_bien_id'])) {
    $bien_id = $_POST['delete_bien_id'];
    $sql = "DELETE FROM BIEN WHERE numero = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bien_id);
    $stmt->execute();
    $stmt->close();
}

// Récupération des agents immobiliers pour la liste déroulante
$sql_agents = "SELECT numero_identification, nom FROM AGENT_IMMO";
$result_agents = $conn->query($sql_agents);
$agents = [];
if ($result_agents->num_rows > 0) {
    while ($row = $result_agents->fetch_assoc()) {
        $agents[] = $row;
    }
}

// Ajout d'un bien immobilier
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['type'])) {
    // Récupération des données du formulaire
    $type = $_POST['type'] ?? '';
    $description = $_POST['description'] ?? '';
    $adresse = $_POST['adresse'] ?? '';
    $id_agent = $_POST['id_agent'] ?? 0;
    $photo = '';

    // Gestion de l'import de la photo
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $photo = $_FILES['photo']['name'];
        $target_dir = "IMMO/";
        
        // Vérifier si le répertoire existe, sinon le créer
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Le troisième paramètre 'true' permet la création récursive des répertoires
        }
        
        $target_file = $target_dir . basename($photo);
        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
            die("Erreur lors de l'upload de la photo.");
        }
    }

    // Insertion des données dans la base de données
    $numero = $id_agent; // Le numéro du bien est le même que l'ID de l'agent
    $sql = "INSERT INTO BIEN (type, numero, photo, description, adresse, id_agent) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }

    $stmt->bind_param("sisssi", $type, $numero, $photo, $description, $adresse, $id_agent);

    if (!$stmt->execute()) {
        die("Erreur lors de l'exécution de la requête : " . $stmt->error);
    }

    $success_message = "Nouveau bien immobilier ajouté avec succès.";
    $stmt->close();
}

// Récupération des biens immobiliers
$sql = "SELECT * FROM BIEN";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer Biens Immobiliers</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Lora', serif;
            color: #333;
            background-color: #f8f9fa;
        }
        .header {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            font-family: 'Montserrat', sans-serif;
            color: white;
            font-size: 2.5rem;
            margin: 0;
        }
        .navigation {
            background-color: #f8f9fa;
            padding: 10px;
            text-align: center;
        }
        .navigation a {
            margin: 0 15px;
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
        .container {
            display: flex;
            justify-content: space-between;
            padding: 50px;
        }
        .biens-list, .add-bien-form {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 48%;
        }
        .bien-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }
        .footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px;
        }
        .delete-btn {
            padding: 5px 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="header">
    <h1>OMNES IMMOBILIER</h1>
    <p>444 N. Rue Principale, Charlotte | +33 01 23 45 67 89</p>
</div>
<div class="navigation">
    <a href="accueil.php">Accueil</a>
    <a href="tout_parcourir.php">Tout Parcourir</a>
    <a href="recherche.php">Recherche</a>
    <a href="rendezvous.php">Rendez-vous</a>
    <a href="espace_admin.php">Votre compte</a>
</div>

<div class="container">
    <div class="biens-list">
        <h2>Liste des biens immobiliers</h2>
        <ul class="list-group">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $numero = $row['numero'] ?? 'N/A';
                    $type = $row['type'] ?? 'N/A';
                    $adresse = $row['adresse'] ?? 'N/A';
                    $description = $row['description'] ?? 'N/A';

                    echo "
                    <li class='list-group-item bien-item'>
                        <div>
                            <span>$type - $adresse - $description</span>
                        </div>
                        <form method='post' style='display:inline;' onsubmit='return confirmDelete();'>
                            <input type='hidden' name='delete_bien_id' value='$numero'>
                            <button type='submit' class='delete-btn btn-danger'>Supprimer</button>
                        </form>
                    </li>";
                }
            } else {
                echo "<li class='list-group-item'>Aucun bien immobilier trouvé.</li>";
            }
            ?>
        </ul>
    </div>
    <div class="add-bien-form">
        <h2>Ajouter un bien immobilier</h2>
        <form action="gerer_biens.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="type">Type :</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="Immobilier résidentiel">Immobilier résidentiel</option>
                    <option value="Immobilier commercial">Immobilier commercial</option>
                    <option value="Appartement à louer">Appartement à louer</option>
                    <option value="Le terrain">Le terrain</option>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Description :</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="adresse">Adresse :</label>
                <input type="text" class="form-control" id="adresse" name="adresse" required>
            </div>
            <div class="form-group">
                <label for="id_agent">Agent immobilier :</label>
                <select class="form-control" id="id_agent" name="id_agent" required>
                    <?php
                    foreach ($agents as $agent) {
                        echo "<option value=\"" . $agent['numero_identification'] . "\">" . $agent['nom'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="photo">Photo :</label>
                <input type="file" class="form-control-file" id="photo" name="photo">
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
        <?php
        if (isset($success_message)) {
            echo "<div class='alert alert-success mt-3'>$success_message</div>";
        }
        ?>
    </div>
</div>

<div class="footer">
    <p>&copy; 2024 OMNES IMMOBILIER. Tous droits réservés.</p>
</div>

<script>
function confirmDelete() {
    return confirm('Êtes-vous sûr de vouloir supprimer ce bien immobilier ?');
}
</script>
</body>
</html>

<?php
$conn->close();
?>
