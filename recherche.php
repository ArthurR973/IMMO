<?php
// Connexion à la base de données
$bdd = new PDO('mysql:host=localhost;dbname=projet_piscine;charset=utf8', 'root', '');

// Terme de recherche
$q = '';
if (isset($_GET['q'])) {
    $q = htmlspecialchars($_GET['q']);
}

// Requête pour rechercher les biens
$query_biens = "SELECT BIEN.*, AGENT_IMMO.nom AS agent_nom, AGENT_IMMO.prenom AS agent_prenom FROM BIEN 
                LEFT JOIN AGENT_IMMO ON BIEN.id_agent = AGENT_IMMO.numero_identification 
                WHERE BIEN.description LIKE :q OR BIEN.type LIKE :q OR BIEN.adresse LIKE :q";
$statement_biens = $bdd->prepare($query_biens);
$statement_biens->execute(array(':q' => '%' . $q . '%'));
$biens = $statement_biens->fetchAll(PDO::FETCH_ASSOC);

// Requête pour rechercher les agents immobiliers
$query_agents = "SELECT * FROM AGENT_IMMO WHERE nom LIKE :q OR prenom LIKE :q OR specialite LIKE :q OR bureau LIKE :q";
$statement_agents = $bdd->prepare($query_agents);
$statement_agents->execute(array(':q' => '%' . $q . '%'));
$agents = $statement_agents->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de recherche</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Lora', serif;
            color: #333;
        }
        .header, .footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px;
        }
        .header h1, .footer p {
            font-family: 'Montserrat', sans-serif;
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
        .navigation a:hover {
            background-color: #ddd;
            color: black;
        }
        .container {
            padding: 50px 20px;
        }
        .results img {
            max-width: 200px;
            height: auto;
        }
        .results h3 {
            margin: 10px 0;
        }
    </style>
</head>

<body>

<div class="wrapper">
    <div class="header">
        <h1>OMNES IMMOBILIER</h1>
        <p>444 N. Rue Principale, Charlotte | +33 01 23 45 67 89</p>
    </div>

    <div class="navigation">
        <a href="accueil.php">Accueil</a>
        <a href="tout_parcourir.php">Tout Parcourir</a>
        <a href="recherche.php">Recherche</a>
        <a href="rendezvous.php">Rendez-vous</a>
        <a href="identification.php">Votre Compte</a>
    </div>
    
    <div class="container">
        <h1>Résultats de recherche</h1>
        <div class="search-container">
            <form action="recherche.php" method="get">
                <input type="text" name="q" value="<?php echo $q; ?>" placeholder="Rechercher un bien ou un agent" class="form-control" />
                <button type="submit" class="btn btn-primary mt-2">Rechercher</button>
            </form>
        </div>

        <h2>Biens immobiliers</h2>
        <div class="results">
            <?php if (count($biens) > 0): ?>
                <ul>
                    <?php foreach ($biens as $bien) : ?>
                        <li>
                            <img src="<?php echo $bien['photo']; ?>" alt="Photo du bien">
                            <h3><?php echo $bien['description']; ?></h3>
                            <p><?php echo $bien['adresse']; ?></p>
                            <p>Agent affilié : <?php echo $bien['agent_prenom'] . ' ' . $bien['agent_nom']; ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Aucun bien immobilier trouvé.</p>
            <?php endif; ?>
        </div>

        <h2>Agents immobiliers</h2>
        <div class="results">
            <?php if (count($agents) > 0): ?>
                <ul>
                    <?php foreach ($agents as $agent) : ?>
                        <li>
                            <img src="<?php echo $agent['photo']; ?>" alt="Photo de l'agent">
                            <h3><?php echo $agent['prenom'] . ' ' . $agent['nom']; ?></h3>
                            <p>Spécialité : <?php echo $agent['specialite']; ?></p>
                            <p>Bureau : <?php echo $agent['bureau']; ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Aucun agent immobilier trouvé.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="footer">
        <p>© 2024 Omnes Immobilier - Tous droits réservés</p>
        <p>Contactez-nous : email@omnesimmobilier.fr | +33 01 23 45 67 89</p>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
