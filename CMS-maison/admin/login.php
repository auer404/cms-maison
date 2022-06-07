<?php

session_start(); // Obligatoire avant toute manipulation du tableau $_SESSION

if ( isset($_SESSION["login"]) ) {
    
    // La session est déjà active, on peut rediriger immédiatement vers l'index
    header("location:index.php");
}

?>


<!DOCTYPE html>
<html lang="">

<head>
	<meta charset="utf-8">
	<title>Authentification</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="admin_style.css">

</head>

<body>

<?php

    $form_error_class = ""; // Par défaut, pas d'erreur, donc pas de classe à ajouter au formulaire
    
    // Test : y a-t-il un paramètre "error" dans l'URL, et vaut-il 1 ?
    if ( isset($_GET["error"]) && $_GET["error"] == 1 ) { // Il y a une erreur
        
        echo "<p>Erreur : identifiant ou mot de passe incorrect</p>";
        
        $form_error_class = " class = 'error' ";
        
    }
    
?>
	
	<form action="admin_php_scripts/action-login.php" method="post" <?php echo $form_error_class; ?>>
	    
	    <input type="text" name="user_login" placeholder="Votre identifiant">
	    
	    <input type="password" name="user_password" placeholder="Votre mot de passe">
	    
	    <input type="submit" value="Connexion">
	    
	</form>
	
</body>

</html>