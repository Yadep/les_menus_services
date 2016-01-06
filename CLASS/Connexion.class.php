<?php


class connexion extends page_base {
	private $connexion;
	private $PDO;



	public function __construct($p) {
		parent::__construct($p);
		$this->PDO=New PDO_MS();
		$this->PDO->connexion("les_menus_services");
		$this->connexion=$this->PDO->connexion;

	}

	
	public function connection() {
		if (isset($_POST['connexion']) && $_POST['connexion'] == 'Connexion') {
			if ((isset($_POST['login']) && !empty($_POST['login'])) && (isset($_POST['pass']) && !empty($_POST['pass']))) {
				$pass = (md5($_POST['pass']));
				$login = $_POST['login'];
				$req = "SELECT count(*) as NB FROM admin WHERE login = '".$login."' AND pass_md5 = '".$pass."'";
				$res = $this->connexion->query($req);
				$req1 = "SELECT * FROM admin WHERE login = '".$login."' AND pass_md5 = '".$pass."'";
				$res1 = $this->connexion->query($req1);
				
				$dataMA = utf8_encode("alert('Authentification non valide')");
				if ($donnees = $res->fetch(PDO::FETCH_OBJ)->NB != 1)
				{	
					echo "<script>$dataMA</script>";
				}				
				else
				{ 
					while ($donnees = $res1->fetch(PDO::FETCH_OBJ))
					{				
						$login =  $_POST['login'];
						$password = (md5($_POST['pass']));
						if (($donnees->login == $_POST['login']) && (($donnees->pass_md5==(md5($_POST['pass'])))))
						{
							session_start();
							$_SESSION['login'] = $_POST['login'];
							$dataMA = utf8_encode("alert('Connexion r�ussie')");
							echo"<script>$dataMA</script>";
							
						}
			
					}
				}		
			}
		}
	}

	public function formulaire_connexion() {
		
		$a="<ul id='navigation' class='nav-main'>
		<br>
		
		<form id='FormC' action=\"index.php\"  method=\"post\">
		<p>Login : <input type=\"text\" style=\"text-transform:lowercase;\" class=\"validate[required] text-input \" name=\"login\"  >
		Mot de passe : <input type=\"password\"  class=\"validate[required] text-input \" name=\"pass\"> </p><br />
		<input type=\"submit\" id='submit' name=\"connexion\" value=\"Connexion\">
		</form><br />
		</ul>";
		return $a;
	
	}
	
	public function affiche_connecter(){
		$vretour = "
			<ul id='navigation' class='nav-main'>
				<br>				
				Bienvenue.
				<br><br>
			</ul>";
			
		return $vretour;
	}
}
?>
