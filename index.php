
<?php
	
   	include_once('CLASS/autoload.php');   // pour inclure nos classes
	$title = 'Les Menus Services';
	$site = new connexion('Connexion');
	$site->corps=$site->formulaire_connexion().$site->connection();
	if (isset($erreur))
	{
		echo '<br /><br />',$erreur;
	}
	
	if (isset($_SESSION['login']))
	{	
		$site->corps=$site->affiche_connecter();
	}			
    $site->affiche();
    
    
?>