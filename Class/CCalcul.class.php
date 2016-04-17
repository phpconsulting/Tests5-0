<?php
/**
  * Fichier de class des opérations pour le calcul
 * @author Christian Bonhomme
 * @version 1.0
 * @package Json
 */

/**
 * Class des opérations pour le calcul
 */
class CCalcul
{
  /**
   * @var int opérande gauche
   * @access private
   */  
  var $a;
  
  /**
   * @var int opérande droite
   * @access private
   */ 
  var $b;
  
  /**
   * @var string opération
   * @access private
   */
  var $operation;
  
  /**
   * Constructeur et initialisation des membres de la class
   * @access public
   * @param array tableau associatif des données du calcul
   *
   * @return none
   */
  public function __construct($_calcul)
  {
    $this->a = $_calcul['NUM1'];
    $this->b = $_calcul['NUM2'];
    $this->operation = $_calcul['OPERATION'];

    return;

  } // __construct($_calcul)

  /**
   * Destructeur
   * @access public
   *
   * @return none
   */
  public function __destruct() {return;}

  /**
   * Récupération du résultat du calcul
   * @access public
   *
   * @return int résultat du calcul
   */
  public function resultat()
  {
    switch ($this->operation)
    {
      case '+' : return $this->add();
      case '-' : return $this->subtract();
      case '*' : return $this->multiply();
      case '/' : return $this->divide();
    }

  } // resultat()

  /**
   * Addition
   * @access private
   *
   * @return int résultat de l'addition
   */
  private function add()
  {
    return $this->a + $this->b;

  } // add()

  /**
   * Soustraction
   * @access private
   *
   * @return int résultat de la soustraction
   */
  private function subtract()
  {
    return $this->a * $this->b;

  } // subtract()

  /**
   * Multiplication
   * @access private
   *
   * @return int résultat de la multiplication
   */
  private function multiply()
  {
    return $this->a * $this->b;

  } // multiply()

  /**
   * Division
   * @access private
   *
   * @return int résultat de la division
   */
  private function divide()
  {
    if (0 == $this->b)
    {
      return 'Erreur : division par zéro';
    }

    return $this->a / $this->b;

  } // divide()

} // CCalcul
?>