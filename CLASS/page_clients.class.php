<?php

session_start();
if (!isset ($_SESSION['login']))
{
	
	header("Location: index.php");
}
class page_clients extends page_base {
	private $connexion;
	private $PDO;

	public function __construct($p) {
		parent::__construct($p);
		$this->PDO=New PDO_MS();
		$this->PDO->connexion("menuservice");
		$this->connexion=$this->PDO->connexion;
		
	}
	
	
	
	public function afficheajoutclient(){ //Fonction qui permet d'afficher le formulaire pour ajouter un nouveau client.
		$vretour = "
				<ul id='navigation'  class='nav-main'>
						
				<form method='POST' id='ajoutclient'  action='AjoutClients.php' >				
					<br>
						<h4>Formulaire de saisie des clients</h4><br>
								<label id='TableauClient'>CodeSage :</label><center> <input type='text' class='validate[required,custom[onlyLetterNumber]] text-input' id='CodeSage' name='CodeSageClient' value='".$this->dernier_codesage()."' /></center><br />
		          				<label id='TableauClient'>Nom du Client : </label><center><input type='text' class='validate[required,custom[onlyLetterSpE]] text-input' id='NomClient' name='NomClient' value='' /></center><br />					
		  						<label id='TableauClient'>Abrege : </label><center><input type='text' class='validate[required,custom[onlyLetterSpE]]text-input' id='Abrege' name='Abrege' value=''></center><br />
		         		    	<label id='TableauClient'>Adresse : </label><center><input type='text' class='validate[optionnal,custom[onlyNumberLetterSpAccent]] text-input' id='Adresse' name='Adresse'  value=''></center><br />
								<label id='TableauClient'>Complement : </label><center><input type='text' id='Complement' name='Complement' value=''></center><br />
								<label id='TableauClient'>Code Postal :</label><center> <input type='text' class='validate[optionnal,minSize[5],maxSize[5],custom[integer]] text-input' id='CodePostal' text-input' name='CodePostal' value=''></center><br /<br>
								<label id='TableauClient'>Commune :</label><center> <input type='text' class='validate[optionnal,custom[onlyNumberLetterSpAccent]] text-input' id='Commune' name='Commune' value=''></center><br />
								<label id='TableauClient'>Telephone :</label><center> <input type='text' class='validate[optionnal,custom[phone],minSize[10]] text-input' id='Telephone' name='Telephone'  value=''></center><br /><br>
								<label id='TableauClient'>Détails :</label><center> <input type='text' class='validate[optionnal] text-input' id='Details' name='Details'  value=''></center><br /><br>
								<ul><li><label id='TableauClient'>Age :</label> <label id='TableauClient1'>-70 ans :</label><center><input type='radio' class='validate[required] radio'  id='Age' name='Age' value='0'  ></li></center>
								     <li> <label id='TableauClient1'>+70 ans :</label><center><input type='radio' class='validate[required] radio' id='Age2'  name='Age'  value='1'></li></ul></center><br><br>
		          				<ul><li><label id='TableauClient'> Regularité :</label> <label id='TableauClient1'> Oui :</label><center><input type='radio' class='validate[required] radio' id='Regularite1' name='Regularite'  value='1'></center></li>
										     <li><label id='TableauClient1'>Non :</label> <center><input type='radio' class='validate[required] radio' id='Regularite2'   name='Regularite'  value='2'></center></li>
										     <li><label id='TableauClient1'>Non défini :</label> <center><input type='radio' class='validate[required] radio' id='Regularite'  name='Regularite'  value='0' ></li></ul></center>
													
		            <br />						
		            <input type='submit' class='submit' name='formclient' value='Ajouter' /><br><br>		
				</form>	
						
				</ul>
				<ul id='navigation' class='nav-main'><br><input type='button' value='Retour' onClick=\"javascript:document.location.href='Clients.php'\"/><br> <br></ul>
		
		
				<script>					
					$('#Regularite').attr('checked','checked');
        		</script>
				";
		
		return $vretour;
	}
	
	public function insertion_client() // Pour inserer un nouveau client.
	{
		$retour="echec de l'insertion";		
		if (isset ( $_POST['NomClient'])){		//Si j'ai bien Nom Client de POST alors :	
			$CodeSage = $_POST['CodeSageClient'];
			$NomClient = $_POST['NomClient'];
			$Abrege = $_POST['Abrege'];
			$Adresse = $_POST['Adresse'];
			$Complement = $_POST['Complement'];
			$CodePostal = $_POST['CodePostal'];
			$Commune = $_POST['Commune'];
			$Telephone = $_POST['Telephone'];
			$Details = $_POST['Details'];	
			if($_POST['Age']==0){ // Si le radio bouton age - 70 est cocher alors Age = 0 . (On a dans la base de donnees un champ bit d'oé le 0 ou 1).
				$Age=0;
			}
			else  // Sinon c'est que le bouton age + 70 est cocher alors Age = 1. 
			{ 
				$Age=1;
			}
			echo $Age;	
			if($_POST['Regularite']==0){
				$Regularite = 0;		// Dans le cas oé on ne connait pas la regularite du client. (On a dans la base de donnees un champ tynintd'oé le 0 , 1 ou 2).
			}
			else if($_POST['Regularite']==1){
				$Regularite = 1;  //Dans le cas oé le client est régulier.
			}
			else if($_POST['Regularite']==2){
				$Regularite = 2; // Dans le cas oé le client n'est pas régulier.
			}
			
			if (isset($_POST['Inactif'])) // Si la case est coché on passe bien en inactif
			{			
				$inactif=1;
			}
			else // Sinon met éa é 0. 
			{
				 $inactif=0;
			}
					
			$retour = 'echec insertion mais connexion OK ';
			$requete = 'insert into clients values ("'.$CodeSage.'","'.$NomClient.'","'.$Abrege.'","'.$Adresse.'","'.$Complement.'","'.$CodePostal.'","'.$Commune.'","' .$Telephone .'","'.$Details.'",'.$Age.','.$Regularite.','.$inactif.');';
			$resultat = $this->connexion->query ( $requete );
			$retour = '<h4>CLIENT INSERER</h4>';	
			echo utf8_encode("<script> alert(' Insertion du client réussie '); </script>");	
		}
		return $retour;		
	}
	
