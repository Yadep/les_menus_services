<?php
include_once('CLASS/autoload.php');
$title = 'Les Menus Services';
$site = new page_clients('Tous les Clients');
$site->corps = $site->Atouslesclients();
$site->affiche();


?>