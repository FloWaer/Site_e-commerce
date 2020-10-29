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
	if (isset($_POST['nom']) && $_POST['nom']!=NULL 
		&& isset($_POST['type']) && $_POST['type']!=NULL
		&& isset($_POST['pourcentage']) && $_POST['pourcentage']!=NULL
		&& isset($_POST['image']) && $_POST['image']!=NULL
		&& isset($_POST['prix']) && $_POST['prix']!=NULL ) {
		$f_nom = $_POST['nom'];
		$f_pourcentage = $_POST['pourcentage'];
		$f_image = $_POST['image'];
		$f_type = $_POST['type'];
		$f_prix = $_POST['prix'];
		echo '<br>INFO:'.$f_nom.' '.$f_type;
	}	
	else {
	    $form_ok=false;     
		echo '<br>ERREUR:nom-type='.$_POST['nom'].' - '.$_POST['type'];
	} 

	if ( $form_ok ){
		echo '<br>INFO:try update where id='.$_POST['ID'];
		try {
			$reqCat=$bdd->prepare("UPDATE produit set nom=:nom , type=:type , prix=:prix, image=:image, pourcentage=:pct WHERE ID = :id ");
			$reqCat->bindParam(':id', $f_id );
			$reqCat->bindParam(':nom', $f_nom );
			$reqCat->bindParam(':type', $f_type );
			$reqCat->bindParam(':prix', $f_prix );
			$reqCat->bindParam(':pct', $f_pourcentage );
			$reqCat->bindParam(':image', $f_image );
			$reqCat->execute();
			echo '<br>INFO: UPDATE produit set nom='.$f_nom.' WHERE ID = '.$f_id;
			}
		catch (PDOException $e) {  
			$_SESSION['message']='ERREUR: update produit: '.$e->getMessage(); 
			$form_ok=false; 
			}
		catch (Exception $e) {  
			$_SESSION['message']='ERREUR SYSTEME: update produit '; 
			$form_ok=false; 
			}
			
		}
}		

header('Location:gesProduit.php');

?>