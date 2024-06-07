//lightbox
document.addEventListener('click', function(event) {
    // Vérifier si l'élément cliqué est une icône fullscreen
    if (event.target && event.target.classList.contains('icon-fullscreen')) {
        // Récupérer l'URL de l'image à partir de l'attribut data-image-url de l'icône
        const imageUrl = event.target.getAttribute('data-image-url');
        // Ouvrir la lightbox avec l'image correspondante
        openLightbox(imageUrl); // Passer l'URL de l'image en tant que paramètre
    }
});

function openLightbox(imageUrl) {
    const overlay = document.querySelector('.lightbox-overlay');
    const modale = document.querySelector('.lightbox-modale');
    var closeIcon = document.querySelector('.lightbox-cross');
    var previousButton = document.querySelector('#lightbox-previous');
    var nextButton = document.querySelector('#lightbox-next');
    
    if (overlay && modale && closeIcon && previousButton && nextButton) {
        overlay.style.display = 'block';
        modale.style.display = 'block';

        // Modifier l'attribut src de l'élément img de la lightbox avec l'URL de l'image
        const lightboxImage = document.getElementById('lightbox-info-img');
        lightboxImage.src = imageUrl;

        // Empêcher le lien de rediriger vers la page single-photo
        event.preventDefault();

        // Mettre à jour les informations sur la référence et la catégorie
        var currentIndex = dataPhotos.findIndex(function(photo) {
            return photo.thumbnail === imageUrl;
        });
        if (currentIndex !== -1) {
            document.getElementById('lightbox-info-ref').textContent = dataPhotos[currentIndex].reference;
            document.getElementById('lightbox-info-cat').textContent = dataPhotos[currentIndex].categorie;
        }

        // Ajoute un gestionnaire d'événement au clic sur l'élément de croix
        closeIcon.addEventListener('click', function() {
            // Ferme la lightbox
            overlay.style.display = 'none';
            modale.style.display = 'none';
        });
    } else {
        console.error('Certains éléments de la lightbox sont manquants.');
    }
}
    
    


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
