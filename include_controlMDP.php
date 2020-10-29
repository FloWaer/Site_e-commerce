<?php
function mdpcontrole($mdp1, $mdp2 = '', $utilisateur = '')
{
	// mdp1 est le nouveau mot de passe
	// mdp2 est l'ancien mot de passe
	// utilisateur est le nom de l'utilisateur
	
	$check = '';
	if (strlen($mdp1) < 7)
		$check = 'mot de passe trop court';
	else if (stristr($mdp2, $mdp1) ||
	    (strlen($mdp2) >= 4 && stristr($mdp1, $mdp2)))
		$check = 'le mot de passe est trop proche du precedent';
	else if (stristr($utilisateur, $mdp1) ||
	    (strlen($utilisateur) >= 4 && stristr($mdp1, $utilisateur)))
		$check = 'le mot de passe contient le nom de l utilisateur';
	if ($check)
		return "Mauvais mot de passe ($check)";
	return 'OK';
}

?>