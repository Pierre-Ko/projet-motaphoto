

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



//Personalisation des filtres

var x, i, j, l, ll, selElmnt, a, b, c;
/*look for any elements with the class "custom-select":*/
x = document.getElementsByClassName("custom-select");
l = x.length;
for (i = 0; i < l; i++) {
  selElmnt = x[i].getElementsByTagName("select")[0];
  ll = selElmnt.length;
  /*for each element, create a new DIV that will act as the selected item:*/
  a = document.createElement("DIV");
  a.setAttribute("class", "select-selected");
  a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
  x[i].appendChild(a);
  /*for each element, create a new DIV that will contain the option list:*/
  b = document.createElement("DIV");
  b.setAttribute("class", "select-items select-hide");
  for (j = 1; j < ll; j++) {
    /*for each option in the original select element,
    create a new DIV that will act as an option item:*/
    c = document.createElement("DIV");
    c.innerHTML = selElmnt.options[j].innerHTML;
    c.addEventListener("click", function(e) {
        /*when an item is clicked, update the original select box,
        and the selected item:*/
        var y, i, k, s, h, sl, yl;
        s = this.parentNode.parentNode.getElementsByTagName("select")[0];
        sl = s.length;
        h = this.parentNode.previousSibling;
        for (i = 0; i < sl; i++) {
          if (s.options[i].innerHTML == this.innerHTML) {
            s.selectedIndex = i;
            h.innerHTML = this.innerHTML;
            y = this.parentNode.getElementsByClassName("same-as-selected");
            yl = y.length;
            for (k = 0; k < yl; k++) {
              y[k].removeAttribute("class");
            }
            this.setAttribute("class", "same-as-selected");
            break;
          }
        }
        h.click();
    });
    b.appendChild(c);
  }
  x[i].appendChild(b);
  a.addEventListener("click", function(e) {
      /*when the select box is clicked, close any other select boxes,
      and open/close the current select box:*/
      e.stopPropagation();
      closeAllSelect(this);
      this.nextSibling.classList.toggle("select-hide");
      this.classList.toggle("select-arrow-active");
    });
}
function closeAllSelect(elmnt) {
  /*a function that will close all select boxes in the document,
  except the current select box:*/
  var x, y, i, xl, yl, arrNo = [];
  x = document.getElementsByClassName("select-items");
  y = document.getElementsByClassName("select-selected");
  xl = x.length;
  yl = y.length;
  for (i = 0; i < yl; i++) {
    if (elmnt == y[i]) {
      arrNo.push(i)
    } else {
      y[i].classList.remove("select-arrow-active");
    }
  }
  for (i = 0; i < xl; i++) {
    if (arrNo.indexOf(i)) {
      x[i].classList.add("select-hide");
    }
  }
}
/*if the user clicks anywhere outside the select box,
then close all select boxes:*/
document.addEventListener("click", closeAllSelect);


