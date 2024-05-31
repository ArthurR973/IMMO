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
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
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
        .welcome {
            background-color: #f8f9fa;
            color: #333;
            padding: 50px;
            text-align: center;
        }
        .welcome h2 {
            font-family: 'Montserrat', sans-serif;
            font-size: 2rem;
            margin-bottom: 20px;
        }
        .welcome p {
            font-size: 1rem;
        }
        .event-section {
            padding: 50px 20px;
            text-align: center;
        }
        .carousel-item img {
            width: 100%;
            height: auto;
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
    <div class="container">
        <a href="accueil.php">
            <img src="logotest.png" alt="Logo Omnes Immobilier" class="logo">
        </a>
        <h2 class="form-title">Créer un compte</h2>
        <form id="registrationForm" action="submitcreation.php" method="post">
            <div class="form-group">
                <label for="surname">Prénom</label>
                <input type="text" class="form-control" id="surname" name="Prénom" placeholder="Prénom" required>
            </div>
            <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" class="form-control" id="name" name="Nom" placeholder="Nom" required>
            </div>
            <div class="form-group">
                <label for="email">Adresse mail</label>
                <input type="email" class="form-control" id="email" name="courriel" placeholder=" " required>
            </div>
            <div class="form-group">
                <label for="address1">Adresse Ligne 1</label>
                <input type="text" class="form-control" id="address1" name="Adresse_Ligne_1" placeholder=" " required>
            </div>
            <div class="form-group">
                <label for="city">Ville</label>
                <input type="text" class="form-control" id="city" name="Ville" placeholder=" " required>
            </div>
            <div class="form-group">
                <label for="postal_code">Code postal</label>
                <input type="text" class="form-control" id="postal_code" name="Code_Postal" placeholder=" " required>
                <div class="error-message" id="postal_code_error"></div>
            </div>
            <div class="form-group">
                <label for="country">Pays</label>
                <input type="text" class="form-control" id="country" name="Pays" placeholder="Pays" required>
            </div>
            <div class="form-group">
                <label for="phone">Numéro de téléphone</label>
                <input type="text" class="form-control" id="phone" name="Numéro_de_téléphone" placeholder=" " required>
                <div class="error-message" id="phone_error"></div>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="Mot_de_passe" placeholder="Au moins 3 caractères" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirmation du mot de passe</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder=" " required>
                <small id="passwordHelp" class="form-text text-danger"></small>
            </div>
            <div class="form-group">
                <label for="card_type">Type de carte de paiement</label>
                <input type="text" class="form-control" id="card_type" name="Type_de_carte_de_paiement" placeholder="Visa/Mastercard" required>
                <div class="error-message" id="card_type_error"></div>
            </div>
            <div class="form-group">
                <label for="card_number">Numéro de la carte</label>
                <input type="text" class="form-control" id="card_number" name="Numéro_de_la_carte" placeholder="12 chiffres" required>
                <div class="error-message" id="card_number_error"></div>
            </div>
            <div class="form-group">
                <label for="card_name">Nom sur la carte</label>
                <input type="text" class="form-control" id="card_name" name="Nom_sur_la_carte" placeholder=" " required>
            </div>
            <div class="form-group">
                <label for="card_expiry">Date d'expiration de la carte</label>
                <input type="text" class="form-control" id="card_expiry" name="Date_d_expiration_de_la_carte" placeholder="AAAA-MM-DD" required>
                <div class="error-message" id="card_expiry_error"></div>
            </div>
            <div class="form-group">
                <label for="card_security">Code de sécurité</label>
                <input type="text" class="form-control" id="card_security" name="Code_de_sécurité" placeholder="CVV" required>
                <div class="error-message" id="card_security_error"></div>
            </div>
            <p class="terms">En créant un compte, tu acceptes les conditions d'utilisation et tu confirmes avoir lu la politique de confidentialité de OMNES IMMOBILIER.</p>
            <button type="submit" class="btn btn-primary">Créer un compte</button>
            <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($result_check->num_rows > 0) {
                echo "<p class='error-message'>Un compte avec cet e-mail ou ce numéro de téléphone existe déjà.</p>";
            }
        }
        ?>
        </form>
        <div class="login-link">
            <br><p>Vous possédez déjà un compte ? <a href="identification.php">Identifiez-vous</a></p>
        </div>
    </div>

    <!-- Inclusion de jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function(){
        $('#registrationForm').submit(function(event){
            var isValid = true;

            // Validation des champs
            var postalCode = $('#postal_code').val();
            if (!/^\d{5}$/.test(postalCode)) {
                $('#postal_code_error').text('Le code postal doit contenir 5 chiffres.');
                isValid = false;
            } else {
                $('#postal_code_error').text('');
            }

            var phone = $('#phone').val();
            if (!/^\d{10}$/.test(phone)) {
                $('#phone_error').text('Le numéro de téléphone doit contenir 10 chiffres.');
                isValid = false;
            } else {
                $('#phone_error').text('');
            }

            var cardType = $('#card_type').val();
            if (cardType !== 'Visa' && cardType !== 'Mastercard') {
                $('#card_type_error').text('Le type de carte doit être Visa ou Mastercard.');
                isValid = false;
            } else {
                $('#card_type_error').text('');
            }

            var cardNumber = $('#card_number').val();
            if (!/^\d{12}$/.test(cardNumber)) {
                $('#card_number_error').text('Le numéro de la carte doit contenir 12 chiffres.');
                isValid = false;
            } else {
                $('#card_number_error').text('');
            }

            var cardExpiry = $('#card_expiry').val();
            if (!/^\d{4}-\d{2}-\d{2}$/.test(cardExpiry)) {
                $('#card_expiry_error').text('La date d\'expiration doit être au format AAAA-MM-JJ.');
                isValid = false;
            } else {
                $('#card_expiry_error').text('');
            }

            var cardSecurity = $('#card_security').val();
            if (!/^\d{3}$/.test(cardSecurity)) {
                $('#card_security_error').text('Le code de sécurité doit contenir 3 chiffres.');
                isValid = false;
            } else {
                $('#card_security_error').text('');
            }

            // Validation des mots de passe
            var password = $('#password').val();
            var confirmPassword = $('#confirm_password').val();
            if (password !== confirmPassword) {
                $('#passwordHelp').text('Les mots de passe ne correspondent pas.');
                isValid = false;
            } else {
                $('#passwordHelp').text('');
            }

            if (!isValid) {
                event.preventDefault(); // Empêche l'envoi du formulaire si validation échoue
            }
        });
    });
    </script>
</body>
</html>
