<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte - Omnes Immobilier</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Lora', serif;
            color: #333;
        }
        .container {
            text-align: center;
            max-width: 400px;   
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-title {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: left;
        }
        .form-group {
            text-align: left;
        }
        .logo {
            width: 100%;
            max-width: 200px;
            height: auto;
            display: block;
            margin: 0 auto 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="accueil.php">
            <img src="logotest.png" alt="Logo Omnes Immobilier" class="logo">
        </a>
        <h2 class="form-title">Créer un compte</h2>
        <form action="submitcreation.php" method="post">
            <div class="form-group">
                <label for="surname">Prénom</label>
                <input type="text" class="form-control" id="surname" name="surname" placeholder="Prénom" required>
            </div>
            <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nom" required>
            </div>
            <div class="form-group">
                <label for="email">Adresse mail</label>
                <input type="email" class="form-control" id="email" name="email" placeholder=" " required>
            </div>
            <div class="form-group">
                <label for="address1">Adresse Ligne 1</label>
                <input type="text" class="form-control" id="address1" name="address1" placeholder=" " required>
            </div>
            <div class="form-group">
                <label for="country">Ville</label>
                <input type="text" class="form-control" id="city" name="city" placeholder=" " required>
            </div>
            <div class="form-group">
                <label for="country">Code postal</label>
                <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder=" " required>
            </div>
            <div class="form-group">
                <label for="country">Pays</label>
                <input type="text" class="form-control" id="country" name="country" placeholder="Pays" required>
            </div>
            <div class="form-group">
                <label for="phone">Numéro de téléphone</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder=" " required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Au moins 3 caractères" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirmation du mot de passe</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder=" " required>
            </div>
            <p class="terms">En créant un compte, tu acceptes les conditions d'utilisation et tu confirmes avoir lu la politique de confidentialité de OMNES IMMOBILIER.</p>
            <button type="submit" class="btn btn-primary">Créer un compte</button>
        </form>
        <div class="login-link">
            <br><p>Vous possédez déjà un compte ? <a href="identification.php">Identifiez-vous</a></p>
        </div>
    </div>
</body>
</html>
