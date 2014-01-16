<?php


$content = '';


if($user!=false && !$user->getAdmin()) {
  $connexion = connexion();
  
  
    
  if(isset($_GET['numCde'])) {
    $connexion = connexion();
 
    //Check si commande modififi\00
    if(isset($_POST['modifier'])) {
      //print_r($_POST);
      $keys = array_keys($_POST);
      
      foreach ($keys as $key) {
	if($key!='modifier') {	  
	  $num_art = preg_replace("/[^0-9]/","",$key);
	  
	  $stmt = $connexion->prepare("SELECT qte_commandee FROM public.detail WHERE num_cde=".$_GET['numCde']." AND num_art=".$num_art);
	  $stmt->execute();
	  $oldQte = $stmt->fetch();
	  $newQte = $_POST[$key];
	  
	  $diffQte = $oldQte['qte_commandee'] - $newQte;
	  
	  if($newQte==0) {
	    //Suppression de la commande
	    $stmt = $connexion->prepare("DELETE FROM detail WHERE num_cde=".$_GET['numCde'].' AND num_art='.$num_art);
	    $stmt->execute();
	  } else {
	    //modification de la quantite command\00e
	    $stmt = $connexion->prepare("UPDATE public.detail SET qte_commandee=".$newQte." WHERE num_cde=".$_GET['numCde']." AND num_art=".$num_art);
	    $stmt->execute();
	    maj_stock($diffQte);
	  }
	  
	  //mise \00 jour du stock
	  $stmt = $connexion->prepare("UPDATE public.article SET qte_dispo=(qte_dispo + ".$diffQte.') WHERE num_art='.$num_art);
	  $stmt->execute();
	}
      }
      
      header('Location:index.php?page=commandes&typeCmd='.$_GET['typeCmd'].'&numCde='.$_GET['numCde']);
      
      
    // Ici on valide la commande : public.terminee=TRUE
    }elseif(isset($_POST['valider'])) {
      $stmt = $connexion->prepare("UPDATE public.cde_fact SET terminee=TRUE WHERE num_cde=".$_GET['numCde']);
      $stmt->execute();
      header('Location:index.php?page=commandes');
      
    // ici on annule la commande 
    }elseif(isset($_POST['annuler'])) {
      
      $stmt = $connexion->prepare("SELECT num_art, qte_commandee FROM public.detail WHERE num_cde=".$_GET['numCde']);
      $stmt->execute();
      $nfo_articles = $stmt->fetchAll();
     

      //mise \00 jour du stock
      foreach($nfo_articles as $article) {
	$stmt = $connexion->prepare("UPDATE public.article SET qte_dispo=(qte_dispo + ".$article['qte_commandee'].') WHERE num_art='.$article['num_art']);
	$stmt->execute();
      }
      
      
      //Suppression de la commande
      $stmt = $connexion->prepare("DELETE FROM public.detail WHERE num_cde=".$_GET['numCde']);
      $stmt->execute();
      $stmt = $connexion->prepare("DELETE FROM public.cde_fact WHERE num_cde=".$_GET['numCde']);
      $stmt->execute();
      
      header('Location:index.php?page=commandes');
    }
    
    
    
    
 
    $stmt = $connexion->prepare("SELECT * FROM detail WHERE num_cde=".$_GET['numCde']);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    
    $nfo_Cde = $stmt->fetchAll();
  
    $content .= '<h4>Détails commande N°'.$_GET['numCde'].' :</h4>';
    
    
    
    // On gère la disponibilité des boutons suivant le type de commande
    $_GET['typeCmd']<>3 ? $canModif='disabled="disabled"' : $canModif='';

        $content .= '<form method="post" action="index.php?page=commandes&typeCmd='.$_GET['typeCmd'].'&numCde='.$_GET['numCde'].'">';

    if($_GET['page']=='commandes' && $_GET['typeCmd']==3){
      $content .= '<table id="btnPanier"><tr>';
      $content .= '<td><input type="submit" name="modifier" value="Modifier" '.$canModif.'/></td>';
      $content .= '<td><input type="submit" name="valider" value="Valider"'.$canModif.'/></td>';
      $content .= '<td><input type="submit" name="annuler" value="Annuler"'.$canModif.'/></td>';
      $content .= '</tr></table>';
    }
    
    // Affichage des lieux et gestion des lieux
   /* $stmt = $connexion->prepare("SELECT num_lieu, adresse FROM public.lieu WHERE num_struct=".$user->getStruct());
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
   
    $nfo_lieu = $stmt->fetchAll();
   */ 
//     $content .= '<form method="post" action="./index.php?page='.$_GET['page'].'">';
//     $content .= '<select name="lieu_pref" onchange="this.form.submit();">';
//       foreach($nfo_lieu as $lieu) {
// 	  if($lieu['num_lieu']==$user->getLieu()) {
// 	    $content .= '<option selected value="'.$lieu['num_lieu'].'">'.$lieu['adresse'].'</option>';
// 	  } else {
// 	    $content .= '<option value="'.$lieu['num_lieu'].'">'.$lieu['adresse'].'</option>';
// 	  }
//       }
//     $content .= '</select>';
//     $content .= '</form>';
//     $content .= '</br>';
//     
    $content .= mkListeDetail($nfo_Cde, $_GET['typeCmd']);
    
   
   

  } else {
    $content .= '<h4>Détails commande :</h4>';
    $content .= '<p>Sélectionner une commande</p>';
  }
 
 
 
} elseif ($user!=false && $user->getAdmin()) {
  
  if(isset($_GET['numCde'])) {
    $connexion = connexion();
 
    //Check si commande modififié
    if(isset($_POST['facturer'])) {
      $mt_facture = getMontantTotal($_GET['numCde']);
      $stmt = $connexion->prepare("UPDATE public.cde_fact SET date_fact=current_date, mt_fact=".$mt_facture. " WHERE num_cde=".$_GET['numCde']);
      var_dump($stmt);
      $stmt->execute();
      
      header('Location:index.php?page=commandes&typeCmd='.$_GET['typeCmd']);
    }
      
     
    
    
 
    $stmt = $connexion->prepare("SELECT * FROM detail WHERE num_cde=".$_GET['numCde']);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    
    $nfo_Cde = $stmt->fetchAll();
  
    $content .= '<h4>Détails commande N°'.$_GET['numCde'].' :</h4>';
    
    $content .= '<form method="post" action="index.php?page=commandes&typeCmd='.$_GET['typeCmd'].'&numCde='.$_GET['numCde'].'">';
    
    
    // On g\00re la disponibilité des boutons suivant les commandes
    if($_GET['typeCmd']==2) {
      $content .= '<table id="btnPanier"><tr>';
      $content .= '<td><input type="submit" name="facturer" value="Facturer"/></td>';
      $content .= '</tr></table>';
    }
    
    $content .= mkListeDetail($nfo_Cde, $_GET['typeCmd']);
    $content .= '</form>';
    
   
  } else {
    $content .= '<h4>Détails commande :</h4>';
    $content .= '<p>Sélectionner une commande</p>';
  }

} else {
   $content .= '<p>Vous n\'êtes pas authentifié.</p>';
}

echo $content;
?>