	public function modifier_client() //Fonction qui permet de modifier un client.
	{
		$retour="Echec de l'insertion";
		if (isset ( $_POST['NomClientM'])) //Si j'ai bien un Nom de client de "POST" alors je peux modifier.
		{
			$CodeSage = $_POST['CodeSageClientM'];
			$NomClient = $_POST['NomClientM'];
			$Abrege = $_POST['AbregeM'];
			$Adresse = $_POST['AdresseM'];
			$Complement = $_POST['ComplementM'];
			$CodePostal = $_POST['CodePostalM'];
			$Commune = $_POST['CommuneM'];
			$Telephone = $this->envoitelephone($_POST['TelephoneM']);
			$Details = $_POST['DetailsM'];
			if($_POST['AgeM']==0){
				$Age=0;
			}
			else
			{
				$Age=1;
			}			
			if($_POST['RegulariteM']==0){
				$Regularite = 0;		// Dans le cas oé on ne connait pas la regularite du client.
			}
			else if($_POST['RegulariteM']==1){
				$Regularite = 1;  //Dans le cas oé le client est régulier.
			}
			else if($_POST['RegulariteM']==2){
				$Regularite = 2; // Dans le cas oé le client n'est pas régulier.
			}
	
			if (isset($_POST['InactifM'])) // Si la case est coché on passe bien en inactif
			{
				$inactif=1;
			}
			else // Sinon met éa é 0.
			{
				$inactif=0;
			}
	
			$retour = 'connexion OK ';
			/*if ((! is_string ( $CodeSage )) && (! is_int ( $CodePostal )) && (! is_int ( $Telephone ))) { //Verif de base mais le jquery verifie tout avant ! Donc test finalement inutile 
				$retour = '<h4>ERREUR DE SAISIE</h4>';
			} else {
			*/
				$requete = 'update clients set CODESAGE="'.$CodeSage.'",NOM="'.$NomClient.'",ABREGE="'.$Abrege.'",ADRESSE="'.$Adresse.'",COMPLEMENT="'.$Complement.'",CODEPOSTAL="'.$CodePostal.'",COMMUNE="'.$Commune.'",TELEPHONE="' .$Telephone .'",DETAILS="'.$Details.'",AGE='.$Age.',REGULARITE='.$Regularite.',INACTIF='.$inactif.' WHERE CODESAGE="'.$CodeSage.'";';
				$resultat = $this->connexion->query ( $requete );
				$retour = '<script> alert(\" Modification du client réussie \"); </script>';
				echo utf8_encode("<script> alert('Modification du client réussie '); </script>");
			
	
		}		
		return $retour;
	
	}
	
	public function dernier_codesage() //Permet de connaitre le dernier client C000 inscrit dans la BDD. /!\/!\/!\/!\/!\/!\/!\ A REVOIR /!\ /!\/!\/!\/!\/!\
	{
		$vretour='';
		$requete = 'SELECT MAX(substr(CodeSage,2,100)+1) AS nb FROM Clients ;'; //(il existe client qui ne sont pas de la forme C0001111 d'oé le substr ).
		$resultat = $this->connexion->query( $requete);
		$vretour=$resultat->fetch(PDO::FETCH_OBJ)->nb;
		if(strlen($vretour)==4)
		{
			$vretour='C000'.$vretour;
		}
		else if(strlen($vretour)==5)
		{
			$vretour='C00'.$vretour;
		}	
		return $vretour;		
	}
	
	
	
	
	
	
	
	
	
	public function afficheModifClient(){
		// Permet d'afficher la liste des clients selon leurs codesage. 
		/*
		 	alert(\"LE ONCHANGE FONCTIONNE !!! \");
			$( '#listeclients2' ).hide();
			
		*/
		
		$tabCodeSage = array();
		
		$vretour="
				<script>
					function Submitliste1()
					{												
						$( '#formlist1' ).submit();
					}				
				</script>
				
				
				
				<ul id='navigation' class='nav-main'>
				<li>
					<a href='TousClients.php'>
					Liste de tous les clients</a>
				</li>
				</ul>";
				

		if((isset($_POST['afficherC']))||(isset($_POST['CodeSageClientCache']))) // S'il y a un client de selectionné dans la liste et un submit via afficher alors tu execute la fonction afficherclient.
		{
			$vretour=$vretour.$this->afficherclient($tabCodeSage); //Envoi du tableau des clients qui permet de faire fonctionner les boutons précedent et suivant.
		}
		
		//$vretour = $vretour."<a href=\"Clients.php\">Retour</a>"	;
		$vretour= $vretour."<ul id='navigation' class='nav-main'><br><input type='button' value='Retour' onClick=\"javascript:document.location.href='Clients.php'\"/><br> <br></ul>";
		return $vretour;	
	}
	
	
	
	
	
	
	
	
	
	
	
	public function affichelisteclient(){ // Permet d'afficher la liste des clients selon leurs codesage. 
		/*
		 	alert(\"LE ONCHANGE FONCTIONNE !!! \");
			$( '#listeclients2' ).hide();
		*/
		$tabCodeSage = array();
		
		$vretour="
				<script>
					function Submitliste1()
					{												
						$( '#formlist1' ).submit();
					}				
				</script>
				
				
				
			
				
				
				<ul id='navigation' class='nav-main'>
				<h3> Fiche client : </h3>
				<br><form id='formlist1' method='POST' action='ModifierClients.php' >";
		
		
		$req = 'SELECT CODESAGE,NOM FROM Clients ORDER BY `NOM` ASC ;';			
		$result = $this->connexion->query($req);		
		if(isset($result)) //Si il existe un resultat alors je remplis la liste de client.
		{			
				//$vretour= $vretour."<center><li><label>Liste par ordre alphabétique :</label><select name='listeclients1' id='listeclients1'  onchange=\"Submitliste1()\"><option value='VIDE'> </option>";
		
			$vretour= $vretour."<center><li><label>Liste par ordre alphabétique :</label><select name='listeclients1' id='listeclients1' ><option value='VIDE'> </option>";
				while ($donnees = $result->fetch(PDO::FETCH_OBJ)) {					
					$vretour= $vretour.'<option value=' . $donnees->CODESAGE . '>'. $donnees->CODESAGE .' - ' . $donnees->NOM . '</option>';
					//array_push($tabCodeSage,$donnees->CODESAGE); // pour empiler les codesages a la fin du tableau.
					$tabCodeSage[] = $donnees->CODESAGE;
				}
				$result->closeCursor ();
				$vretour = $vretour."</select></li></center>
						<input type='submit' name='afficherC' id='afficherC' value='Afficher' >
						<input type='submit' name='modifierC' id='modifierC' value='Modifier'> " ;			
		}
		
		$vretour= $vretour."</form><br><br></ul>";
		
		//ENSUITE j'affiche le reste de la page. 
		
		if((isset($_POST['modifierC']))||(isset($_POST['CodeSageClientM']))) // S'il y a un client de selectionné dans la liste et un submit via modifier alors tu execute la fonction modifierclient. 
		{ 
			
			$vretour=$vretour.$this->afficherclientamodifier($tabCodeSage); //Envoi du tableau des clients qui permet de faire fonctionner les boutons précedent et suivant.
		}
		if((isset($_POST['afficherC']))||(isset($_POST['CodeSageClientCache']))) // S'il y a un client de selectionné dans la liste et un submit via afficher alors tu execute la fonction afficherclient.
		{ 
			$vretour=$vretour.$this->afficherclient($tabCodeSage); //Envoi du tableau des clients qui permet de faire fonctionner les boutons précedent et suivant.
		}
		//$vretour = $vretour."<a href=\"Clients.php\">Retour</a>"	;
		$vretour= $vretour."<ul id='navigation' class='nav-main'><br><input type='button' value='Retour' onClick=\"javascript:document.location.href='Clients.php'\"/><br> <br></ul>";
		return $vretour;	
	}
		
	
	
