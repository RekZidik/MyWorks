<?php
include("Controle/initialisation_session.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<link rel="stylesheet" href="style.css"/>
<title>News</title>
</head>

<body >
<div id="corp_page">
<header>

</header>

<nav>
<?php 
include("Vue/menu.php");
?>
</nav>
<div id="partie_principale">
<div id="baniere">
<marquee> <h1> Divesité,Disponibilité,Compétence</h1></marquee>
</div>
<div id="partie_annexe">
<?php
 include('Vue/affichage_news.php');
 include('Vue/interface_connexion.php');

?>
</div>
<section>
<?php
include('Controle/connexion_bdd.php');
$rep=$bdd->query(' SELECT * FROM news ORDER BY date_ajout DESC ');
echo('<table width="600" border="0" cellspacing="0" id="tableau_totale_news" class="tableau">
 <caption> Toutes les news </caption>
  <tr>
    <th scope="col">Titre</th>
    <th scope="col">Contenue</th>
  </tr>');
while($donnes=$rep->fetch())
{
	echo('<tr>
	      <td><strong>'.$donnes['titre'].'</strong> </td>
		  <td>'.$donnes['contenu'].' </td>
		  </tr>');
}
echo('</table>');
?>
</section>
<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
</div>
<footer >
<section class="s_footer"> 
        
		 <?php include("Vue/pied_de_page_1.php"); ?>
		  
</section>
<section class="s_footer">
        
		<?php include("Vue/eufemeride.php"); ?>
		
</section>
<section class="s_footer"> 

        <?php include("Vue/pied_de_page_3.php"); ?>

</section>
</footer>
</div>
</body>
</html>
