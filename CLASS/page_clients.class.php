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
	
	public function les_employes()
	{
		$req = "Select * From employes";
		$res = $this->connexion->query($req);
		return $res;
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
								<label id='TableauClient'>Mobile :</label><center> <input type='text' class='validate[optionnal] text-input' id='Mobile' name='Mobile'  value=''></center><br /><br>
								<label id='TableauClient'>Mail :</label><center> <input type='text' class='validate[optionnal] text-input' id='Mail' name='Mail'  value=''></center><br /><br>
								<label id='TableauClient'>Commentaire :</label><center> <input type='text' class='validate[optionnal] text-input' id='Commentaire' name='Commentaire'  value=''></center><br /><br>
									
										
										
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
			$Mobile = $_POST['Mobile'];
			$Mail = $_POST['Mail'];
			$Commentaire = $_POST['Commentaire'];
			
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
			$requete = 'insert into clients values ("'.$CodeSage.'",UPPER("'.$NomClient.'"),"'.$Abrege.'",UPPER("'.$Adresse.'"),UPPER("'.$Complement.'"),"'.$CodePostal.'",UPPER("'.$Commune.'"),"' .$Telephone .'","'.$Details.'",'.$Age.','.$Regularite.','.$inactif.',"'.$Mobile.'","'.$Mail.'","'.$Commentaire.'");';
			echo $requete;
			$resultat = $this->connexion->query ( $requete );
			$retour = '<h4>CLIENT INSERER</h4>';	
			echo "<script> alert(' Insertion du client réussie '); </script>";	
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
			$Mobile = $_POST['Mobile'];
			$Mail = $_POST['Mail'];
			$Commentaire = $_POST['Commentaire'];
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
				$requete = 'update clients set CODESAGE="'.$CodeSage.'",NOM="'.$NomClient.'",ABREGE="'.$Abrege.'",ADRESSE="'.$Adresse.'",COMPLEMENT="'.$Complement.'",CODEPOSTAL="'.$CodePostal.'",COMMUNE="'.$Commune.'",TELEPHONE="' .$Telephone .'",DETAILS="'.$Details.'",AGE='.$Age.',REGULARITE='.$Regularite.',INACTIF='.$inactif.',NumMobile="'.$Mobile.'",Mail="'.$Mail.'",Commentaire="'.$Commentaire.'" WHERE CODESAGE="'.$CodeSage.'";';
				$resultat = $this->connexion->query ( $requete );
				$retour = '<script> alert(\" Modification du client réussie \"); </script>';
				echo "<script> alert('Modification du client réussie '); </script>";
			
	
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
	
	
	
	
	
	
	public function les_clients2($parametre,$id)
	{
		$vretour="";
		$req = "Select CODESAGE,NOM From clients order by NOM";
		$res = $this->connexion->query($req);
		// Si aucune sélection de liste n'a été demander avant, par défaut, au lancement de la page Interventions
		if (!empty ($_POST['CodeCI']))
		{
			$CodeCI = $_POST['CodeCI'];
			$req2 = "Select * From clients where CODESAGE = '$CodeCI'";
			$res2 = $this->connexion->query($req2);
	
			while ($donneesR = $res2->fetch(PDO::FETCH_OBJ)) {
				$NomC = utf8_decode($donneesR->NOM);
	
				$vretour = $vretour."<input type='hidden' name='NomC' value=$NomC>";
					
			}
		}
		if(isset($res)){
	
			if (!isset ($_POST['listeclients']) && !isset($_POST['listeclients2']))	{
				$vretour= $vretour."
				<select name='listeclients2' id='$id' class=\"validate[$parametre] \" Onchange=\"ValeurClientI()\"><option value=''></option>";
				while ($donnees = $res->fetch(PDO::FETCH_OBJ)) {
					$vretour= $vretour.'<option value=' . $donnees->CODESAGE . '>'. $donnees->CODESAGE .' - ' . $donnees->NOM . '</option>';
	
				}
				$vretour=$vretour."</select>";
				$vretour = $vretour."<input type='hidden' id='CodeCI' name='CodeCI' value=''>";
	
			}
			// Si un enregistrement é été effectuer juste avant.
			if (isset ($_POST['CodeC'])) {
	
				$CodeC = $_POST['CodeC'];
				$req2 = "Select * From clients where CODESAGE = '$CodeC'";
				$res2 = $this->connexion->query($req2);
				while ($donneesR = $res2->fetch(PDO::FETCH_OBJ)) {
					$NomC = utf8_decode($donneesR->NOM);
					$vretour = $vretour."<input type='hidden' name='NomC' value=$NomC>";
	
				}
	
				$vretour= $vretour."<select name='listeclients2' id='$id' class=\"validate[$parametre] \" Onchange=\"ValeurEmployeI()\"><option value=$CodeC>".$CodeC." - ".$NomC."</option><option value=''></option>";
				while ($donnees = $res->fetch(PDO::FETCH_OBJ))
				{
					$vretour= $vretour.'<option value=' . $donnees->CODESAGE . '>'. $donnees->CODESAGE .' - ' . utf8_decode($donnees->NOM) .'</option>';
				}
				$vretour = $vretour."</select><input type='hidden' id='CodeCI' name='CodeCI' value=$CodeC>";
			}
			// Si une selection é été effectuer juste avant
			if (isset ($_POST['NomClient']) && !empty ($_POST['NomClient'])){
				$NomC = $_POST['NomClient'];
				$req2 = "Select * From clients where Nom = '$NomC'";
				$res2 = $this->connexion->query($req2);
				while ($donneesR = $res2->fetch(PDO::FETCH_OBJ)) {
					$CodeC = utf8_decode($donneesR->CODESAGE);
	
					$vretour = $vretour."<input type='hidden' name='NomC' value=$NomC>";
				}
					
				$vretour= $vretour."<select name='listeclients2' id='$id' class=\"validate[$parametre] \" Onchange=\"ValeurClientI()\"><option value='$CodeC'>".$CodeC." - ".$NomC."</option><option value=''></option>";
				while ($donnees = $res->fetch(PDO::FETCH_OBJ))
				{
					$vretour= $vretour.'<option value=' . $donnees->CODESAGE . '>'. $donnees->CODESAGE .' - ' . utf8_decode($donnees->NOM) .'</option>';
				}
				$vretour = $vretour."</select><input type='hidden' id='CodeC' name='CodeCI' value='$CodeC'>";
			}
			$res->closeCursor ();
	
	
	
		}
	
		return $vretour;
	}
	
	
	public function les_employes2($parametre,$id)
	{
		$vretour='';
		$req = "Select EmplSage,Nom,Prenom From employes where ANCIEN_EMPLOYE='0'";
		$res = $this->connexion->query($req);
		if (!empty ($_POST['CodeEI']))
		{
			$CodeEI = $_POST['CodeEI'];
				
			$req2 = "Select * From employes where EmplSage = '$CodeEI'";
			$res2 = $this->connexion->query($req2);
	
			while ($donneesR = $res2->fetch(PDO::FETCH_OBJ)) {
				$NomE = utf8_decode($donneesR->Nom);
				$PrenomE = utf8_decode($donneesR->Prenom);
				$vretour = $vretour."<input type='hidden' name='NomE' value=$NomE>";
				$vretour = $vretour."<input type='hidden' name='PrenomE' value=$PrenomE>";
			}
		}
		if(isset($res)){
			if (!isset ($_POST['listeemployes']) && !isset($_POST['listeemployes2']))	{
				$vretour= $vretour."<select name='listeemployes2' id='$id' class=\"validate[$parametre] \" Onchange=\"ValeurEmployeI()\"><option value=''></option><option value=''></option>";
				while ($donnees = $res->fetch(PDO::FETCH_OBJ))
				{
					$vretour= $vretour.'<option value=' . $donnees->EmplSage . '>'. $donnees->EmplSage .' - ' . utf8_decode($donnees->Nom) .' - ' . utf8_decode($donnees->Prenom) .  '</option>';
				}
				$vretour=$vretour."</select><input type='hidden' id='CodeEI' name='CodeEI' value=''>";
	
			}
			if (isset ($_POST['CodeE'])) {
	
				$CodeE = $_POST['CodeE'];
				$req2 = "Select * From employes where EmplSage = '$CodeE'";
				$res2 = $this->connexion->query($req2);
				while ($donneesR = $res2->fetch(PDO::FETCH_OBJ)) {
					$NomE = utf8_decode($donneesR->Nom);
					$PrenomE = utf8_decode($donneesR->Prenom);
					$vretour = $vretour."<input type='hidden' name='NomE' value=$NomE>";
					$vretour = $vretour."<input type='hidden' name='PrenomE' value=$PrenomE>";
				}
	
				$vretour= $vretour."<select name='listeemployes2' id='$id' class=\"validate[$parametre] \" Onchange=\"ValeurEmployeI()\"><option value=$CodeE>".$CodeE." - ".$NomE." - ".$PrenomE."</option><option value=''></option>";
				while ($donnees = $res->fetch(PDO::FETCH_OBJ))
				{
					$vretour= $vretour.'<option value=' . $donnees->EmplSage . '>'. $donnees->EmplSage .' - ' . utf8_decode($donnees->Nom) .' - ' . utf8_decode($donnees->Prenom) .  '</option>';
				}
				$vretour = $vretour."</select><input type='hidden' id='CodeEI' name='CodeEI' value=$CodeE>";
			}
	
			if (isset ($_POST['NomEmp']) && !empty ($_POST['NomEmp'])){
				$NomE = $_POST['NomEmp'];
				$req2 = "Select * From employes where Nom = '$NomE'";
				$res2 = $this->connexion->query($req2);
				while ($donneesR = $res2->fetch(PDO::FETCH_OBJ)) {
					$CodeE = utf8_decode($donneesR->EmplSage);
					$PrenomE = utf8_decode($donneesR->Prenom);
					$vretour = $vretour."<input type='hidden' name='NomE' value=$NomE><input type='hidden' name='PrenomE' value=$PrenomE>";
				}
	
				$vretour= $vretour."<select name='listeemployes2' id='$id' class=\"validate[$parametre] \" Onchange=\"ValeurEmployeI()\"><option value=$CodeE>".$CodeE." - ".$NomE." - ".$PrenomE."</option><option value=''></option>";
				while ($donnees = $res->fetch(PDO::FETCH_OBJ))
				{
					$vretour= $vretour.'<option value=' . $donnees->EmplSage . '>'. $donnees->EmplSage .' - ' . utf8_decode($donnees->Nom) .' - ' . utf8_decode($donnees->Prenom) .  '</option>';
				}
				$vretour = $vretour."</select><input type='hidden' id='CodeE' name='CodeEI' value=$CodeE>";
			}
	
		}	$res->closeCursor ();
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
				
			$vretour= $vretour."<center><li><label>Liste par ordre alphabétique :</label><select name='listeclients1' id='listeclients1' ><option value='VIDE'> </option>";
				while ($donnees = $result->fetch(PDO::FETCH_OBJ)) {					
					$vretour= $vretour.'<option value=' . $donnees->CODESAGE . '>'. $donnees->CODESAGE .' - ' . $donnees->NOM . '</option>';
					$tabCodeSage[] = $donnees->CODESAGE;
				}
				$result->closeCursor ();
				
				
				
			
				
				$vretour = $vretour."</select></li></center>
						<label>Afficher d'abord la fiche client </label><input type='submit' name='afficherC' id='afficherC' value='Afficher' >
						<input type='submit' name='modifierC' id='modifierC' value='Modifier'>
					
						" ;			
		}
		
		
	
		
		$vretour= $vretour."</form><br>

		<form id='formlist' method='POST' action='ListeInterventions1.php' >";
		
		if (isset ($_POST['DateD']) && isset ($_POST['DateF'])){
			$DateD = $_POST['DateD'];
			$DateF = $_POST['DateF'];
				
		}
		Else {
			$DateD = $this->AfficheDate(date('Y-m-d'));
			$DateF = $this->AfficheDate(date('Y-m-d'));
		}
		
		$vretour= $vretour."
		<label> Recherche d'interventions du </label>	
		<input  type='text'  name='DateD' id='DateD'  value='$DateD' class='validate[optionnal] text-input datepicker'/> 
		<label> au </label>	
		<input  type='text'  name='DateF' id='DateF'  value='$DateF' class='validate[optionnal] text-input datepicker'/> 
		<input type='submit' name='Rechecher' id='Rechecher' value='Rechercher' >";
				
		
			
		if(isset($_POST['listeclients1']))
		{	$CodeC = $_POST['listeclients1'];	
		}
		else
			$CodeC = "";
		
		
		$vretour= $vretour."<input type='hidden' name='CodeC' value=".$CodeC.">";
		
		
		$vretour= $vretour."
		
		
		<br><br></ul></form>";
		
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
		if((isset($_POST['afficherC']))||(isset($_POST['CodeSageClientCache']))||(isset($_POST['modifierC']))||(isset($_POST['CodeSageClientM'])))
		{		$vretour= $vretour."<ul id='navigation' class='nav-main'><br><input type='button' value='Retour' onClick=\"javascript:document.location.href='ModifierClients.php'\"/><br> <br></ul>";
			
		}
		else 
		{
		$vretour= $vretour."<ul id='navigation' class='nav-main'><br><input type='button' value='Retour' onClick=\"javascript:document.location.href='Clients.php'\"/><br> <br></ul>";
		}
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
											</script>
			
			
					
					";
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
	
	public function PeriodeClients ()
	{
		$result = $this->les_employes();
		$vretour = '';
		$daterecu =  $this->AfficheDate(date('Y-m-d'));
		 $daterecu2 = $this->AfficheDate(date('Y-m-d'));
		 if( !isset($_POST['Periodeclient']))
		 {
		$vretour="
		 	<ul id='navigation' class='nav-main'><br>
		 	<form method='POST' id='Periodeclient' action='periodeclients.php' >
		 	Afficher les clients qui ont eu des interventions au plus <input type='number' name='nbfois' id='nbfois' value='2'> fois entre le mois de
		 	<select name='Date1' id='Date1' required>
										<option value=''></option>
										<option value='01|Janvier'>Janvier</option>
										<option value='02|Février'>Février</option>
										<option value='03|Mars'>Mars</option>
										<option value='04|Avril'>Avril</option>
										<option value='05|Mai'>Mai</option>
										<option value='06|Juin'>Juin</option>
										<option value='07|Juillet'>Juillet</option>
										<option value='08|Aout'>Aout</option>
										<option value='09|Septembre'>Septembre</option>
										<option value='10|Octobre'>Octobre</option>
										<option value='11|Novembre'>Novembre</option>
										<option value='12|Décembre'>Décembre</option>
									</select>
		 	et 		 	<select name='Date2' id='Date2' required>
										<option value=''></option>
										<option value='01|Janvier'>Janvier</option>
										<option value='02|Février'>Février</option>
										<option value='03|Mars'>Mars</option>
										<option value='04|Avril'>Avril</option>
										<option value='05|Mai'>Mai</option>
										<option value='06|Juin'>Juin</option>
										<option value='07|Juillet'>Juillet</option>
										<option value='08|Aout'>Aout</option>
										<option value='09|Septembre'>Septembre</option>
										<option value='10|Octobre'>Octobre</option>
										<option value='11|Novembre'>Novembre</option>
										<option value='12|Décembre'>Décembre</option>
									</select>
				<input type='hidden' name='datetext2' id='datetext2' value='' />";
		 	$vretour .= "<br><br><br><input type='submit' name='Periodeclient' value='OK'> </form></label>	</center><br>		</ul>";		
		 	$vretour= $vretour."<ul id='navigation' class='nav-main'><br><input type='button' value='Retour' onClick=\"javascript:document.location.href='Clients.php'\"/><br> <br></ul>";
		 	
		 }
		 else 
		 {
		 	$date1 = explode('|', $_POST['Date1']);
		 	$date2 = explode('|', $_POST['Date2']);
		 	$nbfois = $_POST['nbfois'];
		 	$color = "grey";
		 	$codesage = "1";
		$vretour="
		 	<ul id='navigation' class='nav-main'><br>
		 	<form method='POST' id='Periodeclient' action='periodeclients.php' >
		 			 	Afficher les clients qui ont eu des interventions au plus <input type='number' name='nbfois' id='nbfois' value='$nbfois'> fois entre le mois de
		 	<select name='Date1' id='Date1' OnSelect=\"document.getElementById('datetext1').value=this.options[this.selectedIndex].text\" required>
										<option value='$date1[0]|$date1[1]'>$date1[1]</option>
										<option value=''></option>
										<option value='01|Janvier'>Janvier</option>
										<option value='02|Février'>Février</option>
										<option value='03|Mars'>Mars</option>
										<option value='04|Avril'>Avril</option>
										<option value='05|Mai'>Mai</option>
										<option value='06|Juin'>Juin</option>
										<option value='07|Juillet'>Juillet</option>
										<option value='08|Aout'>Aout</option>
										<option value='09|Septembre'>Septembre</option>
										<option value='10|Octobre'>Octobre</option>
										<option value='11|Novembre'>Novembre</option>
										<option value='12|Décembre'>Décembre</option>
									</select>
		 	et 		 	<select name='Date2' id='Date2' required>
										<option value='$date2[0]|$date2[1]'>$date2[1]</option>
										<option value=''></option>
										<option value='01|Janvier'>Janvier</option>
										<option value='02|Février'>Février</option>
										<option value='03|Mars'>Mars</option>
										<option value='04|Avril'>Avril</option>
										<option value='05|Mai'>Mai</option>
										<option value='06|Juin'>Juin</option>
										<option value='07|Juillet'>Juillet</option>
										<option value='08|Aout'>Aout</option>
										<option value='09|Septembre'>Septembre</option>
										<option value='10|Octobre'>Octobre</option>
										<option value='11|Novembre'>Novembre</option>
										<option value='12|Décembre'>Décembre</option>
									</select>
		";
		 	$vretour .= "<br><br><br><input type='submit' name='Periodeclient' value='OK'> </form></label>	</center><br>		</ul>";		
		 	$vretour .= "<ul id='navigation' class='nav-main'><br>";
		 	$vretour .=	"<center><table border='1'><tr><th>CodeSage</th><th>Nom Client</th><th>Date</th><th>Nom intervenant</th></tr>";
		 	$requete ="SELECT C.CODESAGE,C.NOM AS NOMC,I.DATE,E.NOM AS NOME
					  FROM interventions as I INNER JOIN clients as C on codesage = clientsage INNER JOIN employes as E on EmplSage = NUMEMPLSAGE 
					  WHERE MONTH(DATE) BETWEEN '$date1[0]' AND '$date2[0]' 
					  AND C.CODESAGE IN 
		 			 (SELECT C.CODESAGE FROM interventions as I INNER JOIN clients as C on codesage = clientsage INNER JOIN employes as E on EmplSage = NUMEMPLSAGE WHERE MONTH(DATE) BETWEEN '$date1[0]' AND '$date2[0]' GROUP BY `CLIENTSAGE` HAVING COUNT(CODESAGE)<='$nbfois' ORDER BY COUNT(CODESAGE) ASC) ORDER BY `C`.`NOM` ASC";
		 	$result=$this->connexion->query($requete);
		 	while($donnees = $result->fetch(PDO::FETCH_OBJ))
		 			{
						if($codesage != $donnees->CODESAGE)
		 				{
		 					if ($color = "grey")
		 					{
		 					$color = "white";
		 					}
		 				}
		 				if($codesage != $donnees->CODESAGE)
		 				{
		 					if ($color = "white")
		 					{
		 					$color = "grey";
		 					}
		 				}
		 				$codesage = $donnees->CODESAGE;
		 				$Date = $donnees->DATE;
		 				$datefr = date("d-m-Y", strtotime($Date));
		 				$vretour .= "<tr><td>$donnees->CODESAGE</td><td>$donnees->NOMC</td><td>$datefr</td><td>$donnees->NOME</td></tr>";
		 			}
		 			$vretour .="</table></ul>";
					$vretour= $vretour."<ul id='navigation' class='nav-main'><br><input type='button' value='Retour' onClick=\"javascript:document.location.href='Clients.php'\"/><br> <br></ul>";
		 					 			
		 }
		return $vretour;
	}
	
	public function Rappelclients(){

		$result = $this->les_employes();
		$vretour = '';
		if( isset($_POST['ValidFormRappelclient'])) // Lorsqu'on a choisi une date.
		{
			$daterecu1 = $_POST['DateEnvoiRappel1'];
			$daterecu2 = $_POST['DateEnvoiRappel2'];
			$vretour="
			<ul id='navigation' class='nav-main'><br>
			<form method='POST' id='Formrappelclient' action='RappelClients.php' >
			<label> Veuillez choisir une date pour afficher les clients qui n'ont pas commandé depuis cette dernière :</label>
			<br><input type='text' class='validate[required] text-input datepicker' name='DateEnvoiRappel1' id='DateEnvoiRappel1' value='$daterecu1'>
			<br>Ajouter l'intervale jusqu'au :<input type='text' class=' text-input datepicker' name='DateEnvoiRappel2' id='DateEnvoiRappel2' value='$daterecu2'><INPUT type='checkbox' name='choix1' value='1'> 
			<INPUT type='checkbox' name='choix1' value='1'> 
			<input type='submit' name='ValidFormRappelclient' value='OK'>
			</form>
			<br>
			</ul>";
			

			$daterecu =  $this->AfficheDate(date('Y-m-d'));
			$vretour="
			<ul id='navigation' class='nav-main'><br>
					<form method='POST' id='Formrappelclient' action='RappelClients.php' >
					<input type='radio' name='datedet' id='datedet' value='avantcom' required> 
					<label>Afficher les clients qui n'ont pas commandé depuis le : 
					<input type='text' class='validate[required] text-input datepicker' name='DateEnvoiRappel1' id='DateEnvoiRappel1' value='$daterecu'>
					
					<br><input type='radio' name='datedet' id='datedet' value='intercom' required>
					Afficher les clients qui ont commandé la dernière fois entre le  :<input type='text' class='validate[required] text-input datepicker' name='DateEnvoiRappel2' id='DateEnvoiRappel2' value='$daterecu2'>
					 et le <input type='text' class=' text-input datepicker' name='DateEnvoiRappel3' id='DateEnvoiRappel3' value='$daterecu2'>
					<br> <center> Sélectionner un employé : <select name='listeemployes' id='listeemployes' style='width:300px;'><option value='VIDE'></option>";
		while ($donnees = $result->fetch(PDO::FETCH_OBJ)) {
			if($donnees->ANCIEN_EMPLOYE == 0)
			{
				$vretour= $vretour.'<option value=' . $donnees->EmplSage. '>'. $donnees->Nom .' - ' . $donnees->Prenom. '</option>';
			}
		}
		$result->closeCursor ();
		$tabCodeSage = array();
		$req = 'SELECT CODESAGE,NOM FROM Clients ORDER BY `NOM` ASC ;';
		$result = $this->connexion->query($req);
		$vretour .= "</select>";
		$vretour= $vretour."<center><li><label>Sélectionner un client : </label><select name='listeclients1' id='listeclients1' style='width:300px;'><option value='VIDE'> </option>";
		while ($donnees = $result->fetch(PDO::FETCH_OBJ)) {
			$vretour= $vretour.'<option value=' . $donnees->CODESAGE . '>'. $donnees->CODESAGE .' - ' . $donnees->NOM . '</option>';
			//array_push($tabCodeSage,$donnees->CODESAGE); // pour empiler les codesages a la fin du tableau.
			$tabCodeSage[] = $donnees->CODESAGE;
		}
		$result->closeCursor ();
		$vretour .= "<br><br><br><input type='submit' name='ValidFormRappelclient' value='OK'> </form></label>	</center><br>
				
					</ul>";		
		$vretour= $vretour."<ul id='navigation' class='nav-main'><br><input type='button' value='Retour' onClick=\"javascript:document.location.href='Clients.php'\"/><br> <br></ul>";
		
			$vretour = $vretour.$this->afficheclientsrappel($daterecu1,$daterecu2);
				
				
		}
		else if (isset( $_POST['ClientsrappelValid'])) // Lorsqu'on modifie un client.
		{
			
			$daterecu1 = $_POST['Daterappel1'];
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
			<label> Veuillez choisir une date pour afficher les clients qui n'ont pas commandé depuis cette dernière :</label>
			<input type='text' class='validate[required] text-input datepicker' name='DateEnvoiRappel1' id='DateEnvoiRappel1' value='$daterecu1'>
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
		$daterecu2 = $this->AfficheDate(date('Y-m-d'));
		$vretour="
			<ul id='navigation' class='nav-main'><br>
					<form method='POST' id='Formrappelclient' action='RappelClients.php' >
					<input type='radio' name='datedet' id='datedet' value='avantcom' required/> 
					<label>Afficher les clients qui n'ont pas commandé depuis le : </label>
					<input type='text' class='validate[required] text-input datepicker' name='DateEnvoiRappel1' id='DateEnvoiRappel1' value='$daterecu'/>
					
					<br><input type='radio' name='datedet' id='datedet' value='intercom' required>
					Afficher les clients qui ont commandé la dernière fois entre le  :<input type='text' class='validate[required] text-input datepicker' name='DateEnvoiRappel2' id='DateEnvoiRappel2' value='$daterecu2'>
					 et le <input type='text' class=' text-input datepicker' name='DateEnvoiRappel3' id='DateEnvoiRappel3' value='$daterecu2'>
					<br> <center> Sélectionner un employé : <select name='listeemployes' id='listeemployes' style='width:300px;'><option value='VIDE'></option>";
		while ($donnees = $result->fetch(PDO::FETCH_OBJ)) {
			if($donnees->ANCIEN_EMPLOYE == 0)
			{
				$vretour= $vretour.'<option value=' . $donnees->EmplSage. '>'. $donnees->Nom .' - ' . $donnees->Prenom. '</option>';
			}
		}
		$result->closeCursor ();
		$tabCodeSage = array();
		$req = 'SELECT CODESAGE,NOM FROM Clients ORDER BY `NOM` ASC ;';
		$result = $this->connexion->query($req);
		$vretour .= "</select>";
		$vretour= $vretour."<center><li><label>Sélectionner un client : </label><select name='listeclients1' id='listeclients1' style='width:300px;' ><option value='VIDE'> </option>";
		while ($donnees = $result->fetch(PDO::FETCH_OBJ)) {
			$vretour= $vretour.'<option value=' . $donnees->CODESAGE . '>'. $donnees->CODESAGE .' - ' . $donnees->NOM . '</option>';
			//array_push($tabCodeSage,$donnees->CODESAGE); // pour empiler les codesages a la fin du tableau.
			$tabCodeSage[] = $donnees->CODESAGE;
		}
		$result->closeCursor ();
		$vretour .= "<br><br><br><input type='submit' name='ValidFormRappelclient' value='OK'> </form></label>	</center><br>
				
					</ul>";		
		$vretour= $vretour."<ul id='navigation' class='nav-main'><br><input type='button' value='Retour' onClick=\"javascript:document.location.href='Clients.php'\"/><br> <br></ul>";
		
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
		$datePourMysql2 =  $this->envoiMysqlDate($dateRa2);
		$datePourMysql3 =  $this->envoiMysqlDate($_POST['DateEnvoiRappel3']);
		$dateinter1 = $_POST['DateEnvoiRappel2'];
		$dateinter2 = $_POST['DateEnvoiRappel3'];
		$nblignes = 2 ; // /!\ TEMPORAIRE NE SERA PLUS LA LORSQUE QUE LA BARRE DE NAVIGATION SERA EN PLACE
		$vretour= "<ul id='navigation' class='nav-main'>";
		if($nblignes > 0)
		{		
			$client = $_POST['listeclients1'];
			$employe = $_POST['listeemployes'];
					if ($client != 'VIDE' && $employe != 'VIDE' && $_POST['datedet'] == 'avantcom') //Si un client ET un employé ont été séléctionner alors on utilise cette requete
			{
			$req = "SELECT C.CODESAGE,MAX(DATE) as DATE2,C.NOM AS NOMC,C.REGULARITE,I.NINTERV,I.NUMEMPLSAGE,I.DATE, E.NOM AS NOME
					FROM interventions as I 
					INNER JOIN `clients` as C on clientsage = codesage 
					INNER JOIN employes as E on NUMEMPLSAGE = EmplSage 
					WHERE CODESAGE = '$client' 
					AND emplsage = '$employe' 
					group by `CLIENTSAGE`
                    HAVING date < '$datePourMysql1' 
					ORDER BY DATE2 DESC";
			}
			elseif($client != 'VIDE' && $employe == 'VIDE' && $_POST['datedet'] == 'avantcom')  //Si un client a été séléctionner alors on utilise cette requete
			{
				$req = "SELECT C.CODESAGE,MAX(DATE) as DATE2,C.NOM AS NOMC,C.REGULARITE,I.NINTERV,I.NUMEMPLSAGE,I.DATE, E.NOM AS NOME
				FROM `clients` as C INNER JOIN interventions as I on codesage = clientsage
				INNER JOIN employes as E on NUMEMPLSAGE = EmplSage 
				WHERE CODESAGE = '$client' 
				group by `CLIENTSAGE`
                HAVING  MAX(date) < '$datePourMysql1'
                ORDER BY DATE2 DESC";
			}
			elseif ($client == 'VIDE' && $employe != 'VIDE' && $_POST['datedet'] == 'avantcom')//Si un employer a été séléctionner alors on utilise cette requete
			{
				$req = "SELECT C.CODESAGE,MAX(DATE) as DATE2,C.NOM AS NOMC,C.REGULARITE,I.NINTERV,I.NUMEMPLSAGE,I.DATE , E.NOM AS NOME
				FROM interventions as I 
				INNER JOIN `clients` as C on clientsage = codesage 
				INNER JOIN employes as E on NUMEMPLSAGE = EmplSage 
				WHERE emplsage = '$employe' 
				group by `CLIENTSAGE` 
                HAVING MAX(date) < '$datePourMysql1' 
				ORDER BY DATE2 DESC";
			}
			elseif ($client == 'VIDE' && $employe == 'VIDE' && $_POST['datedet'] == 'avantcom')//Si un client ET un employer n'ont PAS été séléctionner alors on utilise cette requete
			{
			$req = "SELECT C.CODESAGE,MAX(DATE) as DATE2,C.NOM AS NOMC,C.REGULARITE,I.NINTERV,I.NUMEMPLSAGE,I.DATE , E.NOM AS NOME
			FROM `clients` as C INNER JOIN interventions as I on codesage = clientsage 
			INNER JOIN employes as E on NUMEMPLSAGE = EmplSage 
			group by `CLIENTSAGE` HAVING max(date) < '$datePourMysql1' ORDER BY MAX(DATE) DESC";
			}
			elseif ($client != 'VIDE' && $employe != 'VIDE' && $_POST['datedet'] == 'intercom')
			{
				$req = "SELECT C.CODESAGE,MAX(DATE) as DATE2,C.NOM AS NOMC,C.REGULARITE,I.NINTERV,I.NUMEMPLSAGE,I.DATE, E.NOM AS NOME
				FROM interventions as I
				INNER JOIN `clients` as C on clientsage = codesage
				INNER JOIN employes as E on NUMEMPLSAGE = EmplSage
				WHERE CODESAGE = '$client'	AND emplsage = '$employe'
				group by `CLIENTSAGE`
                HAVING MAX(date) BETWEEN '$datePourMysql2' AND '$datePourMysql3' 
				ORDER BY DATE2 DESC";
			}
			elseif($client != 'VIDE' && $employe == 'VIDE' && $_POST['datedet'] == 'intercom')
			{
				$req = "SELECT C.CODESAGE,MAX(DATE) as DATE2,C.NOM AS NOMC,C.REGULARITE,I.NINTERV,I.NUMEMPLSAGE,I.DATE, E.NOM AS NOME
				FROM `clients` as C INNER JOIN interventions as I on codesage = clientsage
				INNER JOIN employes as E on NUMEMPLSAGE = EmplSage 
				WHERE CODESAGE = '$client' 
				group by `CLIENTSAGE`
                HAVING max(date) BETWEEN '$datePourMysql2' AND '$datePourMysql3'
                ORDER BY DATE2 DESC";
			}
			elseif ($client == 'VIDE' && $employe != 'VIDE' && $_POST['datedet'] == 'intercom')//Si un employer a été séléctionner alors on utilise cette requete
			{
				$req = "SELECT C.CODESAGE,MAX(DATE) as DATE2,C.NOM AS NOMC,C.REGULARITE,I.NINTERV,I.NUMEMPLSAGE,I.DATE , E.NOM AS NOME
						FROM interventions as I INNER JOIN `clients` as C on clientsage = codesage INNER JOIN employes as E on NUMEMPLSAGE = EmplSage 
						WHERE emplsage = '$employe' group by `CLIENTSAGE` 
						HAVING MAX(DATE) BETWEEN '$datePourMysql2' AND '$datePourMysql3' ORDER BY DATE2 DESC";
				
			}
			elseif ($client == 'VIDE' && $employe == 'VIDE' && $_POST['datedet'] == 'intercom')//Si un client ET un employer n'ont PAS été séléctionner alors on utilise cette requete
			{
				$req = "SELECT C.CODESAGE,MAX(DATE) as DATE2,C.NOM AS NOMC,C.REGULARITE,I.NINTERV,I.NUMEMPLSAGE,I.DATE , E.NOM AS NOME
				FROM `clients` as C INNER JOIN interventions as I on codesage = clientsage 
				INNER JOIN employes as E on NUMEMPLSAGE = EmplSage 
				group by `CLIENTSAGE`
				HAVING MAX(date) BETWEEN '$datePourMysql2' AND '$datePourMysql3' ORDER BY MAX(DATE) DESC";
			}
			$resultat = $this->connexion->query($req);
			if ( !$resultat)
			{
				$vretour=$vretour."<p>Aucun clients à rappeler</p>";
			}
			else
			{
				$vretour=$vretour. "<center>
										<table id='Tabcontientrappel'>
											<tr>
	        								<td>
												<table id='tabrappel'>
													<caption>";
				
				if ($_POST['datedet'] == 'avantcom')
				{
				$vretour=$vretour.		"<h2>Liste des clients dont la dernière intervention <br> est située avant le :<input type='text' name='DateAffiche1' readonly='true' value='$dateRa1'> </h2>";
				}
				elseif ($_POST['datedet'] == 'intercom')
				{
				$vretour=$vretour.		"<h2>Liste des clients dont la dernière intervention <br> est située entre le :<input type='text' name='DateAffiche1' readonly='true' value='$dateinter1'> et le <input type='text' name='DateAffiche1' readonly='true' value='$dateinter2'> </h2>";			
				}
				$vretour=$vretour.		"</caption>
													<tr>
														<th>CodeSage</th><th>Nom</th><th>Date de la derniére intervention</th><th>Nom de l'intervenant</th><th>Lien vers l'intervention</th>
													</tr>";
				//$vretour = $vretour."<ul id='navigation' class='nav-main'><br><center>";//<table><tr><th>CodeSage :</th><th>Nom du client :</th><th>Date de la derniére intervention :</th><th>Régulier</th><th>Non Régulier</th><th>Inconnu</th><th>Inactif :</th></tr>";
				
				
				$tabcodesage= array('');
				while($clients = $resultat->fetch(PDO::FETCH_OBJ)){
					if((in_array($clients->CODESAGE , $tabcodesage)) == false){			 //SI le codesage est pas déjé dans la liste tu lui ajoute et modifie vretour.
						$tabcodesage[]=$clients->CODESAGE;
							
						$vretour = $vretour."<form method='post' id='rappelclients' name='Clientsrappel' action='RappelDInterv.php'>
								<tr>
								<td>	<input type='text' name='Codesagerappel' readonly='true' value='".utf8_encode($clients->CODESAGE)."'></td>
															<td>	<input type='text' name='Nomrappel' readonly='true' value='".utf8_encode($clients->NOMC)."'>	</td>
										<td>	<input type='text' name='Daterappel' readonly='true' value='".$this->AfficheDate($clients->DATE2)."'>	</td>
									
												<td> <input type='text' name='Daterappel' readonly='true' value='".$clients->NOME."'> </td>
												<td> 	<input type='submit' name='RappelDIntervCE' id='RappelDIntervCE' value=\"Voir l'intervention\" > </td>
												</tr>
												<input type='hidden' name='Daterappel1' value='$dateRa1'>
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
	
	

	
	
	
/*	public function Atouslesclients()
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
		
		$vretour = $vretour."
				
		<form method='post' action='#'>
				<fieldset align='left'>
				<input type='radio' id='triC' name='triC' value='TriC'> Tri par commune <br><br>
				<input type='radio' id='triN' name='triN' value='TriN'> Tri par nom <br><br>
				<input type='radio' id='triCl' name='triCl' value='TriCl'> Tri par code client
				<input type='submit' id='go' name='go' value='Valider'><br><br>
				</fieldset>
		</form>";
					
		

		$vretour = $vretour."
		<form method='post' action='#'>	
				<fieldset align='right'>
				<label> Rechercher : </label>
				<input type='textbox' id'rechercher' name='rechercher' value=''><br><br>
				<input type='submit' id='go' name='go' value='Valider'><br><br>
				</fieldset>
		</form>";	
		
		$resultat = "";
		
		
		if($nbtotal > 0)
		{
			if(isset($_POST['triC']))
			{
				echo $_POST['triC'];
				$requete = 'SELECT * FROM clients ORDER BY `COMMUNE` ASC LIMIT '.$limite.' OFFSET '.$debut.' ;';	
				$resultat = $this->connexion->query($requete);
				$vretour = $vretour."<br><form name='ExcelClients' id='ExcelClients' method='POST' action='ExcelClientsCom.php'><input type='submit' id='ExcelClients' name='ExcelClients' value ='Generer Excel'></form><br></nav></ul><br><br>";
				
			}
			elseif(isset($_POST['triN']))
			{
				echo $_POST['triN'];
				$requete = 'SELECT * FROM clients ORDER BY `NOM` ASC LIMIT '.$limite.' OFFSET '.$debut.' ;';
				$resultat = $this->connexion->query($requete);
				$vretour = $vretour."<br><form name='ExcelClients' id='ExcelClients' method='POST' action='ExcelClients.php'><input type='submit' id='ExcelClients' name='ExcelClients' value ='Generer Excel'></form><br></nav></ul><br><br>";
			}
			elseif(isset($_POST['triCl'])){
				$requete = 'SELECT * FROM clients ORDER BY `CODESAGE` ASC LIMIT '.$limite.' OFFSET '.$debut.' ;';
				$resultat = $this->connexion->query($requete);
				$vretour = $vretour."<br><form name='ExcelClients' id='ExcelClients' method='POST' action='ExcelClientsCL.php'><input type='submit' id='ExcelClients' name='ExcelClients' value ='Generer Excel'></form><br></nav></ul><br><br>";
			}
			
			/*if(isset($_POST['commune']))
			{
				$reqcpt = 'SELECT COUNT(*) AS nb FROM clients group by commune;';
				$result = $this->connexion->query($reqcpt);
			}
			
			if(isset($_POST['rechercher']))
			{
			$recherche = $_POST['rechercher'];
			echo $recherche;
			$requete = 'SELECT * FROM clients where COMMUNE LIKE "%'.$recherche.'%" Or NOM LIKE "%'.$recherche.'%" Or COMPLEMENT LIKE "%'.$recherche.'%" Or ADRESSE LIKE "%'.$recherche.'%" LIMIT '.$limite.' OFFSET '.$debut.' ;';
			$resultat = $this->connexion->query($requete);			
			}
			
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
			
			// Puis insertion d'un formulaire pour pouvoir réaliser l'export via un clic bouton.
			
			
			if (isset($_POST['ExcelClients'])){
				$this->AfficheExcelClients();
			}
			
		}
		
		else
		{
			$vretour = $vretour."Aucun client, désolé !";
		}
		
		$vretour= $vretour."<ul id='navigation' class='nav-main'><br><input type='button' value='Retour' onClick=\"javascript:document.location.href='ListeClient.php'\"/><br> <br></ul>";
		return $vretour;
	}*/
	
	
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
	
	
		
		$vretour = $vretour."
		<form method='post' action='#'>
				<fieldset align='right'>
				<label> Recherche dans commune, nom de rue et nom de client : </label>
				<input type='textbox' id'rechercher' name='recherche' value=''><br><br>
				<input type='submit' id='go' name='go' value='Valider'><br><br>
				</fieldset>
		</form>";
	
		$vretour = $vretour."
		
		
		
		<form method='post' action='#'>
				<fieldset align='left'>
				<input type='radio' id='triC' name='triC' value='TriC'> Tri par commune <br>
				<input type='radio' id='triN' name='triN' value='TriN'> Tri par nom <br><br>
				<input type='radio' id='triCl' name='triCl' value='TriCl'> Tri par code client<br><br>
				<label> Le tri s'applique sur l'ensemble des clients  </label>
				<input type='submit' id='go' name='go' value='Valider'><br><br>
				</fieldset>
		</form>";
	
	
	
		if($nbtotal > 0)
		{
			if(isset($_POST['triC']))
			{
				$requete = 'SELECT * FROM clients ORDER BY `COMMUNE` ASC LIMIT '.$limite.' OFFSET '.$debut.' ;';
				$resultat = $this->connexion->query($requete);
				$vretour = $vretour."<br><form name='ExcelClients' id='ExcelClients' method='POST' action='ExcelClientsCom.php'><input type='submit' id='ExcelClients' name='ExcelClients' value ='Generer Excel'></form><br></nav></ul><br><br>";
	
			}
			elseif(isset($_POST['triN']))
			{
				$requete = 'SELECT * FROM clients ORDER BY `NOM` ASC LIMIT '.$limite.' OFFSET '.$debut.' ;';
				$resultat = $this->connexion->query($requete);
				$vretour = $vretour."<br><form name='ExcelClients' id='ExcelClients' method='POST' action='ExcelClients.php'><input type='submit' id='ExcelClients' name='ExcelClients' value ='Generer Excel'></form><br></nav></ul><br><br>";
			}
			else {
					
				$requete = 'SELECT * FROM clients ORDER BY `CODESAGE` ASC LIMIT '.$limite.' OFFSET '.$debut.' ;';
				$resultat = $this->connexion->query($requete);
				$vretour = $vretour."<br><form name='ExcelClients' id='ExcelClients' method='POST' action='ExcelClientsCL.php'><input type='submit' id='ExcelClients' name='ExcelClients' value ='Generer Excel'></form><br></nav></ul><br><br>";
			}
				
			
			if(isset($_POST['rechercher']))
			{
				$recherche = $_POST['rechercher'];
			//	echo $recherche;
				$recherche = strtoupper($recherche);
			//	echo $recherche;
				$requete = 'SELECT * FROM clients where COMMUNE LIKE "%'.$recherche.'%" Or NOM LIKE "%'.$recherche.'%" Or COMPLEMENT LIKE "%'.$recherche.'%" Or ADRESSE LIKE "%'.$recherche.'%" LIMIT '.$limite.' OFFSET '.$debut.' ;';				
				$resultat = $this->connexion->query($requete);
			}
			
			/*if(isset($_POST['commune']))
				{
			$reqcpt = 'SELECT COUNT(*) AS nb FROM clients group by commune;';
			$result = $this->connexion->query($reqcpt);
			}*/
				
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
				
				
			if (isset($_POST['ExcelClients'])){
				$this->AfficheExcelClients();
			}
		}
		else
		{
			$vretour = $vretour."Aucun client, désolé !";
		}
	
		$vretour= $vretour."<ul id='navigation' class='nav-main'><br><input type='button' value='Retour' onClick=\"javascript:document.location.href='ListeClient.php'\"/><br> <br></ul>";
		return $vretour;
	}
	
		
	public function AfficheExcelClients(){
		$vretourExcel = "";
		$NOM = "Clients";
		$Date = date('Y-m-d');		
		header("Content-type: application/msexcel; charset=Windows-1252"); //++++++++++++++++++++++++++++++++++++++++++++++++++++++ CHARSET A CHANGER ISO
		header ("Content-Disposition: attachment; filename=$NOM-$Date.xls");
		//$vretour= $_SESSION['htmlClients'];
		// Pour pouvoir exporter tous les clients dans un fichier excel. (xls) on met tous le contenu dans une variable de session.
		$requeteExcel = 'SELECT * FROM clients ORDER BY `NOM` ASC;';
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
											<td>".utf8_encode ($clientsExcel->CODESAGE)."</td>
											<td>".utf8_encode ($clientsExcel->NOM)."</td>
											<td>".utf8_encode ($clientsExcel->ABREGE)."</td>
											<td>".utf8_encode ($clientsExcel->ADRESSE)."</td>
											<td>".utf8_encode ($clientsExcel->COMPLEMENT)."</td>
											<td>".utf8_encode ($clientsExcel->CODEPOSTAL)."</td>
											<td>".utf8_encode ($clientsExcel->COMMUNE)."</td>
											<td>".utf8_encode ($this->Affichetelephone($clientsExcel->TELEPHONE))."</td>
											<td>".utf8_encode ($clientsExcel->DETAILS)."</td>";
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
	
	public function AfficheExcelClientsCL(){
		$vretourExcel = "";
		$NOM = "Clients";
		$Date = date('Y-m-d');
		header("Content-type: application/msexcel; charset=Windows-1252"); //++++++++++++++++++++++++++++++++++++++++++++++++++++++ CHARSET A CHANGER ISO
		header ("Content-Disposition: attachment; filename=$NOM-$Date.xls");
		//$vretour= $_SESSION['htmlClients'];
		// Pour pouvoir exporter tous les clients dans un fichier excel. (xls) on met tous le contenu dans une variable de session.
		$requeteExcel = 'SELECT * FROM clients ORDER BY `CODESAGE` ASC ;';
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
											<td>".utf8_encode ($clientsExcel->CODESAGE)."</td>
											<td>".utf8_encode ($clientsExcel->NOM)."</td>
											<td>".utf8_encode ($clientsExcel->ABREGE)."</td>
											<td>".utf8_encode ($clientsExcel->ADRESSE)."</td>
											<td>".utf8_encode ($clientsExcel->COMPLEMENT)."</td>
											<td>".utf8_encode ($clientsExcel->CODEPOSTAL)."</td>
											<td>".utf8_encode ($clientsExcel->COMMUNE)."</td>
											<td>".utf8_encode ($this->Affichetelephone($clientsExcel->TELEPHONE))."</td>
											<td>".utf8_encode ($clientsExcel->DETAILS)."</td>";
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
	
	
	public function AfficheExcelClientsCom(){
		$vretourExcel = "";
		$NOM = "Clients";
		$Date = date('Y-m-d');
		header("Content-type: application/msexcel; charset=Windows-1252"); //++++++++++++++++++++++++++++++++++++++++++++++++++++++ CHARSET A CHANGER ISO
		header ("Content-Disposition: attachment; filename=$NOM-$Date.xls");
		//$vretour= $_SESSION['htmlClients'];
		// Pour pouvoir exporter tous les clients dans un fichier excel. (xls) on met tous le contenu dans une variable de session.
		$requeteExcel = 'SELECT * FROM clients ORDER BY `COMMUNE` ASC ;';
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
											<td>".utf8_encode ($clientsExcel->CODESAGE)."</td>
											<td>".utf8_encode ($clientsExcel->NOM)."</td>
											<td>".utf8_encode ($clientsExcel->ABREGE)."</td>
											<td>".utf8_encode ($clientsExcel->ADRESSE)."</td>
											<td>".utf8_encode ($clientsExcel->COMPLEMENT)."</td>
											<td>".utf8_encode ($clientsExcel->CODEPOSTAL)."</td>
											<td>".utf8_encode ($clientsExcel->COMMUNE)."</td>
											<td>".utf8_encode ($this->Affichetelephone($clientsExcel->TELEPHONE))."</td>
											<td>".utf8_encode ($clientsExcel->DETAILS)."</td>";
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
?>
