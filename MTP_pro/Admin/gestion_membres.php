<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<link rel="stylesheet" href="style.css"/>
<title>Gestion_membres</title>
</head>

<body>
<header></header>
<center>
<nav>
	<?php include("interface_connexion.php"); ?>
</nav>
<section>
<?php 
//Renvoie dans "$idmax" le plus grand'id'
$compteur_id = fopen('../Modele/compteur_id_membres.txt','r+');
$id_max_comp = fgets($compteur_id);
fclose($compteur_id);
include("connexion_bdd.php"); 
$id_max=0; 
//Renvoie dans "$rep" les entr�s de la table "engin" et recherche le plus grand'id'
$req = $bdd->query('SELECT COUNT(*) AS nbr_membres FROM membres');
$donnees = $req->fetch();
 $req->closeCursor();
 $id_max=$donnees['nbr_membres'];
/*
-----------------------------------------------------------------------------------------------
debut de traitement du premier formulaire
-----------------------------------------------------------------------------------------------
*/
// Verifie si l'utilisateur a envoy� le formulaire "AFFICHER ENGIN"
 if ( isset($_POST['afficher_engin']) and isset($_POST['tache']) )
 {
  if ($_POST['tache']=='supprimer')
    {
       // Renvoie dans "$req" le nonbre d'entr�s dans la table "engin" et l'affiche
       $req = $bdd->query('SELECT COUNT(*) AS nbr_membres FROM membres');
       $nbr_membres = $req->fetch();
       echo('Nombre de membres est :'.$nbr_membres['nbr_membres'].'<br/>');
       $cpt=1;
       $nbr_objet_sup=0;
       //Recherche les engins cocher et les supprime et affiche le nombre qui a ete supprim� 
       while ($cpt <= $id_max_comp )
        { 
          if ( isset($_POST[$cpt])) 
           { 
	         $rep = $bdd->prepare('DELETE FROM membres WHERE id =?');
	         $rep->execute(array($cpt));
			 $rep->closeCursor();
			 $nbr_objet_sup=$nbr_objet_sup+1;
	       }
       $cpt=$cpt+1;  
        }
       echo('Action effectue ,nombre de membres affecte :'.$nbr_objet_sup.'<br/>');
    }
}
if ( isset($_POST['afficher_engin']) and isset($_POST['tache']) )
 {
  if ($_POST['tache']=='modifier' and !empty($_POST['modif_etat_membre']))
    {
       // Renvoie dans "$req" le nonbre d'entr�s dans la table "engin" et l'affiche
       $req = $bdd->query('SELECT COUNT(*) AS nbr_membres FROM membres');
       $nbr_membres = $req->fetch();
       echo('Nombre de membres est :'.$nbr_membres['nbr_membres'].'<br/>');
       $cpt=1;
       $nbr_objet_sup=0;
       //Recherche les engins cocher et les supprime et affiche le nombre qui a ete supprim� 
       while ($cpt <= $id_max_comp )
        { 
          if ( isset($_POST[$cpt])) 
           { $_POST['modif_etat_membre']=htmlspecialchars($_POST['modif_etat_membre']);
	         $rep = $bdd->prepare('UPDATE membres SET etat_membres=?  WHERE id =?');
	         $rep->execute(array($_POST['modif_etat_membre'],$cpt));
			 $rep->closeCursor();
			 $nbr_objet_sup=$nbr_objet_sup+1;
	       }
       $cpt=$cpt+1;  
        }
       echo('Action effectue ,nombre de membres affecte :'.$nbr_objet_sup.'<br/>');
    }
}		
     
