<?php
session_start(); 
require_once 'include_connectBDD.php';
require_once 'include_testCONNECTE.php';

$form_ok = false;
$email = "indefini";
$mdp= "";

if (isset($_POST['submitted'])) {     
	$form_ok=true; 
	if (isset($_POST['ID']) && $_POST['ID']!=NULL ) {
		$f_id = (int) $_POST['ID'];
		if ($_SESSION['id']==$f_id || $_SESSION['droits']=='admin') {
			$form_ok = true;	
		}else{
			$form_ok = false;
		}
	}	
	else {
	    $form_ok=false; 
		echo '<br>ERREUR:ID='.$_POST['ID'];
	} 

	if ( $form_ok ){
		echo '<br>INFO:try delete where id='.$_POST['ID'];
		try {
			// supprimer les commandes avant de supprimer le compte
			$reqCat=$bdd->prepare("DELETE FROM commande WHERE ID_utilisateur = :id ");
			$reqCat->bindParam(':id', $f_id );
			$reqCat->execute();
			// supprimer le compte
			$reqCat=$bdd->prepare("DELETE FROM utilisateur WHERE ID = :id ");
			$reqCat->bindParam(':id', $f_id );
			$reqCat->execute();
			echo '<br>INFO: DELETE FROM utilisateur WHERE ID = '.$f_id;
			}
		catch (PDOException $e) {  
			echo 'ERREUR: delete utilisateur: '.$e->getMessage(); 
			$_SESSION['message']='ERREUR: delete utilisateur: '.$e->getMessage(); 
			$form_ok=false; 
			}
		catch (Exception $e) {  
			$_SESSION['message']='ERREUR SYSTEME: delete utilisateur '; 
			$form_ok=false; 
			}
			
		}
}		

if ( $_SESSION['droits']=='admin' ){
	header('Location:gesUtilisateur.php');
}else{
	header('Location:disconnect.php');
}

?>