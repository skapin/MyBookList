<?php
require_once ('include.php');

class Livre  { 
    static public $table_livre="MBL_livre";
    static public $table_biblio="MBL_biblio";
    private $id_user=0;
    private $id_livre=0;
    
    public function __construct($id_user=0) {
        $this->id_user = $id_user;
    }

    static public function getAll($where_clause=0, $params=array())
    {
		$table_livre = Livre::$table_livre;
		$livres = Bdd::sql_fetch_array_assoc( "SELECT ".$table_livre.".*
									FROM ".$table_livre." 
									".($where_clause?"WHERE ".$where_clause."=?":"")." ORDER BY auteur",$params );								
		return $livres;
	}
	static public function getOrder()
	{
		if ( empty($_SESSION['order_livre']) )
		{
			$order='auteur';
		}
		else
		{
			$order = $_SESSION['order_livre'];
		}
		return $order;
	}
	static public function getFilter( $name )
	{
		$filter = '';
		if ( !empty($_SESSION['filter_'.$name]) )
		{
			$filter = $_SESSION['filter_'.$name];
		}
		return $filter;
	}
	static public function comparerDistance(  $titre, $auteur, $distance )
	{
		$distance = Bdd::sql_fetch_array_assoc("SELECT id, titre, auteur, date_parution, distance_titre, distance_auteur, distance_titre+distance_auteur AS TOTAL_DISTANCE
												FROM ( 
														SELECT  LEVENSHTEIN(LOWER(titre), LOWER('".$titre."')) AS distance_titre,
																LEVENSHTEIN(LOWER(auteur), LOWER('".$auteur."')) AS distance_auteur,
																id,
																titre,
																auteur,
																date_parution
														FROM MBL_livre
														) AS T
												WHERE T.distance_titre < ".$distance." 
													AND T.distance_auteur < ".$distance." 
												ORDER BY T.distance_titre, distance_auteur
												LIMIT 10"
									);
		return $distance;
		
	}
	static public function getTopLecture( $nombre = 5 )
	{
		$livres = Bdd::sql_fetch_array_assoc( "SELECT count(MBL_livre.id) AS NBR_LECTURE, 
												MBL_livre.titre, MBL_livre.auteur, MBL_livre.id
												FROM MBL_livre
												JOIN MBL_fiche_lecture ON MBL_livre.id = MBL_fiche_lecture.id_livre
												GROUP BY MBL_fiche_lecture.id_livre 
												LIMIT ".$nombre );
		return $livres;
	}
	
	static public function getTopPossedes( $nombre = 5 )
	{
		$livres = Bdd::sql_fetch_array_assoc( "SELECT count(MBL_livre.id) AS NBR_POSSEDES, 
												MBL_livre.titre, MBL_livre.auteur, MBL_livre.id
												FROM MBL_livre
												JOIN MBL_biblio ON MBL_livre.id = MBL_biblio.id_livre
												GROUP BY MBL_biblio.id_livre 
												LIMIT ".$nombre );
		return $livres;
	}
	
	
	static public function getMesLivres( $id_user )
	{
		$livres = Bdd::sql_fetch_array_assoc( "SELECT   MBL_biblio.*, 
												MBL_livre.*,
												MBL_emprunt.id_livre_biblio,
												MBL_pret.id_mon_livre_biblio, MBL_pret.personne,
												MBL_wish.id AS id_wish, 
												MBL_fiche_lecture.id AS id_fiche_lecture
								FROM MBL_biblio
								JOIN MBL_livre ON MBL_biblio.id_livre=MBL_livre.id 
									AND MBL_biblio.id_user=?
								LEFT OUTER JOIN MBL_pret ON MBL_biblio.id_mon_livre=MBL_pret.id_mon_livre_biblio
								LEFT OUTER JOIN MBL_emprunt ON MBL_biblio.id_mon_livre=MBL_emprunt.id_livre_biblio
								LEFT OUTER JOIN MBL_wish ON MBL_livre.id = MBL_wish.id_livre
									AND MBL_wish.id_user=?
								LEFT OUTER JOIN MBL_fiche_lecture ON MBL_livre.id = MBL_fiche_lecture.id_livre
									AND MBL_fiche_lecture.id_user=?
								",array($id_user,$id_user,$id_user) );
		return $livres;
	}
	
		static public function getMesLivresByLimit( $id_user, $offset=0 )
	{
		$table_livre = Livre::$table_livre;
		$order = Livre::getOrder();
		$filter = Livre::getFilter('livre');
		$livres = Bdd::sql_fetch_array_assoc( "SELECT   MBL_biblio.*, 
												MBL_livre.*,
												MBL_emprunt.id_livre_biblio,
												MBL_pret.id_mon_livre_biblio, MBL_pret.personne,
												MBL_wish.id AS id_wish, 
												MBL_fiche_lecture.id AS id_fiche_lecture
								FROM MBL_biblio
								JOIN MBL_livre ON MBL_biblio.id_livre=MBL_livre.id 
									AND MBL_biblio.id_user=:id_user
								LEFT OUTER JOIN MBL_pret ON MBL_biblio.id_mon_livre=MBL_pret.id_mon_livre_biblio
								LEFT OUTER JOIN MBL_emprunt ON MBL_biblio.id_mon_livre=MBL_emprunt.id_livre_biblio
								LEFT OUTER JOIN MBL_wish ON MBL_livre.id = MBL_wish.id_livre
									AND MBL_wish.id_user=:id_user
								LEFT OUTER JOIN MBL_fiche_lecture ON MBL_livre.id = MBL_fiche_lecture.id_livre
									AND MBL_fiche_lecture.id_user=:id_user
								WHERE ".$table_livre.".".$order." LIKE :queryString
								ORDER BY ".$table_livre.".".$order." LIMIT 15 OFFSET ".$offset
								, array(':queryString' => post2bdd($filter) . '%', ':id_user' => $id_user));	
		return $livres;
	}
	
	static public function getAllByLimit( $user_id='', $offset=0)
    {
		$table_livre = Livre::$table_livre;
		$livres = '';
		
		$order = Livre::getOrder();
		$filter = Livre::getFilter('livre');
		
		
		
		if ( !empty($user_id) )
		{
			$livres = Bdd::sql_fetch_array_assoc( "SELECT ".$table_livre.".*, 
															MBL_biblio.id_mon_livre AS mon_livre_id, 
															MBL_wish.id AS id_wish, 
															MBL_fiche_lecture.id AS id_fiche_lecture
									FROM ".$table_livre."  
									LEFT OUTER JOIN MBL_biblio ON ".$table_livre.".id=MBL_biblio.id_livre
										AND MBL_biblio.id_user=".$user_id."
									LEFT OUTER JOIN MBL_wish ON MBL_livre.id = MBL_wish.id_livre
										AND MBL_wish.id_user=".$user_id."
									LEFT OUTER JOIN MBL_fiche_lecture ON MBL_livre.id = MBL_fiche_lecture.id_livre
										AND MBL_fiche_lecture.id_user=".$user_id."
									WHERE ".$table_livre.".".$order." LIKE :queryString
									ORDER BY ".$order." LIMIT 15 OFFSET ".$offset, array(':queryString' => post2bdd($filter) . '%'));
		}
		else
		{
			$livres = Bdd::sql_fetch_array_assoc( "SELECT ".$table_livre.".*
									FROM ".$table_livre." 
									WHERE ".$table_livre.".".$order." LIKE :queryString
									ORDER BY ".$order." LIMIT 15 OFFSET ".$offset, array(':queryString' => post2bdd($filter) . '%'));	
		}
		return $livres;
	}
	
    
    static public function getAllLike( $col, $params=array())
    {
		$table_livre = Livre::$table_livre;
		$livres = Bdd::sql_fetch_array_assoc( "SELECT ".$table_livre.".*
									FROM ".$table_livre." 
									WHERE `".post2bdd($col)."` LIKE ? ", $params );
		return $livres;
	}
    
    static public function getById($id_livre)
    {
		$table_livre = Livre::$table_livre;
		$livres = Bdd::sql_fetch_array_assoc( "SELECT ".$table_livre.".*
									FROM ".$table_livre."
									WHERE ".$table_livre.".id=?",array($id_livre) );								
		return $livres;
	}
    
    static public function getByUserId($id_user)
    {
		$table_livre = Livre::$table_livre;
		$livres = Bdd::sql_fetch_array_assoc( "SELECT ".$table_biblio.",
											".$table_livre.".*
									FROM ".$table_biblio."
									JOIN ".$table_livre." ON ".$table_biblio.".id_livre=".$table_livre.".id
									WHERE ".$table_biblio.".id_user=?",array($id_user) );								
		return $livres;
	}
    
    static public function getAllFormat()
    {
		$formats = Bdd::sql_fetch_array_assoc( "SELECT *
									FROM MBL_format" );								
		return $formats;
	}
	
	static public function getAllEtat()
    {
		$etats = Bdd::sql_fetch_array_assoc( "SELECT *
									FROM MBL_etat" );								
		return $etats;
	}
	
	static public function removeById( $id )
    {
	    $tmp_req = Bdd::sql_get_global_bdd();
	    $tmp_req = $tmp_req->pdo()->prepare( 'DELETE FROM `MBL_livre` WHERE `MBL_livre`.`id`=?  ' );
	     if ( !($tmp_req->execute( array( $id ) )) && $GLOBALS['debug'] )
			 {
					 echo 'Bdd:: suppression echou&eacute; #19.17.8'.'<br />';
						if ( $GLOBALS['debug'] )
						{
								print_r($tmp_req->errorInfo());
								echo '<br />';
						}
					 return false;
	     }
			 return true;
		return $etats;
	}

	static public function deleteById( $id )
    {
	    $tmp_req = Bdd::sql_get_global_bdd();
	    $tmp_req = $tmp_req->pdo()->prepare( 'DELETE FROM `MBL_biblio` WHERE `MBL_biblio`.`id_mon_livre`=?  ' );
	     if ( !($tmp_req->execute( array( $id ) )) && $GLOBALS['debug'] )
			 {
					 echo 'Bdd:: suppression echou&eacute; #19.17.8'.'<br />';
						if ( $GLOBALS['debug'] )
						{
								print_r($tmp_req->errorInfo());
								echo '<br />';
						}
					 return false;
	     }
			 return true;
		return $etats;
	}
	
	static public function convertToXML( $livres )
	{
		unset($livres[0]);
		

		$livres = changekeyname( $livres, 'author', 'auteur');
		$livres = changekeyname( $livres, 'title', 'titre');
		$livres = changekeyname( $livres, 'year', 'date_parution');
		
		$xml = new SimpleXMLElement('<bookstore/>');
		
		array_to_xml($livres, $xml, 'book');
		//array_walk_recursive( $livres, array ($xml, 'addChild') );
		return $xml->asXML();
		
	}
	
}
