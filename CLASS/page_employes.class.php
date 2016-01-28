
<?php


session_start();


if (!isset ($_SESSION['login']))
{
	header("Location: index.php");
}
class page_employes extends page_base {
	private $connexion;
	private $PDO;

	public function __construct($p) {
		parent::__construct($p);

		$this->PDO=New PDO_MS();
		$this->PDO->connexion("menuservice");
		$this->connexion=$this->PDO->connexion;
	}
	
	

	public function insertion_employe()
	{
		if (isset($_POST['AncienneteEmploye']))
		{
			$AncienneteEmploye='1';
		}
		Else $AncienneteEmploye='0';
	
		$NomEmploye = $this->connexion -> quote($_POST['NomEmploye']) ;
		$PrenomEmploye = $this->connexion -> quote($_POST['PrenomEmploye']) ;
		
		$RequeteMax=$this->connexion->query("SELECT MAX(EmplSage)+1 as MAX FROM employes;");
		$max_row = $RequeteMax->fetch(PDO::FETCH_ASSOC);
		$max = $max_row['MAX'];
		
		
		$RequeteIncrement="ALTER TABLE  `employes` AUTO_INCREMENT =".$max.";";
		$ExecuteIncrement=$this->connexion -> exec($RequeteIncrement);
		
		$requete="insert into employes (Nom,Prenom,`ANCIEN_EMPLOYE`) VALUES(".$NomEmploye.",".$PrenomEmploye.",".$AncienneteEmploye.")";
		$nblignes=$this->connexion -> exec($requete);
		
		
		$dataIR ="alert('Insertion réussie')";
		
			if ($nblignes !=1)
			{
				echo "<script>alert('Insertion impossible')</script>";
				
			}
			else
			{
				echo "<script>$dataIR\n";
			    echo "document.location = ('Employes.php')";
			    echo "</script>";
				$result = null;
			}
			
	}

	public function modifier_employe()
	{
	
		$EmplSage  = $_POST["EmplSage"] ;
		$NomEmploye = $_POST["Nom"];
		$PrenomEmploye = $_POST["Prenom"];
	
		if (isset($_POST['ANCIEN_EMPLOYE']))
		{
			$AncienneteEmploye='1';
		}
		Else $AncienneteEmploye='0';
		
	
		$requete="update employes set Nom='$NomEmploye', Prenom='$PrenomEmploye',`ANCIEN_EMPLOYE`=$AncienneteEmploye where EmplSage=$EmplSage";
		$nblignes=$this->connexion -> exec($requete);
		$dataMR = "alert('Modification réussie')"; //$dataMR = utf8_encode("alert('Modification réussie')");
		
		if ($nblignes !=1)
		{
			echo "<script>alert('Modification impossible')</script>";
		}
		else
		{	
			
			echo "<script>$dataMR\n";
			echo "document.location = ('Employes.php')";
			echo "</script>";
			$result = null;
		}
			
	}
	
	public function supprimer_employe()
	{
	
		$EmplSage  = $_POST["EmplSage"] ;
	
		$requete="delete employes FROM employes where EmplSage=$EmplSage";
		$nblignes=$this->connexion -> exec($requete);
		$dataSI = utf8_encode("alert('Supression impossible, cette employé(e) est lié(e) une intervention')");
		$dataSR = utf8_encode("alert('Supression réussie')");
		if ($nblignes !=1)
		{
			echo "<script>$dataSI</script>";
		}
		else
		{
			
			echo "<script>$dataSR\n";
			echo "document.location = ('Employes.php')";
			echo "</script>";
			$result = null;
		}
			
	}
	
	public function les_employes()
	{
		$req = "Select * From employes";
		$res = $this->connexion->query($req);
		return $res;
	}
	
