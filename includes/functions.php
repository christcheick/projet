<?php
require_once 'config.php';

// Fonction de connexion à la base de données
function getConnection() {
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (!$conn) {
        die('Connection failed: ' . mysqli_connect_error());
    }
    return $conn;
}

// Fonction pour récupérer les produits
function getProduits($limit = null, $offset = null) {
    $conn = getConnection();
    if ($limit !== null && $offset !== null) {
        $stmt = mysqli_prepare($conn, 'SELECT * FROM produits LIMIT ? OFFSET ?');
        mysqli_stmt_bind_param($stmt, 'ii', $limit, $offset);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $result = mysqli_query($conn, 'SELECT * FROM produits');
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}

// Fonction pour obtenir le nombre total de produits
function getTotalProduits() {
    $conn = getConnection();
    $result = mysqli_query($conn, 'SELECT COUNT(*) as total FROM produits');
    $total = mysqli_fetch_assoc($result);
    return $total['total'];
}

// Fonction pour récupérer un utilisateur par son ID
function getUserById($id) {
    $conn = getConnection();
    $stmt = mysqli_prepare($conn, 'SELECT * FROM utilisateurs WHERE id = ?');
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

// Fonction pour récupérer les produits par catégorie
function getProduitsParCategorie($categorie, $limit = null, $offset = null) {
    $conn = getConnection();
    if ($limit !== null && $offset !== null) {
        $stmt = mysqli_prepare($conn, 'SELECT * FROM produits WHERE categorie = ? LIMIT ? OFFSET ?');
        mysqli_stmt_bind_param($stmt, 'sii', $categorie, $limit, $offset);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $stmt = mysqli_prepare($conn, 'SELECT * FROM produits WHERE categorie = ?');
        mysqli_stmt_bind_param($stmt, 's', $categorie);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}

// Fonction pour obtenir le nombre total de produits par catégorie
function getTotalProduitsParCategorie($categorie) {
    $conn = getConnection();
    $stmt = mysqli_prepare($conn, 'SELECT COUNT(*) as total FROM produits WHERE categorie = ?');
    mysqli_stmt_bind_param($stmt, 's', $categorie);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $total = mysqli_fetch_assoc($result);
    return $total['total'];
}

// Fonction pour récupérer un produit par son ID
function getProduitById($id) {
    $conn = getConnection();
    $stmt = mysqli_prepare($conn, 'SELECT * FROM produits WHERE id = ?');
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

// Fonction pour ajouter un produit
function ajouterProduit($nom, $prix_unitaire, $quantite, $image, $description, $categorie) {
    $conn = getConnection();
    $stmt = mysqli_prepare($conn, 'INSERT INTO produits (nom, prix_unitaire, quantite, image, description, categorie) VALUES (?, ?, ?, ?, ?, ?)');
    mysqli_stmt_bind_param($stmt, 'sdisss', $nom, $prix_unitaire, $quantite, $image, $description, $categorie);
    return mysqli_stmt_execute($stmt);
}

// Fonction pour modifier un produit
function modifierProduit($id, $nom, $prix_unitaire, $quantite, $image, $description, $categorie) {
    $conn = getConnection();
    $stmt = mysqli_prepare($conn, 'UPDATE produits SET nom = ?, prix_unitaire = ?, quantite = ?, image = ?, description = ?, categorie = ? WHERE id = ?');
    mysqli_stmt_bind_param($stmt, 'sdisssi', $nom, $prix_unitaire, $quantite, $image, $description, $categorie, $id);
    return mysqli_stmt_execute($stmt);
}

// Fonction pour supprimer un produit
function supprimerProduit($id) {
    $conn = getConnection();
    $stmt = mysqli_prepare($conn, 'DELETE FROM produits WHERE id = ?');
    mysqli_stmt_bind_param($stmt, 'i', $id);
    return mysqli_stmt_execute($stmt);
}

// Fonction pour inscrire un utilisateur
function inscrire($nom, $prenom, $email, $mot_de_passe, $adresse) {
    $conn = getConnection();
    
    // Vérifier si l'email existe déjà
    $stmt = mysqli_prepare($conn, 'SELECT id FROM utilisateurs WHERE email = ?');
    if (!$stmt) {
        return false;
    }
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if (mysqli_stmt_num_rows($stmt) > 0) {
        // Email déjà existant
        return false;
    }

    // Email n'existe pas, procéder à l'insertion
    $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_BCRYPT);
    $stmt = mysqli_prepare($conn, 'INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, adresse) VALUES (?, ?, ?, ?, ?)');
    if (!$stmt) {
        return false;
    }
    mysqli_stmt_bind_param($stmt, 'sssss', $nom, $prenom, $email, $mot_de_passe_hache, $adresse);
    $result = mysqli_stmt_execute($stmt);
    
    // Vérifier l'erreur d'insertion
    if (!$result) {
        return false;
    }

    return true;
}

// Fonction pour connecter un utilisateur
function connecter($email, $mot_de_passe) {
    $conn = getConnection();
    $stmt = mysqli_prepare($conn, 'SELECT * FROM utilisateurs WHERE email = ?');
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $utilisateur = mysqli_fetch_assoc($result);
    if ($utilisateur && password_verify($mot_de_passe, $utilisateur['mot_de_passe'])) {
        return $utilisateur;
    }
    return false;
}

// Fonction pour vérifier si l'utilisateur est admin
function estAdmin($userId) {
    $conn = getConnection();
    $stmt = mysqli_prepare($conn, 'SELECT role FROM utilisateurs WHERE id = ?');
    mysqli_stmt_bind_param($stmt, 'i', $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $utilisateur = mysqli_fetch_assoc($result);
    return $utilisateur && $utilisateur['role'] == 'admin';
}

// Fonction pour récupérer tous les utilisateurs
function getAllUsers() {
    $conn = getConnection();
    $result = mysqli_query($conn, 'SELECT * FROM utilisateurs');
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Fonction pour supprimer un utilisateur
function supprimerUtilisateur($id) {
    $conn = getConnection();

    // Supprimer les lignes associées dans commande_produits
    $stmt = mysqli_prepare($conn, 'DELETE cp FROM commande_produits cp JOIN commande c ON cp.commande_id = c.id WHERE c.utilisateur_id = ?');
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);

    // Supprimer les lignes associées dans commande
    $stmt = mysqli_prepare($conn, 'DELETE FROM commande WHERE utilisateur_id = ?');
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);

    // Supprimer l'utilisateur
    $stmt = mysqli_prepare($conn, 'DELETE FROM utilisateurs WHERE id = ?');
    mysqli_stmt_bind_param($stmt, 'i', $id);
    return mysqli_stmt_execute($stmt);
}

// Fonction pour modifier le rôle d'un utilisateur
function modifierUtilisateurRole($id, $role) {
    $conn = getConnection();
    $stmt = mysqli_prepare($conn, 'UPDATE utilisateurs SET role = ? WHERE id = ?');
    mysqli_stmt_bind_param($stmt, 'si', $role, $id);
    return mysqli_stmt_execute($stmt);
}

// Fonction pour récupérer le panier
function getPanier($userId) {
    $conn = getConnection();
    $stmt = mysqli_prepare($conn, 'SELECT p.*, cp.quantite FROM panier cp JOIN produits p ON cp.produit_id = p.id WHERE cp.utilisateur_id = ?');
    mysqli_stmt_bind_param($stmt, 'i', $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Fonction pour ajouter au panier
function ajouterAuPanier($userId, $produitId, $quantite) {
    $conn = getConnection();
    $stmt = mysqli_prepare($conn, 'INSERT INTO panier (utilisateur_id, produit_id, quantite) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE quantite = quantite + ?');
    mysqli_stmt_bind_param($stmt, 'iiii', $userId, $produitId, $quantite, $quantite);
    return mysqli_stmt_execute($stmt);
}

// Fonction pour supprimer du panier
function supprimerDuPanier($userId, $produitId) {
    $conn = getConnection();
    $stmt = mysqli_prepare($conn, 'DELETE FROM panier WHERE utilisateur_id = ? AND produit_id = ?');
    mysqli_stmt_bind_param($stmt, 'ii', $userId, $produitId);
    return mysqli_stmt_execute($stmt);
}

// Fonction pour augmenter la quantité dans le panier
function augmenterQuantitePanier($userId, $produitId) {
    $conn = getConnection();
    $stmt = mysqli_prepare($conn, 'UPDATE panier SET quantite = quantite + 1 WHERE utilisateur_id = ? AND produit_id = ?');
    mysqli_stmt_bind_param($stmt, 'ii', $userId, $produitId);
    return mysqli_stmt_execute($stmt);
}

// Fonction pour diminuer la quantité dans le panier
function diminuerQuantitePanier($userId, $produitId) {
    $conn = getConnection();
    $stmt = mysqli_prepare($conn, 'UPDATE panier SET quantite = GREATEST(quantite - 1, 1) WHERE utilisateur_id = ? AND produit_id = ?');
    mysqli_stmt_bind_param($stmt, 'ii', $userId, $produitId);
    return mysqli_stmt_execute($stmt);
}

// Fonction pour créer une commande
function creerCommande($utilisateurId, $panier) {
    $conn = getConnection();
    
    // Calculer le montant total
    $total = 0;
    foreach ($panier as $item) {
        $total += $item['prix_unitaire'] * $item['quantite'];
    }

    // Insertion dans la table `commande`
    $stmt = mysqli_prepare($conn, 'INSERT INTO commande (utilisateur_id, total) VALUES (?, ?)');
    mysqli_stmt_bind_param($stmt, 'id', $utilisateurId, $total);
    mysqli_stmt_execute($stmt);
    $commandeId = mysqli_insert_id($conn);

    // Insertion dans la table `commande_produits`
    foreach ($panier as $item) {
        $stmt = mysqli_prepare($conn, 'INSERT INTO commande_produits (commande_id, produit_id, quantite, prix_unitaire) VALUES (?, ?, ?, ?)');
        mysqli_stmt_bind_param($stmt, 'iiid', $commandeId, $item['id'], $item['quantite'], $item['prix_unitaire']);
        mysqli_stmt_execute($stmt);
    }

    // Vider le panier
    $stmt = mysqli_prepare($conn, 'DELETE FROM panier WHERE utilisateur_id = ?');
    mysqli_stmt_bind_param($stmt, 'i', $utilisateurId);
    mysqli_stmt_execute($stmt);

    return $commandeId;
}

// Fonction pour récupérer les commandes d'un utilisateur
function getCommandesByUtilisateur($utilisateurId) {
    $conn = getConnection();
    $stmt = mysqli_prepare($conn, 'SELECT * FROM commande WHERE utilisateur_id = ? ORDER BY date_commande DESC');
    mysqli_stmt_bind_param($stmt, 'i', $utilisateurId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Fonction pour récupérer les produits d'une commande
function getProduitsByCommande($commandeId) {
    $conn = getConnection();
    $stmt = mysqli_prepare($conn, 'SELECT p.*, cp.quantite, cp.prix_unitaire FROM commande_produits cp JOIN produits p ON cp.produit_id = p.id WHERE cp.commande_id = ?');
    mysqli_stmt_bind_param($stmt, 'i', $commandeId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>