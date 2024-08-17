<?php
session_start(); // Assure que la session est démarrée
include 'templates/header.php';
require_once 'includes/functions.php'; // Inclut les fonctions nécessaires

// Vérifie si un ID de produit est fourni
if (isset($_GET['id'])) {
    $produitId = $_GET['id'];
    // Récupère les détails du produit
    $produit = getProduitById($produitId);

    // Si le produit n'existe pas, redirige vers la page d'accueil
    if (!$produit) {
        echo "<script>window.location.href = 'index.php';</script>";
        exit();
    }
} else {
    // Si aucun ID n'est fourni, redirige vers la page d'accueil
    echo "<script>window.location.href = 'index.php';</script>";
    exit();
}
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <img src="uploads/<?= htmlspecialchars($produit['image']); ?>" class="img-fluid" alt="<?= htmlspecialchars($produit['nom']); ?>">
        </div>
        <div class="col-md-6">
            <h1><?= htmlspecialchars($produit['nom']); ?></h1>
            <p><strong>Prix: <?= htmlspecialchars($produit['prix_unitaire']); ?> €</strong></p>
            <p><?= htmlspecialchars($produit['description']); ?></p>
            <form action="ajout.php" method="POST">
                <input type="hidden" name="produit_id" value="<?= htmlspecialchars($produit['id']); ?>">
                <input type="hidden" name="quantite" value="1">
                <button type="submit" class="btn custom-btn-add">Ajouter au Panier</button>
            </form>
        </div>
    </div>
</div>

<?php
include 'templates/footer.php';
?>