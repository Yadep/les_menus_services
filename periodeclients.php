<?php
include_once('CLASS/autoload.php');

$title = 'Les Menus Services';
$site = new page_clients('Période Clients');
$site->corps = $site->PeriodeClients();
$site->affiche();

?>