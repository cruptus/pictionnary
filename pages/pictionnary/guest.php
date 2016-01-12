<?php
use core\App;
App::getAuth()->redirect();
if(!isset($_GET['dessin']) && !is_numeric($_GET['dessin'])){
    header('Location: '.$dir.'/pictionnary/home');
    exit();
}

$dessin = App::getDataBase()->prepare('SELECT * FROM drawings WHERE id = :id AND id_user = :user_id',
            [
                'id' => $_GET['dessin'],
                'user_id' => App::getAuth()->idAuth()
            ], true);
if($dessin == false){
    header('Location: '.$dir.'/pictionnary/home');
    exit();
} ?>

<div class="row">
    <div class="col-xs-12 content">
        <h1>Mon dessin : <?= $dessin->nom; ?></h1>
        <div class="col-xs-12 text-center">
            <canvas width="350" height="350" id="myCanvas" style="border: 1px solid grey;"></canvas>
        </div>
        <div class="col-xs-12 text-center">
            <a href="<?= $dir.'/pictionnary/home'; ?>" class="btn btn-primary">Retour</a>
        </div>
    </div>
</div>
<script>
    var size, color;
    var commands = <?= $dessin->commands; ?>;

    var setColor = function() {
        color = document.getElementById('color').value;
    };

    var setSize = function() {
        size = document.getElementById('size').value;
    };

    window.onload = function() {
        var canvas    = document.getElementById('myCanvas');
        canvas.width  = 350;
        canvas.height = 350;
        var context   = canvas.getContext('2d');

        var draw = function(c) {
            context.beginPath();
            context.fillStyle = c.color;
            context.arc(c.x, c.y, c.size, 0, 2 * Math.PI);
            context.fill();
            context.closePath();
        };

        var clear = function() {
            context.clearRect(0, 0, canvas.width, canvas.height);
        };

        var i = 0;
        var iterate = function() {
            if (i >= commands.length) {
                return;
            }
            var c = commands[i];

            switch (c.command) {
                case "draw":
                    draw(c);
                    break;
                case "clear":
                    clear();
                    break;
                default:
                    console.error("cette commande n'existe pas "+ c.command);
            }

            i++;
            setTimeout(iterate,5);
        };
        iterate();

    };

        document.getElementById('picturename').onkeyup = function(){
            if(document.getElementById('picturename').value.length > 2)
                document.getElementById('validate').disabled = false;
            else
                document.getElementById('validate').disabled = true;

        };

        document.getElementById('validate').onclick = function() {
            document.getElementById('commands').value = JSON.stringify(commands);
            document.getElementById('picture').value = canvas.toDataURL();
        };
</script>