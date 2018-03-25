<?php
session_start(); // J'évite de perdre les données en changeant de page sur la même session
//echo $_SESSION['id'];// Afficher l'ID de l'ambassadeur
//echo $_SESSION['prenom_amba'];// Afficher le prénom de l'ambassaeur
//var_dump($_POST);
if(!isset($_SESSION['id'])){
    header('Location: ../php/connexion.php');
    exit;
}

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


// je prend tout de detail en les rangé pas ordre decroissant par Id_date
$reqListe = $bdd->query("SELECT * FROM details LEFT JOIN facture ON details.Id_foyer = facture.Id_foyer  ORDER BY details.Id_date DESC");
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

    <title>Facture</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
    <link href="../vendor/datatables/css/buttons.dataTables.css" rel="stylesheet">

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



<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Generer vos factures </h1>
        </div>
        <!-- /.col-lg-12

    </div>
    <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Facture

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
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($liste as $item) {
                    ?>
                    <tr class="odd gradeX">
                        <td><?php echo $item['Id_foyer']; ?></td>
                        <td><?php echo $item['Id_date']; ?></td>
                        <td>
                            <?php
                            if ($item['Id_type_install'] == "1") {
                                echo "Installation";
                            } elseif ($item['Id_type_install'] == "2"){
                                echo "Intervention";
                            }

                            ?>
                            </td>
                        <td>
                            <?php
                            if ($item['Forfait'] == "1") {
                                echo "Web - Démo";
                            } else {
                                echo "Démo";
                            }

                            ?>
                        </td>
                        <td><?php echo $item['Kms_aller'] * 1,25; ?></td>
                        <td><?php echo $item['Nb_Poste'] * 1; ?></td>
                        <td><?php echo $item['Repas'] * 3 ; ?></td>
                        <td><?php echo $item['Peage'] * 4; ?></td>
                        <td><?php echo $item['Hotel'] * 5; ?></td>
                        <td><?php echo $item['Autre'] * 6; ?></td>

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
    <script src="../vendor/datatables/Buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendor/datatables/Buttons/js/buttons.bootstrap.min.js"></script>
    <script src="../vendor/datatables/Buttons/js/buttons.flash.min.js"></script>
    <script src="../vendor/datatables/Buttons/js/jszip.min.js"></script>
    <script src="../vendor/datatables/Buttons/js/pdfmake.min.js"></script>
    <script src="../vendor/datatables/Buttons/js/vfs_fonts.min.js"></script>
    <script src="../vendor/datatables/Buttons/js/buttons.html5.min.js"></script>
    <script src="../vendor/datatables/Buttons/js/buttons.print.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->

    <script>


        $(document).ready(function () {
            $('#dataTables-example').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'pdfHtml5',

                    }
                ]
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