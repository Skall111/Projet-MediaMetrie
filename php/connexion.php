<?php
session_start();
//  Récupération de l'utilisateur et de son pass hashé
include ('Db.php');
if(isset($_POST) && !empty($_POST)){
$req = $bdd->prepare('SELECT id , pass , prenom_amba , admin FROM compte WHERE id = :id AND pass  = :pass');
    // invzlid parametre si tu te connecet eavec l'id et le pass
    // dans les param ci dessous tu as mis id = qq chose
    // et pass = qq chose
    // sauf que dans la requete tu as mis id = prenom de mon zbobub
    //et pass = pass
    //// tu vois la couille ?
    /// comprend pas
    /// mdrrrr
    ///  ça menerve que ça soit juste ça....
$req->execute(array(
    'id' => $_POST['id'] ,
    'pass' => $_POST['pass'])); // la j'ai change rton prenom amba par pass puisque c'est ce que je voulais qu'il prenne en compte et ? bha regarde!!
    // J'ai une doc a finir moi !
    // désolé frère c'est le merdier php ça me gonfle genre la regarde
    $resultat = $req->fetch();// fetch ? tu met sous forme de  tabelau la permier ligne du resultat
// fetchAll() tu mets sous forme de tabelau tout les lignes du reulatat

// Comparaison du pass envoyé via le formulaire avec la base
//$isPasswordCorrect = password_verify($_POST['pass'], $resultat['pass']);
if (!$resultat)
{
    echo 'Mauvais identifiant ou mot de passe !';
    // si y'a de resulatt je lui echo ce qui ya au dessus
}
else
{
    if($resultat['admin'] == 1){
        $_SESSION['ADMIN'] = 1 ;
    }else{
        $_SESSION['ADMIN'] = 0 ;
    }
        $_SESSION['id'] = $resultat['id'];// La je mets l'id dasn la varible (recuperable depuis toute les pages ) $_SESSION au rang 'id'
        $_SESSION['prenom_amba'] = $resultat['prenom_amba'];//Pas neccessaire mais tu peux laisser
        $_SESSION['pass']    =  $resultat['pass'];
    // si il est connceter je redirieg ce fdp vers la page que je souhaite sans mettre de echo ni var_dump avant sinon ca beug
    header('Location: ../pages/index.php');
    exit();
}

}
?>




<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Facturation Simple & Rapide</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Connexion</h3>
                </div>
                <div class="panel-body">
                    <form role="form" method="POST">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Id" name="id" type="text" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Mot de passe" name="pass" type="password" value="">
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input name="remember" type="checkbox" value="Remember Me">Se souvenir de moi
                                </label>
                            </div>

                            <input type="submit" class="btn btn-lg btn-success btn-block">
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="../vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="../vendor/metisMenu/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>


