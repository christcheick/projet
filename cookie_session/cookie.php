<?php
// Fonctions de calcul
function calculDouble($nb) {
    return $nb * 2;
}

function multiplication($nb, $multiplicateur = 2) {
    return $nb * $multiplicateur;
}

// Fonction pour définir un cookie
function setCookieValue($name, $value, $expire = 3600) {
    setcookie($name, $value, time() + $expire, "/");
}

// Fonction pour récupérer la valeur d'un cookie
function getCookieValue($name) {
    return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
}

// Fonction pour supprimer un cookie
function deleteCookie($name) {
    setcookie($name, "", time() - 3600, "/");
}
?>