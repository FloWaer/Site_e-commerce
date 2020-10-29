<?php
session_start(); 
require_once 'include_connectBDD.php';
require_once 'include_testADMIN.php';

$form_ok = false;
$email = "indefini";
$mdp= "";

if (isset($_POST['submitted'])) {     
	$form_ok=true; 
	if (isset($_POST['ID']) && $_POST['ID']!=NULL ) {
		$f_id = (int) $_POST['ID'];
	}	
	else {
	    $form_ok=false; 
		echo '<br>ERREUR:ID='.$_POST['ID'];
	} 

	if ( $form_ok ){
		echo '<br>INFO:try delete where id='.$_POST['ID'];
		try {
			// supprimer les commandes avant de supprimer le produit
			$reqCat=$bdd->prepare("DELETE FROM commande WHERE ID_produit = :id ");
			$reqCat->bindParam(':id', $f_id );
			$reqCat->execute();
			// supprimer le produit
			$reqCat=$bdd->prepare("DELETE FROM produit WHERE ID = :id ");
			$reqCat->bindParam(':id', $f_id );
			$reqCat->execute();
			echo '<br>INFO: DELETE FROM produit WHERE ID = '.$f_id;
			}
		catch (PDOException $e) {  
			echo 'ERREUR: delete produit: '.$e->getMessage(); 
			$_SESSION['message']='ERREUR: delete produit: '.$e->getMessage(); 
			$form_ok=false; 
			}
		catch (Exception $e) {  
			$_SESSION['message']='ERREUR SYSTEME: delete produit '; 
			$form_ok=false; 
			}
			
		}
}		

header('Location:gesProduit.php');

?>