<?php
// Connexion à la base de données
$bdd = new PDO('mysql:host=localhost;dbname=projet_piscine;charset=utf8', 'root', '');

// Terme de recherche
$q = '';
if (isset($_GET['q'])) {
    $q = htmlspecialchars($_GET['q']);
}

// Requête pour rechercher les biens et les agents immobiliers
$query_biens_agents = "SELECT BIEN.*, AGENT_IMMO.nom AS agent_nom, AGENT_IMMO.prenom AS agent_prenom, AGENT_IMMO.courriel, AGENT_IMMO.tel, AGENT_IMMO.photo AS agent_photo 
                       FROM BIEN 
                       LEFT JOIN AGENT_IMMO ON BIEN.id_agent = AGENT_IMMO.numero_identification 
                       WHERE BIEN.description LIKE :q 
                       OR BIEN.type LIKE :q 
                       OR BIEN.adresse LIKE :q
                       OR AGENT_IMMO.nom LIKE :q 
                       OR AGENT_IMMO.prenom LIKE :q 
                       OR AGENT_IMMO.specialite LIKE :q 
                       OR AGENT_IMMO.bureau LIKE :q";
$statement_biens_agents = $bdd->prepare($query_biens_agents);
$statement_biens_agents->execute(array(':q' => '%' . $q . '%'));
$biens_agents = $statement_biens_agents->fetchAll(PDO::FETCH_ASSOC);
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
        .search-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .search-container input {
            width: 50%;
            display: inline-block;
        }
        .results ul {
            list-style-type: none;
            padding: 0;
        }
        .results li {
            background-color: #f8f9fa;
            margin: 10px 0;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
        }
        .btn-black {
            background-color: #000;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn-black:hover {
            background-color: #444;
            color: #fff;
        }
        .footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px;
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
        <a href="rendez_vous.php">Rendez-vous</a>
        <a href="identification.php">Votre Compte</a>
    </div>
    
    <div class="container">
        <h1 class="text-center">Résultats de recherche</h1>
        <div class="search-container">
            <form action="recherche.php" method="get">
                <input type="text" name="q" value="<?php echo $q; ?>" placeholder="Rechercher un bien ou un agent" class="form-control" />
                <button type="submit" class="btn btn-black mt-2">Rechercher</button>
            </form>
        </div>

        <h2 class="text-center">Résultats de recherche</h2>
        <div class="results">
            <?php if (count($biens_agents) > 0): ?>
                <ul>
                    <?php foreach ($biens_agents as $bien) : ?>
                        <li>
                            <img src="<?php echo $bien['photo']; ?>" alt="Photo du bien">
                            <h3><?php echo $bien['description']; ?></h3>
                            <p>Numéro du bien : <?php echo $bien['numero']; ?></p>
                            <p>Adresse : <?php echo $bien['adresse']; ?></p>
                            <p>Prix: <?php echo $bien['prix']; ?> €</p>
                            <h4>Agent affilié</h4>
                            <img src="<?php echo $bien['agent_photo']; ?>" alt="Photo de l'agent">
                            <p>Nom : <?php echo $bien['agent_prenom'] . ' ' . $bien['agent_nom']; ?></p>
                            <p>Email : <a href='mailto:<?php echo $bien['courriel']; ?>'><?php echo $bien['courriel']; ?></a></p>
                            <p>Téléphone : <?php echo $bien['tel']; ?></p>
                            <a href="contacter_agent.php?agent_id=<?php echo $bien['id_agent']; ?>" class="btn btn-black">Contactez l'agent</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-center">Aucun résultat trouvé.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="footer">
        <p>© 2024 Omnes Immobilier - Tous droits réservés</p>
        <p>Mail : <a href="mailto:omnes.immobilier@gmail.com">email@omnesimmobilier.fr</a></p>
        <p>Téléphone : <a href="tel:+33102030405">+33 01 23 45 67 89</a></p> 
        <p>Adresse : <a href="https://www.google.fr/maps/place/4+Rue+Principale,+67300+Schiltigheim">444 N. Rue Principale, Charlotte</a></p>
    </div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
