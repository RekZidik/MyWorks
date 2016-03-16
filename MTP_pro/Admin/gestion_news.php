<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<link rel="stylesheet" href="style.css"/>
<title>Gestion_news</title>
</head>

<body>
<header></header>
<center>
<nav>
<?php include("interface_connexion.php"); ?>
</nav>
<section>
<?php
// connexion a la base de donnée
 include("connexion_bdd.php");
 //Renvoie dans "$idmax" le plus grand'id'
$compteur_id = fopen('compteur_id_news.txt','r+');
$id_max = fgets($compteur_id);
fclose($compteur_id);
if (isset($_POST['ajout_news']))
{
	if(!empty($_POST['titre']))
	 {
		 $flag_titre=true;
		 $_POST['titre']=htmlspecialchars($_POST['titre']);
	 }
	  else $flag_titre=false;
	if(!empty($_POST['type_news']))
	 {
		 $flag_type_news=true;
		 $_POST['type_news']=htmlspecialchars($_POST['type_news']);
	 }
	  else $flag_type_news=false;
	if(!empty($_POST['contenue']))
	 {
		 $flag_contenue=true;
		 $_POST['contenue']=htmlspecialchars($_POST['contenue']);
	 }
	  else $flag_contenue=false;   
	if(!empty($_POST['etat_news_ajout']))
	 {
		 $flag_etat_news_ajout=true;
		 $_POST['etat_news_ajout']=htmlspecialchars($_POST['etat_news_ajout']);
		 
	 }
	  else {$flag_etat_news_ajout=false;    }
	
	if(	 $flag_titre and $flag_type_news and $flag_contenue and $flag_etat_news_ajout)
	 {
		  $req=$bdd->prepare('INSERT INTO news(titre,contenu,type_news,etat_news,date_ajout) VALUES(:titre,:contenu,:type_news,:etat_news,NOW())');
          $req->execute(array('titre'=>$_POST['titre'],
                              'type_news'=>$_POST['type_news'], 
					          'contenu'=>$_POST['contenue'],
							  'etat_news'=>$_POST['etat_news_ajout']
					          ));
		  $compteur_id = fopen('compteur_id_news.txt','r+');
		  fseek($compteur_id,0);
          fputs($compteur_id,($id_max+1));
          fclose($compteur_id);			
	 }
	 else echo('l\'un des champs n\'a pas ete remplit');
}
		   
		 

