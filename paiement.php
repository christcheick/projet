<?php
session_start();
include 'templates/header.php';
require_once 'includes/functions.php'; // Assurez-vous que les fonctions nécessaires sont définies ici

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur'])) {
    echo "<script>window.location.href = 'login.php';</script>";
    exit();
}

$userId = $_SESSION['utilisateur']['id'];
$panier = getPanier($userId);

// Traitement du formulaire de paiement
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les informations de paiement (non utilisées dans cet exemple)
    $cardName = $_POST['cardName'];
    $cardNumber = $_POST['cardNumber'];
    $expiryDate = $_POST['expiryDate'];
    $cvv = $_POST['cvv'];

    // Traitement du paiement ici (simulation)
    // ...

    // Créer la commande après le paiement
    $commandeId = creerCommande($userId, $panier);

    echo "<script>alert('Paiement réussi ! Votre numéro de commande est $commandeId.'); window.location.href = 'index.php';</script>";
    exit();
}
?>

<div class="container mt-5">
    <h1 class="text-center">Paiement</h1>
    <form method="post" class="max-w-xs mx-auto">
        <div class="group">
            <div class="flex flex-col justify-around bg-gray-800 p-4 border border-white border-opacity-30 rounded-lg shadow-md max-w-xs mx-auto">
                <div class="flex flex-row items-center justify-between mb-3">
                    <input class="input w-full h-10 border-none outline-none text-sm bg-gray-800 text-white font-semibold caret-orange-500 pl-2 mb-3 flex-grow" type="text" name="cardName" id="cardName" placeholder="Nom complet" required>
                    <div class="flex items-center justify-center relative w-14 h-9 bg-gray-800 border border-white border-opacity-20 rounded-md">
                        <svg class="text-white fill-current" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 48 48">
                            <path fill="#ff9800" d="M32 10A14 14 0 1 0 32 38A14 14 0 1 0 32 10Z"></path>
                            <path fill="#d50000" d="M16 10A14 14 0 1 0 16 38A14 14 0 1 0 16 10Z"></path>
                            <path fill="#ff3d00" d="M18,24c0,4.755,2.376,8.95,6,11.48c3.624-2.53,6-6.725,6-11.48s-2.376-8.95-6-11.48 C20.376,15.05,18,19.245,18,24z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex flex-col space-y-3">
                    <input class="input w-full h-10 border-none outline-none text-sm bg-gray-800 text-white font-semibold caret-orange-500 pl-2" type="text" name="cardNumber" id="cardNumber" placeholder="0000 0000 0000 0000" required>
                    <div class="flex flex-row justify-between">
                        <input class="input w-full h-10 border-none outline-none text-sm bg-gray-800 text-white font-semibold caret-orange-500 pl-2" type="text" name="expiryDate" id="expiryDate" placeholder="MM/AA" required>
                        <input class="input w-full h-10 border-none outline-none text-sm bg-gray-800 text-white font-semibold caret-orange-500 pl-2" type="text" name="cvv" id="cvv" placeholder="CVV" required>
                    </div>
                </div>
            </div>
        </div>
        <input type="submit" class="btn btn-primary buy" value="Payer">
    </form>
</div>

<?php
include 'templates/footer.php';
?>