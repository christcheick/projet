<?php
session_start();
include 'templates/header.php';
require_once 'includes/functions.php';

$error = '';

// Vérifier si l'utilisateur est connecté et est un administrateur
if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'admin') {
    echo "<script>window.location.href = 'index.php';</script>";
    exit();
}

// Vérifier si un ID de produit est passé dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $produit = getProduitById($id); // Récupérer les informations du produit
    if (!$produit) {
        echo "<script>window.location.href = 'index.php';</script>";
        exit();
    }
} else {
    echo "<script>window.location.href = 'index.php';</script>";
    exit();
}

// Traitement du formulaire de modification
if (isset($_POST['modifier'])) {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prix = $_POST['prix'];
    $quantite = $_POST['quantite'];
    $categorie = $_POST['categorie'];
    $description = $_POST['description'];
    $image = $produit['image'];

    // Gestion de l'upload de l'image
    if ($_FILES['image']['name']) {
        $image = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($image_tmp, "uploads/" . $image);
    }

    // Appeler la fonction pour modifier le produit
    modifierProduit($id, $nom, $prix, $quantite, $image, $description, $categorie);
    echo "<script>window.location.href = 'index.php';</script>";
    exit();
}
?>

<div class="container mt-5">
    <h1 class="text-center">Modifier un produit</h1>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= htmlspecialchars($produit['id']); ?>">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($produit['nom']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="prix" class="form-label">Prix unitaire</label>
            <input type="text" class="form-control" id="prix" name="prix" value="<?= htmlspecialchars($produit['prix_unitaire']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="quantite" class="form-label">Quantité</label>
            <input type="number" class="form-control" id="quantite" name="quantite" value="<?= htmlspecialchars($produit['quantite']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="categorie" class="form-label">Catégorie</label>
            <select class="form-control" id="categorie" name="categorie" required>
                <option value="Vêtements" <?= $produit['categorie'] == 'Vêtements' ? 'selected' : ''; ?>>Vêtements</option>
                <option value="Gants" <?= $produit['categorie'] == 'Gants' ? 'selected' : ''; ?>>Gants</option>
                <option value="Sacs de sport" <?= $produit['categorie'] == 'Sacs de sport' ? 'selected' : ''; ?>>Sacs de sport</option>
                <option value="Accessoires" <?= $produit['categorie'] == 'Accessoires' ? 'selected' : ''; ?>>Accessoires</option>
                <option value="Équipements de protection" <?= $produit['categorie'] == 'Équipements de protection' ? 'selected' : ''; ?>>Équipements de protection</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image">
            <img src="uploads/<?= htmlspecialchars($produit['image']); ?>" alt="<?= htmlspecialchars($produit['nom']); ?>" class="img-fluid mt-2" width="100">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required><?= htmlspecialchars($produit['description']); ?></textarea>
        </div>
        <button type="submit" name="modifier" class="btn btn-primary">Modifier</button>
    </form>
</div>

<?php
include 'templates/footer.php';
?>