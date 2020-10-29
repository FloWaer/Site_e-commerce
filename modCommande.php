<?php
session_start();
require_once 'include_connectBDD.php';
require_once 'include_testCONNECTE.php';

$form_ok = false;

if (isset($_POST['submitted'])) {     
	$form_ok=true; 
	if (isset($_POST['ID']) && $_POST['ID']!=NULL 
		&& isset($_POST['quantite']) && $_POST['quantite']!=NULL 
		&& isset($_POST['utilisateur']) && $_POST['utilisateur']!=NULL 
		&& isset($_POST['produit']) && $_POST['produit']!=NULL 
		&& isset($_POST['statut']) && $_POST['statut']!=NULL ) {
		$f_id = (int) $_POST['ID'];
		$f_utilisateur = $_POST['utilisateur'];
		$f_produit = $_POST['produit'];
		$f_quantite = abs((int)$_POST['quantite']);
		$f_statut = $_POST['statut'];
		echo '<br>INFO:'.$f_id.' '.$f_utilisateur.' '.$f_produit.' '.$f_quantite.' '.$f_statut;
	}	
	else {
	    $form_ok=false;     
		echo '<br>ERREUR:id-util-produit-qte-statut='.$_POST['utilisateur'].' - '.$_POST['produit'].' '.$_POST['quantite'].' - '.$_POST['statut'];
	} 

	if ( $form_ok ){
		echo '<br>INFO:try update where id='.$f_id;
		try {
			$reqCat=$bdd->prepare("UPDATE commande set quantite=:qte , statut=:st WHERE ID = :id and ID_utilisateur = :uti and ID_produit = :prd");
			$reqCat->bindParam(':id', $f_id );
			$reqCat->bindParam(':uti', $f_utilisateur );
			$reqCat->bindParam(':prd', $f_produit );
			$reqCat->bindParam(':qte', $f_quantite );
			$reqCat->bindParam(':st', $f_statut );
			$reqCat->execute();
			echo '<br>INFO: UPDATE commande set quantite='.$f_quantite.' , statut='.$f_statut.'  WHERE ID = '.$f_id.' and ID_utilisateur = '.$f_utilisateur.' and ID_produit = '.$f_produit;
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
	header('Location:index.php');
}
?>