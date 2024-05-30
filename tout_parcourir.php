<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Omnes Immobilier - Tout Parcourir</title>
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
        .container {
            padding: 50px 20px;
        }
        .card {
            border: none;
            text-align: center;
        }
        .card-body {
            padding: 20px;
            background-color: #f8f9fa;
        }
        .card-body-dark {
            padding: 20px;
            background-color: #333;
            color: white;
        }
        .card-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.5rem;
            cursor: pointer; /* Pour montrer que le titre est cliquable */
        }
        .card-text {
            font-size: 1rem;
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
        <a href="#tout_parcourir">Tout Parcourir</a>
        <a href="recherche.php">Recherche</a>
        <a href="#rendez-vous">Rendez-vous</a>
        <a href="identification.php">Votre Compte</a>
    </div>
   
    <div id="tout-parcourir" class="container">
        <h2 class="text-center mb-5">Tout Parcourir</h2>
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body-dark">
                        <h3 class="card-title" onclick="window.location.href='immobilier_residentiel.php';">Immobilier résidentiel</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title" onclick="window.location.href='immobilier_commercial.php';">Immobilier commercial</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title" onclick="window.location.href='terrain.php';">Terrain</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body-dark">
                        <h3 class="card-title" onclick="window.location.href='appartement_a_louer.php';">Appartement à louer</h3>
                    </div>
                </div>
            </div>
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
