<?php
/**
 * Fichier de tests selenium
 * @author Christian Bonhomme
 * @version 1.0
 * @package Calcul11
 */

// Connexion Base de Données
/*define('DATABASE', 'mysql:host=votre_host;dbname=nom_de_votre_base');
define('LOGIN', 'login_de_connexion');
define('PASSWORD', 'mot_de_passe_de_connexion');*/
define('DATABASE', 'mysql:host=localhost;dbname=methodologie-web2.0');
define('LOGIN', 'root');
define('PASSWORD', 'gulliver');

define('URL_TESTS', 'http://localhost/MOOC-WEB2.0/Mooc/Tests/Exo/Tests5-0/Php/');

// Récupération de la class CCalcul
$path = str_replace('Tests', 'Mod', realpath(dirname(__FILE__))) . '\\';
$path = str_replace('Mod-', 'Tests-', $path);
require_once ($path . 'MPeintres.mod.php');

/**
 * class Selenium Test Case pour tester l'application Web Calculatrice
 */
class SeleniumPeintresTest extends PHPUnit_Extensions_Selenium2TestCase
{
  private $img_tests;
    
  /**
   * Initialisation de l'environnement de test
   */
  protected function setUp()
  {
    // Test sur firefox
    $this->setBrowser('firefox');
    // Url du répertoire de l'application à tester
    $this->setBrowserUrl(URL_TESTS);
    
    // Récupère le chemin absolu du répertoire Inc et le remplace par Tests
    $path = str_replace('Inc', 'Tests', realpath('../Inc')) . '\\';
    
    // Chemin absolu des images de tests
    $this->img_tests = $path . 'Img\\';

  } // setUp()
  
  /**
   * Test sur les messages
   * @access public
   *
   * @return none
   */
  public function testMessages()
  {
    // Test sur le message de connexion
    $this->messageConnexion();
     
    // Test sur le message Image
    $this->messageImage();

    // Test sur le message Nom Prénom
    $this->messageNomPreNom();
    
    // Test sur le message Nom
    $this->messageNom();

    // Test sur le message Prénom
    $this->messagePrenom();
      
  } // testMessages()
  
  /**
   * Test sur le message de connexion
   * @access public
   *
   * @return none
   */
  public function messageConnexion()
  {
    // Connexion à l'administration
    $this->url('index.php?EX=admin');
    
    // Login/mot de passe erroné
    $this->byId('login')->value('test');
    $this->byId('pwd')->value('tes');
    
    // Soumission du formulaire
    $submit = $this->byCssSelector('input[type="submit"]');
    $submit->click();
    
    // Vérification du message d'erreur
    $this->assertEquals('Votre Login et/ou votre Mot de passe sont erronés !', $this->byId('erreur')->text());
    
  } // testMessageConnexion()

  /**
   * Test sur le message Image
   * @access public
   *
   * @return none
   */
  public function messageImage()
  {
    // Connexion à l'administration
    $this->url('index.php?EX=admin');
    
    // Login/mot de passe valide
    $this->byId('login')->value('test');
    $this->byId('pwd')->value('test');
  
    // Soumission du formulaire
    $submit = $this->byCssSelector('input[type="submit"]');
    $submit->click();
  
    // Insertion du Nom et du Prénom
    $this->byId('nom')->value('Dali');
    $this->byId('prenom')->value('Salvador');
  
    // Soumission du formulaire
    $submit = $this->byCssSelector('input[type="submit"]');
    $submit->click();
  
    // Vérification du message d'erreur
    $error = $this->byCssSelector('#error p');
    $this->assertEquals("Vous n'avez pas choisi d'image !", $error->text());

    // Sortie du message d'erreur
    $button = $this->byCssSelector('#error button');
    $button->click();
    
  } // messageImage()
  
  /**
   * Test sur le message Nom Prénom
   * @access public
   *
   * @return none
   */
  private function messageNomPrenom()
  {
    // Connexion à l'administration
    $this->url('index.php?EX=admin');
    
    // Login/mot de passe valide
    $this->byId('login')->value('test');
    $this->byId('pwd')->value('test');
  
    // Soumission du formulaire
    $submit = $this->byCssSelector('input[type="submit"]');
    $submit->click();
  
    $this->timeouts()->implicitWait(100);
      
    // Insertion du Nom, du Prénom et de l'Image
    $this->byId('nom')->value('');
    $this->byId('prenom')->value('');
    $this->byId('photo')->value($this->img_tests . 'dali.png');

    // Soumission du formulaire
    $submit = $this->byCssSelector('input[type="submit"]');
    $submit->click();
     
    // Vérification du message d'erreur
    $error = $this->byCssSelector('#error p');      
    $this->assertEquals('Vous devez renseigner les champs suivants :', $error->text());
    $error = $this->byCssSelector('#error p+p');
    $this->assertEquals('- Nom', $error->text());
    $error = $this->byCssSelector('#error p+p+p');
    $this->assertEquals('- Prénom', $error->text());
  
    // Sortie du message d'erreur
    $button = $this->byCssSelector('#error button');
    $button->click();
      
  } // testMessageNomPrenom()

