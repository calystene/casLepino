<?php
    require_once('./include/lib_connexion.php');
    auth();
    
    if(getUser()) {
      session_destroy();
    }
    
    header('location:index.php');

?>