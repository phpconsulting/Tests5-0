/**
 * Fonctions utilisées pour les tableaux 
 * @author Christian Bonhomme
 */

/**
 * Récupération des données du formulaire et transformation des données au format JSON
 * Insertion des données dans le tableau et tri du tableau
 * @param element frm Elément de type formulaire
 * 
 * @return boolean
 */
function insertData(event)
{
  // Récupère l'élément <form>
  var frm = event.target || event.srcElement;

  // Vérifie le formulaire
  if (!verifImage() || !verifForm(frm))
  {
    // Stoppe l'événement
    stopEvent(event);
				
    return false;
  }

  // Si l'élément <input id="id_peintre"> est renseigné update sinon insert
  var ex = (document.getElementById('id_peintre').value) ? 'update' : 'insert';

  // Envoie l'objet HTMLFormElement frm
  // Et récupère les données JSON comme membre de l'objet Javascript data
  var data = uploadForm('../Php/index.php?EX=' + ex, frm, 'PHOTO', file_photo);
 
  // Insère les données ou les met à jour suivant la valeur de ex
  ('insert' == ex) ? insertTr(data) : updateTr(data);

  // Stoppe l'événement
  stopEvent(event);
  
  // Remise à blanc des champs du formulaire
  document.getElementById('id_peintre').value = '';
  document.getElementById('nom').value = '';
  document.getElementById('prenom').value = '';
  document.getElementById('photo').value = '';
  
  // Remise à vide des attributs de l'élément <img id="preview">
  document.getElementById('preview').setAttribute('src', '../Img/image.png');
  document.getElementById('preview').setAttribute('alt', 'image');
  document.getElementById('preview').setAttribute('title', 'image');
    
  return false;

} // insertData(event)
 
function insertTr(data)
{
  // Récupère le corps du tableau <tbody>
  var tbody = document.getElementsByTagName('tbody')[0];
  
  // Crée l'élément ligne <tr>
  var tr = document.createElement('tr');
  // Ajout de l'attribut id avec l'identifiant de ligne
  tr.setAttribute('id', data.ID_PEINTRE);
  // Crée le premier élément cellule <td>
  var td1 = document.createElement('td');
  // Crée le deuxième élément cellule <td>
  var td2 = document.createElement('td');
  // Crée le troisième élément cellule <td>
  var td3 = document.createElement('td');
  // Crée le quatrième élément cellule <td>
  var td4 = document.createElement('td');
 
  // Ajout du nom de l'artiste dans le premier élément cellule <td>
  td1.innerHTML = data.NOM;
  // Initialisation du click sur le premier élément cellule <td>
  initClickTd(td1);
  
  // Met la valeur du membre PRENOM de l'objet data dans la deuxième cellule <td>
  td2.innerHTML = data.PRENOM;
  
  // Création du bouton de modification
  var modify = document.createElement('button');
  modify.setAttribute('class', 'button modify');
  modify.innerHTML = 'Modification';
  // Ajout du bouton de modification dans la troisième cellule <td>
  td3.appendChild(modify);
  // Initialisation du click sur le bouton de modification
  initClickModify(modify);
  
  // Création du bouton de suppression
  var trash = document.createElement('button');
  trash.setAttribute('class', 'button trash');
  trash.innerHTML = 'Poubelle';
  // Ajout du bouton de suppression dans la troisième cellule <td>
  td4.appendChild(trash);
  // Initialisation du click sur le bouton de suppression
  initClickTrash(trash);
 
  // Ajoute la première cellule à l'élément ligne <tr>
  tr.appendChild(td1);
  // Ajoute la deuxième cellule à l'élément ligne <tr>
  tr.appendChild(td2);
  // Ajoute la troisième cellule à l'élément ligne <tr>
  tr.appendChild(td3);
  // Ajoute la quatrième cellule à l'élément ligne <tr>
  tr.appendChild(td4);
 
  // Ajoute l'élément ligne <tr> à l'élément corps du tableau <tbody>
  tbody.appendChild(tr);

} // insertTr(data)

function updateTr(data)
{
  // Récupère les éléments <tr> 
  var tr = document.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
  var nb_tr = tr.length;
  for (var i = 0; i < nb_tr; ++i)
  {
	// Test si on modifie la bonne ligne  
    if (data.ID_PEINTRE == tr[i].getAttribute('id'))
    {
      // Modifie les éléments <a>
      tr[i].getElementsByTagName('td')[0].innerHTML = data.NOM;
      tr[i].getElementsByTagName('td')[1].innerHTML = data.PRENOM;
    }
  }

} // updateTr(data)

