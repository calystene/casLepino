<?php
$content = '';


if (($user=auth())!=false && isset($_POST['produit'])) {
  $connexion = connexion();
  $arrayProd = $_POST['produit'];
  $arrayLenght = sizeof($arrayProd);
  
  for($i=0;$i<=$arrayLenght;$i++) {
    if($arrayProd[$i]!=null) {
      $qte = $arrayProd[$i];
      $stmt = $connexion->prepare("INSERT INTO public.detail(num_cde,num_art,qte_commandee) VALUES (".$_GET['numCde'].",".$i.",".$qte.");");
      $stmt->execute();
	
      maj_stock($qte-(2*$qte),$i);
    }
  }
  
}






$content .= '		<form action="index.php?page=produit&numCde='.$_GET['numCde'].'" method="post">';

$content .= '		  <div class="b1">';
$content .= '			  <img class="img-produit" src="./images/gomme.jpg" />';
$content .= '			  <p>Gomme rose</p>';
$content .= '			  <input type="text" name="produit[1]" value="" /> ';
$content .= '		  </div>';
		  
$content .= '		  <div class="b1">';
$content .= '			  <img class="img-produit" src="./images/crayon-a-papier.jpg" />';
$content .= '			  <p>Crayon HB</p>';
$content .= '			  <input type="text" name="produit[2]" value=""/>';
$content .= '		  </div>';
		  
$content .= '		  <div class="b1">';
$content .= '			  <img  class="img-produit" src="./images/bloc-note.jpg" />';
$content .= '			  <p>Calepin 50 p. grand format</p>';
$content .= '			  <input type="text" name="produit[3]" value="" />';
$content .= '		  </div>';
		  
$content .= '		  <br class="clear" />';
		  
$content .= '		  <div class="b1">';
$content .= '			  <img class="img-produit" src="./images/calculatrice-publicitaire.jpg" />';
$content .= '			  <p>Calculette poche</p>';
$content .= '			  <input type="text" name="produit[4]" value="" />';
$content .= '		  </div>';
		  
$content .= '		  <div class="b1">';
$content .= '			  <img class="img-produit" src="./images/bloc-note.jpg" />';
$content .= '			  <p>Bloc notes 100 p</p>';
$content .= '			  <input type="text" name="produit[5]" value="" />';
$content .= '		  </div>';
		  
$content .= '		  <div class="b1">';
$content .= '			  <img class="img-produit" src="./images/bloc-note.jpg" />';
$content .= '			  <p>Bloc notes 200 p</p>';
$content .= '			  <input type="text" name="produit[6]" value="" />';
$content .= '		  </div>';
		  
$content .= '		  <br class="clear" />';
		  
$content .= '		  <div class="b1">';
$content .= '			  <img class="img-produit" src="./images/calculatrice-de-bureau.jpg" />';
$content .= '			  <p>Calcul. Financiere</p>';
$content .= '			  <input type="text" name="produit[7]" value="" />';
$content .= '		  </div>';
		  
$content .= '		  <div class="b1">';
$content .= '			  <img  class="img-produit" src="./images/gomme.jpg" />';
$content .= '			  <p>Gomme bleue dure</p>';
$content .= '			  <input type="text" name="produit[8]" value="" />';
$content .= '		  </div>';
		  
$content .= '		  <div class="b1">';
$content .= '			  <img class="img-produit" src="./images/stylo-bille.jpg" />';
$content .= '			  <p>Stylo bille bleu</p>';
$content .= '			  <input type="text" name="produit[9]" value="" />';
$content .= '		  </div>';
		  
$content .= '		  <input type="submit" name="envoyer" value="Ajouter à la commande" />';
		  
$content .= '		  </form>';


echo $content;

?>