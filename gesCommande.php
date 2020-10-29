<?php
session_start();
require_once 'include_connectBDD.php';
require_once 'include_testADMIN.php';
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
<h1>Gestion des commandes</h1>
<table>
<tr>
<th>Date</th><th>ID</th><th>ID du Produit</th><th>Nom du Produit</th><th>ID de l'utilisateur</th><th>email</th><th>Quantite</th><th>Statut de la commande</th>
</tr>
<?php
try {
	$reqCat=$bdd->prepare("SELECT commande.date, commande.ID, commande.ID_produit, produit.nom nomproduit, commande.ID_utilisateur, utilisateur.email, commande.quantite, commande.statut  FROM commande, produit, utilisateur where commande.ID_utilisateur = utilisateur.ID and commande.ID_produit = produit.ID order by statut, date");
	$reqCat->execute();
	while ($result=$reqCat->fetch(PDO::FETCH_OBJ) ) {  
		echo '<tr>';
		echo '<td>['.$result->date.']</td><td>['.$result->ID.']</td><td>'.$result->ID_produit.'</td><td>'.$result->nomproduit.'</td><td>'.$result->ID_utilisateur.'</td><td>'.$result->email.'</td><td>'.$result->quantite.'</td><td>'.$result->statut.'</td>' ;
		echo '<td><table><tr>';
		echo '<td><form id="form'.$result->ID.'-mod" action="editCommande.php" method="post"> <input type=hidden value="'.$result->ID.'" name="ID"><input type=hidden value="'.$result->ID.'" name="submitted"><a href="#" onclick="document.getElementById(\'form'.$result->ID.'-mod\').submit();">&nbsp;Modifier&nbsp;</a></form></td>';
		echo '</tr></table></td>'; 
		echo '</tr>';
		} 
	$reqCat->closeCursor(); 
	}
catch (PDOException $e) {  
	echo 'ERREUR: select commande : '.$e->getMessage();  
	}
catch (Exception $e) {  
	echo 'ERREUR: select produit';  
	}
?>
</table>
</div>
<!-- PIED DE PAGE -->
	<div class=footer>
		<a href="contact.php">Contact</a> -- Copyright HEH&copy;Juin 2019
	</div>
</body>
</html>