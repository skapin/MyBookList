<?php
require("include.php");

$page = new Page();
if ( ! $page->is_logged() )
{
	echo 'Vous devez être connecté pour effectuer cette action';
}
else
{
	if ( ! empty($_GET['format']) && $_GET['format']=='csv' && $_GET['action']=='export' )
	{
		$csv = new CSV(';');		
		$livres = Bdd::sql_fetch_array_assoc( "SELECT MBL_livre.auteur,MBL_livre.titre, MBL_livre.date_parution
									FROM MBL_biblio
									JOIN MBL_livre ON MBL_biblio.id_livre=MBL_livre.id
									WHERE MBL_biblio.id_user=?",array($_SESSION['id_user']) );
		
		$csv->setHeader('Auteur', 'Titre','Date');
		for ( $i = 1; $i < $livres[0]; $i++ )
		{
			$csv->addRow($livres[$i]);
		}
		
		$csv->output("biblioteque.csv");
		
		//echo "Livre supprimé de votre bibliotèque.";
	}
	else if ( ! empty($_GET['format']) && $_GET['format'] == 'xml' && $_GET['action'] == 'export' )
	{
		$livres = Bdd::sql_fetch_array_assoc( "SELECT MBL_livre.auteur,MBL_livre.titre, MBL_livre.date_parution
							FROM MBL_biblio
							JOIN MBL_livre ON MBL_biblio.id_livre=MBL_livre.id
							WHERE MBL_biblio.id_user=?",array($_SESSION['id_user']) );
		 
		header("Content-type: application/xml");
		header("Content-disposition: attachment; filename=biblioteque.xml");
		print Livre::convertToXML( $livres );
	}
	
	else
	{
		echo "Erreur.";
	}
}

