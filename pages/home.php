<?php
use core\Validator;
use core\App;
if(App::getAuth()->isConnect()){
    header('Location: '.$dir.'/pictionnary/home');
    exit();
}


if(!empty($_POST)) {
    $validator = new Validator($_POST);
    $validator->isEmail('email', 'Email non valide');
    $validator->isPassword('passwd', 'Mot de passe invalide');
    if ($validator->isValid()) {
        echo 'ok';
        if(!App::getAuth()->login(App::getDataBase(), $_POST['email'], $_POST['passwd']))
            $errors = ['Email ou mot de passe incorrect'];
    } else {
        $errors = $validator->getErrors();
    }
} ?>
<div class="col-md-offset-2 col-md-8 content">
    <form action="<?= $dir; ?>/home" method="post" name="connexion">
        <h1>Connexion</h1>
        <?php if(!empty($errors)){ ?>
            <div class="col-md-12">
                <div class="alert alert-danger">
                    <p>Des erreurs ont été rencontrées :</p>
                    <ul>
                        <?php foreach($errors as $error){ ?>
                            <li><?= $error; ?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        <?php } ?>
        <div class="col-md-12">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="name@something.com" class="form-control" />
            </div>
            <div class="form-group">
                <label for="passwd">Mot de passe</label>
                <input type="password" name="passwd" id="passwd" class="form-control" />
            </div>
            <button class="btn btn-primary">Connexion</button>
        </div>
    </form>
    <div class="col-md-12">
        <h1>Pas encore inscrit ?</h1>
        <p>Rejoins-nous en cliquant sur le bouton ci-dessous.</p>
        <a href="<?= $dir.'/inscription'; ?>" class="btn btn-primary text-center">Je m'inscris</a>
    </div>
</div>