<?php 
session_start(); 

if (isset($_SESSION['message'])) { 
			echo 'Attention: '. $_SESSION['message'] ; 
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
						</li><li><a href="login.php">Se connecter</a>
						</li>
					</ul>
	</div>
	
	<!-- CORPS PRINCIPAL -->
	<div class=main>
	
						
						
		<form action="creerCompte.php" method="post">
			<fieldset>
					<legend>Créer un compte</legend>
					<div class=connexion>
									
						<table>
							<tr>
							<td><label>Votre nom:</td><td><input type="text" name="nom" size="64" maxlength="256" value=""> </label></td>
							</tr>
							<tr>
							<td><label>Votre prénom:</td><td><input type="text" name="prenom" size="64" maxlength="256" value=""> </label></td>
							</tr>
							<tr>
							<td><label>Adresse de livraison:</td><td><input type="text" name="adresse" size="64" maxlength="8000" value=""></label></td>
							</tr>
							<tr>
							<td><label>Adresse e-mail:</td><td><input type="text" name="email" size="64" maxlength="64" value=""> </label></td>
							</tr>
							<tr>
							<td><label>Mot de passe:<br>(au moins 4 caractères)</td><td><input type="password" name="mdp1" size="64" maxlength="64" value=""> </label></td>
							</tr>
							<tr>
							<td><label>Entrez le mot de passe à nouveau:</td><td><input type="password" name="mdp2" size="64" maxlength="64" value=""> </label></td>
							</tr>
							<tr>
							<td></td><td><input type="submit" value="Créer votre compte" name="submitted"> </td>
							</tr>
						</table> 
						
					</div>
			</fieldset>
		<br>Vous possédez déjà un compte? <a href='login.php'>Identifiez-vous</a>
		</form>
	</div>
	<!-- PIED DE PAGE -->
		<div class=footer>
			Copyright HEH&copy;2019
		</div>
</body>
</html>