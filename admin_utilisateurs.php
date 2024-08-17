<?php
include 'templates/header.php';
require_once 'includes/functions.php';

// Vérifie si l'utilisateur est connecté et s'il est administrateur
session_start();
if (!isset($_SESSION['utilisateur']) || !estAdmin($_SESSION['utilisateur']['id'])) {
    echo "<script>window.location.href = 'index.php';</script>";
    exit();
}

// Récupère tous les utilisateurs
$users = getAllUsers();
?>

<div class="container mt-5">
    <h1 class="text-center">Gestion des utilisateurs</h1>
    <div class="text-right mb-3">
        <a href="ajouter_utilisateur.php" class="btn btn-success">Ajouter un utilisateur</a>
    </div>
    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                <th scope="col">Email</th>
                <th scope="col">Rôle</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['nom']); ?></td>
                    <td><?= htmlspecialchars($user['prenom']); ?></td>
                    <td><?= htmlspecialchars($user['email']); ?></td>
                    <td><?= htmlspecialchars($user['role']); ?></td>
                    <td>
                        <a href="modifier_utilisateur.php?id=<?= $user['id']; ?>" class="btn btn-primary">Modifier</a>
                        <form action="supprimer_utilisateur.php" method="POST" style="display:inline;">
                            <input type="hidden" name="user_id" value="<?= $user['id']; ?>">
                            <button type="submit" class="btn btn-danger">Supprimer</button>
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