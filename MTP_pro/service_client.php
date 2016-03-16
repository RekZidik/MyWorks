<?php
include("Controle/initialisation_session.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<link rel="stylesheet" href="style.css"/>
<title>Service client </title>
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
</div><section>
<?php

?>
<form  method="post" action="#">
<fieldset>
<legend>Information</legend>
<label for="nom_raison-sociale" ><strong>Nom ou Raison-Sociale:</strong></label><br/>
<input type="text" name="nom_raison-sociale" id="nom_raison-sociale" size="30"/><br/>
<label for="type_engin" ><strong>Type engin:</strong></label><br/>
<select id="type_engin" name="type_engin"  >
<optgroup label="Bulldozer"> 
<option value="bulldozer">Bulldozer</option>
</optgroup>
<optgroup label="Chargeur">
<option value="mini_chargeur">Mini chargeur</option>
<option value="Chargeur">Chargeur </option>
 </optgroup>
<optgroup label="Chariot">
<option value="chariot">Chariot </option>
 </optgroup>
<optgroup label="Compacteur">
<option value="compacteur">Compacteur </option>
 </optgroup>
<optgroup label="Grue">
<option value="grue">Grue </option>
 </optgroup>
<optgroup label="Nacelle"> 
<option value="nacelle">Nacelle </option> 
</optgroup>
<optgroup label="Niveleuse"> 
<option value="niveleuse"> Niveleuse</option>

</optgroup>
<optgroup label="Pelle">
<option value="mini_pelle">Mini Pelle</option> 
<option value="pelle">Pelle </option>
</optgroup>
<optgroup label="Retro-chargeur"> 
<option value="retro-chargeur_caterpillar">Retro-chargeur Caterpillar</option>
</optgroup>
<optgroup label="Tracteur">
<option value="tracteur_a_chaine">Tracteur a chaine</option>
 </optgroup>
 <optgroup label="Autre"> 
<option value="autre">Autre</option>
 </optgroup>
 </select><br/>
 <label for="nbr_tel"> <strong>Telephone:</strong></label> <br/>
 <input type="tel" name="nbr_tel" maxlength="14" placeholder="0 xx xxx xxx" id="nbr_tel" size="30"/></br>
 <label for="marque"> <strong>Marque:</strong></label> <br/>
 <input type="text" name="marque" maxlength="14"  id="marque" size="30"/></br>
 <label for="num_serie"> <strong>Num serie:</strong></label> <br/>
 <input type="text" name="num_serie" maxlength="14"  id="num_serie" size="30"/></br>
  <label for="matricule_engin"> <strong>Matricule-engin:</strong></label> <br/>
 <input type="number" name="matricule_engin" maxlength="12" placeholder="xxx-xxxxx-xx" id="matricule_engin" size="30"/></br>
 <label for="commentaire"> <strong>Information complemantaire:</strong></label> <br/>
 <textarea  name="commentaire" rows="4" cols="24" id="commentaire" > </textarea></br>
 
 <?php if (isset($_SESSION['pseudo']))echo('</br><center><input type="submit" value="Envoyer" class="bouton"/></center><br/>');
          else echo('</br>Connectez vous');
 ?>
 </fieldset>
</form>
<?php
include('Controle/connexion_bdd.php');
if (isset($_POST['nom_raison-sociale'])) 
  { $_POST['nom_raison-sociale'] = htmlspecialchars($_POST['nom_raison-sociale']);
  $flag_nrs=true;
  }
    else 
	 {
				$flag_nrs=false;
	 }
if (isset($_POST['type_engin'])) 
  { $_POST['type_engin'] = htmlspecialchars($_POST['type_engin']);
  $flag_type_engin=true;
  }
    else 
	 {
				$flag_type_engin=false;
	 }	 
if (isset($_POST['nbr_tel']))
{
$_POST['nbr_tel'] = htmlspecialchars($_POST['nbr_tel']); 
//On rend inoffensives les balises HTML que le visiteur a pu entrer
if (preg_match("#^0[5-7]([-. ]?[0-9]{2}){4}$#",$_POST['nbr_tel']) or preg_match("#^0[2-4][0-9]([-. ]?[0-9]{2}){3}$#",$_POST['nbr_tel'] ))
{
$flag_nbr_tel=true;
}
else
{
echo 'Le ' . $_POST['nbr_tel'] . ' n\'est pas valide,recommencez !';
$flag_nbr_tel=false;
}
}
if (isset($_POST['matricule_engin']))
{
$_POST['matricule_engin'] = htmlspecialchars($_POST['matricule_engin']); 
//On rend inoffensives les balises HTML que le visiteur a pu entrer
if (preg_match("#^[0-9]{3}[-. ]?[0-9]{5}[-. ]?[0-9]{2}$#",$_POST['matricule_engin']) )
{
$flag_matricule_engin=true;
}
else
{
echo 'Le ' . $_POST['matricule_engin'] . ' n\'est pas valide,recommencez !';
$flag_matricule_engin=false;
}
}
if (isset($_SESSION['pseudo'])) 
     { $_SESSION['pseudo'] = htmlspecialchars($_SESSION['pseudo']);
       $flag_duree_pseudo=true;
     }
    else 
	 {
	  echo 'Connectez vous!';
	  $flag_duree_pseudo=false;
	 } 
	 if (isset($_POST['marque'])) 
     { $_POST['marque'] = htmlspecialchars($_POST['marque']);
       $flag_duree_marque=true;
     }
    else 
	 {
	  $flag_duree_marque=false;
	 } 
	 if (isset($_POST['num_serie'])) 
     { $_POST['num_serie'] = htmlspecialchars($_POST['num_serie']);
       $flag_duree_num_serie=true;
     }
    else 
	 {
	  $flag_duree_num_serie=false;
	 } 
 if ( $flag_nrs and  $flag_nbr_tel and $flag_duree_pseudo and $flag_matricule_engin and $flag_type_engin and $flag_duree_num_serie and $flag_duree_marque)
   {
     if (isset($_POST['commentaire']) ) $commentaire=$_POST['commentaire'];
      else $commentaire='';
	 $req=$bdd->prepare('INSERT INTO reclamation VALUES("",?,?,?,?,?,?,?,?,"afficher",NOW())');
     $req->execute(array($_POST['nom_raison-sociale'],$_SESSION['pseudo'],$_POST['type_engin'],$_POST['nbr_tel'], $_POST['marque'],$_POST['num_serie'],$_POST['matricule_engin'],$commentaire));	
	 $req->closeCursor();
	 $compteur_id = fopen('Modele/compteur_id_reclamation.txt','r+');
     $id_max = fgets($compteur_id);
	 fseek($compteur_id,0);
     fputs($compteur_id,($id_max+1));
     fclose($compteur_id);
	echo('Reclamation effectué</br>
	       NRS:'.$_POST['nom_raison-sociale'].'</br>
		   PSEUDONYME:'.$_SESSION['pseudo'].'</br>
		   NUM TEL:'.$_POST['nbr_tel'].'</br>
		   TYPE :'.$_POST['type_engin'].'</br>
		   MARQUE :'.$_POST['marque'].'</br>
		   NUM SERIE :'.$_POST['num_serie'].'</br>
		   MATRICULE:'.$_POST['matricule_engin'].'</br>
		   COMMENTAIRE:'.$commentaire.'</br>
		   "');  
 }
?>
</p>

</section>

<hr>
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
