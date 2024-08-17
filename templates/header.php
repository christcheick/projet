<?php
session_start();
require_once 'includes/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boxing Zone</title>
</head>
<body>
    <div class="page-title">Boxing Zone</div>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="categories.php?categorie=Équipements de protection">Équipements de protection</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="categories.php?categorie=gants">Gants</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="categories.php?categorie=vetements">Vêtements</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="categories.php?categorie=Sacs de sport">Sacs de sport</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="categories.php?categorie=accessoires">Accessoires</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="panier.php">Panier</a>
                    </li>

                    <?php if (isset($_SESSION['utilisateur'])): ?>
                        <?php if (estAdmin($_SESSION['utilisateur']['id'])): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="ajout_produit.php">Ajouter Produit</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="admin.php">Gestion Produits</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="admin_utilisateurs.php">Gestion des utilisateurs</a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <form action="logout.php" method="POST">
                                <button type="submit" class="btn btn-outline-danger">
                                    <div class="sign">
                                        <svg viewBox="0 0 512 512"><path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path></svg>
                                    </div>
                                    <div class="text">Logout</div>
                                </button>
                            </form>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a href="login.php" >
                                <button class="btn btn-primary">
                                    Se connecter
                                    <div class="hoverEffect">
                                        <div></div>
                                    </div>
                                </button>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <form class="d-flex" role="search" action="search.php" method="GET">
                    <input class="form-control me-2" type="search" name="query" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
</body>
</html>