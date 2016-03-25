/**
 * Initialisation des écouteurs
 * @author Christian Bonhomme
 */
/**
 * Fonction générique de déclenchement des listeners
 */
function Listener(elem ,event, fnct) 
{
  if (elem)
  {
    // Teste si la méhode addEventListener existe (Non IE)
    if (elem.addEventListener)
    {
      // Associe à  l'événement click la fonction (Non IE)
      elem.addEventListener(event , fnct, false);
    }
    else
    {
      // Associe à  l'événement onclick la fonction  (IE)
      elem.attachEvent('on' + event, fnct);
    }
		
    // Si l'événement est un click on change le curseur de souris
    if ('click' == event) 
    { 
      elem.style = 'cursor: pointer';
    }
  }
    
} // Listener(elem ,event, fnct)

/**
 * Gestion des événements sur le formulaire de calcul id="calcul"
 */
// Récupère l'élément <form id="calcul">
var form_calcul = document.getElementById('calcul');
// Teste si l'élémént form_calcul existe
if (form_calcul)
{
  // Gestion de l'événement submit sur le formulaire id="calcul"
  // Récupère l'élément <select id="operation">
  var change_operation = document.getElementById('operation');
  // Récupère les éléments <input id="num1"> et <input id="num2">
  var keypress_num1 = document.getElementById('num1');
  var keypress_num2 = document.getElementById('num2');
  // Teste si la méthode addEventListener existe (Non IE)
  if (form_calcul.addEventListener)
  {
    // Associe à l'événement submit la fonction resultatCalcul (Non IE)
    form_calcul.addEventListener('submit', resultatCalcul, false);
    // Associe à l'événement change la fonction resultatCalcul (Non IE)
    change_operation.addEventListener('change', resultatCalcul, false);
    // Associe à l'événement keypress la fonction isInteger (Non IE)
    keypress_num1.addEventListener('keypress', isInteger, false);
    keypress_num2.addEventListener('keypress', isInteger, false);
  } 
  else
  {
    // Associe à l'événement onsubmit la fonction resultatCalcul (IE)
    form_calcul.attachEvent('onsubmit', resultatCalcul);
    // Associe à l'événement onchange la fonction resultatCalcul (IE)
    change_operation.attachEvent('onchange', resultatCalcul);
    // Associe à l'événement onkeypress la fonction isInteger (IE)
    keypress_num1.attachEvent('onkeypress', isInteger);
    keypress_num2.attachEvent('onkeypress', isInteger);
  }
}

/**
 * Gestion des événements sur les peintres
 */
// Récupère l'élément <form id="peintre">
var form_peintre = document.getElementById('peintre');
//Teste si l'élément form_peintre existe
if (form_peintre)
{  
  // Teste si la méthode addEventListener existe (Non IE)
  if (form_peintre.addEventListener)
  {
    // Associe à l'événement submit la fonction saveForm (Non IE)
	form_peintre.addEventListener('submit', insertData, false);
  } 
  else
  {
	// Associe à l'événement onsubmit la fonction saveForm (IE)
	form_peintre.attachEvent('onsubmit', insertData);
  }
  
  // Récupère l'élément <input id="photo">
  var change_file_image = document.getElementById('photo');
  if (change_file_image.addEventListener)
  {
    // Associe à l'événement change à la fonction selectImage (Non IE)
    change_file_image.addEventListener('change', selectImage, false);
  }
  else
  {
    // Associe à l'événement onchange à la fonction selectImage (IE)
    change_file_image.attachEvent('onchange', selectImage);
  }
}

