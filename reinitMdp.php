<?php
session_start();
require_once 'include_connectBDD.php';

$form_ok = false;
$email = "indefini";
$mdp= "";

if (isset($_POST['submitted'])) {     
	$form_ok=true; 
	if (isset($_POST['ID']) && $_POST['ID']!=NULL ) {
		$f_id = $_POST['ID'];
		echo '<br>INFO:'.$f_id.' ';
	}	
	else {
	    $form_ok=false;     
	} 
	if (isset($_POST['HASH']) && $_POST['HASH']!=NULL ) {
		$f_hash = $_POST['HASH'];
		echo '<br>INFO:'.$f_hash.' ';
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
	}	
	else {
	    $form_ok=false;     
	} 

	if ( $form_ok ){
		echo '<br>INFO:try update where id='.$_POST['ID'];
		try {
			$reqCat=$bdd->prepare("UPDATE utilisateur set mdp=:mdp WHERE ID = :id and mdp = :hash");
			$reqCat->bindParam(':id', $f_id );
			$reqCat->bindParam(':hash', $f_hash );
			$reqCat->bindParam(':mdp', sha1($f_mdp1) );
			$reqCat->execute();
			echo '<br>INFO: UPDATE utilisateur set mdp='.$f_mdp1.' WHERE ID = '.$f_id;
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

header('Location:index.php');
	




?>