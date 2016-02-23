
<?php

class page_base
{
	
	private $titre;
	private $style=array('BASE','MODELE','jquery-ui','validationEngine.jquery');
	private $corps;
	private $page;
	private $connexion;
	private $PDO;

	
	
	public function __construct($p) //Constructeur de la page base
	{
		$this->page = $p;		
		$this->PDO=New PDO_MS();
		$this->PDO->connexion("menuservice");
		$this->connexion=$this->PDO->connexion;
	}
	

	/******** Gestion des setters  *******************/
	public function __set($propriete, $valeur)
	{
		switch ($propriete) {
			case 'style' : {
				$this->style[count($this->style)+1] = $valeur;
				break;
			}			
			case 'corps' : {
				$this->corps = $valeur;
				break;
			}
			case 'parametre' : {
				$this->parametre = $valeur;
				break;
			}
		}
	}
	
	/******** Gestion du titre  *******************/
	private function affiche_titre()
	{
		echo utf8_encode($this->titre);
	}
 
	
	/*************Gestion des styles *********************/
	private function affiche_style()
	{
		foreach ($this->style as $s) {
			echo "<link rel='stylesheet' href='styles/".$s.".css' />\n";
		}
	}
	
	

	/************** Affichage du pied de la page ***************************/
	private function affiche_footer()
	{	
		?>		
		<p id="copyright">
			<b>
				<font color="black">V2 Février 2016</font>
				<a target="_blank" href="http://www.anjou-accompagne-services.fr/">Anjou Accompagn'Services</a> |||
				<a target="_blank" href="http://www.les-menus-services.com/">Les Menus Services</a>
			</b>
		</p>			
		<?php
	}
	
	/************** Affichage du pied du corps ***************************/	
	private function affiche_corps()
	{
 		echo $this->corps;	//utf8_encode($this->corps)
	}		
	
	/************** Affichage du pied de la nav ***************************/
	private function affiche_nav()
	{                                    
		?>  
        <fieldset>  
   <?php if (!isset($_SESSION['login'])) {
        }
        else
        {  ?>    	
			<nav>
			<ul id="navigation" class="nav-main">
				<li>
					<?php if (!isset($_SESSION['login'])) { ?>
					<a href="javascript:alert('Vous n\'êtes pas connectés, accès interdit !')">
					
					<?php } else { ?>
					<a href="Clients.php">
				<B><span style="border:3px solid black;;padding:15px 20px 15px 20px"><u>C</u>lients</a></span></a></B>
					<?php } ?>
				</li>			
				<li>
					<?php if (!isset($_SESSION['login'])) { ?>
					<a href="javascript:alert('Vous n\'êtes pas connectés, accès interdit !')">
					
					<?php } else { ?>
					<a href="Employes.php">
					<B><span style="border:3px solid black;;padding:15px 20px 15px 20px"><u>E</u>mployés</a></span></B>
					<?php } ?>
				</li>				
				<li>
					<?php if (!isset($_SESSION['login'])) { ?>
					<a href="javascript:alert('Vous n\'êtes pas connectés, accès interdit !')">
					
					<?php } else { ?>
					<a href="Interventions.php">
				<B>	<span style="border:3px solid black;;padding:15px 20px 15px 20px"><u>I</u>nterventions</a></span></B>
					<?php } ?>
				</li>					
				<li>
					<?php if (isset($_SESSION['login'])) { ?>					
					<a href="Deconnexion.php">
				<B>	<span style="border:3px solid black;padding:15px 20px 15px 20px"><u>D</u>éconnexion</a></span></B>
					<?php } ?>
				</li>			
				</ul>	
			</nav>       
          <?php
	}}

	/************** Affichage du pied du header ***************************/
	private function affiche_header() {
	?>	
	<h1>	
		<ul id="titre">
			<span>
				<a href="Deconnexion.php" >Les Menus Services - Jardinage</a>		
			</span>	
		</ul>
	</h1>
	<?php 	
	}

	
	/************** Gestion des dates  ***************************/
	public function AfficheDate($daterecu) // RECU : 2014-12-31 ENVOI : 31/12/2014
	{ 										
		$date = (string)$daterecu;
		$vretour = substr($date,8,2).'/'.substr($date,5,2).'/'.substr($date,0,4);
		return $vretour;
	}
	
