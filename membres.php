<?php
require("include.php");

$page = new Page("Communaute");

/**************   CORPS     *****************/
$page->html_printPage(true);

$str =  '<div class="page-header">';

$str .= '<h1>Liste des membres</h1></div>';
$tab = new Tab("");
$tab->setHeader('Pseudo','Nombre de livre','lus');

$membres = User::getAll();
for ( $i = 1 ; $i <= $membres[0]; $i++ ) 
{	
	$tab->add_row( bdd2html($membres[$i]['pseudo']), '<a href="http://www.mybooklist.fr/mes_livres.php?pseudo='.bdd2html($membres[$i]['pseudo']).'" >'.bdd2html($membres[$i]['NBR_LIVRE']).'<a/>' , '<a href="http://www.mybooklist.fr/mes_lectures.php?pseudo='.bdd2html($membres[$i]['pseudo']).'" >'.bdd2html($membres[$i]['NBR_LECTURE']).'<a/>' );
	
}
$str .= $tab->getTab("table table-striped table-livre infinityscroll").'<br /><br />';


$str .= '</div>';

echo $str;
$page->html_footer();
?>
