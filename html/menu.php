<!-- CHANGER LES ID DES DIVS. CREER UN STYLE UNIQUEMENT POUR LE MENU -->

<?php 

$content = "";

$content .= '<div id="upper">';

$content .=  '<div id="menu">';

$content .= '    <nav>  ';
$content .= '	  <table>';
$content .= '	      <tr>';
	      
$user = auth();

if($user!=false && $user->getAdmin()) {
  $content .= '		<td onclick="document.location.href=\'index.php\'">Accueil</td>';
  $content .= '		<td onclick="document.location.href=\'index.php?page=produit\'">Produits</td>';
  //$content .= '		<td><a href="index.php?page=compte">Compte</a></td>';
  $content .= '		<td onclick="document.location.href=\'index.php?page=commandes\'">Commandes</a></td>';
} else {
  $content .= '		<td onclick="document.location.href=\'index.php\'">Accueil</td>';
  $content .= '		<td onclick="document.location.href=\'index.php?page=produit\'">Produits</td>';
  $content .= '		<td onclick="document.location.href=\'index.php?page=compte\'">Compte</td>';
  $content .= '		<td onclick="document.location.href=\'index.php?page=commandes\'">Commandes</td>';
}		
		
$content .= '	      </tr>';  
$content .= '	  </table>';
$content .= '    </nav>';
  
$content .= '  </div>';
$content .= ' </div>';
 
 
echo $content;
?>