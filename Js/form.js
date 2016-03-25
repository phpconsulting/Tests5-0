/**
 * Fonctions utilisées pour les formulaires
 * @author Christian Bonhomme
 */

// Tableau des éléments obligatoires du formulaire
var elemRequired = new Array();
// Tableau de booleens des éléments obligatoires du formulaire
var boolNoRequired = new Array();
/**
 * Vérification du formulaire 
 * Vérifie que les attributs de type NOT NULL soient renseignés
 * @param element frm élément de type formulaire
 * 
 * return boolean
 */
function verifForm(frm)
{
  // Récupère les éléments <label>
  var tabLabel = frm.getElementsByTagName('label');
  //Récupère le nombre d'éléments <label>
  var nbLabel = tabLabel.length;

  // Boucle sur les éléments <label>
  for (var i = 0, k = 0, message = new Array(), errors = 0; i < nbLabel; ++i)
  {
    // Récupère, dans l'élément <label> d'indice i, le contenu de l'attribut for 
    // correspondant au id de l'élément associé au label (input, select, ...)
    var atFor = tabLabel[i].getAttribute('for');

    // Teste si l'attribut for existe
    if (atFor)
    {
      // Récupère l'élément associé au label ayant pour id la valeur de l'attribut for
      var elemById = document.getElementById(atFor);
 
      // Récupére la valeur de la classe associée à l'id
      var atClass = elemById.getAttribute('class');
      
      // Teste si l'attribut class existe
      if (atClass)
      {
      	// Expression régulière permettant de rechercher le mot mandatory
      	var pattern = /(required)/;
     	// Si la class est required et l'élément est vide alors erreur
    	if (pattern.test(atClass))
    	{
          // Eléments du formulaire    	
          elemRequired[k] = elemById;
          // Eléments non requis (initialisation par défaut)
          boolNoRequired[k] = false;
          
    	  if (!elemById.value)
    	  {
    	    // Eléments requis
    		boolNoRequired[k] = true;
    	    // Message d'erreurs en récupérant le texte du label
            message[errors] = '- ' + tabLabel[i].innerHTML;
            // Incrémentation du compteur d'erreurs
    	    ++errors;
    	  }
      	  
      	  ++k;
    	}
      }
    }
  }
  
  // Si error est différent de 0 alors alert
  if (errors)
  {
    // Message d'erreurs suivant le nombre d'erreurs
    var text_message = (errors > 1) ? 'Vous devez renseigner les champs suivants :' : 'Vous devez renseigner le champ suivant :';
	    
    // Appel à la fenêtre d'erreur personnalisée
    windowError(text_message, message, errors);
	    
    return false;
  }

  return true;

} // verifForm(frm)

/**
 * Vérification de l'image 
 * Vérifie qu'une image a été chargée
 * 
 * return boolean
 */
function verifImage()
{
  // Récupère la valeur de l'attribut src de l'image
  var file_photo = document.getElementById('preview').getAttribute('src');

  // Si l'image par défaut n'as pa changé
  if ('../Img/image.png' == file_photo)
  {
	// Appel à la fenêtre d'erreur personnalisée
	windowError("Vous n'avez pas choisi d'image !");
			
	return false;
  }
	
  return true;

} // verifImage()

/**
 * Fenêtre d'erreurs personnalisée 
 * Affiche une Fenêtre d'erreurs personnalisée 
 * @param text_message message d'erreur
 * @param message tableau des messages (champs non renseignés)
 * @param errors nombre d'erreurs
 * 
 * return none
 */
function windowError(text_message, message, errors)
{
  // Crée un élément paragraphe <p>
  var p = document.createElement('p');
  // Ajoute à l'élément paragraphe <p> le début du message suivant si une ou plusieurs erreurs
  p.innerHTML = text_message;

  // Récupère l'élément <div id="error">
  var window = document.getElementById('error');
  // Ajoute à l'élément <div id="error"> l'élément paragraphe <p>
  window.appendChild(p);
  
  for (var i = 0; i < errors; ++i)
  {
    // Crée un élément paragraphe <p>
    var p = document.createElement('p');
    // Insère dans l'élément paragraphe <p> son message
    p.innerHTML = message[i];
    // Ajoute un attribut class="label"
    p.setAttribute('class', 'label');
    // Ajoute à l'élément <div id="error"> l'élément paragraphe <p>
    window.appendChild(p);
  }
    
  // Crée un élément paragraphe <button>
  var button = document.createElement('button');
  // Ajoute à l'élément paragraphe <button> la valeur Ok
  button.innerHTML = 'Ok';

  // Crée un élément paragraphe <p>
  var p = document.createElement('p');
  // Ajoute un attribut class="center"
  p.setAttribute('class', 'center');
  // Ajoute à l'élément <p> l'élément button <button>
  p.appendChild(button);
  
  // Ajoute à l'élément <div id="error"> l'élément paragraphe <p>
  window.appendChild(p);
    
  // Visualise l'élément <div id="error">
  window.style.display = 'block';
    
  // Ecouteur sur le bouton
  if (button.addEventListener)
  {
    button.addEventListener('click', closeDivError, false);
  }
  else
  {
    button.addEventListener('onclick', closeDivError);
  }
   
  // Récupère la largeur de l'élément <div id="error">
  var window_width = window.offsetWidth;
  // Récupère la hauteur de l'élément <div id="error">
  var window_height = window.offsetHeight;
     
  // Déplace l'élément <div id="error"> vers la gauche de la moitié de sa largeur
  window.style.marginLeft = '-' + Math.round(window_width/2) + 'px';
  // Déplace l'élément <div id="error"> vers le haut de la moitié de sa hauteur
  window.style.marginTop = '-' + Math.round(window_height/2) + 'px';  

} // windowError(text_message, message, errors)

