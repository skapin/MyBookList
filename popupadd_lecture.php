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

  <h2 class="page-header">Marquer ce livre lu.</h2>
  <blockquote class="blockquote-reverse">'.post2bdd($_POST['titre']).'
  <footer>'.post2bdd($_POST['auteur']).'</footer>
  </blockquote>
  <form   class="form-signin" role="form" action="mes_lectures.php" method="post">';


$str .= form_preped_text( "", "date_lecture", "Date de lecture", date('Y'), 1, 0);  
$str .= '
	</select>
	</div>
  </div>
';  
$str .=form_hidden('id', post2bdd($_POST['id']) );
  
  $str .= '<div class="form-group">
  <label class="sr-only col-md-1 control-label" for="commentaire"></label>
    <div class="input-group">
      <span class="input-group-addon">Commentaire</span>
      <textarea id="commentaire" name="commentaire" class="form-control"></textarea>  
  </div>
</div>';

  $str .= '<div class="form-group">
    <button id="addlecture" type="submit" name="addlecture" class="btn btn-success">Ajouter</button>
  </div>
  </form>
</article>';

echo $str;
?>
