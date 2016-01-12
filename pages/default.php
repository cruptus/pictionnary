<?php use core\App; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Pictionnary - Inscription</title>

        <!-- Bootstrap -->
        <link href="<?= $dir; ?>/css/bootstrap.css" rel="stylesheet">
        <link href="<?= $dir; ?>/css/style.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?= $dir; ?>/js/bootstrap.min.js"></script>
        <script src="<?= $dir; ?>/js/function.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?= $dir.'/home'; ?>">Pictionnary</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="<?= $dir.'/home'; ?>"><i class="glyphicon glyphicon-home"></i> Accueil</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <?php if(App::getAuth()->isConnect()){ ?>
                            <li><a href="<?= $dir.'/pictionnary/disconnect'; ?>"><i class="glyphicon glyphicon-off"></i> Deconnexion</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container" style="margin-top: 80px;">
            <?= $content; ?>
        </div>
    </body>
</html>