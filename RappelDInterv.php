<?php
include_once('CLASS/autoload.php');   // pour inclure nos classes

$site = new page_interventions('Interventions');
$site->corps = $site->Afficher_derniere_intervention().$site->choisir_date();;	
$site->affiche();

?>