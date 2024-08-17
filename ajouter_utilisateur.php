<?php
// Inclure l'en-tête et les fonctions nécessaires
include 'templates/header.php';
require_once 'includes/functions.php';

// Vérifier si l'utilisateur est connecté et s'il est administrateur
session_start();
if (!isset($_SESSION['utilisateur']) || !estAdmin($_SESSION['utilisateur']['id'])) {
    echo "<script>window.location.href = 'index.php';</script>";
    exit();
}

$error = '';

// Vérifier si le formulaire a été soumis
if (isset($_POST['ajouter'])) {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $adresse = $_POST['adresse'];
    $role = $_POST['role'];

    // Connexion à la base de données
    $conn = mysqli_connect('localhost', 'root', '', 'prjt');

    // Vérifier la connexion
    if (!$conn) {
        die("Échec de la connexion : " . mysqli_connect_error());
    }

    // Inscrire l'utilisateur
    $success = inscrire($nom, $prenom, $email, $mot_de_passe, $adresse, $conn);

    if ($success) {
        // Récupérer l'ID de l'utilisateur nouvellement créé
        $userId = mysqli_insert_id($conn);

        // Modifier le rôle de l'utilisateur
        modifierUtilisateurRole($userId, $role, $conn);

        // Rediriger avec un message de succès
        echo "<script>alert('Utilisateur ajouté avec succès!'); window.location.href = 'admin_utilisateurs.php';</script>";
    } else {
        $error = 'Email déjà utilisé!';
    }

    // Fermer la connexion
    mysqli_close($conn);
}
?>

<div class="container mt-5">
    <h1 class="text-center">Ajouter un utilisateur</h1>
    <?php if ($error): ?>
        <div class="alert alert-danger text-center" role="alert">
            <?= htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>
    <form method="post" class="container mt-5">
        <div class="group">
            <input class="input" type="text" name="nom" placeholder="Nom" required>
        </div>
        <div class="group">
            <input class="input" type="text" name="prenom" placeholder="Prénom" required>
        </div>
        <div class="group">
            <input class="input" type="email" name="email" placeholder="Email" required>
        </div>
        <div class="group">
            <input class="input" type="password" name="mot_de_passe" placeholder="Mot de passe" required>
        </div>
        <div class="group">
            <input class="input" type="text" name="adresse" placeholder="Adresse" required>
        </div>
        <div class="group">
            <label for="role">Rôle</label>
            <select id="role" name="role" class="form-control">
                <option value="client">Client</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <input type="submit" name="ajouter" class="btn btn-primary" value="Ajouter">
    </form>
</div>

<?php
// Inclure le pied de page
include 'templates/footer.php';
?>