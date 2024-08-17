<?php
session_start();
include 'templates/header.php';
require_once 'includes/functions.php';

// Vérifier si l'utilisateur est connecté et est administrateur
if (!isset($_SESSION['utilisateur']) || !estAdmin($_SESSION['utilisateur']['id'])) {
    echo "<script>window.location.href = 'index.php';</script>";
    exit();
}

// Vérifier si un ID d'utilisateur est passé dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user = getUserById($id); // Récupérer les informations de l'utilisateur
    if (!$user) {
        echo "<script>window.location.href = 'admin_utilisateurs.php';</script>";
        exit();
    }
} else {
    echo "<script>window.location.href = 'admin_utilisateurs.php';</script>";
    exit();
}

// Traitement du formulaire de modification
if (isset($_POST['modifier'])) {
    $id = $_POST['id'];
    $role = $_POST['role'];
    modifierUtilisateurRole($id, $role); // Mettre à jour le rôle de l'utilisateur
    echo "<script>window.location.href = 'admin_utilisateurs.php';</script>";
    exit();
}
?>

<div class="container mt-5">
    <h1 class="text-center">Modifier utilisateur</h1>
    <form method="post">
        <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']); ?>">
        <div class="mb-3">
            <label for="role" class="form-label">Rôle</label>
            <select class="form-control" id="role" name="role" required>
                <option value="client" <?= $user['role'] == 'client' ? 'selected' : ''; ?>>Client</option>
                <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
            </select>
        </div>
        <button type="submit" name="modifier" class="btn btn-primary">Modifier</button>
    </form>
</div>

<?php
include 'templates/footer.php';
?>