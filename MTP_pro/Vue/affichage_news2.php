<table width="300" border="0" cellspacing="0" id="tableau_derniere_news">
 <caption> Dérniere News </caption>
  <tr>
    <th scope="col">Titre</th>
    <th scope="col">Contenue</th>
  </tr>
<?php
include('./Controle/connexion_bdd.php');
$rep=$bdd->query(' SELECT * FROM news ORDER BY date_ajout DESC LIMIT 0,4  ');
$donnes=$rep->fetch();

	echo('<tr>
	      <td><strong><a href="Vue/totale_news.php">'.$donnes['titre'].'</a></strong> </td>
		  <td>'.$donnes['contenu'].' </td>
		  </tr>
		  </table></br></br>');
echo('<table width="300" border="0" cellspacing="0" id="tableau_news"> <caption>  News </caption>');
while($donnes=$rep->fetch())
{ echo('
  <tr>
    <th scope="col">Titre</th>
  </tr>
   <tr><td><a href="Vue/totale_news.php">'.$donnes['titre'].'</a></td>
  </tr>');
}
echo('</table>');
		  

?>

