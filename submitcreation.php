<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['Nom'] ?? '';
    $prenom = $_POST['Prénom'] ?? '';
    $courriel = $_POST['courriel'] ?? '';
    $adresseLigne1 = $_POST['Adresse_Ligne_1'] ?? '';
    $ville = $_POST['Ville'] ?? '';
    $codePostal = $_POST['Code_Postal'] ?? '';
    $pays = $_POST['Pays'] ?? '';
    $numTel = $_POST['Numéro_de_téléphone'] ?? '';
    $motDePasse = $_POST['Mot_de_passe'] ?? '';
    $confirmMotDePasse = $_POST['confirm_password'] ?? '';
    $typeCarte = $_POST['Type_de_carte_de_paiement'] ?? '';
    $numCarte = $_POST['Numéro_de_la_carte'] ?? '';
    $nomCarte = $_POST['Nom_sur_la_carte'] ?? '';
    $dateExpiration = $_POST['Date_d_expiration_de_la_carte'] ?? '';
    $codeSecurite = $_POST['Code_de_sécurité'] ?? '';

    // Validation des mots de passe
    if ($motDePasse !== $confirmMotDePasse) {
        echo "<script>alert('Les mots de passe ne correspondent pas.'); window.history.back();</script>";
        exit;
    }

    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projet_piscine";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérification de la connexion
    if ($conn->connect_error) {
        die("La connexion a échoué: " . $conn->connect_error);
    }

    // Insertion des données dans la table clients
    $sql = "INSERT INTO clients (Nom, Prénom, courriel, Mot_de_passe, Adresse_Ligne_1, Ville, Code_Postal, Pays, Numéro_de_téléphone, Type_de_carte_de_paiement, Numéro_de_la_carte, Nom_sur_la_carte, Date_d_expiration_de_la_carte, Code_de_sécurité)
            VALUES ('$nom', '$prenom', '$courriel', '$motDePasse', '$adresseLigne1', '$ville', '$codePostal', '$pays', '$numTel', '$typeCarte', '$numCarte', '$nomCarte', '$dateExpiration', '$codeSecurite')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Nouveau compte créé avec succès'); window.location.href = 'taccueil.html';</script>";
    } else {
        echo "<script>alert('Erreur: " . $conn->error . "'); window.history.back();</script>";
    }

    $conn->close();
}
?>
