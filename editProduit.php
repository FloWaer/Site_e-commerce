<?php 
session_start(); 
require_once 'include_connectBDD.php';
require_once 'include_testCONNECTE.php';

$f_id = -1;
$f_nom = "";
$f_prenom = "";
$f_email = "";

if (isset($_SESSION['message'])) { 
			echo 'Attention: '. $_SESSION['message'] ; 
}


$form_ok = false;
if (isset($_POST['submitted'])) {     
	$form_ok=true; 
	if (isset($_POST['ID']) && $_POST['ID']!=NULL ) {
		$f_id = (int) $_POST['ID'];
	}	
}
if ( $form_ok )
{
	try {
		$reqCat=$bdd->prepare("SELECT * FROM produit where id = :id");
		$reqCat->bindParam(':id',$f_id);
		$reqCat->execute(); 
		
		while ($result=$reqCat->fetch(PDO::FETCH_OBJ) ) {  
			 $f_nom = $result->nom;
			 $f_type = $result->type;
			 $f_prix = $result->prix;
			 $f_image = $result->image;
			 $f_pourcentage = $result->pourcentage;
			} 
		$reqCat->closeCursor(); 
		}
	catch (PDOException $e) {  
		echo '<br>ERREUR: select produit : '.$e->getMessage();  
		}
	catch (Exception $e) {  
		echo '<br>ERREUR: select produit';  
		}
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr" xml:lang="fr">
<head>
		<meta charset="utf-8">
		<title>Les Trappistes belges - site amateur</title>
		<meta name="robots" content="index, follow">
		<meta name="keywords" content="bières, trappistes, belges, abbaye, moines">
		<meta name="geo.placename" content="Mons, hainaut">
		<meta name="geo.region" content="BE-WHT">
		<link href="style/style5.css" rel="stylesheet">
</head>
<body>

	<!-- ENTETE -->
	<div class=header>
		<table>
		<tr>
		<td><a href="index.php"><img src="images/atp-logo-small.png" height=100 alt="Logo Trappiste"></a></td>
		<td><font color="#fff" size=72px>&nbsp;&nbsp;E-Trappiste</font></td>
		<td><font color="#fff" size=px>&nbsp;&nbsp;Site de vente en ligne</font></td>
		</tr>
		</table>
	</div>
	
	<!-- MENU -->
	<div class=nav>
					<ul>
						<li><a href="pages/achel.html">Achel</a>
							<ul>
								<li><a href="pages/achel.html#hist">Historique</a></li>
								<li><a href="pages/achel.html#type">Types et caractéristiques</a></li>
								<li><a href="pages/achel.html#fab">Fabrication</a></li>
								<li><a href="pages/achel.html#loc">Localisation</a></li>
							</ul>
						</li><li><a href="pages/chimay.html">Chimay</a>
							<ul>
								<li><a href="pages/chimay.html#hist">Historique</a></li>
								<li><a href="pages/chimay.html#type">Types et caractéristiques</a></li>
								<li><a href="pages/chimay.html#fab">Fabrication</a></li>
								<li><a href="pages/chimay.html#loc">Localisation</a></li>
							</ul>
						</li><li><a href="pages/orval.html">Orval</a>
							<ul>
								<li><a href="pages/orval.html#hist">Historique</a></li>
								<li><a href="pages/orval.html#type">Types et caractéristiques</a></li>
								<li><a href="pages/orval.html#fab">Fabrication</a></li>
								<li><a href="pages/orval.html#loc">Localisation</a></li>
							</ul>
						</li><li><a href="pages/rochefort.html">Rochefort</a>
							<ul>
								<li><a href="pages/rochefort.html#hist">Historique</a></li>
								<li><a href="pages/rochefort.html#type">Types et caractéristiques</a></li>
								<li><a href="pages/rochefort.html#fab">Fabrication</a></li>
								<li><a href="pages/rochefort.html#loc">Localisation</a></li>
							</ul>
						</li><li><a href="pages/westmalle.html">Westmalle</a>
							<ul>
								<li><a href="pages/westmalle.html#hist">Historique</a></li>
								<li><a href="pages/westmalle.html#type">Types et caractéristiques</a></li>
								<li><a href="pages/westmalle.html#fab">Fabrication</a></li>
								<li><a href="pages/westmalle.html#loc">Localisation</a></li>
							</ul>
						</li><li><a href="pages/westvleteren.html">Westvleteren</a>
							<ul>
								<li><a href="pages/westvleteren.html#hist">Historique</a></li>
								<li><a href="pages/westvleteren.html#type">Types et caractéristiques</a></li>
								<li><a href="pages/westvleteren.html#fab">Fabrication</a></li>
								<li><a href="pages/westvleteren.html#loc">Localisation</a></li>
							</ul>
						</li><li>
						<!-- <a href="login.php">Se connecter</a> -->
	<?php
if (isset($_SESSION['id'])) { 
	if(!empty($_SESSION['droits'])) { 
		if($_SESSION['droits']=='admin') { 
			echo 'Bonjour ADMIN'; 
			$f_admin = true;
		} 
		else if($_SESSION['droits']=='base') { 
			echo 'Bonjour '. $_SESSION['prenom'] ; 
		} 
	} 
}
else{
	echo '<a href="login.php">Identifiez-vous</a>';
}
?>
						</li>
					</ul>
	</div>

	<!-- CORPS PRINCIPAL -->
	<div class=main>
		<form action="modProduit.php" method="post">
		<table>
		<tr>
		<th colspan=2>Modifier un produit</th>
		</tr>

		<?php
		echo '<input type=hidden name="ID" value="'.$f_id.'">';
		?>
		<tr>
		<td>Nom:</td><td>
		<?php
		echo '<input type="text" name="nom" size="64" maxlength="256" value="'.$f_nom.'">';
		?>
		</td>
		</tr>
		<tr>
		<td>Type:</td><td>
		<?php
		echo '<input type="text" name="type" size="64" maxlength="256" value="'.$f_type.'">';
		?>
		</td>
		</tr>
		<tr>
		<td>Degré:</td><td>
		<?php
		echo '<input type="text" name="pourcentage" size="64" maxlength="64" value="'.$f_pourcentage.'">';
		?>
		</td>
		</tr>
		<tr>
		<td>Prix:</td><td>
		<?php
		echo '<input type="text" name="prix" size="64" maxlength="64" value="'.$f_prix.'">';
		?>
		</td>
		</tr>
		<tr>
		<td>Image:</td><td>
		<?php
		echo '<input type="text" name="image" size="64" maxlength="64" value="'.$f_image.'">';
		?>
		</td>
		</tr>
		<tr>
		<td></td><td><input type="submit" value="Modifier le produit" name="submitted"> </td>
		</tr>
		</table>
		</form>
	</div>
	
	<!-- PIED DE PAGE -->
	<div class=footer>
		<a href="contact.php">Contact</a> -- Copyright HEH&copy;Juin 2019
	</div>
</body>
</html>