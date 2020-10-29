<?php
session_start();
require_once 'include_connectBDD.php';
$f_admin = false;
?>
<!DOCTYPE html>


<html xmlns="http://www.w3.org/1999/xhtml" lang="fr" xml:lang="fr">
<head>
		<meta charset="utf-8">
		<title>E-Trappiste - site amateur</title>
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
	echo '<a href="login.php">Se connecter</a>';
}
?>
						</li>
					</ul>
	</div>
	
	<!-- CORPS PRINCIPAL -->
	<div class=main>
	<?php
if (isset($_SESSION['id'])) { 
	echo '<br><br><table><tr>';
	if ( $f_admin ){
		echo '<td><a href="gesUtilisateur.php">Gestion des Utilisateurs</a> </td>';
		echo '<td><a href="gesProduit.php">Gestion des Produits</a> </td>';
		echo '<td><a href="gesCommande.php">Gestion des Commandes</a> </td>';
		echo '<td> ( <a href="disconnect.php">Se déconnecter</a> )</td>';
	}else{
		try {
			$f_statut='en cours';
			$reqCat=$bdd->prepare("SELECT * FROM commande where statut=:st and ID_utilisateur=:uti");
			$reqCat->bindParam(':uti',$_SESSION['id']);
			$reqCat->bindParam(':st',$f_statut);
			$reqCat->execute(); 
			$res=$reqCat->fetchAll();
			$f_total=count($res);
			$reqCat->closeCursor(); 	
		}
		catch (PDOException $e) {  
			echo 'ERREUR: select produit : '.$e->getMessage();  
		}
		catch (Exception $e) {  
			echo 'ERREUR: select produit';  
		}
		echo '<td><form id="form-mod" action="editCompte.php" method="post"> <input type=hidden value="'.$_SESSION['id'].'" name="ID"><input type=hidden value="'.$_SESSION['id'].'" name="submitted"><a href="#" onclick="document.getElementById(\'form-mod\').submit();">&nbsp;Mon Compte&nbsp;</a></form></td>';
		echo '<td><form id="form-cmd" action="maCommande.php" method="post"> <input type=hidden value="'.$_SESSION['id'].'" name="ID"><input type=hidden value="'.$_SESSION['id'].'" name="submitted"><a href="#" onclick="document.getElementById(\'form-cmd\').submit();">&nbsp;Mon Panier&nbsp;</a> ['.$f_total.' articles]</form></td>';
		echo '<td> ( <a href="disconnect.php">Se déconnecter</a> )</td>';
		
	}
	echo '</tr></table>';
}
else{
	echo '<a href="login.php">Identifiez-vous</a> ( Nouveau client? <a href="register.php">commencez ici</a> )';
}

if (isset($_SESSION['message'])) { 
			echo $_SESSION['message'] ; 
			$_SESSION['message']='';
} 

	?>
		<br>
		<table>
			<tbody>
			<?php
				try {
					$reqCat=$bdd->prepare("SELECT * FROM produit ORDER BY nom");
					$reqCat->execute(); 
					while ($result=$reqCat->fetch(PDO::FETCH_OBJ) ) {
						
						echo '<tr>';
						echo '<td>';
						echo '<a href="pages/'.$result->image.'.html"><img src="images/'.$result->image.'.jpg" alt="Image '.$result->nom.'" height="200" width="250"></a>';
						echo '</td>';
						echo '<td><p style="font-family:verdana;font-size:30px">'.$result->nom.'</p> <br><br>'.$result->type.' '.$result->pourcentage.'% <br>Prix: '.$result->prix.' &euro;';
						echo '</td>';
						echo '<td>';
						if (isset($_SESSION['id'])&&!empty($_SESSION['id'])) { 
							echo '<form id="form-'.$result->ID.'-add" action="ajoutCommande.php" method="post"> <input type=hidden value="'.$_SESSION['id'].'" name="utilisateur"><input type=hidden value="'.$result->ID.'" name="produit"><input type=hidden value="'.$_SESSION['id'].'" name="submitted"><a href="#" onclick="document.getElementById(\'form-'.$result->ID.'-add\').submit();">&nbsp;Ajouter au panier&nbsp;</a></form>';
						}
						echo '</td>';
						echo '</tr>';
					} 
					$reqCat->closeCursor(); 
				}	
				catch (PDOException $e) {  
					echo 'ERREUR: select produit : '.$e->getMessage();  
					}
				catch (Exception $e) {  
					echo 'ERREUR: select produit';  

					}
			?>
			</tbody>
		</table>
	</div>

	
	<!-- PIED DE PAGE -->
	<div class=footer>
		<a href="contact.php">Contact</a> -- Copyright HEH&copy;Juin 2019
	</div>
</body>
</html>