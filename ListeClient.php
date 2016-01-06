<?php

include_once('CLASS/autoload.php');

$site = new page_clients('Affiche client');
if( isset($_POST['modifclient']))
{
	$site->corps = $site->modifier_client().$site->afficheModifClient();
}
else
{
	$site->corps = $site->afficheModifClient();
}
$site->affiche();


?>