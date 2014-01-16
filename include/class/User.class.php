<?php 


/* La classe User sert à stocker les informations de l'utilisateur suite à son authentification */
class User {

//attributs
private $num_resp;
private $nom;
private $prenom;
private $login;
private $admin;
private $lieuFav;
private $numStruct;


//méthodes
public function __construct($num, $nom, $prenom, $login, $admin, $lieu, $struct) {
  $this->num_resp = $num;
  $this->nom = $nom;
  $this->prenom = $prenom;
  $this->login = $login;
  $this->admin= $admin;
  $this->lieuFav=$lieu;
  $this->numStruct=$struct;
}

public function getNum() {
  return $this->num_resp;
}

public function getNom() {
  return $this->nom;
}

public function getNomEcho() {
  echo $this->nom;
}

public function setNom($nom) {
  $this->nom = $nom;
}

public function getPrenom() {
  return $this->prenom;
}

public function getPrenomEcho() {
  echo $this->prenom;
}

public function setPrenom($prenom) {
  $this->prenom = $prenom;
}

public function getLogin() {
  return $this->login;
}
  
public function getLoginEcho() {
  echo $this->login;
}

public function getAdmin() {
  return $this->admin;
}

public function getLieu() {
  return $this->lieuFav;
}

public function setLieu($num_lieu) {
  return $this->$num_lieu;
}

public function getStruct() {
  return $this->numStruct;
}
}





?>
