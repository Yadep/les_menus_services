<?php
include_once('CLASS/autoload.php');
$title = 'Les Menus Services';
$site = new page_employes('Excel');
$site->corps = $site->AfficheExcelEmploye();
$site->excel();

?>