/*
-----------------------------------------------------------------------------------------------
debut de traitement du premier formulaire
-----------------------------------------------------------------------------------------------
*/
// Verifie si l'utilisateur a envoyé le formulaire "AFFICHER ENGIN"
 if ( isset($_POST['afficher_news']) and isset($_POST['tache']) )
 {
  if ($_POST['tache']=='supprimer')
    {
       // Renvoie dans "$req" le nonbre d'entrés dans la table "engin" et l'affiche
       $req = $bdd->query('SELECT COUNT(*) AS nbr_news FROM news');
       $nbr_engin = $req->fetch();
       echo('Nombre de news est'.$nbr_engin['nbr_news'].'<br/>');
       $cpt=1;
       $nbr_objet_sup=0;
       //Recherche les engins cocher et les supprime et affiche le nombre qui a ete supprimé 
       while ($cpt <= $id_max )
        { 
          if ( isset($_POST[$cpt])) 
           { 
	         $rep = $bdd->prepare('DELETE FROM news WHERE id =?');
	         $rep->execute(array($cpt));
			 $rep->closeCursor();
	         $nbr_objet_sup=$nbr_objet_sup+1;
	       }
       $cpt=$cpt+1;  
        }
       echo('action effectue ,nombre de news affecté :'.$nbr_objet_sup.'<br/>');
    }

  if ($_POST['tache']=='modifier')
  {
	    // Renvoie dans "$req" le nonbre d'entrés dans la table "engin" et l'affiche
       $req = $bdd->query('SELECT COUNT(*) AS nbr_news FROM news');
       $nbr_engin = $req->fetch();
       echo('Nombre de news est'.$nbr_engin['nbr_news'].'<br/>');
       $cpt=1;
       $nbr_objet_sup=0;
	   $_POST['etat_news']=htmlspecialchars($_POST['etat_news']);
	   $_POST['type_news_modif']=htmlspecialchars($_POST['type_news_modif']);
       //Recherche les engins cocher et les supprime et affiche le nombre qui a ete supprimé
	   $flag=0;
	   if(!empty($_POST['etat_news'])  )  $flag=1;
	   if(!empty($_POST['type_news_modif'])  )  $flag=2;
	   if(!empty($_POST['type_news_modif']) and !empty( $_POST['etat_news'])  )  $flag=3;
		
	   
       while ($cpt <= $id_max )
        { 
          if ( isset($_POST[$cpt])) 
           {
			 $nbr_objet_sup=$nbr_objet_sup+1; 
		   switch ($flag)
		    { 
		      case 1:{$rep = $bdd->prepare('UPDATE news SET etat_news=:etat_news  WHERE id =:id_a_modif');
	          $rep->execute(array('etat_news'=>$_POST['etat_news'],
								  'id_a_modif'=>$cpt));}break;
		  
		      case 2:{$rep = $bdd->prepare('UPDATE news SET type_news=:type_news  WHERE id =:id_a_modif');
	          $rep->execute(array('type_news'=>$_POST['type_news_modif'],
								  'id_a_modif'=>$cpt));}break;
		  
		      case 3:{$rep = $bdd->prepare('UPDATE news SET type_news=:type_news,etat_news=:etat_news  WHERE id =:id_a_modif');
	          $rep->execute(array('type_news'=>$_POST['type_news_modif'],
			                      'etat_news'=>$_POST['etat_news'],
								  'id_a_modif'=>$cpt));}break;
	          default:;break;
		    }
	       }
       $cpt=$cpt+1;  
        }
       echo('action effectue ,nombre de news affecté :'.$nbr_objet_sup.'<br/>');
    }
	}
  
     
