document.addEventListener('DOMContentLoaded', function() {
    // Afficher une alerte au clic sur un bouton Ajouter au panier
    document.querySelectorAll('.btn-success').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            alert('Produit ajouté au panier!');
        });
    });

    // Ajouter une animation pour les cartes de produits
    document.querySelectorAll('.card').forEach(function(card) {
        card.addEventListener('mouseover', function() {
            card.classList.add('shadow-lg');
        });
        card.addEventListener('mouseout', function() {
            card.classList.remove('shadow-lg');
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector('.banter-loader').style.display = 'none';
    });
    
});
