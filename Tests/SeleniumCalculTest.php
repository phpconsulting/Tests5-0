<?php
/**
 * Fichier de tests selenium
 * @author Christian Bonhomme
 * @version 1.0
 * @package Calcul11
 */

/**
 * class Selenium Test Case pour tester l'application Web Calculatrice
 */
class SeleniumTest extends PHPUnit_Extensions_Selenium2TestCase
{    
  /**
   * Initialisation de l'environnement de test
   */
  protected function setUp()
  {    
    $this->setBrowser('firefox');
    $this->setBrowserUrl('http://localhost/MOOC-WEB2.0/Mooc/Tests/Exo/Tests5-0/Php/');

  } // setUp()

  /**
   * Test de l'addition
   * @access public
   *
   * @return none
   */
  public function testAdd()
  {
      $this->url('index.php?EX=calcul');
      
      $this->byName('NUM1')->value(15);
      $this->byName('NUM2')->value(5);
      $this->byName('OPERATION')->value('+');
      
      $submit = $this->byCssSelector('input[type="submit"]');
      $submit->click();
      
      $this->timeouts()->implicitWait(100);
      
      $this->assertEquals('15 + 5 = 20', $this->byId('resultat')->text());
  
  } // testAdd()

  /** Test de la soustraction
   * @access public
   *
   * @return none
   */
  public function testSubtract()
  {
      $this->url('index.php?EX=calcul');
      
      $this->byName('NUM1')->value(25);
      $this->byName('NUM2')->value(10);
      $this->byName('OPERATION')->value('-');
      
      $submit = $this->byCssSelector('input[type="submit"]');
      $submit->click();
      
      $this->timeouts()->implicitWait(100);
      
      $this->assertEquals('25 - 10 = 15', $this->byId('resultat')->text());
  
  } // testSubtract()
  
  /** Test de la multiplication
   * @access public
   *
   * @return none
   */
  public function testMultiply()
  {      
      $this->url('index.php?EX=calcul');
      
      $this->byName('NUM1')->value(25);
      $this->byName('NUM2')->value(5);
      $this->byName('OPERATION')->value('*');
      
      $submit = $this->byCssSelector('input[type="submit"]');
      $submit->click();
      
      $this->timeouts()->implicitWait(100);
      
      $this->assertEquals('25 * 5 = 125', $this->byId('resultat')->text());
      
  } // testMultiply()
  
  /** Test de la division
   * @access public
   *
   * @return none
   */
  public function testDivide()
  {
      $this->url('index.php?EX=calcul');
      
      $this->byName('NUM1')->value(20);
      $this->byName('NUM2')->value(5);
      $this->byName('OPERATION')->value('/');
      
      $submit = $this->byCssSelector('input[type="submit"]');
      $submit->click();
      
      $this->timeouts()->implicitWait(100);
      
      $this->assertEquals('20 / 5 = 4', $this->byId('resultat')->text());
      
  } // testDivide()
  
  /** Test de la division par zéro
   * @access public
   *
   * @return none
   */
  public function testDivideZero()
  {
      $this->url('index.php?EX=calcul');
      
      $this->byName('NUM1')->value(20);
      $this->byName('NUM2')->value(0);
      $this->byName('OPERATION')->value('/');
      
      $submit = $this->byCssSelector('input[type="submit"]');
      $submit->click();
      
      $this->timeouts()->implicitWait(100);
      
      $this->assertEquals('20 / 0 = Erreur : division par zéro', $this->byId('resultat')->text());
      
      
  } // testDivideZero()
  
} // SeleniumTest