/**
 * Fermeture de la fenêtre d'erreurs 
 * 
 * @return none
 */
function closeDivError()
{
  // Récupère l'élément <div id="error">
  var div_error = document.getElementById('error');
  // Efface le contenu de l'élément <div id="error">
  div_error.innerHTML = '';
  
  // Rends non visible l'élément <div id="error">
  div_error.style.display = 'none';
  
  // Nombre d'éléments du formulaire
  var nbElem = elemRequired.length;
  
  // Boucle sur les éléments du formulaire  
  for (var i = 0; i < nbElem; ++i)
  {
	// Récupération de la valeur de l'attribut class
	var classRequired = elemRequired[i].getAttribute('class');
	// Suppression du mot norequired (remise à zéro)
	classRequired = classRequired.replace(' norequired', '');

	// Test si l'élément est obligatoire et non renseigné
	if (boolNoRequired[i])
	{
	  // Ajout du mot norequired
      classRequired += ' norequired';
	}
	
	// Remplacement du contenu de la class par son nouveau contenu
    elemRequired[i].setAttribute('class', classRequired);
  }
  
  return;
  
} // closeDivError()

/**
 * Fermeture de la fenêtre d'erreurs 
 * 
 * @return none
 */
function modifyData(event)
{
  // Récupère l'élément <button> cliqué
  var target = event.target || event.srcElement;
  
  // Récupère la ligne de l'élément <button> cliqué
  var tr =  target.parentNode.parentNode;
  //Récupère le contenu de l'attribut id
  var id_peintre = tr.getAttribute('id');

  // Instancie la variable param avec le paramètre ID_PEINTRE
  var param = 'ID_PEINTRE=' + id_peintre;

  // Récupère les données de la table PEINTRE avec la valeur de ID_PEINTRE
  // data objet javascript dont les membres sont : NOM, PRENOM, PHOTO
  var data = actionForm ('../Php/index.php?EX=select', param);
  
  // Met les valeurs récupérées dans les champs du formulaire
  document.getElementById('id_peintre').value = id_peintre;
  document.getElementById('nom').value = data.NOM;
  document.getElementById('prenom').value = data.PRENOM; 
  
  // Met les valeurs les attributs de l'élément <img id="preview">
  document.getElementById('preview').setAttribute('src', '../Upload/' + data.PHOTO);
  document.getElementById('preview').setAttribute('width', 100);
  document.getElementById('preview').setAttribute('height', 100);
  document.getElementById('preview').setAttribute('alt', data.NOM);
  document.getElementById('preview').setAttribute('title', data.NOM);
   
} // modifyData(event)

/**
 * Confirmation de suppression d'un tuple
 * @param event  événement click sur le bouton delete
 *
 * @return none
 */
function confirmDelete(event)
{
  // Récupère l'élément <button> cliqué
  var target = event.target || event.srcElement;

  // Récupère la ligne de l'élément <button> cliqué
  var tr =  target.parentNode.parentNode;

  //Récupère le contenu de l'attribut id
  var id_peintre = tr.getAttribute('id');

  //Récupère la première cellule de la ligne de l'élément <button> cliqué
  var td1 = tr.getElementsByTagName('td')[0];
  //Récupère le texte de la première cellule
  var nom = td1.innerHTML;

  // Demande de confirmation de suppression
  if (window.confirm ('Voulez vous vraiment supprimer cet artiste : ' + nom + ' ?'))
  {
	// Instancie la variable param avec le paramètre ID_PEINTRE
    var param = 'ID_PEINTRE=' + id_peintre;
 
    // Déclenche la suppression du tuple
	actionForm ('../Php/index.php?EX=delete', param);
   
    // Supprime la ligne du tableau
    tr.parentNode.removeChild(tr);
    
    // Remet à vide les champs du formulaire
    document.getElementById('id_peintre').value = '';
    document.getElementById('nom').value = '';
    document.getElementById('prenom').value = ''; 
    
    // Remet les valeurs par défaut dans les attributs de l'élément <img id="preview">
    document.getElementById('preview').setAttribute('src', '../Img/image.png');
    document.getElementById('preview').setAttribute('alt', 'image');
    document.getElementById('preview').setAttribute('title', 'image');
  }
 
  // Stoppe l'événement
  stopEvent(event);
	  
  return;
 
} // confirmDelete(event)

/**
 * Convertion d'un événement clavier en chaîne de caractères
 * @param event événement du clavier
 * 
 * @return string le caractère frappé
 */
function key2Char(event)
{
  // Boucle sur les propriétés des événements
  for (var prop in event)
  {
    // Test si l'événement a la propriété charCode, keycode ou which
    switch (prop) 
	{
	  case 'charCode' : return String.fromCharCode(event.charCode);
	  case 'keyCode'  : return String.fromCharCode(event.keyCode);
	  case 'which'    : return String.fromCharCode(event.which);
	}
  }
  
} // key2Char(event)

/**
 * Vérifie que les entrées clavier sont de type entier positif
 * @param event événement du clavier
 *
 * @return boolean true ou false
 */
function isInteger(event)
{
  // Expression régulière pour les entiers 
  var valid = /[0-9]/;
  // Expression régulière pour les caractères spéciaux 
  var speciaux = /[\x00\x0D]/;
	  
  // Récupération du caractère frappé
  var car = key2Char(event);
  
  // Vérifie si le caractère frappé est un entier ou un caractère spécial
  if ((valid.test(car) || speciaux.test(car)))
  {	
    return true;
  }
  
  // Stoppe l'événement
  stopEvent(event);

  return false;

} // isInteger(event)
