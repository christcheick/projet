<?php
include 'templates/header.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur'])) {
    echo "<script>window.location.href = 'login.php';</script>";
    exit();
}

// Connexion à la base de données
$conn = mysqli_connect('localhost', 'root', '', 'prjt');

// Vérifier la connexion
if (!$conn) {
    die("Échec de la connexion : " . mysqli_connect_error());
}

// Récupérer les commandes de l'utilisateur
$userId = $_SESSION['utilisateur']['id'];
$stmt = mysqli_prepare($conn, "SELECT * FROM commandes WHERE utilisateur_id = ?");
mysqli_stmt_bind_param($stmt, 'i', $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$commandes = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_stmt_close($stmt);

// Fermer la connexion
mysqli_close($conn);
?>

<div class="container mt-5">
    <h1 class="text-center">Mes Commandes</h1>
    <?php foreach ($commandes as $commande): ?>
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Commande #<?= htmlspecialchars($commande['id']); ?></h5>
                <p class="card-text"><strong>Date:</strong> <?= htmlspecialchars($commande['date_commande']); ?></p>
                <p class="card-text"><strong>Status:</strong> <?= htmlspecialchars($commande['status']); ?></p>
                <p class="card-text"><strong>Total:</strong> <?= htmlspecialchars($commande['total']); ?> €</p>
                <a href="voir_commande.php?id=<?= $commande['id']; ?>" class="btn btn-primary">Voir Détails</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php
include 'templates/footer.php';
?>
