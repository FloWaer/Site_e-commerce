<?php
session_start();
require_once 'include_connectBDD.php';
require_once 'include_testCONNECTE.php';

$form_ok = false;

if (isset($_POST['submitted'])) {     
	$form_ok=true; 
	if ( isset($_POST['utilisateur']) && $_POST['utilisateur']!=NULL 
		&& isset($_POST['produit']) && $_POST['produit']!=NULL ) {
		$f_utilisateur = $_POST['utilisateur'];
		$f_produit = $_POST['produit'];
		echo '<br>INFO: '.$f_utilisateur.' '.$f_produit.' ';
	}	
	else {
	    $form_ok=false;     
		echo '<br>ERREUR:util-produit='.$_POST['utilisateur'].' - '.$_POST['produit'].' ';
	} 

	if ( $form_ok ){
		try {
			$f_statut = 'en cours';
			$f_id = -1;
			
			// chercher une commande en cours pour cet utilisateur
			$reqCat=$bdd->prepare("SELECT date,ID,ID_produit,quantite  FROM commande where ID_produit=:prd and ID_utilisateur=:uti and statut=:st");
			$reqCat->bindParam(':uti',$f_utilisateur);
			$reqCat->bindParam(':prd',$f_produit);
			$reqCat->bindParam(':st',$f_statut);
			$reqCat->execute(); 
			while ($result=$reqCat->fetch(PDO::FETCH_OBJ) ) {  
					$f_id = (int)$result->ID;
					$f_date = $result->date;
					$f_quantite = $result->quantite;
			}
			$reqCat->closeCursor(); 

			// aucune commande n existe, il faut en creer une
			if ( $f_id < 0 ){
				echo '<br>INFO:try insert commande ';
				$reqCat=$bdd->prepare("INSERT INTO commande(ID_utilisateur,statut,ID_produit,date,quantite) VALUES(:uti,:statut,:prd,CURDATE(),1)");
				$reqCat->bindParam(':uti',$f_utilisateur);
				$reqCat->bindParam(':prd',$f_produit);
				$reqCat->bindParam(':statut',$f_statut);
				$reqCat->execute(); 
				echo '<br>INFO: INSERT commande set quantite=1,statut='.$f_statut.',utilisateur='.$f_utilisateur.',produit='.$f_produit;
			}else{
				echo '<br>INFO:try update where id='.$f_id;
				$reqCat=$bdd->prepare("UPDATE commande set quantite=:qte+1, date = CURDATE() WHERE ID=:id and ID_utilisateur=:uti and ID_produit=:prd");
				$reqCat->bindParam(':id', $f_id );
				$reqCat->bindParam(':uti', $f_utilisateur );
				$reqCat->bindParam(':prd', $f_produit );
				$reqCat->bindParam(':qte',$f_quantite);
				$reqCat->execute();
				echo '<br>INFO: UPDATE commande set quantite='.$f_quantite.'  WHERE ID = '.$f_id.' and ID_utilisateur = '.$f_utilisateur.' and ID_produit = '.$f_produit;
			}
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

header('Location:index.php');

?>