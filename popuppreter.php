<?php
require("include.php");

if ( empty($_POST['titre']) && empty($_POST['auteur']) && empty($_POST['id']) && !Page::is_logged() )
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

  <h2 class="page-header">Prêter ce livre</h2>
  <blockquote class="blockquote">'.$_POST['titre'].'
  <footer>'.$_POST['auteur'].'</footer>
  </blockquote>
  <form   class="form-signin" role="form" action="mes_livres.php" method="post">';


$str .= form_preped_text("","personne","Personne","Ex : Edward Elric",1,0);  

$str .=form_hidden('id', post2bdd($_POST['id']) );
$str .=form_hidden('action', 'preterLivre' );    

$str .= '<div class="form-group">
    <button id="preterLivre" type="submit" name="preterLivre" class="btn btn-success">Ajouter</button>
  </div>
  </form>
</article>';

echo $str;
?>
