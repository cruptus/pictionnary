<?php
use core\Validator;
use core\App;
if(App::getAuth()->isConnect()){
    header('Location: '.$dir.'/pictionnary/home');
    exit();
}

if(!empty($_POST)){
    $validator = new Validator($_POST);
    $validator->isEmail('email', 'Email non valide');
    $validator->isPassword('passwd', 'Mot de passe invalide');
    $validator->isAlpha('firstname', 'Format du prénom invalide');
    $validator->isAlpha('lastname', 'Format du nom invalide', false);
    $validator->isTel('number', 'Format du numéro de téléphone invalide', false);
    $validator->isSexe('sexe', 'Format du sexe invalide', false);
    $validator->isUrl('website', 'Format du site web invalide', false);
    $validator->isDate('birthday', 'Format de la date invalide');
    $validator->isAlphaCaractere('ville', 'Format de la ville invalide', false);
    $validator->isColor('color', 'Format de la couleur invalide', false);
    $validator->isPicture('picture', 'Format de la photo invalide', false);
    $validator->isTaille('taille', 'Format de la taille invalide', false);
    if($validator->isValid()){
        $db = App::getDataBase();
        $result = $db->prepare('SELECT * FROM users WHERE email = :email',
                                ['email' => $_POST['email']]);
        if(count($result) == 1){
            $errors = ['Email existant'];
        }else {
            $db->insert("INSERT INTO users (email, password, nom, prenom, tel, website, sexe, birthdate, ville, taille, couleur, profilepic)
                      VALUES (:email, :password, :nom, :prenom, :tel, :website, :sexe, :birthday, :ville, :taille, :couleur, :profilepic)",
                [
                    'email' => $_POST['email'],
                    'password' => hash('sha256', $_POST['passwd']),
                    'nom' => $_POST['firstname'],
                    'prenom' => $_POST['lastname'],
                    'tel' => $_POST['number'],
                    'website' => $_POST['website'],
                    'sexe' => empty($_POST['sexe']) ? null : $_POST['sexe'],
                    'birthday' => $_POST['birthday'],
                    'ville' => $_POST['ville'],
                    'taille' => $_POST['taille'],
                    'couleur' => str_replace('#', '', $_POST['color']),
                    'profilepic' => $_POST['picture']
                ]);
            App::getAuth()->login(App::getDataBase(), $_POST['email'], $_POST['passwd']);
        }

    }else{
        $errors = $validator->getErrors();
    }
} ?>
<div class="col-md-4 col-xs-12" style="opacity: 0.95">
    <?php if(empty($errors)){ ?>
        <div class="alert alert-info">Les champs obligatoires sont indiqués par *</div>
    <?php }else{ ?>
        <div class="alert alert-danger">
            <p>Des erreurs ont été rencontrées :</p>
            <ul>
                <?php foreach($errors as $error){ ?>
                    <li><?= $error; ?></li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>
</div>
<form action="<?= $dir; ?>/inscription" method="post" name="inscription">
    <div class="col-md-offset-1 col-md-7 col-xs-12 content">
        <h1>Inscription</h1>
        <div class="col-md-6">
            <h2>Identité</h2>
            <?php
                $form = new \core\HTML\Form($_POST);
                echo $form->email("E-mail *", "email", "name@something.com", "autofocus required");
                echo $form->password("Mot de passe *", 'passwd', "4 à 8 caractères alphanumériques", "pattern='[a-zA-Z0-9]{4,8}' required");
                echo $form->password("Confirmation du mot de passe *", "passwdconf", "", "required onkeyup='verifPw(this)'");
                echo $form->input("Prénom *", "firstname", "Jean", "required");
                echo $form->input("Nom", "lastname", "Dupond");
                echo $form->tel("Téléphone", "number", "0606060606", "pattern='[0-9]{10}'");
            ?>
            <div class="form-inline" style="margin-bottom: 16px;" >
                <label>Sexe :</label>
                <?= $form->radio(['Homme', 'Femme'], ['masculin', 'feminin'], "sexe", ['m', 'f']); ?>
            </div>
        </div>
        <div class="col-md-6">
            <h2>Information</h2>
            <?php
                echo $form->url("Site web", 'website', "http://www.website.com");
                echo $form->date("Anniversaire *", "birthday", "AAAA-MM-JJ", "required onchange='calculDate(this)'");
                echo $form->number("Age", "age", "", "disabled='disabled'");
                echo $form->input("Ville", "ville", "Sophia-Antipolis");
                echo $form->color("Couleur préféré", "color");
            ?>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-5">
                        <label for="photo">Photo</label>
                        <input type="file" name="photo" id="photo" onchange="loadProfilePic(this)" style="color: transparent" />
                        <input type="hidden" name="picture" id="picture" />
                    </div>
                    <div class="col-sm-7">
                        <canvas id="preview" style="border: 1px solid black; width: 96px; height: 96px;"></canvas>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="taille">Taille :</label><span id="lataille" style="padding-left: 10px;">1 m</span>
                <input type="range" name="taille" id="taille" value="<?= isset($_POST['taille']) ? htmlspecialchars($_POST['taille']) : 1; ?>" max="2.5" min="0" step="0.01" />
            </div>
        </div>
        <div class="col-md-12 text-center">
            <?= $form->submit("S'inscrire"); ?>
        </div>
    </div>
</form>
<script language="JavaScript">
    window.onload = function(){
        calculDate(document.getElementById('birthday'));
    }
</script>