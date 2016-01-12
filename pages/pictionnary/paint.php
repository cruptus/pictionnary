<?php
use core\App;
use core\Validator;
App::getAuth()->redirect();
$donne = App::getDataBase()->prepare('SELECT couleur FROM users WHERE id = :id', ['id' => App::getAuth()->idAuth()], true);

if(!empty($_POST)){
    $validator = new Validator($_POST);
    $validator->isAlphaNumeric('picturename', 'Format du nom incorrect');
    if($validator->isValid()){
        $req = App::getDataBase()->insert('INSERT INTO drawings (id_user, commands, dessin, nom)
                                           VALUES (:id_user, :commands, :dessin, :nom)',
                    [
                        'id_user'  => App::getAuth()->idAuth(),
                        'commands' => $_POST['commands'],
                        'dessin'   => $_POST['picture'],
                        'nom'      => $_POST['picturename']
                    ]
                );
        header("Location: $dir/pictionnary/home");
        exit();

    }
}
?>
<div class="row">
    <div class="col-xs-12 content">
        <h1>Mon dessin</h1>
        <form class="form-horizontal" method="post">
            <div class="form-group">
                <label for="size" class="col-sm-2 control-label">Taille</label>
                <div class="col-sm-10">
                    <select id="size" name="size" class="form-control">
                        <option value="8" selected>8</option>
                        <option value="20">20</option>
                        <option value="44">44</option>
                        <option value="90">90</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="color" class="col-sm-2 control-label">Color</label>
                <div class="col-sm-10">
                    <input type="color" name="color" id="color" class="form-control" value="<?= '#'.$donne->couleur; ?>" />
                </div>
            </div>
            <div class="col-xs-12 text-center">
                <canvas width="350" height="350" id="myCanvas" style="border: 1px solid grey;"></canvas>
            </div>
            <div class="col-xs-12">
                <div class="form-group">
                    <label for="picturename" class="col-sm-2 control-label">Nom :</label>
                    <div class="col-sm-10">
                        <input type="text" name="picturename" id="picturename" pattern="[a-zA-Z0-9]{2,20}" class="form-control" placeholder="Caractère AlphaNumérique" />
                    </div>
                </div>
            </div>
            <div class="col-xs-12 text-center">
                <button class="btn btn-danger" id="restart">Réinitialisé</button>
                <button class="btn btn-primary" id="validate">Enregistrer</button>
                <input type="hidden" id="commands" name="commands"/>
                <input type="hidden" id="picture" name="picture"/>
            </div>
        </form>
    </div>
</div>
<script>
    var sizes = [8, 20, 44, 90];
    var size, color;
    var commands = [];

    var setColor = function() {
        color = document.getElementById('color').value;
    };

    var setSize = function() {
        size = document.getElementById('size').value;
    };

    window.onload = function() {
        document.getElementById('validate').disabled = true;
        var canvas    = document.getElementById('myCanvas');
        canvas.width  = 350;
        canvas.height = 350;
        var context   = canvas.getContext('2d');

        setSize();
        setColor();

        document.getElementById('size').onchange  = setSize;
        document.getElementById('color').onchange = setColor;

        var isDrawing = false;

        var startDrawing = function(e) {
            isDrawing = true;
        };

        var stopDrawing = function(e) {
            isDrawing = false;
        };

        var draw = function(e) {
            if (isDrawing) {
                var rect = canvas.getBoundingClientRect();
                commands.push({
                    command : "draw",
                    x : e.clientX - rect.left,
                    y : e.clientY - rect.top,
                    size: size / 2,
                    color: color
                });

                context.beginPath();
                context.fillStyle = color;
                context.arc(e.clientX - rect.left, e.clientY - rect.top, size / 2, 0, 2 * Math.PI);
                context.fill();
                context.closePath();
            }
        };

        canvas.onmousedown = startDrawing;
        canvas.onmouseout  = stopDrawing;
        canvas.onmouseup   = stopDrawing;
        canvas.onmousemove = draw;

        document.getElementById('restart').onclick = function() {
            commands.push({
                command : "clear"
            });

            context.clearRect(0, 0, canvas.width, canvas.height);
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
    };
</script>

