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

  <h2 class="page-header">Ajouter ce livre à vos souhaits</h2>
  <blockquote class="blockquote-reverse">'.post2bdd($_POST['titre']).'
  <footer>'.post2bdd($_POST['auteur']).'</footer>
  </blockquote>
  <form   class="form-signin" role="form" action="liste_livres.php" method="post">';


$str .= form_preped_text("","prix","Prix","15-25 €",1,0);  

$str .=form_hidden('id', post2bdd($_POST['id']) );  


$str .= '<div class="form-group">
  <label class="sr-only col-md-1 control-label" for="lien"></label>
    <div class="input-group">
      <span class="input-group-addon">Liens</span>
      <textarea id="lien" name="lien" class="form-control"></textarea>  
  </div>
</div>';


$str .= '<div class="form-group">
  <label class="sr-only col-md-1 control-label" for="autre"></label>
    <div class="input-group">
      <span class="input-group-addon">Commentaire</span>
      <textarea id="autre" name="autre" class="form-control"></textarea>  
  </div>
</div>';




$str .= '<div class="form-group">
    <button id="addWish" type="submit" name="addWish" class="btn btn-success">Ajouter</button>
  </div>
  </form>
</article>';

echo $str;
?>
