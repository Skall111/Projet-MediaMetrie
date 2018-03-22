<?php
session_start();
include '../php/Db.php';
$directory = "/Applications/MAMP/htdocs/Projet-MediaMetrie/Files/";
if(isset($_GET) && !empty($_GET)){
    $reqDetail = $bdd->query("SELECT * FROM details WHERE Id_foyer = ".$_GET['foyer']);
    $detail = $reqDetail->fetchAll();
    $reqImage = $bdd->query("SELECT * FROM fichiers WHERE Id_foyer = ".$_GET['foyer']);
    $Image = $reqImage->fetchAll();
}else{
    echo "Un erreur a eu lieu , nous sommes désolé " ;
    exit;
}
$Id_foyer = $_GET['foyer'];
if(isset($_POST) && !empty($_POST)) {
    $Id_foyer = @$_POST['foyer'];
    $Current_date = @$_POST['date'];
    $Id_type = isset($_POST['packweb']) ? 2 : 1;
    $Detail = @$_POST['nbr_poste'];
    $Kms_aller = @$_POST['kms_aller'];
    $Repas = @$_POST['repas'];
    $Peage = @$_POST['peage'];
    $Hotel = @$_POST['hotel'];
    $Autre = @$_POST['autre'];

    $string_req = 'UPDATE details SET Id_foyer = :Id_foyer , Id_date = :curdate, Id_type_install = :Id_type_install, Id_type = 1, Detail = :Kms_aller WHERE Id_foyer = :param ; 
UPDATE details SET Id_foyer = :Id_foyer , Id_date = :curdate, Id_type_install = :Id_type_install, Id_type = 2, Detail = :Id_type WHERE Id_foyer = :param ; 
UPDATE details SET Id_foyer = :Id_foyer , Id_date = :curdate, Id_type_install = :Id_type_install, Id_type = 3, Detail = :Detail WHERE Id_foyer = :param ; 
UPDATE details SET Id_foyer = :Id_foyer , Id_date = :curdate, Id_type_install = :Id_type_install, Id_type = 4, Detail = :Repas WHERE Id_foyer = :param ; 
UPDATE details SET Id_foyer = :Id_foyer , Id_date = :curdate, Id_type_install = :Id_type_install, Id_type = 5, Detail = :Peage WHERE Id_foyer = :param ; 
UPDATE details SET Id_foyer = :Id_foyer , Id_date = :curdate, Id_type_install = :Id_type_install, Id_type = 6, Detail = :Hotel WHERE Id_foyer = :param ; 
UPDATE details SET Id_foyer = :Id_foyer , Id_date = :curdate, Id_type_install = :Id_type_install, Id_type = 7, Detail = :Autre WHERE Id_foyer = :param ; ';
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

    $file = $_FILES['file_kms_aller']['tmp_name'];
    if (!file_exists($directory . $Id_foyer)) { // Si le dossier n'existe pas on le crée avec l'id du foyer qui est censé etre unique
        mkdir($directory . $Id_foyer);
    }
    if (!move_uploaded_file($file, $directory . $Id_foyer . '/' . $_FILES['file_kms_aller']['name'])) {
        echo "Impossible de copier le fichier dans" . $directory. $Id_foyer . '/' . $_FILES['file_kms_aller']['name'];
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
                'Files_chemin' => $directory . $Id_foyer));

        } else {
            $req = $bdd->prepare('UPDATE fichiers SET Fichier = :Name_files , Url = :Files_chemin WHERE Id_foyer = :Id_foyer AND Id_type = 1 ');
            $req->execute(array(
                'Id_foyer' => $Id_foyer,
                'Name_files' => $_FILES['file_kms_aller']['name'],
                'Files_chemin' => $directory . $Id_foyer));
        }
        $reqImage = $bdd->query("SELECT * FROM fichiers WHERE Id_foyer = ".$_GET['foyer']);
        $Image = $reqImage->fetchAll();

    }
}
/*
* 1 => Kms_aller
* 2 => Forfait
* 3 => Nbr de poste
* 4 => Repas
* 5 => Peages
* 6 => Hotels
* 7 => Autres
 * */

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
            <h1 class="page-header">Modifier son Compte-Rendu : Installation</h1>
                <h6><br>En ajoutant des fichiers sur ce formualire , les anciens fichiers seront supprimé ! <br>
                Vous trouverez tout les fichiers télécharger concernant cette installation plus bas </h6>
        </div>

        <div class="modalpersoo">


            <div class="modal-body">
                <form id="form" method="POST" enctype="multipart/form-data">

                    <div class="col-sm-5 cri">
                        <h4>Frais Généraux</h4>
                        <div class="panel panel-default">
                            <div class="panel-body form-horizontal payment-form">

                                <div class="form-group">
                                    <label for="concept"
                                           class="col-sm-3 control-label">N°Foyer</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="foyer"
                                               name="foyer" readonly value="<?php echo $foyer ;?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="date" class="col-sm-3 control-label"
                                           style="padding-top: 0%">Date Intervention</label>
                                    <div class="col-sm-9">
                                        <input type="date" class="form-control" id="date"
                                               name="date" value="<?php echo $date ;?>">
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label for="description" class="col-sm-3 control-label">Kms
                                        aller</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="kms_aller"
                                               name="kms_aller" value="<?php echo $kms ; ?>">
                                        <span>
                                         <input type="file" class="form-control-file"
                                                id="exampleFormControlFile1" name="file_kms_aller" >
                                          </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="description"
                                           class="col-sm-3 control-label">Forfait</label>
                                    <div class="checkbox-install">
                                        <input type="checkbox" id="packweb" name="packweb"
                                               value="1" <?php echo ($forfait == 1)? "checked" : "" ; ?>>
                                        <label for="packweb">Forfait Pack Web</label>
                                        <input type="checkbox" id="Demo" name="demo" value="1" checked disabled>
                                        <label for="Demo">Forfait Démo</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="concept" class="col-sm-3 control-label"
                                           style="padding-top: 0%">Nbre de poste</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="nbr_poste"
                                               name="nbr_poste" value="<?php echo $poste ; ?>">
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

                                <div class="form-group">
                                    <label for="concept"
                                           class="col-sm-3 control-label">Repas</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="concept"
                                               name="repas" value="<?php echo $repas ; ?>">
                                        <span>
                                        <input type="file" class="form-control-file" id="fiche_repas" >
                                </span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description"
                                           class="col-sm-3 control-label">Péages</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="peage"
                                               name="peage" value="<?php echo $peage ; ?>">
                                        <span>
                                        <input type="file" class="form-control-file" id="fiche_peage" >
                                </span>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label for="amount"
                                           class="col-sm-3 control-label">Hotels</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="hotel"
                                               name="hotel" value="<?php echo $hotel ; ?>">
                                        <span>
                                        <input type="file" class="form-control-file" id="fiche_hotel" >
                                </span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="amount"
                                           class="col-sm-3 control-label">Autres</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="autre"
                                               name="autre" value="<?php echo $autres ; ?>">
                                        <span>
                                        <input type="file" class="form-control-file" id="fiche_autre">
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
                <button type="button" onclick="$('#form').submit();" class="btn btn-primary">Sauvegarder les changements
                </button>
            </div>
        </div>
    </div>
            <div class="row">
                <div class="col-sm-4 text-center" style="background-image: url('bg.jpg') ; height: 130px ; ">
                    <h3>Kms</h3>
                    <br>
                    <i class="fa fa-road" aria-hidden="true"></i>
                    <?php
                    if (isset($kms_image) && !empty($kms_image)) {
                        ?>
                        Fichier : <a target="_blank"
                                href="dl.php?chemin=<?php echo $kms_url  ; ?>&fichier=<?php echo $kms_image; ?>"><?php echo $kms_image; ?></a>
                        <br>
                        <a target="_blank"
                           href="dl.php?supp=1&chemin=<?php echo $kms_url  ; ?>&fichier=<?php echo $kms_image; ?>"><i title="Supprimer !" class="fa fa-trash fa-2x">
                            </i></a>
                        <?php
                    }else{
                        echo "Fichier : Aucun fichier trouvé";
                    }
                    ?>

                </div>
                <div class="col-sm-4 text-center" style="background-image: url('bg.jpg') ; height: 130px ; ">
                    <h3>Repas</h3>
                    <br>
                    <i class="fa fa-cutlery" aria-hidden="true"></i>
                    <?php
                    if (isset($repas_image) && !empty($repas_image)) {
                        ?>
                        Fichier : <a target="_blank"
                                href="dl.php?chemin=<?php echo $repas_url  ; ?>&fichier=<?php echo $repas_image; ?>"><?php echo $repas_image; ?></a>
                        <a target="_blank"
                           href="dl.php?supp=1&chemin=<?php echo $repas_url  ; ?>&fichier=<?php echo $repas_image; ?>"><i title="Supprimer !" class="fa fa-trash fa-2x">
                            </i></a><i title="Supprimer !" class="fa fa-trash fa-2x"></i>
                        <?php
                    }else{
                       echo  "Fichier : Aucun fichier trouvé";
                    }
                    ?>

                </div>
                <div class="col-sm-4 text-center" style="background-image: url('bg.jpg') ; height: 130px ; ">
                    <h3>Peage</h3>
                    <br>
                    <i class="fa fa-ticket" aria-hidden="true"></i>
                    <?php
                    if (isset($peage_image) && !empty($peage_image)) {
                        ?>
                        Fichier : <a target="_blank"
                                href="dl.php?chemin=<?php echo $peage_url  ;?>&fichier=<?php echo $peage_image; ?>"><?php echo $peage_image; ?></a>
                        <a target="_blank"
                           href="dl.php?supp=1&chemin=<?php echo $peage_url  ; ?>&fichier=<?php echo $peage_image; ?>"><i title="Supprimer !" class="fa fa-trash fa-2x">
                            </i></a><i title="Supprimer !" class="fa fa-trash fa-2x"></i>
                        <?php
                    }else{
                       echo  "Fichier : Aucun fichier trouvé";
                    }
                    ?>

                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 text-center" style="background-image: url('bg.jpg') ; height: 130px ; ">
                    <h3>Hotel</h3>
                    <br>
                    <i class="fa fa-bed" aria-hidden="true"></i>
                    <?php
                    if (isset($hotel_image) && !empty($hotel_image)) {
                        ?>
                        Fichier : <a target="_blank"
                                href="dl.php?chemin=<?php echo $hotel_url  ; ?>&fichier=<?php echo $hotel_image; ?>"><?php echo $hotel_image; ?></a>
                        <a target="_blank"
                           href="dl.php?supp=1&chemin=<?php echo $hotel_url  ; ?>&fichier=<?php echo $hotel_image; ?>"><i title="Supprimer !" class="fa fa-trash fa-2x">
                            </i></a><i title="Supprimer !" class="fa fa-trash fa-2x"></i>
                        <?php
                    }else{
                       echo  "Fichier : Aucun fichier trouvé";
                    }
                    ?>
                </div>
                <div class="col-sm-6 text-center" style="background-image: url('bg.jpg') ; height: 130px ; ">
                    <h3>Autres</h3>
                    <br>
                    <i class="fa fa-list" aria-hidden="true"></i>
                    <?php
                    if (isset($autres_image) && !empty($autres_image)) {
                        ?>
                        Fichier : <a target="_blank"
                                href="dl.php?chemin=<?php echo $autres_url  ; ?>&fichier=<?php echo $autres_image; ?>"><?php echo $autres_image; ?></a>
                        <a target="_blank"
                           href="dl.php?supp=1&chemin=<?php echo $autres_url  ; ?>&fichier=<?php echo $autres_image; ?>"><i title="Supprimer !" class="fa fa-trash fa-2x">
                            </i></a><i title="Supprimer !" class="fa fa-trash fa-2x"></i>
                        <?php
                    }else{
                        echo "Fichier : Aucun fichier trouvé";
                    }
                    ?>

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