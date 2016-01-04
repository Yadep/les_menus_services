<?php
include_once('CLASS/autoload.php');   // pour inclure nos classes

$site = new page_interventions('MListeinterventions');
$site->corps = $site->Afficher_modifier_Interventions().$site->choisir_date();

$site->affiche();
//
?>