	public function afficherclient($tousCodeSage){ //Fonction qui permet d'afficher un client préalablement choisi dans la liste. 
		$vretour = "<ul id='navigation' class='nav-main'><br><center>
				<form id='formAfficheclient' method='POST' action='ModifierClients.php#formAfficheclient' > 
				";
		
			
			
		$codesageclients = "VIDE OK";
		$longueur = count($tousCodeSage);
		$index = 0;
		if(((isset($_POST['listeclients1']))&&($_POST['listeclients1'] != 'VIDE'))||(isset($_POST['CodeSageClientCache']))) 
		{
			if(isset($_POST['listeclients1']))
			{
				$codesageclients = $_POST['listeclients1'];
			}
			else if (isset($_POST['CodeSageClientCache']))
			{
				//$codesageclients = $_POST['CodeSageClientCache'];
				foreach($tousCodeSage as $key => $value)
				{
					if($value == $_POST['CodeSageClientCache'])
					{
						$index = $key ;					
						break;
					}
				}
				if (isset($_POST['APrecedentC'])){
					$index = $index - 1;
				}
				else if (isset($_POST['ASuivantC']))
				{
					$index = $index + 1;
				}
				$codesageclients = $tousCodeSage[$index];			
					
			}
			
			
			$req= 'SELECT * FROM Clients WHERE CODESAGE =\''.$codesageclients.'\';';
			$resultat = $this->connexion->query($req);
			//CodeSage : <input type='text' name='CodeSageClient' value='".$clients."' /><br /><br> ($infoclients->TELEPHONE)
			while ($infoclients = $resultat->fetch(PDO::FETCH_OBJ)) {
				$vretour = $vretour."						
						<input type='hidden' id='CodeSageClientCache' name='CodeSageClientCache' value='".$codesageclients."'/>					
						<table id='tab1client'>
						<tr>							 
						<td> CodeSage </td>
						<td> $codesageclients </td> 						
						</tr>
						<tr>
						<td> Nom du Client </td>
						<td> $infoclients->NOM </td>
						</tr>
						<tr>
						<td> Abrege </td>
						<td> $infoclients->ABREGE </td>
						</tr>
						<tr>
						<td> Adresse </td>
						<td> $infoclients->ADRESSE </td>
						</tr>
						<tr>
						<td> Complement </td>
						<td> $infoclients->COMPLEMENT </td>
						</tr>
						<tr>
						<td> Code Postal </td>
						<td> $infoclients->CODEPOSTAL </td>
						</tr>
						<tr>
						<td> Commune </td>
						<td> $infoclients->COMMUNE </td>
						</tr>
						<tr>
						<td> Telephone </td>
						<td> ".$this->Affichetelephone($infoclients->TELEPHONE)." </td>
						</tr>
						<tr>
						<td> Détails </td>
						<td> ".$infoclients->DETAILS."</td>
						</tr>";
			
					if($infoclients->AGE==0)
					{
						$vretour=$vretour."<tr><td> Age </td><td> Moins de 70 ans </td></tr>";
					}
					else if($infoclients->AGE==1)
					{
						$vretour=$vretour."<tr><td> Age </td><td> Plus de 70 ans </td></tr>";
					}
					if($infoclients->REGULARITE==2)
					{ // Pour non value =2
						$vretour=$vretour."<tr><td> Regulier </td><td> Non </td></tr>";
					}
					else if($infoclients->REGULARITE==1)
					{  //Pour oui value = 1
						$vretour=$vretour."<tr><td> Regulier </td><td> Oui </td></tr>";
					}
					else if($infoclients->REGULARITE==0)
					{ //Pour inconnu value = 0
						$vretour=$vretour."<tr><td> Regulier </td><td> Inconnu </td></tr>";
					}		
					if($infoclients->inactif==1)
					{
						$vretour=$vretour."<tr><td> Inactif </td><td> Oui </td></tr>";
					}
					else
					{
						$vretour=$vretour."<tr><td> Inactif </td><td> Non </td></tr>";
					}			
					
			}
			$resultat->closeCursor ();
			$vretour = $vretour."</table><br>";
			if($tousCodeSage[0] == $codesageclients)//Dans le cas oé on est au premier client enregistré.
			{
				$vretour = $vretour."<input type='submit' name='ASuivantC' id='ASuivantC' value='Suivant'> ";
			}
			else if($index == $longueur-1){ //Dans le cas oé on arrive au dernier client enregistré.
				$vretour = $vretour."<input type='submit' name='APrecedentC' id='APrecedentC' value='Precedent'> ";
			}
			else 
			{
				$vretour = $vretour."<input type='submit' name='APrecedentC' id='APrecedentC' value='Precedent'>
									 <input type='submit' name='ASuivantC' id='ASuivantC' value='Suivant'>";
			}
				
			$vretour=$vretour."		</form></center></ul>
											<script> var code = $('#CodeSageClientCache').val();
												$('#listeclients1 option[value='+code+']').attr('selected', 'selected');
											</script>";
		}
		else
		{
			$vretour = " ".$vretour." <br>Aucun client choisi<br>.</ul>";
		}
		return $vretour;
	}
	
