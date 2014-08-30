<?php
require("include.php");

$page = new Page("MBL");

if ( ! $page->is_logged() )
{
	header('Location: index');
}


$notification ='';
/*****************Ajouter une lecture*******************************/

if ( $page->is_logged() && isset($_POST['addlecture']) && !empty($_POST['id']) && isset($_POST['date_lecture']) && isset($_POST['commentaire'])  && Page::checkCSRF()  )
{
	
	$req = "INSERT INTO `MBL_fiche_lecture` (id_livre, id_user, date_lecture, commentaire ) VALUES ( ?,?,?,? )";
	if ( empty($_POST['date_lecture']) )
	{
		$timestamp = date('Y-m');
	}
	else 
	{
		$timestamp = post2bdd($_POST['date_lecture']);
	}
    $vals = array( post2bdd($_POST['id']), post2bdd($_SESSION['id_user']), $timestamp, post2bdd($_POST['commentaire']) );
    
    
	if ( Bdd::sql_insert( $req, $vals ) )
	{
		$notification .=  '<p class="bg-success">Livre ajouté à vos lecture.</p>';
	}
	else
	{
		$notification .=  '<p class="bg-danger">Erreur à l\'ajout de votre lecture.</p>';
	}

}
else if ( isset($_POST['addlecture']) )
{
	$notification .=  '<p class="bg-info">Erreur, veuillez remplir tout les champs.</p>';
}

/*****************Ajouter une note *******************************/

if ( $page->is_logged() && isset($_POST['addnote']) && !empty($_POST['note']) && !empty($_POST['id']) && Page::checkCSRF())
{
	
	$req = "INSERT INTO `MBL_note` (id_fiche, id_theme, note ) VALUES ( ?,?,? )";
	$i = 0;
	foreach($_POST['note'] as $note)
	{
		$vals = array( post2bdd($_POST['id']), post2bdd($_SESSION['theme_id'][$i]), $note  );	
		if ( Bdd::sql_insert( $req, $vals ) )
		{
			$notification .=  '<p class="bg-success">Livre ajouté à votre bibliotèque.</p>';
		}
		else
		{
			$notification .=  '<p class="bg-danger">Erreur à l\'ajout de votre livre dans la bibliotèque.</p>';
		}

		$i++;
	}
	unset($_SESSION['theme_id']);
	
}
else if ( isset($_POST['addnote']) )
{
	$notification .=  '<p class="bg-info">Erreur, veuillez remplir tout les champs.</p>';
}

/*********************************************************************/


$page->addJS('js/livres.js');
$page->html_printPage(true);
echo $notification;

$show_action = false;
if ( $page->is_logged()  && empty($_GET['pseudo'])  )
{
	$id_user = $_SESSION['id_user'];
	$show_action = true;
}
else if ( ! empty($_GET['pseudo']) )
{
	$datas = Bdd::sql_fetch_array_assoc( "SELECT *
										FROM MBL_user 
										WHERE pseudo=?",array(post2bdd($_GET['pseudo']) )) ;	
	if ( $datas[0] > 0 )
	{
		echo '<h1><small>Membre : </small>'.$datas[1]['pseudo'].'</h1><br /><hr /><br /><br /><br />';
		$id_user = post2bdd($datas[1]['id']);
	}
	else
	{
		
	}
}


echo '
<article>
  <h2 class="page-header">Mes Lectures</h2>
  <div class="table-responsive">';
  
	$tab = new Tab("");
	$tab->setHeader('Titre','Auteur','Date','Themes','Note','☢','Date de lecture','Commentaire','Action');
  
	$livres = Bdd::sql_fetch_array_assoc( "SELECT MBL_fiche_lecture.*, MBL_fiche_lecture.id AS id_fiche_lecture, MBL_fiche_lecture.commentaire AS commentaire_perso,
											MBL_livre.*
									FROM MBL_fiche_lecture
									JOIN MBL_livre ON MBL_fiche_lecture.id_livre=MBL_livre.id
									WHERE MBL_fiche_lecture.id_user=?",array($id_user) );

	//echo '<div class="" >';
	for ( $i = 1 ; $i <= $livres[0]; $i++ ) 
	{
		
		$actions = '';
		if ( $show_action )
		{
			$actions .= '<button id="noterlivre" name="noterlivre" class="btn btn-info col-md-4 col-md-offset-1"
						onclick="TINY.box.show(
								{	url:\'popupadd_note.php\',
									post:\'id='.$livres[$i]['id_fiche_lecture'].'&titre='.$livres[$i]['titre'].'&auteur='.$livres[$i]['auteur'].'\',
									width:800,height:620,opacity:20,topsplit:3,top:100
								})"
						>Noter <span class="glyphicon glyphicon-pencil"></span></button>'.
						'<button id="supprimerfiche" name="supprimerfiche" class="btn btn-danger col-md-2 col-md-offset-1" 
						onclick="postId(\''.$livres[$i]['id_fiche_lecture'].'\', \'ajaxbiblio.php\', \'supprFiche\')">
						<span class="glyphicon glyphicon-remove"></span></button>';
		}
		$theme_raw = Note::getNotesById($livres[$i]['id_fiche_lecture']);
		$theme = '';
		$noteG = Note::getNoteGeneraleById($livres[$i]['id_fiche_lecture']);
		$radioactivite = Note::getNoteRadioById($livres[$i]['id_fiche_lecture']);
		$nxt_c ='';
		for ( $h = 1 ; $h <= $theme_raw[0]; $h++ ) 
		{
			$theme .= $nxt_c . '<abbr title="'.stripslashes($theme_raw[$h]['nom']).'">'.stripslashes($theme_raw[$h]['tag']).'</abbr> ';
			$nxt_c = ' - ';
		}
		$tab->setTrId(stripslashes($livres[$i]['id_fiche_lecture']) );
		$tab->add_row(stripslashes($livres[$i]['titre']) ,
						stripslashes($livres[$i]['auteur']),
						stripslashes($livres[$i]['date_parution']),
						$theme,
						stripslashes( $noteG[1]['note'] ),
						stripslashes( $radioactivite[1]['note'] ),
						stripslashes($livres[$i]['date_lecture']),
						stripslashes($livres[$i]['commentaire_perso']),
						$actions						
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
