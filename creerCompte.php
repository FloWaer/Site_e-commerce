<?php
session_start();
require_once 'include_connectBDD.php';

$form_ok = false;
$email = "indefini";
$mdp= "";

if (isset($_POST['submitted'])) {     
	$form_ok=true; 
	if (isset($_POST['email']) && $_POST['email']!=NULL && isset($_POST['adresse']) && $_POST['adresse']!=NULL) {
		$f_email = $_POST['email'];
		$f_adresse = $_POST['adresse'];
		echo '<br>INFO:'.$f_email.' ';
	}	
	else {
	    $form_ok=false;     
	} 
	if (isset($_POST['nom']) && $_POST['nom']!=NULL && isset($_POST['prenom']) && $_POST['prenom']!=NULL) {
		$f_nom = $_POST['nom'];
		$f_prenom = $_POST['prenom'];
		echo '<br>INFO:'.$f_nom.' '.$f_prenom;
	}	
	else {
	    $form_ok=false;     
	} 
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
		 
	}	
	else {
	    $form_ok=false;     
	} 

	if (!filter_var($f_email, FILTER_VALIDATE_EMAIL)) {
		$_SESSION['message']='ERREUR: adresse email invalide';
		$form_ok=false; 
	}
	if (!preg_match("/^[a-zA-Z0-9 ]*$/",$f_nom) || !preg_match("/^[a-zA-Z0-9 ]*$/",$f_prenom) || !preg_match("/^[a-zA-Z0-9 ]*$/",$f_adresse)) {
		$_SESSION['message']='ERREUR: caractères non autorisés (uniquement lettres, chiffres et espace) ';
		$form_ok=false; 
	}

	if ( $form_ok ==true ){
		try {
			$reqCat=$bdd->prepare("SELECT * FROM utilisateur where email=:email");
			$reqCat->bindParam(':email',$f_email);
			$reqCat->execute(); 
			while ($result=$reqCat->fetch(PDO::FETCH_OBJ) ) {  
				echo '<br>INFO: ['.$result->ID.']'.$result->nom.' - '.$result->prenom.' - '.$result->email; 
				$id=$result->ID;
				$mdp=$result->mdp;
				$nom=$result->nom;
				$prenom=$result->prenom;
				$admin=$result->admin;
				} 
			$reqCat->closeCursor(); 
			if ( isset($id) ){
				echo '<br>INFO: cet email existe déja!!! '.$f_email;
				$_SESSION['message']='ERREUR: cet email '.$f_email.' existe déja!!! ';
				$form_ok=false; 
				}	
			}
		catch (PDOException $e) {  
			echo 'ERREUR: select utilisateur: '.$e->getMessage(); 
			$_SESSION['message']='ERREUR: select utilisateur: '.$e->getMessage(); 
			$form_ok=false; 
			}
		catch (Exception $e) {  
			$_SESSION['message']='ERREUR SYSTEME: select utilisateur '; 
			$form_ok=false; 
			}
			
		}
		
	if ( $form_ok == true ){	
		try {
			$reqCat=$bdd->prepare("INSERT INTO utilisateur (adresse, email, nom, prenom, mdp) VALUES (:adresse, :email, :nom, :prenom, :mdp)");
			$reqCat->bindParam(':adresse', $adresse );
			$reqCat->bindParam(':email', $email );
			$reqCat->bindParam(':nom', $nom );
			$reqCat->bindParam(':prenom', $prenom );
			$reqCat->bindParam(':mdp', $mdp );

			$id_adresse = 0;
			$email= $f_email;
			$adresse = $f_adresse;
			$nom = $f_nom;
			$prenom = $f_prenom;
			$mdp = sha1($f_mdp1);
			echo 'adresse='.$adresse.' email='.$email.' nom='.$nom.' prenom='.$prenom.' mdp='.$mdp;

			$reqCat->execute(); 
			}
		catch (PDOException $e) {  
			echo 'ERREUR: insert utilisateur: '.$e->getMessage();  
			$_SESSION['message']='ERREUR: insert utilisateur: '.$e->getMessage(); 
			$form_ok=false; 			
			}
		catch (Exception $e) {  
			echo 'ERREUR: insert utilisateur';
			$_SESSION['message']='ERREUR SYSTEME: insert utilisateur '; 
			$form_ok=false; 
			}		
		}		
	}

if ( $form_ok==true ) {
	header('Location:index.php');
	}
else{
	header('Location:register.php');
	}


?>