	public function afficherclientamodifier($tousCodeSageM){ //Permet d'afficher le client qui sera é modifier qui aura été préalablement choisi dans la liste des clients.
		$vretour="<ul id='navigation' class='nav-main'><br>
				  <form method='POST' id='modifclient' action='ModifierClients.php#modifclient' >
				  <br>";
		$clients="";
		$longueurM = count($tousCodeSageM);
		$indexM = 0;		
		if(((isset($_POST['listeclients1']))&&($_POST['listeclients1'] != 'VIDE'))||(isset($_POST['CodeSageClientM'])))
		{
			if(isset($_POST['listeclients1'])){
				$clients= $_POST['listeclients1'];
			}
			else if (isset($_POST['CodeSageClientM']))
			{
				//$codesageclients = $_POST['CodeSageClientCache'];
				foreach($tousCodeSageM as $key => $value)
				{
					if($value == $_POST['CodeSageClientM'])
					{
						$indexM = $key ;
						break;
					}
				}
				if (isset($_POST['MPrecedentC']))
				{
					$indexM = $indexM - 1;
				}
				else if (isset($_POST['MSuivantC']))
				{
					$indexM = $indexM + 1;
				}
				$clients = $tousCodeSageM[$indexM];
					
			}
			$req= 'SELECT * FROM Clients WHERE CODESAGE =\''.$clients.'\';';
			$resultat = $this->connexion->query($req);
			//CodeSage : <input type='text' name='CodeSageClient' value='".$clients."' /><br /><br> ($infoclients->TELEPHONE)
			while ($infoclients = $resultat->fetch(PDO::FETCH_OBJ)) {
				$vretour = $vretour."
						
					<label id='TableauClient'> CodeSage : </label><center><input type='text' READONLY='true' class='validate[required,custom[onlyLetterNumber]] text-input' id='CodeSageClientM' name='CodeSageClientM' value=\"".$clients."\"/></center><br>
	
					<label id='TableauClient'> Nom du Client : </label><center><input type='text' class='validate[required,custom[onlyLetterSpE]] text-input'  id='NomClient' name='NomClientM' value=\"".$infoclients->NOM."\" /></center><br>
	
					<label id='TableauClient'> Abrege : </label><center><input type='text' class='validate[required,custom[onlyLetterSpE]]text-input' id='Abrege' name='AbregeM' value=\"".$infoclients->ABREGE."\" /></center><br>
	
					<label id='TableauClient'> Adresse : </label><center><input type='text' class='validate[required,custom[onlyNumberLetterSpAccent]] text-input' id='Adresse' name='AdresseM'  value=\"".$infoclients->ADRESSE."\" /></center><br>
	
					<label id='TableauClient'> Complement :</label><center> <input type='text' id='Complement' name='ComplementM' value='".$infoclients->COMPLEMENT."' /></center><br>
	
					<label id='TableauClient'> Code Postal : </label><center><input type='text' class='validate[required,minSize[5],maxSize[5],custom[integer]] text-input' id='CodePostal' name='CodePostalM' value='".$infoclients->CODEPOSTAL."' /></center><br>
	
					<label id='TableauClient'> Commune : </label><center><input type='text' class='validate[required,custom[onlyNumberLetterSpAccent]] text-input' id='Commune' name='CommuneM' value=\"".$infoclients->COMMUNE."\" /></center><br>
	
					<label id='TableauClient'> Telephone : </label><center><input type='text'   id='Telephone' name='TelephoneM' class='validate[optionnal,minSize[10]] text-input'  value='".$this->Affichetelephone($infoclients->TELEPHONE)."' /></center><br>
					
					<label id='TableauClient'>Détails :</label><center> <input type='text' class='validate[optionnal] text-input' id='Details' name='DetailsM'  value=\"".$infoclients->DETAILS."\"></center><br /><br>
					 <ul><li><label id='TableauClient'>Age :</label>
										<label id='TableauClient1'> -70 ans :</label><input type='radio' class='validate[required] radio'  id='AgeMoins' name='AgeM' value='0'  ></li>
										<li><label id='TableauClient1'>+70 ans :</label> <input type='radio' class='validate[required] radio' id='AgePlus'  name='AgeM'  value='1'></li></ul><br>
	
					 <ul><li><label id='TableauClient'>Regularité : </label>
								<label id='TableauClient1'>Oui :</label> <input type='radio' class='validate[required] radio' id='RegulariteOui' name='RegulariteM'  value='1'>
								<li><label id='TableauClient1'>Non :</label> <input type='radio' class='validate[required] radio' id='RegulariteNon'   name='RegulariteM'  value='2'></li>
								<li><label id='TableauClient1'>Non défini : </label><input type='radio' class='validate[required] radio' id='RegulariteI'  name='RegulariteM'  value='0' ></li></ul><br>
	
					 <ul><li><label id='TableauClient1'>Inactif : </label>
							<center><input type='checkbox' id='Inactif' name='InactifM' value='0'></center></li></ul>
					 <br />
					 <input type='submit' id='modifclientbtn' name='modifclient' value='Valider la modification' /></br></br>
					";
				$age = $infoclients->AGE;
				$regu = $infoclients->REGULARITE;	
				$ina = $infoclients->inactif;	
				if($tousCodeSageM[0] == $clients)//Dans le cas oé on est au premier client enregistré.
				{
					$vretour = $vretour."<input type='submit' name='MSuivantC' id='MSuivantC' value='Suivant'> ";
				}
				else if($indexM == $longueurM-1){ //Dans le cas oé on arrive au dernier client enregistré.
					$vretour = $vretour."<input type='submit' name='MPrecedentC' id='MPrecedentC' value='Precedent'> ";
				}
				else
				{
					$vretour = $vretour."<input type='submit' name='MPrecedentC' id='MPrecedentC' value='Precedent'>
									 <input type='submit' name='MSuivantC' id='MSuivantC' value='Suivant'>";
				}
				
			}
			$resultat->closeCursor ();
				
			$vretour=$vretour."			
							</form><br></ul>";
			
			if($age == 0)
			{
				$vretour=$vretour."<script>$('#AgeMoins').attr('checked','checked');";
			}
			else if($age == 1)
			{
				$vretour=$vretour."<script>$('#AgePlus').attr('checked','checked');";
			}
			if($regu == 2)
			{ // Pour non value =2
			$vretour=$vretour."$('#RegulariteNon').attr('checked','checked');";
			}
			else if($regu == 1)
			{  //Pour oui value = 1
			$vretour=$vretour."$('#RegulariteOui').attr('checked','checked');";
			}
			else if($regu == 0)
			{ //Pour inconnu value = 0
			$vretour=$vretour."$('#RegulariteI').attr('checked','checked');";
			}
			
			if($ina == 1){
				$vretour=$vretour."$('#Inactif').attr('checked','checked');";
			}
			$vretour=$vretour."
					var code = $('#CodeSageClientM').val();
					$('#listeclients1 option[value='+code+']').attr('selected', 'selected');
					</script>";
		}
		else
		{
			$vretour = " ".$vretour." <br>Aucun client choisi<br>.</ul>";
		}
		return $vretour;
	}
	
	public function Affichetelephone($telrecu){ //fonction qui permet d'afficher un numero de telephone sous le format : 02.02.02.02.02
		/*
		$tel = (string)$telrecu;				
		$vretour = substr($tel,0,2).".".substr($tel,2,2).".".substr($tel,4,2).".".substr($tel,6,2).".".substr($tel,8,2);
		*/
		//$tabretour = str_split('');	//Convertit une chaéne de caractéres en tableau	
		$tabretour = array();
		$vretour = '';
		$i = 0;
		$tabtel = array();
		$tabtel = str_split($telrecu);
		$longueur = strlen($telrecu);
		while($i < $longueur){
			if(is_int(intval($tabtel[$i]))){
				$tabretour[] = $tabtel[$i];
			}
			$i = $i + 1;
		}		
		if((isset($tabretour[0]))&&(($tabretour[0] == 0)&&($longueur == 11))) //Les numeros de telephone recu auront forcement 11 chiffres é cause du int(11) qui a l'optipn unsigned zero fill sous phpmyadmin. Si on enleve cette option si le premier numero du telephone est un 0 ce zéro sera alors supprimé par phpmyadmin.
		{
			$telstring = implode("", $tabretour); //Pour remettre le contenu du tableau tabretour dans un string.
			$vretour = substr($telstring,1,2).".".substr($telstring,3,2).".".substr($telstring,5,2).".".substr($telstring,7,2).".".substr($telstring,9,2);
		}		
		else if ($longueur == 11)
		{ //Si on a un numero de telephone tel que : 33212345678.--> qui voudrait donc signifier +33 2 12 34 56 78
			$telstring = implode("", $tabretour);
			$vretour = substr($telstring,0,2).".".substr($telstring,2,1).".".substr($telstring,3,2).".".substr($telstring,5,2).".".substr($telstring,7,2).".".substr($telstring,9,2);
		}		
		return $vretour;
	}
	
