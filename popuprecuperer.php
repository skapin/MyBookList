<?php
require("include.php");

if ( empty($_POST['titre']) && empty($_POST['auteur']) && empty($_POST['id']) && !Page::is_logged() )
{
    echo 'Echec 19.76.78';
    die();
}
$str ='<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">			
  </head>
';
$str .= '<article>

  <h2 class="page-header">Récuperer ce livre</h2>
  <blockquote class="blockquote">'.post2bdd($_POST['titre']).'
  <footer>'.post2bdd($_POST['auteur']).'</footer>
  </blockquote>
  <form   class="form-signin" role="form" action="mes_livres.php" method="post">';
$str .=form_hidden('id', post2bdd($_POST['id']) );  

$str .= '<div class="form-group">
    <button id="recupererLivre" type="submit" name="recupererLivre" class="btn btn-success">Récuperer</button>
  </div>
  </form>
</article>';

echo $str;
?>
