<?php
include_once('CLASS/autoload.php');

$title = 'Les Menus Services';
$site = new page_interventions('Intervention prévu');
$site->corps = $site->InterventionPrevu();
$site->affiche();

?>