	public function envoitelephone($telrecu){ //fonction qui permet de mettre un numero de tel sous le format : 0202020202		
		$tel='';
		$i = 0;
		$tabtel = array();
				
		$longueur = strlen($telrecu);
		$tabtel = str_split($telrecu);
		while($i< $longueur){
			if($tabtel[$i] != "."){ //Pour remettre le contenu du tableau tabtel dans un string sans espace ni aucun autre caractére d'oé les "".
				$tel=$tel."".$tabtel[$i];
			}
			$i = $i + 1;
		}
		return $tel;
	}	
	
	public function Rappelclients(){
		/*rzsd
		 $demain =  time() + 86400; // ajout de 24 heures
		 date('Y-m-d', $demain)
		 */
	
		$vretour = '';
		if( isset($_POST['ValidFormRappelclient'])) // Lorsqu'on a choisi une date.
		{
			$daterecu1 = $_POST['DateEnvoiRappel1'];
			$daterecu2 = $_POST['DateEnvoiRappel2'];
			$vretour="
			<ul id='navigation' class='nav-main'><br>
			<form method='POST' id='Formrappelclient' action='RappelClients.php' >
			<label> Veuillez choisir un intervalle de date (les clients dont la derniére intervention se situe dans l'intervalle choisi s'afficheront) :</label>
			<br><input type='text' class='validate[required] text-input datepicker' name='DateEnvoiRappel1' id='DateEnvoiRappel1' value='$daterecu1'>
			<input type='text' class='validate[required] text-input datepicker' name='DateEnvoiRappel2' id='DateEnvoiRappel2'  value='$daterecu2'>
			<input type='submit' name='ValidFormRappelclient' value='OK'>
			</form>
			<br>
			</ul>";
			$vretour = $vretour.$this->afficheclientsrappel($daterecu1,$daterecu2);
				
				
		}
		else if (isset( $_POST['ClientsrappelValid'])) // Lorsqu'on modifie un client.
		{
			
			$daterecu1 = $_POST['Daterappel1'];
				$daterecu2 = $_POST['Daterappel2'];
				$CodeSageR = $_POST['Codesagerappel'];
				$NomR = $this->connexion -> quote($_POST['Nomrappel']);
				if($_POST['Regulariterappel']==0)
					{
					$RegulariteR = 0;		// Dans le cas oé on ne connait pas la regularite du client.
			}
			else if($_POST['Regulariterappel']==1)
				{
					$RegulariteR = 1;  //Dans le cas oé le client est régulier.
			}
			else if($_POST['Regulariterappel']==2)
				{
					$RegulariteR = 2; // Dans le cas oé le client n'est pas régulier.
			}
			if (isset($_POST['Inactifrappel']))
					{
					$inactifR=1;
			}
			else
				{
				$inactifR=0;
			}
			$requeteR = 'update clients set CODESAGE="'.$CodeSageR.'",REGULARITE='.$RegulariteR.',INACTIF='.$inactifR.' WHERE CODESAGE="'.$CodeSageR.'";';
				$resultatR = $this->connexion->query ( $requeteR );
					//$vretour="<script> document.location = ('RappelClients.php')</script>";
			$vretour="
			<ul id='navigation' class='nav-main'><br>
			<form method='POST' id='Formrappelclient' action='RappelClients.php' >
			<label> Veuillez choisir un intervalle de date (les clients dont la derniére intervention se situe dans l'intervalle choisi s'afficheront) :</label>
			<input type='text' class='validate[required] text-input datepicker' name='DateEnvoiRappel1' id='DateEnvoiRappel1' value='$daterecu1'>
			<input type='text' class='validate[required] text-input datepicker' name='DateEnvoiRappel2' id='DateEnvoiRappel2'  value='$daterecu2'>
			<input type='submit' name='ValidFormRappelclient' value='OK'>
			</form>
			<br>
			</ul>";
			$vretour = $vretour.$this->afficheclientsrappel($daterecu1,$daterecu2);
		
		}
		/*else if(isset($_POST['RappelDInterv'])) // REDIRECTION SUR L'intervention.
		{
			$vretour = $site->Afficher_derniere_intervention();
		}
		*/
		else //SI on arrive sur la page la 1ere fois.
		{
		$daterecu =  $this->AfficheDate(date('Y-m-d'));
		$vretour="
			<ul id='navigation' class='nav-main'><br>
					<form method='POST' id='Formrappelclient' action='RappelClients.php' >
					<label> Veuillez choisir un intervalle de date (les clients dont la derniére intervention se situe dans l'intervalle choisi s'afficheront) :</label>
					<input type='text' class='validate[required] text-input datepicker' name='DateEnvoiRappel1' id='DateEnvoiRappel1' value='$daterecu'>
					<input type='text' class='validate[required] text-input datepicker' name='DateEnvoiRappel2' id='DateEnvoiRappel2'  value='$daterecu'>
					<input type='submit' name='ValidFormRappelclient' value='OK'>
					</form>
					<br>
					</ul>";
		}
		return $vretour;
	}
	
