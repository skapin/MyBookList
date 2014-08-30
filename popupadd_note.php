<?php
require("include.php");

if ( empty($_POST['titre']) && empty($_POST['auteur']) && empty($_POST['id']))
{
    echo 'Echec 19.76.78';
    die();
}
Page::createCSRF();
$str ='<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">			
  </head>
';
$str .= '<article>

  <h2 class="page-header">Noter le livre</h2>
  <blockquote class="blockquote-reverse">'.post2bdd($_POST['titre']).'
  <footer>'.post2bdd($_POST['auteur']).'</footer>
  </blockquote>
  <form class="form-inline" role="form" action="lecture_noter.php" method="post">
  ';
  
	$theme = Note::getAllTheme();
	
	for ( $i = 1 ; $i <= $theme[0]; $i++ ) 
	{// btn btn-warning col-md-5 col-md-offset-1
		$str .= '<div class="col-md-5 col-md-offset-1">'.form_check_as_button($theme[$i]['nom'],"theme[]", $theme[$i]['nom'].'/'.$theme[$i]['id_theme']).'</div>';
	}

	$str .=form_hidden('id', post2bdd($_POST['id']) );
  
  $str .= '<div class="form-group">
    <button id="addnote" type="submit" name="addnote" class="btn btn-success">Continuer</button>
  </div>';
  $str .='</form>';

echo $str;
?>
