<?php
class VNav
{
  public function __construct(){}
  
  public function __destruct(){}
  
  public function showNav()
  {
    $li = (isset($_SESSION['ADMIN']) && $_SESSION['ADMIN']) ? '<li><a href="../Php/index.php?EX=deconnect">Déconnexion</a></li>' : '';
    
    echo <<<HERE
      <h1 id="logo" title="XHTML"><a href="../Php/index.php">XHTML</a></h1>
      <ol id="menu">
       <li><a href="../Php/index.php?EX=calcul">Calculatrice</a></li>
       <li><a href="../Php/index.php?EX=peintres">Peintres</a></li>
       $li
      </ol>
HERE;
            
  } // showNav()
  
} // VNav
?>