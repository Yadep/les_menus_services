<?php
include_once('CLASS/autoload.php');
$title = 'Les Menus Services';
$site = new page_clients('Excel');
$site->corps = $site->Rechercher();
$site->excel();

?>