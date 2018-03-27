<?php
session_start();
//echo $_SESSION['id'];// Afficher l'ID de l'ambassadeur
//echo $_SESSION['prenom_amba'];// Afficher le prénom de l'ambassaeur
//var_dump($_POST);
//$directory = "C:/wamp64\www/Projet-MediaMetrie/Files/";
$directory = "C:/wamp64/www/Projet-MediaMetrie/Files/";

include '../php/Db.php';
// Insertion du bouton supprimer dans mon tableau


if(isset($_GET['valid'])){
    $req = $bdd->prepare('UPDATE facture SET Id_type_inter = 1 WHERE Id_foyer = :Id_foyer LIMIT 1 ');
    $req->execute(array(
        'Id_foyer' => $_GET['valid']));
}
if(isset($_GET['no_valid'])){
    $req = $bdd->prepare('UPDATE facture SET Id_type_inter = 0 WHERE Id_foyer = :Id_foyer LIMIT 1 ');
    $req->execute(array(
        'Id_foyer' => $_GET['no_valid']));
}

if (isset($_GET['supp'])) {
    $req = $bdd->prepare('DELETE FROM facture  WHERE Id_foyer = :Id_foyer LIMIT 1 ');
    $req->execute(array(
        'Id_foyer' => $_GET['supp']));

    $req = $bdd->prepare('DELETE FROM details  WHERE Id_foyer = :Id_foyer LIMIT 1 ');
    $req->execute(array(
        'Id_foyer' => $_GET['supp']));

    $req = $bdd->prepare('DELETE FROM fichiers  WHERE Id_foyer = :Id_foyer ');
    $req->execute(array(
        'Id_foyer' => $_GET['supp']));

    header('Location: intervention.php');
    exit();
}

