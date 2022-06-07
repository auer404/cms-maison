<?php
include("admin_php_scripts/check-session.php");
// En incluant ceci, un utilisateur non connecté sera automatiquement "chassé"


// Valeurs à afficher dans le cas par défaut : mode création de contenu
$action_script = "create-content.php";
$form_title = "Ajouter un contenu :";
$submit_caption = "Créer";
$title_in_field = "";
$main_content_in_field = "";
$image_tag = "";
$id_input_tag = "";


if (isset($_GET["id"])) { // On est À PRIORI en mode édition
    
    include("../php_scripts/DB_connection.php");
    
    $id = $_GET["id"];
    
    // Dans l'idéal, on vérifie si cet id existe bien dans la table contents.
    // > Utiliser une requête SELECT ... WHERE
    
    $SQL_query = "SELECT * FROM `contents` WHERE `id` = $id";
        
    $result = $DB_connection->query($SQL_query);
    
    $rows = $result->fetchAll();
    
    $row_count = count($rows); // Le nombre d'éléments retournés par la requête
    
    if ($row_count > 0) { // On est CERTAINS d'être en mode édition car un résultat existe, correspondant à l'id récupéré dans l'URL
        
        // Comme ce qu'on cherche est un identifiant unique, on est sûrs de n'avoir qu'une seule ligne correspondante dans la table. Et celle-ci sera forcément le premier élément de notre liste $rows
        $the_row = $rows[0];
        
        // On peut donc REMPLACER ce qui avait été préparé avant nos tests sur l'id
        
        $action_script = "update-content.php";
        $form_title = "Modifier un contenu :";
        $submit_caption = "Mettre à jour";
        $title_in_field = $the_row["title"];
        $main_content_in_field = $the_row["main_content"];
        if ($the_row["image_name"] != "") {
            $image_tag = "<img src='../uploads/".$the_row["image_name"]."'>";
            $image_tag .= "<p><input type='checkbox' name='delete_image' id='delete_image'>";
            $image_tag .=  "<label for='delete_image'>Supprimer l'image</label></p>";
        }
        $id_input_tag = "<input type='hidden' name='id' value='$id'>";
        
    }
  
}

?>

<!DOCTYPE html>
<html lang="">

<head>
	<meta charset="utf-8">
	<title>Editeur de contenus</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="admin_style.css">
</head>

<body>

	<header>
    
        Bonjour, <?php echo $_SESSION["login"]; ?> - <a href = "index.php">Retour</a> - <a href = "logout.php">Déconnexion</a>
        
    </header>
    
    <main>
	
        <form action="admin_php_scripts/<?php echo $action_script; ?>" method="post" enctype="multipart/form-data">
        
        <h3><?php echo $form_title; ?></h3>
        
            <input type="text" name="title" value="<?php echo $title_in_field; ?>" placeholder="Titre" required>
            
            <textarea name="main_content" placeholder="Contenu principal" required><?php echo $main_content_in_field; ?></textarea>
            
            <?php echo $image_tag; ?>
            <!--
            
            > Pour améliorer l'interface, on peut camoufler la case à cocher et faire en sorte que ce soit un bouton (type croix de fermeture placé dans un coin de l'image) qui l'active. On peut utiliser JS pour ça.
            
            > Via JS également, on peut influer sur l'apparence de l'image. Elle peut apparaître grisée une fois qu'on a choisi de la supprimer, et éventuellement aussi lorsqu'une nouvelle image a été choisie via l'élément input qui suit.
            
            -->
            
            <p>Image : <input type="file" name="image"></p>
            
            <?php echo $id_input_tag; ?>
            
            <input type="submit" name="editor_validation" value="<?php echo $submit_caption; ?>">
            
        </form>
    
    </main>
    
</body>

</html>