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

  <h2 class="page-header">Demander à emprunter ce livre</h2>
  <blockquote class="blockquote-reverse">'.post2bdd($_POST['titre']).'
  <footer>'.post2bdd($_POST['auteur']).'</footer>
  </blockquote>
  <form   class="form-signin" role="form" action="liste_livres.php" method="post">';

$str .=form_hidden('id', post2bdd($_POST['id']) );  

$str .= '
<p>Vous êtes sur le point d\'envoyer une requete d\'emprunt. <br /><br />
Afin d\'aider la communication entre les deux membres, il vous est possible
de laisser un court message (136 caractères) en laissant vos coordonnées (e-mail, facebook, twitter, chat etc...).<br /><br /><br />

</p>
<div class="form-group">
  <label class="sr-only col-md-1 control-label" for="autre"></label>
    <div class="input-group">
      <span class="input-group-addon">Note</span>
      <textarea id="autre" name="autre" class="form-control" onkeyup="javascript:MaxLengthTextarea(this, 136);" ></textarea>  
  </div>
</div>';




$str .= '<div class="form-group">
    <button id="addWish" type="submit" name="addWish" class="btn btn-success">Ajouter</button>
  </div>
  </form>
</article>';

echo $str;
?>
