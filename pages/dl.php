<?php
$file = $_GET['chemin'].'/'.$_GET['fichier'] ;
if (file_exists($file)) {
    if(isset($_GET['supp']) && $_GET['supp'] == 1){
        unlink($file);
        include '../php/Db.php';
        $string_req = 'DELETE FROM fichiers WHERE  Url = "'. $_GET['chemin'] . '" AND Fichier = "'.$_GET['fichier'] .'" LIMIT 1 ';
        $req = $bdd->prepare($string_req);
        $req->execute();
        echo "Le fichier a bien été supprimer ";
        exit ;
    }
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.basename($file).'"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($file));
readfile($file);
exit;
}else {
echo "Aucun fichier trouve ";
exit ;
}

?>