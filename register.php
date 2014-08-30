<?php
require("include.php");

$page = new Page("register");

$page->addSheet("css/signin.css");
$page->addJs("js/register.js");
$page->html_printPage(false);

echo '<div class="container theme-showcase" role="main">';


echo '
<form class="form-signin" role="form" action="compte.php" method="post">
  <h2 class="form-signin-heading">Inscription</h2>

';
echo $page->getUserForm();


echo '
<div class="form-group has-warning has-feedback" id="formPassConf">
    <label class="control-label" for="passconf" id="labelPassConf">Entrer mot de passe</label>
    <div class="input-group">
      <span class="input-group-addon">Confirmation</span>
      <input id="passconf" name="passconf" class="form-control" onchange="checkPass(\'pass\', \'passconf\');" ) type="password">    
  </div>
  <span class="glyphicon glyphicon-warning-sign form-control-feedback" id="glyphPassConf"></span>
</div>';

echo '<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="Valider"></label>
  <div class="col-md-4">
    <button id="register" name="register" class="btn btn-success">Valider !</button>
  </div>
</div>
</form>
';


echo '</div>';
$page->html_footer();
?>
