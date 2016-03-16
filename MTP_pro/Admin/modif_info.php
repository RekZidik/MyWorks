<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<link rel="stylesheet" href="style.css"/>
<script src="eval_password.js" > </script>
<title>Modifier Compte </title>
</head>

<body>
<header></header>
<center>
<nav>
<?php include("interface_connexion.php"); ?>
</nav>

<section>
<?php
//Verification si au moins un des champs a ete remplit
if ( isset($_POST['email_modification']) or isset($_POST['password_modification']) or isset($_POST['password_modification']) or isset($_POST['pseudo_modification']) )
{
if (!empty($_POST['email_modification']) or !empty($_POST['password_modification']) or  !empty($_POST['pseudo_modification']) )
{
include('connexion_bdd.php');
//Verification de la validité du pseudo contenue dans la variable "$_SESSION"
if (isset($_SESSION['pseudo']))
{ 
$pseudo=htmlspecialchars($_SESSION['pseudo']);
 
$req = $bdd->prepare('SELECT * FROM membres WHERE pseudo = :pseudo ');
             $req->execute(array(
             'pseudo' => $pseudo));
 $resultat = $req->fetch();
 //Initialisaion des variables "$email","$pseudo","$pass_hache"
 if($resultat)	
  {
   $id_membre=$resultat['id'];
   $email=$resultat['email'];
   $pseudo=$resultat['pseudo'];
   $pass_hache=$resultat['pass'];
   
  		 
   $flag_error=true;
// Vérification de la validité des informations
 //Verification de l'adresse email
 if (isset($_POST['email_modification']) )
  {
    $_POST['email'] = htmlspecialchars($_POST['email_modification']); // On rend inoffensives les balises HTML que le visiteur a pu rentrer
     if (     preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#",$_POST['email_modification'])) $flag_email=true;
	     else {     if( !empty($_POST['email_modification'] )) 
		                  {
			                 echo 'L\'adresse <strong>' . $_POST['email_modification'] . '</strong> n\'est pas valide,recommencez!</br>';
			                 $flag_error=false;
			 
		                  }
		             $flag_email=false;
		      }
  } else $flag_email=false;	    
      //Verification d'absence d'erreur de frappe
     if  ( isset($_POST['password_modification']) and isset($_POST['confirmation_password']) and $_POST['password_modification']==$_POST['confirmation_password']  ) $flag_password=true;
        else {    if (!empty($_POST['password_modification']) and !empty($_POST['confirmation_password']))
		                  {
		                       echo('ERREUR de frappe lors de la saisie du mot de passe </br>');
							   $flag_error=false;
						  }
							   
							   $flag_password=false;
		     }
	  //Verification de la disponibilité du pseudo demander
	 if(isset($_POST['pseudo_modification']) and !empty($_POST['pseudo_modification'])) 
	 { $pseudo = htmlspecialchars($_POST['pseudo_modification']);
	   $req = $bdd->prepare('SELECT id FROM membres WHERE pseudo = :pseudo ');
             $req->execute(array(
             'pseudo' => $pseudo));
       $resultat = $req->fetch();
	  
       if(!$resultat) $flag_pseudo=true;
	        else {
				    echo('<strong> PSEUDONYME DEJA UTILISE OU VIDE</strong></br>');
					$flag_pseudo=false;
					$flag_error=false;
				 }
	 }
	   else $flag_pseudo=false;	  
		    
			 $pseudo = htmlspecialchars($_SESSION['pseudo']);
	         $rep = $bdd->prepare('SELECT * FROM membres WHERE pseudo = :pseudo ');
             $rep->execute(array('pseudo' => $pseudo));
			 $donnes =$rep->fetch();
			 // Hachage du mot de passe et insetion
              if ($flag_email) $email = htmlspecialchars($_POST['email_modification']);
			       else $email = $donnes['email']; 
              if($flag_password) $pass_hache = sha1($_POST['password_modification']);
			    else $pass_hache = $donnes['pass'];
			  if($flag_pseudo) $pseudo = htmlspecialchars($_POST['pseudo_modification']);
			    else $pseudo = $donnes['pseudo'];
                $req->closeCursor();
				if(($flag_email or $flag_password or $flag_pseudo) and $flag_error)
				{
                   $req = $bdd->prepare('UPDATE membres SET pseudo=:pseudo,pass=:pass,email=:email WHERE id=:id'); 
                   $req->execute(array('pseudo' => $pseudo,
                                       'pass' => $pass_hache,
                                       'email' => $email,
				                       'id'=>$id_membre)
			                           );
                 echo('Votre compte a ete mis a jour('.$pseudo.')</br>');
				 }			 
  }
  else echo("HACKER DE MERDE</br>");
 }else echo('connecter vous</br>'); 
  
 } else echo('entrer des information pour modifier quoi que ce soit</br>'); 
     
}



?>
    <p> 
    <form method="post" action="#">
    <fieldset>
    <legend> INFORMATION </legend>
  <table width="1200" border="0" class="tableau" id="tableau_modif_info">
  <tr>
    <th scope="row">Pseudo</th>
    <td><input type="text" name="pseudo_modification" maxlength="10"  id="pseudo"  autofocus placeholder="anonymous"></td>
  </tr>
  <tr>
    <th scope="row">Mot de passe</th>
    <td><input  type="password" name="password_modification"  maxlength="10"  id="password"  placeholder="mot de passe" onkeyup="evalPwd(this.value);"> </td>
  </tr>
  <th scope="row">Valeur password</th>
    <td><div id="sm" ><center><ul><li id="weak" class="nrm">Faible</li><li id="medium" class="nrm">Moyen</li><li id="strong" class="nrm">Fort</li></ul></center></div> </td>
  </tr>
  <tr>
    <th scope="row">Confirmation Mot de passe</th>
    <td><input  type="password" name="confirmation_password"  maxlength="10" id="confirmation_password"  placeholder="confirmation"></td>
  </tr>
  <tr>
    <th scope="row">E-mail</th>
    <td><input type="email" name="email_modification"   id="email" placeholder="mtp@pro.com"></td>
  </tr>
</table>
<input type="submit"  value="Confirmer">
    </fieldset>
    </form>
	
	
	</p>
</section>
</center>
<footer></footer>
</body>
</html>
