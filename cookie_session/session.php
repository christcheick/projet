<?php
// Démarrage de la session
function startSession() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}

// Fonction pour définir une valeur de session
function setSessionValue($key, $value) {
    startSession();
    $_SESSION[$key] = $value;
}

// Fonction pour récupérer une valeur de session
function getSessionValue($key) {
    startSession();
    return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
}

// Fonction pour vérifier si une valeur de session existe
function checkSessionValue($key) {
    startSession();
    return isset($_SESSION[$key]);
}

// Fonction pour supprimer une valeur de session
function deleteSessionValue($key) {
    startSession();
    if (isset($_SESSION[$key])) {
        unset($_SESSION[$key]);
    }
}

// Fonction pour détruire la session
function destroySession() {
    startSession();
    session_unset();
    session_destroy();
}

// Fonction pour régénérer l'ID de session
function regenerateSession() {
    startSession();
    session_regenerate_id(true);
}

// Fonction pour définir un message flash
function setFlashMessage($key, $message) {
    startSession();
    $_SESSION['flash_messages'][$key] = $message;
}

// Fonction pour récupérer un message flash
function getFlashMessage($key) {
    startSession();
    if (isset($_SESSION['flash_messages'][$key])) {
        $message = $_SESSION['flash_messages'][$key];
        unset($_SESSION['flash_messages'][$key]);
        return $message;
    }
    return null;
}

// Fonction pour récupérer tous les messages flash
function getAllFlashMessages() {
    startSession();
    $messages = isset($_SESSION['flash_messages']) ? $_SESSION['flash_messages'] : [];
    unset($_SESSION['flash_messages']);
    return $messages;
}
?>