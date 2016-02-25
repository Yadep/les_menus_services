
<?php
    include_once('CLASS/autoload.php');
    $title = 'Les Menus Services';
    $site = new page_interventions('Excel');
    $site->corps = $site->affiche_Excel2();
	$site->excel();
  
?>