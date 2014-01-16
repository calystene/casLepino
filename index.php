<?php 
  require_once('./include/lib_connexion.php');
  require('./include/lib_mkTable.php');
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
    <meta author="Pierard et Hequet" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <title>CasLepino</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>


<?php

   
   include('./html/entete.php');
   include('./html/menu.php');
   
   if(isset($_GET['page'])){
    switch($_GET['page']) {
      case "accueil":
	include('./html/accueil.php');
	break;
	
      case "produit":
	include('./html/produits.php');
	break;
	
      case "compte":
	include('./html/compte.php');
	break;
	
      case "commandes":
	include('./html/commandes.php');
	break;
	
      default:
	include('./html/accueil.php');
	break;
    }
   }else{include('./html/accueil.php');}


// VOIR POUR EXTERNALISER LE FOOTER DES PAGES PRODUITS / ACCUEIL / COMPTE 
//include('./html/footer.html');
   
?>


  </body>
</hmtl>
