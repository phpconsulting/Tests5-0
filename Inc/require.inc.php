<?php
/**
 * Travaux Pratiques : Bdd
 * Autoload
 * @author Christian Bonhomme
 * @version 1.0
 * @package Bdd
 */

// Récupère le chemin absolu du répertoire Inc
$path = str_replace('Inc', 'Upload', realpath('../Inc')) . '\\';
// Répertoire pour le téléchargement
define ('UPLOAD', $path);

// Debuggage
define('DEBUG', false);

// Connexion Base de Données
/*define('DATABASE', 'mysql:host=votre_host;dbname=nom_de_votre_base');
define('LOGIN', 'login_de_connexion');
define('PASSWORD', 'mot_de_passe_de_connexion');*/
define('DATABASE', 'mysql:host=localhost;dbname=methodologie-web2.0');
define('LOGIN', 'root');
define('PASSWORD', 'gulliver');

// Constantes d'autorisation
define('CONSULTATION', 0);
define('INSERTION', 1);
define('MODIFICATION', 2);
define('SUPPRESSION', 4);

/**
 * Chargement automatique des class
 * @param string class appelée
 *
 * @return none
 */
function __autoload($class)
{
  switch ($class[0])
  {
    // Inclusion des class de type View
    case 'V' : require_once('../View/'.$class.'.view.php');
               break;
    // Inclusion des class de type Model
    case 'M' : require_once('../Mod/'.$class.'.mod.php');
               break;
    // Inclusion des class de type Class
    case 'C' : require_once('../Class/'.$class.'.class.php');
               break;
  }
      
  return;

} // __autoload($class)

/**
 * Redimensionnement de l'image
 * @param string image à redimensionner
 * @param string type de l'image à redimensionner
 *
 * @return image redimensionnée
 */
function redimensionne($file_image)
{
    // Définition de la largeur et de la hauteur maximale
    $width_new = 600;
    $height_new = 600;

    // Calcul des nouvelles dimensions et le mime
    $tab = getimagesize($file_image);
    $width_old = $tab[0];
    $height_old = $tab[1];
    $mime_old = $tab['mime'];

    // Ratio pour la mise à l'échelle
    $ratio = $width_old/$height_old;

    // Redimensionnement suivant le ratio
    if ($width_new/$height_new > $ratio)
    {
      $width_new = $height_new*$ratio;
    }
    else
    {
      $height_new = $width_new/$ratio;
    }

    // Nouvelle image redimensionnée
    $image_new = imagecreatetruecolor($width_new, $height_new);

    // Création d'une image à partir du fichier d'origine et suivant le mime
    switch ($mime_old)
    {
        case 'image/png' :  $image_old = imagecreatefrompng($file_image); break;
        case 'image/jpeg' : $image_old = imagecreatefromjpeg($file_image); break;
        case 'image/gif' :  $image_old = imagecreatefromgif($file_image); break;
    }

    // Copie et redimensionne l'ancienne image dans la nouvelle
    imagecopyresampled($image_new, $image_old, 0, 0, 0, 0, $width_new, $height_new, $width_old, $height_old);

    // Retourne la nouvelle image redimensionnée (Attention ce n'est pas un fichier mais une image)
    return $image_new;

} // redimensionne($file_image)

/**
 * Mise en forme des chaînes de caractères pour un tableau
 * @param array $val tableau de chaînes à convertir
 *
 * @return none
 */
function strip_xss(&$val)
{
    // Teste si $val est un tableau
    if (is_array($val))
    {
        // Si $val est un tableau, on réapplique la fonction strip_xss()
        array_walk($val, 'strip_xss');
    }
    else if (is_string($val))
    {
        // Si $val est une string, on filtre avec strip_tags()
        $val = strip_tags($val, '<strong>');
    }

} // strip_xss(&$val)

// Visualisation des erreurs
if (DEBUG)
{
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    /**
     * Fonction de debug pour les tableaux
     * @param array tableau à débugguer
     *
     * @return none
    */
    function debug($Tab)
    {
      echo '<pre>Tab';
      print_r($Tab);
      echo '</pre>';
         
    } // debug($Tab)
}
?>