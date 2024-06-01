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

// Suppression d'un agent
if (isset($_POST['delete_agent_id'])) {
    $agent_id = $_POST['delete_agent_id'];
    $sql = "DELETE FROM agent_immo WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $agent_id);
    $stmt->execute();
    $stmt->close();
}

// Ajout d'un agent
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nom'])) {
    // Récupération des données du formulaire
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $specialite = $_POST['specialite'] ?? '';

    // Génération du code au hasard à deux chiffres
    $code = rand(10, 99);

    // Assignation du numéro d'identification
    $numero_identification = 50 + $code;

    // Création de l'adresse e-mail à partir du prénom de l'agent
    $courriel = $prenom . "@omnesimmobilier";

    // Définition de la valeur de l'honoraire en fonction de la spécialité
    switch ($specialite) {
        case "Immobilier résidentiel":
            $honoraire = 12;
            $bureau = 1;
            break;
        case "Immobilier commercial":
            $honoraire = 13;
            $bureau = 2;
            break;
        case "Appartement à louer":
            $honoraire = 14;
            $bureau = 3;
            break;
        case "Le terrain":
            $honoraire = 15;
            $bureau = 4;
            break;
        default:
            $honoraire = NULL;
            $bureau = NULL;
    }

    // Insertion des données dans la base de données
    $sql = "INSERT INTO agent_immo (numero_identification, nom, prenom, specialite, honoraire, courriel, bureau) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssiss", $numero_identification, $nom, $prenom, $specialite, $honoraire, $courriel, $bureau);
    if ($stmt->execute()) {
        $success_message = "Nouvel agent ajouté avec succès.";
    } else {
        $error_message = "Erreur lors de l'ajout de l'agent : " . $conn->error;
    }
    $stmt->close();
}


// Récupération des agents
$sql = "SELECT * FROM agent_immo";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer Agents</title>
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
        .agents-list, .add-agent-form {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 48%;
        }
        .agent-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }
        .agent-item img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
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
    <a href="espace_admin.php">Espace Administrateur</a>
</div>

<div class="container">
    <div class="agents-list">
        <h2>Liste des agents</h2>
        <ul class="list-group">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $id = $row['id'] ?? 'N/A';
                    $nom = $row['nom'] ?? 'N/A';
                    $prenom = $row['prenom'] ?? 'N/A';
                    $specialite = $row['specialite'] ?? 'N/A';

                    echo "
                    <li class='list-group-item agent-item'>
                        <div>
                            <span>$prenom $nom - $specialite</span>
                        </div>
                        <form method='post' style='display:inline;' onsubmit='return confirmDelete();'>
                            <input type='hidden' name='delete_agent_id' value='$id'>
                            <button type='submit' class='delete-btn btn-danger'>Supprimer</button>
                        </form>
                    </li>";
                }
            } else {
                echo "<li class='list-group-item'>Aucun agent trouvé.</li>";
            }
            ?>
        </ul>
    </div>
    <div class="add-agent-form">
    <h2>Ajouter un agent</h2>
    <form action="gerer_agents.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nom">Nom :</label>
            <input type="text" class="form-control" id="nom" name="nom" required>
        </div>
        <div class="form-group">
            <label for="prenom">Prénom :</label>
            <input type="text" class="form-control" id="prenom" name="prenom" required>
        </div>
        <div class="form-group">
            <label for="cv">CV :</label>
            <input type="file" class="form-control-file" id="cv" name="cv" required>
        </div>
        <div class="form-group">
            <label for="photo">Photo :</label>
            <input type="file" class="form-control-file" id="photo" name="photo" required>
        </div>
        <div class="form-group">
            <label for="courriel">Courriel :</label>
            <input type="email" class="form-control" id="courriel" name="courriel" required>
        </div>
        <div class="form-group">
            <label for="specialite">Spécialité :</label>
            <select class="form-control" id="specialite" name="specialite" required>
                <option value="">Choisissez une spécialité</option>
                <option value="Immobilier commercial">Immobilier commercial</option>
                <option value="Immobilier résidentiel">Immobilier résidentiel</option>
                <option value="Immobilier résidentiel">Appartement à louer</option>
                <option value="Le terrain">Le terrain</option>
            </select>
        </div>
        <div class="form-group">
            <label for="telephone">Téléphone :</label>
            <input type="tel" class="form-control" id="telephone" name="telephone" pattern="[0-9]{10}" title="Entrez un numéro de téléphone à 10 chiffres" required>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
</div>


</div>

<div class="footer">
    <p>© 2024 Omnes Immobilier - Tous droits réservés</p>
    <p>Contactez-nous : email@omnesimmobilier.fr | +33 01 23 45 67 89</p>
</div>

<script>
function confirmDelete() {
    return confirm("Êtes-vous sûr de vouloir le supprimer ?");
}
</script>
</body>
</html>

<?php
$conn->close();
?>
