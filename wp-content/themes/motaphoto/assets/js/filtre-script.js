jQuery(function($) {
    // Fonction pour charger plus de photos
    var loadMorePhotos = function() {
        var page = 1; // Commencez à la page 1 pour le chargement initial
        var canLoadMore = true;

        $('#load-more-photos').on('click', function() {
            if (canLoadMore) {
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
                        nonce: ajax_params.nonce
                    },
                    success: function(response) {
                        var $response = $(response);
                        
                        // Ajouter les classes aux nouvelles photos
                        $response.find('.photos-container-image').each(function() {
                            $(this).addClass('image-container');
                            $(this).addClass('presentation-images-gauche');
                        });
                
                        // Ajouter les classes à l'overlay des nouvelles photos
                        $response.find('.overlay').addClass('overlay');
                
                        $('#photos-container').append($response);
                        page++;
                
                        // Désactiver le bouton "Charger plus" si aucune nouvelle photo n'est chargée
                        if (response.trim() === '') {
                            $('#load-more-photos').attr('disabled', 'disabled').text('Plus aucune photo à charger');
                            canLoadMore = false;
                        }
                    }
                });
                
                
            }
        });
    };

    // Fonction pour filtrer les photos
    var filterPhotos = function() {
        $('.home-filter').on('change', function() {
            // Réinitialiser la pagination
            $('#photos-container').empty(); // Supprimez les photos actuelles
            $('#load-more-photos').removeAttr('disabled').text('Charger plus'); // Réactivez le bouton "Charger plus"
            loadMorePhotos(); // Rechargez les photos avec les nouveaux filtres
        });
    };

    // Appel de la fonction de chargement initial des photos et de la fonction de filtrage au chargement de la page
    loadMorePhotos(); // Charger initialement les photos
    filterPhotos(); // Filtrer les photos lorsqu'un filtre est changé
});
