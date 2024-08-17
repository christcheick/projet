<?php
session_start(); // Assure que la session est démarrée
include 'templates/header.php';
require_once 'includes/functions.php'; // Assure que les fonctions nécessaires sont incluses

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur'])) {
    echo "<script>window.location.href = 'login.php';</script>";
    exit();
}

// Vérifie si un ID de commande est fourni
if (!isset($_GET['id'])) {
    echo "<script>window.location.href = 'commandes.php';</script>";
    exit();
}

// Récupère l'ID de la commande depuis la requête GET
$commandeId = $_GET['id'];

// Récupère les détails de la commande pour l'utilisateur connecté
$commande = getCommandeByIdAndUtilisateur($commandeId, $_SESSION['utilisateur']['id']);

// Si la commande n'existe pas, redirige vers la page des commandes
if (!$commande) {
    echo "<script>window.location.href = 'commandes.php';</script>";
    exit();
}

// Récupère les produits associés à la commande
$produits = getProduitsByCommande($commandeId);
?>

<div class="container mt-5">
    <h1 class="text-center">Détails de la Commande #<?= htmlspecialchars($commandeId); ?></h1>
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Commande #<?= htmlspecialchars($commande['id']); ?></h5>
            <p class="card-text"><strong>Date:</strong> <?= htmlspecialchars($commande['date_commande']); ?></p>
            <p class="card-text"><strong>Status:</strong> <?= htmlspecialchars($commande['status']); ?></p>
            <p class="card-text"><strong>Total:</strong> <?= htmlspecialchars($commande['total']); ?> €</p>
        </div>
    </div>
    <h2 class="text-center">Produits</h2>
    <?php foreach ($produits as $produit): ?>
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($produit['nom']); ?></h5>
                <p class="card-text"><strong>Quantité:</strong> <?= htmlspecialchars($produit['quantite']); ?></p>
                <p class="card-text"><strong>Prix unitaire:</strong> <?= htmlspecialchars($produit['prix_unitaire']); ?> €</p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php
include 'templates/footer.php';
?>