
<?php

session_start();
if (!isset ($_SESSION['login']))
{
	header("Location: index.php");
}
class page_interventions extends page_base {
	private $connexion;
	private $PDO;
	
	
	public function __construct($p) {
		parent::__construct($p);

		$this->PDO=New PDO_MS();
		$this->PDO->connexion("menuservice");
		$this->connexion=$this->PDO->connexion;
	}
	
	

	public function insertion_Interventions() 
	{
		if (isset($_POST['facture']))
		{
			$facture='1';
		}
		Else $facture='0';
	
		$Client = $this->connexion -> quote($_POST['listeclients']) ;
		$Employe = $this->connexion -> quote($_POST['listeemployes']) ;
		//$DateR = $this->connexion -> quote($_POST['Date']) ;    SI J'UTILISE Cette méthode le envoiMysqlDate me renverra une mauvaise date derriére.
		$DateR = $_POST['Date'];		
		$Date = $this->envoiMysqlDate($DateR); //Fonction qui va retourné la date au  format yyyy-mm-dd pour Mysql ensuite.		
		$T1 = $this->connexion -> quote($_POST['T1']) ;
		$T2 = $this->connexion -> quote($_POST['T2']) ;
		$DESH = $this->connexion -> quote($_POST['DESH']) ;
		$DECH = $this->connexion -> quote($_POST['DECH']) ;
		$BRIC = $this->connexion -> quote($_POST['BRIC']) ;
		$VITR = $this->connexion -> quote($_POST['VITR']) ;
		$COURSES = $this->connexion -> quote($_POST['COURSES']) ;
		$PULVERISATEUR = $this->connexion -> quote($_POST['PULVERISATEUR']) ;
		$TOTAL = $this->connexion -> quote($_POST['TOTAL']) ;
		
		
	
			
		$requete="insert into interventions (CLIENTSAGE,NUMEMPLSAGE,DATE,T1,T2,DESH,DECH,BRIC,VITR,COURSES,PULVERISATEUR,TOTAL,facture)
				 VALUES(".$Client.",".$Employe.",'".$Date."',".$T1.",".$T2.",".$DESH.",".$DECH.",".$BRIC.",".$VITR.",".$COURSES.",".$PULVERISATEUR.",".$TOTAL.",".$facture.")";
		$nblignes=$this->connexion -> exec($requete);
		
		$dataIR = "alert('Insertion réussie')"; 
			if ($nblignes !=1)
			{				
				echo "<script>alert('Insertion impossible')</script>";				
			}
			else
			{
				echo "<script>$dataIR\n";
			    echo "</script>";
				$result = null;
			}
			
	}

	public function modifier_Interventions()
	{

			if (isset($_POST['facture']))
		{
			$facture='1';
		}
		Else $facture='0';
		
		$NINTERV  = $_POST["NumI"] ;
		$Client = $_POST["CodeC"];
		$Employe = $_POST["CodeE"];
		

		$Date= $_POST['Date'];
		$DateR1 = explode("/",$Date); //Divise la variables pour ensuite la répartir en Jour/mois/année
		$jour = $DateR1[0];
		$mois = $DateR1[1];
		$annee = $DateR1[2];
		$DateR = $annee.'-'.$mois.'-'.$jour;
		
		$T1 = $_POST["T1"];
		$T2 = $_POST["T2"];
		$DESH = $_POST["DESH"];
		$DECH = $_POST["DECH"];
		$BRIC = $_POST["BRIC"];
		$VITR = $_POST["VITR"];
		$COURSES = $_POST["COURSES"];
		$PULVERISATEUR = $_POST["PULVERISATEUR"];
		$TOTAL = $_POST["TOTAL"];
	
		$requete="update interventions set CLIENTSAGE='$Client', NUMEMPLSAGE='$Employe', DATE='$DateR', T1='$T1', T2='$T2', DESH='$DESH', DECH='$DECH', BRIC='$BRIC', VITR='$VITR', COURSES='$COURSES', PULVERISATEUR='$PULVERISATEUR', TOTAL='$TOTAL', facture='$facture' where NINTERV='$NINTERV'";
		$nblignes=$this->connexion -> exec($requete);
	

		if ($nblignes !=1)
		{
			echo utf8_decode("<script>alert('Modification impossible')\n");
			echo "document.location = ('Interventions.php')";
			echo "</script>";
		}
		if ($nblignes ==1)
		{	
			echo utf8_decode("<script>alert('Modification réussie')\n");
			echo "document.location = ('Interventions.php')";
			echo "</script>";
			$result = null;
		}
		
		
			
	}
	
	
	
	public function supp_Interventions()
	{
	
		
		$requete="DELETE FROM interventions WHERE ninterv=$NINTERV";
		$nblignes=$this->connexion -> exec($requete);
	
	
		if ($nblignes !=1)
		{
			echo "<script>alert('Suppression impossible')\n";
			echo "document.location = ('Interventions.php')";
			echo "</script>";
		}
		if ($nblignes ==1)
		{
			echo "<script>alert('Suppression réussie')\n";
			echo "document.location = ('Interventions.php')";
			echo "</script>";
			$result = null;
		}
	
	
			
	}
	
	
	
	
	
	
	
	
	
	
	
	
	// Suites de réquetes SQL afin d'obtenir toute les informations selons les interventions de la BDD
	public function les_interventions()
	{
		$req = "Select * , DAY(date) AS jour, MONTH(date) AS mois, YEAR(date) AS annee From interventions";
		$res = $this->connexion->query($req);
		return $res;
	}
	
	public function les_interventions_date()
	{
		$DateD = $this->envoiMysqlDate($_POST['DateD']);
		$DateF = $this->envoiMysqlDate($_POST['DateF']);
		
		$req = "Select *, DAY(date) AS jour, MONTH(date) AS mois, YEAR(date) AS annee From interventions as I inner join employes as E on I.NUMEMPLSAGE=E.EmplSage inner join clients as C on I.CLIENTSAGE=C.CODESAGE WHERE Date BETWEEN '$DateD' AND '$DateF'";
		$res = $this->connexion->query($req);
		return $res;
	}
	
	public function les_interventions_date_clients()
	{

		$DateD = $this->envoiMysqlDate($_POST['DateD']);
		$DateF = $this->envoiMysqlDate($_POST['DateF']);
		
		if (isset ($_POST['listeclients2'])){$listeclients= $_POST['listeclients2'];}
		$req = "Select *, DAY(date) AS jour, MONTH(date) AS mois, YEAR(date) AS annee From interventions as I inner join employes as E on I.NUMEMPLSAGE=E.EmplSage inner join clients as C on I.CLIENTSAGE=C.CODESAGE WHERE CODESAGE='$listeclients' AND Date BETWEEN '$DateD' AND '$DateF'";
		$res = $this->connexion->query($req);
		
		
		return $res;
		
	
	}
	
	public function les_interventions_date_employes()
	{
		$DateD = $this->envoiMysqlDate($_POST['DateD']);
		$DateF = $this->envoiMysqlDate($_POST['DateF']);
		
	
		if (isset ($_POST['listeemployes2'])){$listeemployes= $_POST['listeemployes2'];}
		
		$req = "Select * , DAY(date) AS jour, MONTH(date) AS mois, YEAR(date) AS annee From interventions as I inner join employes as E on I.NUMEMPLSAGE=E.EmplSage inner join clients as C on I.CLIENTSAGE=C.CODESAGE WHERE EmplSage=$listeemployes AND Date BETWEEN '$DateD' AND '$DateF'";
		$res = $this->connexion->query($req);
		return $res;
	}
	
	public function les_interventions_date_employes_clients()
	{
		$DateD = $this->envoiMysqlDate($_POST['DateD']);
		$DateF = $this->envoiMysqlDate($_POST['DateF']);
	
	
		if (isset($_POST['listeemployes2']) && isset($_POST['listeclients2'])) 
		{$listeemployes=$_POST['listeemployes2'];
		 $listeclients=$_POST['listeclients2'];}
		$req = "Select *, DAY(date) AS jour, MONTH(date) AS mois, YEAR(date) AS annee From interventions as I inner join employes as E on I.NUMEMPLSAGE=E.EmplSage inner join clients as C on I.CLIENTSAGE=C.CODESAGE WHERE EmplSage=$listeemployes AND CODESAGE='$listeclients' AND Date BETWEEN '$DateD' AND '$DateF'";
		$res = $this->connexion->query($req);
		return $res;
	}
	
