<?php
require("include.php");

$page = new Page();
if ( ! $page->is_logged() )
{
	echo 'Vous devez être connecté pour effectuer cette action';
}
else
{
	if ( ! empty($_POST['action']) && $_POST['action']=='supprLivreBiblio' && !empty($_POST['id']) )
	{
		Livre::deleteById( post2bdd($_POST['id']) );
		echo "Livre supprimé de votre bibliotèque.";
	}
	else if ( ! empty($_POST['action']) && $_POST['action']=='supprWish' && !empty($_POST['id']) )
	{
		Wish::delete( post2bdd($_POST['id']), $_SESSION['id_user'] );
		echo "Souhait supprimé de votre bibliotèque.";
	}
	else if ( ! empty($_POST['action']) && $_POST['action']=='supprFiche' && !empty($_POST['id']) )
	{
		Fiche::delete( post2bdd($_POST['id']), $_SESSION['id_user'] );
		echo "Fiche supprimée de votre bibliotèque.";
	}
	
	else
	{
		echo "Erreur à la suppression de votre souhait.";
	}
}

