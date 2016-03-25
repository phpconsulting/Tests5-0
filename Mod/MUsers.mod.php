<?php
/**
 * Class de type Modèle gérant la table USERS
 * 
 * @author Christian Bonhomme
 * @version 1.0
 * @package Security
 */
class MUsers
{
  /**
   * Connexion à la Base de Données
   * @var object $conn
   */
  private $conn;

  /**
   * Constructeur de la class MUsers
   * @access public
   *        
   * @return none
   */
  public function __construct()
  {
    // Connexion à la Base de Données
    $this->conn = new PDO(DATABASE, LOGIN, PASSWORD);
 
  } // __construct()
  
  /**
   * Destructeur de la class MUsers
   * @access public
   *        
   * @return none
   */
  public function __destruct(){}
  
  /**
   * Récupère plusieurs tuples de la table USERS
   * @access public
   *        
   * @return array $result->fetchAll()
   */
  public function VerifUser($_value)
  {
    $query = 'select ID_USER,
                     NOM, 
                     PRENOM,
                     AUTORISATION
	          from USERS
              where LOGIN = :LOGIN
              and PASSWORD = :PASSWORD';
 
    $result = $this->conn->prepare($query);

    $result->bindValue(':LOGIN', $_value['LOGIN'], PDO::PARAM_STR);
    $result->bindValue(':PASSWORD', $_value['PASSWORD'], PDO::PARAM_STR);
        
    $result->execute();
        
    return $result->fetch();  
  
  } // VerifUser($_value)
  
} // MUserss
?>