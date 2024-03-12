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
