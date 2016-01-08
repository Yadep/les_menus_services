<?php
include_once('CLASS/autoload.php');   // pour inclure nos classes

$site = new page_interventions('SListeinterventions');
$site->corps = $site->Afficher_supprimer_Interventions().$site->choisir_date();

$site->affiche();
//
?>