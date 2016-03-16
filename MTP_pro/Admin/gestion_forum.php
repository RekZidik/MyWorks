<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<link rel="stylesheet" href="style.css"/>
<title>Gestion du forum </title>
<script >
// JavaScript Document
<!--
// ==========================
// Script réalisé par Eric Marcus - Aout 2006
// ==========================

// conteneur = id du bloc (<div>, <p> ...) contenant les checkbox
// a_faire = '0' pour tout décocher
// a_faire = '1' pour tout cocher
// a_faire = '2' pour inverser la sélection
//-->table tr td input
function GereChkbox( a_faire) {
var blnEtat=null;
var Chckbox = document.querySelectorAll(' #cac ');
var long =  Chckbox.length;
var i =0;
alert('i am number'+long);
	while ( i< long) {
		
				blnEtat = (a_faire=='0') ? false : (a_faire=='1') ? true : (Chckbox[i].checked) ? false : true;
				Chckbox[i].checked=blnEtat;
			
		i++;
	}
}
</script>

</head>

<body>
<header></header>
<nav>
<?php include("interface_connexion.php"); ?>
</nav>
<section>
<?php 
 include("connexion_bdd.php"); 
$id_max=0; 
$compteur_id = fopen('../Modele/compteur_id_forum.txt','r+');
$id_max = fgets($compteur_id);
fclose($compteur_id);
//Renvoie dans "$rep" les entrés de la table "engin" et recherche le plus grand'id'
$rep = $bdd->query('SELECT * FROM mini_chat ');
while ($donnees=$rep->fetch())
 {
  if (isset($donnees['id'])) $id_max++;
 }

	if( isset($_POST["ajouter_message"]))
{
	$_SESSION['pseudo']=htmlspecialchars($_SESSION['pseudo']);
	$_POST["message"]=htmlspecialchars($_POST["message"]);
    $ban_word = fopen('../Modele/mots_interdit.txt','r+');
    $flag=true;
    while( ($mot = fgets($ban_word)) and $flag)
	{
		$flag=preg_match('#'.$mot.'#i',$_POST["message"]);
	}
	if ($flag)
	     {
            $req=$bdd->prepare('INSERT INTO mini_chat(pseudo, message,etat_message,date) VALUES(?,?,"afficher",NOW())');
            $req->execute(array($_SESSION['pseudo'],$_POST['message']));
            $req->closeCursor();
                 $compteur_id = fopen('../Modele/compteur_id_forum.txt','r+');
                 $id_max = fgets($compteur_id);
	             fseek($compteur_id,0);
                 fputs($compteur_id,($id_max+1));
                 fclose($compteur_id);
          }else echo '<script type="text/javascript">alert("Nous n\'autorisons pas d\'insulte sur ce forum")</script> ';
}
	
/*
-----------------------------------------------------------------------------------------------
debut de traitement du premier formulaire
-----------------------------------------------------------------------------------------------
*/
// Verifie si l'utilisateur a envoyé le formulaire "AFFICHER ENGIN"
 if ( isset($_POST['afficher_engin']) and isset($_POST['tache']) )
 {
  if ($_POST['tache']=='supprimer')
    {
       // Renvoie dans "$req" le nonbre d'entrés dans la table "engin" et l'affiche
       $req = $bdd->query('SELECT COUNT(*) AS nbr_engin FROM mini_chat');
       $nbr_engin = $req->fetch();
       echo('Nombre de message est :'.$nbr_engin['nbr_engin'].'<br/>');
       $cpt=1;
       $nbr_objet_sup=0;
       //Recherche les engins cocher et les supprime et affiche le nombre qui a ete supprimé 
       while ($cpt <= $id_max )
        { 
          if ( isset($_POST[$cpt])) 
           { 
	         $rep = $bdd->prepare('DELETE FROM mini_chat WHERE id =?');
	         $rep->execute(array($cpt));
			 $rep->closeCursor();
			 $nbr_objet_sup=$nbr_objet_sup+1;
	       }
       $cpt=$cpt+1;  
        }
       echo('action effectue ,nombre de message affecté :'.$nbr_objet_sup.'<br/>');
    }
}	
     
