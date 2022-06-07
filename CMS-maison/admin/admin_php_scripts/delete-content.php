<?php // Script de traitement : suppression d'un contenu

// On commence par tester si on vient bien du formulaire (cas obligatoire pour considérer qu'un ajout doit être fait).
if (!isset($_POST["id"])) {
    header("location:../index.php");
    exit(); // On interromp le script
}

// 1) Connexion à la BDD

include("../../php_scripts/DB_connection.php");
// On a accès à $DB_connection

// 2) Récupérer les données en provenance du formulaire

$id = $_POST["id"];


// Test : l'id est-il bien en place ? (Normalement ce sera toujours le cas car cette donnée vient d'un input caché, non modifiable SAUF si l'utilisateur est allé modifier des choses dans le formulaire via l'inspecteur)
if ($id == "") { // Note : ce test pourrait être amélioré !
    header("location:../index.php");
    exit(); // On interromp le script
}

// Nouveau : gestion de la suppression éventuelle de l'image rattachée au contenu concerné


//• Récupérer le contenu de la colonne image_name (ou équivalent) pour la ligne qui nous intéresse

$SQL_query = "SELECT * FROM `contents` WHERE `id` = $id";
        
$result = $DB_connection->query($SQL_query);
    
$row = $result->fetch(); // fetch() récupèrera une seule ligne à la fois. Plus adapté ici que fetchAll() car on sait que notre résultat sera de toute façon une seule ligne.

$image_name = $row["image_name"];

if ($image_name != "") {
    
    $image_path = "../../uploads/".$image_name;
    
    if (file_exists($image_path)) { // Si le fichier existe bien
        
        unlink($image_path); // On le supprime
    }
        
}


// 3) Préparer une requête SQL pour supprimer la ligne de notre table correspondant à l'id réceptionné

$SQL_query = "DELETE FROM `contents` WHERE `id` = ?";

$preparation = $DB_connection->prepare($SQL_query);

// 3b) Exécuter cette requête

$preparation->execute([$id]);


// 4) Rediriger vers l'index de la section admin

header("location:../index.php");

?>