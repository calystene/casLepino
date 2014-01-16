   <div id="outer">
	<div id="main">
	  <!-- Corps de la page --> 
	  
	  <h1>Commandes</h1>
	  <div class="sidebar2">
	      <form method="get" action="./index.php">
		<input type="hidden" name="page" value="commandes"/>
		
		<select name="typeCmd" onchange="this.form.submit();">
		<?php
		if(($user=auth())!=false && !$user->getAdmin()) {
		  //Liste déroulante gérant les différents types de commandes 
		  if(isset($_GET['typeCmd']) && $_GET['typeCmd']==2){
		    echo '<option value=1>Commande facturées non réglées</option>';
		    echo '<option selected value=2>Commande validées non facturées</option>';
		    echo '<option value=3>Commande non terminées</option>';
		    }
		  elseif(isset($_GET['typeCmd']) && $_GET['typeCmd']==1)  {
		    echo '<option selected value=1>Commande facturées non réglées</option>';
		    echo '<option value=2>Commande validées non facturées</option>';
		    echo '<option value=3>Commande non terminées</option>';
		  } else {
		    echo '<option value=1>Commande facturées non réglées</option>';
		    echo '<option value=2>Commande validées non facturées</option>';
		    echo '<option value=3 selected>Commandes non terminées</option>';
		  }		  
		} else {
		    
		  if(isset($_GET['typeCmd']) && $_GET['typeCmd']==1)  {
		    echo '<option selected value=1>Commande facturées non réglées</option>';
		    echo '<option value=2>Commande validées non facturées</option>';
		    }else{
		    echo '<option value=1>Commande facturées non réglées</option>';
		    echo '<option selected value=2>Commande validées non facturées</option>';
		    }
		}
		  ?>
		</select>	      
	      </form>
	      </br>
	  </div>
	  <div class="content">
		 
	    <div class="box2">
	      <div class="corps">
		<?php include('./include/syntheseCmd.php'); ?>
	      </div>
	    </div>
	      
	    <div class="box3">
	      <div class="corps">
		<?php include('./include/panier.php'); ?>
	      </div>
	    </div>
	   
	    
	    
	  </div>
	  <br id="clear" />
	</div> 
	<br id="clear" />
      </div>
      <div id="copyright">
	<!-- Bas de page -->
	&copy; CasLepino | Made by Thomas Pierard and Pierre-Louis Hequet.
      </div>
    </div>
