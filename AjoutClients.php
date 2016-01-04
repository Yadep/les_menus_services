<?php
include_once('CLASS/autoload.php');   // pour inclure nos classes
$title = 'Les Menus Services';
$site = new page_clients('ajoutclients');
$site->corps = $site->afficheajoutclient();
$site->affiche();

?>