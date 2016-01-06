<?php
	include_once('CLASS/autoload.php');   // pour inclure nos classes
	$title = 'Les Menus Services';
	$site = new page_clients('clients');
	$site->corps = '<nav >
			<ul id="navigation" class="nav-main">
				<li>
					<a href="ModifierClients.php">
					Liste des Clients</a>
				</li>
			<br>
				<li>
					<a href="ListeClient.php">
					accès aux fiches Clients </a>
				</li>
			<br>		
				<li>
					<a href="AjoutClients.php">
					Créer un nouveau Client</a>
				</li>
			<br>				
				<li>
					<a href="RappelClients.php">
					Rappel clients</a>
				</li>
			<br>				
			</ul>		
			</nav>';
	$site->affiche();

?>