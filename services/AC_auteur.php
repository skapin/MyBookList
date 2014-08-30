<?php
require_once ('../include.php');
/* veillez bien à vous connecter à votre base de données */

$array = array();
$datas= array();


$titres = Bdd::sql_fetch_array_assoc('SELECT * FROM MBL_livre WHERE auteur LIKE ?', array( '%'.post2bdd($_GET['query']).'%' ) );

$array = array();

for ( $i = 1 ; $i <= $titres[0]; $i++ ) 
{	
	$element['data'] = stripslashes($titres[$i]['auteur']);
	$element['value'] = stripslashes($titres[$i]['auteur']);
	
	$datas['suggestions'][] = $element;
}

echo json_encode($datas);
?>
