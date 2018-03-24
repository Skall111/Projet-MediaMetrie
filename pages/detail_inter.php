<?php


session_start();
include '../php/Db.php';
$directory = "C:/wamp64\/www/Projet-MediaMetrie/Files/";

$Id_foyer = $_GET['foyer'];
if(isset($_POST) && !empty($_POST)) {
$Id_foyer = @$_POST['foyer'];
$Current_date = @$_POST['date'];
$Id_type = 0;
$Detail = @$_POST['temps_passe'];
$Kms_aller = @$_POST['kms_aller'];
$Repas = @$_POST['repas'];
$Peage = @$_POST['peage'];
$Hotel = @$_POST['hotel'];
$Autre = @$_POST['autre'];

$string_req = 'UPDATE details SET Id_foyer = '.$Id_foyer.' , Id_date = "'.$Current_date.'", Id_type_install = 1, Id_type = 1, Detail = "'.$Kms_aller.'" WHERE Id_type = 1 AND Id_foyer = '.$_GET['foyer'].' ; 
UPDATE details SET Id_foyer = '.$Id_foyer.' , Id_date = "'.$Current_date.'", Id_type_install = 1, Id_type = 2, Detail = "'.$Id_type.'" WHERE Id_type = 2 AND Id_foyer = '.$_GET['foyer'].' ; 
UPDATE details SET Id_foyer = '.$Id_foyer.' , Id_date = "'.$Current_date.'", Id_type_install = 1, Id_type = 3, Detail = "'.$Detail.'" WHERE Id_type = 3 AND Id_foyer = '.$_GET['foyer'].' ; 
UPDATE details SET Id_foyer = '.$Id_foyer.' , Id_date = "'.$Current_date.'", Id_type_install = 1, Id_type = 4, Detail = "'.$Repas.'" WHERE Id_type = 4 AND Id_foyer = '.$_GET['foyer'].' ; 
UPDATE details SET Id_foyer = '.$Id_foyer.' , Id_date = "'.$Current_date.'", Id_type_install = 1, Id_type = 5, Detail = "'.$Peage.'" WHERE Id_type = 5 AND Id_foyer = '.$_GET['foyer'].' ; 
UPDATE details SET Id_foyer = '.$Id_foyer.' , Id_date = "'.$Current_date.'", Id_type_install = 1, Id_type = 6, Detail = "'.$Hotel.'" WHERE  Id_type = 6 AND Id_foyer = '.$_GET['foyer'].' ; 
UPDATE details SET Id_foyer = '.$Id_foyer.' , Id_date = "'.$Current_date.'", Id_type_install = 1, Id_type = 7, Detail = "'.$Autre.'" WHERE Id_type = 7 AND Id_foyer = '.$_GET['foyer'].' ; ';
//echo $string_req ;
$req = $bdd->prepare($string_req);
$req->execute(array(
    'Id_foyer' => $Id_foyer,
    'curdate' => $Current_date,
    'Id_type_install' => '1',
    'Id_type' => $Id_type,
    'Detail' => $Detail,
    'Kms_aller' => $Kms_aller,
    'Repas' => $Repas,
    'Peage' => $Peage,
    'Hotel' => $Hotel,
    'Autre' => $Autre,
    'param' => $_GET['foyer']));

$string_req = 'UPDATE facture SET Id_foyer = :Id_foyer , Id_date = :curdate, Id_type_inter = :Id_type_install WHERE Id_foyer = :param ; ';


$req = $bdd->prepare($string_req);
$req->execute(array(
    'Id_foyer' => $Id_foyer,
    'curdate' => $Current_date,
    'Id_type_install' => '1',
    'param' => $_GET['foyer']));

    /*
     * PEITI JUIF
     * */
    $file = $_FILES['file_kms_aller']['tmp_name'];
    if (!file_exists($directory . $Id_foyer.'_'.$Current_date)) { // Si le dossier n'existe pas on le crée avec l'id du foyer qui est censé etre unique
        mkdir($directory . $Id_foyer.'_'.$Current_date);
    }
    if (!move_uploaded_file($file, $directory . $Id_foyer . '_'.$Current_date .'/'.$_FILES['file_kms_aller']['name'])) {
        echo "Impossible de copier le fichier dans" . $directory . $Id_foyer . '_'.$Current_date .'/'.$_FILES['file_kms_aller']['name'];
    } else {
        echo "Le fichier a bien été uploader";
        /*
             * ATTENTION IL FAUT CHANGER DANS LA REQUERE prepare() le chiffre qui suit :Id_type_inter
             * C'est ce qui defini le champs !!
         * Il faut aussi changer le Name_files dasn chaque reqete
             * */
        $resultreq = $bdd->query("SELECT * FROM fichiers WHERE Id_foyer = " . $_GET['foyer'] . " AND Id_type = 1");
        $result = $resultreq->fetch();
        if (!$result) {
            $req = $bdd->prepare('INSERT INTO fichiers(Id_foyer, Id_date, Id_type_install, Id_type, Id_dossier, Fichier, Url) 
                                        VALUES (:Id_foyer, :curdate , :Id_type_inter , 1 , :Id_foyer , :Name_files , :Files_chemin) ');
            $req->execute(array(
                'Id_foyer' => $Id_foyer,
                'curdate' => $Current_date,
                'Id_type_inter' => '1',
                'Name_files' => $_FILES['file_kms_aller']['name'],
                'Files_chemin' => $directory . $Id_foyer.'_'.$Current_date));

        } else {
            $req = $bdd->prepare('UPDATE fichiers SET Fichier = :Name_files , Url = :Files_chemin WHERE Id_foyer = :Id_foyer AND Id_type = 1 ');
            $req->execute(array(
                'Id_foyer' => $Id_foyer,
                'Name_files' => $_FILES['file_kms_aller']['name'],
                'Files_chemin' => $directory . $Id_foyer.'_'.$Current_date));
        }
        $reqImage = $bdd->query("SELECT * FROM fichiers WHERE Id_foyer = ".$_GET['foyer']);
        $Image = $reqImage->fetchAll();

    }
    /*
     * PETIT FOUR

     * */
    /*
 * PEITI JUIF
 * */
    $file = $_FILES['file_repas']['tmp_name'];
    if (!file_exists($directory . $Id_foyer.'_'.$Current_date)) { // Si le dossier n'existe pas on le crée avec l'id du foyer qui est censé etre unique
        mkdir($directory . $Id_foyer.'_'.$Current_date);
    }
    if (!move_uploaded_file($file, $directory . $Id_foyer . '_'.$Current_date .'/'.$_FILES['file_repas']['name'])) {
        echo "Impossible de copier le fichier dans" . $directory . $Id_foyer . '_'.$Current_date .'/'.$_FILES['file_repas']['name'];
    } else {
        echo "Le fichier a bien été uploader";
        /*
             * ATTENTION IL FAUT CHANGER DANS LA REQUERE prepare() le chiffre qui suit :Id_type_inter
             * C'est ce qui defini le champs !!
         * Il faut aussi changer le Name_files dasn chaque reqete
             * */
        $resultreq = $bdd->query("SELECT * FROM fichiers WHERE Id_foyer = " . $_GET['foyer'] . " AND Id_type = 4");
        $result = $resultreq->fetch();
        if (!$result) {
            $req = $bdd->prepare('INSERT INTO fichiers(Id_foyer, Id_date, Id_type_install, Id_type, Id_dossier, Fichier, Url) 
                                        VALUES (:Id_foyer, :curdate , :Id_type_inter , 4 , :Id_foyer , :Name_files , :Files_chemin) ');
            $req->execute(array(
                'Id_foyer' => $Id_foyer,
                'curdate' => $Current_date,
                'Id_type_inter' => '1',
                'Name_files' => $_FILES['file_repas']['name'],
                'Files_chemin' => $directory . $Id_foyer.'_'.$Current_date));

        } else {
            $req = $bdd->prepare('UPDATE fichiers SET Fichier = :Name_files , Url = :Files_chemin WHERE Id_foyer = :Id_foyer AND Id_type = 4 ');
            $req->execute(array(
                'Id_foyer' => $Id_foyer,
                'Name_files' => $_FILES['file_repas']['name'],
                'Files_chemin' => $directory . $Id_foyer.'_'.$Current_date));
        }
        $reqImage = $bdd->query("SELECT * FROM fichiers WHERE Id_foyer = ".$_GET['foyer']);
        $Image = $reqImage->fetchAll();

    }
    /*
     * PETIT FOUR

     * */
    /*
 * PEITI JUIF
 * */
    $file = $_FILES['file_peage']['tmp_name'];
    if (!file_exists($directory . $Id_foyer.'_'.$Current_date)) { // Si le dossier n'existe pas on le crée avec l'id du foyer qui est censé etre unique
        mkdir($directory . $Id_foyer.'_'.$Current_date);
    }
    if (!move_uploaded_file($file, $directory . $Id_foyer . '_'.$Current_date .'/'.$_FILES['file_peage']['name'])) {
        echo "Impossible de copier le fichier dans" . $directory . $Id_foyer . '_'.$Current_date .'/'.$_FILES['file_peage']['name'];
    } else {
        echo "Le fichier a bien été uploader";
        /*
             * ATTENTION IL FAUT CHANGER DANS LA REQUERE prepare() le chiffre qui suit :Id_type_inter
             * C'est ce qui defini le champs !!
         * Il faut aussi changer le Name_files dasn chaque reqete
             * */
        $resultreq = $bdd->query("SELECT * FROM fichiers WHERE Id_foyer = " . $_GET['foyer'] . " AND Id_type = 5");
        $result = $resultreq->fetch();
        if (!$result) {
            $req = $bdd->prepare('INSERT INTO fichiers(Id_foyer, Id_date, Id_type_install, Id_type, Id_dossier, Fichier, Url) 
                                        VALUES (:Id_foyer, :curdate , :Id_type_inter , 5 , :Id_foyer , :Name_files , :Files_chemin) ');
            $req->execute(array(
                'Id_foyer' => $Id_foyer,
                'curdate' => $Current_date,
                'Id_type_inter' => '1',
                'Name_files' => $_FILES['file_peage']['name'],
                'Files_chemin' => $directory . $Id_foyer.'_'.$Current_date));

        } else {
            $req = $bdd->prepare('UPDATE fichiers SET Fichier = :Name_files , Url = :Files_chemin WHERE Id_foyer = :Id_foyer AND Id_type = 5 ');
            $req->execute(array(
                'Id_foyer' => $Id_foyer,
                'Name_files' => $_FILES['file_peage']['name'],
                'Files_chemin' => $directory . $Id_foyer.'_'.$Current_date));
        }
        $reqImage = $bdd->query("SELECT * FROM fichiers WHERE Id_foyer = ".$_GET['foyer']);
        $Image = $reqImage->fetchAll();

    }
    /*
     * PETIT FOUR

     * */
    /*
 * PEITI JUIF
 * */
    $file = $_FILES['file_hotel']['tmp_name'];
    if (!file_exists($directory . $Id_foyer.'_'.$Current_date)) { // Si le dossier n'existe pas on le crée avec l'id du foyer qui est censé etre unique
        mkdir($directory . $Id_foyer.'_'.$Current_date);
    }
    if (!move_uploaded_file($file, $directory . $Id_foyer . '_'.$Current_date .'/'.$_FILES['file_hotel']['name'])) {
        echo "Impossible de copier le fichier dans" . $directory . $Id_foyer . '_'.$Current_date .'/'.$_FILES['file_hotel']['name'];
    } else {
        echo "Le fichier a bien été uploader";
        /*
             * ATTENTION IL FAUT CHANGER DANS LA REQUERE prepare() le chiffre qui suit :Id_type_inter
             * C'est ce qui defini le champs !!
         * Il faut aussi changer le Name_files dasn chaque reqete
             * */
        $resultreq = $bdd->query("SELECT * FROM fichiers WHERE Id_foyer = " . $_GET['foyer'] . " AND Id_type = 6");
        $result = $resultreq->fetch();
        if (!$result) {
            $req = $bdd->prepare('INSERT INTO fichiers(Id_foyer, Id_date, Id_type_install, Id_type, Id_dossier, Fichier, Url) 
                                        VALUES (:Id_foyer, :curdate , :Id_type_inter , 6 , :Id_foyer , :Name_files , :Files_chemin) ');
            $req->execute(array(
                'Id_foyer' => $Id_foyer,
                'curdate' => $Current_date,
                'Id_type_inter' => '1',
                'Name_files' => $_FILES['file_hotel']['name'],
                'Files_chemin' => $directory . $Id_foyer.'_'.$Current_date));

        } else {
            $req = $bdd->prepare('UPDATE fichiers SET Fichier = :Name_files , Url = :Files_chemin WHERE Id_foyer = :Id_foyer AND Id_type = 6 ');
            $req->execute(array(
                'Id_foyer' => $Id_foyer,
                'Name_files' => $_FILES['file_hotel']['name'],
                'Files_chemin' => $directory . $Id_foyer.'_'.$Current_date));
        }
        $reqImage = $bdd->query("SELECT * FROM fichiers WHERE Id_foyer = ".$_GET['foyer']);
        $Image = $reqImage->fetchAll();

    }
    /*
     * PETIT FOUR

     * */
    /*
 * PEITI JUIF
 * */
    $file = $_FILES['file_autre']['tmp_name'];
    if (!file_exists($directory . $Id_foyer.'_'.$Current_date)) { // Si le dossier n'existe pas on le crée avec l'id du foyer qui est censé etre unique
        mkdir($directory . $Id_foyer.'_'.$Current_date);
    }
    if (!move_uploaded_file($file, $directory . $Id_foyer . '_'.$Current_date .'/'.$_FILES['file_autre']['name'])) {
        echo "Impossible de copier le fichier dans" . $directory . $Id_foyer . '_'.$Current_date .'/'.$_FILES['file_autre']['name'];
    } else {
        echo "Le fichier a bien été uploader";
        /*
             * ATTENTION IL FAUT CHANGER DANS LA REQUERE prepare() le chiffre qui suit :Id_type_inter
             * C'est ce qui defini le champs !!
         * Il faut aussi changer le Name_files dasn chaque reqete
             * */
        $resultreq = $bdd->query("SELECT * FROM fichiers WHERE Id_foyer = " . $_GET['foyer'] . " AND Id_type = 7");
        $result = $resultreq->fetch();
        if (!$result) {
            $req = $bdd->prepare('INSERT INTO fichiers(Id_foyer, Id_date, Id_type_install, Id_type, Id_dossier, Fichier, Url) 
                                        VALUES (:Id_foyer, :curdate , :Id_type_inter , 7 , :Id_foyer , :Name_files , :Files_chemin) ');
            $req->execute(array(
                'Id_foyer' => $Id_foyer,
                'curdate' => $Current_date,
                'Id_type_inter' => '1',
                'Name_files' => $_FILES['file_autre']['name'],
                'Files_chemin' => $directory . $Id_foyer.'_'.$Current_date));

        } else {
            $req = $bdd->prepare('UPDATE fichiers SET Fichier = :Name_files , Url = :Files_chemin WHERE Id_foyer = :Id_foyer AND Id_type = 7 ');
            $req->execute(array(
                'Id_foyer' => $Id_foyer,
                'Name_files' => $_FILES['file_autre']['name'],
                'Files_chemin' => $directory . $Id_foyer.'_'.$Current_date));
        }
        $reqImage = $bdd->query("SELECT * FROM fichiers WHERE Id_foyer = ".$_GET['foyer']);
        $Image = $reqImage->fetchAll();

    }
    /*
     * PETIT FOUR

     * */

}
if(isset($_GET) && !empty($_GET)){
    $reqDetail = $bdd->query("SELECT * FROM details WHERE Id_foyer = ".$_GET['foyer']);
    $detail = $reqDetail->fetchAll();
    $reqImage = $bdd->query("SELECT * FROM fichiers WHERE Id_foyer = ".$_GET['foyer']);
    $Image = $reqImage->fetchAll();
}else{
    echo "Un erreur a eu lieu , nous sommes désolé " ;
    exit;
}

foreach ($detail as $item){
    $foyer = $item['Id_foyer'];
    $date = $item['Id_date'];
    switch ($item['Id_type']){
        case 1 :
            $kms = $item['Detail'] ;
            continue ;
        case 2 :
            $forfait = $item['Detail']   ;
            continue ;
        case 3 :
            $poste = $item['Detail']   ;
            continue ;
        case 4 :
            $repas = $item['Detail']   ;
            continue ;
        case 5 :
            $peage = $item['Detail']   ;
            continue ;
        case 6 :
            $hotel = $item['Detail']   ;
            continue ;
        case 7 :
            $autres = $item['Detail']   ;
            continue ;
    }
}
foreach ($Image as $item){
    switch ($item['Id_type']){
        case 1 :
            $kms_image = $item['Fichier']   ;
            $kms_url = $item['Url']   ;
            continue ;
        case 4 :
            $repas_image = $item['Fichier']   ;
            $repas_url = $item['Url']   ;
            continue ;
        case 5 :
            $peage_image = $item['Fichier']   ;
            $peage_url = $item['Url']   ;
            continue ;
        case 6 :
            $hotel_image = $item['Fichier']   ;
            $hotel_url = $item['Url']   ;
            continue ;
        case 7 :
            $autres_image = $item['Fichier']   ;
            $autres_url = $item['Url']   ;
            continue ;
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

    <title>Installation</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">

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
<?php include("../php/menus.php"); ?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Modifier son Compte-Rendu : Intervention </h1>
        </div>

        <div class="modalpersoo">

            <div class="modal-body">
                <form id="form" method="POST" enctype="multipart/form-data">
                    <div class="col-sm-5 cri" >
                        <h4>Frais Généraux</h4>
                        <div class="panel panel-default">
                            <div class="panel-body form-horizontal payment-form">

                                <div class="form-group" >
                                    <label for="concept" class="col-sm-3 control-label">N°Foyer</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="foyer" name="foyer">
                                    </div>
                                </div>

                                <div class="form-group" >
                                    <label for="date" class="col-sm-3 control-label" style="padding-top: 0%">Date Intervention</label>
                                    <div class="col-sm-9">
                                        <input type="date" class="form-control" id="date" name="date">
                                    </div>

                                </div>

                                <div class="form-group" >
                                    <label for="description" class="col-sm-3 control-label">Kms aller</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="kms_aller" name="kms_aller">
                                        <span>
                                        <input type="file" class="form-control-file" id="file_kms_aller" name="file_temps_passe">
                                </span>
                                    </div>
                                </div>

                                <div class="form-group" >
                                    <label for="amount" class="col-sm-3 control-label" style="padding-top: 0%">Temps Passé </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="temps_passe" name="temps_passe">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / panel preview -->
                    <div class="col-sm-5 cri">
                        <h4>Frais Annexes</h4>
                        <div class="panel panel-default">
                            <div class="panel-body form-horizontal payment-form">

                                <div class="form-group" >
                                    <label for="concept" class="col-sm-3 control-label">Repas</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="repas" name="repas">
                                        <span>
                                        <input type="file" class="form-control-file" id="fiche_repas" name="file_repas">
                                </span>
                                    </div>
                                </div>

                                <div class="form-group" >
                                    <label for="description" class="col-sm-3 control-label">Péages</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="peage" name="peage">
                                        <span>
                                        <input type="file" class="form-control-file" id="fiche_peage" name="file_peage">
                                </span>
                                    </div>

                                </div>

                                <div class="form-group" >
                                    <label for="amount" class="col-sm-3 control-label">Hotels</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="hotel" name="hotel">
                                        <span>
                                        <input type="file" class="form-control-file" id="fiche_hotel" name="file_hotel">
                                </span>
                                    </div>
                                </div>

                                <div class="form-group" >
                                    <label for="amount" class="col-sm-3 control-label">Autres</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="autre" name="autre">
                                        <span>
                                        <input type="file" class="form-control-file" id="fiche_autre" name="file_autre">
                                </span>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="button" onclick="$('#form').submit();" class="btn btn-primary">Sauvegarder les changements</button>
            </div>
        </div>







<script src="../vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="../vendor/metisMenu/metisMenu.min.js"></script>

<!-- DataTables JavaScript -->
<script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

<!-- Custom Theme JavaScript -->
<script src="../dist/js/sb-admin-2.js"></script>


</body>
</html>