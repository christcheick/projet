<?php
// Inclure le fichier de l'en-tête et démarrer la session
include 'templates/header.php';
session_start();

// Vérifier si l'utilisateur est connecté et s'il a le rôle d'administrateur
if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'admin') {
    echo "<script>window.location.href = 'index.php';</script>";
    exit();
}

// Vérifier si le formulaire a été soumis pour ajouter un produit
if (isset($_POST['ajout'])) {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $prix = $_POST['prix'];
    $quantite = $_POST['quantite'];
    $categorie = $_POST['categorie'];
    $description = $_POST['description'];

    // Gérer l'upload de l'image
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    move_uploaded_file($image_tmp, "uploads/" . $image);

    // Appeler la fonction pour ajouter le produit à la base de données
    ajouterProduit($nom, $prix, $quantite, $image, $description, $categorie);

    // Alerte de confirmation et redirection
    echo "<script>alert('Produit ajouté avec succès.'); window.location.href = 'ajout_produit.php';</script>";
    exit();
}

// Fonction pour ajouter un produit à la base de données
function ajouterProduit($nom, $prix, $quantite, $image, $description, $categorie) {
    // Connexion à la base de données
    $conn = mysqli_connect('localhost', 'root', '', 'prjt');

    // Vérification de la connexion
    if (!$conn) {
        die("Échec de la connexion : " . mysqli_connect_error());
    }

    // Préparer la requête SQL d'insertion
    $stmt = mysqli_prepare($conn, "INSERT INTO produits (nom, prix_unitaire, quantite, image, description, categorie) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'sdisss', $nom, $prix, $quantite, $image, $description, $categorie);

    // Exécuter la requête et fermer la connexion
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<!-- Formulaire pour ajouter un produit -->
<div class="container mt-5">
    <h1 class="text-center">Ajouter un produit</h1>
    <form method="post" enctype="multipart/form-data" class="form-styled">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" required>
        </div>
        <div class="mb-3">
            <label for="prix" class="form-label">Prix unitaire</label>
            <input type="text" class="form-control" id="prix" name="prix" required>
        </div>
        <div class="mb-3">
            <label for="quantite" class="form-label">Quantité</label>
            <input type="number" class="form-control" id="quantite" name="quantite" required>
        </div>
        <div class="mb-3">
            <label for="categorie" class="form-label">Catégorie</label>
            <select class="form-control" id="categorie" name="categorie" required>
                <option value="Vêtements">Vêtements</option>
                <option value="Gants">Gants</option>
                <option value="Sacs de sport">Sacs de sport</option>
                <option value="Accessoires">Accessoires</option>
                <option value="Équipements de protection">Équipements de protection</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <button type="submit" name="ajout" class="btn btn-primary btn-custom">Ajouter un produit</button>
    </form>
</div>

<?php
// Inclure le pied de page
include 'templates/footer.php';
?>