	public function afficheclientsrappel($dateRa1,$dateRa2){
		$lien = "RappelClients.php";
		$limite = 25; // Limit sert é définir le nombre de tuples é afficher.
		if(isset($_GET['debut'])){
			$debut = $_GET['debut'];
		}
		else if (empty($debut))
		{
			$debut=0;					// L'offset sert é définir le point de départ.
		}
		$datePourMysql1 =  $this->envoiMysqlDate($dateRa1);
		$datePourMysql2 = $this->envoiMysqlDate($dateRa2);
		/*
		$reqcompt = "SELECT COUNT(*) AS nb From interventions
			as I INNER JOIN clients as C on I.CLIENTSAGE=C.CODESAGE
			WHERE I.DATE < CAST('$datePourMysql' AS DATE)
			AND C.inactif !=1
			AND C.CODESAGE NOT IN (Select C.CODESAGE From interventions as I
			INNER JOIN clients as C on I.CLIENTSAGE=C.CODESAGE
			WHERE C.inactif != 1 AND I.DATE > CAST('$datePourMysql' AS DATE))
			ORDER BY I.DATE DESC;";
		$result = $this->connexion->query($reqcompt);		
		$nblignes = $result->fetch(PDO::FETCH_OBJ )->nb;
		*/
		$nblignes = 2 ; // /!\ TEMPORAIRE NE SERA PLUS LA LORSQUE QUE LA BARRE DE NAVIGATION SERA EN PLACE
		$vretour= "<ul id='navigation' class='nav-main'>";
		if($nblignes > 0)
		{		
			$req = "Select C.CODESAGE,C.NOM,C.REGULARITE,I.NINTERV,I.NUMEMPLSAGE,I.DATE
					From interventions as I
					INNER JOIN clients as C on I.CLIENTSAGE=C.CODESAGE
					WHERE I.DATE BETWEEN CAST('$datePourMysql1' AS DATE)AND CAST('$datePourMysql2' AS DATE)					
					AND C.CODESAGE NOT IN (Select C.CODESAGE From interventions as I
					                       INNER JOIN clients as C on I.CLIENTSAGE=C.CODESAGE
					                       WHERE I.DATE > CAST('$datePourMysql2' AS DATE))
					                       ORDER BY I.DATE DESC; ";
			/*$req ="Select C.CODESAGE,C.NOM,C.REGULARITE,I.DATE From interventions
				as I INNER JOIN clients as C on I.CLIENTSAGE=C.CODESAGE
				WHERE I.DATE < CAST('$datePourMysql' AS DATE)
				AND C.inactif !=1
				AND C.CODESAGE NOT IN (Select C.CODESAGE From interventions as I
				INNER JOIN clients as C on I.CLIENTSAGE=C.CODESAGE
				WHERE C.inactif != 1 AND I.DATE > CAST('$datePourMysql' AS DATE))
				ORDER BY I.DATE DESC ;";
			*/
			
			/*
			$req ="Select C.CODESAGE,C.NOM,C.REGULARITE,I.DATE From interventions
				as I INNER JOIN clients as C on I.CLIENTSAGE=C.CODESAGE
				WHERE I.DATE < CAST('$datePourMysql' AS DATE)
				AND C.inactif !=1
				AND C.CODESAGE NOT IN (Select C.CODESAGE From interventions as I
				INNER JOIN clients as C on I.CLIENTSAGE=C.CODESAGE
				WHERE C.inactif != 1 AND I.DATE > CAST('$datePourMysql' AS DATE))
				ORDER BY I.DATE DESC LIMIT ".$limite." OFFSET ".$debut.";";
				*/
			$resultat = $this->connexion->query($req);
			if ( !$resultat)
			{
				$vretour=$vretour."<p>Aucun clients é rappeler</p>";
			}
			else
			{
				$vretour=$vretour. "<center>
										<table id='Tabcontientrappel'>
											<tr>
	        								<td>
												<table id='tabrappel'>
													<caption>
														<h2>Liste des clients dont la derniére intervention <br> est situé entre le :<input type='text' name='DateAffiche1' readonly='true' value='$dateRa1'> et le <input type='text' name='DateAffiche2' readonly='true' value='$dateRa2'></h2>
													</caption>
													<tr>
														<th>CodeSage</th><th>Nom</th><th>Date de la derniére intervention</th><th>Régulier</th><th>Non Régulier</th><th>Inconnu</th><th>Inactif</th><th>Lien vers l'intervention</th>
													</tr>";
				//$vretour = $vretour."<ul id='navigation' class='nav-main'><br><center>";//<table><tr><th>CodeSage :</th><th>Nom du client :</th><th>Date de la derniére intervention :</th><th>Régulier</th><th>Non Régulier</th><th>Inconnu</th><th>Inactif :</th></tr>";
				
				
				$tabcodesage= array('');
				while($clients = $resultat->fetch(PDO::FETCH_OBJ)){
					if((in_array($clients->CODESAGE , $tabcodesage)) == false){			 //SI le codesage est pas déjé dans la liste tu lui ajoute et modifie vretour.
						$tabcodesage[]=$clients->CODESAGE;
							
						if($clients->REGULARITE == 1)
						{
							$RadioRegulier= "<td><input type='radio' name='Regulariterappel' checked value='1'></td>
								<td><center><input type='radio' name='Regulariterappel' value='2'></center></td>
														<td><input type='radio' name='Regulariterappel' value='0'></td>";
						}
						else if($clients->REGULARITE == 2)
						{
							$RadioRegulier= "<td><input type='radio' name='Regulariterappel' value='1'></td>
													<td><center><input type='radio' name='Regulariterappel' checked value='2'></center></td>
														<td><input type='radio' name='Regulariterappel' value='0'></td>";
						}
						else
						{
							$RadioRegulier= "<td><input type='radio' name='Regulariterappel' value='1'></td>
								<td><center><input type='radio' name='Regulariterappel' value='2'></center></td>
														<td><input type='radio' name='Regulariterappel' checked value='0'></td>";
						}
						$vretour = $vretour."<form method='post' id='rappelclients' name='Clientsrappel' action='RappelDInterv.php'>
								<tr>
								<td>	<input type='text' name='Codesagerappel' readonly='true' value='".$clients->CODESAGE."'></td>
															<td>	<input type='text' name='Nomrappel' readonly='true' value='".$clients->NOM."'>	</td>
										<td>	<input type='date' name='Daterappel' readonly='true' value='".$this->AfficheDate($clients->DATE)."'>	</td>
												$RadioRegulier
												<td>	<input type=checkbox name='Inactifrappel' value='0'>	</td>
												
												<td> 	<input type='submit' name='RappelDIntervCE' id='RappelDIntervCE' value=\"Voir l'intervention\" > </td>
												</tr>
												<input type='hidden' name='Daterappel1' value='$dateRa1'>
												<input type='hidden' name='Daterappel2' value='$dateRa2'>
												<input type='hidden' name='Emplrappel' value='$clients->NUMEMPLSAGE'>
												<input type='hidden' name='RappelDInterv' value='".$clients->NINTERV."'>
												</form>";
					}
				}
				$resultat->closeCursor ();
				$vretour = $vretour."</table></td></tr></table></center>"; // /!\ TEMPORAIRE NE SERA PLUS LA LORSQUE QUE LA BARRE DE NAVIGATION SERA EN PLACE (sans la barre un seul tableau suffit)
				/*$vretour = $vretour."</table>
										</td>
				        				</tr>".$this->navigateur($nblignes,$debut,$limite,$lien)."</table>
				        					</center><br><nav><ul id='navigation' class='nav-main'></ul></nav>";
				*/
				$vretour = $vretour."<ul id='navigation' class='nav-main'><br><input type='button' value='Retour' onClick=\"javascript:document.location.href='Clients.php'\"/><br> <br></ul>";
			}
		}
		return $vretour;
	}
	
	

	
	
	
	
