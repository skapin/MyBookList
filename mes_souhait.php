<?php
require("include.php");

$page = new Page("MBL");

if ( ! $page->is_logged() )
{
	header('Location: index');
}

$page->addJS('js/livres.js');
$page->html_printPage(true);

echo '
<article>
  <h2 class="page-header">Mes Souhaits</h2>
  <div class="table-responsive">';
  
	$tab = new Tab("");
	$tab->setHeader('Titre','Auteur','Date','Prix','Liens','Autre','Action');
  
	$livres = Bdd::sql_fetch_array_assoc( "SELECT *
									FROM MBL_wish
									JOIN MBL_livre ON MBL_wish.id_livre=MBL_livre.id
									WHERE MBL_wish.id_user=?",array($_SESSION['id_user']) );

	for ( $i = 1 ; $i <= $livres[0]; $i++ ) 
	{
		$tab->setTrId(stripslashes($livres[$i]['id_livre']) );
		$tab->add_row(stripslashes($livres[$i]['titre']) ,
						stripslashes($livres[$i]['auteur']),
						stripslashes($livres[$i]['date_parution']),
						stripslashes($livres[$i]['prix']),
						stripslashes($livres[$i]['lien']),
						stripslashes($livres[$i]['autre']),
						'<button id="ajouterlivre" 
								name="ajouterlivre" 
								class="btn btn-success col-md-2" 
								onclick="postId(\''.$livres[$i]['id_livre'].'\', \'ajaxbiblio.php\', \'supprWish\');
										TINY.box.show(
								{	url:\'popupadd_livre.php\',
									post:\'id='.$livres[$i]['id_livre'].'&titre='.$livres[$i]['titre'].'&auteur='.$livres[$i]['auteur'].'\',
									width:700,height:520,opacity:20,topsplit:3,top:100
								})"><span class="glyphicon glyphicon-plus"></span></button>'.
						'<button id="ajouterlecture" 
								name="ajouterlecture" 
								class="btn btn-info col-md-2 col-md-offset-1" 
								onclick="postId(\''.$livres[$i]['id_livre'].'\', \'ajaxbiblio.php\', \'supprWish\');
										TINY.box.show(
								{	url:\'popupadd_lecture.php\',
									post:\'id='.$livres[$i]['id_livre'].'&titre='.$livres[$i]['titre'].'&auteur='.$livres[$i]['auteur'].'\',
									width:700,height:520,opacity:20,topsplit:3,top:100
								})"><span class="glyphicon glyphicon-eye-open"></span></button>'.
						'<button id="retirerlivre" name="retirerlivre" class="btn btn-danger col-md-2 col-md-offset-1" 
								onclick="postId(\''.$livres[$i]['id_livre'].'\', \'ajaxbiblio.php\', \'supprWish\')"><span class="glyphicon glyphicon-remove"></span></button>'
						);
	}
  
  echo $tab->getTab("table table-striped");
  
	echo '
  </div>
</article>
';


echo '</div>';
$page->html_footer();
?>
