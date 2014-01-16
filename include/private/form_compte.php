<?php

$content = '</br>';

$user = auth();




if($user!=false) {
  $connexion = connexion();

  
try {

  /* Insertion des Data en cas de mofification */
  if(isset($_POST['pswd_new1']) && isset($_POST['pswd_new2']) && isset($_POST['pswd_old']) && $_POST['pswd_old']!="") {
      $stmt = $connexion->prepare("SELECT num_resp FROM public.responsable WHERE num_resp=".$user->getNum()." AND password='".$_POST['pswd_old']."';");
      $stmt->execute();

      if($stmt->fetch()!=false) {
	if($_POST['pswd_new1']==$_POST['pswd_new2']) {
	  $stmt = $connexion->prepare("UPDATE public.responsable SET password='".$_POST['pswd_new1']."' WHERE num_resp=".$user->getNum());
	  $stmt->execute();
	}
	else {
	  throw new Exception("Erreur changement mdp : nouveau mdp différent");
	}
      } 
      else {
	throw new Exception("Erreur changement mdp : ancien mdp incorrect");
      }
  
  $content .= '<p>Modification effectuée mot de passe avec succès</p>';
  }

    
  } catch (Exception $e) {
    $content .= '<p>'.$e->getMessage().'</p>';
  }

  /* Insertion des données du formulaire (nom, prénom, lieu) */
  if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['lieu_pref'])) {
    $stmt = $connexion->prepare("UPDATE public.responsable SET nom='".$_POST['nom']."', prenom='".$_POST['prenom']."', num_lieu=".$_POST['lieu_pref']." WHERE num_resp=".$user->getNum());
    $stmt->execute();
    
    $user->setNom($_POST['nom']);
    $user->setPrenom($_POST['prenom']);
    $user->setLieu($_POST['lieu_pref']);
    
    $content .= '<p>Modification infos personnelles effectuées avec succès</p>';
  }
  
  /* Récupération des Data  */
  
   $stmt = $connexion->prepare("SELECT num_resp, nom, prenom, login, num_struct, num_lieu FROM public.responsable WHERE num_resp=".$user->getNum());
   $stmt->execute();
   $stmt->setFetchMode(PDO::FETCH_ASSOC);
   
   $nfo_resp = $stmt->fetch();
   
   $stmt = $connexion->prepare("SELECT rs, adresse FROM public.structure WHERE num_struct=".$nfo_resp['num_struct']);
   $stmt->execute();
   $stmt->setFetchMode(PDO::FETCH_ASSOC);
   
   $nfo_struct = $stmt->fetch();
   
   $stmt = $connexion->prepare("SELECT num_lieu, adresse FROM public.lieu WHERE num_struct=".$nfo_resp['num_struct']);
   $stmt->execute();
   $stmt->setFetchMode(PDO::FETCH_ASSOC);
   
   $nfo_lieu = $stmt->fetchAll();
   
   
   // Formulaire
   $content .= '<form name="input" action="./index.php?page=compte" method="post">';
   $content .= '<table cellspacing=0><tr>';
   $content .= '<td>Login :</td><td> <input type="text" name="login" disabled="disabled" value="'.$nfo_resp['login'].'" /></td>';
   $content .= '<tr><td></br></td></tr>';
   $content .= '<tr><td colspan=2>Changer mot de passe : </td></tr>';
   $content .= '<tr><td>Ancien password :</td><td> <input type="password" name="pswd_old" value="" /></td></tr>';
   $content .= '<tr><td>Nouveau password :</td><td> <input type="password" name="pswd_new1" value="" /></td></tr>';
   $content .= '<tr><td>Confirmation nouveau password :</td><td> <input type="password" name="pswd_new2" value="" /></td></tr>';
   $content .= '<tr><td></br></td></tr>';
   $content .= '<tr><td colspan=2>Informations personnelles : </td></tr>';
   $content .= '<tr><td>Nom : </td><td><input type="text" name="nom" value="'.$user->getNom().'" /></td></tr>';
   $content .= '<tr><td>Prenom : </td> <td><input type="text" name="prenom" value="'.$user->getPrenom().'" /></td></tr>';
   //partie liste déroulante
   $content .= '<tr><td>Lieu préféré : </td><td>';
   $content .= '<select name="lieu_pref">';
   foreach($nfo_lieu as $lieu) {
      if($lieu['num_lieu']==$nfo_resp['num_lieu']) {
	$content .= '<option selected value="'.$lieu['num_lieu'].'">'.$lieu['adresse'].'</option>';
      } else {
	$content .= '<option value="'.$lieu['num_lieu'].'">'.$lieu['adresse'].'</option>';
      }
   }
   $content .= '</select>';
   $content .= '</td></tr>'; //fin partie liste déroulante
   $content .= '<tr><td></br></td></tr>';
   $content .= '<tr><td colspan=2><input type="submit" value="Valider" /></td></tr>';
   $content .= '</table>';
   $content .= '</form>';
    
   
     
} else {
  $content .= '<p>Vous n\'êtes pas authentifié.</p>';
  //$content .= include('form_auth.php');
}


echo $content;




?>