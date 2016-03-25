/**
 * Affichage de l'image du tableau d'un artiste
 * @param array event tableau des objets de type événement
 * 
 * @return none
 */
function showPicture(event)
{
  // Récupère l'élément cellule qui a été cliqué
  var target = event.target || event.srcElement;
  
  //Récupère la valeur de l'attribut id de la ligne de la cellule qui a été cliquée
  var param = 'ID_PEINTRE=' + target.parentNode.getAttribute('id');

  // Récupère les données de ID_PEINTRE via la fonction de contrôle select()
  var data = actionForm('../Php/index.php?EX=select', param);

  //Récupère l'élément <div id="window">
  var wind = document.getElementById('window');
  
  //Récupère l'élément <img id="picture">
  var pict = document.getElementById('picture');
  // Si l'élément <img id="picture"> existe, on le supprime
  if (pict) wind.removeChild(pict);
  
  // Création d'un élément <img>
  pict = document.createElement('img');

  // Attributs de l'élément <img>
  pict.setAttribute('id', 'picture');
  pict.setAttribute('src', '../Upload/' + data.PHOTO);
  pict.setAttribute('alt', data.NOM);
  pict.setAttribute('title', data.NOM);
  // Ajout de l'élément <img> à l'élément <div id="window">
  wind.appendChild(pict);
  
  //Temporisation pour l'affichage de la fenêtre recentrée
  setTimeout(function(){positionWindow(wind)},200);
  
  // Initialisation du bouton de fermeture de l'élément <div id="window">
  initCloseWindow();

} // showPicture(event)

/**
 * Recentrage de l'image du tableau d'un artiste
 * @param object HTMLDivElement correspondant à l'élément <div id="window">
 * 
 * @return none
 */
function positionWindow(wind)
{
  // Recentrage horizontale
  wind.style.marginLeft = '-' + Math.floor(wind.clientWidth/2) + 'px';
  // Recentrage verticale
  wind.style.marginTop = '-' + Math.floor(wind.clientHeight/2) + 'px';
  
  // Affichage de la fenêtre 
  wind.style.visibility = 'visible';
  
} // positionWindow(wind)

/**
 * Initialisation de l'écouteur de fermeture de l'élément <div id="window">
 * 
 * @return none
 */
function initCloseWindow()
{
  //Récupère l'élément <button id="close">
  var click_close = document.getElementById('close');
  Listener(click_close, 'click', function(){document.getElementById('window').style.visibility = 'hidden'});
  
} // initCloseWindow()

/**
 * Prévisualisation de l'image
 * 
 * return none
 */
//Fichier image en global pour le drag and drop
var file_photo;
function selectImage(event)
{
  // Récupère l'élément <input id="photo">
  var target = event.target || event.srcElement;
   
  // Vérifie si l'image vient du file manager ou d'un drag and drop
  // files contient une FileList
  var files = (typeof(event.dataTransfer) == 'undefined') ? target.files : event.dataTransfer.files;
  
  // files[0] le premier fichier de FileList
  file_photo = files[0];

  // Regexp pour vérifier que nous avons une image png, jpeg ou gif
  var pattern = /image\/png|image\/jpeg|image\/gif/;
  // Test vérifiant si image. fait partie du type du fichier (file.type)
  if (!file_photo.type.match(pattern))
  {
    // Appel la fonction gérant l'alerte personnalisée
    windowError("Votre fichier n'est pas une image valide : png, jpeg ou gif !");
	  
    return false;
  }

  // Récupère l'élément <img id="preview">
  var preview = document.getElementById('preview');
  // Réinitialisation de la prévisualisation
  preview.style.display = 'none';
  preview.setAttribute('src', '');
  preview.setAttribute('title', '');
  preview.setAttribute('width', '');
  preview.setAttribute('height', '');

  //Création un objet URL à partir d'un fichier téléchargé qu'on met dans la source de img
  preview.src = window.URL.createObjectURL(file_photo); 
  // On charge l'image et on met à l'échelle
  preview.onload = function(){if(preview.width > preview.height){preview.width = 100}else{preview.height = 100}};
  // On ajoute un attribut alt à l'image correspondant au nom de l'artiste
  preview.setAttribute('alt', document.getElementById('nom').value);
  // On ajoute un titre à l'image correspondant au nom de l'artiste
  preview.setAttribute('title', document.getElementById('nom').value);
  
  // On met une temporisation pour visualiser l'image en prévisualisation
  setTimeout(function(){preview.style.display = 'block'},400);

} // selectImage(event)

/**
 * Entrer dans la zone accueillant l'image
 * param event événement souris
 * 
 * @return none
 */
function dragenter(event)
{
  stopEvent(event);
  
} // dragenter(event)
	 
/**
 * Déplacement dans la zone accueillant l'image
 * param event événement souris
 * 
 * @return none
 */
function dragover(event)
{
  stopEvent(event);
  
} // dragover(event)
	
/**
 * Relâchement dans la zone accueillant l'image
 * param event événement souris
 * 
 * @return none
 */
function drop(event)
{
  stopEvent(event);
  
  selectImage(event);
    
} // drop(event)
