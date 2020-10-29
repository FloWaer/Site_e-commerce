<?php
session_start();
require_once 'include_connectBDD.php';
require_once 'include_testCONNECTE.php';

$form_ok = false;

if (isset($_POST['submitted'])) {     
	$form_ok=true; 
	if (isset($_POST['utilisateur']) && $_POST['utilisateur']!=NULL ) {
		$f_utilisateur = $_POST['utilisateur'];
		echo '<br>INFO:'.$f_utilisateur;
	}	
	else {
	    $form_ok=false;     
		echo '<br>ERREUR:util='.$_POST['utilisateur'];
	} 

	if ( $form_ok ){
		echo '<br>INFO:try update where uti='.$f_utilisateur;
		$f_statut='en cours';
		$f_valide='commandé';
		try {
			$reqCat=$bdd->prepare("UPDATE commande set statut=:st2 WHERE ID_utilisateur = :uti and statut=:st1");
			$reqCat->bindParam(':uti', $f_utilisateur );
			$reqCat->bindParam(':st1', $f_statut );
			$reqCat->bindParam(':st2', $f_valide );
			$reqCat->execute();
			echo '<br>INFO: UPDATE commande set statut='.$f_valide.'  WHERE ID_utilisateur = '.$f_utilisateur.' and statut = '.$f_statut;
			}
		catch (PDOException $e) {  
			$_SESSION['message']='ERREUR: update commande: '.$e->getMessage(); 
			$form_ok=false; 
			}
		catch (Exception $e) {  
			$_SESSION['message']='ERREUR SYSTEME: update commande '; 
			$form_ok=false; 
			}
			
		}
}		


if ( $f_admin ){
	header('Location:gesCommande.php');
}else{
	header('Location:maCommande.php');
}

?>