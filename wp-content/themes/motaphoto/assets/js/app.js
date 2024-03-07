//test toto//
document.addEventListener('DOMContentLoaded', function() {
    // Get the button that opens toto.php
    var openTotoBtn = document.getElementById('openTotoBtn');

    // Function to open toto.php
    function openToto() {
        // Change the URL to the correct path of toto.php
        window.location.href = '<?php echo get_template_directory_uri(); ?>template-parts/toto.php';
    }

    // Attach event listener to open toto.php if the button exists
    if (openTotoBtn) {
        openTotoBtn.addEventListener('click', openToto);
    }
});
//ouverture modale//
document.addEventListener('DOMContentLoaded', function () {
    var openModalBtn = document.getElementById('openModalBtn');
    var modal = document.getElementById('myModal');
    var closeModalBtn = document.getElementById('closeModalBtn');
    var overlay = document.getElementById('overlay');

    // Fonction pour ouvrir la modale
    function openModal() {
        if (modal) {
            modal.classList.remove('inactive');
            overlay.classList.remove('inactive');
        }
    }

    // Fonction pour fermer la modale
    function closeModal() {
        if (modal) {
            modal.classList.add('inactive');
            overlay.classList.add('inactive');
        }
    }

    // Attacher un gestionnaire d'événements au bouton d'ouverture de la modale
    if (openModalBtn) {
        openModalBtn.addEventListener('click', openModal);
    }

    // Attacher un gestionnaire d'événements au bouton de fermeture de la modale
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', closeModal);
    }

    // Fermer la modale lorsque l'overlay est cliqué
    if (overlay) {
        overlay.addEventListener('click', closeModal);
    }
});


  //test script//

  jQuery(function($) {


    ///script de personnalisation des filtres

    // Iterate over each select element
    jQuery('select').each(function () {

        // Cache the number of options
        var $this = $(this),
            numberOfOptions = $(this).children('option').length;
    
            // Hides the select element
            $this.addClass('s-hidden');
    
            // Wrap the select element in a div
            $this.wrap('<div class="select"></div>');
    
            // Insert a styled div to sit over the top of the hidden select element
            $this.after('<div class="styledSelect"></div>');
    
            // Cache the styled div
            var $styledSelect = $this.next('div.styledSelect');
    
            // Show the first select option in the styled div
            $styledSelect.text($this.children('option').eq(0).text());
    
            // Insert an unordered list after the styled div and also cache the list
            var $list = $('<ul />', {
                'class': 'options'
            }).insertAfter($styledSelect);
    
            // Insert a list item into the unordered list for each select option
            for (var i = 0; i < numberOfOptions; i++) {
                $('<li />', {
                    text: $this.children('option').eq(i).text(),
                    rel: $this.children('option').eq(i).val()
                }).appendTo($list);
            }
    
            // Cache the list items
            var $listItems = $list.children('li');
    
            // Show the unordered list when the styled div is clicked (also hides it if the div is clicked again)
            $styledSelect.click(function (e) {
                e.stopPropagation();
                $('div.styledSelect.active').each(function () {
                    $(this).removeClass('active').next('ul.options').hide();
                });
                $(this).toggleClass('active').next('ul.options').toggle();
            });
    
            // Hides the unordered list when a list item is clicked and updates the styled div to show the selected list item
            // Updates the select element to have the value of the equivalent option
            $listItems.click(function (e) {
                e.stopPropagation();
                $styledSelect.text($(this).text()).removeClass('active');
                $this.val($(this).attr('rel'));
                $list.hide();
                /* alert($this.val()); Uncomment this for demonstration! */
            });
    
            // Hides the unordered list when clicking outside of it
            $(document).click(function () {
                $styledSelect.removeClass('active');
                $list.hide();
            });
    
        });

    //script charger plus et changement des filtres
    var page = 2;
    var canLoadMore = true;

    // Charger plus de photos au clic sur le bouton "Charger plus"
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
                    nonce: ajax_obj.load_more_photos_nonce,
                },
                success: function(response) {
                    $('#photos-container').append(response);
                    page++;
                }
            });
        }
    });

    // Filtrer les photos lorsqu'un filtre est changé
    $('.options li').on('click', function() {
        // Réinitialiser la pagination
        page = 1;

        // Réinitialiser les photos affichées
        $('#photos-container').empty();

        // Charger les nouvelles photos avec les filtres actuels
        $('#load-more-photos').trigger('click');
    });

});