	public function Atouslesclients()
	{
		$lien = "TousClients.php"; //Pour que les chiffres et les fleches ajouter renvoi é la bonne page.
		$limite = 25; // Limit sert é définir le nombre de tuples é afficher.
		if(isset($_GET['debut'])){
			$debut = $_GET['debut'];
		}
		else if (empty($debut))
		{
			$debut=0;					// L'offset sert é définir le point de départ.
		}		
	
		$vretour="		
				<ul id='navigation' class='nav-main'><br>
				<h3> Liste de tous les clients : </h3>
				<center>
				<nav>
				<table id='Tabcontientclientspage' >
					<tr>
						<td>						
      					<table id='Tabclientspage' >
								<tr>
									<th id='thcodesage'>CodeSage</th>
									<th id='thnomc'>Nom</th>									
									<th id='thadressec'>Adresse</th>
									<th id='thcomplement'>Complement</th>
									<th id='thcodepostal'>Code Postal</th>
									<th id='thcommune'>Commune</th>
									<th id='thtelephone'>Telephone</th>
									<th id='thdetails'>Détails</th>
									<th id='thage'>Age </th>
									<th id='thregularite'>Regularite</th>
									<th id='thinactif'>Inactif</th>
								</tr>";
		$reqcpt = 'SELECT COUNT(*) AS nb FROM clients;';
		$result = $this->connexion->query($reqcpt);
		//$nblignes = $result->fetch(PDO::FETCH_OBJ )->nb;
		$nbtotal = $result->fetch(PDO::FETCH_OBJ )->nb;
		$nbenr = 0;
		$cfg_nbres_ppage = 25; // Nombre de réponses par page
		$cfg_nb_pages    = 10; // Nombre de Né de pages affichés dans la barre
		if($nbtotal > 0)
		//if($nblignes > 0)
		{
			$requete = 'SELECT * FROM clients ORDER BY `NOM` ASC LIMIT '.$limite.' OFFSET '.$debut.' ;';
			$resultat = $this->connexion->query($requete);
			while($clients = $resultat->fetch(PDO::FETCH_OBJ))
			{
				$vretour = $vretour."<tr> 
									<td>".utf8_encode ($clients->CODESAGE)."</td>
									<td>".utf8_encode ($clients->NOM)."</td>									
									<td>".utf8_encode ($clients->ADRESSE)."</td>
									<td>".utf8_encode ($clients->COMPLEMENT)."</td>
									<td>".utf8_encode ($clients->CODEPOSTAL)."</td>
									<td>".utf8_encode ($clients->COMMUNE)."</td>
									<td>".utf8_encode ($this->Affichetelephone($clients->TELEPHONE))."</td>
									<td>".utf8_encode ($clients->DETAILS)."</td>";
				if($clients->AGE==0)
				{
					$vretour=$vretour."<td> - 70 ans </td>";
				}
				else if($clients->AGE==1)
				{
					$vretour=$vretour."<td> + 70 ans </td>";
				}
				if($clients->REGULARITE==2)
				{ // Pour non value =2
					$vretour=$vretour."<td> Non </td>";
				}
				else if($clients->REGULARITE==1)
				{  //Pour oui value = 1
					$vretour=$vretour."<td> Oui </td>";
				}
				else if($clients->REGULARITE==0)
				{ //Pour inconnu value = 0
					$vretour=$vretour."<td> Inconnu </td>";
				}
				if($clients->inactif==1)
				{
					$vretour=$vretour."<td> Oui </td>";
				}
				else
				{
					$vretour=$vretour."<td> Non </td>";
				}
				$vretour=$vretour."</tr>";
				$nbenr = $nbenr + 1;
			}
			$resultat->closeCursor ();
			$vretour = $vretour."</table></td></tr><tr><td>".$this->barre_navigation($nbtotal, $nbenr, $cfg_nbres_ppage, $debut, $cfg_nb_pages)."</td></tr></table>";
			/*$vretour = $vretour."</table>
			         			</td>
								
			        			</tr><tr>".$this->navigateur($nblignes,$debut,$limite,$lien)."</tr></table>";
			*/
			// Puis insertion d'un formulaire pour pouvoir réaliser l'export via un clic bouton.
			
			$vretour = $vretour."<br><form name='ExcelClients' id='ExcelClients' method='POST' action='ExcelClients.php'><input type='submit' id='ExcelClients' name='ExcelClients' value ='Generer Excel'></form><br></nav></ul>";
			if (isset($_POST['ExcelClients'])){
				$this->AfficheExcelClients();
			}
		}
		else
		{
			$vretour = $vretour."Aucun client, désolé !";
		}
		
		$vretour= $vretour."<ul id='navigation' class='nav-main'><br><input type='button' value='Retour' onClick=\"javascript:document.location.href='ModifierClients.php'\"/><br> <br></ul>";
		return $vretour;
	}
	
	public function AfficheExcelClients(){
		$vretourExcel = "";
		$NOM = "Clients";
		$Date = date('Y-m-d');		
		header("Content-type: application/msexcel; charset=UTF-8");
		header ("Content-Disposition: attachment; filename=$NOM-$Date.xls");
		//$vretour= $_SESSION['htmlClients'];
		// Pour pouvoir exporter tous les clients dans un fichier excel. (xls) on met tous le contenu dans une variable de session.
		$requeteExcel = 'SELECT * FROM clients ;';
		$resultatExcel = $this->connexion->query($requeteExcel);
		$vretourExcel = "<ul id='navigation' class='nav-main'><br><center><table>
								<tr>
									<th>CodeSage</th>
									<th>Nom</th>
									<th>Abrege</th>
									<th>Adresse</th>
									<th>Complement</th>
									<th>CodePostal</th>
									<th>Commune</th>
									<th>Telephone</th>
									<th>Détails</th>
									<th>Age </th>
									<th>Regularite</th>
									<th>Inactif</th>
								</tr>";
		while($clientsExcel = $resultatExcel->fetch(PDO::FETCH_OBJ))
		{
			$vretourExcel = $vretourExcel."<tr>
											<td>".$clientsExcel->CODESAGE."</td>
											<td>".$clientsExcel->NOM."</td>
											<td>".$clientsExcel->ABREGE."</td>
											<td>".$clientsExcel->ADRESSE."</td>
											<td>".$clientsExcel->COMPLEMENT."</td>
											<td>".$clientsExcel->CODEPOSTAL."</td>
											<td>".$clientsExcel->COMMUNE."</td>
											<td>".$this->Affichetelephone($clientsExcel->TELEPHONE)."</td>
											<td>".$clientsExcel->DETAILS."</td>";
			if($clientsExcel->AGE==0)
			{
				$vretourExcel=$vretourExcel."<td> - 70 ans </td>";
			}
			else if($clientsExcel->AGE==1)
			{
				$vretourExcel=$vretourExcel."<td> + 70 ans </td>";
			}
			if($clientsExcel->REGULARITE==2)
			{ // Pour non value =2
				$vretourExcel=$vretourExcel."<td> Non </td>";
			}
			else if($clientsExcel->REGULARITE==1)
			{  //Pour oui value = 1
				$vretourExcel=$vretourExcel."<td> Oui </td>";
			}
			else if($clientsExcel->REGULARITE==0)
			{ //Pour inconnu value = 0
				$vretourExcel=$vretourExcel."<td> Inconnu </td>";
			}
			if($clientsExcel->inactif==1)
			{
				$vretourExcel=$vretourExcel."<td> Oui </td>";
			}
			else
			{
				$vretourExcel=$vretourExcel."<td> Non </td>";
			}
			$vretourExcel = $vretourExcel."</tr>";
		}
		$resultatExcel->closeCursor ();
		$vretourExcel = $vretourExcel."</table></center></ul>";
		
		return $vretourExcel;
	}

	// ------------------------------------------------------------------------
	// image_html
	// ------------------------------------------------------------------------
	function image_html($img, $align = "middle")
	{
		$taille = @getimagesize($img);
		return '<IMG SRC="'.$img.'" '.$taille[3].' BORDER=0 ALIGN="'.$align.'">';
	}
	
	
	// ------------------------------------------------------------------------
	// barre_navigation
	// ------------------------------------------------------------------------
	