  /**
   * Test sur le message Nom
   * @access public
   *
   * @return none
   */
  private function messageNom()
  {
    // Connexion à l'administration
    $this->url('index.php?EX=admin');
    
    // Login/mot de passe valide
    $this->byId('login')->value('test');
    $this->byId('pwd')->value('test');
  
    // Soumission du formulaire
    $submit = $this->byCssSelector('input[type="submit"]');
    $submit->click();
  
    // Insertion du Prénom et de l'Image
    $this->byId('nom')->value('');
    $this->byId('prenom')->value('Salvador');
    $this->byId('photo')->value($this->img_tests . 'dali.png');
  
    // Soumission du formulaire
    $submit = $this->byCssSelector('input[type="submit"]');
    $submit->click();
   
    // Vérification du message d'erreur
    $error = $this->byCssSelector('#error p');
    $this->assertEquals('Vous devez renseigner le champ suivant :', $error->text());
    $error = $this->byCssSelector('#error p+p');
    $this->assertEquals('- Nom', $error->text());
  
    // Sortie du message d'erreur
    $button = $this->byCssSelector('#error button');
    $button->click();
  
  } // testMessageNom()

  /**
   * Test sur le message Prénom
   * @access public
   *
   * @return none
   */
  private function messagePrenom()
  {
    // Connexion à l'administration
    $this->url('index.php?EX=admin');
    
    // Login/mot de passe valide
    $this->byId('login')->value('test');
    $this->byId('pwd')->value('test');
  
    // Soumission du formulaire
    $submit = $this->byCssSelector('input[type="submit"]');
    $submit->click();
  
    // Insertion du Nom et de l'Image
    $this->byId('nom')->value('Dali');
    $this->byId('prenom')->value('');
    $this->byId('photo')->value($this->img_tests . 'dali.png');
  
    // Soumission du formulaire
    $submit = $this->byCssSelector('input[type="submit"]');
    $submit->click();
  
    $this->timeouts()->implicitWait(100);
  
    // Vérification du message d'erreur
    $error = $this->byCssSelector('#error p');     
    $this->assertEquals('Vous devez renseigner le champ suivant :', $error->text());
    $error = $this->byCssSelector('#error p+p');
    $this->assertEquals('- Prénom', $error->text());
  
    // Sortie du message d'erreur
    $button = $this->byCssSelector('#error button');
    $button->click();
  
  } // messagePrenom()

  /**
   * Test de l'insertion
   * @access public
   *
   * @return none
   */
  public function testInsert()
  {
    // Connexion à l'administration
    $this->url('index.php?EX=admin');
    
    // Login/mot de passe valide
    $this->byId('login')->value('test');
    $this->byId('pwd')->value('test');
  
    // Soumission du formulaire
    $submit = $this->byCssSelector('input[type="submit"]');
    $submit->click();
      
   // Insertion du Nom, du Prénom et de l'Image
    $this->byId('nom')->value('Dali');
    $this->byId('prenom')->value('Salvador');
    $this->byId('photo')->value($this->img_tests . 'dali.png');
    
    // Soumission du formulaire
    $submit = $this->byCssSelector('input[type="submit"]');
    $submit->click();

    $this->timeouts()->implicitWait(100);
    
    // Récupération du id_peintre
    $mpeintres = new MPeintres();
    $the_values = $mpeintres->SelectAll();
    
    $this->timeouts()->implicitWait(100);
    
    foreach($the_values as $val)
    {
      if ('Dali' == $val['NOM'] && 'Salvador' == $val['PRENOM'])
      {
        $id_peintre = $val['ID_PEINTRE'];
      }
    }
  
    // Vérification des données de la ligne du id_peintre
    $tr_id_peintre = $this->byId($id_peintre);
    $td_id_peintre1 = $tr_id_peintre->byCssSelector('td');     
    $this->assertEquals('Dali', $td_id_peintre1->text());
    $td_id_peintre2 = $tr_id_peintre->byCssSelector('td+td');
    $this->assertEquals('Salvador', $td_id_peintre2->text());
    
  } // testInsert()

  /**
   * Test de l'image
   * @access public
   *
   * @return none
   */
  public function testImage()
  {
    // Connexion à la consultation
    $this->url('index.php?EX=peintres');
    
    // Récupération du id_peintre
    $mpeintres = new MPeintres();
    $the_values = $mpeintres->SelectAll();

    $this->timeouts()->implicitWait(100);
    
    foreach($the_values as $val)
    {
      if ('Dali' == $val['NOM'] && 'Salvador' == $val['PRENOM'])
      {
        $id_peintre = $val['ID_PEINTRE'];
      }
    }
    
    // Clic sur le nom du peintre
    $tr_id_peintre = $this->byId($id_peintre);
    $td_id_peintre = $tr_id_peintre->byCssSelector('td');
    $td_id_peintre->click();

    $this->timeouts()->implicitWait(100);
    
    // Vérification de l'existence de l'image
    $picture = $this->byId('picture');
    $this->assertRegExp('/..\/Upload\/dali.png/', $picture->attribute('src'));
    
   // Vérification de la taille de l'image
    $size = $picture->size();
    $this->assertEquals('390', $size['height']);
    $this->assertEquals('600', $size['width']);
    
  } // testImage()

