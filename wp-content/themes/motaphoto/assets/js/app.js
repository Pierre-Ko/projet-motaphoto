//lightbox

document.addEventListener('DOMContentLoaded', function() {
    const iconFullscreen = document.querySelectorAll('.icon-fullscreen');
    if (iconFullscreen) {
        iconFullscreen.forEach(icon => {
            icon.addEventListener('click', function(event) {
                event.preventDefault();
                const imageUrl = this.getAttribute('data-image-url'); // Récupérer l'URL de l'image à afficher
                openLightbox(imageUrl);
            });
        });
    }


    function openLightbox() {
        const overlay = document.querySelector('.lightbox-overlay');
        const modale = document.querySelector('.lightbox-modale');
        var closeIcon = document.querySelector('.lightbox-cross');
        var previousButton = document.querySelector('#lightbox-previous');
        var nextButton = document.querySelector('#lightbox-next');
    
        if (overlay && modale && closeIcon && previousButton && nextButton) {
            overlay.style.display = 'block';
            modale.style.display = 'block';
    
            // Empêcher le lien de rediriger vers la page single-photo
            event.preventDefault();
    
            // Ajoute un gestionnaire d'événement au clic sur l'élément de croix
            closeIcon.addEventListener('click', function() {
                // Ferme la lightbox
                overlay.style.display = 'none';
                modale.style.display = 'none';
            });
    
            // Gestionnaire d'événement pour le bouton précédent
            previousButton.addEventListener('click', function() {
                // Mettez en œuvre la logique pour afficher l'image précédente
                console.log('Image précédente');
            });
    
            // Gestionnaire d'événement pour le bouton suivant
            nextButton.addEventListener('click', function() {
                // Mettez en œuvre la logique pour afficher l'image suivante
                console.log('Image suivante');
            });
        } else {
            console.error('Certains éléments de la lightbox sont manquants.');
        }
    }
    
    
});

//navigation dans la lightbox

function rightLightbox() {
    // Sélectionner l'image actuellement affichée dans la lightbox
    var currentImage = document.getElementById('lightbox-info-img');
    
    // Récupérer l'URL de l'image actuelle
    var currentImageUrl = currentImage.src;
    
    // Trouver l'index de l'image actuelle dans le tableau de données des photos
    var currentIndex = dataPhotos.findIndex(function(photo) {
        return photo.thumbnail === currentImageUrl;
    });
    
    // Vérifier si l'image actuelle est la dernière
    if (currentIndex === dataPhotos.length - 1) {
        // Si c'est le cas, revenir au début du tableau
        currentIndex = 0;
    } else {
        // Sinon, passer à l'image suivante
        currentIndex++;
    }
    
    // Sélectionner l'URL de l'image suivante dans le tableau de données des photos
    var nextImageUrl = dataPhotos[currentIndex].thumbnail;
    
    // Mettre à jour l'attribut src de l'élément img de la lightbox avec l'URL de l'image suivante
    currentImage.src = nextImageUrl;
    
    // Mettre à jour les informations sur la référence et la catégorie de la nouvelle image
    document.getElementById('lightbox-info-ref').textContent = dataPhotos[currentIndex].reference;
    document.getElementById('lightbox-info-cat').textContent = dataPhotos[currentIndex].categorie;
}
function leftLightbox() {
    // Sélectionner l'image actuellement affichée dans la lightbox
    var currentImage = document.getElementById('lightbox-info-img');
    
    // Récupérer l'URL de l'image actuelle
    var currentImageUrl = currentImage.src;
    
    // Trouver l'index de l'image actuelle dans le tableau de données des photos
    var currentIndex = dataPhotos.findIndex(function(photo) {
        return photo.thumbnail === currentImageUrl;
    });
    
    // Vérifier si l'image actuelle est la première
    if (currentIndex === 0) {
        // Si c'est le cas, passer à la dernière image du tableau
        currentIndex = dataPhotos.length - 1;
    } else {
        // Sinon, passer à l'image précédente
        currentIndex--;
    }
    
    // Sélectionner l'URL de l'image précédente dans le tableau de données des photos
    var previousImageUrl = dataPhotos[currentIndex].thumbnail;
    
    // Mettre à jour l'attribut src de l'élément img de la lightbox avec l'URL de l'image précédente
    currentImage.src = previousImageUrl;
    
    // Mettre à jour les informations sur la référence et la catégorie de la nouvelle image
    document.getElementById('lightbox-info-ref').textContent = dataPhotos[currentIndex].reference;
    document.getElementById('lightbox-info-cat').textContent = dataPhotos[currentIndex].categorie;
}

//Modale contact
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

// MENU BURGER
document.addEventListener('DOMContentLoaded', function() {
    const burgerButton = document.querySelector('.burger');
    const navBurger = document.querySelector('#nav-burger');

    burgerButton.addEventListener('click', function() {
        navBurger.classList.toggle('show-nav');

        // Ajouter une condition pour changer la propriété display de nav_burger
        if (navBurger.classList.contains('show-nav')) {
            navBurger.style.display = 'block'; // Afficher le menu burger
            burgerButton.classList.add('open'); // Ajouter la classe open au bouton burger
        } else {
            navBurger.style.display = 'none'; // Masquer le menu burger
            burgerButton.classList.remove('open'); // Supprimer la classe open du bouton burger
        }
    });

    
});

