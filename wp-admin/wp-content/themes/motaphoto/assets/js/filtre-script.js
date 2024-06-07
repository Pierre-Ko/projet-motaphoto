jQuery(function($) {
    // Définir un tableau pour stocker les IDs des photos chargées
    var loadedPhotoIds = [];

    // Fonction pour charger plus de photos
    var loadMorePhotos = function() {
        var page = 1; // Commencez à la page 1 pour le chargement initial

        // Fonction pour effectuer la requête AJAX
        var performAjaxRequest = function() {
            var format = $('#format-select').val();
            var categorie = $('#categorie-select').val();
            var order = $('#order-select').val();

            $.ajax({
                url: ajax_obj.ajaxurl,
                type: 'POST',
                data: {
                    action: 'load_more_photos',
                    page: page,
                    format: format,
                    categorie: categorie,
                    order: order,
                    loaded_photo_ids: loadedPhotoIds.join(','), // Transmettre les IDs des photos déjà chargées
                    nonce: ajax_params.nonce
                },
                success: function(response) {
                    

                    if (response.success) {
                        // Vérifier si la réponse contient le contenu attendu
                        if (response.data && response.data.content) {
                            // Ajouter le contenu HTML des nouvelles photos au conteneur
                            $('#photos-container').append(response.data.content);
                        }
                        
                        // Mettre à jour les IDs des photos déjà chargées
                        if (response.data && response.data.references) {
                            loadedPhotoIds = response.data.references;
                        }
                        
                        page++; // Mettre à jour le numéro de la page
                    } else {
                        // Désactiver le bouton "Charger plus" s'il n'y a plus de nouvelles photos
                        $('#load-more-photos').attr('disabled', 'disabled').text('Plus aucune photo à charger');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erreur AJAX:', error); // Afficher les erreurs dans la console
                }
            });
        };

        // Attacher l'événement de clic sur le bouton "Charger plus"
        $('#load-more-photos').on('click', performAjaxRequest);

        // Charger initialement les photos
        performAjaxRequest();
    };

    // Fonction pour filtrer les photos
    var filterPhotos = function() {
        $('.custom-select .select-items div').on('click', function() {
            var selectedOption = $(this).html(); // Récupérer la valeur de l'option sélectionnée
            // Réinitialiser la pagination
            $('#photos-container').empty(); // Supprimez les photos actuelles
            $('#load-more-photos').removeAttr('disabled').text('Charger plus'); // Réactivez le bouton "Charger plus"
            loadedPhotoIds = []; // Réinitialiser les IDs des photos chargées
            loadMorePhotos(); // Rechargez les photos avec les nouveaux filtres
        });
    };
    
    

    // Appel de la fonction de filtrage au chargement de la page
    filterPhotos(); // Filtrer les photos lorsqu'un filtre est changé

    // Appel de la fonction de chargement initial des photos et de la fonction de filtrage au chargement de la page
    loadMorePhotos(); // Charger initialement les photos
    
});

