<?php

function getMontantTotal($numCde) {
  $result = 0;
  
  $connexion = connexion();
  
  $stmt = $connexion->prepare("SELECT * FROM detail WHERE num_cde=".$numCde);
  $stmt->execute();
    
  $detail_cmd = $stmt->fetchAll();
  
  foreach($detail_cmd as $article) {
    $stmt = $connexion->prepare("SELECT pu FROM article WHERE num_art=".$article['num_art']);
    $stmt->execute();
    
    $pu = $stmt->fetch();
  
    $result +=  $pu['pu'] * $article['qte_commandee'];
  } 
  
  return $result;
}



function mkTableCmd($resultFetchAll, $typeCmd) {
  $content = '';
  
  $content .= '<table id="syntheseCmd">';
  $content .= '<tr>';
  $content .= '<th>N° Commande</th>';
  $content .= '<th>Date commande</th>';
  $content .= '<th>Montant total</th>';
  $content .= '<th>Date facture</th>';
  $content .= '<th>Montant facture</th>';
  $content .= '</tr>';

  foreach($resultFetchAll as $cmd) {
    
    $content .= '<tr class="synthCmdTR" onclick="document.location.href=\'index.php?page=commandes&typeCmd='.$typeCmd.'&numCde='.$cmd['num_cde'].'\'">';
    
    $content .= '<td>'.$cmd['num_cde'].'</td>';
    $content .= '<td>'.$cmd['date_cde'].'</td>';
    $content .= '<td>'.getMontantTotal($cmd['num_cde']).' €</td>';
    
    
    $date_fact = $cmd['date_fact'];
    
    if($date_fact==NULL) {
      $content .= '<td>Non facturée</td>';
    } else {
      $content .= '<td>'.$date_fact.'</td>';
    }
    
    
    $mt_fact=$cmd['mt_fact'];
    if($mt_fact==NULL) {
      $content .= '<td>Non facturée</td>';
    } else {
      $content .= '<td>'.$mt_fact.'</td>';
    }
    
    $content .= '</tr>';
   
  }
  $content .= '</table>';
  
  return $content;
}


    // libell\00 article, PU, quantit\00 command\00e, montant de la ligne 
function mkListeDetail($resultFetchAll, $typeCmd) {
  $content = '';
  
  $connexion = connexion();
  
  
  $content .= '<table id="detailCmd">';
  $content .= '<tr>';
  $content .= '<th>Libellé article</th>';
  $content .= '<th>P.U</th>';
  $content .= '<th>Quantité</th>';
  $content .= '<th>Total</th>';
  $content .= '</tr>';
  foreach($resultFetchAll as $article) {
    $stmt = $connexion->prepare("SELECT libelle, pu FROM article WHERE num_art=".$article['num_art']);
    $stmt->execute();
    
    $nfo_article = $stmt->fetch();
    
    $libelle = $nfo_article['libelle'];
    $qte = $article['qte_commandee'];
    $pu = $nfo_article['pu'];
    $montant_ligne = $pu * $qte;
    
    $typeCmd<>3 ? $canModif='disabled="disabled"' : $canModif='';
    
    $content .= '<tr><td>'.$libelle.'</td><td>'.$pu.'€</td><td><input type="text" '.$canModif.' name="qteProd'.$article['num_art'].'" value="'.$qte.'"/"></td><td>'.$montant_ligne.'€</td></tr>';
  
     
  }
  $content .= '</table>';
  
  return $content;
}



function getClient($numClient) {
  $connexion = connexion();
  
  $stmt = $connexion->prepare("SELECT prenom, nom, num_struct FROM responsable WHERE num_resp=".$numClient);
  $stmt->execute();
  $nfo_resp = $stmt->fetch();
  
  $stmt = $connexion->prepare("SELECT rs FROM structure WHERE num_struct=".$nfo_resp['num_struct']);
  $stmt->execute();
  $nfo_struct = $stmt->fetch();
  
  return $nfo_resp['prenom'].' '.$nfo_resp['nom'].', '.$nfo_struct['rs'];
}


function mkTableCmdAdmin($resultFetchAll, $typeCmd) {
  $content = '';
  
  $content .= '<table id="syntheseCmd">';
  $content .= '<tr>';
  $content .= '<th>Date commande</th>';
  $content .= '<th>N° commande</th>';
  $content .= '<th>Client</th>';
  $content .= '<th>Date facture</th>';
  $content .= '<th>Montant facture</th>';
  $content .= '<th>Montant total</th>';
  $content .= '</tr>';

  foreach($resultFetchAll as $cmd) {
    
    $content .= '<tr class="synthCmdTR" onclick="document.location.href=\'index.php?page=commandes&typeCmd='.$typeCmd.'&numCde='.$cmd['num_cde'].'\'">';
    
    $content .= '<td>'.$cmd['date_cde'].'</td>';
    $content .= '<td>'.$cmd['num_cde'].'</td>';
    
    $nfo_client = getClient($cmd['num_resp']);
    $content .= '<td>'.$nfo_client.'</td>';
    
    
    $date_fact = $cmd['date_fact'];
    
    if($date_fact==NULL) {
      $content .= '<td>Non facturée</td>';
    } else {
      $content .= '<td>'.$date_fact.'</td>';
    }
    
    $mt_fact=$cmd['mt_fact'];
    if($mt_fact==NULL) {
      $content .= '<td>Non facturée</td>';
    } else {
      $content .= '<td>'.$mt_fact.'</td>';
    }
    
    $content .= '<td>'.getMontantTotal($cmd['num_cde']).' €</td>';    
    
    $content .= '</tr>';
   
  }
  $content .= '</table>';
  
  return $content;
}


function maj_stock($diff_qte, $num_art) {
$connexion = connexion();

$stmt = $connexion->prepare("UPDATE public.article SET qte_dispo=(qte_dispo + ".$diff_qte.") WHERE num_art=".$num_art);
$stmt->execute();
}
?>
