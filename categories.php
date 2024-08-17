<?php
// Inclure l'en-tête
include 'templates/header.php';

// Vérifier la présence du paramètre 'categorie' dans l'URL
if (isset($_GET['categorie'])) {
    $categorie = $_GET['categorie'];
    
    // Connexion à la base de données
    $conn = mysqli_connect('localhost', 'root', '', 'prjt');
    
    // Vérifier la connexion
    if (!$conn) {
        die("Échec de la connexion : " . mysqli_connect_error());
    }
    
    // Obtenir le total des produits par catégorie
    $stmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM produits WHERE categorie = ?");
    mysqli_stmt_bind_param($stmt, 's', $categorie);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $totalProduitsParCategorie);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    
    // Obtenir les produits par catégorie
    $stmt = mysqli_prepare($conn, "SELECT * FROM produits WHERE categorie = ?");
    mysqli_stmt_bind_param($stmt, 's', $categorie);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $produits = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    
    // Fermer la connexion
    mysqli_close($conn);
} else {
    // Rediriger vers la page d'accueil si 'categorie' n'est pas défini
    echo "<script>window.location.href = 'index.php';</script>";
    exit();
}
?>

<div class="container mt-5">
    <h1 class="text-center">Boxing Zone</h1>
    <h2 class="text-center"><?= htmlspecialchars($categorie); ?> 
        <?php if (isset($_SESSION['utilisateur']) && estAdmin($_SESSION['utilisateur']['id'])): ?>
            (Total: <?= htmlspecialchars($totalProduitsParCategorie); ?>)
        <?php endif; ?>
    </h2>
    <div class="row">
        <?php foreach ($produits as $produit): ?>
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <img src="uploads/<?= htmlspecialchars($produit['image']); ?>" class="card-img-top" alt="<?= htmlspecialchars($produit['nom']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($produit['nom']); ?></h5>
                        <p class="card-text"><strong><?= htmlspecialchars($produit['prix_unitaire']); ?> €</strong></p>
                        <p class="card-text"><?= htmlspecialchars($produit['description']); ?></p>
                        <a href="voir_produit.php?id=<?= $produit['id']; ?>" class="btn btn-primary custom-btn-view">Voir</a>
                        <form action="ajout.php" method="POST" class="d-inline">
                            <input type="hidden" name="produit_id" value="<?= $produit['id']; ?>">
                            <button type="submit" class="btn btn-success custom-btn-add">Ajouter au Panier</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
// Inclure le pied de page
include 'templates/footer.php';
?>