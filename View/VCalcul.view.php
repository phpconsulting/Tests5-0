<?php
/**
  * Fichier de class de types vues pour le calcul
 * @author Christian Bonhomme
 * @version 1.0
 * @package Calcul9
 */

/**
 * Class de types vues pour le calcul
 */
class VCalcul
{
  /**
   * Constructeur
   * @access public
   *
   * @return none
   */
  public function __construct() {return;}

  /**
   * Destructeur
   * @access public
   *
   * @return none
   */
  public function __destruct() {return;}

  /**
   * Affiche le formulaire du calcul
   * @access public
   *
   * @return none
   */
  public function ShowForm()
  {
    $vhtml = new VHtml();
    $vhtml->showHtml('../Html/calculatrice.html');

    return;

  } // ShowForm()

  /**
   * Affiche le résultat du calcul
   * @access public
   * @param array tableau associatif contenant les données du calcul
   *
   * @return none
   */
   public function ShowCalcul($_calcul)
   {
     echo "<p>{$_calcul['NUM1']} {$_calcul['OPERATION']} {$_calcul['NUM2']} = {$_calcul['RESULTAT']}</p>";

     return;

  } // ShowCalcul($_calcul)

} // VCalcul
?>