  /**
   * Test de mise à jour
   * @access public
   *
   * @return none
   */
  public function testUpdate()
  {
    // Connexion à l'administration
    $this->url('index.php?EX=admin');
    
    // Login/mot de passe valide
    $this->byId('login')->value('test');
    $this->byId('pwd')->value('test');
  
    // Soumission du formulaire
    $submit = $this->byCssSelector('input[type="submit"]');
    $submit->click();

    $this->timeouts()->implicitWait(100);
    
    // Récupération du id_peintre
    $mpeintres = new MPeintres();
    $the_values = $mpeintres->SelectAll();
    
    $this->timeouts()->implicitWait(100);   
    
    foreach($the_values as $val)
    {
      if ('Dali' == $val['NOM'] && 'Salvador' == $val['PRENOM'])
      {
        $id_peintre = $val['ID_PEINTRE'];
      }
    }

    // Clic sur le bouton de modification
    $tr_id_peintre = $this->byId($id_peintre);
    $button_dali = $tr_id_peintre->byCssSelector('td+td+td button');
    $button_dali->click();

    // Vérification des données du formulaire
    $nom = $this->byId('nom');
    $this->assertEquals('Dali', $nom->value());
    $prenom = $this->byId('prenom');
    $this->assertEquals('Salvador', $prenom->value());
    $preview = $this->byId('preview');   
    $this->assertRegExp('/..\/Upload\/dali.png/', $preview->attribute('src'));

    // Modification des données du formulaire
    $nom->clear();
    $nom->value('Salvador');
    $prenom->clear();
    $prenom->value('Dali');
    $this->byId('photo')->value($this->img_tests . 'monet.png');

    // Soumission du formulaire
    $submit = $this->byCssSelector('input[type="submit"]');
    $submit->click();
     
    // Vérification des données de la ligne du id_peintre
    $tr_id_peintre = $this->byId($id_peintre);
    $td_id_peintre1 = $tr_id_peintre->byCssSelector('td');
    $this->assertEquals('Salvador', $td_id_peintre1->text());
    $td_id_peintre2 = $tr_id_peintre->byCssSelector('td+td');
    $this->assertEquals('Dali', $td_id_peintre2->text());

    // Clic sur le nom du peintre
    $td_id_peintre1->click();
    
    $this->timeouts()->implicitWait(100);
       
    // Vérification de l'existence de l'image modifiée
    $picture = $this->byId('picture');
    $this->assertRegExp('/..\/Upload\/monet.png/', $picture->attribute('src'));
    
   // Vérification de la taille de l'image modifiée
    $size = $picture->size();
    $this->assertEquals('424', $size['height']);
    $this->assertEquals('600', $size['width']);
   
  } // testUpdate()
  
  /**
   * Test de supression
   * @access public
   *
   * @return none
   */
  public function testDelete()
  {
    // Connexion à l'administration
    $this->url('index.php?EX=admin');
    
    // Login/mot de passe valide
    $this->byId('login')->value('test');
    $this->byId('pwd')->value('test');
  
    // Soumission du formulaire
    $submit = $this->byCssSelector('input[type="submit"]');
    $submit->click();

    $this->timeouts()->implicitWait(100);
    
   // Récupération du id_peintre
    $mpeintres = new MPeintres();
    $the_values = $mpeintres->SelectAll();
    
    $this->timeouts()->implicitWait(100);
    
    foreach($the_values as $val)
    {
      if ('Salvador' == $val['NOM'] && 'Dali' == $val['PRENOM'])
      {
        $id_peintre = $val['ID_PEINTRE'];
      }
    }
  
   // Clic sur le bouton de suppression
    $tr_id_peintre = $this->byId($id_peintre);
    $button_id_peintre = $tr_id_peintre->byCssSelector('td+td+td+td button');     
    $button_id_peintre->click();
    
    // Clic sur le bouton de confirmation
    $this->acceptAlert();

    // Temps d'attente
    $this->timeouts()->implicitWait(100);
    $this->timeouts()->implicitWait(100);
    
    // Vérification de la non existence de la ligne des peintres
    try 
    {
      $element = $this->byId($id_peintre);
    } 
    catch (PHPUnit_Extensions_Selenium2TestCase_WebDriverException $e) 
    {
      $this->assertEquals(PHPUnit_Extensions_Selenium2TestCase_WebDriverException::NoSuchElement, $e->getCode());
      
      return;
    }
    
    $this->fail('L\'élément n\'existe pas.');
    
  } // testDelete()
  
} // SeleniumPeintresTest