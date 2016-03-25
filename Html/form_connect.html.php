<?php 
$erreur = (isset($_SESSION['AUTORISATION']) && 'erreur' == $_SESSION['AUTORISATION']) ? '<p id="erreur">Votre Login et/ou votre Mot de passe sont erronés !</p>' : ''
?>

<form id="user" action="../Php/index.php?EX=connect" method="post">
 <fieldset>
  <legend>Connexion</legend>
  <?= $erreur ?>
  <p>
   <label for="login">Login</label>
   <input id="login" class="required" name="LOGIN" value="" size="10" maxlength="10" />
  </p>
  <p>
   <label for="pwd">Mot de passe</label>
   <input id="pwd" class="required" type="password" name="PASSWORD" value="" size="10" maxlength="10" />
  </p>
  <p>
   <input type="submit" value="Ok" />
  </p>
 </fieldset>
</form>
<div id="error"></div><!-- id="error" -->
