<?php
include_once('CLASS/autoload.php');

$title = 'Les Menus Services';
$site = new page_clients('Rappel clients');
$site->corps = $site->Rappelclients();
$site->affiche();

?>