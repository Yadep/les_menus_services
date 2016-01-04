<?php
include_once('CLASS/autoload.php');
$title = 'Les Menus Services';
$site = new page_employes('HeuresEmployes');
$site->corps= $site->EmployesHeures();
$site->affiche();
?>