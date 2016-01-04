<?php
include_once('CLASS/autoload.php');
$title = 'Les Menus Services';
$site = new page_clients('Excel');
$site->corps = $site->AfficheExcelClients();
$site->excel();

?>