	public function les_interventions_employes_clients()
	{
		if (isset($_POST['listeemployes2']) && isset($_POST['listeclients2'])) 
		{$listeemployes=$_POST['listeemployes2'];
		 $listeclients=$_POST['listeclients2'];}

		$req = "Select *, DAY(date) AS jour, MONTH(date) AS mois, YEAR(date) AS annee From interventions as I inner join employes as E on I.NUMEMPLSAGE=E.EmplSage inner join clients as C on I.CLIENTSAGE=C.CODESAGE WHERE EmplSage=$listeemployes AND CODESAGE='$listeclients'";
		$res = $this->connexion->query($req);
		return $res;
	}
	public function les_interventions_employes()
	{
	
	if (isset($_POST['listeemployes2'])) {$listeemployes=$_POST['listeemployes2'];}
		$req = "Select *, DAY(date) AS jour, MONTH(date) AS mois, YEAR(date) AS annee From interventions as I inner join employes as E on I.NUMEMPLSAGE=E.EmplSage inner join clients as C on I.CLIENTSAGE=C.CODESAGE WHERE EmplSage=$listeemployes";
		$res = $this->connexion->query($req);
		return $res;
	}
	public function les_interventions_clients()
	{
		
	if (isset ($_POST['listeclients2'])){
		$listeclients =$_POST['listeclients2'];}
		Else {$listeclients=$_POST['CodeC'];}
		$req = "Select *, DAY(date) AS jour, MONTH(date) AS mois, YEAR(date) AS annee From interventions as I inner join employes as E on I.NUMEMPLSAGE=E.EmplSage inner join clients as C on I.CLIENTSAGE=C.CODESAGE WHERE CODESAGE='$listeclients'";
		$res = $this->connexion->query($req);
		return $res;
	}
	//Liste déroulante Client d'enregistrer clients, ou modifier client.
public function les_clients($parametre,$id)
	{
		$vretour="";
		$req = "Select CODESAGE,NOM From clients order by NOM";
		$res = $this->connexion->query($req);
		

	if(isset($res)){
		
		//En cas d'enregistrements (par défaut, le lien du menu Intervention renvoi sur cette liste la)
		 if ((!isset ($_POST['listeclients']) && !isset($_POST['listeclients2'])) && (!isset ($_POST['Codesagerappel'])))	{	
				$vretour= $vretour."
						<select name='listeclients' id='$id' class=\"validate[$parametre] \" Onchange=\"ValeurClient()\"><option value=''></option>";
				while ($donnees = $res->fetch(PDO::FETCH_OBJ)) {					
					$vretour= $vretour.'<option value=' . $donnees->CODESAGE . '>'. $donnees->CODESAGE .' - ' . $donnees->NOM . '</option>';
					
					} 
					$vretour=$vretour."</select>";
					$vretour = $vretour."<input type='hidden' id='CodeC' name='CodeC' value=''>";
		          
		}
		
		// SI l'enregistrement é été effectuer, ou qu'on appel le formulaire du rappel client
		else if ((isset ($_POST['CodeC']))||((isset ($_POST['Codesagerappel'])))) {
				if(isset ($_POST['Codesagerappel']))
				{
					$CodeC = $_POST['Codesagerappel'];
				}
				else
				{
					$CodeC = $_POST['CodeC'];
				}
				$req2 = "Select * From clients where CODESAGE = '$CodeC'";
				$res2 = $this->connexion->query($req2);
				while ($donneesR = $res2->fetch(PDO::FETCH_OBJ)) {
					$NomC = utf8_decode($donneesR->NOM);
					$vretour = $vretour."<input type='hidden' name='NomC' value=$NomC>";
					
				}
				
				$vretour= $vretour."<select name='listeclients' id='$id' class=\"validate[$parametre] \" Onchange=\"ValeurClient()\"><option value=$CodeC>".$CodeC." - ".$NomC."</option><option value=''></option>";
				while ($donnees = $res->fetch(PDO::FETCH_OBJ))
				{
					$vretour= $vretour.'<option value=' . $donnees->CODESAGE . '>'. $donnees->CODESAGE .' - ' . utf8_decode($donnees->NOM) .'</option>';
				}
				$vretour = $vretour."</select><input type='hidden' id='CodeC' name='CodeC' value=$CodeC>";
				}
				// Si ont veut afficher la modification interventions suite au choix d'une liste d'interventions
		else if (isset ($_POST['NomClient']) && !empty ($_POST['NomClient'])){
				$NomC = $_POST['NomClient'];
				$req2 = "Select * From clients where Nom = '$NomC'";
				$res2 = $this->connexion->query($req2);
				while ($donneesR = $res2->fetch(PDO::FETCH_OBJ)) {
					$CodeC = utf8_decode($donneesR->CODESAGE);
			
					$vretour = $vretour."<input type='hidden' name='NomC' value=$NomC>";
				}
			
				$vretour= $vretour."<select name='listeclients' id='$id' class=\"validate[$parametre] \" Onchange=\"ValeurClient()\"><option value='$CodeC'>".$CodeC." - ".$NomC."</option><option value=''></option>";
				while ($donnees = $res->fetch(PDO::FETCH_OBJ))
				{
					$vretour= $vretour.'<option value=' . $donnees->CODESAGE . '>'. $donnees->CODESAGE .' - ' . utf8_decode($donnees->NOM) .'</option>';
				}
				$vretour = $vretour."</select><input type='hidden' id='CodeC' name='CodeC' value='$CodeC'>";
			}
				$res->closeCursor ();	
			
								
					
		}
		
		return $vretour;
	}
	// Affiche la liste client de la Selection d'interventions. 
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
	// Idem que pour client
	public function les_employes($parametre,$id)
	{
		$vretour='';
		$req = "Select EmplSage,Nom,Prenom From employes where ANCIEN_EMPLOYE='0'";
		$res = $this->connexion->query($req);
		 if(isset($res))
		 {
		  if (!isset ($_POST['listeemployes']) && !isset($_POST['listeemployes2']) && !isset($_POST['Emplrappel']) )	{
		  		$vretour= $vretour."<select name='listeemployes' id='$id' class=\"validate[$parametre] \" Onchange=\"ValeurEmploye()\"><option value=''></option>";
		  		while ($donnees = $res->fetch(PDO::FETCH_OBJ))
		  		{
		  			$vretour= $vretour.'<option value=' . $donnees->EmplSage . '>'. $donnees->EmplSage .' - ' . utf8_decode($donnees->Nom) .' - ' . utf8_decode($donnees->Prenom) .  '</option>';
		  		}
		  		$vretour=$vretour."</select><input type='hidden' id='CodeE' name='CodeE' value=''>";
		  	
		  	}
		else if ((isset ($_POST['CodeE']))||(isset($_POST['Emplrappel']))) {
			
			if (isset ($_POST['Emplrappel'])){
				$CodeE = $_POST['Emplrappel'];					
			}
			else
			{
				$CodeE = $_POST['CodeE'];
			}
				$req2 = "Select * From employes where EmplSage = '$CodeE'";
				$res2 = $this->connexion->query($req2);
				while ($donneesR = $res2->fetch(PDO::FETCH_OBJ)) {
					$NomE = utf8_decode($donneesR->Nom);
					$PrenomE = utf8_decode($donneesR->Prenom);
					$vretour = $vretour."<input type='hidden' name='NomE' value=$NomE>";
					$vretour = $vretour."<input type='hidden' name='PrenomE' value=$PrenomE>";
				}
				
				$vretour= $vretour."<select name='listeemployes' id='$id' class=\"validate[$parametre] \" Onchange=\"ValeurEmploye()\"><option value=$CodeE>".$CodeE." - ".$NomE." - ".$PrenomE."</option><option value=''></option>";
				while ($donnees = $res->fetch(PDO::FETCH_OBJ))
				{
					$vretour= $vretour.'<option value=' . $donnees->EmplSage . '>'. $donnees->EmplSage .' - ' . utf8_decode($donnees->Nom) .' - ' . utf8_decode($donnees->Prenom) .  '</option>';
				}
				$vretour = $vretour."</select><input type='hidden' id='CodeE' name='CodeE' value=$CodeE>";
		}	
		else if (isset ($_POST['NomEmp']) && !empty ($_POST['NomEmp'])){
				$NomE = $_POST['NomEmp'];
				$req2 = "Select * From employes where Nom = '$NomE'";
				$res2 = $this->connexion->query($req2);
				while ($donneesR = $res2->fetch(PDO::FETCH_OBJ)) {
					$CodeE = utf8_decode($donneesR->EmplSage);
					$PrenomE = utf8_decode($donneesR->Prenom);
					$vretour = $vretour."<input type='hidden' name='NomE' value=$NomE><input type='hidden' name='PrenomE' value=$PrenomE>";
				}
				
				$vretour= $vretour."<select name='listeemployes' id='$id' class=\"validate[$parametre] \" Onchange=\"ValeurEmploye()\"><option value=$CodeE>".$CodeE." - ".$NomE." - ".$PrenomE."</option><option value=''></option>";
				while ($donnees = $res->fetch(PDO::FETCH_OBJ))
				{
					$vretour= $vretour.'<option value=' . $donnees->EmplSage . '>'. $donnees->EmplSage .' - ' . utf8_decode($donnees->Nom) .' - ' . utf8_decode($donnees->Prenom) .  '</option>';
				}
				$vretour = $vretour."</select><input type='hidden' id='CodeE' name='CodeE' value=$CodeE>";
		}
	 }				
		
		$res->closeCursor ();
		return $vretour;
	}
	
