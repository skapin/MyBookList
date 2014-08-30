<?php
require("include.php");

$page = new Page("MBL");


$page->html_printPage();


echo '
<h2>Fonctions existantes : </h2>
<p>
<ul>
	<li>Ajouter un livre à la bibliotèque commune,</li>
	<li>Ajouter/supprimer des livres à votre bibliotèque personnelle,</li>
	<li>Preter un livre à une personne,</li>
	<li>Créer une fiche de lecture et noter un livre,</li>
	<li>Partager votre bibliotèque sur la toile,</li>
	<li>Liste des membres,</li>
	<li>Export bibliotèque format CSV,</li>
	<li>Protection CSRF,</li>
	<li>Trier les livres</li>
</ul>

Pour en profiter, il vous suffit de créer un compte en moins de 1 minute.
</p>

<h2>Fonctions à venir : </h2>
<p>
<ul>
	<li>Mes dernières lectures, Mes derniers livres,</li>
	<li>Demander le livre d\'un utilisateur,</li>
	<li>Référencer les livres connexes,</li>
	<li>Afficher les notes et moyenne des notes,</li>
	<li>Traiter les EPUB,</li>
	<li>Suppréssion des doublons auto.</li>
	<li>Suppréssion des livres de la bibliotèques de manière collaborative,</li>
	<li>Dessiner arbre des connexions,</li>
	<li>Vignette,</li>
	<li>Valoriser un livre,</li>
	<li>Modifier les saisies,</li>
	<li>Import/Export des biblioteques aux formats CVS et XML.</li>
</ul>

Pour en profiter, il vous suffit de créer un compte en moins de 1 minute.
</p>


';

echo '<br />
<br />
<br />
<br />
<p class="text-center"><img src="img/logo.png" alt="logo" /></p>';



$page->html_footer();
?>
