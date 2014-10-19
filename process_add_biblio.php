<?php
require("include.php");

Page::start_session_once();

if (  Page::is_logged() && !empty($_GET['titre']) && !empty($_GET['auteur']) && !empty($_GET['date']) && is_numeric($_GET['date']) && isset($_GET['commentaire'])  )
{
	$req = "INSERT INTO `MBL_livre` ( titre, auteur, date_parution, commentaire, id_createur ) VALUES ( ?,?,?,?, ? )";
    $vals = array( post2bdd($_GET['titre']), post2bdd($_GET['auteur']), post2bdd($_GET['date']), post2bdd($_GET['commentaire']), post2bdd($_SESSION['id_user']));
    
    
	if ( Bdd::sql_insert( $req, $vals ) )
	{
		header('Location: liste_livres.php?notification=0');
		die();
		exit();
	}
	else
	{
		header('Location: liste_livres.php?notification=1');
		die();
		exit();
	}

}
else
{
    echo 'Echec 19.76.754';
    header('Location: liste_livres.php?notification=2');
	die();
	exit();
}

?>
