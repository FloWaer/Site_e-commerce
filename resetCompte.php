<?php
session_start();
require_once 'include_connectBDD.php';
require_once 'include_testADMIN.php';
 

$form_ok = false;
$f_email = "indefini";
$mdp= "";

if (isset($_POST['submitted'])) {     
	$form_ok=true; 
	if (isset($_POST['ID']) && $_POST['ID']!=NULL ) {
		$f_id = (int) $_POST['ID'];
	}	
	else {	
	    $form_ok=false; 
	} 

	if ( $form_ok ){
		try {
			$reqCat=$bdd->prepare("SELECT * FROM utilisateur where ID = :id");
			$reqCat->bindParam(':id',$f_id);
			$reqCat->execute(); 
			
			while ($result=$reqCat->fetch(PDO::FETCH_OBJ) ) {  
				 $f_email = $result->email;
				} 
			$reqCat->closeCursor(); 
			}
		catch (PDOException $e) {  
			echo '<br>ERREUR: select utilisateur : '.$e->getMessage();  
			}
		catch (Exception $e) {  
			echo '<br>ERREUR: select utilisateur';  
			}		
		
		$f_mdp = sha1('PHP'.$f_id.'PHP'.rand(1,1000000));
		try {
			$reqCat=$bdd->prepare("UPDATE utilisateur set mdp=:mdp WHERE ID = :id ");
			$reqCat->bindParam(':id', $f_id );
			$reqCat->bindParam(':mdp', $f_mdp );
			$reqCat->execute();
			}
		catch (PDOException $e) {  
			$_SESSION['message']='ERREUR: update utilisateur: '.$e->getMessage(); 
			$form_ok=false; 
			}
		catch (Exception $e) {  
			$_SESSION['message']='ERREUR SYSTEME: update utilisateur '; 
			$form_ok=false; 
			}
			
		}
}		


echo '<html> <body>';
echo 'Suivez ce lien ou envoyez le à '.$f_email;
echo'<br>';
echo '<form id="form-mdp" action="register3.php" method="post"> <input type=hidden value="'.$f_mdp.'" name="HASH"><input type=hidden value="null" name="submitted"><a href="#" onclick="document.getElementById(\'form-mdp\').submit();">&nbsp;Réinitialiser le mot de passe&nbsp;</a></form>';
echo '<br><br><br>';
echo 'retour à la <a href="gesUtilisateur.php">  gestion des utilisateurs </a>';
echo '</body></html>';

?>
