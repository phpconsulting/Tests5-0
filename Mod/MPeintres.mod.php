<?php
/**
 * Class de type Modèle gérant la table PEINTRES
 * 
 * @author Christian Bonhomme
 * @version 1.0
 * @package Bdd
 */
class MPeintres
{
  /**
   * Connexion à la Base de Données
   * @var object $conn
   */
  private $conn;
  
  /**
   * Clef primaire de la table PEINTRES
   * @var int $id
   */
  private $id_peintre;
  
  /**
   * Tableau de gestion de données (insert ou update)
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
    // Connexion à la Base de Données
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
   * @param array tableau des données
   *
   * @return none
   */
  public function SetValue($_value)
  {
    $this->value = $_value;
  
  } // SetValue($_value)
  
  /**
   * Récupère plusieurs tuples de la table PEINTRES
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
   * Récupère un tuple de la table PEINTRES
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
   * Déclenche une modification des données d'une table
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
   * Insère les données d'un tuple dans la table PEINTRES
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
   * Insère les données d'un tuple dans la table PEINTRES
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
?>