
const width = 1100;
const height = 500;
const maxStarRadius = 6/3.7;
const minStarDistance =  Math.floor(Math.random() * (10 - 1 + 1)) + 1;;
const minStarOpacity = 0.1;
const maxStarOpacity = 0.7;
const stars = createStars(width, height, 30);
const canvas = document.querySelector("#canvas");
const ctx = canvas.getContext("2d");
canvas.width = width;
canvas.height = height;

let counter = 0;

function randomInt(max) {
  return Math.floor(Math.random() * max);
}

function randomInt(min) {
  return Math.floor(Math.random() * min);
}
  


function createStars(width, height, spacing) {
  const stars = [];
  

  for (let x = 0; x < width; x += spacing) {
    for (let y = 0; y < height; y += spacing) {
      const star = {
        x: x + randomInt(spacing),
        y: y + randomInt(spacing),
        r: Math.random() * maxStarRadius
      };
      
      stars.push(star);
    }
  }
  return stars;
}

function getOpacity(factor) {
  const opacityIncrement =
    (maxStarOpacity - minStarOpacity) * Math.abs(Math.sin(factor));
  const opacity = minStarOpacity + opacityIncrement;
  return opacity;
}

function fillCircle(ctx, x, y, r, fillStyle) {
  ctx.beginPath();
  
  ctx.fillStyle = fillStyle;
  ctx.arc(x, y, r, 0, Math.PI * 2);
  ctx.fill();
}

function render() {
 
  ctx.fillRect(0, 0, width, height);
  stars.forEach(function(star) {
    const e = "#" + ("00001" + Math.floor(Math.random() * Math.pow(16, 6)).toString(16)).slice(-6);
    const x = star.x;
    const y = star.y;
    const r = star.r;
    fillCircle(ctx, x, y, r, e);
    
  });
}

function moveRows(){
  for(var i = 0; i < objects.length; i++){
    removeCell(stars[i][0], objects[i][1]);
    objects[i][1] += length;
  }
}

function removeCell(x, y){
  ctx.clearRect(x, y, length, length);
}

function moveRows2(){
  for(var i = 0; i < objects.length; i--){
    removeCell(objects[i][0], objects[i][1]);
    objects[i][1] += length;
  }
}
render();
