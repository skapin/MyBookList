<?php
require_once ('include.php');

class ViewTab  { 

    public function __construct($id_user=0) {

    }
    
    
    static public function finderArea()
    {
		$str = '
		<form class="form-inline" role="form">
			<label class="control-label" >Recherche : </label>';
		$str .= form_preped_text("","rechercheLivreTitre","Titre","Né en 1984",1,0,'');
		$str .= form_preped_text("","rechercheLivreAuteur","Auteur","Abauzi Adrien ",1,0,'');
		$str .= '<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon">Trier</span>
							<select class="combobox form-control" id="triLivre" name="tri-livre">';

								$str .= '<option value="auteur"'.((Livre::getOrder()=='auteur')?' selected ':'').'>Auteur</option>';
								$str .= '<option value="titre"'.((Livre::getOrder()=='titre')?' selected ':'').'>Titre</option>';
								$str .= '<option value="date_parution"'.((Livre::getOrder()=='date_parution')?' selected ':'').'>Date</option>';
				$str .=  '</select>
						</div>
					  </div>';
		
		$str .= '</form><br /><br />';
		return $str;
	}
	
	static public function filterAZArea()
	{
		$str = '
			<div class="filter-area">
				<form   class="form-inline" role="form" action="" method="">';
		$str .= '
					  <div class="form-group">
							<button type="button" class="btn btn-default filter-letter">Reset</button>
					  </div>';
		foreach(range('A','Z') as $i) 
		{
			$str .= '
					  <div class="form-group">
							<button type="button" class="btn btn-default filter-letter">'.$i.'</button>
					  </div>';
		}
		$str .= '<br /><br /><br />
				</form>
			</div>
			';
		return $str;
	}
	static public function setInfiniteScroll( $action )
	{
		return '
			<script>setInfiniteScrollService(\''.$action.'\');infiniteScroll();</script>
			<div id="content"></div>
		';
	}
	static public function scriptAutoComplete()
	{
		return '<script type="text/javascript" src="js/autocomplete.js"></script>';
	}
    
    static public function printLivres()
    {
		$str = ViewTab::setInfiniteScroll('liste_livres').'
		<article>
			<h2 class="page-header">Les Livres existants</h2>
			<br />
			<div class="table-responsive">';
		$str .= ViewTab::finderArea();
		
		$livres = Livre::getAllByLimit( $_SESSION['id_user'], 0 );
		$str .= ViewTab::getLivreTabFormated( $livres );
		
		return $str;
	}
	
	static public function getTabClass( )
	{	
		return  'table table-striped table-livre infinityscroll';
	}
	static public function createTab( $titre )
	{
		return '
<article>
  <h2 class="page-header">'.$titre .'</h2>
  <br />
  <div class="table-responsive">';
	}

	
	static public function getLivreTabFormated( $livres , $only_row=false)
	{
			
		$tab = new Tab("");
		$tab->setHeader('Titre','Auteur','Date','Commentaire','Actions <small class="text-muted">(Ajouter/Lu/Voulu)</small>');
		if ( empty($livres) )
			$livres = array(0);
		
		for ( $i = 1 ; $i <= $livres[0]; $i++ ) 
		{	
			$action = '';
			if ( Page::is_logged() )
			{
				if ( empty($livres[$i]['mon_livre_id']) )
				{
					$action .= Bouton::addLivre( $livres[$i] );
				}
				else
				{
					$action .= Bouton::hiddenButton('btn btn-danger col-md-2');
				}		
				if ( empty($livres[$i]['id_fiche_lecture']) )
				{
					$action .= Bouton::addLecture( $livres[$i]);
				}
				else
				{
					$action .= Bouton::hiddenButton('btn btn-danger col-md-2 col-md-offset-1');
				}	/*.
							'<button id="supprimerLivre" 
									name="supprimerLivre" 
									class="btn btn-danger col-md-2 col-md-offset-1" 
									onclick="TINY.box.show(
									{	url:\'popupremove_livre.php\',
										post:\'id='.$livres[$i]['id'].'&titre='.$livres[$i]['titre'].'&auteur='.$livres[$i]['auteur'].'\',
										width:700,height:320,opacity:20,topsplit:3,top:100
									})"><span class="glyphicon glyphicon-remove"></span></button>'*/
				if ( empty($livres[$i]['id_wish']) &&  empty($livres[$i]['mon_livre_id'])  )
				{					
					$action .= Bouton::addWish( $livres[$i] );
				}
				else
				{
					$action .= Bouton::hiddenButton('btn btn-danger col-md-2 col-md-offset-1');
				}	
									
			}
			else
			{
				$action = '';
			}
			if ( $only_row )
			{
				$tab->add_row_css(truncate(bdd2html($livres[$i]['titre']),$GLOBALS['truncate_field_size']) ,
							truncate(bdd2html($livres[$i]['auteur']),$GLOBALS['truncate_field_size']),
							truncate(bdd2html($livres[$i]['date_parution']),$GLOBALS['truncate_field_size']),
							truncate(bdd2html($livres[$i]['commentaire']),$GLOBALS['truncate_field_size']),
							$action,
							"hidden"
							);
			}
			else
			{
				$tab->add_row(truncate(bdd2html($livres[$i]['titre']),$GLOBALS['truncate_field_size']) ,
							truncate(bdd2html($livres[$i]['auteur']),$GLOBALS['truncate_field_size']),
							truncate(bdd2html($livres[$i]['date_parution']),$GLOBALS['truncate_field_size']),
							truncate(bdd2html($livres[$i]['commentaire']),$GLOBALS['truncate_field_size']),
							$action
							);
			}
			
		}
		if ( $only_row )
		{
			return $tab->getBody();
		}
		else
		{
			$str = $tab->getTab( ViewTab::getTabClass() );	
			return $str;
		}
		
	}
	
	
	public static function getMesLivresFormated( $livres, $id_user, $only_row=false )
	{
		$show_personal_action = false;
		if ( empty($livres) )
			$livres = array(0);
			
		if ( Page::is_logged()  && empty($_GET['pseudo'])  )
		{
			$show_personal_action = true;
		}
		$tab = new Tab("");
		$tab->setHeader('Titre','Auteur','Date d\'achat','Lieu','Commentaire','Actions');
	  		
		//echo '<div class="" >';
		
		
		for ( $i = 1 ; $i <= $livres[0]; $i++ ) 
		{
			$actions = '';
			if ( $show_personal_action )
			{
				if ( !empty($livres[$i]['id_livre_biblio']) )
				{
					$actions = '<button id="restituerlivre" name="restituerlivre" class="btn btn-wish col-md-9 col-md-offset-1" 
									onclick="TINY.box.show(
									{	url:\'popuprestituer.php\',
										post:\'id='.$livres[$i]['id_mon_livre'].'&titre='.$livres[$i]['titre'].'&auteur='.$livres[$i]['auteur'].'\',
										width:700,height:250,opacity:20,topsplit:3,top:100
									})"
									><small>Restituer à '.$livres[$i]['proprietaire'].'</small></button>';
				}
				else if ( !empty($livres[$i]['id_mon_livre_biblio']) )
				{
					$actions = '<button id="recupererlivre" name="recupererlivre" class="btn btn-info col-md-10 col-md-offset-1" 
									onclick="TINY.box.show(
									{	url:\'popuprecuperer.php\',
										post:\'id='.$livres[$i]['id_mon_livre'].'&titre='.$livres[$i]['titre'].'&auteur='.$livres[$i]['auteur'].'\',
										width:700,height:250,opacity:20,topsplit:3,top:100
									})"
									><small>Récuperer à '.$livres[$i]['personne'].'</small></button>';
					
				}
				else
				{
					$actions .= '<button id="preterlivre" name="preterlivre" class="btn btn-success col-md-3 col-md-offset-1" 
									onclick="TINY.box.show(
									{	url:\'popuppreter.php\',
										post:\'id='.$livres[$i]['id_mon_livre'].'&titre='.$livres[$i]['titre'].'&auteur='.$livres[$i]['auteur'].'\',
										width:700,height:350,opacity:20,topsplit:3,top:100
									})"
									>Preter</button>';
									
					if ( empty($livres[$i]['id_fiche_lecture']) )
					{
						$actions .= Bouton::addLecture( $livres[$i]);
					}
					else
					{
						$actions .= Bouton::hiddenButton('btn btn-danger col-md-2 col-md-offset-1');
					}
					
					$actions .= '<button id="retirerlivre" name="retirerlivre" class="btn btn-danger col-md-3 col-md-offset-1" onclick="postId(\''
									.$livres[$i]['id_mon_livre'].
									'\', \'ajaxbiblio.php\', \'supprLivreBiblio\')">Retirer</button>';
				}
			}
			else // visite du profile
			{
				if ( empty($livres[$i]['id_wish']) )
				{					
					$actions .= Bouton::addWish( $livres[$i] );
				}
				
			}
							
			
			
			$tab->setTrId(bdd2html($livres[$i]['id_mon_livre']) );
			$tab->add_row(bdd2html($livres[$i]['titre']) ,
							bdd2html($livres[$i]['auteur']),
							bdd2html($livres[$i]['date_achat']),
							bdd2html($livres[$i]['lieu']),
							bdd2html($livres[$i]['autre']),
							 $actions);
		}
		if ( $only_row )
		{
			return $tab->getBody();
		}
		else
		{
			return $tab->getTab( ViewTab::getTabClass() ); //"table table-striped"
		}
			
	}

	
}
