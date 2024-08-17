<?php
// Inclure les fichiers nécessaires pour la connexion à la base de données et les fonctions
require_once 'includes/db_connection.php';
require_once 'includes/functions.php';

// Données de l'administrateur
$nom = 'Admin';
$prenom = 'Admin';
$email = 'admin@boxingzone.com';
$mot_de_passe = 'admin123';
$adresse = 'Adresse Admin';

// Appeler la fonction pour inscrire l'administrateur et afficher le résultat
if (inscrireAdmin($nom, $prenom, $email, $mot_de_passe, $adresse, $conn)) {
    echo "Compte administrateur créé avec succès.";
} else {
    echo "Échec de la création du compte administrateur.";
}

// Fonction pour inscrire un administrateur
function inscrireAdmin($nom, $prenom, $email, $mot_de_passe, $adresse, $conn) {
    // Vérifier si l'email existe déjà dans la base de données
    $stmt = mysqli_prepare($conn, 'SELECT id FROM utilisateurs WHERE email = ?');
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_close($stmt);
        return false;
    }

    mysqli_stmt_close($stmt);

    // Insérer le nouvel utilisateur avec le rôle admin
    $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_BCRYPT);
    $stmt = mysqli_prepare($conn, 'INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, adresse, role) VALUES (?, ?, ?, ?, ?, ?)');
    $role = 'admin';
    mysqli_stmt_bind_param($stmt, 'ssssss', $nom, $prenom, $email, $mot_de_passe_hache, $adresse, $role);
    
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}

// Connexion à la base de données
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Vérification de la connexion
if (!$conn) {
    die("Échec de la connexion à la base de données : " . mysqli_connect_error());
}
?>