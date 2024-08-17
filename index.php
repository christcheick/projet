<?php
include 'templates/header.php';
require_once 'includes/functions.php';

// Définir le nombre de produits par page
$limit = 6; // Nombre de produits à afficher par page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Récupérer le numéro de page actuel
$offset = ($page - 1) * $limit; // Calculer l'offset

// Connexion à la base de données
$conn = mysqli_connect('localhost', 'root', '', 'prjt');

// Vérifier la connexion
if (!$conn) {
    die("Échec de la connexion : " . mysqli_connect_error());
}

// Récupérer le nombre total de produits
$result = mysqli_query($conn, "SELECT COUNT(*) as total FROM produits");
$row = mysqli_fetch_assoc($result);
$totalProduits = $row['total'];
$totalPages = ceil($totalProduits / $limit); // Calculer le nombre total de pages

// Récupérer les produits pour la page actuelle
$query = "SELECT * FROM produits LIMIT ? OFFSET ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'ii', $limit, $offset);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$produits = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Fermer la connexion
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>

<div class="container mt-5">
    <h1 class="text-center">Tous les Produits</h1>
    
    <?php if (isset($_SESSION['utilisateur']) && $_SESSION['utilisateur']['role'] === 'admin'): ?>
        <p class="text-right">Total des produits: <?= $totalProduits; ?></p>
    <?php endif; ?>

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
    <!-- Pagination -->
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <?php if($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="index.php?page=<?= $page - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php for($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : ''; ?>">
                    <a class="page-link" href="index.php?page=<?= $i; ?>"><?= $i; ?></a>
                </li>
            <?php endfor; ?>
            <?php if($page < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link" href="index.php?page=<?= $page + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<?php
include 'templates/footer.php';
?>