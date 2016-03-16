
<?php
include('connexion_bdd.php');
//Verifie que le visiteur n'est pas connecte 
if ( !isset($_SESSION['pseudo']) and !isset($_SESSION['id']))
{
 if (isset($_COOKIE['pseudo']) and isset($_COOKIE['pass_hache']))
  { 
	
     // Hachage du mot de passe
	 $pseudo = htmlspecialchars($_COOKIE['pseudo']);
     $pass_hache = htmlspecialchars($_COOKIE['pass_hache']);
   // Vérification des identifiant
   $req = $bdd->prepare('SELECT * FROM membres WHERE pseudo = :pseudo AND pass = :pass');
   $req->execute(array(
   'pseudo' => $pseudo,
   'pass' => $pass_hache));
   $resultat = $req->fetch();
	 
  if (!$resultat)
  {
   echo '<script type="text/javascript">alert("Mot de passe ou pseudo incorrecte")</script> ';
  }else
  {
	if ( $resultat['etat_membres']=='actif')
  {  
   //crée les variables de $_SESSION
   $_SESSION['etat_membres'] = $resultat['etat_membres'];
   $_SESSION['type_membres'] = $resultat['type_membres'];
   $_SESSION['id'] = $resultat['id'];
   $_SESSION['pseudo'] = $pseudo;
   setcookie('dernier_connecter',$pseudo, time() + 365*24*3600, null, null, false,true);//Enregistre le dernier membres a c'etre connecter
    echo(' <table width="100" border="0" cellspacing="20" id="tableau_connexion" >
                    <tr>
                       <th scope="row">Membre:</th>
                       <td>'.$_SESSION['pseudo'].'</td>
                       <a href="Controle/modif_info.php"><td> Modifier  </td></a>
                       <a href="Controle/mes_commandes.php"><td> Commandes </td></a>
					   <a href="Controle/deconnexion.php"><td> Deconnexion  </td></a>
                    </tr>
                    </table>');
	}
		    else echo '<script type="text/javascript">alert("Vous avez etait banie")</script> ';				
  }
 }else
  {
   if (isset($_POST['pseudo']) and isset($_POST['password']))
    {
      // Hachage du mot de passe
      $pseudo = htmlspecialchars($_POST['pseudo']);
      $pass_hache = sha1($_POST['password']);
      // Vérification des identifiants
      $req = $bdd->prepare('SELECT * FROM membres WHERE pseudo = :pseudo AND pass = :pass');
      $req->execute(array(
      'pseudo' => $pseudo,
      'pass' => $pass_hache));
      $resultat = $req->fetch();
      //test le resultat 
      if (!$resultat )
       {
         echo '<script type="text/javascript">alert("Mot de passe ou pseudo incorrecte")</script> ';
       }else
        { if ( $resultat['etat_membres']=='actif')
          {//crée les variables de $_SESSION
		  $_SESSION['etat_membres'] = $resultat['etat_membres'];
		  $_SESSION['type_membres'] = $resultat['type_membres'];
          $_SESSION['id'] = $resultat['id'];
          $_SESSION['pseudo'] = $pseudo;
		  setcookie('dernier_connecter',$pseudo, time() + 365*24*3600, null, null, false,true);//Enregistre le dernier membres a c'etre connecter
          //Verifie si la connexion automatique a etait demande
          if ( isset($_POST['connexion_automatique']) )
           { 
	           //Ecriture des COOKIE de connexion automatique
	           setcookie('pseudo',$pseudo, time() + 365*24*3600, null, null,false, true); // On écrit un cookie
               setcookie('pass_hache',$pass_hache, time() + 365*24*3600, null, null, false,true); // On écrit un autre cookie...
			   setcookie('dernier_connecter',$pseudo, time() + 365*24*3600, null, null, false,true);//Enregistre le dernier membres a c'étre connecter
	       }  
		  header('Location:index.php');
		  }
		    else echo '<script type="text/javascript">alert("Vous avez etait banie")</script> !';
       }
      }
	}  
} 
 //Verifie que le visiteur n'est pas connecte
 if (!isset ($_SESSION['pseudo']))
 { 
   //Le formulaire de connexion
   if (isset($_COOKIE['dernier_connecter'])) 
     $pseudo_cookie= htmlspecialchars($_COOKIE['dernier_connecter']);
   elseif(isset($_COOKIE['pseudo']))
        $pseudo_cookie= htmlspecialchars($_COOKIE['pseudo']);
		else
           $pseudo_cookie='';
   echo('
    <form method="post" action="#">
	<table width="200" border="0">
       <tr>
          <th scope="col">Pseudo</th>
          <th scope="col"> <input type="text" name="pseudo" maxlength="10" value="'.$pseudo_cookie.'" required id="pseudo"></th>
       </tr><tr>
	      <td> <strong>Mots de passe</strong></td>
          <td><input  type="password" name="password"  maxlength="10" required id="password"></td>
          
       </tr>
      <tr>
	      
          <td colspan="2" align="right" ><input type="checkbox"    name="connexion_automatique" id="connexion_automatique" /><label for="connexion_automatique">Connexion-automatique </label></td>
          
      </tr>
      <tr >
	  <td><a href="inscription.php"> <input type="button" value="Inscription"/> </a></td>
	  <td ><input type="submit"  value="Connexion"></td> </tr>
   </table>

    </form>
	');
 }
?>


