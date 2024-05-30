<?php
// Configuration de la base de données
$servername = "localhost";
$username = "root"; // Remplacez par votre nom d'utilisateur
$password = ""; // Remplacez par votre mot de passe
$dbname = "projet_piscine";

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer les données du formulaire
$surname = $_POST['surname'];
$name = $_POST['name'];
$email = $_POST['email'];
$address1 = $_POST['address1'];
$city = $_POST['city'];
$postal_code = $_POST['postal_code'];
$country = $_POST['country'];
$phone = $_POST['phone'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Vérifier si les mots de passe correspondent
if ($password !== $confirm_password) {
    echo "Les mots de passe ne correspondent pas.";
    exit();
}

// Échapper les caractères spéciaux pour éviter les injections SQL
$surname = $conn->real_escape_string($surname);
$name = $conn->real_escape_string($name);
$email = $conn->real_escape_string($email);
$address1 = $conn->real_escape_string($address1);
$city = $conn->real_escape_string($city);
$postal_code = $conn->real_escape_string($postal_code);
$country = $conn->real_escape_string($country);
$phone = $conn->real_escape_string($phone);
$password = password_hash($password, PASSWORD_BCRYPT); // Hachage du mot de passe

// Insérer les données dans la table `users`
// Les colonnes de carte de paiement sont mises à NULL par défaut
$sql = "INSERT INTO users (Nom, Prénom, courriel, Mot_de_passe, Adresse_Ligne_1, Ville, Code_Postal, Pays, Numéro_de_téléphone, Type_de_carte_de_paiement, Numéro_de_la_carte, Nom_sur_la_carte, Date_d_expiration_de_la_carte, Code_de_sécurité) 
        VALUES ('$name', '$surname', '$email', '$password', '$address1', '$city', '$postal_code', '$country', '$phone', NULL, NULL, NULL, NULL, NULL)";

if ($conn->query($sql) === TRUE) {
    echo "Compte créé avec succès.";
    header("Location: accueil.php");
    exit();
} else {
    echo "Erreur : " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
