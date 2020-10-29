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
		<h1>Modifier une commande</h1>
		<table>
		<tr>
		<th>Date</th><th>ID</th><th>ID du Produit</th><th>Nom du Produit</th><th>ID de l'utilisateur</th><th>email</th><th>Quantite</th><th>Statut de la commande</th>
		</tr>
		<?php
		function isSelected($val, $sel)
		{
			if ( $val == $sel ) return 'selected';
			return '';
		};
		if ( $form_ok )
		{
			echo '<form id="form-mod" action="modCommande.php" method="post"> ';
			echo '<input type=hidden value="'.$f_id.'" name="ID">';
			try {
				
				$reqCat=$bdd->prepare("SELECT commande.date, commande.ID, commande.ID_produit, produit.nom nomproduit, commande.ID_utilisateur, utilisateur.email, commande.quantite, commande.statut  FROM commande, produit, utilisateur where commande.ID_utilisateur = utilisateur.ID and commande.ID_produit = produit.ID and commande.id = :id");
				$reqCat->bindParam(':id',$f_id);
				$reqCat->execute(); 
				
				while ($result=$reqCat->fetch(PDO::FETCH_OBJ) ) {  
					echo '<tr>';
					echo '<td>['.$result->date.']</td><td>['.$result->ID.']</td>';
					echo '<td>'.$result->ID_produit.'<input type=hidden value="'.$result->ID_produit.'" name="produit"></td>';
					echo '<td>'.$result->nomproduit.'</td>';
					echo '<td>'.$result->ID_utilisateur.'<input type=hidden value="'.$result->ID_utilisateur.'" name="utilisateur"></td>';
					echo '<td>'.$result->email.'</td><td>'.$result->quantite.'</td><td>'.$result->statut.'</td>' ;
					echo '<td><input type="text" name="quantite" size="4" maxlength="4" value="'.$result->quantite.'"></td>';
					echo '<td><select name="statut">';
					echo '  <option value="en cours" '.isSelected($result->statut,'encours').'>En cours</option>';
					echo '  <option value="commandé" '.isSelected($result->statut,'commandé').'>Commandé</option>';
					echo '  <option value="expédié" '.isSelected($result->statut,'expédié').'>Expédié</option>';
					echo '  </select></td>';
					echo '</tr>';
					} 
				echo '<tr><td><input type="submit" value="Modifier la commande" name="submitted"> </td></tr>';	
				$reqCat->closeCursor(); 
				}
			catch (PDOException $e) {  
				echo '<br>ERREUR: select commande : '.$e->getMessage();  
				}
			catch (Exception $e) {  
				echo '<br>ERREUR: select commande';  
				}
		}
		?>
		</form>
		<form id="form-supp" action="suppCommande.php" method="post"> 
		<?php
			echo '<tr><td><input type=hidden value="'.$f_id.'" name="ID">';
			echo '<input type="submit" value="Supprimer la commande" name="submitted"></td></tr>';
		?>
		</form>
		</table>
	</div>
	
	<!-- PIED DE PAGE -->
	<div class=footer>
		<a href="contact.php">Contact</a> -- Copyright HEH&copy;Juin 2019
	</div>
</body>
</html>