<?php // Script de traitement : édition d'un contenu existant

// On commence par tester si on vient bien du formulaire. On peut pour cela vérifier l'envoi de ce fameux formulaire, via la présence dans $_POST d'une valeur sous la clé correspondant à l'attribut name de son bouton submit.
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

$id = $_POST["id"];
$title = $_POST["title"];
$content = $_POST["main_content"];

// établir la nécessité du supprimer l'image (manière longue) :
//$delete_image = false; // par défaut l'image ne doit pas être supprimée
//if (isset($_POST["delete_image"])) { // Mais si la case est cochée,
//    $delete_image = true; // il faudra finalement la supprimer
//}
// ou, pour optimiser :
$delete_image = isset($_POST["delete_image"]); // $delete_image prend la valeur retournée par cet appel à isset (donc soit true, soit false)

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

// 3) Requête(s) :

// a) Mettre à jour les colonnes title et main_content (de la ligne qui nous intéresse)

$SQL_query = "UPDATE `contents` SET `title` = ? , `main_content` = ? WHERE `id` = ?";

$preparation = $DB_connection->prepare($SQL_query);

$preparation->execute([$title , $content , $id]);

// b) Si $image_name est une valeur cohérente, mettre à jour dans un second temps la colonne image_name de cette même ligne

if ($image_name || $delete_image) { // $image_name n'est pas false et/ou une suppression a été demandée
    
    // Suppression éventuelle de l'ancien fichier (on teste d'abord s'il y en a un)
    
    $SQL_query = "SELECT * FROM `contents` WHERE `id` = $id";
        
    $result = $DB_connection->query($SQL_query);
    
    $row = $result->fetch();

    $old_image_name = $row["image_name"];

    if ($old_image_name != "") {
    
        $image_path = "../../uploads/".$old_image_name;
    
        if (file_exists($image_path)) { // Si le fichier existe bien
        
            unlink($image_path); // On le supprime
        }
        
    }
    
    // Mise à jour de l'image
  
    $SQL_query = "UPDATE `contents` SET `image_name` = ? WHERE `id` = ?";

    $preparation = $DB_connection->prepare($SQL_query);

    $preparation->execute([$image_name , $id]);
    
}

// 4) Rediriger vers l'index de la section admin

header("location:../index.php");

?>