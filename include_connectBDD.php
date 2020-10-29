<?php
date_default_timezone_set('Europe/Brussels'); 
$hote='localhost'; 
$nomBD='projet_php';  
$user='root';  
$mdp='';  
 
try {   
	$bdd=new PDO('mysql:host='.$hote.';dbname='.$nomBD,$user,$mdp);  
	//$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	$bdd->exec("SET NAMES 'utf8'");
	//echo '<br>INFO:BDD Connected';  
	} 
catch (PDOException $e) {  
	echo '<br>ERREUR: connexion a la BDD : '.$e->getMessage();  
	die();
	}
catch (Exception $e) {  
	echo '<br>ERREUR: connexion a la BDD';  
	die();
	}
?>
