<?php
// Démarrer la session
session_start();

// Inclure les fonctions nécessaires
require_once 'includes/functions.php';

// Vérifier si la requête est de type POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si l'utilisateur est connecté
    if (isset($_SESSION['utilisateur'])) {
        // Récupérer l'ID de l'utilisateur et du produit
        $userId = $_SESSION['utilisateur']['id'];
        $produitId = $_POST['produit_id'];

        // Ajouter le produit au panier
        ajouterAuPanier($userId, $produitId, 1);

        // Rediriger vers la page du panier
        echo "<script>window.location.href = 'panier.php';</script>";
    } else {
        // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
        echo "<script>window.location.href = 'login.php';</script>";
    }
}

// Fonction pour ajouter un produit au panier
function ajouterAuPanier($userId, $produitId, $quantite) {
    // Connexion à la base de données
    $conn = mysqli_connect('localhost', 'root', '', 'prjt');

    // Vérification de la connexion
    if (!$conn) {
        die("Échec de la connexion : " . mysqli_connect_error());
    }

    // Vérifier si le produit est déjà dans le panier
    $stmt = mysqli_prepare($conn, "SELECT quantite FROM panier WHERE utilisateur_id = ? AND produit_id = ?");
    mysqli_stmt_bind_param($stmt, 'ii', $userId, $produitId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $existingQuantite);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($existingQuantite) {
        // Mettre à jour la quantité si le produit est déjà dans le panier
        $newQuantite = $existingQuantite + $quantite;
        $stmt = mysqli_prepare($conn, "UPDATE panier SET quantite = ? WHERE utilisateur_id = ? AND produit_id = ?");
        mysqli_stmt_bind_param($stmt, 'iii', $newQuantite, $userId, $produitId);
    } else {
        // Insérer un nouveau produit dans le panier
        $stmt = mysqli_prepare($conn, "INSERT INTO panier (utilisateur_id, produit_id, quantite) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'iii', $userId, $produitId, $quantite);
    }

    // Exécuter la requête et fermer la connexion
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>