<?php
require("include.php");

if ( !isset($_GET['offset']) )
{
	echo "Error 1.21.10";
}
else if ( empty($_GET['action']) )
{
	echo "Error 1.21.11";
}
else
{
	// Get ID USER
	Page::start_session_once();
	$id_user = '';
	if ( !empty($_SESSION['id_user']) )
	{
		$id_user = $_SESSION['id_user'];
	}
	// Get OFFSET
	$offset = '';
	if ( ! is_numeric( $_GET['offset'] ) )
	{
		echo "ErrorVRangedLivre#";
		return;
		die();
	}
	else
	{
		$offset = post2bdd($_GET['offset']);
	}
	//*********** LISTE_LIVRES **************//
	if ( getField( Page::$scrollServiceUrl, post2bdd($_GET['action'])) == Page::$scrollServiceUrl[0]  )
	{
		$livres =  Livre::getAllByLimit( $id_user, $offset );
		echo ViewTab::getLivreTabFormated( $livres, true );
	}
	//*********** MES_LIVRES **************//
	else if ( getField( Page::$scrollServiceUrl, post2bdd($_GET['action'])) == Page::$scrollServiceUrl[1]  )
	{
		$livres = Livre::getMesLivresByLimit( $id_user, $offset );
		echo ViewTab::getMesLivresFormated( $livres, $id_user, true );	
	}
	//*********** ERRORS **************//
	else
	{
		echo "Error 1.21.12";
	}
}
