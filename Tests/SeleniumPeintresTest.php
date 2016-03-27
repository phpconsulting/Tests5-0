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

// Récupère le chemin absolu du répertoire Inc
$path = str_replace('Inc', 'Tests', realpath('../Inc')) . '\\';

define('URL_TESTS', 'http://localhost/MOOC-WEB2.0/Mooc/Tests/Exo/Tests5-0/Php/');

// Récupération de la classe MPeintres
//require_once('../Mod/MPeintres.mod.php');
/**
 * Class de type ModÃ¨le gÃ©rant la table PEINTRES
 *
 * @author Christian Bonhomme
 * @version 1.0
 * @package Bdd
 */
class MPeintres
{
    /**
     * Connexion Ã  la Base de DonnÃ©es
     * @var object $conn
     */
    private $conn;

    /**
     * Clef primaire de la table PEINTRES
     * @var int $id
     */
    private $id_peintre;

    /**
     * Tableau de gestion de donnÃ©es (insert ou update)
     * @var array $value
     */
    private $value;

    /**
     * Constructeur de la class MPeintres
     * @access public
     *
     * @return none
     */
    public function __construct($_id_peintre = null)
    {
        // Connexion Ã  la Base de DonnÃ©es
        $this->conn = new PDO(DATABASE, LOGIN, PASSWORD);

        // Instanciation du membre $id_peintre
        $this->id_peintre = $_id_peintre;

    } // __construct($_id_peintre = null)

    /**
     * Destructeur de la class MPeintres
     * @access public
     *
     * @return none
     */
    public function __destruct(){}

    /**
     * Modificateur du membre $value
     * @access public
     * @param array tableau des donnÃ©es
     *
     * @return none
     */
    public function SetValue($_value)
    {
        $this->value = $_value;

    } // SetValue($_value)

    /**
     * RÃ©cupÃ¨re plusieurs tuples de la table PEINTRES
     * @access public
     *
     * @return array $result->fetchAll()
     */
    public function SelectAll()
    {
        $query = 'select ID_PEINTRE,
                     NOM,
                     PRENOM,
                     PHOTO
	          from PEINTRES';

        $result = $this->conn->prepare($query);

        $result->execute();

        return $result->fetchAll();

    } // SelectAll()

    /**
     * RÃ©cupÃ¨re un tuple de la table PEINTRES
     * @access public
     *
     * @return array $result->fetch()
     */
    public function Select()
    {
        $query = 'select ID_PEINTRE,
                     NOM,
                     PRENOM,
                     PHOTO
              from PEINTRES
              where ID_PEINTRE = :ID_PEINTRE';

        $result = $this->conn->prepare($query);

        $result->bindValue(':ID_PEINTRE', $this->id_peintre, PDO::PARAM_INT);

        $result->execute();

        return $result->fetch();

    } // Select()

    /**
     * DÃ©clenche une modification des donnÃ©es d'une table
     * @access public
     *
     * @return none
     */
    public function Modify($_type)
    {
        switch ($_type)
        {
            case 'insert' : return $this->Insert();
            case 'update' : return $this->Update();
            case 'delete' : return $this->Delete();
        }
         
    } // Modify($_type)

    /**
     * InsÃ¨re les donnÃ©es d'un tuple dans la table PEINTRES
     * @access private
     *
     * @return none
     */
    private function Insert()
    {
        $query = 'insert into PEINTRES (NOM, PRENOM, PHOTO)
	          values(:NOM, :PRENOM, :PHOTO)';

        $result = $this->conn->prepare($query);

        $result->bindValue(':NOM', $this->value['NOM'], PDO::PARAM_STR);
        $result->bindValue(':PRENOM', $this->value['PRENOM'], PDO::PARAM_STR);
        $result->bindValue(':PHOTO', $this->value['PHOTO'], PDO::PARAM_STR);

        $result->execute();

        $this->id_peintre = $this->conn->lastInsertId();

        $this->value['ID_PEINTRE'] = $this->id_peintre;

        return $this->value;

    } // Insert()

    /**
     * InsÃ¨re les donnÃ©es d'un tuple dans la table PEINTRES
     * @access private
     *
     * @return none
     */
    private function Update()
    {
        $query = 'update PEINTRES
              set NOM = :NOM,
                  PRENOM = :PRENOM,
                  PHOTO = :PHOTO
              where ID_PEINTRE = :ID_PEINTRE';

        $result = $this->conn->prepare($query);

        $result->bindValue(':ID_PEINTRE', $this->id_peintre, PDO::PARAM_INT);
        $result->bindValue(':NOM', $this->value['NOM'], PDO::PARAM_STR);
        $result->bindValue(':PRENOM', $this->value['PRENOM'], PDO::PARAM_STR);
        $result->bindValue(':PHOTO', $this->value['PHOTO'], PDO::PARAM_STR);

        $result->execute();

        $this->value['ID_PEINTRE'] = $this->id_peintre;

        return $this->value;

    } // Update()

    /**
     * Supprime un tuple de la table PEINTRES
     * @access private
     *
     * @return none
     */
    private function Delete()
    {
        $query = 'delete from PEINTRES
              where ID_PEINTRE = :ID_PEINTRE';

        $result = $this->conn->prepare($query);

        $result->bindValue(':ID_PEINTRE', $this->id_peintre, PDO::PARAM_INT);

        $result->execute();

        return;
         
    } // Delete()

} // MPeintres

// Récupération de la classe SeleniumTestCase
//require_once('../PHPUnit/Extensions/Selenium2TestCase.php');

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
    
    // Récupération du id_peintre
    $mpeintres = new MPeintres();
    $the_values = $mpeintres->SelectAll();
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
      
    // Récupération du id_peintre
    $mpeintres = new MPeintres();
    $the_values = $mpeintres->SelectAll();
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
      
   // Récupération du id_peintre
    $mpeintres = new MPeintres();
    $the_values = $mpeintres->SelectAll();
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