   <div id="outer">
	<div id="main">
	  <!-- Corps de la page --> 
	  
	  <h1>Produits</h1>
	  <div class="sidebar2">
	    <form method="get" action="./index.php">
		<input type="hidden" name="page" value="produit"/>
		
		<?php
		echo '<select name="numCde" onchange="this.form.submit();">';
		echo '<option value="">Sélectionner une commande</option>';
		
		if(($user=auth())!=false && !$user->getAdmin()) {
		  $connexion = connexion();
		  
		  if(isset($_POST['newCde'])) {
		    
		    $insert = '(SELECT MAX(num_cde) FROM cde_fact)+1,(SELECT current_date),FALSE,FALSE,FALSE,'.$user->getNum().','.$user->getLieu();
		    $stmt = $connexion->prepare("INSERT INTO public.cde_fact(num_cde,date_cde,payee,terminee,colis_fait,num_resp,num_lieu) VALUES(".$insert.")");
		    var_dump($stmt);
		    $stmt->execute();
		    
		    
		  }
		  
		  
 		  $stmt = $connexion->prepare("SELECT num_cde FROM cde_fact WHERE terminee=FALSE AND num_resp=".$user->getNum().' ORDER BY num_cde');
 		  $stmt->execute();
 		  $liste_cmd = $stmt->fetchAll();
 		  
		    //Liste déroulante gérant les numéro de commande
		    foreach ($liste_cmd as$cmd) {
		      (isset($_GET['numCde']) && $_GET['numCde']==$cmd['num_cde']) ? $select='selected' : $select='';
		      echo '<option '.$select.' value='.$cmd['num_cde'].'>Commande non terminée n° '.$cmd['num_cde'].'</option>';
		    }
		}
		
		  
		echo '</select>';
		
	      echo '</form>';
	      echo '<form method="post" action="./index.php?page=produit"><input type="submit" name="newCde" value="Nouvelle commande"/></form>';
	      ?>
	     </div>
	  
	  <div clas="content">
		 
	    <div class="box2">
		<div id="corps">
		  <?php include('./include/gest_produits.php'); ?>
		</div>
	    </div>
	
	  <div class="box3">
	    <div class="corp">
	      <?php include('./include/panier.php'); ?>
	     </div>
	  </div>
	  
	  </div>
	  <br class="clear" />
	</div> 
	<br class="clear" />
      <div id="copyright">
	<!-- Bas de page -->
	&copy; CasLepino | Made by Thomas Pierard and Pierre-Louis Hequet.
      </div>
    </div>
