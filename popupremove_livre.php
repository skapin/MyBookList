<?php
require("include.php");

if ( empty($_POST['titre']) && empty($_POST['auteur']) && empty($_POST['id']))
{
	echo '->';
	print_r($_POST['titre']);
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

  <h2 class="page-header">Supprimer ce livre du catalogue</h2>
  <blockquote class="blockquote-reverse">'.post2bdd($_POST['titre']).'
  <footer>'.post2bdd($_POST['auteur']).'</footer>
  </blockquote>
  <form   class="form-signin" role="form" action="liste_livres.php" method="post">';
$str .=form_hidden('id', post2bdd($_POST['id']) );
  

$str .= '<button id="removelivre" type="submit" name="removelivre" class="btn btn-success col-md-4">Supprimer</button>
  </form>
</article>';

echo $str;
?>
