<?php
include_once('CLASS/autoload.php');   // pour inclure nos classes

$site = new page_interventions('Listeinterventions');

$site->corps = $site->affiche_interventions2();	
$site->affiche();

//
?>