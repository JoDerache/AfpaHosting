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

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))



let message = document.querySelector('#recapForm')

// Permet de récupérer le numéro de chambre dans l'URL
document.querySelectorAll("[data-editer]").forEach((element) => {
    element.addEventListener("click", function() {
    var idChambre = [this.dataset.id]
    var url = document.location.href
    history.pushState('', '', [url +'attribuer/' + idChambre])
    });
});

// Permet de récupérer le numéro de bail dans l'URL
document.querySelectorAll("[data-modifier]").forEach((element) => {
    element.addEventListener("click", function() {
    var idChambre = [this.dataset.id]
    var url = document.location.href
    history.pushState('', '', [url +'modifier/' + idChambre])
    });
});

// Permet de récupérer le numéro de travaux d'une chambre
document.querySelectorAll("[data-travaux]").forEach((element) => {
    element.addEventListener("click", function() {
    var idChambre = [this.dataset.id]
    var url = document.location.href
    history.pushState('', '', [url +'travaux/' + idChambre])

    });
});

document.querySelector('#validForm').addEventListener('click', (e) =>{

    let url = document.location.href
    let name = document.querySelector('#name').value
    let entree = document.querySelector('#dateEntree').value
    let sortie = document.querySelector('#dateSortie').value

    let chambre =  url.charAt(url.length-3) + url.charAt(url.length-2) +  url.charAt(url.length-1)
    

    message.innerHTML = "Voulez vous confirmez ces informations ? <br> Nom du stagiaire : "+ name +
    "<br> Numéro de chambre : "+ chambre
    +"<br> Date d'entrée : "+ entree
    +"<br> Date de sortie : "+ sortie
})

document.querySelectorAll(".fermerAttribution").forEach((element) => {
    element.addEventListener("click", function() {
    window.history.back();
    });
});


if(document.querySelector('.fermerValidationAttribution')){
    document.querySelectorAll(".fermerValidationAttribution").forEach((element) => {
        element.addEventListener("click", function() {
            window.history.go(-1);
        });
    });
}

if(document.querySelector('#isTravaux')){
    document.querySelector('#isTravaux').addEventListener('click',(e) =>{
        if(document.querySelector('#isTravaux').checked ){
            document.querySelector('#selectTravaux').style.display="block"
        }
        else{
            document.querySelector('#selectTravaux').style.display="none"
        }
    })
    
}

///////////////////////////////////////////////////////////////////////////////////////////////////
document.querySelectorAll("[data-toggle]").forEach((element) => {
    element.addEventListener("click", function() {
    var test = [this.dataset.content]
    console.log(test)
    });
});




////////////////////////Circle Progress Libre/////////////////////////////////////////////////////////
let progressBar = document.querySelector('.circular-progress');
let valueContainer = document.querySelector('.value-container');
let progressValue = 0;
let progressEndValue = Math.ceil(valueContainer.innerHTML);
////////////////////////Circle Progress Occupe//////////////////////////////////////////////////////////////////////
let progressBarOccupe = document.querySelector('.circular-progressOccupe');
let valueContainerOccupe = document.querySelector('.value-containerOccupe');
let progressValueOccupe = 0;
let progressEndValueOccupe = Math.ceil(valueContainerOccupe.innerHTML);
////////////////////////Circle Progress Reserve//////////////////////////////////////////////////////////////////////
let progressBarReserve = document.querySelector('.circular-progressReserve');
let valueContainerReserve = document.querySelector('.value-containerReserve');
let progressValueReserve = 0;
let progressEndValueReserve = Math.ceil(valueContainerReserve.innerHTML);
////////////////////////Circle Progress Reserve//////////////////////////////////////////////////////////////////////
let progressBarInutilisable = document.querySelector('.circular-progressInutilisable');
let valueContainerInutilisable = document.querySelector('.value-containerInutilisable');
let progressValueInutilisable = 0;
let progressEndValueInutilisable = Math.ceil(valueContainerInutilisable.innerHTML);

let speed = 25;

let progress = setInterval(() => {
    if(progressEndValue != 0){
        progressValue++;
        valueContainer.classList.remove('hiddenPourcentage')
    }
    else {
        valueContainer.classList.remove('hiddenPourcentage')
    }
    valueContainer.textContent = `${progressValue}%`;
    progressBar.style.background = `conic-gradient(
        #198754 ${progressValue * 3.6}deg,
        #90dbb8 ${progressValue * 3.6}deg
    )`;
    if ((progressValue == progressEndValue) ){
        clearInterval(progress);
    }
}, speed)

let progressOccupe = setInterval(() => {
    if (progressEndValueOccupe !=0){
        progressValueOccupe++;
        valueContainerOccupe.classList.remove('hiddenPourcentage')
    }else {
        valueContainerOccupe.classList.remove('hiddenPourcentage')
    }
    valueContainerOccupe.textContent = `${progressValueOccupe}%`;
    progressBarOccupe.style.background = `conic-gradient(
        #B52C39 ${progressValueOccupe * 3.6}deg,
        #ed959c ${progressValueOccupe * 3.6}deg
    )`;
    if ((progressValueOccupe == progressEndValueOccupe) ){
        clearInterval(progressOccupe);
    }
}, speed)

let progressReserve = setInterval(() => {
    if(progressEndValueReserve != 0){
        progressValueReserve++;
        valueContainerReserve.classList.remove('hiddenPourcentage')
    }
    else {
        valueContainerReserve.classList.remove('hiddenPourcentage')
    }
    valueContainerReserve.textContent = `${progressValueReserve}%`;
    progressBarReserve.style.background = `conic-gradient(
        #FFC107 ${progressValueReserve * 3.6}deg,
        #f7e3a8 ${progressValueReserve * 3.6}deg
    )`;
    if ((progressValueReserve == progressEndValueReserve) ){
        clearInterval(progressReserve);
    }
}, speed)

let progressInutilisable = setInterval(() => {
    if(progressEndValueInutilisable != 0){
        progressValueInutilisable++;
        valueContainerInutilisable.classList.remove('hiddenPourcentage')
    }
    else {
        valueContainerInutilisable.classList.remove('hiddenPourcentage')
    }
    valueContainerInutilisable.textContent = `${progressValueInutilisable}%`;
    progressBarInutilisable.style.background = `conic-gradient(
        #000000 ${progressValueInutilisable * 3.6}deg,
        #C1C1C1 ${progressValueInutilisable * 3.6}deg
    )`;
    if ((progressValueInutilisable == progressEndValueInutilisable) ){
        clearInterval(progressInutilisable);
    }
}, speed)


