<?php
include("Controle/initialisation_session.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<link rel="stylesheet" href="style.css"/>
<link rel="icon" type="image/jpg" href="Modele/logo_1.jpg"/>
<title>MTP-pro</title>
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
// la fonction de redimensionnemet des images
include("Controle/fonction_image.php");
 include('Vue/affichage_news.php');
 include('Vue/interface_connexion.php');

?>
</div>
<section>
<article> 
<h3> Hstorique </h3>
<p>
L'entreprise MTP-pro exerce dans plusieur domaines en relation avec les travaux public ou elle excelle grace a l'experience de ses employé et sa gestion rigoureuse des moyens techniques et humains dont elle dispose. </p>
<p>
Elle a ete crée le 25 décembre 2011 par monsieur Larbi manseur (PDG de l'entreprise) pour rependre au nombreux besoin en matiere de  savoir fair dans le domaine que se soit au niveau locale ou nationale .
</p>
<h3>Terrassement</h3>
<p id="terrassement">
<?php image("Modele/image/images (4).jpg",'129','129','0','0');?>
Entre toute ses activité notre entreprise excéle dans les travaux de terrassement ou elle a realiser  énormément de projet dans le plus imposant est celui réalisé pour le stade omnisports de Tizi Ouzou et le projet de realisation d'une ligne de chemin de fer reliant la wilaya de Tiaret et celle de Tissemsilt 

</p>
</article>


 </section>



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
