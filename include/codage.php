<?php

/* Conversion d'une chaîne UTF-8 en ASCII 7bits
  - remplace un caractère avec diacritique par le caractère de base (ex : à -> a, ç -> c, Ü ->U ...)
  - remplace un caractère ligaturé par les 2 caractères ASCII (ex : œ -> oe, Œ -> OE)
  - les éventuels autres caractères UTF-8 sont remplacés par  leur entité XML/HTML
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