<?php
require("include.php");

$page = new Page("MBL");
$page->addJS('js/jquery.autocomplete.js');
$page->html_printPage(true);



/*****************Supprimer un livre du catalogue*******************************/

if ( $page->is_logged() && isset($_POST['removelivre']) && !empty($_POST['id'])  )
{    
	if ( Livre::removeById( post2bdd($_POST['id']) ) )
	{
		echo '<p class="bg-success">Livre ajouté à votre bibliotèque.</p>';
	}
	else
	{
		echo '<p class="bg-danger">Erreur à l\'ajout de votre livre dans la bibliotèque.</p>';
	}

}
else if ( isset($_POST['addlivre']) )
{
	echo '<p class="bg-info">Erreur, veuillez remplir tout les champs.</p>';
}



/************* Creer un nouveau wish **************************************/

if (  $page->is_logged() && isset($_POST['addWish']) && !empty($_POST['id']) && isset($_POST['prix']) && isset($_POST['lien']) && isset($_POST['autre']) && Page::checkCSRF() )
{
	$req = "INSERT INTO `MBL_wish` ( id_user, id_livre, prix, lien, autre ) VALUES ( ?,?,?,?,? )";
    $vals = array( post2bdd($_SESSION['id_user']), post2bdd($_POST['id']), post2bdd($_POST['prix']), post2bdd($_POST['lien']), post2bdd($_POST['autre']),);
    
    
	if ( Bdd::sql_insert( $req, $vals ) )
	{
		echo '<p class="bg-success">Souhait créé avec succés !</p>';
	}
	else
	{
		echo '<p class="bg-danger">Erreur à création du souhait.</p>';
	}

}


/************* Creer un nouveau livre **************************************/

if (  Page::is_logged() && isset($_GET['notification']) )
{
	if ( post2bdd($_GET['notification'])==0 )
	{
		echo '<p class="bg-success">Livre créé avec succés !</p>';
	}
	else
	{
		echo '<p class="bg-danger">Erreur à création du livre.</p>';
	}

}

/************************************************************************/

if (  $page->is_logged() )
{
echo '<article>
  <h2 class="page-header">Créer un nouveau livre</h2>
  <form  class="form-inline" role="form"  onsubmit = "return false;" >
  <input type="text" name="titre" placeholder="Titre" id="ADDrechercheLivreTitre" class="form-control">
  <input type="text" name="auteur" placeholder="Auteur" id="ADDrechercheLivreAuteur" class="form-control">
  <input type="text" name="date" placeholder="Date (Ex : 1973)" id="ADDrechercheLivreDate" class="form-control">
  <input type="text" name="commentaire" placeholder="Commentaire" id="ADDrechercheLivreCommentaire" class="form-control">
  <button id="createLivre" name="createLivre" class="btn btn-success" 
  onclick="
  var _titre_ = document.getElementById(\'ADDrechercheLivreTitre\').value;
  var _auteur_ = document.getElementById(\'ADDrechercheLivreAuteur\').value;
  var _date_ = document.getElementById(\'ADDrechercheLivreDate\').value;
  var _commentaire_ = document.getElementById(\'ADDrechercheLivreCommentaire\').value;
  TINY.box.show(
				{	url:\'popupadd_livre_biblio.php\',
					post:\'titre=\'+_titre_+\'&auteur=\'+_auteur_+\'&date=\'+_date_+\'&commentaire=\'+_commentaire_+\'\',
					width:700,height:620,opacity:20,topsplit:3,top:100
				})">
	Ajouter </button>
  </form>
</article>
';
}
/********************************************/
// GET Datas
$livres = Livre::getAllByLimit( $_SESSION['id_user'], 0 );

// Display
$str = ViewTab::setInfiniteScroll('liste_livres');
$str .= ViewTab::createTab( 'Les Livres existants' );
$str .= ViewTab::finderArea();
$str .= ViewTab::filterAZArea();
$str .= ViewTab::getLivreTabFormated( $livres );

$str .= '
	</div>
</article>';
$str .= ViewTab::scriptAutoComplete();


$str .= '<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />';

echo $str;
$page->html_footer();
?>
