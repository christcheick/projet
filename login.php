<?php
include 'templates/header.php';
require_once 'includes/functions.php';

$error = '';

if (isset($_POST['connexion'])) {
    // Récupération des données du formulaire
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];
    
    // Appel de la fonction de connexion
    $utilisateur = connecter($email, $mot_de_passe);
    
    if ($utilisateur) {
        session_start();
        $_SESSION['utilisateur'] = $utilisateur;
        echo "<script>alert('Connexion réussie!'); window.location.href = 'index.php';</script>";
    } else {
        $error = 'Email ou mot de passe incorrect!';
    }
}
?>

<div class="container mt-5">
    <h1 class="text-center">Connexion à Boxing Zone</h1>
    <?php if ($error): ?>
        <div class="alert alert-danger text-center" role="alert">
            <?= htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>
    <form method="post" class="container mt-5">
        <div class="group">
            <svg stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="icon">
                <path d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" stroke-linejoin="round" stroke-linecap="round"></path>
            </svg>
            <input class="input" type="email" name="email" placeholder="Email" required>
        </div>
        <div class="group">
            <svg stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="icon">
                <path d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" stroke-linejoin="round" stroke-linecap="round"></path>
            </svg>
            <input class="input" type="password" name="mot_de_passe" placeholder="Mot de passe" required>
        </div>
        <input type="submit" name="connexion" class="btn btn-primary" value="Connexion">
    </form>
    <div class="text-center mt-3">
        <p>Pas encore inscrit ? <a href="inscription.php" class="btn btn-secondary">S'inscrire</a></p>
    </div>
</div>

<?php
include 'templates/footer.php';
?>