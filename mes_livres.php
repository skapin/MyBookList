<?php
require("include.php");

$page = new Page("MBL");
$page->addJS('js/jquery.autocomplete.js');
$notification='';


/*****************Ajouter un livre a la biblio*******************************/

if ( $page->is_logged() && isset($_POST['addlivre']) && !empty($_POST['id']) && isset($_POST['date_achat']) && isset($_POST['etat']) && isset($_POST['format']) && isset($_POST['autre'])   && Page::checkCSRF() )
{
	
	$req = "INSERT INTO `MBL_biblio` (id_livre, id_user, date_achat, lieu, format, etat, autre ) VALUES ( ?,?,?,?,?,?,? )";
    $vals = array( post2bdd($_POST['id']), post2bdd($_SESSION['id_user']), post2bdd($_POST['date_achat']), post2bdd($_POST['lieu']), post2bdd($_POST['format']), post2bdd($_POST['etat']), post2bdd($_POST['autre'])  );
    
    
	if ( Bdd::sql_insert( $req, $vals ) )
	{
		$notification .= '<p class="bg-success">Livre ajouté à votre bibliotèque.</p>';
	}
	else
	{
		$notification .= '<p class="bg-danger">Erreur à l\'ajout de votre livre dans la bibliotèque.</p>';
	}

}
else if ( isset($_POST['addlivre']) )
{
	$notification .= '<p class="bg-info">Erreur, veuillez remplir tout les champs.</p>';
}


/***************** Preter un livre *******************************/

if ( $page->is_logged() && isset($_POST['preterLivre']) && !empty($_POST['id']) && Page::checkCSRF() )
{
	
	$req = "INSERT INTO `MBL_pret` (id_livre_biblio, personne, date_debut, date_fin ) VALUES ( ?,?,?,? )";
    $vals = array( post2bdd($_POST['id']), post2bdd($_POST['personne']), date('Y'), 0 );
    
	if ( Bdd::sql_insert( $req, $vals ) )
	{
		$notification .= '<p class="bg-success">Livre prêté !</p>';
	}
	else
	{
		$notification .= '<p class="bg-danger">Erreur lors du prêt de votre livre.</p>';
	}

}
else if ( isset($_POST['preterLivre']) )
{
	$notification = '<p class="bg-info">Erreur, veuillez remplir tout les champs.</p>';
}

/***************** Recuperer un livre *******************************/

if ( $page->is_logged() && isset($_POST['recupererLivre']) && !empty($_POST['id']) && Page::checkCSRF() )
{
	$tmp_req = Bdd::sql_get_global_bdd();
    $tmp_req = $tmp_req->pdo()->prepare( 'DELETE FROM `MBL_pret` WHERE id_livre_biblio=?' );
    if ( !($tmp_req->execute( array( post2bdd($_POST['id'])  ) )) && $GLOBALS['debug'] )
	{
		$notification .= 'Bdd:: suppression echou&eacute; #19.17.8'.'<br />';
		if ( $GLOBALS['debug'] )
		{
				print_r($tmp_req->errorInfo());
				echo '<br />';
		}
		$notification .= '<p class="bg-danger">Erreur lors de la récupération de votre livre.</p>';
	}
	else
	{
		$notification .= '<p class="bg-success">Livre récupéré !</p>';
	}
}
else if ( isset($_POST['preterLivre']) )
{
	$notification .= '<p class="bg-info">Erreur, veuillez remplir tout les champs.</p>';
}

/*******************************************************************/

$page->addJS('js/livres.js');
$page->html_printPage(true);

echo $notification;



$show_personal_action = false;
if ( $page->is_logged()  && empty($_GET['pseudo'])  )
{
	$id_user = $_SESSION['id_user'];
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
else
{
	header('Location: index');
}	

if ( $page->is_logged() && empty($_GET['pseudo']))
  {
	  echo '<h2 class="page-header">Importer, Exporter, Partager ! </h2>
	  <p>
		Partager votre bibliotèque ! <a href="http://www.mybooklist.fr/mes_livres.php?pseudo='.$page->get_pseudo().'" >http://www.mybooklist.fr/mes_livres.php?pseudo='.$page->get_pseudo().'</a>
	  </p>
	  <p>
  <a href="download.php?action=export&format=csv"><button id="exportCVS" name="exportCVS" class="btn btn-success col-md-2 col-md-offset-1" 
								onclick=""
								><span class="glyphicon glyphicon-export"></span> Exporter CVS</button></a>
								
  <a href="download.php?action=export&format=xml"><button id="exportXML" name="exportXML" class="btn btn-success col-md-2 col-md-offset-1" >
													<span class="glyphicon glyphicon-export"></span> Exporter XML
												</button>
	</a>
<br />
<br />
  <button id="importCVS" name="importCVS" class="btn btn-info col-md-2 col-md-offset-1" 
								onclick="TINY.box.show(
								{	url:\'popuppreter.php\',
									post:\'id=\',
									width:700,height:350,opacity:20,topsplit:3,top:100
								})"
								><span class="glyphicon glyphicon-import"></span> Importer CVS</button>
								
	<button id="importXML" name="importXML" class="btn btn-info col-md-2 col-md-offset-1" 
								onclick="TINY.box.show(
								{	url:\'popuppreter.php\',
									post:\'id=\',
									width:700,height:350,opacity:20,topsplit:3,top:100
								})"
								><span class="glyphicon glyphicon-import"></span> Importer XML</button>														
	<br /><br /><br />
	  
	  </p>';
	}
$str='';
// Get Datas
$livres = Livre::getMesLivres( $id_user );

// Diplay
$str = ViewTab::setInfiniteScroll('mes_livres');
$str .= ViewTab::createTab( 'Mes Livres' );
$str .= ViewTab::finderArea();
$str .= ViewTab::filterAZArea();
$str .= ViewTab::getMesLivresFormated( $livres, $id_user, false );
  
	
  
$str .= '
  </div>
</article>'.ViewTab::scriptAutoComplete().'
<br />
<br />
<br />
<br />
';

$str .= '<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /></div>';

echo $str;
$page->html_footer();
?>
