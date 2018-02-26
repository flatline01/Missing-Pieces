(function () {
var canvas = document.getElementById('canvas'),
    context = canvas.getContext('2d');
var debug =document.getElementById('debug');
let X_position = 0;
let Y_position = 0;
context.fillStyle = 'yellow';
context.fillRect(X_position, Y_position, 25, 25);
context.rect(X_position, Y_position, 25, 25);
context.stroke();

debug.value=X_position + " " + Y_position;

function move(event) {
      if ( event.keyCode == 39) {
           X_position += 5;
      }
      if (event.keyCode == 37) {
           X_position -= 5;
       }

	debug.value=X_position + " " + Y_position;
 }

 document.onkeydown= move(e);
 })();