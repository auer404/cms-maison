<?php

include("DB_connection.php");
// Met à disposition la variable $DB_connection (qui permet de se connecter à la BDD)

/*

La fonction get_content() doit pouvoir, d'après un id et un nom de colonne, récupérer le contenu de la table contents, se trouvant à la ligne d'identifiant id, dans la colonne "nom de colonne".

Le résultat éventuellement trouvé dans la BDD devra plutôt être retourné que directement affiché.

*/

function get_content($id , $column_name) { // En premier lieu, prévoir de fonctionner avec deux paramètres : un id (numérique) et un nom de colonne (texte)
    
    // Pour accéder à la variable $DB_connection définie hors de cette fonction (portée globale), il faut utiliser le mot-clé "global" suivi du nom de la variable.
    global $DB_connection;
    
    $SQL_query = "SELECT * FROM `contents` WHERE `id` = $id"; // La ligne sélectionnée dépend du paramètre $id
        
    $result = $DB_connection->query($SQL_query);
    
    $row = $result->fetch();
    
    $value = $row[$column_name]; // La colonne récupérée dépend du paramètre $column_name
    
    return $value;
    
    
}

// Fonctions-raccourcis - dans le style de Wordpress

function the_title() {
    
    global $id; // Cet id sera celui mis en place automatiquement par check-id.php
    
    echo get_content($id , "title");
}

function the_content() {
    
    global $id;
    
    echo nl2br(get_content($id , "main_content"));
    
}

function the_image_src() {
   
    global $id;
    
    echo "uploads/".get_content($id , "image_name");
}

?>