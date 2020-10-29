<?php

if (isset($_SESSION['id'])) { 
	if(!empty($_SESSION['droits'])) { 
		if($_SESSION['droits']!='admin') { 
			echo 'Vous n etes pas administrateur' ; 
			die();
		}
	}	
}else{
	header('Location:login.php');
}
	
?>