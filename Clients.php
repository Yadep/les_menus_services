<?php
	include_once('CLASS/autoload.php');   // pour inclure nos classes
	$title = 'Les Menus Services';
	$site = new page_clients('clients');
	$site->corps = '<nav >
			<ul id="navigation" class="nav-main">
				<li>
					<a href="ModifierClients.php">
					Accès aux fiches Clients</a>
				</li>
			<br>
				<li>
					<a href="ListeClient.php">
					Liste des Clients</a>
				</li>
			<br>		
				<li>
					<a href="AjoutClients.php">
					Créer un nouveau Client</a>
				</li>
			<br>				
					
			</ul>	
			<ul id="navigation" class="nav-main">
			<br>				
				<li>
					<a href="RappelClients.php">
					Rappel clients</a>
				</li>
			<br>	
				<li>
					<a href="periodeclients.php">
					Période Client</a>
				</li>
			<br>	
			</nav>';
	$site->affiche();

?>