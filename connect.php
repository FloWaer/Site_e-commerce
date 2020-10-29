<?php 
session_start();
require_once 'include_connectBDD.php';

$form_ok = false;
$email = "indefini";
$mdp= "";

if (isset($_POST['submitted'])) {     
	$form_ok=true; 
	if (isset($_POST['email']) && $_POST['email']!=NULL && isset($_POST['mdp']) && $_POST['mdp']!=NULL ) {
		$f_email = $_POST['email'];
		$f_mdp = $_POST['mdp'];
		echo '<br>INFO:'.$f_email.' '.$f_mdp;
	}	
	else {
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
		if ( !isset($id) ){
			echo '<br>INFO: email non trouve';
			$form_ok=false;  
			}	
		if ( sha1($f_mdp) != $mdp ){
			echo '<br>INFO: mdp invalide';
			$form_ok=false;  
			}
		else{
			$_SESSION['utilisateur']=$f_email;  
			$_SESSION['nom']=$nom;  
			$_SESSION['prenom']=$prenom;  
			$_SESSION['id']=$id;  
			if ( $admin==1 ) {
				$_SESSION['droits']='admin'; 
				}
			else{
				$_SESSION['droits']='base'; 
				}
			echo '<br>'.$_SESSION['utilisateur'].' est connecte avec les droits '.$_SESSION['droits']; 
			}
		}
	catch (PDOException $e) {  
		echo 'ERREUR: select utilisateur: '.$e->getMessage();  
		}
	catch (Exception $e) {  
		echo 'ERREUR: select utilisateur';
		}
		header('Location:index.php');
	}
}


?>
