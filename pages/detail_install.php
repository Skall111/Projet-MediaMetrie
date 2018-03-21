<?php
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
            <h1 class="page-header">Modifier son Compte-Rendu : Installation </h1>
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