/*
----------------------------------------------------------------------------------------------------------------------------------------
fin de traitement du premier formulaire
----------------------------------------------------------------------------------------------------------------------------------------
*/ 
//Renvoie dans "$req" les entr�s de la table "engin" et recherche
 $req = $bdd->query('SELECT * FROM membres ');
 $resultat = $req->fetch();
 //test l'existance d'entr�es
 if (!$resultat)
  {
   echo '<script type="text/javascript">alert("Pas de membres dans la base de donnee")</script> ';
  }
  $req->closeCursor();
	 //Affichage du formulaire "AFFICHAGE DES ENGINS"
	?>
	
	<form method="post" action="gestion_membres.php">
	       <fieldset>
		   <legend> AFFICHAGE DES MEMBRES</legend>
           <table width="1200" border="1" cellspacing="2">
      <tr>
        <th scope="col">Pseudo</th>
        <th scope="col">Type_membre</th>
        <th scope="col">Etat_membre</th>
      </tr>
     <tr> <td> <input typ="text" name="critere_pseudo"  id="critere_pseudo" /> </td>
          <td> <select name="critere_type_membre" id="critere_type_membre">
               <option value=""> -------- </option>
               <option value="membre"> Membre </option>
               <option value="administrateur"> Administrateur </option>
               </select> </td>
          <td> <select name="critere_etat_membre"  id="critere_etat_membre">
               <option value=""> -------- </option>
               <option value="actif"> Actif </option>
               <option value="banie"> Banie </option>
               </select> </td>
      </tr>
   </table>       
		   <table width="1200" border="1" cellspacing="2">
  <tr>
    <th scope="col">ID</th>
    <th scope="col">Selection</th>
    <th scope="col">Pseudo</th>
    <th scope="col">Email</th>
    <th scope="col">Date_inscription</th>
	<th scope="col">Type_membre</th>
    <th scope="col">Etat_membre</th>
  </tr>

	<?php  
    if ( isset($_POST['email_inscription']) and isset($_POST['password_inscription']) and isset($_POST['confirmation_password']) and isset($_POST['pseudo_inscription']))
{
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
			  $type_membre = htmlspecialchars($_POST['type_membre_inscription']);
             // Insertion
			 $req = $bdd->prepare('SELECT id FROM membres WHERE pseudo = :pseudo ');
             $req->execute(array(
             'pseudo' => $pseudo));
             $resultat = $req->fetch();
             if(!$resultat)
			  {
                $req = $bdd->prepare('INSERT INTO membres(pseudo, pass, email,date_inscription,type_membres,etat_membres) VALUES(:pseudo, :pass, :email,                                       CURDATE(),:type_membre_inscription,"actif")'); 
                $req->execute(array(
                'pseudo' => $pseudo,
                'pass' => $pass_hache,
                'email' => $email,
				'type_membre_inscription'=>$type_membre)
			     );
				 $compteur_id = fopen('../Modele/compteur_id_membres.txt','r+');
                 $id_max = fgets($compteur_id);
	             fseek($compteur_id,0);
                 fputs($compteur_id,($id_max+1));
                 fclose($compteur_id);
                 echo('<strong>VOUS AVEZ AJOUTER LE MEMBRE('.$pseudo.')</strong>');
			  }else echo('<strong> PSEUDONYME DEJA UTILISE</strong>');   
			 }
      }
     else
      {
         echo 'L\'adresse ' . $_POST['email_inscription'] . ' n\'est pas valide,recommencez !';
      }
   }


}
	 //Definie la partie du forum demande 
	 if(isset($_GET['index_page']) )
		 {
		  if($_GET['index_page']>=0) $index_page=(int) htmlspecialchars($_GET['index_page']);
		     else {echo('index de page non autorisée');$index_page=0;}
			 if(isset($_GET['pseudo'])) $_POST['critere_pseudo']= htmlspecialchars($_GET['pseudo']);
			 if(isset($_GET['type_membre'])) $_POST['critere_type_membre']= htmlspecialchars($_GET['type_membre']);
			 if(isset($_GET['etat_membre'])) $_POST['critere_etat_membre']= htmlspecialchars($_GET['etat_membre']);
		 }
		 else $index_page=0;
	
	
	$flag=0;
	 if (isset($_POST['critere_pseudo']) and !empty($_POST['critere_pseudo'])) $flag=1;
	 if (isset($_POST['critere_type_membre']) and !empty($_POST['critere_type_membre'])) $flag=2;
	 if (isset($_POST['critere_pseudo']) and !empty($_POST['critere_pseudo']) and isset($_POST['critere_type_membre']) and !empty($_POST['critere_type_membre']))
	 $flag=3;
	 if (isset($_POST['critere_etat_membre']) and !empty($_POST['critere_etat_membre'])) $flag=4;
	 if (isset($_POST['critere_pseudo']) and !empty($_POST['critere_pseudo']) and isset($_POST['critere_etat_membre']) and !empty($_POST['critere_etat_membre'])) $flag=5;
	 if ( isset($_POST['critere_type_membre']) and !empty($_POST['critere_type_membre']) and  isset($_POST['critere_etat_membre']) and !empty($_POST['critere_etat_membre'])) $flag=6;
	 if (isset($_POST['critere_pseudo']) and !empty($_POST['critere_pseudo']) and isset($_POST['critere_type_membre']) and !empty($_POST['critere_type_membre']) and  isset($_POST['critere_etat_membre']) and !empty($_POST['critere_etat_membre'])) $flag=7;
	 
	 switch($flag)
		{ 
		case 1:{
			    $_POST['critere_pseudo']=htmlspecialchars($_POST['critere_pseudo']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM membres WHERE pseudo=?');
				$req->execute(array($_POST['critere_pseudo']));
		        $nbr_messages=$req->fetch();
				$nbr_liens=$nbr_messages['nbr_message']/10;
				$_GET['pseudo']=$_POST['critere_pseudo'];
	            $rep = $bdd->prepare('SELECT * FROM membres WHERE pseudo=? ORDER BY id DESC LIMIT '.( $index_page*10).',10');
	            $rep->execute(array($_POST['critere_pseudo']));
	           }break; 
		case 2:{
			    $_POST['critere_type_membre']=htmlspecialchars($_POST['critere_type_membre']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM membres WHERE type_membres=?');
				$req->execute(array($_POST['critere_type_membre']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
				$nbr_liens=$nbr_messages['nbr_message']/10;
				$_GET['type_membre']=$_POST['critere_type_membre'];
	            $rep = $bdd->prepare('SELECT * FROM membres WHERE type_membres=? ORDER BY id DESC LIMIT '.( $index_page*10).',10');
	            $rep->execute(array($_POST['critere_type_membre']));
	           }break; 
		case 3:{
			    $_POST['critere_pseudo']=htmlspecialchars($_POST['critere_pseudo']);
				 $_POST['critere_type_membre']=htmlspecialchars($_POST['critere_type_membre']);
				 $req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM membres WHERE pseudo=? AND type_membre=?');
				$req->execute(array($_POST['critere_pseudo'],$_POST['critere_type_membre']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
				$nbr_liens=$nbr_messages['nbr_message']/10;
				$_GET['pseudo']=$_POST['critere_pseudo'];
				$_GET['type_membre']=$_POST['critere_type_membre'];
	            $rep = $bdd->prepare('SELECT * FROM membres WHERE pseudo=? AND type_membres=? ORDER BY id DESC LIMIT '.( $index_page*10).',10');
	            $rep->execute(array($_POST['critere_pseudo'],$_POST['critere_type_membre']));
	           }break; 
		case 4:{
			    $_POST['critere_etat_membre']=htmlspecialchars($_POST['critere_etat_membre']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM membres WHERE etat_membres=?');
				$req->execute(array($_POST['critere_etat_membre']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
				$nbr_liens=$nbr_messages['nbr_message']/10;
				$_GET['etat_membre']=$_POST['critere_etat_membre'];
	            $rep = $bdd->prepare('SELECT * FROM membres WHERE etat_membres=? ORDER BY id DESC LIMIT '.( $index_page*10).',10');
	            $rep->execute(array($_POST['critere_etat_membre']));
	           }break; 
		case 5:{
			    $_POST['critere_pseudo']=htmlspecialchars($_POST['critere_pseudo']);
				$_POST['critere_etat_membre']=htmlspecialchars($_POST['critere_etat_membre']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM membres WHERE pseudo=? AND etat_membres=?');
				$req->execute(array($_POST['critere_pseudo'],$_POST['critere_etat_membre']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
				$nbr_liens=$nbr_messages['nbr_message']/10;
				$_GET['pseudo']=$_POST['critere_pseudo'];
				$_GET['etat_membre']=$_POST['critere_etat_membre'];
	            $rep = $bdd->prepare('SELECT * FROM membres WHERE pseudo=? AND etat_membres=? ORDER BY id DESC LIMIT '.( $index_page*10).',10');
	            $rep->execute(array($_POST['critere_pseudo'],$_POST['critere_etat_membre']));
	           }break; 
		case 6:{
				$_POST['critere_type_membre']=htmlspecialchars($_POST['critere_type_membre']);
				$_POST['critere_etat_membre']=htmlspecialchars($_POST['critere_etat_membre']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM membres WHERE type_membres=? AND etat_membres=?');
				$req->execute(array($_POST['critere_type_membre'],$_POST['critere_etat_membre']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
				$nbr_liens=$nbr_messages['nbr_message']/10;
				$_GET['type_membre']=$_POST['critere_type_membre'];
				$_GET['etat_membre']=$_POST['critere_etat_membre'];
	            $rep = $bdd->prepare('SELECT * FROM membres WHERE type_membres=? AND etat_membres=? ORDER BY id DESC LIMIT'.( $index_page*10).',10');
	            $rep->execute(array($_POST['critere_type_membre'],$_POST['critere_etat_membre']));
	           }break; 	
		case 7:{
			    $_POST['critere_pseudo']=htmlspecialchars($_POST['critere_pseudo']);
				$_POST['critere_type_membre']=htmlspecialchars($_POST['critere_type_membre']);
				$_POST['critere_etat_membre']=htmlspecialchars($_POST['critere_etat_membre']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM membres WHERE pseudo=? AND type_membres=? AND etat_membres=?');
				$req->execute(array($_POST['critere_pseudo'],$_POST['critere_type_membre'],$_POST['critere_etat_membre']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
	            $nbr_liens=$nbr_messages['nbr_message']/10;
				$_GET['pseudo']=$_POST['critere_pseudo'];
				$_GET['type_membre']=$_POST['critere_type_membre'];
				$_GET['etat_membre']=$_POST['critere_etat_membre'];
	            $rep = $bdd->prepare('SELECT * FROM membres WHERE pseudo=? AND type_membres=? AND etat_membres=? ORDER BY id DESC LIMIT'.( $index_page*10).',10');
	            $rep->execute(array($_POST['critere_pseudo'],$_POST['critere_type_membre'],$_POST['critere_etat_membre']));
	           }break; 	      	   	   	   	   
	    default:
		        { $req=$bdd->query('SELECT COUNT(*) AS nbr_message FROM membres');
		          $nbr_messages=$req->fetch();
		          $req->closeCursor();
	              $nbr_liens=$nbr_messages['nbr_message']/10;
	              $rep = $bdd->query('SELECT * FROM membres ORDER BY id DESC LIMIT '.( $index_page*10).',10');
				  
	            }
		}
	 //Inclue un a un les engin sous forme de case a cocher 	   
	 while ($donnees = $rep->fetch())
        {
		 
         echo(' <tr>
		        <td>'.$donnees['id'].'</td>
		        <td><input type="checkbox" name="'.$donnees['id'].'" id="'.$donnees['id'] .'" /><label for="'.$donnees['id'].'"></label></td>
				<td>'.$donnees['pseudo'].'</td>
				<td>'.$donnees['email'].'</td>
				<td>'.$donnees['date_inscription'].'</td>
				<td>'.$donnees['type_membres'].'</td>
				<td>'.$donnees['etat_membres'].'</td>
				</tr>');
        }
		
		
	?>
	</table>
    
    <table width="1200" border="0" cellspacing="0">
      <tr>
       <?php
	   if(isset($_GET['pseudo']) )$pseudo=$_GET['pseudo'];
	      else $pseudo='';
	    if(isset($_GET['type_membre']) )$type_membre=$_GET['type_membre'];
	      else $type_membre='';
	   if(isset($_GET['etat_membre']) )$etat_membre=$_GET['etat_membre'];
	      else $etat_membre='';
	  
	   $i=0;
    while($i<$nbr_liens)
	{ 
	   echo('<th scope="col"> <a href=gestion_membres.php?index_page='.$i.'&amp;pseudo='.$pseudo.'&amp;type_membre='.$type_membre.'&amp;etat_membre='.$etat_membre.'>'.($i+1).'</a></th>');
	   $i++;
	}
	    ?>
	</tr>
    </table>
	<input type="radio" name="tache" value="supprimer" id="tache1"/><label for="tache1">Supprimer un membre </label>
	<input type="radio" name="tache" value="modifier" id="tache2"/><label for="tache2">Modifier un membre </label><br/>
    <select name="modif_etat_membre"  id="modif_etat_membre">
               <option value=""> -------- </option>
               <option value="actif"> Actif </option>
               <option value="banie"> Banie </option>
               </select>	</br>
	<input type="submit" name="afficher_engin" value="Confirmer"/> 
	<a href="http://127.0.0.1/MTP_pro/Admin/gestion_membres.php"> <input type="button" name="actualiser" value="Actualiser"/> </a>
	</fieldset> 
	</form>	

   
	<form method="post" action="gestion_membres.php">
    <fieldset>
    <legend> AJOUTER UN MEMBRE </legend>
    <table width="1200" border="1" cellspacing="2" >
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
   <tr>
    <th scope="row">Etat_membre</th>
    <td><select name="type_membre_inscription" id="type_membre_inscription">
               <option value="membre"> Membre </option>
               <option value="administrateur"> Administrateur </option>
               </select></td>
  </tr>
</table>
<br/>
    <center><input type="submit" name="ajout_membre"  value="Ajouter" class="bouton"></center>
    </fieldset>
    </form>
</section>
</center>
<footer></footer>
</body>
</html>




   