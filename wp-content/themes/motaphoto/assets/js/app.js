document.addEventListener("DOMContentLoaded", function() {
    var openModalBtn = document.getElementById('openModalBtn');
    var modal = document.getElementById('modale');
    var overlay = document.getElementById('overlay');
    var placementModale = document.getElementById('placement');
    
    // Sélectionne le bouton "Contact" du menu
    var contactButton = document.getElementById('menu-item-73');
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

        // Récupérer la référence de la photo
        var referenceElement = document.querySelector('.photo-informations p:nth-child(2)');
        if (referenceElement) {
            var referenceText = referenceElement.textContent.trim();
            // Diviser la chaîne en fonction de la séquence ":"
            var referenceParts = referenceText.split(':');
            if (referenceParts.length > 1) {
                var reference = referenceParts[1].trim(); // Récupérer la partie après le ":"
                // Pré-remplir le champ de référence dans le formulaire de la modale
                var referenceInput = document.querySelector('input[name="your-subject"]');
                if (referenceInput) {
                    referenceInput.value = reference;
                } else {
                    console.error('Le champ de référence n\'a pas été trouvé.');
                }
            } else {
                console.error('La référence n\'a pas été trouvée dans le format attendu.');
            }
        } else {
            console.error('Élément contenant la référence non trouvé.');
        }
    });

    var closeModalBtn = document.getElementById('closeModalBtn');
    closeModalBtn.addEventListener('click', function() {
        modal.style.display = 'none';
        overlay.classList.remove('active');
        placementModale.style.display = 'none'; // Cache la modale
    });

    // Fermer la modale lorsque l'utilisateur clique en dehors de celle-ci
    overlay.addEventListener('click', function(event) {
        if (event.target === overlay) {
            modal.style.display = 'none';
            overlay.classList.remove('active');
            placementModale.style.display = 'none'; // Cache la modale
        }
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

// filtres page accueil

//charger plus
