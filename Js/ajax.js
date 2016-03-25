/**
 * Fonctions javascript utilisant les appels aux serveur http
 * @author Christian Bonhomme
 * @version 1.0
 * @package json
 */
var DEBUG_AJAX = false;
/**
 *  Connexion au serveur http
 *
 *  @return string Connexion
 */
function getXhr()
{
  var xhr;
  if (window.XMLHttpRequest)         // Firefox et autres
  {
    xhr = new XMLHttpRequest();
  }
  else if (window.ActiveXObject)     // Internet Explorer
  {
    try
    {
      xhr = new ActiveXObject("Msxml2.XMLHTTP"); // IE version > 5
    }
    catch (e)
    {
      xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
  }
  else // XMLHttpRequest non supporté par le navigateur
  {
    alert("Votre navigateur ne supporte pas les objets XMLHttpRequest !");
    xhr = false;
  }

  return xhr;

} // getXhr ()

/**
 * Modification du contenu d'un élément en mode asynchrone
 * @param string id identifiant de l'élément à modifier
 * @param string php programme de modification
 * @param string param paramètres de modification
 * @param string callback : programme d'appel après la modification
 *  
 * @return none
 */
function changeContent(id, php, param, callback)
{
  // Récupère l'élément cible dont l'identifiant vaut id
  var c = document.getElementById(id);
  
  // Met une image animée afin de montrer le chargement en cours du contenu
  c.innerHTML = '<img src="../Img/loading.gif" alt="Chargement" />';

  //Récupère la connexion au serveur http
  var xhr = getXhr();

  // Ouvre la connexion en mode asynchrone avec le serveur http avec comme url php
  xhr.open('POST', php, true);

  // Envoie des entêtes pour l'encodage
  xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

  //Envoie les paramètres param (même vide)
  xhr.send(param);
  
  // Exécution en mode asynchrone de la fonction anonyme dès que l'on obtient une réponse du serveur http
  xhr.onreadystatechange = function() 
  {
	// Debuggage
    if (DEBUG_AJAX) alert(xhr.responseText);
    
    // Test si le serveur a tout reçu (200) et que le serveur a fini (4)
    if (xhr.status == 200 && xhr.readyState == 4)
    {
      // Modifie l'élément ayant pour identificateur id suivant le programme php
      c.innerHTML = xhr.responseText;

      //Test s'il y a une callback 
      if (callback != null)
      {
    	// Exécution du script contenu dans la callback
        window.eval(callback);
      }

      // Si on a du javascript dans le nouveau contenu on identifie les scripts et on force l'éxécution avec eval()
      var allscript = c.getElementsByTagName('script');
      for (var i = 0; i < allscript.length; ++i)
      {
    	// Exécution du script
        window.eval(allscript[i].text);
      }
    }
  };
  
  return;

} // changeContent(id, php, param, callback)

/**
 * Récupération d'une action (d'un formulaire) en mode synchrone au format json
 * @param string php programme de modification
 * @param string param paramètres de modification
 *  
 * @return string json
 */
function actionForm(php, param)
{
  // Récupère la connexion au serveur http
  var xhr = getXhr ();

  //Ouvre la connexion en mode synchrone avec le serveur http avec comme url php
  xhr.open('POST', php, false);

  // Envoie des entêtes pour l'encodage
  xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

  //Envoie les paramètres param
  xhr.send(param);
  
  // Debuggage
  if (DEBUG_AJAX) alert(xhr.responseText);

  // La réponse  au format json devient un objet javascript
  return JSON.parse(xhr.responseText);

} // actionForm(php, param)

/**
 * Récupération d'une action (d'un formulaire) en mode synchrone au format json
 * Avec téléchargement d'un fichier
 * @param string php programme de modification
 * @param string param paramètres de modification
 *  
 * @return string json
 */
function uploadForm(php, target, name_image, image)
{
  // Récupère la connexion au serveur http
  var xhr = getXhr ();
  
  //Ouvre la connexion avec le serveur http avec comme url php
  xhr.open('POST', php, false);
  
  // Génère les données d'un formulaire sous la forme name/value
  var upload = new FormData(target); 

  // Ajout de la paire name_image/image
  upload.append(name_image, image);

  // Envoie des données du formulaire
  xhr.send(upload);
  
  // Debuggage
  if (DEBUG_AJAX) alert(xhr.responseText);

  //La réponse  au format json devient un objet javascript
  return JSON.parse(xhr.responseText);

} // uploadForm(php, target, name_image, image)
