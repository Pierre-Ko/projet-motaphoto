document.addEventListener("DOMContentLoaded", function() {
    var openModalBtn = document.getElementById('openModalBtn');
    var modal = document.getElementById('modale');
    var overlay = document.getElementById('overlay');
    var placementModale = document.getElementById('placement');
    
    // Sélectionne le bouton "Contact" du menu
    var contactButton = document.querySelector('.menu-item-73');
    // Ajoute un écouteur d'événement sur le clic du bouton "Contact"
    contactButton.addEventListener('click', function(event) {
        // Empêche la redirection vers la page de contact
        event.preventDefault();

        // Affiche la modale
        modal.style.display = 'block';
    });

    openModalBtn.addEventListener('click', function() {
        modal.style.display = 'block';
        overlay.classList.add('active');
        placementModale.style.display = 'block'; // Affiche la modale
    });

    var closeModalBtn = document.getElementById('closeModalBtn');
    closeModalBtn.addEventListener('click', function() {
        modal.style.display = 'none';
        overlay.classList.remove('active');
        placementModale.style.display = 'none'; // Cache la modale
    });

    // Nouvel événement de clic pour le bouton "Contact" du menu
    var contactMenuBtn = document.getElementById('menu-item-73');
    contactMenuBtn.addEventListener('click', function() {
        // Ouvrir la modale ici
        modal.style.display = 'block';
        overlay.classList.add('active');
        placementModale.style.display = 'block';
    });
});



