let cel = document.querySelector('.cel');

function crearCel(tamany) {
  
  let estrella = document.createElement('div');
  estrella.classList.add('estrella');
  
  let rangAleatori = Math.floor(Math.random() * (10 - 1)) + 1;
  estrella.classList.add(`blink_${rangAleatori}`);
  
  let dimensions = numAleatori(tamany, 'px');
  estrella.style.height = estrella.style.width = dimensions;
  
  estrella.style.left = numAleatori(window.innerWidth, 'px');
  estrella.style.top = numAleatori(window.innerHeight, 'px');
  cel.appendChild(estrella);
}

let [estrellesSlider, tamanySlider] = document.querySelectorAll('.slider');
let [estrelles, tamany] = document.querySelectorAll('.valor');

[estrellesSlider, tamanySlider].forEach(slider => {
  slider.addEventListener('change', () => {
    estrelles.textContent = estrellesSlider.value;
    tamany.textContent = tamanySlider.value;
  });
  slider.addEventListener('change', () => {
    dibuixarEstrelles(estrellesSlider.value, tamanySlider.value);
  });
});

function dibuixarEstrelles(estrelles, tamany) {
  while (cel.firstChild) {
    cel.removeChild(cel.firstChild);
  }
  for (let i = 0; i < estrelles; i++) {
    crearCel(tamany);
  }
}

function numAleatori(range, unit) {
  let numero = Math.floor(Math.random() * range) + 1;
  return `${numero}${unit}`;
}

dibuixarEstrelles(50, 5);

