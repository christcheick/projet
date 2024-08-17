<?php
session_start();
require_once 'includes/functions.php';

// Vérifie si l'utilisateur est connecté et est un admin
if (!isset($_SESSION['utilisateur']) || !estAdmin($_SESSION['utilisateur']['id'])) {
    echo "<script>window.location.href = 'index.php';</script>";
    exit();
}

// Vérifie si un ID d'utilisateur est fourni et supprime l'utilisateur
if (isset($_POST['user_id'])) {
    supprimerUtilisateur($_POST['user_id']);
    echo "<script>window.location.href = 'admin_utilisateurs.php';</script>";
    exit();
}
?>