	// Idem que pour clients
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
	

	public function affiche_interventions() {
		
		
		$a="
					
			
					
		<ul id='navigation' class='nav-main'><h2>Liste : </h2>";

		$DateD = $this->envoiMysqlDate($_POST['DateD']);
		$DateF = $this->envoiMysqlDate($_POST['DateF']);
		//Si la deuxieme liste client a été selectionner
		if (isset ($_POST['listeclients2'])){
		$listeclients =  $_POST['listeclients2'];}
		else $listeclients='';
		//Si la deuxieme liste employés a été selectionner
		if (isset ($_POST['listeemployes2'])){
		$listeemployes =  $_POST['listeemployes2'];}
		else $listeemployes='';
		
		//Conditions des executions des réquetes SQL 
		if (!empty ($listeclients) && empty ($listeemployes))
		{
			$result = $this->les_interventions_date_clients();
		}
		if (!empty ($listeemployes) && empty ($listeclients))
		{
			$result = $this->les_interventions_date_employes();
		}
	   if (!empty ($listeclients) && !empty ($listeemployes))
	    {
        	$result = $this->les_interventions_date_employes_clients();
		}
		if (empty ($listeclients) && empty ($listeemployes))
		{
			$result = $this->les_interventions_date();
	
		}
		if (!empty ($listeclients) && !empty ($listeemployes) && empty ($_POST['DateD']) && empty ($_POST['DateF']))
		{
			$result = $this->les_interventions_employes_clients();
		}
		
		if (!empty ($listeclients) && empty ($listeemployes) && empty ($_POST['DateD']) && empty ($_POST['DateF']))
		{
			$result = $this->les_interventions_clients();
		}
		
		if (empty ($listeclients) && !empty ($listeemployes) && empty ($_POST['DateD']) && empty ($_POST['DateF']))
		{
			$result = $this->les_interventions_employes();
		}
		
		if (empty ($listeclients) && empty ($listeemployes) && empty ($_POST['DateD']) && empty ($_POST['DateF']))
		{
			$result = $this->les_interventions();
		}
		// Pour trouver si c'est la valeur de la premier liste ou deuxieme liste employé qui é été renvoyer
		
		if (isset ($_POST['CodeE'])){
			$CodeE = $_POST['CodeE'];
			$a=$a."<input type='hidden' name='CodeE' value=".$CodeE.">";}
				
		if (isset ($_POST['CodeEI'])){
			$CodeEI = $_POST['CodeEI'];
			$a=$a."<input type='hidden' name='CodeEI' value=".$CodeEI.">";}
			
		// Pour trouver si c'est la valeur de la premier liste ou deuxieme liste client qui é été renvoyer
		if (isset ($_POST['CodeC'])){
			$CodeC = $_POST['CodeC'];
			$a=$a."<input type='hidden' name='CodeC' value=".$CodeC.">";}
						
		if (isset ($_POST['CodeCI'])){
			$CodeCI = $_POST['CodeCI'];
			$a=$a."<input type='hidden' name='CodeCI' value=".$CodeCI.">";}
				
			$a=$a. "<center>
					<table id='TBZHEBRA' border='1'>
					<tr><th>Numéro</th><th>Client</th><th>Employé(e)</th>
					<th>Date</th><th>T1</th><th>T2</th><th>DECH</th><th>BRIC</th>
					<th>VITR</th><th>COUR</th><th><b>TOTAL</b></th><th>PULVE</th><th>DESH</th></tr>";
			
			
				
			// Entrer de toutes les variables pour les transmettres aux autres pages.
			while ($donnees = $result->fetch(PDO::FETCH_OBJ))
			{
					$a=$a."<form name='Modifier' action=\"Modif_interventions.php\" id='PDF' method=\"post\">";

					if (isset ($_POST['DateD']) && isset ($_POST['DateF'])){
						$DateD = $_POST['DateD'];
						$DateF = $_POST['DateF'];
						$a=$a. "
						<input type='hidden' name='DateD' value=$DateD>
						<input type='hidden' name='DateF' value=$DateF> ";
					}
				
				$a=$a."
				<input type='hidden' name='listeemployes' value=".$listeemployes.">
				<input type='hidden' name='listeclients' value=".$listeclients.">
				<input type='hidden' name='NomEmp' value='".$donnees->Nom."'>
				<input type='hidden' name='NomClient' value='".$donnees->NOM."'>
			    <input type='hidden' name='AdresseClient' value='".$donnees->ADRESSE."'>
			    <input type='hidden' name='CPClient' value='".$donnees->CODEPOSTAL."'>
			    <input type='hidden' name='CommuneClient' value='".$donnees->COMMUNE."'>
			    <input type='hidden' name='COMPLEMENTClient' value='".$donnees->COMPLEMENT."'>
			    <input type='hidden' name='TELEPHONEClient' value='".$donnees->TELEPHONE."'>
			    <input type='hidden' name='NINTERV' value='".$donnees->NINTERV."'>
			    <input type='hidden' name='Client' value='".$donnees->CODESAGE."'>
			    <input type='hidden' name='T1' value='".$donnees->T1."'>
			    <input type='hidden' name='T2' value='".$donnees->T2."'>
			    <input type='hidden' name='DESH' value='".$donnees->DESH."'>
			    <input type='hidden' name='DECH' value='".$donnees->DECH."'>
			    <input type='hidden' name='BRIC' value='".$donnees->BRIC."'>
			    <input type='hidden' name='VITR' value='".$donnees->VITR."'>
			    <input type='hidden' name='COURSES' value='".$donnees->COURSES."'>
			    <input type='hidden' name='COURSES' value='".$donnees->COURSES."'>
			    <input type='hidden' name='PULVERISATEUR' value='".$donnees->PULVERISATEUR."'>
			    <input type='hidden' name='TOTAL' value='".$donnees->TOTAL."'>
			    <input type='hidden' name='jour' value='".$donnees->jour."'>
			    <input type='hidden' name='mois' value='".$donnees->mois."'>
			    <input type='hidden' name='annee' value='".$donnees->annee."'>
			    <input type='hidden' name='NINTERV' value='".$donnees->NINTERV."'>
			 
				";

				
				if ($donnees->facture==1)
				{ $donnees->facture='Oui'; }
				Else
				{ $donnees->facture='Non';}
				
				if ($donnees->TOTAL=='0')
				{
					$donnees->TOTAL= $donnees->T1 + $donnees->T2 + $donnees->DECH + $donnees->BRIC + $donnees->VITR + $donnees->COURSES ;
				}
				if ($donnees->TOTAL=='')
				{
					$donnees->TOTAL= $donnees->T1 + $donnees->T2  + $donnees->DECH + $donnees->BRIC + $donnees->VITR + $donnees->COURSES ;
				}
				
				if ($donnees->mois<10)
				{$mois = '0'.$donnees->mois;}
				else { $mois =$donnees->mois;}
				
				if ($donnees->jour<10)
				{$jour = '0'.$donnees->jour;}
				else { $jour =$donnees->jour;}
				
			    // Affichage du tableau de la liste des interventions
				$a=$a."
				<tr>
			    <td id='TD1I'>" .utf8_encode ($donnees->NINTERV)."</td>
			    <td id='TD2I'>" .utf8_encode ($donnees->CLIENTSAGE). "<br>" .utf8_encode ($donnees->NOM)."</td>
			    <td>".utf8_encode ($donnees->Nom)."</td>
			    <td id='TD1I' >" .utf8_encode ($jour/$mois/$donnees->annee)."</td>
			    <td id='TD1I'>" .utf8_encode ($donnees->T1)."</td>
			    <td id='TD1I'>" .utf8_encode ($donnees->T2)."</td>
			   
			    <td id='TD1I'>" .utf8_encode ($donnees->DECH)."</td>
			    <td id='TD1I'>" .utf8_encode ($donnees->BRIC)."</td>
				<td id='TD1I'>" .utf8_encode ($donnees->VITR)."</td>
				<td id='TD1I'>" .utf8_encode ($donnees->COURSES)."</td>
				 
				<td id='TD1I'>" .utf8_encode ($donnees->TOTAL)."</td>
				
				<td id='TD1I'>" .utf8_encode ($donnees->PULVERISATEUR)."</td>
				<td id='TD1I'>" .utf8_encode ($donnees->DESH)."</td>						
				<td><input type=\"submit\"  name='Modifier'  value=\" Modifier \"/></td>
			
				</form>
						
						
						
						
				<form name='Supprimer' action=\"Ex_supp_intervention.php\" id='PDF' method=\"post\">";
				
				if (isset ($_POST['DateD']) && isset ($_POST['DateF'])){
					$DateD = $_POST['DateD'];
					$DateF = $_POST['DateF'];
					$a=$a. "
					<input type='hidden' name='DateD' value=$DateD>
					<input type='hidden' name='DateF' value=$DateF> ";
				}
				
				$a=$a."
				<input type='hidden' name='listeemployes' value=".$listeemployes.">
				<input type='hidden' name='listeclients' value=".$listeclients.">
				<input type='hidden' name='NomEmp' value='".$donnees->Nom."'>
				<input type='hidden' name='NomClient' value='".$donnees->NOM."'>
			    <input type='hidden' name='AdresseClient' value='".$donnees->ADRESSE."'>
			    <input type='hidden' name='CPClient' value='".$donnees->CODEPOSTAL."'>
			    <input type='hidden' name='CommuneClient' value='".$donnees->COMMUNE."'>
			    <input type='hidden' name='COMPLEMENTClient' value='".$donnees->COMPLEMENT."'>
			    <input type='hidden' name='TELEPHONEClient' value='".$donnees->TELEPHONE."'>
			    <input type='hidden' name='NINTERV' value='".$donnees->NINTERV."'>
			    <input type='hidden' name='Client' value='".$donnees->CODESAGE."'>
			    <input type='hidden' name='T1' value='".$donnees->T1."'>
			    <input type='hidden' name='T2' value='".$donnees->T2."'>
			    <input type='hidden' name='DESH' value='".$donnees->DESH."'>
			    <input type='hidden' name='DECH' value='".$donnees->DECH."'>
			    <input type='hidden' name='BRIC' value='".$donnees->BRIC."'>
			    <input type='hidden' name='VITR' value='".$donnees->VITR."'>
			    <input type='hidden' name='COURSES' value='".$donnees->COURSES."'>
			    <input type='hidden' name='COURSES' value='".$donnees->COURSES."'>
			    <input type='hidden' name='PULVERISATEUR' value='".$donnees->PULVERISATEUR."'>
			    <input type='hidden' name='TOTAL' value='".$donnees->TOTAL."'>
			    <input type='hidden' name='jour' value='".$donnees->jour."'>
			    <input type='hidden' name='mois' value='".$donnees->mois."'>
			    <input type='hidden' name='annee' value='".$donnees->annee."'>
			    <input type='hidden' name='NINTERV' value='".$donnees->NINTERV."'>
				
				";
				
				
				if ($donnees->facture==1)
				{ $donnees->facture='Oui'; }
				Else
				{ $donnees->facture='Non';}
				
				if ($donnees->TOTAL=='0')
				{
					$donnees->TOTAL= $donnees->T1 + $donnees->T2 + $donnees->DECH + $donnees->BRIC + $donnees->VITR + $donnees->COURSES ;
				}
				if ($donnees->TOTAL=='')
				{
					$donnees->TOTAL= $donnees->T1 + $donnees->T2  + $donnees->DECH + $donnees->BRIC + $donnees->VITR + $donnees->COURSES ;
				}
				
				if ($donnees->mois<10)
				{$mois = '0'.$donnees->mois;}
				else { $mois =$donnees->mois;}
				
				if ($donnees->jour<10)
				{$jour = '0'.$donnees->jour;}
				else { $jour =$donnees->jour;}
				
				// Affichage du tableau de la liste des interventions
				$a=$a."
			
				<td><input type=\"submit\"  name='Supprimer'  value=\" Supprimer \"/></td>
		
				</form>	";  
			
			}
				
				
				 
			
			$result -> closeCursor();
			//Formulaire de l'excel
			$a=$a."</table>
				
			<form name='Excel' action=\"Excelinterv.php\"  method=\"post\">
					
			    <input type='hidden' name='DateD' id='DateD' value=".$DateD.">		
			    <input type='hidden' name='DateF' id='DateF' value=".$DateF.">
			    <input type='hidden' name='listeemployes2' value=".$CodeEI.">
			    <input type='hidden' name='listeclients2' value=".$CodeCI.">	
			   
					<br>
				<input name='Excel' type=\"submit\"style=\" width: 130px\"    value=\" Exporter \" />
			</form ></centre><br><nav ><ul id='navigation' class='nav-main'></ul></ul></nav>";
			
			
			$a= $a."<ul id='navigation' class='nav-main'><br><input type='button' value='Retour' onClick=\"javascript:document.location.href='Interventions.php'\"/><br> <br></ul>";
			
		$result=null;
		
		
	return $a;
}

public function dernier_NINTERV() //Permet de connaitre le dernier client C000 inscrit dans la BDD.
{
	$vretour='';
	$requete = 'SELECT MAX(NINTERV+1) AS nb FROM Interventions ;'; //LE +0 c'est pour que le MAX ne prenne en compte que les int ! (Car il existe client qui ne sont pas de la forme C0001111).
	$resultat = $this->connexion->query( $requete);
	$vretour=$resultat->fetch(PDO::FETCH_OBJ)->nb;
	return $vretour;
}

public function SCRIPT()
/*
 * les function ValeurEmploye,ValeurEmployeI,ValeurClient et ValeurClientI servent é modifier directement
 * les valeurs de leurs liste respectives afin de plus facilement renvoyer les données. 
 */
 {
	$vretour = "<script>
			
			
			function ValeurEmploye() {
													i = document.FormI.listeemployes.selectedIndex;
													if (i == 0) return;
													valeur = document.FormI.listeemployes.options[i].value;
													document.getElementById(\"FormI\").elements[\"CodeE\"].value=valeur;
													}
			
			function ValeurEmployeI() {
													i1 = document.FormCDI.listeemployes2.selectedIndex;
													if (i1 == 0) return;
													valeur1 = document.FormCDI.listeemployes2.options[i1].value;
													document.getElementById(\"FormCDI\").elements[\"CodeEI\"].value=valeur1;
													}
			function ValeurClient() {
													i2 = document.FormI.listeclients.selectedIndex;
													if (i2 == 0) return;
													valeur2 = document.FormI.listeclients.options[i2].value;
													document.getElementById(\"FormI\").elements[\"CodeC\"].value=valeur2;
													}
			
			function ValeurClientI() {
													i3= document.FormCDI.listeclients2.selectedIndex;
													if (i3 == 0) return;
													valeur3 = document.FormCDI.listeclients2.options[i3].value;
													document.getElementById(\"FormCDI\").elements[\"CodeCI\"].value=valeur3;
													}
			
			
			
			
		function calculTOTAL()
			{
			
				var total=   parseFloat(document.getElementById(\"FormI\").elements[\"T1\"].value) + 
						     parseFloat(document.getElementById(\"FormI\").elements[\"T2\"].value) + 
						   
						     parseFloat(document.getElementById(\"FormI\").elements[\"DECH\"].value) + 
					         parseFloat(document.getElementById(\"FormI\").elements[\"BRIC\"].value) + 
				    	     parseFloat(document.getElementById(\"FormI\").elements[\"VITR\"].value) +
					    	 parseFloat(document.getElementById(\"FormI\").elements[\"COURSES\"].value);
						
				document.getElementById(\"FormI\").elements[\"TOTAL\"].value=total;
				
							}
								
									function calculMinute()
			{
		
				
				var M1=  parseFloat(document.getElementById(\"FormI\").elements[\"T1\"].value) * 60;  
								  var hours1 = parseInt(M1 / 60);
								 var nbminuteRestante1 = (M1 % 60);
								document.getElementById(\"FormI\").elements[\"M1\"].value=nbminuteRestante1;
								document.getElementById(\"FormI\").elements[\"H1\"].value=hours1;
			
				var M2=	  parseFloat(document.getElementById(\"FormI\").elements[\"T2\"].value) * 60;  
								  var hours2 = parseInt(M2 / 60);
								 var nbminuteRestante2 = (M2 % 60);
								document.getElementById(\"FormI\").elements[\"M2\"].value=nbminuteRestante2;
								document.getElementById(\"FormI\").elements[\"H2\"].value=hours2;
			
				
			
				var M4=   parseFloat(document.getElementById(\"FormI\").elements[\"DECH\"].value) * 60; 
								 var hours4 = parseInt(M4 / 60);
								 var nbminuteRestante4 = (M4 % 60);
								document.getElementById(\"FormI\").elements[\"M4\"].value=nbminuteRestante4;
								document.getElementById(\"FormI\").elements[\"H4\"].value=hours4;
			 
				var M5=   parseFloat(document.getElementById(\"FormI\").elements[\"BRIC\"].value) * 60;
								 var hours5 = parseInt(M5 / 60);
								 var nbminuteRestante5 = (M5 % 60);
								document.getElementById(\"FormI\").elements[\"M5\"].value=nbminuteRestante5;
								document.getElementById(\"FormI\").elements[\"H5\"].value=hours5;
			
				var M6=   parseFloat(document.getElementById(\"FormI\").elements[\"VITR\"].value) * 60; 
								 var hours6 = parseInt(M6 / 60);
								 var nbminuteRestante6 = (M6 % 60);
								document.getElementById(\"FormI\").elements[\"M6\"].value=nbminuteRestante6;
								document.getElementById(\"FormI\").elements[\"H6\"].value=hours6;
			
				var M7=   parseFloat(document.getElementById(\"FormI\").elements[\"COURSES\"].value) * 60;
								  var hours7 = parseInt(M7 / 60);
								 var nbminuteRestante7 = (M7 % 60);
								document.getElementById(\"FormI\").elements[\"M7\"].value=nbminuteRestante7;
								document.getElementById(\"FormI\").elements[\"H7\"].value=hours7;
			
				
				
								
										
				
							}
								
			function calculDecimal()
			{
			
				var M1B=	  parseFloat(document.getElementById(\"FormI\").elements[\"M1\"].value) ;  
				var H1B=      parseFloat(document.getElementById(\"FormI\").elements[\"H1\"].value) ; 
								 var hours1 = H1B;
								 var nbminuteRestante1 = (M1B / 60);
								 var HM1 = hours1 + nbminuteRestante1 ;
								parseFloat(document.getElementById(\"FormI\").elements[\"T1\"].value=HM1 );
			
			
				var M2B=	  parseFloat(document.getElementById(\"FormI\").elements[\"M2\"].value) ;  
				var H2B=      parseFloat(document.getElementById(\"FormI\").elements[\"H2\"].value) ; 
								 var hours2 = H2B;
								 var nbminuteRestante2 = (M2B / 60);
								 var HM2 = hours2 + nbminuteRestante2 ;
								parseFloat(document.getElementById(\"FormI\").elements[\"T2\"].value=HM2 );
			
				
			
				var M4B=   parseFloat(document.getElementById(\"FormI\").elements[\"M4\"].value); 
				var H4B=   parseFloat(document.getElementById(\"FormI\").elements[\"H4\"].value) ; 
								 var hours4 = H4B;
								 var nbminuteRestante4 = (M4B / 60);
								 var HM4 = hours4 + nbminuteRestante4 ;
								parseFloat(document.getElementById(\"FormI\").elements[\"DECH\"].value=HM4 );
			 
				var M5B=   parseFloat(document.getElementById(\"FormI\").elements[\"M5\"].value) ;  
				var H5B=   parseFloat(document.getElementById(\"FormI\").elements[\"H5\"].value) ; 
								 var hours5 = H5B;
								 var nbminuteRestante5 = (M5B / 60);
								 var HM5 = hours5 + nbminuteRestante5 ;
								parseFloat(document.getElementById(\"FormI\").elements[\"BRIC\"].value=HM5 );
			
				var M6B=   parseFloat(document.getElementById(\"FormI\").elements[\"M6\"].value) ; 
				var H6B=   parseFloat(document.getElementById(\"FormI\").elements[\"H6\"].value) ; 
								 var hours6 = H6B;
								 var nbminuteRestante6 = (M6B / 60);
								 var HM6 = hours6 + nbminuteRestante6 ;
								parseFloat(document.getElementById(\"FormI\").elements[\"VITR\"].value=HM6 );
			
				var M7B=   parseFloat(document.getElementById(\"FormI\").elements[\"M7\"].value) ; 
				var H7B=   parseFloat(document.getElementById(\"FormI\").elements[\"H7\"].value) ; 
								 var hours7 = H7B;
								 var nbminuteRestante7 = (M7B / 60);
								 var HM7 = hours7 + nbminuteRestante7 ;
								parseFloat(document.getElementById(\"FormI\").elements[\"COURSES\"].value=HM7 );
			
			
							}
								
					function CalculHeure()
								 {
    var minutes = parseFloat(document.getElementById(\"FormI\").elements['TOTAL'].value) * 60;
    var hours = parseInt(minutes / 60);
	var nbminuteRestante = (minutes % 60);
    document.getElementById(\"FormI\").elements[\"TOTALH\"].value = hours;
    document.getElementById(\"FormI\").elements[\"TOTALHM\"].value = nbminuteRestante;
                    				}	

			
								

	</script>";
	
	return $vretour;
}

public function Afficher_EM_Interventions()  {


	
	if (isset ($_POST['RappelDIntervCE'])){$NINTERV = $_POST['RappelDInterv'];}
    else if (isset ($_POST['NINTERV'])){$NINTERV  = $_POST["NINTERV"] ;}
	else {$NINTERV= 0;}	if (isset ($_POST['facture'])){$facture = $_POST['facture'];} Else {$facture= '-1';}
	if (isset ($_POST['listeclients'])){$Client = $_POST["listeclients"]; } Else {$Client= $this->les_clients('required','listeclients') ;}
	if (isset ($_POST['listeemployes'])){$Employe = $_POST["listeemployes"];} Else {$Employe= '';}
	
	
	if (isset ($_POST['T1'])){$T1 = $_POST["T1"];} Else {$T1= 0;}
	if (isset ($_POST['T2'])){$T2 = $_POST["T2"];} Else {$T2= 0;}
	if (isset ($_POST['DESH'])){$DESH = $_POST["DESH"];} Else {$DESH= 0;}
	if (isset ($_POST['DECH'])){$DECH = $_POST["DECH"];} Else {$DECH= 0;}
	if (isset ($_POST['BRIC'])){$BRIC = $_POST["BRIC"];} Else {$BRIC= 0;}
	if (isset ($_POST['VITR'])){$VITR = $_POST["VITR"];} Else {$VITR= 0;}
	if (isset ($_POST['COURSES'])){$COURSES = $_POST["COURSES"];} Else {$COURSES=0;}
	if (isset ($_POST['PULVERISATEUR'])){$PULVERISATEUR = $_POST["PULVERISATEUR"];} Else {$PULVERISATEUR= 0;}
	if (isset ($_POST['TOTAL'])){$TOTAL = $_POST["TOTAL"];} Else {$TOTAL= 0;}
	if (isset ($_POST['NomC'])){$NomC = $_POST['NomC'];} Else {$NomC = '';}
	
	if (isset ($_POST['NomE'])){$NomE = $_POST['NomE'];} Else {$NomE = '';}
	if (isset ($_POST['PrenomE'])){$PrenomE = $_POST['PrenomE'];} Else {$PrenomE = '';}
	
	if (isset ($_POST['CodeC'])){$CodeC = $_POST['CodeC'];} Else {$CodeC = '';}
	if (isset ($_POST['CodeE'])){$CodeE = $_POST['CodeE'];} Else {$CodeE = '';}
	if (isset ($_POST['CodeEI'])){$CodeEI = $_POST['CodeEI'];} Else {$CodeEI = '';}
	

	
	if (isset ($_POST['Date'])){
		$jour='';
		$mois='';
		$annee='';
		$Date= $_POST['Date'];
	}
	elseif (isset ($_POST['jour']) && isset ($_POST['mois']) && isset ($_POST['annee']))
	   {
	
	if ($_POST['jour']<10)
	{$jour = '0'.$_POST['jour'];}
	else { $jour = $_POST['jour'];}
	
	if ($_POST['mois']<10)
	{$mois = '0'.$_POST['mois'];}
	else { $mois = $_POST['mois'];}
	
	$annee = $_POST['annee'];
	$Date = $jour.'/'.$mois.'/'.$annee;
		}
	
	else {$jour='';
		  $mois='';
		  $annee='';
		  $Date = $this->AfficheDate(date('Y-m-d'));
	     }
	
	$vretour= "
	<input type='hidden' name='jour' value=$jour>
	<input type='hidden' name='mois' value=$mois>
	<input type='hidden' name='annee' value=$annee>
	
	
	
	<li>
	
	<label>Numéro :</label>
		
	<center>";
		if ((!isset ($_POST['NINTERV']))&&(!isset ($_POST['RappelDIntervCE'])))
		{
			$vretour= $vretour."<input type=\"text\" name=\"NumI\" id=\"NumI\" readonly='true'  class=\"validate[required] \" value=\"".$this->dernier_NINTERV()."\" /> <br />";
		}
		else if ((isset ($_POST['NINTERV']))||(isset ($_POST['RappelDIntervCE'])))
		{
			$vretour= $vretour."<input type=\"text\" name=\"NumI\" id=\"NumI\" readonly='true'  class=\"validate[required] \" value=\"".$NINTERV."\" /> <br />";
		}
		$vretour= $vretour."<center>
							</li>
							<li>
								<label>Client :</label>";
		if(isset ($_POST['RappelDIntervCE']))
		{
			$reqrap = "SELECT * FROM INTERVENTIONS WHERE NINTERV = $NINTERV ; ";
			$resultrap = $this->connexion->query($reqrap);
			while($R = $resultrap->fetch(PDO::FETCH_OBJ))
			{
				$Date = $this->AfficheDate($R->DATE);
				$T1 = $R->T1;
				$T2 = $R->T2;
				$DESH = $R->DESH;
				$DECH = $R->DECH;
				$BRIC = $R->BRIC;
				$VITR = $R->VITR;
				$COURSES = $R->COURSES;
				$PULVERISATEUR = $R->PULVERISATEUR;
				$TOTAL = $R->TOTAL;
					
			}
			$resultrap->closeCursor();
		}

		if ((!empty ($_POST['CodeC'])) )
		{$vretour=$vretour.$this->les_clients('required','listeclients');}

		if (!empty ($_POST['CodeCI']))
		{$vretour=$vretour.$this->les_clients2('required','listeclients');}

		if (empty ($_POST['CodeCI']) && empty ($_POST['CodeC'])){
			$vretour=$vretour.$this->les_clients('required','listeclients');}
				
				
			$vretour=$vretour. "
							</li>
							<li>
								<label>Employé(e) :</label>";
								if (!empty ($_POST['CodeE']))
										{$vretour=$vretour.utf8_encode($this->les_employes('required','listeemployes'));}
								if (!empty ($_POST['CodeEI']))
										{$vretour=$vretour.utf8_encode($this->les_employes2('required','listeemployes'));}
								if (empty ($_POST['CodeEI']) && empty ($_POST['CodeE'])){
									$vretour=$vretour.utf8_encode($this->les_employes('required','listeemployes'));}
								$vretour=$vretour. "	
								</li>
	
									<label>Date :</label>
									<center>
									<input type=\"text\"  name=\"Date\"  class=\"validate[required] text-input datepicker\" value='$Date' />
									</center>
									<li>
									<label>Avec/sans outillage :</label>
									
									<span id='Heures'><input type='number' step='0.25' min='0' name=\"T1\"  autofocus onfocus=\"calculTOTAL(),calculMinute(),CalculHeure()\" Onchange=\"calculTOTAL(),calculMinute(),CalculHeure()\"  value='$T1' class=\"validate[required,custom[numberP]]\"  />
									Heure(s)</span>
									<span id='EQA'>équivaut à :</span> 
									<span id='HeuresMinutes'><input type='number'  min='0' step='1' name=\"H1\"    Onchange=\"calculDecimal(),calculTOTAL(),CalculHeure()\" value=\"0\" class=\"validate[required,custom[numberP]]\" />
									H
									<input type='number' min='0' max='59' step='15' name=\"M1\"    Onchange=\"calculDecimal(),calculTOTAL(),CalculHeure()\" value=\"0\" class=\"validate[required,custom[numberP]]\" />
									Min</span>
									
									</li>
									<li>
									<label>Outillage thermique :</label>
									<span id='Heures'>
									<input type='number' step='0.25' min='0' name=\"T2\"  Onchange=\"calculTOTAL(),calculMinute(),CalculHeure()\" value='$T2' class=\"validate[required,custom[numberP]]\"  />
									Heure(s)</span>
									<span id='HeuresMinutes'>
									<input type='number'   min='0' step='1' name=\"H2\"    Onchange=\"calculDecimal(),calculTOTAL(),CalculHeure()\" value=\"0\" class=\"validate[required,custom[numberP]]\" />
									H
									<input type='number'  min='0' max='59' step='15' name=\"M2\"    Onchange=\"calculDecimal(),calculTOTAL(),CalculHeure()\" value=\"0\" class=\"validate[required,custom[numberP]]\" />
									Min
									</span>
									</li>
								
									<li>
									<label>Déchetterie :</label>
									<span id='Heures'>
									<input type='number' step='0.25' min='0' name=\"DECH\" Onchange=\"calculTOTAL(),calculMinute(),CalculHeure()\" value='$DECH' class=\"validate[required,custom[numberP]]\"  />
									Heure(s)</span>
									<span id='HeuresMinutes'>
									<input type='number'  min='0' step='1' name=\"H4\"    Onchange=\"calculDecimal(),calculTOTAL(),CalculHeure()\" value=\"0\" class=\"validate[required,custom[numberP]]\" / >
									H
									<input type='number'  min='0' max='59' step='15' name=\"M4\"    Onchange=\"calculDecimal(),calculTOTAL(),CalculHeure()\" value=\"0\" class=\"validate[required,custom[numberP]]\" />
									Min
									</span>
									</li>
									<li>
									<label>Bricolage :</label>
									<span id='Heures'>
									<input type='number' step='0.25' min='0' name=\"BRIC\"   Onchange=\"calculTOTAL(),calculMinute(),CalculHeure()\" value='$BRIC' class=\"validate[required,custom[numberP]]\" />
									Heure(s)</span>
									<span id='HeuresMinutes'>
									<input type='number' min='0' step='1' name=\"H5\"    Onchange=\"calculDecimal(),calculTOTAL(),CalculHeure()\" value=\"0\" class=\"validate[required,custom[numberP]]\" />
									H
									<input type='number' min='0' max='59' step='15' name=\"M5\"    Onchange=\"calculDecimal(),calculTOTAL(),CalculHeure()\" value=\"0\" class=\"validate[required,custom[numberP]]\" />
									Min
									</span>
									</li>
									<li>
									<label>Vitrerie :</label>
									<span id='Heures'>
									<input type='number' step='0.25' min='0' name=\"VITR\"  Onchange=\"calculTOTAL(),calculMinute(),CalculHeure()\" value='$VITR' class=\"validate[required,custom[numberP]]\"  />
									Heure(s)</span>
									<span id='HeuresMinutes'>
									<input type='number'  min='0' step='1' name=\"H6\"    Onchange=\"calculDecimal(),calculTOTAL(),CalculHeure()\" value=\"0\" class=\"validate[required,custom[numberP]]\" />
									H
									<input type='number'  min='0' max='59' step='15' name=\"M6\"    Onchange=\"calculDecimal(),calculTOTAL(),CalculHeure()\" value=\"0\" class=\"validate[required,custom[numberP]]\" />
									Min
									</span>
									</li>
									<li>
									<label>Courses :</label>
									<span id='Heures'>
									<input type='number' step='0.25' min='0' name=\"COURSES\"  Onchange=\"calculTOTAL(),calculMinute(),CalculHeure()\" value='$COURSES' class=\"validate[required,custom[numberP]]\"  />
									Heure(s)</span>
									<span id='HeuresMinutes'>
									<input type='number'  min='0' step='1' name=\"H7\"    Onchange=\"calculDecimal(),calculTOTAL(),CalculHeure()\" value=\"0\" class=\"validate[required,custom[numberP]]\" />
									H
									<input type='number'  min='0' max='59' step='15' name=\"M7\"    Onchange=\"calculDecimal(),calculTOTAL(),CalculHeure()\" value=\"0\" class=\"validate[required,custom[numberP]]\" />
									Min
									</span>
									</li>
								
									<br>
									<li>
									<label><b>TOTAL :</b></label>
									<span id='Heures'>
									<input type=\"varchar\" style='width:5%;'  name=\"TOTAL\" value='$TOTAL' READONLY='true' />
									<b>Heure(s)</b>
									</span>
										
									<span id='HeuresMinutes'>
									<input type=\"varchar\" style='width:5%;' name=\"TOTALH\"  value='0' READONLY='true' /> <b>H</b>
									<input type=\"varchar\" style='width:5%;'name=\"TOTALHM\"  value='0' READONLY='true' /> <b>Min</b>
									</span>
									</li>
									<br>
									<li>
									<label>Pulvérisateur :</label>
									<span id='Heures2'>
									<input type='number' step='1' min='0' name=\"PULVERISATEUR\"   Onchange=\"calculTOTAL(),calculMinute(),CalculHeure()\" value='$PULVERISATEUR' class=\"validate[required,custom[numberP]]\" />
									</span>
									
									</li>
									
										<li>
									<label>Desherbant :</label>
									<span id='Heures2'>
									<input type='number' step='1' min='0' name=\"DESH\"  Onchange=\"calculTOTAL(),calculMinute(),CalculHeure()\"   value='$DESH' class=\"validate[required,custom[numberP]]\" />
									</span>
									
									</li>
									<li>
									
									"
											
								;
	return $vretour;
}
public function Afficher_modifier_Interventions() {

	$b = $this->SCRIPT();
	$b = $b."
		<ul id='navigation'  class='nav-main'>
			<section>
				<article>
					<center>
						<h2> Modifications des interventions</h2>
					</center><br>
					<center>
						<form method='POST' id='FormI'  name='FormI' action='Ex_modif_intervention.php'>
					";
	$b=$b. $this->Afficher_EM_Interventions();
	$b = $b. "			
	         		<center><br>
	         					<input type='submit' name='ValidFormMI' value='Modifier'>
								
	         		
	         				
	   					</form>
			<form method='POST' id='FormIS'  name='FormIS' action='Ex_supp_intervention.php'>
			<input type='submit' name='ValidFormS' value='Supprimer'>
			</form>
			</center>
					</center>
	    	    </article>
	    	</section>
		</ul>";
	return $b;
}


public function Afficher_supprimer_Interventions() {

	$b = $this->SCRIPT();
	$b = $b."
		<ul id='navigation'  class='nav-main'>
			<section>
				<article>
					<center>
						<h2> supprimer des interventions</h2>
					</center><br>
					<center>
						<form method='POST' id='FormI'  name='FormI' action='Ex_supp_intervention.php'>
					";
	$b=$b. $this->Afficher_EM_Interventions();
	$b = $b. "
	         		<center><br>
	         					<input type='submit' name='ValidFormMI' value='Modifier'>



	   					</form>
			<form method='POST' id='FormIS'  name='FormIS' action='Ex_supp_intervention.php'>
			<input type='submit' name='ValidFormS' value='Supprimer'>
			</form>
			</center>
					</center>
	    	    </article>
	    	</section>
		</ul>";
	return $b;
}






public function Afficher_derniere_intervention()
{
	$vretour = 'Erreur';
	$vretour = $this->SCRIPT();
	$vretour = $vretour."
		<ul id='navigation'  class='nav-main'>
			<section>
				<article>
					<center>
						<h2> Modifications des interventions</h2>
					</center><br>
					<center>
						<form method='POST' id='FormI'  name='FormI' action='Ex_modif_intervention.php'>
					";
	$vretour=$vretour. $this->Afficher_EM_Interventions();
	$vretour = $vretour. "
	         		<center>
	         					<input type='submit' name='ValidFormMI' value='Modifier'>
							
	         		</center>
	         				<span><br><br>
	   					</form>
		
					</center>
	    	    </article>
	    	</section>
		</ul>";
	return $vretour;
}




public function enregistrer_interventions() {
	
	//$DateA = date('Y-m-d');
	//$DateA = date('d-m-Y');
	
	
	$b = $this->SCRIPT();
	$b = $b." 
		<ul id='navigation'  class='nav-main'>
			<section>
				<article>
					<center>
						<h2> Enregistrements des interventions</h2>
					</center><br>
					<center>
						<form method='POST' name='FormI' id='FormI'  action='Modif_interventions.php'>				
					";
	$b=$b. $this->Afficher_EM_Interventions();
	$b = $b. "			
			<input type='hidden' value='listeclients'
	         		<center><br>
			
	         					<input type='submit' name='ValidFormI' value='Enregistrer'>
	         		</center>
	         				<span><br><br>		
	   					</form>
					
					</center>
	    	    </article>
	    	</section>
		</ul>";
	return $b;	
}

public function choisir_date()
{
	if (isset ($_POST['DateD']) && isset ($_POST['DateF'])){
	$DateD = $_POST['DateD'];
	$DateF = $_POST['DateF'];}
	Else {
	$DateD = $this->AfficheDate(date('Y-m-d'));
	$DateF = $this->AfficheDate(date('Y-m-d'));
	}
    $parametre = "Optionnal"; 
	$a="
			<ul id='navigation'  class='nav-main'>
				<section>
				
					<article>
						<center>
							<h2>Sélection d'intervention(s)</h2>
								<form method='POST' id='FormCDI' name='FormCDI' action='ListeInterventions.php'>
		<label>Date début :</label>
		<input  type='text'  name='DateD' id='DateD'  value='$DateD' class='validate[optionnal] text-input datepicker'/> 
		<br><br>
		<label>Date fin :</label>
		<input type=\"text\" name=\"DateF\" id=\"DateF\"   class=\"validate[optionnal] text-input datepicker\" value='$DateF' /> 
		<br><br><br>
		<label>Clients :</label>".utf8_encode($this->les_clients2($parametre,'listeclients4'))."<br><label>Employé(es) :</label>".utf8_encode($this->les_employes2($parametre,'listeemployes4'))."
		<br>	
				
				<input type='submit' id='input' name='ValidFormCDI' value='Rechercher'>
			 	
								</form>
						    	<span><br>
							</center>
		                </article>
		            </section>
			</ul>
			";
	$a= $a."<ul id='navigation' class='nav-main'><br><input type='button' value='Retour' onClick=\"javascript:document.location.href='Clients.php'\"/><br> <br></ul>";
	return $a;
}

public function affiche_Excel()
{
	
	$DateD = $_POST['DateD'];
	$DateF = $_POST['DateF'];
	header("Content-type: application/msexcel; charset=Windows-1252");
	header ("Content-Disposition: attachment; filename=Excel_$DateD \ $DateF.xls");
	
        if (isset ($_POST['listeclients2'])){
		$listeclients =  $_POST['listeclients2'];}
		else $listeclients='';
		
		if (isset ($_POST['listeemployes2'])){
		$listeemployes =  $_POST['listeemployes2'];}
		else $listeemployes='';

		if (!empty ($listeclients) && empty ($listeemployes))
		{
			$result = $this->les_interventions_date_clients();
		}
		if (!empty ($listeemployes) && empty ($listeclients))
		{
			$result = $this->les_interventions_date_employes();
		}
	   if (!empty ($listeclients) && !empty ($listeemployes))
	    {
        	$result = $this->les_interventions_date_employes_clients();
		}
		if (empty ($listeclients) && empty ($listeemployes))
		{
			$result = $this->les_interventions_date();
	
		}
		if (!empty ($listeclients) && !empty ($listeemployes) && empty ($_POST['DateD']) && empty ($_POST['DateF']))
		{
			$result = $this->les_interventions_employes_clients();
		}
		
		if (!empty ($listeclients) && empty ($listeemployes) && empty ($_POST['DateD']) && empty ($_POST['DateF']))
		{
			$result = $this->les_interventions_clients();
		}
		
		if (empty ($listeclients) && !empty ($listeemployes) && empty ($_POST['DateD']) && empty ($_POST['DateF']))
		{
			$result = $this->les_interventions_employes();
		}
		
		if (empty ($listeclients) && empty ($listeemployes) && empty ($_POST['DateD']) && empty ($_POST['DateF']))
		{
			$result = $this->les_interventions();
		}
		
		
	
	$a='';
	if ( !$result)
	{   $a=$a."<p>Aucune interventions enregistrer</p>";  }
	else
	{
		$TotalDutotal='0';
		$TotalT1 = '0';
		$TotalT2 = '0';
		$TotalDESH = '0';
		$TotalDECH = '0';
		$TotalBRIC = '0';
		$TotalVITR = '0';
		$TotalCOURSES = '0';
		$TotalPULVERISATEUR = '0';
		$a=$a. "<center><table border='1'><tr><th>CLIENTSAGE</th><th>CLIENTS.Nom</th><th>Adresse</th><th>COMPLEMENT</th><th>CODE POSTAL</th><th>COMMUNE</th><th>Date</th><th>NUMEMPLSAGE</th><th>EMPLOYES.Nom</th><th>T1</th><th>T2</th><th>DECH</th><th>BRIC</th><th>VITR</th><th>COUR</th><th>TOTAL</th><th>PULVE</th><th>DESH</th></tr>";
		$nb = $result->rowCount();
		while ($donnees = $result->fetch(PDO::FETCH_OBJ))
		{
			
			if ($donnees->facture==1)
			{ $donnees->facture='Oui'; }
			Else
			{ $donnees->facture='Non';}
			
			if ($donnees->TOTAL=='0')
			{
				$donnees->TOTAL= $donnees->T1 + $donnees->T2  + $donnees->DECH + $donnees->BRIC + $donnees->VITR + $donnees->COURSES ;
			}
			if ($donnees->TOTAL=='')
			{
				$donnees->TOTAL= $donnees->T1 + $donnees->T2  + $donnees->DECH + $donnees->BRIC + $donnees->VITR + $donnees->COURSES ;
			}
			// Remplacer les valeurs Varchar en Int, directement en changeant le point en virgules, pour le excel.
			$T1 = floatval($donnees->T1);
			$T1a = explode('.',$T1);
			if (isset ($T1a[1]) ){
			$T11 = $T1a[0].','.$T1a[1];}
			Else { $T11 = $T1a[0];}
			
			$T2 = floatval($donnees->T2);
			$T2a = explode('.',$T2);
			if (isset ($T2a[1]) ){
			$T21 = $T2a[0].','.$T2a[1];}
			Else { $T21 = $T2a[0];}
			
			$DESH = floatval($donnees->DESH);
			$DESHa = explode('.',$DESH);
			if (isset ($DESHa[1]) ){
			$DESH1 = $DESHa[0].','.$DESHa[1];}
			Else { $DESH1 = $DESHa[0];}
			
			$DECH = floatval($donnees->DECH);
			$DECHa = explode('.',$DECH);
			if (isset ($DECHa[1]) ){
			$DECH1 = $DECHa[0].','.$DECHa[1];}
			Else { $DECH1 = $DECHa[0];}
				
			$BRIC = floatval($donnees->BRIC);
			$BRICa = explode('.',$BRIC);
			if (isset ($BRICa[1]) ){
			$BRIC1 = $BRICa[0].','.$BRICa[1];}
			Else { $BRIC1 = $BRICa[0];}
				
			$VITR = floatval($donnees->VITR);
			$VITRa = explode('.',$VITR);
			if (isset ($VITRa[1]) ){
			$VITR1 = $VITRa[0].','.$VITRa[1];}
			Else { $VITR1 = $VITRa[0];}
			
			$COURSES = floatval($donnees->COURSES);
			$COURSESa = explode('.',$COURSES);
			if (isset ($COURSESa[1]) ){
			$COURSES1 = $COURSESa[0].','.$COURSESa[1];}
			Else { $COURSES1 = $COURSESa[0];}
			
			$PULVERISATEUR = floatval($donnees->PULVERISATEUR);
			$PULVERISATEURa = explode('.',$PULVERISATEUR);
			if (isset ($PULVERISATEURa[1]) ){
			$PULVERISATEUR1 = $PULVERISATEURa[0].','.$PULVERISATEURa[1];}
			Else { $PULVERISATEUR1 = $PULVERISATEURa[0];}
			
			$TOTAL = floatval($donnees->TOTAL);
			$TOTALa = explode('.',$TOTAL);
			if (isset ($TOTALa[1]) ){
			$TOTAL1 = $TOTALa[0].','.$TOTALa[1];}
			Else { $TOTAL1 = $TOTALa[0];}
			
			$a=$a. "<tr>	
			<td >" .utf8_encode ($donnees->CLIENTSAGE)."</td>
			<td >" .utf8_encode ($donnees->NOM)."</td>
			<td >" .utf8_encode ($donnees->ADRESSE)."</td>
			<td >" .utf8_encode ($donnees->COMPLEMENT)."</td>
			<td >" .utf8_encode ($donnees->CODEPOSTAL)."</td>
			<td >" .utf8_encode ($donnees->COMMUNE)."</td>
			<td> " .utf8_encode ($donnees->jour / $donnees->mois / $donnees->annee)."</td>
			<td >".utf8_encode ($donnees->NUMEMPLSAGE)."</td>
			<td> ".utf8_encode ($donnees->Nom)."</td>
			<td > ".utf8_encode ($T11)."</td>
			<td >" .utf8_encode ($T21)."</td>
			
			<td > ".utf8_encode ($DECH1)."</td>
			<td > ".utf8_encode ($BRIC1)."</td>
			<td > ".utf8_encode ($VITR1)."</td>
			<td > ".utf8_encode ($COURSES1)."</td>
			
			<td > ".utf8_encode ($TOTAL1)."</td>
			<td > ".utf8_encode ($PULVERISATEUR1)."</td>
			<td > ".utf8_encode ($DESH1)."</td>
			</tr>";
			
			$nb1 = 0;
			while ($nb1<=$nb)
		    {
		    $nb1++;
		   
			$TotalT1 =  'SOMME(J2:J'.$nb1.')';
			$TotalT2 = 'SOMME(K2:K'.$nb1.')';
			$TotalDECH = 'SOMME(L2:L'.$nb1.')';
			$TotalBRIC = 'SOMME(M2:M'.$nb1.')';
			$TotalVITR = 'SOMME(N2:N'.$nb1.')';
			$TotalCOURSES = 'SOMME(O2:O'.$nb1.')';
			
			$TotalDutotal = 'SOMME(P2:P'.$nb1.')';
			
			$TotalPULVERISATEUR = 'SOMME(Q2:Q'.$nb1.')';
			$TotalDESH = 'SOMME(R2:R'.$nb1.')';
			}
			
			
		}				
		
		$a=$a."<tr ><td colspan='9' style='font-weight: bold; ' style='text-align:right;'>Total Heure : </td><td style='font-weight: bold; '>=$TotalT1</td><td style='font-weight: bold; '>=$TotalT2</td>
		<td style='font-weight: bold; '>=$TotalDECH</td><td style='font-weight: bold; '>=$TotalBRIC</td><td style='font-weight: bold; '>=$TotalVITR</td><td style='font-weight: bold; '>=$TotalCOURSES</td><td style='font-weight: bold; '>=$TotalDutotal</td><td style='font-weight: bold; '>=$TotalPULVERISATEUR</td><td style='font-weight: bold; '>=$TotalDESH</td></tr>";
		}
	
		$a=$a."</table></center>";
		utf8_encode ($a);
		return $a;
}


	}
	
	
	
	