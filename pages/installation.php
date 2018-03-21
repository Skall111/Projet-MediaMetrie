<?php
session_start(); // J'évite de perdre les données en changeant de page sur la même session
//echo $_SESSION['id'];// Afficher l'ID de l'ambassadeur
//echo $_SESSION['prenom_amba'];// Afficher le prénom de l'ambassaeur
//var_dump($_POST);


/*
 * POUR DILMEN
 * Il faut que chaque champs est un numero
 * On devra les definir dans un ordre bien precis
 * 1 => Kms_aller
 * 2 => Forfait
 * 3 => Nbr de poste
 * 4 => Repas
 * 5 => Peages
 * 6 => Hotels
 * 7 => Autres
 *
 * En fait le Type dasn la partie detail c'est le nom du champs et detail c'est sa valeur
 * Il a fait ca pour faire le lien entre chaque fichier telecharger et son champ ...
 * */


include '../php/Db.php';
if (isset($_GET['supp'])) {
    $req = $bdd->prepare('DELETE FROM facture  WHERE Id_foyer = :Id_foyer LIMIT 1 ');
    $req->execute(array(
        'Id_foyer' => $_GET['supp']));

    $req = $bdd->prepare('DELETE FROM details  WHERE Id_foyer = :Id_foyer LIMIT 1 ');
    $req->execute(array(
        'Id_foyer' => $_GET['supp']));

    header('Location: installation.php');
    exit();
}

if (isset ($_POST) && !empty($_POST)) {
    //Il faut le chemin complet
    $directory = "/Applications/MAMP/htdocs/Projet-MediaMetrie/Files/";
// Insertion
    $Id_foyer = $_POST['foyer'];
    $Current_date = $_POST['date'];
    $Id_type = isset($_POST['packweb']) ? 2 : 1;
    $Detail = $_POST['nbr_poste'];
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
        'Autre' => $Autre));

// La table facture sert a avoir tout tes trucs en rapide et la table detail sert a avoir le detail de tes factures
    // Donc il faut que tu enregistre dans les 2 ta tables ;
    $req = $bdd->prepare('INSERT INTO facture (Id_foyer, Id_date, Id_type_inter) VALUES (:Id_foyer, :curdate, :Id_type_inter )');
    $req->execute(array(
        'Id_foyer' => $Id_foyer,
        'curdate' => $Current_date,
        'Id_type_inter' => '1'));


