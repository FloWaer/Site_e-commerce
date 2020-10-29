<?php 
session_start(); 
require_once 'include_connectBDD.php';
require_once 'include_testCONNECTE.php';

if (isset($_SESSION['message'])) { 
			echo 'Attention: '. $_SESSION['message'] ; 
}
$f_utilisateur = $_SESSION['id'];

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
	
<h1>Mes commandes en cours</h1>
<table>
<tr>
<th>Date</th><th>Nom du Produit</th><th>Quantite</th><th>Statut de la commande</th>
</tr>
<?php
function enCours( $v_statut )
{
	if ( $v_statut == 'en cours' )	return true;
	return false;
}

try {
	
	$reqCat=$bdd->prepare("SELECT commande.date, commande.ID, commande.ID_produit, produit.nom nomproduit, commande.ID_utilisateur, commande.quantite, commande.statut  FROM commande, produit where commande.ID_utilisateur = :uti and commande.ID_produit = produit.ID and statut!='expédié' order by date desc");
	$reqCat->bindParam(':uti',$f_utilisateur);
	$reqCat->execute(); 
	
	while ($result=$reqCat->fetch(PDO::FETCH_OBJ) ) {  
		echo '<tr>';
		echo '<form id="form'.$result->ID.'-mod" action="modCommande.php" method="post"> ';
		echo '<input type=hidden value="'.$result->ID.'" name="submitted"> ';
		echo '<td>['.$result->date.']<input type=hidden value="'.$result->ID.'"name="ID"></td>';
		echo '<td>'.$result->nomproduit;
		echo '     <input type=hidden value="'.$result->ID_produit.'" name="produit">';
		echo '     <input type=hidden value="'.$result->ID_utilisateur.'" name="utilisateur">  </td>';
		if ( enCours($result->statut) ) {
			echo '<td><input type="text" name="quantite" size="4" maxlength="4" value="'.$result->quantite.'"></td>';
		}else{
			echo '<td>'.$result->quantite.'<input type=hidden name="quantite" value="'.$result->quantite.'"></td>';
		}
		echo '<td>'.$result->statut.'<input type=hidden value="'.$result->statut.'" name="statut"></td>';
		if ( enCours($result->statut) ) {
			echo '<td><a href="#" onclick="document.getElementById(\'form'.$result->ID.'-mod\').submit();">Modifier</a></td>';
			echo '</form>';
			echo '<form id="form'.$result->ID.'-supp" action="suppCommande.php" method="post"> ';
			echo '<td><input type=hidden value="'.$result->ID.'" name="submitted"> ';
			echo '    <input type=hidden value="'.$result->ID.'" name="ID">';
			echo '    <a href="#" onclick="document.getElementById(\'form'.$result->ID.'-supp\').submit();">Supprimer</a></td>';
		}
		echo '</form>';
		echo '</tr>';
		} 
	$reqCat->closeCursor(); 
	echo '<tr>';
	
	echo '<form id="form-valid" action="valCommande.php" method="post"> ';
	echo '<input type=hidden value="'.$f_utilisateur.'" name="submitted"> ';
	echo '<input type=hidden value="'.$f_utilisateur.'" name="utilisateur"> ';
	echo '<td></td>';
	echo '<td></td>';
	echo '<td></td>';
	echo '<td></td>';
	echo '<td colspan=2><input type="submit" value="Valider mes commandes" name="submitted"></td>';
	echo '</form>';
	echo '</tr>';
	}
catch (PDOException $e) {  
	echo '<br>ERREUR: select commande : '.$e->getMessage();  
	}
catch (Exception $e) {  
	echo '<br>ERREUR: select commande';  
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