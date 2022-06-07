<?php
include("admin_php_scripts/check-session.php");
// En incluant ceci, un utilisateur non connecté sera automatiquement "chassé"
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
    
    <?php
    
    if (...) {
        $script_php = "script01.php";
        $content = "";
    } else {
        $script_php = "script02.php";
        $content = "Du contenu qui peut provenir de la BDD";
    }
    
    
    ?>
	
    <form action="admin_php_scripts/<?php echo $script_php; ?>" method="post">
    
        <input type="text" name="title" value="<?php echo $content; ?>">
        
        <textarea name="main_content"></textarea>
        
        <input type="submit" value="Créer">
        
    </form>
    
</body>

</html>