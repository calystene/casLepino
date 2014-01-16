<?php


$content = '</br>';

$user = auth();


// SynthËse des commandes partie responsable
if($user!=false  && !$user->getAdmin()) {
  $connexion = connexion();
  
  // Commande ValidÈes non facturÈes
  if(isset($_GET['typeCmd']) && $_GET['typeCmd']==2) {
    $stmt = $connexion->prepare("SELECT * FROM cde_fact WHERE date_fact IS NULL AND terminee=TRUE AND num_resp=".$user->getNum()." ORDER BY num_cde");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $nfo_cmd = $stmt->fetchAll();
    
    
    if($nfo_cmd!=false) {
      isset($_GET['typeCmd']) ? $content .= mkTableCmd($nfo_cmd, $_GET['typeCmd']) : $content .= mkTableCmd($nfo_cmd, 2);
    } else {
      $content .= '<p>Aucune commande enregistr√©e</p>';
    }
    
  //Commande facturÈes non payÈes
  } elseif (isset($_GET['typeCmd']) && $_GET['typeCmd']==1)  {
    $stmt = $connexion->prepare("SELECT * FROM cde_fact WHERE date_fact IS NOT NULL AND payee=FALSE AND num_resp=".$user->getNum()." ORDER BY num_cde");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $nfo_cmd = $stmt->fetchAll();
    
    if($nfo_cmd!=false) {
      isset($_GET['typeCmd']) ? $content .= mkTableCmd($nfo_cmd, $_GET['typeCmd']) : $content .= mkTableCmd($nfo_cmd, 1);     
    } else {
      $content .= '<p>Aucune commande enregistr√©e</p>';
    }
    
  // Commande non terminÈes
  } else {
    $stmt = $connexion->prepare("SELECT * FROM cde_fact WHERE date_fact IS NULL AND terminee=FALSE AND num_resp=".$user->getNum()." ORDER BY num_cde");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $nfo_cmd = $stmt->fetchAll();
    
    if($nfo_cmd!=false) {
      isset($_GET['typeCmd']) ? $content .= mkTableCmd($nfo_cmd, $_GET['typeCmd']) : $content .= mkTableCmd($nfo_cmd, 3);     
    } else {
      $content .= '<p>Aucune commande enregistr√©e</p>';
    }
  }
  

// partie Gestionnaire
} elseif($user!=false && $user->getAdmin()) {
  $connexion = connexion();
  
  // Commandes facturÈes mais pas encore payÈes
  if (isset($_GET['typeCmd']) && $_GET['typeCmd']==1)  {
    $stmt = $connexion->prepare("SELECT * FROM cde_fact WHERE date_fact IS NOT NULL AND payee=FALSE AND terminee=TRUE ORDER BY num_cde");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $nfo_cmd = $stmt->fetchAll();
    
    if($nfo_cmd!=false) {
      $content .= mkTableCmdAdmin($nfo_cmd, $_GET['typeCmd']);
    } else {
      $content .= '<p>Aucune commande enregistr√©e</p>';
    }
    
  
  
  // Commandes terminÈes non facturÈes
  } else {
    $stmt = $connexion->prepare("SELECT * FROM cde_fact WHERE date_fact IS NULL AND terminee=TRUE AND terminee=TRUE ORDER BY num_cde");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $nfo_cmd = $stmt->fetchAll();
    
    
    if($nfo_cmd!=false) {
      isset($_GET['typeCmd']) ? $content .= mkTableCmdAdmin($nfo_cmd, $_GET['typeCmd']) : $content .= mkTableCmdAdmin($nfo_cmd, 2);  
      
    } else {
      $content .= '<p>Aucune commande enregistr√©e</p>';
    }
  }
 

} else {
   $content .= '<p>Vous n\'√™tes pas authentifi√©.</p>';
}
  
  
  echo $content;
?>