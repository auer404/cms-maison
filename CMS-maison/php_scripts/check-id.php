<?php

include("php_scripts/DB_connection.php");

$id_is_valid = true;

if ( isset($_GET["id"]) && intval($_GET["id"]) != 0 ) {
    
    // ICI : Tester si une ligne dans la table contents contient cet id dans la bonne colonne
    // Si c'est le cas : on pourra utiliser cet id sur la page actuelle, et $id_is_valid ne change pas
    $id = intval($_GET["id"]); // $id est l'identifiant à utiliser avec get_contents()
    // Note : intval() permet de garantir un id cohérent, même si ce qui se trouvant dans l'URL était sous la forme "1aaa" ou "2." (un nombre suivi d'autres caractères)
    
    $SQL_query = "SELECT * FROM `contents` WHERE `id` = $id";
        
    $result = $DB_connection->query($SQL_query);
    
    $rows = $result->fetchAll();
    
    if (count($rows) == 0) { // Pas de résultat dans la table
        
        // Option 1 : si l'article demandé n'existe pas, on prévoit de rediriger vers le dernier article existant dans la table
        
       //$id_is_valid = false; 
        
        // Option 2 : on peut tout de suite rediriger vers la page 404
        header("location:404.php");
        exit();
        
    }
    
    // Si ce n'est pas le cas : on passe la valeur de $id_is_valid à false
    
} else { // Pas d'id renseigné dans l'url
   
    $id_is_valid = false;
    
}

// À l'issue de ces tests sur l'id potentiellement trouvé dans l'url, la variable $id_is_valid nous indique simplement si on peut rester sur la page ou si on doit rediriger

if (!$id_is_valid) { // Soit on n'a pas d'id renseigné, soit celui-ci n'existe pas dans la table
    // Donc on essaie de rediriger vers une version valide : celle où l'id est celui du dernier contenu créé
    
    // On cherche le plus grand id disponible dans notre table contents
    $SQL_query = "SELECT MAX(id) FROM `contents`";
    
    $result = $DB_connection->query($SQL_query);
    
    $row = $result->fetch();
    
    $id = $row[0];
    
    if ($id == NULL) { // Si on obtient NULL, c'est que la table est vide, on n'a donc pas d'identifiant correct permettant d'afficher du contenu. On peut par exemple amener vers une page 404
        header("location:404.php");
        exit();
    }
    
    header("location:?id=".$id);
    exit();
    
}

// Ici : vérifier qu'on a un paramètre "id=" dans l'URL.
// Si c'est le cas, en stocker la valeur dans une variable $id (qui sera utilisée en 1er paramètre lorsqu'on appellera get_content() )
// Si ce n'est pas le cas : ???

// Note : on a un exemple dans editor.php

?>