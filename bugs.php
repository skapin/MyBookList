<?php
require("include.php");

$page = new Page("bugs");

/**************   CORPS     *****************/
$page->html_printPage(true);

echo '<div class="page-header">';

echo '<h1>Bugs</h1></div>
Ce site avait pour vocation première une utilisation purement personnelle. Je le partage pour les personnes intéréssées. <br />
Je compte implémenter plus de fonctionnalités comme la détéction de doublon, la mise en relatation des livres par références, la listes des "tops", etc... Mais le temps est limité.
<br />
<br />Pour me faire part des bugs ou des idées d\'amélioration, c\'est par ici :  <br />
<br />
<br />
<h3><a href="https://github.com/skapin/MyBookList/issues"> BugTracker </a> </h3>
';

echo '</div>';
$page->html_footer();
?>
