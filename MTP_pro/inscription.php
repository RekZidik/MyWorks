<?php
include("Controle/initialisation_session.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<link rel="stylesheet" href="style.css"/>
<title>Inscription </title>
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

if ( isset($_POST['email_inscription']) and isset($_POST['password_inscription']) and isset($_POST['confirmation_password']) and isset($_POST['pseudo_inscription']))
{
include('Controle/connexion_bdd.php');
// Vérification de la validité des informations
 if (isset($_POST['email_inscription']))
  {
    $_POST['email_inscription'] = htmlspecialchars($_POST['email_inscription']); // On rend inoffensives les balises HTML que le visiteur a pu rentrer
     if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#",$_POST['email_inscription']))
      {
         if( $_POST['password_inscription']!=$_POST['confirmation_password'] ) echo('ERREUR de frappe lors de la saisie du mot de passe');
		  else
		    {
			 // Hachage du mot de passe
              $email = htmlspecialchars($_POST['email_inscription']);
              $pseudo = htmlspecialchars($_POST['pseudo_inscription']);
              $pass_hache = sha1($_POST['password_inscription']);
             // Insertion
			 $req = $bdd->prepare('SELECT id FROM membres WHERE pseudo = :pseudo ');
             $req->execute(array(
             'pseudo' => $pseudo));
             $resultat = $req->fetch();
             if(!$resultat)
			  {
                $req = $bdd->prepare('INSERT INTO membres(pseudo, pass, email,date_inscription,type_membres,etat_membres) VALUES(:pseudo, :pass, :email,                                       CURDATE(),"membre","actif")'); 
                $req->execute(array(
                'pseudo' => $pseudo,
                'pass' => $pass_hache,
                'email' => $email)
			     );
				 $compteur_id = fopen('Modele/compteur_id_membres.txt','r+');
                 $id_max = fgets($compteur_id);
	             fseek($compteur_id,0);
                 fputs($compteur_id,($id_max+1));
                 fclose($compteur_id);
                 echo('<strong>Vous etes a present inscrit('.$pseudo.')</strong>');
			  }else echo('<strong> PSEUDONYME DEJA UTILISE</strong>');   
			 }
      }
     else
      {
         echo 'L\'adresse ' . $_POST['email_inscription'] . ' n\'est pas valide,recommencez !';
      }
   }


}
?>
   
	<form method="post" action="inscription.php">
    <fieldset>
    <legend> INFORMATION </legend>
    <table width="600" border="0" class="tableau" id="tableau_inscription">
  <tr>
    <th scope="row">Pseudo</th>
    <td><input type="text" name="pseudo_inscription" maxlength="10"  id="pseudo"  autofocus placeholder="anonymous"></td>
  </tr>
  <tr>
    <th scope="row">Mot de passe</th>
    <td><input  type="password" name="password_inscription"  maxlength="10"  id="password"  placeholder="mot de passe"></td>
  </tr>
  <tr>
    <th scope="row">Confirmation Mot de passe</th>
    <td><input  type="password" name="confirmation_password"  maxlength="10" id="confirmation_password"  placeholder="confirmation"></td>
  </tr>
  <tr>
    <th scope="row">E-mail</th>
    <td><input type="email" name="email_inscription"   id="email" placeholder="mtp@pro.com"></td>
  </tr>
</table>
<br/>
    <center><input type="submit"  value="Modifier" class="bouton"></center>
    </fieldset>
    </form>
	
	</p>
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
</footer></div>
</body>
</html>