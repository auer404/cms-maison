<?php // Ce bloc doit être inclus sur chaque page à protéger !

session_start(); // Obligatoire avant toute manipulation du tableau $_SESSION

if ( !isset($_SESSION["login"]) ) { // ou : isset($_SESSION["login"]) == false
    
    // La session n'est pas active donc l'utilisateur n'a pas le droit de rester sur cette page.
    
    header("location:login.php"); // On le renvoie au formulaire
    
}

?>