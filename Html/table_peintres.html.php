<?php
global $data_peintres;

$th = '';
if (isset($_SESSION['ADMIN']) && $_SESSION['ADMIN'])
{
 $th .= ((MODIFICATION & $_SESSION['AUTORISATION']) == MODIFICATION) ? '<th></th>' : '';
 $th .= ((SUPPRESSION & $_SESSION['AUTORISATION']) == SUPPRESSION) ? '<th></th>' : '';
}

$tr = '';
foreach($data_peintres as $val)
{   
  $tr .= '<tr id="'.$val['ID_PEINTRE'].'"><td>'.$val['NOM'].'</td><td>'.$val['PRENOM'].'</td>';
  if (isset($_SESSION['ADMIN']) && $_SESSION['ADMIN'])
  {
    $tr .= ((MODIFICATION & $_SESSION['AUTORISATION']) == MODIFICATION) ? '<td><button class="button modify">Modification</button></td>' : '';
    $tr .= ((SUPPRESSION & $_SESSION['AUTORISATION']) == SUPPRESSION) ? '<td><button class="button trash">Poubelle</button></tr>' : '';
  }
}
?>
<table>
 <caption>Peintres</caption>
 <thead>
  <tr>
   <th>Nom</th>
   <th>Prénom</th>
   <?= $th ?>
  </tr>
 </thead>
 <tbody>
 <?= $tr ?>
 </tbody>
</table>
 
<div id="window"><button id="close" class="button quit">Close</button><img id="picture" /></div>

<div id="admin"><a href="../Php/index.php?EX=admin"></a></div>
