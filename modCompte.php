<?php
session_start();
require_once 'include_connectBDD.php';
require_once 'include_testCONNECTE.php';

$form_ok = false;
$email = "indefini";
$mdp= "";

echo '<br>INFO:submitted='.$_POST['submitted'];
echo '<br>INFO:f_email='.$_POST['email'];
echo '<br>INFO:f_nom='.$_POST['nom'];
echo '<br>INFO:f_prenom='.$_POST['prenom'];

if (isset($_POST['submitted'])) {     
	$form_ok=true; 
	if (isset($_POST['ID']) && $_POST['ID']!=NULL 
		&& isset($_POST['email']) && $_POST['email']!=NULL
		&& isset($_POST['adresse']) && $_POST['adresse']!=NULL
		&& isset($_POST['nom']) && $_POST['nom']!=NULL 
		&& isset($_POST['prenom']) && $_POST['prenom']!=NULL
		) {
		$f_id = (int) $_POST['ID'];
		$f_email = $_POST['email'];
		$f_nom = $_POST['nom'];
		$f_prenom = $_POST['prenom'];
		$f_adresse = $_POST['adresse'];
		echo '<br>INFO:'.$f_nom.' '.$f_prenom;
	}	
	else {
	    $form_ok=false; 
		echo '<br>ERREUR:ID='.$_POST['ID'];
		echo '<br>ERREUR:email='.$_POST['email'];
		echo '<br>ERREUR:nom-prenom='.$_POST['nom'].' - '.$_POST['prenom'];
	}

	if (!filter_var($f_email, FILTER_VALIDATE_EMAIL)) {
		$_SESSION['message']='ERREUR: adresse email invalide';
		$form_ok=false; 
	}
	if (!preg_match("/^[a-zA-Z0-9 ]*$/",$f_nom) || !preg_match("/^[a-zA-Z0-9 ]*$/",$f_prenom) || !preg_match("/^[a-zA-Z0-9 ]*$/",$f_adresse)) {
		$_SESSION['message']='ERREUR: caractères non autorisés (uniquement lettres, chiffres et espace) ';
		$form_ok=false; 
	}
	
	$mdp_ok = false;
	if (isset($_POST['mdp2']) && $_POST['mdp2']!=NULL && isset($_POST['mdp1']) && $_POST['mdp1']!=NULL ) {
		$f_mdp1 = $_POST['mdp1'];
		$f_mdp2 = $_POST['mdp2'];
		if ( $f_mdp2 != $f_mdp1 ){
			echo '<br>ERREUR: les mots de passe ne sont pas identiques';
			$_SESSION['message']='ERREUR: les mots de passe ne sont pas identiques';
			$form_ok=false;
		}
		if ( $f_mdp2 < 4 && $f_mdp1 < 4 ){
			echo '<br>ERREUR: le mot de passe est trop petit';
			$_SESSION['message']='ERREUR: le mot de passe est trop petit';
			$form_ok=false;     
		}	
		else{
			$mdp_ok = true;
		}
	}	

	if ( $form_ok ){
		echo '<br>INFO:try update where id='.$_POST['ID'];
		try {
			$reqCat=$bdd->prepare("UPDATE utilisateur set email=:email , nom=:nom , prenom=:prenom, adresse=:adr WHERE ID = :id ");
			$reqCat->bindParam(':id', $f_id );
			$reqCat->bindParam(':email', $f_email );
			$reqCat->bindParam(':adr', $f_adresse );
			$reqCat->bindParam(':nom', $f_nom );
			$reqCat->bindParam(':prenom', $f_prenom );
			$reqCat->execute();
			echo '<br>INFO: UPDATE utilisateur set email='.$f_email.' , nom='.$f_nom.' , prenom='.$f_prenom.' WHERE ID = '.$f_id;
			
			if ( $mdp_ok ){
				$reqCat=$bdd->prepare("UPDATE utilisateur set mdp=:mdp WHERE ID = :id ");
				$reqCat->bindParam(':id', $f_id );
				$reqCat->bindParam(':mdp', $mdp );
				$mdp = sha1($f_mdp1);
				$reqCat->execute();
			}
		}
		catch (PDOException $e) {  
			echo 'ERREUR: update utilisateur: '.$e->getMessage(); 
			$_SESSION['message']='ERREUR: update utilisateur: '.$e->getMessage(); 
			$form_ok=false; 
		}
		catch (Exception $e) {  
			$_SESSION['message']='ERREUR SYSTEME: update utilisateur '; 
			$form_ok=false; 
		}
			
		}
}		

if ( $f_admin ){
	header('Location:gesUtilisateur.php');
}else{
	$_SESSION['utilisateur']=$f_email;  
	$_SESSION['nom']=$f_nom;  
	$_SESSION['prenom']=$f_prenom;  

	header('Location:index.php');
}

?>