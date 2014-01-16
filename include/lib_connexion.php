<?php
require_once('./include/class/User.class.php');


function connexion() {
  try
  {
      $connexion = new PDO("pgsql:host=localhost; dbname=pierard","postgres","");
      $connexion ->query("SET NAMES UTF8");
      
      return $connexion;
  }
  catch (Exception $e) {
	  die('Erreur : ' . $e->getMessage());
	  exit();
  }
}
  
  
function auth() {
  if(!isset($_SESSION['user'])){
    session_start();
  }
  
  if(isset($_SESSION['user'])) {
    return $_SESSION['user'];
  } else {
    try {
      authentification();
      return $_SESSION['user'];
    } catch (Exception $d) {
      return false;
    }
  }
}

  
function authentification() {

  $connexion = connexion();

      if($connexion!=null && isset($_POST['login']) && isset($_POST['pswd'])) {

	$log = $_POST['login'];
	$mdp = $_POST['pswd'];
	
	// EN premier on regarde si la personne est un gestionnaire
	$stmt = $connexion->prepare("SELECT nom, prenom, login FROM public.gestionnaire WHERE login='".$log."' AND password='".$mdp."';");
	$stmt->execute();	
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$nfo = $stmt->fetch();
	
	if ($nfo!=false) {
	  // Ici on crée un User admin, avec 0 comme num vu que dans la bdd le gestionnaire n'a pas de numéro.
	  $_SESSION['user'] = new User(0, $nfo['nom'], $nfo['prenom'], $nfo['login'], true, null, null);
	} else {
	  $stmt = $connexion->prepare("SELECT num_resp, nom, prenom, login, num_lieu, num_struct FROM public.responsable WHERE login='".$log."' AND password='".$mdp."';");
	  $stmt->execute();
	  
	  $stmt->setFetchMode(PDO::FETCH_ASSOC);
	
	  //var_dump($stmt->fetch());
	  $nfo = $stmt->fetch();

	  // Ici on crée un User normal.
	  if($nfo!=false) {
	    $_SESSION['user'] = new User($nfo['num_resp'], $nfo['nom'], $nfo['prenom'], $nfo['login'], false, $nfo['num_lieu'], $nfo['num_struct']);
	  }
	}
	return;
      } else {
	throw new Exception("AuthentificationKO");
      }
}
  
  
function deconnexion() {
    session_destroy();
}
  
  
function getUser() {
  if(isset($_SESSION['user'])) {
    return $_SESSION['user'];
  } else {
    return false;
  }
}
?>
