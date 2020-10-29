<?php
session_start(); 
require_once 'include_connectBDD.php';
require_once 'include_testCONNECTE.php';

$form_ok = false;
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
			$reqCat=$bdd->prepare("DELETE FROM commande WHERE ID = :id ");
			$reqCat->bindParam(':id', $f_id );
			$reqCat->execute();
			echo '<br>INFO: DELETE FROM commande WHERE ID = '.$f_id;
			}
		catch (PDOException $e) {  
			echo 'ERREUR: delete commande: '.$e->getMessage(); 
			$_SESSION['message']='ERREUR: delete commande: '.$e->getMessage(); 
			$form_ok=false; 
			}
		catch (Exception $e) {  
			$_SESSION['message']='ERREUR SYSTEME: delete commande '; 
			$form_ok=false; 
			}
			
		}
}		


if ( $_SESSION['droits']=='admin' ){
	header('Location:gesCommande.php');
}else{
	header('Location:maCommande.php');
}

?>