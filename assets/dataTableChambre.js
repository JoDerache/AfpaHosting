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
let message = document.querySelector('#recapForm')


document.querySelectorAll("[data-editer]").forEach((element) => {
    element.addEventListener("click", function() {
    var idChambre = [this.dataset.id]
    var url = document.location.href
    history.pushState('', '', [url +'attribuer/' + idChambre])
    });
});

document.querySelectorAll("[data-modifier]").forEach((element) => {
    element.addEventListener("click", function() {
    var idChambre = [this.dataset.id]
    var url = document.location.href
    history.pushState('', '', [url +'modifier/' + idChambre])
    });
});


document.querySelector('#validForm').addEventListener('click', (e) =>{

    let url = document.location.href
    let name = document.querySelector('#name').value
    let entree = document.querySelector('#dateEntree').value
    let sortie = document.querySelector('#dateSortie').value
    let status = document.querySelector('#status').value

    let chambre =  url.charAt(url.length-3) + url.charAt(url.length-2) +  url.charAt(url.length-1)
    

    message.innerHTML = "Voulez vous confirmez ces informations ? <br> Nom du stagiaire : "+ name +
    "<br> Numéro de chambre : "+ chambre
    +"<br> Date d'entrée : "+ entree
    +"<br> Date de sortie : "+ sortie
})

document.querySelector('#fermerAttributionChambre').addEventListener('click', (e) =>{
    window.history.back();
})

if(document.querySelector('#fermerValidationAttributionChambre')){
    document.querySelector('#fermerValidationAttributionChambre').addEventListener('click', (e) =>{
        window.history.go(-1);
    })
}
