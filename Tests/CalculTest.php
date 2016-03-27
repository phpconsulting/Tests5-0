<?php
/**
 * Fichier de tests des opérations pour le calcul
 * @author Christian Bonhomme
 * @version 1.0
 * @package Calcul4
 */

// Récupération de la class CCalcul
$path = str_replace('Inc', 'Class', realpath('../../Inc')) . '\\';

$file = 'C:\tmp\test.txt';
$fd = fopen($file, 'w');
fwrite($fd, 'REALPATH = ' . realpath('.\..'));
fwrite($fd, 'PATH = ' . $path);
fclose($fd);

require_once ($path . 'CCalcul.class.php');

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