// Ce script est a dupliquer autant de fois qu'il y'a de fichier a enregistrer
    //Faut pas oublier de mettre un name a l'input file (moi j'ai mis file_kms_aller)
    // Il est valable que pour kms_aller  ;

    $file = $_FILES['file_kms_aller']['tmp_name'];
    if (!file_exists($directory . $Id_foyer)) { // Si le dossier n'existe pas on le crée avec l'id du foyer qui est censé etre unique
        mkdir($directory . $Id_foyer);
    }
    if (!move_uploaded_file($file, $directory . $Id_foyer . '/kms.jpg')) {
        echo "Impossible de copier le fichier dans" . $directory;
    } else {
        echo "Le fichier a bien été uploader";


    $file = $_FILES['fiche_repas']['tmp_name'];
    if (!file_exists($directory . $Id_foyer)) { // Si le dossier n'existe pas on le crée avec l'id du foyer qui est censé etre unique
            mkdir($directory . $Id_foyer);
        }
    if (!move_uploaded_file($file, $directory . $Id_foyer . '/repas.jpg')) {
            echo "Impossible de copier le fichier dans" . $directory;
    } else {
            echo "Le fichier a bien été uploader";


    $file = $_FILES['fiche_peage']['tmp_name'];
    if (!file_exists($directory . $Id_foyer)) { // Si le dossier n'existe pas on le crée avec l'id du foyer qui est censé etre unique
                mkdir($directory . $Id_foyer);
    }
    if (!move_uploaded_file($file, $directory . $Id_foyer . '/peage.jpg')) {
        echo "Impossible de copier le fichier dans" . $directory;
    } else {
        echo "Le fichier a bien été uploader";


    $file = $_FILES['fiche_hotel']['tmp_name'];
    if (!file_exists($directory . $Id_foyer)) { // Si le dossier n'existe pas on le crée avec l'id du foyer qui est censé etre unique
            mkdir($directory . $Id_foyer);
        }
    if (!move_uploaded_file($file, $directory . $Id_foyer . '/hotel.jpg')) {
            echo "Impossible de copier le fichier dans" . $directory;
    } else {
            echo "Le fichier a bien été uploader";

    $file = $_FILES['fiche_autre']['tmp_name'];
    if (!file_exists($directory . $Id_foyer)) { // Si le dossier n'existe pas on le crée avec l'id du foyer qui est censé etre unique
            mkdir($directory . $Id_foyer);
        }
    if (!move_uploaded_file($file, $directory . $Id_foyer . '/hotel.jpg')) {
            echo "Impossible de copier le fichier dans" . $directory;
    } else {
            echo "Le fichier a bien été uploader";

        $req = $bdd->prepare('INSERT INTO fichiers(Id_foyer, Id_date, Id_type_install, Id_type, Id_dossier, Fichier, Url) 
                                        VALUES (:Id_foyer, :curdate , :Id_type_inter , 1 , :Id_foyer , :Name_files , :Files_chemin) ');
        $req->execute(array(
            'Id_foyer' => $Id_foyer,
            'curdate' => $Current_date,
            'Id_type_inter' => '1',
            'Name_files' => "kms.jpg",
            'Files_chemin' => $directory . $Id_foyer));
    }
//Fin Du script de DL

}
// je prend tout de detail en les rangé pas ordre decroissant par Id_date
$reqListe = $bdd->query("SELECT * FROM details  WHERE Id_type_install = '1' ORDER BY Id_date DESC");
$liste = $reqListe->fetchAll();

foreach ($liste as $key => $value) {
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
            $liste[$value['Id_foyer']]['Nb_Poste'] = $value['Detail'];
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

<!-- /.navbar-static-side -->
</nav>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg modalMargin">

        <div class="modalperso">

            <div class="modal-header">
                <h1 class="modal-title" id="exampleModalLabel">Compte Rendu installation :</h1>
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
                                         <input type="file" class="form-control-file"
                                                id="exampleFormControlFile1" name="file_kms_aller">
                                          </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="description"
                                           class="col-sm-3 control-label">Forfait</label>
                                    <div class="checkbox-install">
                                        <input type="checkbox" id="packweb" name="packweb"
                                               value="1">
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
                                               name="nbr_poste">
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
                                               name="repas">
                                        <span>
                                        <input type="file" class="form-control-file" id="fiche_repas">
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
                                        <input type="file" class="form-control-file" id="fiche_peage">
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
                                        <input type="file" class="form-control-file" id="fiche_hotel">
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

</div>


<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Rédiger son Compte-Rendu : Installation </h1>
        </div>
        <!-- /.col-lg-12

    </div>
    <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Installation
                        <button type="button" class="btn btn-primary btn-circle" data-toggle="modal"
                                data-target=".bd-example-modal-lg" style="margin-left: 90%; "><i class="fa fa-plus"></i>
                        </button>


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
                    <th>Forfait</th>
                    <th>Nbrs de KM aller parcourus</th>
                    <th>Nombres de Postes</th>
                    <th>Repas</th>
                    <th>Péages</th>
                    <th>Hotels</th>
                    <th>Autres types de frais</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($liste as $item) {
                    ?>
                    <tr class="odd gradeX">
                        <td><?php echo $item['Id_foyer']; ?></td>
                        <td><?php echo $item['Id_date']; ?></td>
                        <td><?php echo 'Installation' ?></td>
                        <td>
                            <?php
                            if ($item['Forfait'] == "1") {
                                echo "Web - Démo";
                            } else {
                                echo "Démo";
                            }

                            ?>
                        </td>
                        <td><?php echo $item['Kms_aller']; ?></td>
                        <td><?php echo $item['Nb_Poste']; ?></td>
                        <td><?php echo $item['Repas']; ?></td>
                        <td><?php echo $item['Peage']; ?></td>
                        <td><?php echo $item['Hotel']; ?></td>
                        <td><?php echo $item['Autre']; ?></td>
                        <td><i class="fa fa-trash"
                               onclick="document.location.href = 'installation.php?supp=<?php echo $item['Id_foyer']; ?>' ">

                            </i>
                            <i class="fas fa-edit"
                               onclick="document.location.href = 'detail_install.php<?php echo $item['Id_foyer']; ?>' ">

                            </i>

                        </td>


                    </tr>
                    <?php
                }
                ?>

                </tbody>
            </table>
        </div>

    </div>

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
                responsive: true,
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
            $('.preview-add-button').click(function () {//WHAT THAT ??? tout ça appartient au tableaux ah ok jcrois je vois
                var form_data = {};
                form_data["concept"] = $('.payment-form input[name="concept"]').val();
                form_data["description"] = $('.payment-form input[name="description"]').val();
                form_data["amount"] = parseFloat($('.payment-form input[name="amount"]').val()).toFixed(2);
                form_data["status"] = $('.payment-form #status option:selected').text();
                form_data["date"] = $('.payment-form input[name="date"]').val();
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