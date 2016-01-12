<?php
use core\App;
App::getAuth()->redirect();
if(!empty($_POST)){
    if(is_numeric($_POST['dessin'])){
        $donne = App::getDataBase()->prepare('SELECT id FROM drawings WHERE id = :id AND id_user = :user',
            [
                'id' => $_POST['dessin'],
                'user' => App::getAuth()->idAuth()
            ], true);
        if($donne){
            $donne = App::getDataBase()->insert('DELETE FROM drawings WHERE id = :id',
                [
                    'id' => $_POST['dessin']
                ]);
        }
    }
}
?>
<div class="col-xs-12 content">
    <h1>Mon profil</h1>
    <?php $donne = App::getDataBase()->prepare('SELECT prenom, nom, profilepic FROM users WHERE id = :id', ['id' => App::getAuth()->idAuth()], true);  ?>
    <div class="col-xs-5 col-sm-3 col-md-2">
        <img src="<?= empty($donne->profilepic) ? $dir.'/images/default.png' : $donne->profilepic; ?>" alt="image profil" class="img-thumbnail" />
    </div>
    <div class="col-xs-7 col-sm-9 col-md-10">
        <h2><?= htmlspecialchars($donne->prenom. ' '.$donne->nom) ?></h2>
    </div>
</div>
<div class="col-xs-12 content">
    <div class="row">
        <div class="col-xs-8">
            <h1>Mes oeuvres</h1>
        </div>
        <div class="col-xs-4 text-right" style="padding-top: 10px;">
            <a href="<?= $dir.'/pictionnary/paint'; ?>" class="btn btn-info"><i class="glyphicon glyphicon-file"></i> Nouveau</a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table text-center">
            <thead>
            <tr>
                <td>Nom du dessin</td>
                <td>Voir</td>
                <td>Supprimer</td>
            </tr>
            </thead>
            <tbody>
                <?php $donne = App::getDataBase()->prepare('SELECT * FROM drawings WHERE id_user = :id', ['id' => App::getAuth()->idAuth()]);
                if($donne == false){ ?>
                    <tr>
                        <td colspan="3">Pas de dessin.</td>
                    </tr>
                <?php }else {
                    foreach ($donne as $draw) { ?>
                        <tr>
                            <td><?= $draw->nom; ?></td>
                            <td><a href="<?= $dir.'/pictionnary/guest/'.$draw->id; ?>" class="btn btn-primary"><i class="glyphicon glyphicon-eye-open"></i></a></td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="dessin" value="<?= $draw->id; ?>"/>
                                    <button class="btn btn-danger">
                                        <i class="glyphicon glyphicon-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php }
                } ?>
            </tbody>
        </table>
    </div>
</div>