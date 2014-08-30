<?php
require("include.php");

$page = new Page("MBL");

if ( ! $page->is_logged() && empty($_POST['id']) )
{
	header('Location: index.php');
}

$page->addJS('js/livres.js');
$page->html_printPage(true);

$str = '
<article>
  <h2 class="page-header">Noter un livre</h2>
  <br />
  <form class="form-inline" role="form" action="mes_lectures.php" method="post">';  
	$str .=form_hidden('id', post2bdd($_POST['id']) );
	
	$note_available[0] = 11;
	for ( $i = 0 ; $i <= $note_available[0]+1; $i++ ) 
	{
		$note_available[] = array( $i, $i );
	}
	
	$str .= '<h3>Note générales</h3><br />';	
	$themes = Note::getAllTheme(false);
	for ( $i = 1 ; $i <= $themes[0]; $i++ ) 
	{
		$str .= '<div class="col-md-12 form-group">'.form_select_bs($themes[$i]['nom'],"note[]", $note_available).'</div>';
		$str .= '<div class="col-md-12"><hr/></div>';
		$_SESSION['theme_id'][]= $themes[$i]['id_theme']; 
	}
	$str .= '<h3>Thèmes</h3><br />';	
	foreach($_POST['theme'] as $theme)
	{
		$themeEXP = explode('/', $theme);
		$theme_name = $themeEXP[0];
		$_SESSION['theme_id'][]= $themeEXP[1]; 
		$str .= '<div class="col-xs-3 form-group">'.form_select_bs($theme_name,"note[]", $note_available).'</div>';
	}	
	  $str .= '<div class="form-group">
    <button id="addnote" type="submit" name="addnote" class="btn btn-success">Noter</button>
  </div>';
  
	$str .= '
  </form>
</article>
';

$str .= '</div>';

echo $str;
$page->html_footer();
?>
