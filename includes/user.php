<?php
require_once 'includes/db_connection.php';

// Fonction pour enregistrer un nouvel utilisateur
function register($fullname, $email, $password) {
    $conn = getConnection();
    $stmt = mysqli_prepare($conn, "INSERT INTO utilisateurs (fullname, email, password) VALUES (?, ?, ?)");
    if ($stmt) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "sss", $fullname, $email, $hashedPassword);
        return mysqli_stmt_execute($stmt);
    }
    return false;
}

// Fonction pour connecter un utilisateur
function login($email, $password) {
    $conn = getConnection();
    $stmt = mysqli_prepare($conn, "SELECT * FROM utilisateurs WHERE email = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['utilisateur'] = $user;
            return true;
        }
    }
    return false;
}

// Fonction pour obtenir une connexion à la base de données
function getConnection() {
    // Récupère la connexion à la base de données depuis db_connection.php
    return DBConnection::getConnection();
}
?>