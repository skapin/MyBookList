<?php
require_once ('include.php');

class Note  { 
    static public $table="MBL_note";
    
    public function __construct() {
    }
    static public function getAll( )
    {
		$res = Bdd::sql_fetch_array_assoc( "SELECT ".$table.".*
									FROM ".$table." 
									".($where_clause?"WHERE ".$where_clause."=?":""),$params );								
		return $res;
	}
	
	static public function getAllTheme( $listable = true )
    {
		$res = Bdd::sql_fetch_array_assoc( "SELECT  MBL_theme.*
									FROM MBL_theme 
									WHERE listable=?", array($listable) );
		return $res;
	}
	
	static public function getNotesById( $id_fiche )
    {
		$NOTE_MIN = 0;
		$res = Bdd::sql_fetch_array_assoc( "SELECT  MBL_note.*, MBL_theme.*
									FROM MBL_note 
									JOIN MBL_theme ON MBL_theme.id_theme=MBL_note.id_theme
									WHERE note>=? AND MBL_note.id_fiche=? AND MBL_theme.listable=1
									ORDER BY note DESC
									", array($NOTE_MIN, $id_fiche) );
		return $res;
	}
	
	static public function getNoteGeneraleById( $id_fiche )
    {
		$res = Bdd::sql_fetch_array_assoc( "SELECT  MBL_note.*, MBL_theme.*
									FROM MBL_note 
									JOIN MBL_theme ON MBL_theme.id_theme=MBL_note.id_theme
									WHERE MBL_note.id_fiche=? AND MBL_theme.listable=0 AND MBL_note.id_theme=20
									", array( $id_fiche) );
		return $res;
	}
	static public function getNoteRadioById( $id_fiche )
    {
		$res = Bdd::sql_fetch_array_assoc( "SELECT  MBL_note.*, MBL_theme.*
									FROM MBL_note 
									JOIN MBL_theme ON MBL_theme.id_theme=MBL_note.id_theme
									WHERE MBL_note.id_fiche=? AND MBL_theme.listable=0 AND MBL_note.id_theme=99
									", array( $id_fiche) );
		return $res;
	}

    
	static public function delete( $id_livre, $id_user )
    {
	    $tmp_req = Bdd::sql_get_global_bdd();
	    $tmp_req = $tmp_req->pdo()->prepare( 'DELETE FROM `'.Wish::$table.'` WHERE `'.Wish::$table.'`.`id_livre`=? AND `'.Wish::$table.'`.`id_user`=?  ' );
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
