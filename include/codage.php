<?php

/* Conversion d'une cha�ne UTF-8 en ASCII 7bits
  - remplace un caract�re avec diacritique par le caract�re de base (ex : � -> a, � -> c, � ->U ...)
  - remplace un caract�re ligatur� par les 2 caract�res ASCII (ex : � -> oe, � -> OE)
  - les �ventuels autres caract�res UTF-8 sont remplac�s par  leur entit� XML/HTML
*/
define('REG_CONV','/&([A-za-z]{1,2})'.
                  '(?:acute|breve|caron|cedil|circ|dblac|die|dot|grave|macr|ogon|ring|tilde|uml|lig);'.
                  '|(&)amp;/'
       );
function codage($s){
 $s1=str_replace("&","&amp;",$s);
 $entities=mb_convert_encoding($s1,"HTML-ENTITIES","UTF-8");
 $res = preg_replace(REG_CONV,'\1\2', $entities);
 return $res;
}

$tncc_article = array('','','Le ','La ','Les ','L\'','Aux ','Las ','Los ');
?>