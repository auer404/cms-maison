<?php

// Fermeture volontaire de session

session_start();

session_unset();
session_destroy();

header("location:../"); // Redirection hors du dossier admin

?>