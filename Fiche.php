<?php
require_once ('include.php');

class Fiche  { 
    static public $table="MBL_fiche_lecture";
    
    public function __construct() {
    }

    static public function getAll($where_clause=0, $params=array())
    {
		$table_livre = Fiche::$table;
		$livres = Bdd::sql_fetch_array_assoc( "SELECT ".$table.".*
									FROM ".$table." 
									".($where_clause?"WHERE ".$where_clause."=?":""),$params );								
		return $livres;
	}
    
    
	static public function delete( $id_fiche, $id_user )
    {
	    $tmp_req = Bdd::sql_get_global_bdd();
	    $tmp_req = $tmp_req->pdo()->prepare( 'DELETE FROM `'.Fiche::$table.'` WHERE `'.Fiche::$table.'`.`id`=? AND `'.Fiche::$table.'`.`id_user`=?  ' );
	     if ( !($tmp_req->execute( array( $id_fiche, $id_user ) )) && $GLOBALS['debug'] )
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
	
	
	
	
}