// Récupère les éléments <th> d'entêtes de tableau
var click_th = document.getElementsByTagName('th');
// Nombre d'éléments <th>
var nb_click_th = click_th.length;
//Teste si des éléments th existent
if (nb_click_th)
{
  // Boucle sur les éléments <th>
  for (var i = 0; i < nb_click_th; ++i)
  {
    // Teste si la méthode addEventListener existe (Non IE)
    if (click_th[i].addEventListener)
    {
      // Associe à l'événement click la fonction triBulle (Non IE)
   	  click_th[i].addEventListener('click', triCol, false);
    } 
    else
    {
	  // Associe à l'événement onclick la fonction triBulle (IE)
      click_th[i].attachEvent('onclick', triCol);
    }
    
    // Met le curseur à pointeur sur les éléments <th>
    click_th[i].style.cursor = 'pointer';
  }
  
  // Récupère les éléments <tr> du corps du tableau
  var elem_tr = document.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
  var nb_elem_tr = elem_tr.length;
  // Boucle sur les éléments <tr>
  for (var i = 0; i < nb_elem_tr; ++i)
  {
	// Récupère le premier élément <td> de la ligne
	var click_td = elem_tr[i].getElementsByTagName('td')[0];
	// Initialisation des événements sur le premier élément <td> de la ligne
	if (click_td) initClickTd(click_td);
	
	// Récupère le premier élément ayant class="modify" de la ligne
	var click_modify = elem_tr[i].getElementsByClassName('modify')[0];
	// Initialisation des événements sur l'élément <bouton id="modify">
	if (click_modify) initClickModify(click_modify);
	
	// Récupère le premier élément ayant class="trash" de la ligne
	var click_trash = elem_tr[i].getElementsByClassName('trash')[0];
	// Initialisation des événements sur l'élément <bouton id="trash">
	if (click_trash) initClickTrash(click_trash);
  }
}

/**
 * Initialisation des événements sur le premier élément <td> de la ligne
 */
function initClickTd(click_elem)
{
  // Teste si la méthode addEventListener existe (Non IE)
  if (click_elem.addEventListener)
  {
    // Associe à l'événement click la fonction showWindow (Non IE)
    click_elem.addEventListener('click', showPicture, false);
  } 
  else
  {
    // Associe à l'événement onclick la fonction showWindow (IE)
    click_elem.attachEvent('onclick', showPicture);
  } 
  
  click_elem.style.fontWeight = 'bold';
  click_elem.style.cursor = 'pointer';
  	
} // initClickTd(click_elem)

/**
 * Initialisation des événements sur le bouton modify
 */
function initClickModify(click_elem)
{
  // Teste si la méthode addEventListener existe (Non IE)
  if (click_elem.addEventListener)
  {
    // Associe à l'événement click la fonction modifyData (Non IE)
    click_elem.addEventListener('click', modifyData, false);
  } 
  else
  {
    // Associe à l'événement onclick la fonction modifyData (IE)
    click_elem.attachEvent('onclick', modifyData);
  } 
  	
} // initClickModify(click_elem)

/**
 * Initialisation des événements sur le bouton trash
 */
function initClickTrash(click_elem)
{
  // Teste si la méthode addEventListener existe (Non IE)
  if (click_elem.addEventListener)
  {
    // Associe à l'événement click la fonction confirmDelete (Non IE)
    click_elem.addEventListener('click', confirmDelete, false);
  } 
  else
  {
    // Associe à l'événement onclick la fonction confirmDelete (IE)
    click_elem.attachEvent('onclick', confirmDelete);
  }
	
} // initClickTrash(click_elem)

//Récupère l'élément <div id="drop_photo">
var drop_photo = document.getElementById('drop_photo');
if (drop_photo)
{
  // Teste si la méthode addEventListener existe (Non IE)
  if (drop_photo.addEventListener)
  {
   // Associe à l'événement dragenter la fonction dragenter (Non IE)
   drop_photo.addEventListener('dragenter', dragenter, false);
   // Associe à l'événement dragover la fonction dragover (Non IE)
   drop_photo.addEventListener('dragover', dragover, false);
   // Associe à l'événement drop la fonction drop (Non IE)
   drop_photo.addEventListener('drop', drop, false);
  }
  else
 {
   // Associe à l'événement ondragenter la fonction dragenter (IE)
   drop_photo.addEventListener('ondragenter', dragenter);
   // Associe à l'événement ondragover la fonction dragover (IE)
   drop_photo.addEventListener('ondragover', dragover);
   // Associe à l'événement ondrop la fonction drop (IE)
   drop_photo.addEventListener('ondrop', drop);
  }  
}

/**
 * Fonction d'arrêt de la propagation d'un événement dans la phase de bouillonnement
 * @param event événement
 */
function stopEvent(event)
{
  // Teste si la méthode stopPropagation existe (Non IE)
  if (event.stopPropagation)
  {
    // Stoppe la propagation de l'événement (pas de bouillonnement)
    event.stopPropagation();
    // Remet l'événement à false
    event.preventDefault();
  }
  else
  {
    // Stoppe la propagation de l'événement (pas de bouillonnement)
    event.cancelBubble = true;
    // Remet l'événement à false
    event.returnValue = false;
  }

} // stopEvent(event)
