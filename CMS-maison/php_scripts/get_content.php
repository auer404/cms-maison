<?php

include("DB_connection.php");
// Met à disposition la variable $DB_connection (qui permet de se connecter à la BDD)

/*

La fonction get_content() doit pouvoir, d'après un id et un nom de colonne, récupérer le contenu de la table contents, se trouvant à la ligne d'identifiant id, dans la colonne "nom de colonne".

Le résultat éventuellement trouvé dans la BDD devra plutôt être retourné que directement affiché.

*/

function get_content() {
    
    // Pour accéder à la variable $DB_connection définie hors de cette fonction (portée globale), il faut utiliser le mot-clé "global" suivi du nom de la variable.
    global $DB_connection;
    

    
}

?>