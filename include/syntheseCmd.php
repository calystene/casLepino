<?php


$content = '</br>';

$user = auth();


// Synth�se des commandes partie responsable
if($user!=false  && !$user->getAdmin()) {
  $connexion = connexion();
  
  // Commande Valid�es non factur�es
  if(isset($_GET['typeCmd']) && $_GET['typeCmd']==2) {
    $stmt = $connexion->prepare("SELECT * FROM cde_fact WHERE date_fact IS NULL AND terminee=TRUE AND num_resp=".$user->getNum()." ORDER BY num_cde");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $nfo_cmd = $stmt->fetchAll();
    
    
    if($nfo_cmd!=false) {
      isset($_GET['typeCmd']) ? $content .= mkTableCmd($nfo_cmd, $_GET['typeCmd']) : $content .= mkTableCmd($nfo_cmd, 2);
    } else {
      $content .= '<p>Aucune commande enregistrée</p>';
    }
    
  //Commande factur�es non pay�es
  } elseif (isset($_GET['typeCmd']) && $_GET['typeCmd']==1)  {
    $stmt = $connexion->prepare("SELECT * FROM cde_fact WHERE date_fact IS NOT NULL AND payee=FALSE AND num_resp=".$user->getNum()." ORDER BY num_cde");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $nfo_cmd = $stmt->fetchAll();
    
    if($nfo_cmd!=false) {
      isset($_GET['typeCmd']) ? $content .= mkTableCmd($nfo_cmd, $_GET['typeCmd']) : $content .= mkTableCmd($nfo_cmd, 1);     
    } else {
      $content .= '<p>Aucune commande enregistrée</p>';
    }
    
  // Commande non termin�es
  } else {
    $stmt = $connexion->prepare("SELECT * FROM cde_fact WHERE date_fact IS NULL AND terminee=FALSE AND num_resp=".$user->getNum()." ORDER BY num_cde");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $nfo_cmd = $stmt->fetchAll();
    
    if($nfo_cmd!=false) {
      isset($_GET['typeCmd']) ? $content .= mkTableCmd($nfo_cmd, $_GET['typeCmd']) : $content .= mkTableCmd($nfo_cmd, 3);     
    } else {
      $content .= '<p>Aucune commande enregistrée</p>';
    }
  }
  

// partie Gestionnaire
} elseif($user!=false && $user->getAdmin()) {
  $connexion = connexion();
  
  // Commandes factur�es mais pas encore pay�es
  if (isset($_GET['typeCmd']) && $_GET['typeCmd']==1)  {
    $stmt = $connexion->prepare("SELECT * FROM cde_fact WHERE date_fact IS NOT NULL AND payee=FALSE AND terminee=TRUE ORDER BY num_cde");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $nfo_cmd = $stmt->fetchAll();
    
    if($nfo_cmd!=false) {
      $content .= mkTableCmdAdmin($nfo_cmd, $_GET['typeCmd']);
    } else {
      $content .= '<p>Aucune commande enregistrée</p>';
    }
    
  
  
  // Commandes termin�es non factur�es
  } else {
    $stmt = $connexion->prepare("SELECT * FROM cde_fact WHERE date_fact IS NULL AND terminee=TRUE AND terminee=TRUE ORDER BY num_cde");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $nfo_cmd = $stmt->fetchAll();
    
    
    if($nfo_cmd!=false) {
      isset($_GET['typeCmd']) ? $content .= mkTableCmdAdmin($nfo_cmd, $_GET['typeCmd']) : $content .= mkTableCmdAdmin($nfo_cmd, 2);  
      
    } else {
      $content .= '<p>Aucune commande enregistrée</p>';
    }
  }
 

} else {
   $content .= '<p>Vous n\'êtes pas authentifié.</p>';
}
  
  
  echo $content;
?>