<?php
require("include.php");

if ( empty($_POST['titre']) || empty($_POST['auteur']) || empty($_POST['date']))
{
	echo '->';
	print_r($_POST['titre']);
    echo 'Echec 19.76.78';
    die();
}
Page::createCSRF();

/*************************** HEAD *************************************/
$str ='<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<script type="text/javascript" src="js/jquery-2.1.1.js"></script>
  </head>
<article>
  <h2 class="page-header">Ajouter ce livre à la bibliotèque commune</h2>  
  <blockquote class="blockquote-reverse">'.bdd2text($_POST['titre']).'
  <footer>'.bdd2text($_POST['auteur']).'  ('.bdd2text($_POST['date']).')</footer>
  </blockquote>';

/**********************************************************************/

$distances = Livre::comparerDistance( post2bdd($_POST['titre']), post2bdd($_POST['auteur']), 7);
// livre existant

if ( !empty($distances) && $distances[0] != 0 )
{
	if ( $distances[1]['TOTAL_DISTANCE'] <= 3 )
	{
		$str .= '<h4 class="page-header">Ce livre existe déja dans la base de donnée!</h4>';
		$str .= '<div><br /><br />
					<form  class="form-inline" role="form"  action="liste_livres.php" method="post" >
						<button id="createLivre" name="createLivre" class="btn btn-danger"> Fermer </button>
					</form>
				</div>';
		$str .= '</article>';
	}
	else
	{
		$str .= '<h3>Ce livre semble exister.</h3>';
		$tab = new Tab("");
		$tab->setHeader('Titre','Auteur','Date', 'Pertinence' ,'Actions');
		
		
		for ( $i = 1 ; $i <= $distances[0]; $i++ ) 
		{	
			$actions = '<button id="ajouterlivre" 
							name="ajouterlivre" 
							class="btn btn-success"
							onclick="window.parent.TINY.box.hide()">
							<span class="glyphicon glyphicon-check"></span>
						</button>';
			$tab->add_row( bdd2text($distances[$i]['titre']), bdd2text($distances[$i]['auteur']), bdd2text($distances[$i]['date_parution']), 4/bdd2text($distances[$i]['TOTAL_DISTANCE'])*100, $actions );
		}
		$str .= $tab->getTab('table table-striped');
		$str .= '<div class="row bottom-controler" >';
		$str .= Bouton::validerLivre( $_POST );
		$str .= '<button id="close" 
							name="close" 
							class="btn btn-danger col-md-2 col-md-offset-3"
							onclick="window.parent.TINY.box.hide()">Fermer
							<span class="glyphicon glyphicon-remove"></span>
						</button>';
		$str .= '</div>';
	}
	
}
else
{
	$str .= '
			<form  class="form-inline" role="form"  action="process_add_biblio.php?&titre='.$_POST['titre']
							.'&auteur='.$_POST['auteur']
							.'&date='.$_POST['date']
							.'&commentaire='.$_POST['commentaire'].'" method="post" >
				<button id="createLivre" name="createLivre" class="btn btn-success col-md-4 col-md-offset-8"> Ajouter </button>
			</form>';
	$str .= '</article>';
}
    
echo $str;
    

?>
