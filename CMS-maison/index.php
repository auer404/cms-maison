<?php

include("php_scripts/check-id.php");
// Ceci permet de vérifier la présence d'un id dans l'url et d'automatiquement renseigner ce qui y est trouvé dans une variable $id

?>


<!DOCTYPE html>
<html lang="">

<head>
	<meta charset="utf-8">
	<title>CMS Maison : Front-End</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Roboto:wght@100;400;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="style.css">

</head>

<?php include("php_scripts/get_content.php"); ?>

<body>
	
	<header>
    
    <?php
    
        /* Ici, générer un menu.
        
        Il doit se présenter sous la forme d'une liste de liens, dans un élément nav.
        
        La liste peut être générée comme sur admin/index.php : un élément de liste contenant un lien doit exister par ligne disponible dans la table des contenus.
        
        Si il n'existe aucune ligne dans la table, ce n'est pas la peine de générer quoi que ce soit (pas de nav, etc).
        
        */
        
    ?>
	    
	    <div class="header_col" id = "h1_container">
	        
	        <h1><?php the_title(); ?></h1>
	        
	    </div>
	    
	    <div class="header_col">
	        
	        <img src="<?php the_image_src(); ?>">
	        
	    </div>
	    
	    <div class = "ornament_dots"></div>
	    
	</header>
	
	<main>
	    
	    <div id="main_contents">
	        <?php the_content(); ?>
	    </div>
	    
	</main>
	
	<footer>
	    
	    <div class = "ornament_dots"></div>
	    
	</footer>
	
</body>

</html>