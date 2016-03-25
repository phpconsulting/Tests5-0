/**
 * Fonctions utilisées pour le calcul
 * @author Christian Bonhomme
 */

/**
 * Récupère les données du calcul effectue l'opération et l'affiche dans l'élément resultat
 *  
 * @return boolean
 */
function resultatCalcul(event)
{
  // Vérifie le formulaire
  if (!verifForm(document.getElementById('calcul')))
  {
    // Stoppe l'événement
    stopEvent(event);
    
    return false;    
  }
  
  // Récupère la valeur du champ id="num1"
  var num1 = document.getElementById('num1').value;
  // Récupère la valeur du champ id="num1"
  var num2 = document.getElementById('num2').value;
  // Récupère la valeur du champ id="operation"
  var operation = document.getElementById('operation').value;

  // Instancie l'identifiant de l'élément cible
  var id = 'resultat';
  // Instancie le contrôleur qui effectuera le changement du contenu de la cible
  var php = '../Php/index.php?EX=res_calcul';
  // Instancie les paramètres du contrôleur
  var param = 'NUM1='+num1+'&OPERATION='+encodeURIComponent(operation)+'&NUM2='+num2;

  // Appel du programme qui effectuera le changement du contenu de la cible
  var res = actionForm(php, param);
  
  // Instancie la variable calcul avec la chaîne du calcul
  var calcul = res.NUM1 + ' ' + res.OPERATION + ' ' +  res.NUM2 + ' = ' +  res.RESULTAT;

  // Remplace le contenu de l'élément id="resultat" par la chaîne du calcul
  document.getElementById('resultat').innerHTML = calcul;
  
  // Stoppe l'événement
  stopEvent(event);

  return false;

} // resultatCalcul()
