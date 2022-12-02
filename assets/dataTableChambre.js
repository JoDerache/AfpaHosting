/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (meteo.css in this case)
import './styles/dataTable.css';


// start the Stimulus application
import './bootstrap';


document.querySelectorAll("[data-editer]").forEach((element) => {
    element.addEventListener("click", function() {
    var idChambre = [this.dataset.id]
    var url = document.location.href
    history.pushState('', '', [url +'attribuer/' + idChambre])
    console.log(document.querySelector('#attribuer_chambre_submit'))
    });
});