<?php
include("admin_php_scripts/check-session.php");
// En incluant ceci, un utilisateur non connecté sera automatiquement "chassé"

include("../php_scripts/DB_connection.php");

?>

<!DOCTYPE html>
<html lang="">

<head>
	<meta charset="utf-8">
	<title>CMS Maison - interface d'administration</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="admin_style.css">

</head>

<body>
    
	<header>
    
        Bonjour, <?php echo $_SESSION["login"]; ?> - <a href = "logout.php">Déconnexion</a>
        
    </header>
    
    <main>
    
        <a href = "editor.php">Ajouter un contenu</a>
        
        <?php // ICI : Faire apparaître la liste des contenus existants, avec possibilité de les éditer (et supprimer)
        
        // Rappel : le script de connexion à la BDD est inclus plus haut dans la page.
        
        // 1) Requête SQL : Récupérer toutes les lignes de la table des contenus
        $SQL_query = "SELECT * FROM `contents` ORDER BY id DESC";
        
        $result = $DB_connection->query($SQL_query);
        
        // 2) Récupérer un résultat sous forme de tableau
        $rows = $result->fetchAll();
        
        $row_count = count($rows); // Le nombre d'éléments retournés par la requête
        
        if ($row_count > 0) {
            echo "<ul>";
        }
        
        // 3) Passer en revue les éléments de ce tableau, générer le HTML nécessaire pour chacun :
        // Affichage du titre, lien vers "editor.php?id=IDENTIFIANT_UNIQUE_DE_LA_LIGNE"
        
        foreach($rows as $this_row) {
           
            $this_id = $this_row["id"];
            $this_title = $this_row["title"];
            
            // Sécurisation : empêcher le HTML dans les contenus (et par extension, l'ajout de scripts JS ou PHP malveillants !)
            // Ici on transforme $this_title
            $this_title = htmlentities($this_title);
            //ou : $this_title = htmlspecialchars($this_title);
            
            echo "<li>";
                
            echo "<a href='editor.php?id=$this_id'>$this_title</a>";
            
            echo "<form method='post' action='admin_php_scripts/delete-content.php'>";
            echo "<input type='hidden' name='id' value='$this_id'>";
            
            echo "<input type='submit' value='Supprimer' onclick='if (!confirm(\"Supprimer ce contenu ?\")) { return false }'>";
            
            echo "</form>";
            
            echo "</li>";
            
        }
        
        if ($row_count > 0) {
            echo "</ul>";
        } else {
            echo "<p>Aucun contenu existant</p>";
        }
            
        
        ?>

        
    </main>

</body>

</html>