<?php

$f_admin = false;
if (isset($_SESSION['id'])) { 
	if(!empty($_SESSION['droits'])) { 
		if($_SESSION['droits']=='admin') { 
			$f_admin = true;
		}
	}	
}else{
	header('Location:login.php');
}	

?>