	function barre_navigation($nbtotal,$nbenr,$cfg_nbres_ppage,$debut, $cfg_nb_pages)
	{
		//   RECUPERATION DES VARIABLES GET    //
		$barre ='';
		$debut = isset($_GET['debut']) ? (int)$_GET['debut'] : 0;
		if($debut < 0)
			exit;
		// --------------------------------------------------------------------
		//global $cfg_nb_pages; // Nb de né de pages affichées dans la barre
	
		$lien_on         = ' <A HREF="{cible}">{lien}</A> ';
		$lien_off        = ' {lien} ';
		// --------------------------------------------------------------------
	
		$query  = 'TousClients.php?debut=';
	
	
		// début << .
		// --------------------------------------------------------------------
		if ($debut >= $cfg_nbres_ppage)
		{
			$cible = $query.(0);
			$image = $this->image_html('STYLES/suitegauche.gif');
			$lien = str_replace('{lien}', $image.$image, $lien_on);
			$lien = str_replace('{cible}', $cible, $lien);
		}
		else
		{
			$image = $this->image_html('STYLES/suitegauche.gif');
			$lien = str_replace('{lien}', $image.$image, $lien_off);
		}
		$barre .= $lien." <B><font color = foe3ae>é</B>";
	
	
		// précédent < .
		// --------------------------------------------------------------------
		if ($debut >= $cfg_nbres_ppage)
		{
			$cible = $query.($debut-$cfg_nbres_ppage);
			$image = $this->image_html('STYLES/suitegauche.gif');
			$lien = str_replace('{lien}', $image, $lien_on);
			$lien = str_replace('{cible}', $cible, $lien);
		}
		else
		{
			$image = $this->image_html('STYLES/suitegauche.gif');
			$lien = str_replace('{lien}', $image, $lien_off);
		}
		$barre .= $lien." <B>é</B>";
	
	
		// -------------------------------------------------------------------
	
		if ($debut >= ($cfg_nb_pages * $cfg_nbres_ppage))
		{
			$cpt_fin = ($debut / $cfg_nbres_ppage) + 1;
			$cpt_deb = $cpt_fin - $cfg_nb_pages + 1;
		}
		else
		{
			$cpt_deb = 1;
	
			$cpt_fin = (int)($nbtotal / $cfg_nbres_ppage);
			if (($nbtotal % $cfg_nbres_ppage) != 0) $cpt_fin++;
	
			if ($cpt_fin > $cfg_nb_pages) $cpt_fin = $cfg_nb_pages;
		}
	
		for ($cpt = $cpt_deb; $cpt <= $cpt_fin; $cpt++)
		{
			if ($cpt == ($debut / $cfg_nbres_ppage) + 1)
			{
				$barre .= "<A CLASS='off'> ".$cpt." </A> ";
        	}
	        else
	        {
	        	$barre .= "<A CLASS='on' HREF='".$query.(($cpt-1)*$cfg_nbres_ppage)."'>".$cpt."</A>  ";
	        }
    	}
	
	
	    // suivant . >
	    // --------------------------------------------------------------------
	    if ($debut + $cfg_nbres_ppage < $nbtotal)
	    {
	    $cible = $query.($debut+$cfg_nbres_ppage);
	    $image = $this->image_html('STYLES/suitedroite.gif');
	    $lien = str_replace('{lien}', $image, $lien_on);
	    $lien = str_replace('{cible}', $cible, $lien);
	    }
	    else
	    {
	    $image = $this->image_html('STYLES/suitedroite.gif');
	    	$lien = str_replace('{lien}', $image, $lien_off);
	    }
	    $barre .= " <B>é</B>".$lien;
	
	    // fin . >>
	    // --------------------------------------------------------------------
	    $fin = ($nbtotal - ($nbtotal % $cfg_nbres_ppage));
	    if (($nbtotal % $cfg_nbres_ppage) == 0){ $fin = $fin - $cfg_nbres_ppage;}
	
	    if ($fin != $debut)
	    {
	    $cible = $query.$fin;
	    $image = $this->image_html('STYLES/suitedroite.gif');
	    $lien = str_replace('{lien}', $image.$image, $lien_on);
	    $lien = str_replace('{cible}', $cible, $lien);
	    }
	    else
	    {
	    $image = $this->image_html('STYLES/suitedroite.gif');
	    $lien = str_replace('{lien}', $image.$image, $lien_off);
	    }
	    $barre .= "<B>é</B> ".$lien;
	
	
	
	
	    // Voila, c'est ici que l'on retourne la barre
	    // --------------------------------------------------------------------
	
	    return($barre);
	
	    // -------------------- FIN FONCTION ------------------------------
	}	

	
	
	function navigateur($nblignes,$debut,$limite,$lienpage) { //  Affichage du navigateur en bas de page //REMPLACER FINALEMENT PAR CELLE D'AU DESSUS
		$vretour = "<center>";
		// Calcule le nombre devant posseder un lien d'accés
		$pages=intval($nblignes/$limite); // % Donne le reste de la division entiére entre les 2 nombres
	
		// $pages contient la partie entiére du résultat de la division...
		// ...s'il y a un reste on ajoute une page
		if ($nblignes%$limite)
		{
			$pages = $pages + 1;
		}
	
		if ($pages > 1)
		{
			$vretour = $vretour."<tr><td>";
	        // Creation des liens vers les pages virtuelles contenant les autres resultats
	       if ($debut>=$limite)
	       { // On ne cree pas de lien "PRECEDENT" si debut vaut 0
	            $precdebut=$debut-$limite;
	            $vretour = $vretour."<A href=\"$lienpage?debut=$precdebut#num\">
	            <img id='suitegauche' src=\"STYLES/suitegauche.gif\" border=0></A>\n";
	        }
	
	        for ($i=1;$i<=$pages;$i++)
	        { // affichage des liens numerotes
	            $nouvdebut=$limite*($i-1);
	            if ($nouvdebut == $debut)
	            {  // numero sans lien
	                $vretour = $vretour."<b>$i</b>&nbsp;\n"; 
	            }
	            else
	            { // numero avec lien
	            	$vretour = $vretour. "<a id='num' href=\"$lienpage?debut=$nouvdebut#num\">$i</a>&nbsp;\n";
	            }
	           // action="'.$_SERVER['PHP_SELF'].'"
	        }
	
	        // verification si nous sommes a la derniere page
	        if ($debut!=$limite*($pages-1))
	        { 
	            // nous ne sommes pas a la derniere page donc il faut creer un lien "SUIVANT"
	            $nouvdebut = $debut+$limite; 
	            $vretour = $vretour."<A href=\"$lienpage?debut=$nouvdebut#num\">
	            <img id='suitedroite' src=\"STYLES/suitedroite.gif\" border=0></A>\n";
	        }
	        $vretour = $vretour."</td></tr></center>";
	    }
		return $vretour;
	}
	
}