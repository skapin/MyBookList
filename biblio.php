<?php
require("include.php");

$page = new Page("MBL");


$page->html_printPage(true);

echo '<div class="container theme-showcase" role="main">
<div class="jumbotron">
</div>';


echo '
<article>
  <h2 class="page-header">Les Livres enregistrés</h2>
  <div class="table-responsive">';
  
  $tab = new Tab("Mes Livres");
  
  echo $tab->getTab("table table-striped");
  
	echo '
  </div>
</article>
';




echo '</div>';
$page->html_footer();
?>
