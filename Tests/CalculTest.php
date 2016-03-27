<?php
/**
 * Fichier de tests des opérations pour le calcul
 * @author Christian Bonhomme
 * @version 1.0
 * @package Calcul4
 */

// Récupération de TestCase.php
//require_once ('../PHPUnit/Framework/TestCase.php');

// Récupération de la class CCalcul
//require_once '../Class/CCalcul.class.php';

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
        return $this->a - $this->b;

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

/**
 * class PHPUnit Test Case pour tester la class CCalcul
 */
class CalculTest extends PHPUnit_Framework_TestCase
{
  /**
   * Test de l'addition
   * @access public
   *
   * @return none
   */
  public function testAdd()
  {
    $val['NUM1'] = 1;
    $val['NUM2'] = 5;
    $val['OPERATION'] = '+';
    
    $CCalcul = new CCalcul($val);    
    $this->assertEquals(6, $CCalcul->resultat());
    $this->assertNotEquals(7, $CCalcul->resultat());

    return;

  } // testAdd()

  /**
   * Test de la soustraction
   * @access public
   *
   * @return none
   */
  public function testSubtract()
  {
    $val['NUM1'] = 5;
    $val['NUM2'] = 2;
    $val['OPERATION'] = '-';
    
    $CCalcul = new CCalcul($val);    
    $this->assertEquals(3, $CCalcul->resultat());
    $this->assertNotEquals(1, $CCalcul->resultat());

    return;

  } // testSubtract()

  /**
   * Test de la multiplication
   * @access public
   *
   * @return none
   */
  public function testMultiply ()
  {
    $val['NUM1'] = 6;
    $val['NUM2'] = 5;
    $val['OPERATION'] = '*';
    
    $CCalcul = new CCalcul($val);    
    $this->assertEquals(30, $CCalcul->resultat());
    $this->assertNotEquals(7, $CCalcul->resultat());

    return;

  } // testMultiply()

  /**
   * Test de la division
   * @access public
   *
   * @return none
   */
  public function testDivide()
  {
    $val['NUM1'] = 30;
    $val['NUM2'] = 5;
    $val['OPERATION'] = '/';
    
    $CCalcul = new CCalcul($val);    
    $this->assertEquals(6, $CCalcul->resultat());
    $this->assertNotEquals(7, $CCalcul->resultat());

    return;

  } // testDivide()

  /**
   * Test de la division par zéro
   * @access public
   *
   * @return none
   */
  public function testDivideByZero()
  {
    $val['NUM1'] = 3;
    $val['NUM2'] = 0;
    $val['OPERATION'] = '/';
    
    $CCalcul = new CCalcul($val);    
    $this->assertEquals('Erreur : division par zéro', $CCalcul->resultat());

    return;

  } // testDivideByZero()

} // CalculTest
?>