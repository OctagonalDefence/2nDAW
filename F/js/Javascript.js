
const digits = new Map();

digits.set(0, "A");
digits.set(1, "X");
digits.set(2, "M");
digits.set(3, "T");
digits.set(4, "B");
digits.set(5, "C");
digits.set(6, "S");
digits.set(7, "O");
digits.set(8, "P");
digits.set(9, "Z");

window.onload = function preparacio() {
    emplenar();
    document.getElementsByTagName("select")[0].addEventListener("change", comprovaCodi);
    document.getElementById("codi").addEventListener("change", comprovaCodi);

    var caracteristiques = Array.from(document.getElementsByClassName("caracteristica"));
    caracteristiques.forEach(element => element.addEventListener("change", function () {comprovarCaracteristiques(caracteristiques);}));


    var ubicacions = Array.from(document.getElementsByName("ubicacio"));
    ubicacions[0].regex = /^P-[0-9]{2}-(E|D){1}$/;
    ubicacions[1].regex = /^EST\+[0-9]{2}\.[0-9]{2}$/;
    ubicacions[2].regex = /^[0-9]{2}\*[A-Z]{3}\*[0-9]{2}\\[0-9]{2}$/i;
    ubicacions.forEach(element => element.addEventListener("change", comprovaUbicacio));

    document.getElementsByTagName('button')[0].addEventListener("click", comprovaFormulari);
}

function emplenar() {
    var selector = document.getElementsByTagName("select")[0];
    var families = ["Pop", "Rock", "Metal", "Classica", "Techno"];

    families = families.sort();
    families.forEach(element => {
        var option = document.createElement("option");
        option.innerHTML = element;
        selector.appendChild(option);
    });

}

function comprovaCodi() {
    var selector = document.getElementsByTagName("select")[0];
    var codi = document.getElementById("codi");

    var digitsCodi = codi.value.split("-")[1];
    var opcio = selector.options[select.selectedIndex].text.toLowerCase();
    var abreviacio = opcio.slice(0, 3);
    var lletraCodi = digits.get(digitsCodi % 10);

    var part1 = new RegExp(`^${abreviacio}`, "i");
    var part2 = new RegExp(`-[0-9]{7}-${lletraCodi}{1}$`);
    var codiFull = part1.test(codi.value) && part2.test(codi.value);

    setImatgeiClasse(codi, codiFull);

}

function comprovarCaracteristiques(caracteristiques) {

    var totesCaracteristiques = caracteristiques.every(element => comprovaCaracteristica(element));

    if (totesCaracteristiques) {
        var fraseCaracteristiques = caracteristiques.map(element => element.value).join("x");
        escriureCaracteristiques(fraseCaracteristiques);
    } 
    
    else {
        borrarCaracteristiques();
    }

}

function escriureCaracteristiques(string) {

    document.getElementsByTagName("span")[0].innerHTML = string;

}

function borrarCaracteristiques() {

    document.getElementsByTagName("span")[0].innerHTML = "";

}

function comprovaCaracteristica(caracteristica) {

    var valor = caracteristica.value;
    console.log(valor);
    var regExp = /^[0-9]+$/;
    const codiFull = regExp.test(valor);

    setClasse(caracteristica, codiFull);
    return codiFull;
}


function comprovaUbicacio(event) {

    var valor = event.currentTarget.value;
    var regExp = event.currentTarget.regex;
    const codiFull = regExp.test(valor);

    setImatgeiClasse(event.currentTarget, codiFull);

}

function setClasse(inputElement, isValid) {

    var validClass = "valid";
    var invalidClass = "invalid";

    if (isValid) {
        inputElement.classList.add(validClass);
        inputElement.classList.remove(invalidClass);
    } 
    
    else {
        inputElement.classList.add(invalidClass);
        inputElement.classList.remove(validClass);

    }
}
function setImatge(inputElement, isValid) {
    var tick = "../F/imatges/tick.png";
    var creu = "../F/imatges/creu.png";
    var imatge = inputElement.nextElementSibling;

    if (isValid) {
        imatge.src = tick;

    } 
    
    else {
        imatge.src = creu;
    }

}

function setImatgeiClasse(inputElement, isValid) {
    setClasse(inputElement, isValid);
    setImatge(inputElement, isValid);

}

function comprovaFormulari() {

    isValid = document.getElementsByClassName("valid").length == 7;

    if (isValid) {
        Resultat();
    } 
    
    else {
        borrarResultat();
        alert("Cal arreglar el formulari");
    }

}

function borrarResultat(){

document.getElementsByClassName("dades")[0].innerHTML = "";

}

function Resultat() {
    var array = [];

    var selector = document.getElementsByTagName("select")[0];
    var familia = selector.options[selector.selectedIndex].text.toLowerCase();
    var codi = document.getElementById("codi").value;
    var nom = document.getElementsByName("nom")[0].value;
    var caracteristiques = Array.from(document.getElementsByClassName("caracteristica")).map(element => element.value).join("x");
    var ubicacio = Array.from(document.getElementsByName("ubicacio")).map(element => element.value).join(" ");
    array.push("Familia: " + familia); array.push("Codi: " + codi); array.push("Nom: " + nom); array.push("Caracteristiques: " + caracteristiques); array.push("Ubicacio: " + ubicacio);

    html = document.getElementsByClassName("dades")[0];

    var string = "";
    array.forEach(function (element) {string += "<p>"+element+"</p>";});
    html.innerHTML = string;
}