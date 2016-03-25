<?php
require('../Inc/require.inc.php');

session_name('EXO');
session_start();

$EX = isset($_REQUEST['EX']) ? $_REQUEST['EX'] : 'home';

if (isset($_SESSION['AUTORISATION']) && 'erreur' == $_SESSION['AUTORISATION']) session_destroy();

switch($EX)
{
  case 'home'       : home();            break;
  case 'admin'      : admin();           break;
  case 'connect'    : connect();         break;
  case 'deconnect'  : deconnect();       break;
  case 'calcul'     : calcul();          break;
  case 'peintres'   : peintres();        break;
  case 'res_calcul' : res_calcul();      exit;
  case 'select'     : select();          exit;
  case 'insert'     : modify('insert');  exit;
  case 'update'     : modify('update');  exit;
  case 'delete'     : modify('delete');  exit;
  default : home();
}

require('../View/layout.view.php');

function home()
{
  global $content;
  
  $content['title'] = 'Accueil';
  $content['class'] = 'VHtml';
  $content['method'] = 'showHtml';
  $content['arg'] = '../Html/home.html';
  
  session_destroy();

} // home()

function admin()
{
    global $content;
    $content['title'] = 'Connexion';
    $content['class'] = 'VHtml';
    $content['method'] = 'showHtml';
    $content['arg'] = '../Html/form_connect.html.php';

} // admin()

function connect()
{
    $musers = new MUsers();
    $value = $musers->VerifUser($_POST);
    
    if ($value['AUTORISATION'])
    {
      $_SESSION['AUTORISATION'] = $value['AUTORISATION'];
      $_SESSION['ADMIN'] = true;
    
      peintres();
    }
    else
    {
      $_SESSION['AUTORISATION'] = 'erreur';
      
      admin();
    }

} // connect()

function deconnect()
{
    session_destroy();

    header('Location: ../Php');

} // deconnect()

function calcul()
{
  global $content;

  $content['title'] = 'Calculatrice';
  $content['class'] = 'VHtml';
  $content['method'] = 'showHtml';
  $content['arg'] = '../Html/calculatrice.html';
  
} // calcul()

function peintres()
{
  global $data_peintres;
  $mpeintres = new MPeintres();
  $data_peintres = $mpeintres->SelectAll();
  array_walk($data_peintres, 'strip_xss');
  
  global $content;
  $content['title'] = (isset($_SESSION['ADMIN']) && $_SESSION['ADMIN']) ? 'Administration Peintres' : 'Peintres';
  $content['class'] = 'VPeintres';
  $content['method'] = (isset($_SESSION['ADMIN']) && $_SESSION['ADMIN']) ? 'showAdminPeintres' : 'showPeintres';
  $content['arg'] = '';
  
} // peintres()

function res_calcul()
{
  $calcul = $_POST;
  $ccalcul = new CCalcul($calcul);
  $calcul['RESULTAT'] = $ccalcul->resultat();

  echo json_encode($calcul);

} // res_calcul()

function select()
{
  $mpeintres = new MPeintres($_POST['ID_PEINTRE']);
  $value = $mpeintres->Select();
  array_walk($value, 'strip_xss');
  
  echo json_encode($value);

} // select() 

function modify($type)
{
  $mpeintres = new MPeintres($_POST['ID_PEINTRE']);
  
  $value_peintre = $_POST;

  if ($type != 'insert')
  {
    $value = $mpeintres->Select();
    
    $value_peintre['PHOTO'] = $value['PHOTO'];
    
    if ('delete' == $type || ('update' == $type && $_FILES['PHOTO']['tmp_name']))
    {
      $file_old = UPLOAD . $value['PHOTO'];
      
      if (is_file($file_old)) unlink($file_old);
    }
  } 

  if (isset($_FILES['PHOTO']) && $_FILES['PHOTO']['tmp_name'])
  {
    $image_new = redimensionne($_FILES['PHOTO']['tmp_name']);
    
    $file_new = UPLOAD . $_FILES['PHOTO']['name'];

    imagepng($image_new, $file_new, 0);

    $value_peintre['PHOTO'] = $_FILES['PHOTO']['name'];
  }
  
  if ($type != 'delete') $mpeintres->SetValue($value_peintre);
  $value = $mpeintres->Modify($type);
  
  echo json_encode($value);
    
} // modify($type)
?>
