<?php

// Ici, il faudra commencer par comparer les informations renseignées dans le formulaire avec ce qui se trouve dans notre base de données.

include("../../php_scripts/DB_connection.php");

// On a maintenant accès à la variable $DB_connection (à utiliser pour toutes manips concernant la BDD)

// 1) Récupérer les données du formulaire : login et mdp, les stocker dans 2 variables

$login = $_POST["user_login"];
$password = $_POST["user_password"];

// 2) Envoyer une requête vers la BDD : trouver dans la table admin_sessions une ligne contenant à la fois le login et le mot de passe (en passant ce dernier dans la fonction PASSWORD() )

// > La requête : Sélectionner toute ligne dans la table, où login vaut valeur_login_récupérée et password vaut PASSWORD(valeur_mdp_récupérée)

//$SQL_query = "SELECT * FROM `admin_sessions` WHERE `login` = '$login' AND `password`= PASSWORD('$password')";
// Note : avec cette manière (sans gérer l'échappement des caractères problématiques), on peut détourner la requête et se connecter sans connaître le bon mot de passe. Il suffit de renseigner le bon login, suivi de '# (fausser la délimitation de la valeur à tester, et mettre le reste de la requête en commentaire via #)

//$preparation = $DB_connection->query($SQL_query);

// La manière suivante gère automatiquement ce type de problème car les valeurs sont préparées
$SQL_query = "SELECT * FROM `admin_sessions` WHERE `login` = ? AND `password`= PASSWORD(?)";

$preparation = $DB_connection->prepare($SQL_query);

$preparation->execute([$login , $password]);

$rows = $preparation->fetchAll(); // Les lignes correspondant à notre recherche

// 3) A-t-on trouvé au moins un résultat ?

//var_dump($rows);

if (count($rows) > 0) { // Si il y a au moins un résultat correspondant (donc l'authentification est valide)
    
    // Ici on peut établir une session (au nom de $login par exemple)
    
    session_start();
    
    $_SESSION["login"] = $login;
    
    header("location:../index.php"); // Ramener à l'index
    
} else {
    
    // On n'est pas connecté ! On ramène au formulaire de login.
    header("location:../login.php?error=1");
    // Le paramètre "?error=1" permet de détecter, au retour sur le formulaire, si il y a eu un souci d'authentification (le bon couple login / password n'a pas été trouvé dans la BDD)
    
}

?>