/*
----------------------------------------------------------------------------------------------------------------------------------------
fin de traitement du premier formulaire
----------------------------------------------------------------------------------------------------------------------------------------
*/ 
 //Renvoie dans "$req" les entrés de la table "engin" et recherche
 $req = $bdd->query('SELECT * FROM news ');
 $resultat = $req->fetch();
 //test l'existance d'entrées
 if (!$resultat)
  {
   echo '<script type="text/javascript">alert("Pas d\' engins dans la base de donnée")</script> !';
  }
  
	 //Affichage du formulaire "AFFICHAGE DES NEWS"
	?>
	
	<form method="post" action="gestion_news.php">
	       <fieldset>
		   <legend><h1> AFFICHAGE DES NEWS </h1></legend>
           <table width="1200" border="1" cellspacing="2">
      <tr>
        <th scope="col">Titre</th>
        <th scope="col">Type</th>
        <th scope="col">Etat</th> 
      </tr>
     <tr> 
          <td><input typ="text" name="critere_titre"  id="critere_titre" /></td>
          <td> 
          <select id="critere_type" name="critere_type" >
           <option value=""> ------- </option>
           <option value="annonce"> Annonce </option>
           <option value="message_admin"> Message admin </option>
           <option value="important"> <em>Important</em> </option>
          </select> 
          </td>
          <td> 
          <select name="critere_etat_news" id="critere_etat_news">
           <option value="">---------</option>
           <option value="afficher"> Afficher </option>
           <option value="masque"> Masque </option>
          </select> 
          </td>
      </tr>
   </table>       
		   	   <table width="1200" border="1" cellspacing="2">
                      <tr>
                          <th scope="col">ID</th>
                          <th scope="col">Selection</th>
                          <th scope="col">Titre</th>
                          <th scope="col">Contenue</th>
						  <th scope="col">Type_news</th>	 
						  <th scope="col">Etat news</th>
					      <th scope="col">Date ajout</th>
                          
                     </tr>
	<?php
	
	//Definie la partie du forum demande 
	 if(isset($_GET['index_page']) )
		 { 
		  if($_GET['index_page']>=0) $index_page=(int) htmlspecialchars($_GET['index_page']);
		     else {echo('index de page non autorisée');$index_page=0;}
			 if(isset($_GET['type'])) $_POST['critere_type']= htmlspecialchars($_GET['type']);
			 if(isset($_GET['etat_news'])) $_POST['critere_etat_news']= htmlspecialchars($_GET['etat_news']);
			 if(isset($_GET['titre'])) $_POST['critere_titre']= htmlspecialchars($_GET['titre']);
		 }
		 else $index_page=0;
	//initialisation des drapeaux selon les cas
	
	 $flag=0;
	 if (isset($_POST['critere_type']) and !empty($_POST['critere_type'])) $flag=1;
	 if (isset($_POST['critere_etat_news']) and !empty($_POST['critere_etat_news'])) $flag=2;
	 if (isset($_POST['critere_type']) and !empty($_POST['critere_type']) and isset($_POST['critere_etat_news']) and !empty($_POST['critere_etat_news']))
	 $flag=3;
	 if (isset($_POST['critere_titre']) and !empty($_POST['critere_titre'])) $flag=4;
	 if (isset($_POST['critere_type']) and !empty($_POST['critere_type']) and isset($_POST['critere_titre']) and !empty($_POST['critere_titre'])) $flag=5;
	 if ( isset($_POST['critere_etat_news']) and !empty($_POST['critere_etat_news']) and  isset($_POST['critere_date_sup']) and !empty($_POST['critere_titre'])) $flag=6;
	 if (isset($_POST['critere_type']) and !empty($_POST['critere_type']) and isset($_POST['critere_etat_news']) and !empty($_POST['critere_etat_news']) and  isset($_POST['critere_titre']) and !empty($_POST['critere_titre'])) $flag=7;
	 
		//introduction dans la base de données selon les cas
	    switch($flag)
		{ 
		case 1:{
			    $_POST['critere_type']=htmlspecialchars($_POST['critere_type']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM news WHERE type_news=?');
				$req->execute(array($_POST['critere_type']));
		        $nbr_messages=$req->fetch();
				$req->closeCursor();
				$nbr_liens=$nbr_messages['nbr_message']/10;
				$_GET['type']=$_POST['critere_type'];
	            $rep = $bdd->prepare('SELECT * FROM news WHERE type_news=? ORDER BY id DESC LIMIT '.( $index_page*10).',10');
	            $rep->execute(array($_POST['critere_type']));
				
	           }break; 
		case 2:{
			    $_POST['critere_etat_news']=htmlspecialchars($_POST['critere_etat_news']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM news WHERE etat_news=?');
				$req->execute(array($_POST['critere_etat_news']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
				$nbr_liens=$nbr_messages['nbr_message']/10;
				$_GET['etat_news']=$_POST['critere_etat_news'];
	            $rep = $bdd->prepare('SELECT * FROM news WHERE etat_news=? ORDER BY id DESC LIMIT '.( $index_page*10).',10');
	            $rep->execute(array($_POST['critere_etat_news']));
				
	           }break; 
		case 3:{
			    $_POST['critere_type']=htmlspecialchars($_POST['critere_type']);
				$_POST['critere_etat_news']=htmlspecialchars($_POST['critere_etat_news']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM news WHERE type_news=? AND etat_news=?');
				$req->execute(array($_POST['critere_type'],$_POST['critere_etat_news']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
				$nbr_liens=$nbr_messages['nbr_message']/10;
				$_GET['type']=$_POST['critere_type'];
				$_GET['etat_news']=$_POST['critere_etat_news'];
	            $rep = $bdd->prepare('SELECT * FROM news WHERE type_news=? AND etat_news=? ORDER BY id DESC LIMIT '.( $index_page*10).',10');
	            $rep->execute(array($_POST['critere_type'],$_POST['critere_etat_news']));
				
	           }break; 
		case 4:{
			    $_POST['critere_titre']=htmlspecialchars($_POST['critere_titre']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM news WHERE titre REGEXP "'.$_POST['critere_titre'].'"');
				$req->execute(array($_POST['critere_titre']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
				$nbr_liens=$nbr_messages['nbr_message']/10;
				$_GET['titre']=$_POST['critere_titre'];
	            $rep = $bdd->prepare('SELECT * FROM news WHERE titre REGEXP "'.$_POST['critere_titre'].'" ORDER BY id DESC LIMIT '.( $index_page*10).',10');
	            $rep->execute(array($_POST['critere_titre']));
				
	           }break; 
		case 5:{
			    $_POST['critere_type']=htmlspecialchars($_POST['critere_type']);
				$_POST['critere_titre']=htmlspecialchars($_POST['critere_titre']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM news WHERE type_news=? AND titre REGEXP "'.$_POST['critere_titre'].'"');
				$req->execute(array($_POST['critere_type'],$_POST['critere_date']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
				$nbr_liens=$nbr_messages['nbr_message']/10;
				$_GET['type']=$_POST['critere_type'];
				$_GET['titre']=$_POST['critere_titre'];
	            $rep = $bdd->prepare('SELECT * FROM news WHERE type_news=? AND titre REGEXP "'.$_POST['critere_titre'].'" ORDER BY id DESC LIMIT '.( $index_page*10).',10');
	            $rep->execute(array($_POST['critere_type'],$_POST['critere_titre']));
				
	           }break; 
		case 6:{
			    $_POST['critere_etat_news']=htmlspecialchars($_POST['critere_etat_news']);
				$_POST['critere_titre']=htmlspecialchars($_POST['critere_titre']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM news WHERE etat_news=? AND titre=?');
				$req->execute(array($_POST['critere_etat_news'],$_POST['critere_titre']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
				$nbr_liens=$nbr_messages['nbr_message']/10;
				$_GET['etat_news']=$_POST['critere_etat_news'];
				$_GET['titre']=$_POST['critere_titre'];
	            $rep = $bdd->prepare('SELECT * FROM news WHERE etat_news=? AND titre REGEXP "'.$_POST['critere_titre'].'" ORDER BY id DESC LIMIT'.( $index_page*10).',10');
	            $rep->execute(array($_POST['critere_etat_news'],$_POST['critere_titre']));
				
	           }break; 	
		case 7:{
			    $_POST['critere_type']=htmlspecialchars($_POST['critere_type']);
				$_POST['critere_etat_news']=htmlspecialchars($_POST['critere_etat_news']);
				$_POST['critere_titre']=htmlspecialchars($_POST['critere_titre']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM news WHERE type_news=? AND etat_news=? AND titre=?');
				$req->execute(array($_POST['critere_type'],$_POST['critere_etat_news'],$_POST['critere_titre']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
	            $nbr_liens=$nbr_messages['nbr_message']/10;
				$_GET['type']=$_POST['critere_type'];
				$_GET['etat_news']=$_POST['critere_etat_news'];
				$_GET['titre']=$_POST['critere_titre'];
	            $rep = $bdd->prepare('SELECT * FROM news WHERE type_news=? AND etat_news=? AND titre REGEXP "'.$_POST['critere_titre'].'" ORDER BY id DESC LIMIT'.( $index_page*10).',10');
	            $rep->execute(array($_POST['critere_type'],$_POST['critere_etat_news'],$_POST['critere_titre']));
				
	           }break; 	      	   	   	   	   
	    default:
		        { $req=$bdd->query('SELECT COUNT(*) AS nbr_message FROM news');
		          $nbr_messages=$req->fetch();
		          $req->closeCursor();
	              $nbr_liens=$nbr_messages['nbr_message']/10;
	              $rep = $bdd->query('SELECT * FROM news ORDER BY id DESC LIMIT '.( $index_page*10).',10');
				  
	            }
		}
	 
	 
	 //Inclue un a un les engin sous forme de case a cocher 	   
	 while ($donnees = $rep->fetch())
        {
		 
         echo(' <tr>
		        <td>'.$donnees['id'].'</td>
		        <td><input type="checkbox" name="'.$donnees['id'].'" id="'.$donnees['id'] .'" /><label for="'.$donnees['id'].'"></label></td>
				<td>'.$donnees['titre'].'</td>
				<td>'.nl2br($donnees['contenu']).'</td>
				<td>'.$donnees['type_news'].'</td>
				<td>'.$donnees['etat_news'].'</td>
				<td>'.$donnees['date_ajout'].'</td>
				</tr>');
				
        }
		
	?>
	</table>
    <table width="1200" border="0" cellspacing="0">
      <tr>
     <?php
	   if(isset($_GET['type']) )$type=$_GET['type'];
	      else $type='';
	   if(isset($_GET['etat_news']) )$etat_news=$_GET['etat_news'];
	      else $etat_news='';
	   if(isset($_GET['titre']) )$titre=$_GET['titre'];
	      else $titre='';
	   $i=0;
    while($i<$nbr_liens)
	{ 
	   echo('<th scope="col"> <a href=gestion_news.php?index_page='.$i.'&amp;type='.$type.'&amp;etat_news='.$etat_news.'&amp;titre='.$titre.'>'.($i+1).'</a></th>');
	   $i++;
	}
	    ?>
        </tr>
    </table>
	<input type="radio" name="tache" value="supprimer" id="tache1"/><label for="tache1">Supprimer un engin </label>
	<input type="radio" name="tache" value="modifier" id="tache2"/><label for="tache2">Modifier un engin </label><br/>	 
 <table width="1200" border="1" cellspacing="2">
                      <tr>
						  <th scope="col">Type_news</th>
						  <th scope="col">Etat news</th>
                     </tr>   
    <tr>
    <td><select id="type_news_modif" name="type_news_modif" >
         <option value=""> ------- </option>
         <option value="annonce"> Annonce </option>
         <option value="message_admin"> Message admin </option>
         <option value="important"> <em>Important</em> </option>
 </select>
 </td>
 <td>
 <select name="etat_news" id="etat_news">
 <option value="">---------</option>
 <option value="afficher"> Afficher </option>
 <option value="masque"> Masque </option>
 </select></td>
 </tr>
 </table>
        <input type="submit" name="afficher_news" /> 
    	<a href="http://127.0.0.1/MTP_pro/Admin/gestion_news.php"> <input type="button" name="actualiser" value="Actualiser"/> </a>
	</fieldset> <br/>
	</form>	
    <form method="post" action="gestion_news.php" enctype="multipart/form-data">
<fieldset>
<legend><h1> AJOUTER UNE NEWS </h1></legend>
 <table width="1200" border="1" cellspacing="2">
                      <tr>
                          <th scope="col">Titre </th>
                          <th scope="col">Type</th>
                          <th scope="col">Contenue</th>
                          <th scope="col">Etat</th>
                          
                          
                     </tr>
<tr>
<td> <input type="text" name="titre" value="Confirmer" />
</td>
<td>
<select id="type_news" name="type_news" >
<option value="annonce"> Annonce </option>
         <option value="message_admin"> Message admin </option>
         <option value="important"> <em>Important</em> </option>
 </select></td>
<td><textarea name="contenue" id="contenue"></textarea></td>
<td><select name="etat_news_ajout" id="etat_news_ajout">
 <option value="afficher"> Afficher </option>
 <option value="masque"> Masque </option>
 </select></td>
</tr>
<tr ><td colspan="4"><input type="submit" name="ajout_news" value="Confirmer"/></td></tr>
</table>
</fieldset>
</form>

</section>
</center>
<footer></footer>
</body>
</html>