if (isset ($_POST) && !empty($_POST)) // ne garde pas en mémoire ce qu'il ya dans les champs
{
// Insertion
    var_dump($_POST);
    var_dump($_FILES);
    $Id_foyer = $_POST['foyer'];
    $Current_date = $_POST['date'];
    $Detail = $_POST['temps_passe'];
    $Kms_aller = $_POST['kms_aller'];
    $Repas = $_POST['repas'];
    $Peage = $_POST['peage'];
    $Hotel = $_POST['hotel'];
    $Autre = $_POST['autre'];

    $string_req = 'INSERT INTO details (Id_foyer, Id_date, Id_type_install, Id_type, Detail) 
                VALUES (:Id_foyer, :curdate, :Id_type_install, 3, :Detail) ; 
                INSERT INTO details (Id_foyer, Id_date, Id_type_install, Id_type, Detail) 
                VALUES (:Id_foyer, :curdate, :Id_type_install, 1, :Kms_aller) ; 
                INSERT INTO details (Id_foyer, Id_date, Id_type_install, Id_type, Detail) 
                VALUES (:Id_foyer, :curdate, :Id_type_install, 2, :Detail) ; 
                INSERT INTO details (Id_foyer, Id_date, Id_type_install, Id_type, Detail) 
                VALUES (:Id_foyer, :curdate, :Id_type_install, 4, :Repas) ; 
                INSERT INTO details (Id_foyer, Id_date, Id_type_install, Id_type, Detail) 
                VALUES (:Id_foyer, :curdate, :Id_type_install, 5, :Peage) ; 
                INSERT INTO details (Id_foyer, Id_date, Id_type_install, Id_type, Detail) 
                VALUES (:Id_foyer, :curdate, :Id_type_install, 6, :Hotel) ; 
                INSERT INTO details (Id_foyer, Id_date, Id_type_install, Id_type, Detail) 
                VALUES (:Id_foyer, :curdate, :Id_type_install, 7, :Autre) ; 
                ';

    $req = $bdd->prepare('INSERT INTO facture (Id_foyer, Id_date, Id_type_inter) VALUES (:Id_foyer, :curdate, :Id_type_inter )');
    $req->execute(array(
        'Id_foyer' => $Id_foyer,
        'curdate' => $Current_date,
        'Id_type_inter' => '0'));

    $req = $bdd->prepare($string_req);
//    $req = $bdd->prepare('INSERT INTO details (Id_foyer, Id_date, Id_type_install, Id_type, Detail, Kms_aller, Repas, Peage, Hotel, Autre) VALUES (:Id_foyer, :curdate, :Id_type_install, :Id_type, :Detail, :Kms_aller, :Repas, :Peage, :Hotel, :Autre )');
    $req->execute(array(
        'Id_foyer' => $Id_foyer,
        'curdate' => $Current_date,
        'Id_type_install' => '2',
        'Id_type' => 0,
        'Detail' => $Detail,
        'Kms_aller' => $Kms_aller,
        'Repas' => $Repas,
        'Peage' => $Peage,
        'Hotel' => $Hotel,
        'Autre' => $Autre));

// La table facture sert a avoir tout tes trucs en rapide et la table detail sert a avoir le detail de tes factures
    // Donc il faut que tu enregistre dans les 2 ta tables ;
    $req = $bdd->prepare('INSERT INTO facture (Id_foyer, Id_date, Id_type_inter) VALUES (:Id_foyer, :curdate, :Id_type_inter )');
    $req->execute(array(
        'Id_foyer' => $Id_foyer,
        'curdate' => $Current_date,
        'Id_type_inter' => '2'));

    $file = $_FILES['file_kms_aller']['tmp_name'];
    if (!file_exists($directory . $Id_foyer . '_' . $Current_date)) { // Si le dossier n'existe pas on le crée avec l'id du foyer qui est censé etre unique
        mkdir($directory . $Id_foyer . '_' . $Current_date , 777);
    }
    if (!move_uploaded_file($file, $directory . $Id_foyer . '_' . $Current_date . '/' . $_FILES['file_kms_aller']['name'])) {
        echo "Impossible de copier le fichier dans" . $directory . $Id_foyer . '_' . $Current_date . '/' . $_FILES['file_kms_aller']['name'];
    } else {
        echo "Le fichier a bien été uploader";
        /*
             * ATTENTION IL FAUT CHANGER DANS LA REQUERE prepare() le chiffre qui suit :Id_type_inter
             * C'est ce qui defini le champs !!
         * Il faut aussi changer le Name_files dasn chaque reqete
             * */
        $req = $bdd->prepare('INSERT INTO fichiers(Id_foyer, Id_date, Id_type_install, Id_type, Id_dossier, Fichier, Url) 
                                        VALUES (:Id_foyer, :curdate , :Id_type_inter , 1 , :Id_foyer , :Name_files , :Files_chemin) ');
        $req->execute(array(
            'Id_foyer' => $Id_foyer,
            'curdate' => $Current_date,
            'Id_type_inter' => '2',
            'Name_files' => $_FILES['file_kms_aller']['name'],
            'Files_chemin' => $directory . $Id_foyer . '_' . $Current_date));
    }


    $file = $_FILES['file_repas']['tmp_name'];
    if (!file_exists($directory . $Id_foyer . '_' . $Current_date)) { // Si le dossier n'existe pas on le crée avec l'id du foyer qui est censé etre unique
        mkdir($directory . $Id_foyer . '_' . $Current_date , 777);
    }
    if (!move_uploaded_file($file, $directory . $Id_foyer . '_' . $Current_date . '/' . $_FILES['file_repas']['name'])) {
        echo "Impossible de copier le fichier dans" . $directory;
    } else {
        echo "Le fichier a bien été uploader";
        /*
             * ATTENTION IL FAUT CHANGER DANS LA REQUERE prepare() le chiffre qui suit :Id_type_inter
             * C'est ce qui defini le champs !!
         * * Il faut aussi changer le Name_files dasn chaque reqete
             * */
        $req = $bdd->prepare('INSERT INTO fichiers(Id_foyer, Id_date, Id_type_install, Id_type, Id_dossier, Fichier, Url) 
                                        VALUES (:Id_foyer, :curdate , :Id_type_inter , 4 , :Id_foyer , :Name_files , :Files_chemin) ');
        $req->execute(array(
            'Id_foyer' => $Id_foyer,
            'curdate' => $Current_date,
            'Id_type_inter' => '2',
            'Name_files' => $_FILES['file_repas']['name'],
            'Files_chemin' => $directory . $Id_foyer . '_' . $Current_date));
    }


    $file = $_FILES['file_peage']['tmp_name'];
    if (!file_exists($directory . $Id_foyer . '_' . $Current_date)) { // Si le dossier n'existe pas on le crée avec l'id du foyer qui est censé etre unique
        mkdir($directory . $Id_foyer . '_' . $Current_date , 777);
    }
    if (!move_uploaded_file($file, $directory . $Id_foyer . '_' . $Current_date . '/' . $_FILES['file_peage']['name'])) {
        echo "Impossible de copier le fichier dans" . $directory;
    } else {
        echo "Le fichier a bien été uploader";
        /*
             * ATTENTION IL FAUT CHANGER DANS LA REQUERE prepare() le chiffre qui suit :Id_type_inter
             * C'est ce qui defini le champs !!
         * * Il faut aussi changer le Name_files dasn chaque reqete
             * */
        $req = $bdd->prepare('INSERT INTO fichiers(Id_foyer, Id_date, Id_type_install, Id_type, Id_dossier, Fichier, Url) 
                                        VALUES (:Id_foyer, :curdate , :Id_type_inter , 5 , :Id_foyer , :Name_files , :Files_chemin) ');
        $req->execute(array(
            'Id_foyer' => $Id_foyer,
            'curdate' => $Current_date,
            'Id_type_inter' => '2',
            'Name_files' => $_FILES['file_peage']['name'],
            'Files_chemin' => $directory . $Id_foyer . '_' . $Current_date));

    }


    $file = $_FILES['file_hotel']['tmp_name'];
    if (!file_exists($directory . $Id_foyer . '_' . $Current_date)) { // Si le dossier n'existe pas on le crée avec l'id du foyer qui est censé etre unique
        mkdir($directory . $Id_foyer . '_' . $Current_date , 777);
    }
    if (!move_uploaded_file($file, $directory . $Id_foyer . '_' . $Current_date . '/' . $_FILES['file_hotel']['name'])) {
        echo "Impossible de copier le fichier dans" . $directory;
    } else {
        echo "Le fichier a bien été uploader";

        /*
         * ATTENTION IL FAUT CHANGER DANS LA REQUERE prepare() le chiffre qui suit :Id_type_inter
         * C'est ce qui defini le champs !!
         * * Il faut aussi changer le Name_files dasn chaque reqete
         * */
        $req = $bdd->prepare('INSERT INTO fichiers(Id_foyer, Id_date, Id_type_install, Id_type, Id_dossier, Fichier, Url) 
                                        VALUES (:Id_foyer, :curdate , :Id_type_inter , 6 , :Id_foyer , :Name_files , :Files_chemin) ');
        $req->execute(array(
            'Id_foyer' => $Id_foyer,
            'curdate' => $Current_date,
            'Id_type_inter' => '2',
            'Name_files' => $_FILES['file_hotel']['name'],
            'Files_chemin' => $directory . $Id_foyer . '_' . $Current_date));
    }


    $file = $_FILES['file_autre']['tmp_name'];
    if (!file_exists($directory . $Id_foyer . '_' . $Current_date)) { // Si le dossier n'existe pas on le crée avec l'id du foyer qui est censé etre unique
        mkdir($directory . $Id_foyer . '_' . $Current_date , 777);
    }
    if (!move_uploaded_file($file, $directory . $Id_foyer . '_' . $Current_date . '/' . $_FILES['file_autre']['name'])) {
        echo "Impossible de copier le fichier dans" . $directory;
    } else {
        echo "Le fichier a bien été uploader";
        /*
                     * ATTENTION IL FAUT CHANGER DANS LA REQUERE prepare() le chiffre qui suit :Id_type_inter
                     * C'est ce qui defini le champs !!
         * * Il faut aussi changer le Name_files dasn chaque reqete
                     * */
        $req = $bdd->prepare('INSERT INTO fichiers(Id_foyer, Id_date, Id_type_install, Id_type, Id_dossier, Fichier, Url) 
                                        VALUES (:Id_foyer, :curdate , :Id_type_inter , 7 , :Id_foyer , :Name_files , :Files_chemin) ');
        $req->execute(array(
            'Id_foyer' => $Id_foyer,
            'curdate' => $Current_date,
            'Id_type_inter' => '2',
            'Name_files' => $_FILES['file_autre']['name'],
            'Files_chemin' => $directory . $Id_foyer . '_' . $Current_date));


    }

}

// je prend tout de detail en les rangé pas ordre decroissant par Id_date
$reqListe = $bdd->query("SELECT * FROM details LEFT JOIN facture ON details.Id_foyer = facture.Id_foyer  WHERE Id_type_install = '2' ORDER BY details.Id_date DESC");
$liste = $reqListe->fetchAll();
foreach ($liste as $key => $value) {
    $liste[$value['Id_foyer']]['Pdf'] = $value['Id_type_inter'];
    $liste[$value['Id_foyer']]['Id_foyer'] = $value['Id_foyer'];
    $liste[$value['Id_foyer']]['Id_date'] = $value['Id_date'];
    $liste[$value['Id_foyer']]['Id_type_install'] = $value['Id_type_install'];

    switch ($value['Id_type']) {
        case 1 : // Kms_aller
            $liste[$value['Id_foyer']]['Kms_aller'] = $value['Detail'];
            break;
        case 2 : //Forfait
            $liste[$value['Id_foyer']]['Forfait'] = $value['Detail'];
            break;
        case 3 : //Nbr de poste
            $liste[$value['Id_foyer']]['Temps_passe'] = $value['Detail'];
            break;
        case 4 : //Repas
            $liste[$value['Id_foyer']]['Repas'] = $value['Detail'];
            break;
        case 5 : //Peages
            $liste[$value['Id_foyer']]['Peage'] = $value['Detail'];
            break;
        case 6 : //Hotels
            $liste[$value['Id_foyer']]['Hotel'] = $value['Detail'];
            break;
        case 7 : //Autres
            $liste[$value['Id_foyer']]['Autre'] = $value['Detail'];
            break;
    }

    if ($key != $value['Id_foyer']) {
        unset($liste[$key]);
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


<!-- /.navbar-top-links -->

<?php include("../php/menus.php"); ?>

</nav>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Rédiger son Compte-Rendu : Intervention </h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Intervention
                    <button type="button" class="btn btn-primary btn-circle" data-toggle="modal"
                            data-target=".bd-example-modal-lg" style="margin-left: 90%; "><i class="fa fa-plus"></i>
                    </button>

                    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
                         aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modalMargin">
                            <div class="modalperso">

                                <div class="modal-header">
                                    <h1 class="modal-title" id="exampleModalLabel">Compte Rendu intervention :</h1>
                                </div>
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
                                                                   name="foyer">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="date" class="col-sm-3 control-label"
                                                               style="padding-top: 0%">Date Intervention</label>
                                                        <div class="col-sm-9">
                                                            <input type="date" class="form-control" id="date"
                                                                   name="date">
                                                        </div>

                                                    </div>

                                                    <div class="form-group">
                                                        <label for="description" class="col-sm-3 control-label">Kms
                                                            aller</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="kms_aller"
                                                                   name="kms_aller">
                                                            <span>
                                        <input type="file" class="form-control-file" id="file_kms_aller"
                                               name="file_kms_aller">
                                </span>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="amount" class="col-sm-3 control-label"
                                                               style="padding-top: 0%">Temps Passé </label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="temps_passe"
                                                                   name="temps_passe">
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
                                                            <input type="text" class="form-control" id="repas"
                                                                   name="repas">
                                                            <span>
                                        <input type="file" class="form-control-file" id="fiche_repas" name="file_repas">
                                </span>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="description"
                                                               class="col-sm-3 control-label">Péages</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="peage"
                                                                   name="peage">
                                                            <span>
                                        <input type="file" class="form-control-file" id="fiche_peage" name="file_peage">
                                </span>
                                                        </div>

                                                    </div>

                                                    <div class="form-group">
                                                        <label for="amount"
                                                               class="col-sm-3 control-label">Hotels</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="hotel"
                                                                   name="hotel">
                                                            <span>
                                        <input type="file" class="form-control-file" id="fiche_hotel" name="file_hotel">
                                </span>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="amount"
                                                               class="col-sm-3 control-label">Autres</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="autre"
                                                                   name="autre">
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
                                    <button type="button" onclick="$('#form').submit();" class="btn btn-primary">
                                        Sauvegarder les changements
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>

            <tr>
                <th>Foyer</th>
                <th>Date d'intervention</th>
                <th>Type d'intervention</th>
                <th>Nbrs de KM aller parcourus</th>
                <th>Temps passé (centième d'heure)</th>
                <th>Repas</th>
                <th>Péages</th>
                <th>Hotels</th>
                <th>Autres types de frais</th>
                <th>Action</th>
            </tr>
            </thead>
            <?php
            foreach ($liste as $item) {
                ?>
                <tr class="odd gradeX">
                    <td><?php echo $item['Id_foyer']; ?></td>
                    <td><?php echo $item['Id_date']; ?></td>
                    <td><?php echo "Intervention" ?></td>
                    <td><?php echo $item['Kms_aller']; ?></td>
                    <td><?php echo $item['Temps_passe']; ?></td>
                    <td><?php echo $item['Repas']; ?></td>
                    <td><?php echo $item['Peage']; ?></td>
                    <td><?php echo $item['Hotel']; ?></td>
                    <td><?php echo $item['Autre']; ?></td>
                    <td>
                        <i class="fa fa-trash"
                           onclick="document.location.href = 'intervention.php?supp=<?php echo $item['Id_foyer']; ?>' "></i>
                        <i class="fa fa-edit"
                           onclick="document.location.href = 'detail_inter.php?foyer=<?php echo $item['Id_foyer']; ?>' ">
                        </i>
                    </td>
                    <?php
                    if($_SESSION['ADMIN'] == 1) {
                    if($item['Pdf'] == 1){
                        ?>
                        <i class="fa fa-ban"
                           onclick="document.location.href = 'intervention.php?no_valid=<?php echo $item['Id_foyer']; ?>' ">
                        </i>
                        <?php
                    }else{
                        ?>
                        <i class="fa fa-check"
                           onclick="document.location.href = 'intervention.php?valid=<?php echo $item['Id_foyer']; ?>' ">
                        </i>
                        <?php
                    }
                    ?>

                </tr>
                <?php
            }
            }
            ?>

            </tbody>
        </table>


        <!-- jQuery -->
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

        <!-- Page-Level Demo Scripts - Tables - Use for reference -->

        <script>


            $(document).ready(function () {
                $('#dataTables-example').DataTable({
                    responsive: true
                });
            });


            function calc_total() {
                var sum = 0;
                $('.input-amount').each(function () {
                    sum += parseFloat($(this).text());
                });
                $(".preview-total").text(sum);
            }

            $(document).on('click', '.input-remove-row', function () {
                var tr = $(this).closest('tr');
                tr.fadeOut(200, function () {
                    tr.remove();
                    calc_total()
                });
            });

            $(function () {
                $('.preview-add-button').click(function () {
                    var form_data = {};
                    form_data["foyer"] = $('.payment-form input[name="foyer"]').val();
                    form_data["kms_aller"] = $('.payment-form input[name="kms_aller"]').val();
                    form_data["temps_passe"] = parseFloat($('.payment-form input[name="temps_passe"]').val()).toFixed(2);
                    form_data["repas"] = $('.payment-form #status option:selected').text();
                    form_data["date"] = $('.payment-form input[name="date"]').val();

                    form_data["peage"] = $('.payment-form input[name="peage"]').val();
                    form_data["hotel"] = $('.payment-form input[name="hotel"]').val();
                    form_data["autre"] = $('.payment-form input[name="autre"]').val();
                    form_data["remove-row"] = '<span class="glyphicon glyphicon-remove"></span>';
                    var row = $('<tr></tr>');
                    $.each(form_data, function (type, value) {
                        $('<td class="input-' + type + '"></td>').html(value).appendTo(row);
                    });
                    $('.preview-table > tbody:last').append(row);
                    calc_total();
                });
            });


        </script>

</body>

</html>