	public function envoiMysqlDate($daterecu) // RECU : 31/12/2014 ENVOI : 2014-12-31
	{ 
	
		$dateA = str_replace('/', '-', $daterecu);
		$vretour = date('Y-m-d', strtotime($dateA));
		//$vretour = '2015-01-23';
		/*
		 * $date = DateTime::createFromFormat('d/m/Y', "24/04/2012");
			echo $date->format('Y-m-d');
		*/
		return $vretour;
	}
	
	
	/********** Affichage de la page *******/
	/*
	 * <link rel="stylesheet" href="STYLES/jquery-ui.css">
	 * <link rel="stylesheet" href="STYLES/validationEngine.jquery.css" type="text/css" media="screen" title="no title" charset="utf-8">
	*/
	public function affiche() {	
	?>         
			<!DOCTYPE html>
			 
			<html lang='fr'>
				<head>	
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">	
				<meta http-equiv="Content-type" content="text/html; charset=UTF-8"/> 	
					<title>
						V2 Les Menus Services
					</title>
					 <link rel="icon" type="image" href="STYLES\les-menus-services.gif" />
					 
					 
					 		<script src="js/jquery-1.8.2.min.js" type="text/javascript"></script>
							<script src="js/languages/jquery.validationEngine-fr.js" type="text/javascript" charset="utf-8"></script>
							<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>

							
							<script src="js/jquery-ui.js"></script>
							
							
							<script type="text/javascript" src="js/searchabledroplist/jquery.searchabledropdown-1.0.8.min.js"></script>
							<script type="text/javascript">
								$(document).ready(function() {
									
									$('#listeclients1').searchable();
									$('#listeclients2').searchable();
									$('#listeclients').searchable();
									$('#listeclients4').searchable();
									$('#listeemployes').searchable();
									$('#listeemployes4').searchable();
								});						
								jQuery(document).ready(function(){
   											$( ".datepicker" ).datepicker();	
   	   										jQuery("form").validationEngine();   	   										
								});
   									
							</script>
					
					<?php 
						$this->affiche_style(); 
					?>
				</head>
				<header>
				
				<?php 
				
				$this->affiche_header();				
				?>				
				</header>
				<body>				
				<div id="centre">
				<?php
				$this->affiche_nav();
				$this->affiche_corps();
				if (get_class($this)=='page_employes'){
					if ( isset($_POST['validform']))
					{
						$this->insertion_employe();
					}				
					if ( isset($_POST['ValidFormModC']))
					{
						$this->modifier_employe();
					}
					if ( isset($_POST['ValidFormSupC']))
					{
						$this->supprimer_employe();
					}
				}
				if (get_class($this)=='page_interventions'){
					if ( isset($_POST['ValidFormI']))
					{
						$this->insertion_Interventions();
					}				
				}
				if (get_class($this)=='page_clients'){
					if( isset($_POST['formclient']))
					{
						$this->insertion_client();
					}									
				}				
				?>
				</div>				
				</body>				
				<footer>
				<?php 
				$this->affiche_footer();
				?>				
				</footer>
			</html>
		<?php
	}
	
	
	public function excel() {
		?>
					<!DOCTYPE html>
					<html lang='fr'>
						<head>	
						<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">		
							<title>
								V2 Les Menus Services
							</title>
		
						</head>
						<header>
						
						<?php 
						
						$this->affiche_header();				
						?>				
						</header>
						<body>				
						<div id="centre">
						<?php
						
						$this->affiche_corps();
						if (get_class($this)=='page_employes'){
							if ( isset($_POST['validform']))
							{
								$this->insertion_employe();
							}				
							if ( isset($_POST['ValidFormModC']))
							{
								$this->modifier_employe();
							}
							if ( isset($_POST['ValidFormSupC']))
							{
								$this->supprimer_employe();
							}
						}
						if (get_class($this)=='page_interventions'){
							if ( isset($_POST['ValidFormI']))
							{
								$this->insertion_Interventions();
							}
							
						
						}
						if (get_class($this)=='page_clients'){
							if( isset($_POST['formclient']))
							{
								$this->insertion_client();
							}
							if( isset($_POST['modifclient']))
							{
								$this->modifier_client();
							}
							
						}				
						?>
						</div>				
						</body>				
						<footer>
						<?php 
						$this->affiche_footer();
						?>				
						</footer>
					</html>
				<?php
		
	}
	
}
?>
