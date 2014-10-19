<?php

require_once ('../include.php');
require_once ('../Page.php');


if ( !empty($_POST['order']) )
{
	Page::createCSRF();
	
	$orders=array("auteur","titre","date_parution");
	$key=array_search($_POST['order'],$orders);
	$order=$orders[$key];
	
	$_SESSION['order_livre'] = $order;	
	echo 'k';
}
if ( !empty($_POST['filter'])  ) 
{
	Page::createCSRF();
	
	/*$filters=array();
	foreach(range('A','Z') as $i) 
	{
		$filters[]=$i;
	}
	$_SESSION['filter_livre'] = getField( $filters, post2bdd($_POST['filter']) );*/
	$_SESSION['filter_livre'] = post2bdd($_POST['filter']);
	echo 'OKAY FOR :'.$_SESSION['filter_livre'];	
}
?>
