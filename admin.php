<?php
include 'templates/header.php';
require_once 'includes/functions.php';

// Démarrer la session
session_start();

// Vérifie si l'utilisateur est connecté et s'il est administrateur
if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'admin') {
    echo "<script>window.location.href = 'index.php';</script>";
    exit();
}

// Vérifie si le formulaire de suppression a été soumis
if (isset($_POST['supprimer'])) {
    $produitId = $_POST['produit_id'];
    supprimerProduit($produitId);
    echo "<script>alert('Produit supprimé avec succès.'); window.location.href = 'admin.php';</script>";
    exit();
}

// Récupère tous les produits
$produits = getProduits();
?>

<div class="container mt-5">
    <h1 class="text-center">Gestion des produits</h1>
    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th scope="col">Nom</th>
                <th scope="col">Prix</th>
                <th scope="col">Quantité</th>
                <th scope="col">Catégorie</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produits as $produit): ?>
                <tr>
                    <td><?= htmlspecialchars($produit['nom']); ?></td>
                    <td><?= htmlspecialchars($produit['prix_unitaire']); ?> €</td>
                    <td><?= htmlspecialchars($produit['quantite']); ?></td>
                    <td><?= htmlspecialchars($produit['categorie']); ?></td>
                    <td>
                        <a href="modifier_produit.php?id=<?= $produit['id']; ?>" class="btn btn-warning">Modifier</a>
                        <form action="admin.php" method="POST" style="display:inline;">
                            <input type="hidden" name="produit_id" value="<?= $produit['id']; ?>">
                            <button type="submit" name="supprimer" class="btn btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
include 'templates/footer.php';
?>