//Variable implicite de type tableau contenant le type de tri
var type_tri = new Array();
/**
 * Méthode de tri pour les colonnes d'un tableau
 * @param int identifiant de la colonne 
 * 
 * @return none;
 */
function triCol(event)
{
  // Récupère l'élément <th> cliqué
  var target = event.target || event.srcElement;
		 
  // Récupère l'élément <tr> de l'élément <thead>
  var tr_thead = target.parentNode;
  // Récupère les éléments <th>
  var th = tr_thead.getElementsByTagName('th');
  var nb_th = th.length;
  // Boucle sur les éléments <th>
  for (var i = 0; i < nb_th; ++i)
  {
    // Teste si l'index de l'élément <th> correspond à l'élément <th> cliqué
    if (th[i] == target)
    {
      // Récupère l'index de l'élément <th> cliqué
      col = i;
    }
  }

  // Récupère l'élément <tbody>
  var tbody = document.getElementsByTagName('tbody')[0];
  // Récupère les éléments <tr>
  var tr = tbody.getElementsByTagName('tr');
  // Récupère le nombre d'éléments <tr>
  var nb_tr = tr.length;
  // Initialise le tableau text
  var text = new Array();
  // Initialise le tableau de copie de lignes
  var tr_clone = new Array();

  for (var i = 0; i < nb_tr; ++i)
  {
	// Récupère les textes de la colonne cliquée
	// Teste si le conteu de l'élément <td> contient un élément <a>
	if (tr[i].getElementsByTagName('td')[col].getElementsByTagName('a')[0])
	{
      text[i] = tr[i].getElementsByTagName('td')[col].getElementsByTagName('a')[0].innerHTML;
	}
	else
    {
	  text[i] = tr[i].getElementsByTagName('td')[col].innerHTML;
    }

	// Met les textes récupérés en majuscule
	text[i] = text[i].toUpperCase();

    // Récupère la copie de la ligne correspondant au texte
    tr_clone[i] = tr[i].cloneNode(true);
  }
  
  type_tri[col] = ('desc' == type_tri[col]) ? 'asc' : 'desc';

  // Tri des données
  triData(tr_clone, text, type_tri[col]);
  
  // Remplacement des lignes par les lignes triées
  for (var i = 0; i < nb_tr; ++i)
  {
	// Remplacement de la ligne par la ligne triée
    tbody.replaceChild(tr_clone[i], tr[i]);
    
    // Initialisation du click sur le premier élément cellule <td>
    initClickTd(tr_clone[i].getElementsByTagName('td')[0]);
  }

} // triCol(event)

/**
 * Tri à bulles des textes et des lignes
 * @param array tr_clone tableau des lignes copiées
 * @param array text texte à trier
 * @param string tri type de tri (ascendant ou descendant)
 * 
 * @return boolean
 */
function triData(tr_clone, text, tri)
{
  // Variable booléenne pour le test du tri
  var trier = true;
  // Variable temporaire pour les échanges de l'indice du tableau text lors du tri
  var tmp_text = null;
  // Variable temporaire pour les échanges de l'indice du tableau tr_clone lors du tri
  var tmp_tr = null;
  
  // Nombre de lignes à trier
  var nb_tr = text.length;
  for (i = 0; i < nb_tr && trier; ++i)
  {
    // Variable du test de tri mis à false (tri réussi)
	trier = false;
	for (var j = 1; j < nb_tr - i; ++j)
	{
	  // test suivant le type de tri
	  // test entre la variable text d'indice j et d'indice j-1 (c'est pour quoi on démarre la boucle à j = 1)
	  if (('desc' == tri && text[j] < text[j-1]) ||
	      ('asc' == tri && text[j] > text[j-1]))
	  {
	    // On instancie la variable temporaire avec le texte contenu dans la variable d'indice j-1
	    tmp_text = text[j-1];
	    // On instancie la variable d'indice j-1 avec le texte contenu dans la variable d'indice j
	    text[j-1] = text[j];
	    // On instancie la variable d'indice j  avec le texte contenu dans la variable temporaire
	    text[j] = tmp_text;

	   	// On instancie la variable temporaire avec la ligne copiée contenue dans la variable d'indice j-1
	    tmp_tr = tr_clone[j-1];
	   	// On instancie la variable d'indice j-1 avec la ligne copiée contenue dans la variable d'indice j
	    tr_clone[j-1] = tr_clone[j];
	    // On instancie la variable d'indice j  avec la ligne copiée contenue dans la variable temporaire
	    tr_clone[j] = tmp_tr;

	    // Variable du test de tri mis à true (tri échoué)
	    trier = true;
	  }
	}
  }
  
} // triData(tr_clone, text, tri)