	public function affiche_employes() {
		
	if (isset ($_POST["HiddenAE"]))
	{
		$CCA  = $_POST["HiddenAE"];
	}
	else {	
		$CCA = '0';
     	}

     	if ($CCA=='0')
     	{
		$a="<ul id='navigation' class='nav-main'><h2>Employés en activité  : </h2>";
     	}
     	else {
     		$a="<ul id='navigation' class='nav-main'><h2>Anciens salariés : </h2>";
     	}
     	
		$result = $this->les_employes();
	
		
		if ( !$result)
		{   $a=$a."<p>Aucun employés enregistrer</p>";  }
		else
		{
			
			$a=$a. "<center><table border='1'><tr><th>Numéro</th><th>Nom</th><th>Prénom</th><th>Ancien</th></tr>";

		
			
						
			while ($donnees = $result->fetch(PDO::FETCH_OBJ))
			{
				if ($donnees->ANCIEN_EMPLOYE==$CCA)
				{
				
				$ScriptCB1="<script type='text/javascript'>
						function cbChange(element)
						{
    						if(element.checked) 
      							element.value='1';
   							 else
    							  element.value='0';
						}
						</script>";
				
				if ($donnees->ANCIEN_EMPLOYE=='1')
				{
					$InputCB1=$ScriptCB1."<input type='checkbox'   name='ANCIEN_EMPLOYE' checked onClick='cbChange(this)' value='1' >";
					
					
				}
				Else if ($donnees->ANCIEN_EMPLOYE=='0')
				{
					
					$InputCB1=$ScriptCB1."<input type='checkbox'   name='ANCIEN_EMPLOYE' onClick='cbChange(this)' value='0'>";
				}
				
				$dataP = $donnees->Prenom;
				$dataN = $donnees->Nom;
				
				
				$a=$a. "
						

						<form method='POST' id='FormEC' name='FormEC'  action='Employes.php#Liste'><tr>		
				       <tr>
			    <td><input type='text'  id='FormEC' READONLY='true' name='EmplSage' value=".$donnees->EmplSage."></td>
				<td><input type='text'  id='FormEC'class=\"validate[required,custom[onlyLetterSpE],length[0,100]] text-input \" name='Nom' value=".$dataN."></td>
				<td><input type='text' id='FormEC' class=\"validate[required,custom[onlyLetterSpE],length[0,100]] text-input \" name='Prenom' value= ".$dataP."></td>
				<td>$InputCB1</td>
				
				<td><input type='submit' name='ValidFormModC' value='Modifier' ></td>
				
				
						</tr>
						</form>"; 
				
					 
			}
			
			}
				
			}
			$result -> closeCursor();
			$a=$a."</table></center><br>";
			
			if ($CCA=='0')
			{
				$a=$a."
				<form method='POST' id='FormAE' name='FormAE'  action='Employes.php#Liste'>
				<input type='hidden' name='HiddenAE' value='1'>
				<input type='submit' name='ValidFormAE' value='Anciens'><br>
				</form><br>";
					
			}
			
			if ($CCA=='1')
			{
				$a=$a."
				<form method='POST' id='FormAE' name='FormAE'  action='Employes.php#Liste'>
				<input type='hidden' name='HiddenAE' value='0'>
				<input type='submit' name='ValidFormAE' value='Actuels'><br>
				</form><br>";
					
			}
			
			$a=$a."</ul>";
		$result=null;
 
		return $a;
}


public function enregistrer_employes() {
	$b = "
	
	
		
		<ul id='navigation'  class='nav-main'>
				<section>
					<article>				
					
		<h2>Enregistrements des employés</h2>
			<form method='POST' id='FormE'  action='Employes.php'>
	
	
	<label>Nom :</label>
		<center>
	<input type=\"text\" class=\"validate[required,custom[onlyLetterSpE],length[0,100]] text-input \" name=\"NomEmploye\" id=\"NomEmploye\" value=\"\" /> <br />
		</center>
		<br>
	<label>Prénom :</label>
		<center>
	<input type=\"text\" class=\"validate[required,custom[onlyLetterSpE],length[0,100]] text-input \" name=\"PrenomEmploye\" id=\"PrenomEmploye\" value=\"\"/><br />
		</center>
		<br>
	
		<br>
	<input type='submit' class='submit' id='inputE' name='validform' value='Enregistrer'>
	   
						
			</form><span><br>
				
	                </article>
	            </section>
		</ul>

		";
	return $b;
	
}

public function choisir_employe (){
	$vretour = "
						
			<ul id='navigation' class='nav-main'>
				<section>
					<article>
						<br><form id='formchoisiremployes' method='POST' action='EmployesHeures.php' > ";
	$result = $this->les_employes();
	if(isset($result)){
		
		$vretour= $vretour."
				<center><h2>Heures des employés :</h2> 	
							<br>    <input type='radio' name='datedet' id='datedet' value='datedet' required> Jour <br>
			Du	<input type=\"text\" name=\"DateD\" id=\"DateD\"   class=\"validate[optionnal] text-input datepicker\"  />  au 
				<input type=\"text\" name=\"DateF\" id=\"DateF\"   class=\"validate[optionnal] text-input datepicker\"  /><br>
							   		<input type='radio' name='datedet' value='moisch'> Mois Complet	<br>
									<br><label>Mois : </label><select name='MoisemployesH' id='MoisemployesH'>
										<option value='VIDE'></option>
										<option value='01'>Janvier</option>
										<option value='02'>Février</option>
										<option value='03'>Mars</option>
										<option value='04'>Avril</option>
										<option value='05'>Mai</option>
										<option value='06'>Juin</option>
										<option value='07'>Juillet</option>
										<option value='08'>Aout</option>
										<option value='09'>Septembre</option>
										<option value='10'>Octobre</option>
										<option value='11'>Novembre</option>
										<option value='12'>Décembre</option>
									</select>
									
									<label>Année : </label><input type='number' name='AnneeemployesH' id='AnneeemployesH' value='2016' class='validate[required,custom[integer],minSize[4],maxSize[4]] text-input' >
									<br><br>
									<li>
									<label>Liste des employés : </label><select name='listeemployes' id='listeemployes'><option value='VIDE'></option>";
		while ($donnees = $result->fetch(PDO::FETCH_OBJ)) {
			if($donnees->ANCIEN_EMPLOYE == 0)
			{
				$vretour= $vretour.'<option value=' . $donnees->EmplSage. '>'. $donnees->Nom .' - ' . $donnees->Prenom. '</option>';
			}
		}
		$result->closeCursor ();
		$vretour = $vretour."</select>
							 </li>
							 <br><input type='submit' class='submit' value='OK'><br>	
							 </center>";
	}
	$vretour = $vretour."</form></article></section><br></ul>";
	
	return $vretour;
}

public function EmployesHeures(){	
	/*
	$annee = (date('Y', $date))-1;		
	$mois = date('m', $date);	//Récupération du mois
	$semaine = week('w',$date);	
	
	$requeteA = "SELECT * FROM INTERVENTIONS WHERE NUMEMPLSAGE = ".$_POST['listeemployes']." AND YEAR(DATE)='".$annee."';";
	$resultatA = $this->connexion->query($requeteA);
	
	$requeteM = "SELECT * FROM INTERVENTIONS WHERE NUMEMPKSAGE = ".$_POST['listeemployes']." AND YEAR(DATE)='".$annee."' AND MONTH(DATE)='".$mois."';";
	$resultatM = $this->connexion->query($requeteM);
	
	$requeteS = "SELECT * FROM INTERVENTIONS WHERE NUMEMPLSAGE = ".$_POST['listeemployes']." AND YEAR(DATE)='".$annee."' AND MONTH(DATE)='".$mois."' AND WEEK(DATE,3)='".$semaine."';";
	$resultatS = $this->connexion->query($requeteS);
	*/
	
	$vretour = '';
	$employe = array();
	$semaine = array();
	$moisT = array();	
	$nom = '';
	$prenom = '';
	$employeN ='';
	$semaineN = 0;
	$numeromois = 0;
	$mois='';
	$e = 0;
	$s = 0;
	$m =0;
	$T1 = 0;
	$T2 = 0;
	$DESH = 0;
	$DECH = 0;
	$BRIC = 0;
	$VITRE = 0;
	$COURSES = 0;
	$PULVE = 0;
	$heuremois = 0;
	$compteligne = 0;
	$dateD = 0 ;
	$dateF = 0 ;
	$rbDate = $_POST['datedet'];
	
	if ($rbDate == "datedet") 
	{
		$dateD = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['DateD'])));
		$dateF = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['DateF'])));
	}

		if($_POST['listeemployes'] == 'VIDE'){ //Si le choix est sans Employé
			//echo "<script>alert('Aucun employé selectionner'); document.location = ('Employes.php')</script>";
			$nom = "Liste";
			$prenom = "Complete";
			$reqsansemployes = '';
			if($_POST['MoisemployesH'] == 'VIDE' && $rbDate == "moisch"){
				//$reqsansemployes = "SELECT * ,YEAR(DATE) AS annee,MONTH(DATE) AS mois,WEEKOFYEAR(DATE) AS semaine FROM INTERVENTIONS AS I INNER JOIN EMPLOYES AS E ON I.NumEmplSage = E.EmplSage WHERE YEAR(DATE)='".$_POST['AnneeemployesH']."' ORDER BY mois ASC, semaine ASC,EmplSage ASC; ";
				$reqsansemployes = "SELECT * ,YEAR(DATE) AS annee,MONTH(DATE) AS mois,WEEKOFYEAR(DATE) AS semaine FROM INTERVENTIONS AS I INNER JOIN EMPLOYES AS E ON I.NumEmplSage = E.EmplSage WHERE YEAR(DATE)='".$_POST['AnneeemployesH']."' ORDER BY EmplSage ASC,mois ASC,semaine ASC; ";
				$_SESSION['MoisemployesH']=$_POST['MoisemployesH'];
			}
			elseif($rbDate == "moisch")
			{
				//$reqsansemployes = "SELECT * ,YEAR(DATE) AS annee,MONTH(DATE) AS mois,WEEKOFYEAR(DATE) AS semaine FROM INTERVENTIONS AS I INNER JOIN EMPLOYES AS E ON I.NumEmplSage = E.EmplSage WHERE YEAR(DATE)='".$_POST['AnneeemployesH']."' AND MONTH(DATE)='".$_POST['MoisemployesH']."' ORDER BY semaine ASC,mois DESC,EmplSage ASC; ";
				$reqsansemployes = "SELECT * ,YEAR(DATE) AS annee,MONTH(DATE) AS mois,WEEKOFYEAR(DATE) AS semaine FROM INTERVENTIONS AS I INNER JOIN EMPLOYES AS E ON I.NumEmplSage = E.EmplSage WHERE YEAR(DATE)='".$_POST['AnneeemployesH']."' AND MONTH(DATE)='".$_POST['MoisemployesH']."' ORDER BY EmplSage ASC,mois ASC,semaine ASC; ";
					
				$_SESSION['MoisemployesH']='';
			}
			elseif($rbDate == "datedet")
			{
				$reqsansemployes = "SELECT * ,YEAR(DATE) AS annee,MONTH(DATE) AS mois,WEEKOFYEAR(DATE) AS semaine FROM INTERVENTIONS AS I INNER JOIN EMPLOYES AS E ON I.NumEmplSage = E.EmplSage WHERE DATE BETWEEN '" . $dateD . "' AND '" . $dateF . "' ORDER BY EmplSage ASC,mois ASC,semaine ASC; ";
			}
			else 
			{
				$reqsansemployes = "SELECT * ,YEAR(DATE) AS annee,MONTH(DATE) AS mois,WEEKOFYEAR(DATE) AS semaine FROM INTERVENTIONS AS I INNER JOIN EMPLOYES AS E ON I.NumEmplSage = E.EmplSage WHERE DATE BETWEEN '$dateD' AND '$dateF' ORDER BY EmplSage ASC,mois ASC,semaine ASC; ";
			}
			$_SESSION['AnneeemployesH']=$_POST['AnneeemployesH'];
			$resultsansemployes = $this->connexion->query($reqsansemployes);

		
			while($donnees = $resultsansemployes->fetch(PDO::FETCH_OBJ)){
		
				$employe[] = $donnees->Nom;
				$semaine[] = $donnees->semaine;
				$moisT[] = $donnees->mois;
				if($e != 0){ $employeN = "".$employe[$e-1]."";} //Employé de l'enregistrement précedent.
				if($s != 0){ $semaineN = $semaine[$s-1];} //Semaine de l'enregistrement précedent.
				if($m != 0){ $numeromois = $moisT[$m-1];} //Mois de l'enregistrement précedent.
		
		
				$annee = $donnees->annee;
				if($e == 0){
					$T1 = $donnees->T1 ;
					$T2 = $donnees->T2 ;
					$DESH = $donnees->DESH ;
					$DECH = $donnees->DECH ;
					$BRIC = $donnees->BRIC;
					$VITRE = $donnees->VITR ;
					$COURSES = $donnees->COURSES ;
					$PULVE = $donnees->PULVERISATEUR;
				}
				else if((($employeN == $donnees->Nom)&&($semaineN == $donnees->semaine))&&($numeromois == $donnees->mois)){ //Si l'employe, la semaine et le mois reste identique.
						
					$T1 = $T1 + $donnees->T1 ;
					$T2 = $T2 + $donnees->T2 ;
					$DESH = $DESH + $donnees->DESH ;
					$DECH = $DECH + $donnees->DECH ;
					$BRIC = $BRIC + $donnees->BRIC;
					$VITRE = $VITRE + $donnees->VITR ;
					$COURSES = $COURSES + $donnees->COURSES ;
					$PULVE = $PULVE + $donnees->PULVERISATEUR;
				}
				else { //Sinon c'est que l'employe change ou la semaine ou le mois. Dans tous les cas il faudra donc afficher.
					if($numeromois == 1)
					{
						$mois = "<td> JANVIER ".$annee." </td>";
							
					}
					else if($numeromois == 2)
					{
						$mois = "<td> FÉVRIER ".$annee." </td>";
					}
					else if($numeromois == 3)
					{
						$mois = "<td> MARS ".$annee." </td>";
					}
					else if($numeromois == 4)
					{
						$mois = "<td> AVRIL ".$annee." </td>";
					}
					else if($numeromois == 5)
					{
						$mois = "<td> MAI ".$annee." </td>";
					}
					else if($numeromois == 6)
					{
						$mois = "<td> JUIN ".$annee." </td>";
					}
					else if($numeromois == 7)
					{
						$mois = "<td> JUILLET ". $annee." </td>";
					}
					else if($numeromois == 8)
					{
						$mois = "<td> AOÛT ". $annee." </td>";
					}
					else if($numeromois == 9)
					{
						$mois = "<td> SEPTEMBRE ".$annee." </td>";
					}
					else if($numeromois == 10)
					{
						$mois = "<td> OCTOBRE ".$annee." </td>";
					}
					else if($numeromois == 11)
					{
						$mois = "<td> NOVEMBRE ".$annee." </td>";
					}
					else if($numeromois == 12)
					{
						$mois = "<td> DÉCEMBRE ".$annee." </td>";
					}
					//	$total = $T1 + $T2 + $DECH + $DESH + $BRIC + $VITRE + $COURSES + $PULVE;
					$total = $T1 + $T2 + $DECH + $BRIC + $VITRE + $COURSES;
					$total1 = floatval($total);
					$totala = explode('.',$total1);
					number_format($heuremois, 4);
					if (isset ($totala[1]) ){
						$total2 = $totala[0].','.$totala[1];}
						Else { $total2 = $totala[0];}
						$vretour= $vretour."
											<tr>
												<td>".utf8_encode($employeN)."</td>
												".utf8_encode($mois)."
												<td>".utf8_encode($semaineN)."</td>
												<td> ".utf8_encode($total2)."</td>
											</tr>";
		
						$heuremois = $heuremois + $total;
						if(($employeN != $donnees->Nom)||($numeromois != $donnees->mois)) //Si l'employe reste identique et le mois change et que la semaine change.
						{
								
							$vretour= $vretour."
										<tr bgcolor='##ffd700'>
												<td>".utf8_encode($employeN)."</td>
												".utf8_encode($mois)."
												<td>MOIS ENTIER</td>
												<td> ".utf8_encode($heuremois)."</td>
											</tr>";
								
						}
						if(($employeN != $donnees->Nom)||($numeromois != $donnees->mois)) // Lorsque l'employer ou le mois change on réinisialise le nombre d'heure par mois
						{
							$heuremois = 0;
						}
		
						// J'envoi le vretour avec les valeurs de l'ancienne semaine puis je mets celles de la nouvelle semaine.
						$T1 = $donnees->T1 ;
						$T2 = $donnees->T2 ;
						$DESH = $donnees->DESH ;
						$DECH = $donnees->DECH ;
						$BRIC = $donnees->BRIC;
						$VITRE = $donnees->VITR ;
						$COURSES = $donnees->COURSES ;
						$PULVE = $donnees->PULVERISATEUR;
				}
				$e = $e+1;
				$s = $s+1;
				$m= $m+1;
		
		
		
		
			} //Fin du while
			// POUR AFFICHER LE DERNIER CALCUL =)
			if($numeromois == 1)
			{
				$mois = "<td> JANVIER ".$annee." </td>";
					
			}
			else if($numeromois == 2)
			{
				$mois = "<td> FÉVRIER ".$annee." </td>";
			}
			else if($numeromois == 3)
			{
				$mois = "<td> MARS ".$annee." </td>";
			}
			else if($numeromois == 4)
			{
				$mois = "<td> AVRIL ".$annee." </td>";
			}
			else if($numeromois == 5)
			{
				$mois = "<td> MAI ".$annee." </td>";
			}
			else if($numeromois == 6)
			{
				$mois = "<td> JUIN ".$annee." </td>";
			}
			else if($numeromois == 7)
			{
				$mois = "<td> JUILLET ". $annee." </td>";
			}
			else if($numeromois == 8)
			{
				$mois = "<td> AOÛT ". $annee." </td>";
			}
			else if($numeromois == 9)
			{
				$mois = "<td> SEPTEMBRE ".$annee." </td>";
			}
			else if($numeromois == 10)
			{
				$mois = "<td> OCTOBRE ".$annee." </td>";
			}
			else if($numeromois == 11)
			{
				$mois = "<td> NOVEMBRE ".$annee." </td>";
			}
			else if($numeromois == 12)
			{
				$mois = "<td> DÉCEMBRE ".$annee." </td>";
			}
			//	$total = $T1 + $T2 + $DECH + $DESH + $BRIC + $VITRE + $COURSES + $PULVE;
			$total = $T1 + $T2 + $DECH + $BRIC + $VITRE + $COURSES ;
			$total1 = floatval($total);
			$totala = explode('.',$total1);
			if (isset ($totala[1]) ){
				$total2 = $totala[0].','.$totala[1];
			}
			else{
				$total2 = $totala[0];
			}
			$semaineN = $semaineN +1;
			$vretour= $vretour."
											<tr>
												<td>".utf8_encode($employeN)."</td>
												".utf8_encode($mois)."
												<td>".utf8_encode($semaineN)."</td>
												<td> ".utf8_encode($total2)."</td>
											</tr>";
				
			$resultsansemployes->closeCursor();
			$_SESSION['NomEmployeH'] = $nom.'_'.$prenom; //SERT pour créer le fichier excel.
			$vretour = '<ul id="navigation" class="nav-main">
							<br>
		
		
							<div >
								<center>
								<table id ="TableauNombreHeureEmployes">
								<caption><h2>'.$nom.' '.$prenom.'</h2></caption>
								<tr>
									<th>Employé</th><th> Période </th><th> Semaine </th><th> Nombre d\'heures (décimal) </th>
								</tr>'.$vretour;
			$heuremois = $heuremois + $total;
			$vretour= $vretour."
										<tr bgcolor='##ffd700'>
												<td>".utf8_encode($employeN)."</td>
												".utf8_encode($mois)."
												<td>MOIS ENTIER</td>
												<td> ".utf8_encode($heuremois)."</td>
											</tr>";
		
			$vretour = $vretour."</table></center></div>";
				
			$_SESSION['html'] = $vretour."</ul>"; //Pour generer l'excel PAS Besoin des boutons dans le document generer.
				
			$vretour = $vretour."
								<br>
								<form name='excelgen' id='excel' method='POST' action='ExcelEmployes.php'>
									<input type='submit' id='exportexcel' class='submit' value='Exporter sous le format Excel'>
								</form>
								<br>
								</ul>";
				
			$vretour = $vretour."";
		
		} //Fin du if
		else { //Sinon le choix est effectué selon un employé
			$req = '';
			if($_POST['MoisemployesH'] == 'VIDE' && $rbDate == "moisch"){ //Si le mois reste vide
				$req="SELECT *,YEAR(DATE) AS annee,MONTH(DATE) AS mois,WEEKOFYEAR(DATE) AS semaine FROM INTERVENTIONS AS I INNER JOIN EMPLOYES AS E ON I.NumEmplSage = E.EmplSage  WHERE NumEmplSage = ".$_POST['listeemployes']." AND YEAR(DATE)='".$_POST['AnneeemployesH']."' ORDER BY semaine ASC";
				$_SESSION['MoisemployesH']='';
			}
			elseif($rbDate == "moisch") //Sinon c'est que le mois et l'annee on été sélectionné.
			{
				$req="SELECT *,YEAR(DATE) AS annee,MONTH(DATE) AS mois,WEEKOFYEAR(DATE) AS semaine FROM INTERVENTIONS AS I INNER JOIN EMPLOYES AS E ON I.NumEmplSage = E.EmplSage  WHERE NumEmplSage = ".$_POST['listeemployes']." AND YEAR(DATE)='".$_POST['AnneeemployesH']."' AND MONTH(DATE)='".$_POST['MoisemployesH']."' ORDER BY semaine ASC";
				$_SESSION['MoisemployesH']=$_POST['MoisemployesH'];
			}
			elseif($rbDate == "datedet")
			{
				$req="SELECT * ,YEAR(DATE) AS annee,MONTH(DATE) AS mois,WEEKOFYEAR(DATE) AS semaine FROM INTERVENTIONS AS I INNER JOIN EMPLOYES AS E ON I.NumEmplSage = E.EmplSage WHERE NumEmplSage = ".$_POST['listeemployes']." AND DATE BETWEEN '" . $dateD . "' AND '" . $dateF . "' ORDER BY EmplSage ASC,mois ASC,semaine ASC; ";
			}
			else 
			{
				$req="SELECT *,YEAR(DATE) AS annee,MONTH(DATE) AS mois,WEEKOFYEAR(DATE) AS semaine FROM INTERVENTIONS AS I INNER JOIN EMPLOYES AS E ON I.NumEmplSage = E.EmplSage  WHERE NumEmplSage = ".$_POST['listeemployes']." AND YEAR(DATE)='".$_POST['AnneeemployesH']."' AND MONTH(DATE)='".$_POST['MoisemployesH']."' ORDER BY semaine ASC";
				$_SESSION['MoisemployesH']=$_POST['MoisemployesH'];
			}
			//$_SESSION['listeemployes']=$_POST['listeemployes'];
			$_SESSION['AnneeemployesH']=$_POST['AnneeemployesH'];
			$result = $this->connexion->query($req);
			while($donnees = $result->fetch(PDO::FETCH_OBJ)){
				$nom = utf8_decode($donnees->Nom);
				$prenom = utf8_decode($donnees->Prenom);
				$semaine[]=$donnees->semaine; // Declaration d'un tableau dans lequel on stock les numeros de semaine pour ensuite pouvoir afficher le bon (d'oé le sem[i-1] ensuite).
				$moisT[]=$donnees->mois; //Méme principe que pour la semaine.
				if($s != 0){ $semaineN = $semaine[$s-1];} //Semaine de l'enregistrement précedent.
				if($m != 0){ $numeromois = $moisT[$m-1];} //Semaine de l'enregistrement précedent.
					
				$annee = $donnees->annee; //L'année en cours.
				if($s == 0)
				{
					//Pour le 1er tour de la boucle while.
		
					$T1 = $donnees->T1 ;
					$T2 = $donnees->T2 ;
					$DESH = $donnees->DESH ;
					$DECH = $donnees->DECH ;
					$BRIC = $donnees->BRIC;
					$VITRE = $donnees->VITR ;
					$COURSES = $donnees->COURSES ;
					$PULVE = $donnees->PULVERISATEUR;
				}
				else if(($donnees->semaine == $semaineN)&&($donnees->mois == $numeromois)) // Dans le cas oé la semaine et le mois reste identique
				{
					$T1 = $T1 + $donnees->T1 ;
					$T2 = $T2 + $donnees->T2 ;
					$DESH = $DESH + $donnees->DESH ;
					$DECH = $DECH + $donnees->DECH ;
					$BRIC = $BRIC + $donnees->BRIC;
					$VITRE = $VITRE + $donnees->VITR ;
					$COURSES = $COURSES + $donnees->COURSES ;
					$PULVE = $PULVE + $donnees->PULVERISATEUR;
				}
				else //Dans le cas ou la semaine change ou le mois.
				{
		
					if($numeromois == 1)
					{
						$mois = "<td> JANVIER ".$annee." </td>";
							
					}
					else if($numeromois == 2)
					{
						$mois = "<td> FÉVRIER ".$annee." </td>";
					}
					else if($numeromois == 3)
					{
						$mois = "<td> MARS ".$annee." </td>";
					}
					else if($numeromois == 4)
					{
						$mois = "<td> AVRIL ".$annee." </td>";
					}
					else if($numeromois == 5)
					{
						$mois = "<td> MAI ".$annee." </td>";
					}
					else if($numeromois == 6)
					{
						$mois = "<td> JUIN ".$annee." </td>";
					}
					else if($numeromois == 7)
					{
						$mois = "<td> JUILLET ". $annee." </td>";
					}
					else if($numeromois == 8)
					{
						$mois = "<td> AOÛT ". $annee." </td>";
					}
					else if($numeromois == 9)
					{
						$mois = "<td> SEPTEMBRE ".$annee." </td>";
					}
					else if($numeromois == 10)
					{
						$mois = "<td> OCTOBRE ".$annee." </td>";
					}
					else if($numeromois == 11)
					{
						$mois = "<td> NOVEMBRE ".$annee." </td>";
					}
					else if($numeromois == 12)
					{
						$mois = "<td> DÉCEMBRE ".$annee." </td>";
					}
					//	$total = $T1 + $T2 + $DECH + $DESH + $BRIC + $VITRE + $COURSES + $PULVE;
					$total = $T1 + $T2 + $DECH + $BRIC + $VITRE + $COURSES;
					$total1 = floatval($total);
					$totala = explode('.',$total1);
					if (isset ($totala[1]) ){
						$total2 = $totala[0].','.$totala[1];
					}
					else
					{
						$total2 = $totala[0];
					}
					$vretour= $vretour."
											<tr>
												".utf8_encode($mois)."
												<td>".utf8_encode($semaineN)."</td>
												<td> ".utf8_encode($total2)."</td>
											</tr>";
					$heuremois = $heuremois + $total;
					if($numeromois != $donnees->mois) //Si l'employe reste identique et le mois change et que la semaine change.
					{
		
						$vretour= $vretour."
										<tr bgcolor='##ffd700'>".utf8_encode($mois)."
												<td>MOIS ENTIER</td>
												<td> ".utf8_encode($heuremois)."</td>
											</tr>";
		
					}
					if($numeromois != $donnees->mois) // Lorsque l'employer ou le mois change on réinisialise le nombre d'heure par mois
					{
						$heuremois = 0;
					}
		
					// J'envoi le vretour avec les valeurs de l'ancienne semaine puis je mets celles de la nouvelle semaine.
					$T1 = $donnees->T1 ;
					$T2 = $donnees->T2 ;
					$DESH = $donnees->DESH ;
					$DECH = $donnees->DECH ;
					$BRIC = $donnees->BRIC;
					$VITRE = $donnees->VITR ;
					$COURSES = $donnees->COURSES ;
					$PULVE = $donnees->PULVERISATEUR;
				} //FIN DU ELSE
				$m = $m + 1 ;
				$s = $s +1 ;
			} // FIN DU WHILE
				
			// POUR AFFICHER LE DERNIER CALCUL =)
			if($numeromois == 1)
			{
				$mois = "<td> JANVIER ".$annee." </td>";
					
			}
			else if($numeromois == 2)
			{
				$mois = "<td> FÉVRIER ".$annee." </td>";
			}
			else if($numeromois == 3)
			{
				$mois = "<td> MARS ".$annee." </td>";
			}
			else if($numeromois == 4)
			{
				$mois = "<td> AVRIL ".$annee." </td>";
			}
			else if($numeromois == 5)
			{
				$mois = "<td> MAI ".$annee." </td>";
			}
			else if($numeromois == 6)
			{
				$mois = "<td> JUIN ".$annee." </td>";
			}
			else if($numeromois == 7)
			{
				$mois = "<td> JUILLET ". $annee." </td>";
			}
			else if($numeromois == 8)
			{
				$mois = "<td> AOÛT ". $annee." </td>";
			}
			else if($numeromois == 9)
			{
				$mois = "<td> SEPTEMBRE ".$annee." </td>";
			}
			else if($numeromois == 10)
			{
				$mois = "<td> OCTOBRE ".$annee." </td>";
			}
			else if($numeromois == 11)
			{
				$mois = "<td> NOVEMBRE ".$annee." </td>";
			}
			else if($numeromois == 12)
			{
				$mois = "<td> DÉCEMBRE ".$annee." </td>";
			}
			//$total = $T1 + $T2 + $DECH + $DESH + $BRIC + $VITRE + $COURSES + $PULVE;
			$total = $T1 + $T2 + $DECH + $BRIC + $VITRE + $COURSES ;
			$total1 = floatval($total);
			$totala = explode('.',$total1);
			if (isset ($totala[1]) ){
				$total2 = $totala[0].','.$totala[1];
			}
			else{
				$total2 = $totala[0];
			}
			$vretour= $vretour."
											<tr>
												".utf8_encode($mois)."
												<td>".utf8_encode($semaineN)."</td>
												<td> ".utf8_encode($total2)."</td>
											</tr>";
			$result->closeCursor();
			$_SESSION['NomEmployeH'] = $nom.'_'.$prenom; //SERT pour créer le fichier excel.
			$vretour = '<ul id="navigation" class="nav-main">
							<br>
				
					<h2> Total des heures </h2>
							<div >
								<center>
								<table id ="TableauNombreHeureEmployes">
								<caption><h2>'.utf8_encode($nom).' '.utf8_encode($prenom).'</h2></caption>
								<tr>
									<th> Période </th><th> Semaine </th><th> Nombre d\'heures (décimal) </th>
								</tr>'.$vretour;
			$heuremois = $heuremois + $total;
			if($heuremois != null)
			{
		
				$vretour= $vretour."			<tr bgcolor='##ffd700'>".$mois."
												<td>MOIS ENTIER</td>
												<td> ".utf8_encode($heuremois)."</td>
											</tr>";
		
			}
			$vretour = $vretour."</table></center></div>";
				
			$_SESSION['html'] = $vretour."</ul>"; //Pour generer l'excel PAS Besoin des boutons dans le document generer.
				
			$vretour = $vretour."
								<br>
								<form name='excelgen' id='excel' method='POST' action='ExcelEmployes.php'>
									<input type='submit' id='exportexcel' class='submit' value='Exporter sous le format Excel'>
								</form>
								<br>
								</ul>";
				
			$vretour = $vretour."";
		
		}  //Fin du else
		$vretour = $vretour."<ul id='navigation' class='nav-main'><br><input type='button' value='Retour' onClick=\"javascript:document.location.href='Employes.php'\"/><br> <br></ul>";
		return $vretour;

	
	}
	
	public function AfficheExcelEmploye(){
		$vretour = "";
		$NOM = $_SESSION['NomEmployeH'];
		$Date = $_SESSION['MoisemployesH'];
		$Date = $Date.'/'.$_SESSION['AnneeemployesH'];
		header("Content-type: application/msexcel; charset=Windows-1252");
		header ("Content-Disposition: attachment; filename=$NOM/$Date.xls");
		$vretour= $_SESSION['html'];
			
		return $vretour;
	}
	
}
	
	
	
	
	
	
	