/*
----------------------------------------------------------------------------------------------------------------------------------------
fin de traitement du premier formulaire
----------------------------------------------------------------------------------------------------------------------------------------
*/ 
//Renvoie dans "$req" les entrés de la table "engin" et recherche
 $req = $bdd->query('SELECT * FROM mini_chat ');
 $resultat = $req->fetch();
 //test l'existance d'entrées
 if (!$resultat)
  {
   echo '<script type="text/javascript">alert("Pas de messages dans la base de donnée")</script> !';
  }
  
	 //Affichage du formulaire "AFFICHAGE DES ENGINS"
	?>
	<fieldset>
   <form method="post" action="gestion_forum.php" name="div_chck">
   <legend> AFFICHAGE DES MESSAGES</legend>
   <input type="button" value="Tout cocher" onClick="GereChkbox('1');">&nbsp;&nbsp;&nbsp;
   <input type="button" value="Tout décocher" onClick="GereChkbox('0');">&nbsp;&nbsp;&nbsp;
   <input type="button" value="Inverser la sélection" onClick="GereChkbox('2');">
<br /><br />
   <table width="1200" border="1" cellspacing="2" id="div_chck" >
   
      <tr>
        <th scope="col">Pseudo</th>
        <th scope="col">Date</th>
        <th scope="col">Date(borne_sup)</th> 
      </tr>
     <tr> <td> <input typ="text" name="critere_pseudo"  id="critere_pseudo" /> </td>
          <td> <input typ="text" name="critere_date"  id="critere_date" /> </td>
          <td><input typ="text" name="critere_date_sup"  id="critere_date_sup" /></td>
      </tr>
   </table>       
   <table width="1200" border="1" cellspacing="2"> 
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Selection</th>
        <th scope="col">Pseudo</th>
        <th scope="col">Message</th>
        <th scope="col">Date</th> 
      </tr>
	<?php
	//Definie la partie du forum demande 
	 if(isset($_GET['index_page']) )
		 { 
		  if($_GET['index_page']>=0) $index_page=(int) htmlspecialchars($_GET['index_page']);
		     else{echo('index de page non autorisée');$index_page=0;}
			 if(isset($_GET['pseudo'])) $_POST['critere_pseudo']= htmlspecialchars($_GET['pseudo']);
			 if(isset($_GET['date'])) $_POST['critere_date']= htmlspecialchars($_GET['date']);
			 if(isset($_GET['date_sup'])) $_POST['critere_date_sup']= htmlspecialchars($_GET['date_sup']);
		 }
		 else $index_page=0;
	//initialisation des drapeaux selon les cas
	
	 $flag=0;
	 if (isset($_POST['critere_pseudo']) and !empty($_POST['critere_pseudo'])) $flag=1;
	 if (isset($_POST['critere_date']) and !empty($_POST['critere_date'])) $flag=2;
	 if (isset($_POST['critere_pseudo']) and !empty($_POST['critere_pseudo']) and isset($_POST['critere_date']) and !empty($_POST['critere_date']))
	 $flag=3;
	 if (isset($_POST['critere_date_sup']) and !empty($_POST['critere_date_sup'])) $flag=4;
	 if (isset($_POST['critere_pseudo']) and !empty($_POST['critere_pseudo']) and isset($_POST['critere_date_sup']) and !empty($_POST['critere_date_sup'])) $flag=5;
	 if ( isset($_POST['critere_date']) and !empty($_POST['critere_date']) and  isset($_POST['critere_date_sup']) and !empty($_POST['critere_date_sup'])) $flag=6;
	 if (isset($_POST['critere_pseudo']) and !empty($_POST['critere_pseudo']) and isset($_POST['critere_date']) and !empty($_POST['critere_date']) and  isset($_POST['critere_date_sup']) and !empty($_POST['critere_date_sup'])) $flag=7;
	 
		//introduction dans la base de données selon les cas
	    switch($flag)
		{ 
		case 1:{
			    $_POST['critere_pseudo']=htmlspecialchars($_POST['critere_pseudo']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM mini_chat WHERE pseudo=?');
				$req->execute(array($_POST['critere_pseudo']));
		        $nbr_messages=$req->fetch();
				$req->closeCursor();
				$nbr_liens=$nbr_messages['nbr_message']/10;
				$_GET['pseudo']=$_POST['critere_pseudo'];
	            $rep = $bdd->prepare('SELECT * FROM mini_chat WHERE pseudo=? ORDER BY id DESC LIMIT '.( $index_page*10).',10');
	            $rep->execute(array($_POST['critere_pseudo']));
				
	           }break; 
		case 2:{
			    $_POST['critere_date']=htmlspecialchars($_POST['critere_date']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM mini_chat WHERE date=?');
				$req->execute(array($_POST['critere_date']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
				$nbr_liens=$nbr_messages['nbr_message']/10;
				$_GET['date']=$_POST['critere_date'];
	            $rep = $bdd->prepare('SELECT * FROM mini_chat WHERE date=? ORDER BY id DESC LIMIT '.( $index_page*10).',10');
	            $rep->execute(array($_POST['critere_date']));
				
	           }break; 
		case 3:{
			    $_POST['critere_pseudo']=htmlspecialchars($_POST['critere_pseudo']);
				 $_POST['critere_date']=htmlspecialchars($_POST['critere_date']);
				 $req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM mini_chat WHERE pseudo=? AND date=?');
				$req->execute(array($_POST['critere_pseudo'],$_POST['critere_date']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
				$nbr_liens=$nbr_messages['nbr_message']/10;
				$_GET['pseudo']=$_POST['critere_pseudo'];
				$_GET['date']=$_POST['critere_date'];
	            $rep = $bdd->prepare('SELECT * FROM mini_chat WHERE pseudo=? AND date=? ORDER BY id DESC LIMIT '.( $index_page*10).',10');
	            $rep->execute(array($_POST['critere_pseudo'],$_POST['critere_date']));
				
	           }break; 
		case 4:{
			    $_POST['critere_date_sup']=htmlspecialchars($_POST['critere_date_sup']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM mini_chat WHERE date<=?');
				$req->execute(array($_POST['critere_date_sup']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
				$nbr_liens=$nbr_messages['nbr_message']/10;
				$_GET['date_sup']=$_POST['critere_date_sup'];
	            $rep = $bdd->prepare('SELECT * FROM mini_chat WHERE date<=? ORDER BY id DESC LIMIT '.( $index_page*10).',10');
	            $rep->execute(array($_POST['critere_date_sup']));
				
	           }break; 
		case 5:{
			    $_POST['critere_pseudo']=htmlspecialchars($_POST['critere_pseudo']);
				$_POST['critere_date_sup']=htmlspecialchars($_POST['critere_date_sup']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM mini_chat WHERE pseudo=? AND date<=?');
				$req->execute(array($_POST['critere_pseudo'],$_POST['critere_date']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
				$nbr_liens=$nbr_messages['nbr_message']/10;
				$_GET['pseudo']=$_POST['critere_pseudo'];
				$_GET['date_sup']=$_POST['critere_date_sup'];
	            $rep = $bdd->prepare('SELECT * FROM mini_chat WHERE pseudo=? AND date<=? ORDER BY id DESC LIMIT '.( $index_page*10).',10');
	            $rep->execute(array($_POST['critere_pseudo'],$_POST['critere_date_sup']));
				
	           }break; 
		case 6:{
			    $_POST['critere_pseudo']=htmlspecialchars($_POST['critere_pseudo']);
				$_POST['critere_date']=htmlspecialchars($_POST['critere_date']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM mini_chat WHERE pseudo=? AND date=?');
				$req->execute(array($_POST['critere_pseudo'],$_POST['critere_date']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
				$nbr_liens=$nbr_messages['nbr_message']/10;
				$_GET['pseudo']=$_POST['critere_pseudo'];
				$_GET['date']=$_POST['critere_date'];
	            $rep = $bdd->prepare('SELECT * FROM mini_chat WHERE pseudo=? AND date=? ORDER BY id DESC LIMIT'.( $index_page*10).',10');
	            $rep->execute(array($_POST['critere_pseudo'],$_POST['critere_date']));
				
	           }break; 	
		case 7:{
			    $_POST['critere_pseudo']=htmlspecialchars($_POST['critere_pseudo']);
				$_POST['critere_date']=htmlspecialchars($_POST['critere_date']);
				$_POST['critere_date_sup']=htmlspecialchars($_POST['critere_date_sup']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM mini_chat WHERE pseudo=? AND date>=? AND date<=?');
				$req->execute(array($_POST['critere_pseudo'],$_POST['critere_date'],$_POST['critere_date_sup']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
	            $nbr_liens=$nbr_messages['nbr_message']/10;
				$_GET['pseudo']=$_POST['critere_pseudo'];
				$_GET['date']=$_POST['critere_date'];
				$_GET['date_sup']=$_POST['critere_date_sup'];
	            $rep = $bdd->prepare('SELECT * FROM mini_chat WHERE pseudo=? AND date>=? AND date<=? ORDER BY id DESC LIMIT'.( $index_page*10).',10');
	            $rep->execute(array($_POST['critere_pseudo'],$_POST['critere_date'],$_POST['critere_date_sup']));
				
	           }break; 	      	   	   	   	   
	    default:
		        { $req=$bdd->query('SELECT COUNT(*) AS nbr_message FROM mini_chat');
		          $nbr_messages=$req->fetch();
		          $req->closeCursor();
	              $nbr_liens=$nbr_messages['nbr_message']/10;
	              $rep = $bdd->query('SELECT * FROM mini_chat ORDER BY id DESC LIMIT '.( $index_page*10).',10');
				  
	            }
		}

	
	 //Inclue un a un les engin sous forme de case a cocher 
	 	   
	 while ($donnees = $rep->fetch())
        {
         echo(' <tr >
		        <td >'.$donnees['id'].'</td>
		        <td ><input type="checkbox" name="'.$donnees['id'].'" id="cac" /><label for="'.$donnees['id'].'"></label></td>
				<td>'.$donnees['pseudo'].'</td>
				<td>'.$donnees['message'].'</td>
				<td>'.$donnees['date'].'</td>
				</tr>');
		
        }
		$rep->closeCursor();
		?>
     </table>
      
   
    <table width="1200" border="0" cellspacing="0">
      <tr>
       <?php
	   if(isset($_GET['pseudo']) )$pseudo=$_GET['pseudo'];
	      else $pseudo='';
	   if(isset($_GET['date']) )$date=$_GET['date'];
	      else $date='';
	   if(isset($_GET['date_sup']) )$date_sup=$_GET['date_sup'];
	      else $date_sup='';
	   $i=0;
    while($i<$nbr_liens)
	{ 
	   echo('<th scope="col"> <a href=gestion_forum.php?index_page='.$i.'&amp;pseudo='.$pseudo.'&amp;date='.$date.'&amp;date_sup='.$date_sup.'>'.($i+1).'</a></th>');
	   $i++;
	}
	    ?>
	</tr>
    </table>
	
    
	<input type="radio" name="tache" value="supprimer" id="tache1"/><label for="tache1">Supprimer un message </label>
	<br/>	
	<input type="submit" name="afficher_engin" /> 
	<a href="http://127.0.0.1/MTP_pro/Admin/gestion_forum.php"> <input type="button" name="actualiser" value="Actualiser"/></a>
	 <br/>
	</form>	
    </fieldset>
     <legend> AJOUTER UN MESSAGE </legend>
    <form method="post" action="gestion_forum.php">
    <fieldset>
    <textarea id='message'  name="message" cols="30" rows="8"  required   ></textarea><br/>	
	<input type="submit" name="ajouter_message"  value="Confirmer"/> 
    </fieldset>
    </form>
    
    

</section>
<footer>
</footer>
</body>
</html>
