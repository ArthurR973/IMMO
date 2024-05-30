<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Communiquer avec l'agent</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
        .chat-container {
            margin-top: 20px;
        }
        .communication-options button {
            margin-right: 10px;
        }
        #message-input {
            width: 100%;
            height: 150px;
            margin-bottom: 10px;
            resize: vertical;
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
        <h1>Communiquer avec l'agent</h1>
        <div class="chat-container">
            <div class="chat-window">
                <div id="messages" class="messages"></div>
            </div>
            <div class="chat-input">
                <textarea id="message-input" placeholder="Tapez votre message..."></textarea>
                <button onclick="sendMessage()">Envoyer</button>
            </div>
            <div class="communication-options">
                <button onclick="startAudioCall()">Appel Audio</button>
                <button onclick="startVideoCall()">Appel Vidéo</button>
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
