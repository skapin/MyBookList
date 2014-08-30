<?php
require("include.php");

if ( empty($_POST['titre']) && empty($_POST['auteur']) && empty($_POST['id']))
{
	echo '->';
	print_r($_POST['titre']);
    echo 'Echec 19.76.78';
    die();
}
Page::createCSRF();
$str ='<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<script type="text/javascript" src="js/jquery-2.1.1.js"></script>
  </head>

';
$str .= '<article>

  <h2 class="page-header">Ajouter ce livre à votre bibliotèque</h2>
  <blockquote class="blockquote-reverse">'.post2bdd($_POST['titre']).'
  <footer>'.post2bdd($_POST['auteur']).'</footer>
  </blockquote>
  <form   class="form-signin" role="form" action="mes_livres.php" method="post">';


$str .= form_preped_text("","date_achat","Date d'achat","1973",1,0);  
$str .= '
<div class="form-group">
	<div class="input-group">
	<span class="input-group-addon">Etat</span>
	<select class="form-control" id="etat" name="etat">
';
$etats = Livre::getAllEtat();

	for ( $i = 1 ; $i <= $etats[0]; $i++ ) 
	{
		$str .= '<option>'.stripslashes($etats[$i]['nom']).'</option>';
	}

$str .='
	</select>
	</div>
  </div>
';  
$str .= form_preped_text("","lieu","Lieu","Maison",1,0); 
$str .=form_hidden('id', post2bdd($_POST['id']) );
  

$str .= '
<div class="form-group">
	<div class="input-group">
	<span class="input-group-addon">Format</span>
	<select class="form-control" id="format" name="format">
';
$formats = Livre::getAllFormat();

	for ( $i = 1 ; $i <= $formats[0]; $i++ ) 
	{
		$str .= '<option>'.stripslashes($formats[$i]['nom']).'</option>';
	}

$str .='
	</select>
	</div>
  </div>';
$str .= form_preped_text("","autre","Autre","...",1,0);  
	
  $str .= '<p>Livre emprunté ?</p>';
  $str .= form_preped_text("","emprunter","Propietaire","",1,0);
  
  
  $str .= '<div class="form-group">
    <button id="addlivre" type="submit" name="addlivre" class="btn btn-success">Ajouter</button>
  </div>
  </form>
</article>';

echo $str;
?>
