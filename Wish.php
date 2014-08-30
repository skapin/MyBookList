<?php
require_once ('include.php');

class Wish  { 
    static public $table_wish="MBL_wish";
    
    public function __construct() {
    }

    static public function getAll($where_clause=0, $params=array())
    {
		$table_livre = Wish::$table_wish;
		$livres = Bdd::sql_fetch_array_assoc( "SELECT ".$table_wish.".*
									FROM ".$table_wish." 
									".($where_clause?"WHERE ".$where_clause."=?":""),$params );								
		return $livres;
	}
    
    
	static public function delete( $id_livre, $id_user )
    {
	    $tmp_req = Bdd::sql_get_global_bdd();
	    $tmp_req = $tmp_req->pdo()->prepare( 'DELETE FROM `'.Wish::$table_wish.'` WHERE `'.Wish::$table_wish.'`.`id_livre`=? AND `'.Wish::$table_wish.'`.`id_user`=?  ' );
	     if ( !($tmp_req->execute( array( $id_livre, $id_user ) )) && $GLOBALS['debug'] )
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
