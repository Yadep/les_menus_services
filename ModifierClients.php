<?php

include_once('CLASS/autoload.php');

$site = new page_clients('Liste de clients');
if( isset($_POST['modifclient']))
{	
	$site->corps = $site->modifier_client().$site->affichelisteclient();
}
else 
{
	$site->corps = $site->affichelisteclient();
}
$site->affiche();


?>