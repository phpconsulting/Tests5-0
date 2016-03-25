<?php
global $content;
$vnav = new VNav();
$vcontent = new $content['class']();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
 <meta charset="utf-8" />
 <title><?=$content['title']?></title>
 <link rel="stylesheet" type="text/css" href="../Css/exo.css" />
</head>

<body>

 <nav>
  <?php $vnav->showNav() ?>
 </nav>

 <div id="content">
  <?php $vcontent->{$content['method']}($content['arg']) ?>
 </div><!-- id="content" -->
 
 <script src="../Js/exo.js"></script>
 
</body>
</html>
