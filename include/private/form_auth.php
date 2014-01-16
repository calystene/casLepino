<?php 
 
$content = '';

if(!isset($_POST['login']) && !isset($_POST['pswd']) && auth()==false) { 
  $content .= '<form name="input" action="./index.php" method="post">';
  $content .= '<table cellspacing=0><tr>';
  $content .= '<td>Login :</td><td> <input type="text" name="login" value="" /></td>';
  $content .= '<td rowspan=2><input type="submit" value="Valider" /></td></tr>';
  $content .= '<tr><td>Password :</td><td> <input type="password" name="pswd" value="" /></td></tr>';
  $content .= '</table>';
  $content .= '</form>';
} else {
  $user = auth();
  // && !isset($user)
  if(auth()!=false) {
    
    $content .= '<article>';
    $content .= '<h3>Bienvenue ' .$user->getPrenom().' '.$user->getNom().'</h3><br>';
    $content .= '<h3><a class="lien_no_deco" href="./deconnexion.php">Se déconnecter</a></h3>';
    $content .= '</article>';
  } else {
    $content .= '<article>';
    $content .= '<h3>Login ou mot de passe incorrects</h3><br>';
    $content .= '<h3><a class="lien_no_deco" href="./deconnexion.php">Retour</a></h3>';
    $content .= '</article>';
  }
}

echo $content;
?>
