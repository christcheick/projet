<?php
session_start();
include 'templates/header.php';
require_once 'includes/functions.php'; // Assurez-vous que les fonctions nécessaires sont définies ici

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur'])) {
    echo "<script>window.location.href = 'login.php';</script>";
    exit();
}

$userId = $_SESSION['utilisateur']['id'];
$panier = getPanier($userId);

// Traitement des actions du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $produitId = $_POST['produit_id'];
        if ($_POST['action'] == 'augmenter') {
            ajouterAuPanier($userId, $produitId, 1);
        } elseif ($_POST['action'] == 'diminuer') {
            diminuerQuantitePanier($userId, $produitId);
        } elseif ($_POST['action'] == 'supprimer') {
            supprimerDuPanier($userId, $produitId);
        }
        echo "<script>window.location.href = 'panier.php';</script>";
        exit();
    }
}
?>

<div class="container mt-5">
    <h1 class="text-center">Votre Panier</h1>
    <div class="row gx-4 gy-4">
        <?php if (count($panier) > 0): ?>
            <?php foreach ($panier as $item): ?>
                <div class="col-md-4 d-flex align-items-stretch">
                    <div class="card mb-4 shadow-sm d-flex flex-column red-black-card">
                        <img src="uploads/<?= htmlspecialchars($item['image']); ?>" class="card-img-top" alt="<?= htmlspecialchars($item['nom']); ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($item['nom']); ?></h5>
                            <p class="card-text"><strong><?= htmlspecialchars($item['prix_unitaire']); ?> €</strong></p>
                            <p class="card-text flex-grow-1"><?= htmlspecialchars($item['description']); ?></p>
                            <p class="card-text"><strong>Quantité: <?= htmlspecialchars($item['quantite']); ?></strong></p>
                            <form action="panier.php" method="POST" class="d-inline">
                                <input type="hidden" name="produit_id" value="<?= $item['id']; ?>">
                                <button type="submit" name="action" value="augmenter" class="btn btn-success btn-quantity"><i class="bi bi-plus-lg"></i></button>
                                <button type="submit" name="action" value="diminuer" class="btn btn-warning btn-quantity"><i class="bi bi-dash-lg"></i></button>
                                <button type="submit" name="action" value="supprimer" class="btn btn-danger btn-quantity"><i class="bi bi-x-lg"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center" role="alert">
                    Votre panier est vide.
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php if (count($panier) > 0): ?>
        <div class="text-center mt-5">
            <a href="paiement.php" class="btn btn-success">Payer</a>
        </div>
    <?php endif; ?>
</div>

<?php
include 'templates/footer.php';
?>