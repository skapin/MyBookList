<?php
require("include.php");

$page = new Page("Communaute");

/**************   CORPS     *****************/
$page->html_printPage(true);

$str =  '<div class="page-header">';

$str .= '<h1>Les Top du site ! </h1></div>
';

/************************* LES PLUS LUS *******************************/
$str .= '<h2>Les plus lus</h2>';
$tab = new Tab("");
$tab->setHeader('Titre','Auteur','Nombre');

$lectures = Livre::getTopLecture( 5 );
for ( $i = 1 ; $i <= $lectures[0]; $i++ ) 
{	
	$tab->add_row( bdd2html($lectures[$i]['titre']), bdd2html($lectures[$i]['auteur']) , bdd2html($lectures[$i]['NBR_LECTURE']) );
	
}
$str .= $tab->getTab("table table-striped table-livre infinityscroll");

/*********************** LES PLUS POSEDES *****************************/
$str .= '<h2>Les plus possédés</h2>';
$tab = new Tab("");
$tab->setHeader('Titre','Auteur','Nombre');

$possedes = Livre::getTopPossedes( 5 );
for ( $i = 1 ; $i <= $possedes[0]; $i++ ) 
{	
	$tab->add_row( bdd2html($possedes[$i]['titre']), bdd2html($possedes[$i]['auteur']) , bdd2html($possedes[$i]['NBR_POSSEDES']) );
	
}
$str .= $tab->getTab("table table-striped table-livre infinityscroll").'<br /><br />';


$str .= '</div>';

echo $str;
$page->html_footer();
?>
