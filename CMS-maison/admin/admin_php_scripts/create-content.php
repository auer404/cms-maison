<?php // Script de traitement : création d'un nouveau contenu

// On commence par tester si on vient bien du formulaire (cas obligatoire pour considérer qu'un ajout doit être fait). On peut pour cela vérifier l'envoi de ce fameux formulaire, via la présence dans $_POST d'une valeur sous la clé correspondant à l'attribut name de son bouton submit.
if (!isset($_POST["editor_validation"])) {
    header("location:../index.php");
    exit(); // On interromp le script
}

// 1) Connexion à la BDD, mise à disposition des outils nécessaires

include("../../php_scripts/DB_connection.php");
// On a accès à $DB_connection

include("upload_image.php");
// En incluant ceci, on a accès à la fonction upload_image()


// 2) Récupérer les données en provenance du formulaire

$title = $_POST["title"];
$content = $_POST["main_content"];

// Test : nos contenus requis ne sont-ils pas des chaines vides ?
// Note : Tester ceci sur des champs requis peut sembler redondant, MAIS l'attribut required peut être supprimé temporairement via l'inspecteur des navigateurs, donc on ne peut pas s'y fier à 100%
if ($title == "" || $content == "") {
    header("location:../index.php");
    exit(); // On interromp le script
}

// 2b) Uploader une éventuelle image et récupérer son nom de fichier

// ! \ On ne trouvera pas cette donnée dans $_POST mais dans $_FILES ! La fonction upload_image() utilisée ci-dessous permet de bien gérer cette récupération.

// Upload du fichier provenant de l'input name="image", à destination du dossier "uploads/" (hors-admin).
$image_name = upload_image("image" , "../../uploads/");
//  La valeur renvoyée (et stockée dans $image_name) si la fonction a marché sera le nom final du fichier, ou false dans le cas inverse

// 3) Préparer une requête SQL pour insérer ces données dans une nouvelle ligne de la table des contenus

$SQL_query = "INSERT INTO `contents` (`title` , `main_content` , `image_name`) VALUES (? , ? , ?)";

$preparation = $DB_connection->prepare($SQL_query);

// 3b) Exécuter cette requête

$preparation->execute([$title , $content , $image_name]);


// 4) Rediriger vers l'index de la section admin

header("location:../index.php");

?>