<?php
include_once('CLASS/autoload.php');   // pour inclure nos classes

$site = new page_employes('Listeemployes');
$site->corps = $site->affiche_employes().$site->choisir_employe().$site->Interventions_Employés().$site->enregistrer_employes();	
$site->affiche();

?>