<?php
session_start();
?>

<!DOCTYPE html>
<html><head>
<meta charset="utf-8"/>
<link rel="stylesheet" href="style.css"/>
<title>Gestion_engin</title>
</head>

<body>
<header></header>
<center>
<nav>
<?php include("interface_connexion.php"); ?>
<nav/>
<section>
<?php
// la fonctuon de redimensionnemet des images
include("fonction_image.php");
// connexion a la base de donnée
 include("connexion_bdd.php");
//Renvoie dans "$idmax" le plus grand'id'
$compteur_id = fopen('compteur_id_engin.txt','r+');
$id_max = fgets($compteur_id);
fclose($compteur_id);
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
       $req = $bdd->query('SELECT COUNT(*) AS nbr_engin FROM engin');
       $nbr_engin = $req->fetch();
       echo('Nombre d\'engin est'.$nbr_engin['nbr_engin'].'<br/>');
       $cpt=1;
       $nbr_objet_sup=0;
       //Recherche les engins cocher et les supprime et affiche le nombre qui a ete supprimé 
       while ($cpt <= $id_max )
        { 
          if ( isset($_POST[$cpt])) 
           { 
	         $rep = $bdd->prepare('DELETE FROM engin WHERE id =?');
	         $rep->execute(array($cpt));
			 $rep->closeCursor();
	         $nbr_objet_sup=$nbr_objet_sup+1;
	       }
       $cpt=$cpt+1;  
        }
       echo('action effectue ,nombre d\' engin affecté :'.$nbr_objet_sup.'<br/>');
    }

  if ($_POST['tache']=='modifier')
  {
	    // Renvoie dans "$req" le nonbre d'entrés dans la table "engin" et l'affiche
       $req = $bdd->query('SELECT COUNT(*) AS nbr_engin FROM engin');
       $nbr_engin = $req->fetch();
       echo('Nombre d\'engin est'.$nbr_engin['nbr_engin'].'<br/>');
       $cpt=1;
       $nbr_objet_sup=0;
	   $_POST['modif_fiche_technique']=htmlspecialchars($_POST['modif_fiche_technique']);
	   $_POST['etat_engin']=htmlspecialchars($_POST['etat_engin']);
	   $_POST['type_engin_modif']=htmlspecialchars($_POST['type_engin_modif']);
       //Recherche les engins cocher et les supprime et affiche le nombre qui a ete supprimé
	   $flag=0;
	   if(!empty($_POST['modif_fiche_technique'])  )  $flag=1;
	   if(!empty($_POST['etat_engin'])  )  $flag=2;
	   if(!empty($_POST['etat_engin']) and !empty( $_POST['modif_fiche_technique'])  )  $flag=3;
	   if(!empty($_POST['type_engin_modif'])  )  $flag=4;
	   if(!empty($_POST['type_engin_modif']) and !empty( $_POST['modif_fiche_technique'])  )  $flag=5;
	   if(!empty($_POST['type_engin_modif']) and !empty( $_POST['etat_engin'])  )  $flag=6;
		if(!empty($_POST['type_engin_modif']) and !empty( $_POST['etat_engin']) and !empty($_POST['modif_fiche_technique']) )  $flag=7;
	   
       while ($cpt <= $id_max )
        { 
          if ( isset($_POST[$cpt])) 
           { switch ($flag)
		  { 
		   case 1:{$rep = $bdd->prepare('UPDATE engin SET fiche_techniquet=:fiche_technique  WHERE id =:id_a_modif');
	         $rep->execute(array('fiche_technique'=>$_POST['modif_fiche_technique'],
								 'id_a_modif'=>$cpt));}break;
								 
		   case 2:{$rep = $bdd->prepare('UPDATE engin SET etat_engin=:etat_engin  WHERE id =:id_a_modif');
	         $rep->execute(array('etat_engin'=>$_POST['etat_engin'],
								 'id_a_modif'=>$cpt));}break;
		  
		   case 3:{$rep = $bdd->prepare('UPDATE engin SET etat_engin=:etat_engin,fiche_technique=:fiche_technique  WHERE id =:id_a_modif');
	         $rep->execute(array('etat_engin'=>$_POST['etat_engin'],
								 'date_ajout'=>$_POST['modif_fiche_technique'],
								 'id_a_modif'=>$cpt));}break;
		  
		   case 4:{$rep = $bdd->prepare('UPDATE engin SET type_engin=:type_engin  WHERE id =:id_a_modif');
	         $rep->execute(array('type_engin'=>$_POST['type_engin_modif'],
								 'id_a_modif'=>$cpt));}break;
		  
		   case 5:{$rep = $bdd->prepare('UPDATE engin SET type_engin=:type_engin,fiche_technique=:fiche_technique  WHERE id =:id_a_modif');
	         $rep->execute(array('type_engin'=>$_POST['type_engin_modif'],
								 'fiche_technique'=>$_POST['modif_fiche_technique'],
								 'id_a_modif'=>$cpt));}break;
		  
		   case 6:{$rep = $bdd->prepare('UPDATE engin SET type_engin=:type_engin,etat_engin=:etat_engin  WHERE id =:id_a_modif');
	         $rep->execute(array('type_engin'=>$_POST['type_engin_modif'],
			                     'etat_engin'=>$_POST['etat_engin'],
								 'id_a_modif'=>$cpt));}break;
		  
		   case 7:{$rep = $bdd->prepare('UPDATE engin SET type_engin=:type_engin,etat_engin=:etat_engin,fiche_technique=:fiche_technique  WHERE id =:id_a_modif');
	         $rep->execute(array('type_engin'=>$_POST['type_engin_modif'],
			                     'etat_engin'=>$_POST['etat_engin'],
								 'fiche_technique'=>$_POST['modif_fiche_technique'],
								 'id_a_modif'=>$cpt));}break;
	        default:;break;
		  }
		  $nbr_objet_sup++;
	       }
       $cpt=$cpt+1;  
        }
       echo('action effectue ,nombre d\' engin affecté :'.$nbr_objet_sup.'<br/>');
    }
	}
  
     
/*
----------------------------------------------------------------------------------------------------------------------------------------
fin de traitement du premier formulaire
----------------------------------------------------------------------------------------------------------------------------------------
*/ 
 //Renvoie dans "$req" les entrés de la table "engin" et recherche
 $req = $bdd->query('SELECT * FROM engin ');
 $resultat = $req->fetch();
 //test l'existance d'entrées
 if (!$resultat)
  {
   echo '<script type="text/javascript">alert("Pas d\' engins dans la base de donnée")</script> !';
  }
  $req->closeCursor();
	 //Affichage du formulaire "AFFICHAGE DES ENGINS"
	?>
	
	<form method="post" action="gestion_engin.php">
	       <fieldset>
		   <legend><h1> AFFICHAGE DES ENGINS </h1></legend>
            
	
            <table width="1200" border="1" cellspacing="2">
      <tr>
        <th scope="col">Marque</th>
        <th scope="col">Type_engin</th>
        <th scope="col">Etat_engin</th>
      </tr>
     <tr> <td> <input typ="text" name="critere_marque"  id="critere_marque" /> </td>
          <td>
<select id="critere_type_engin" name="critere_type_engin" >
<option value="">--------</option>
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
 </select>
 </td>
 <td>
 <select name="critere_etat_engin" id="critere_etat_engin">
 <option value=""> -------- </option>
 <option value="afficher"> Afficher </option>
 <option value="masque"> Masque </option>
 <option value="indesirable"> Indesirable </option>
 </select>
      </tr>
   </table> 
   <?php
	 
// Controle si le formulaire "AJOUTER UN ENGIN" a etait envoyé
if (isset($_POST['ajout_engin']))
{
  // Testons si le fichier a bien été envoyé et s'il n'y a pas d'erreur
  if (isset($_FILES['adresse_image']) and ($_FILES['adresse_image']['error']== 0))
   {
    // Testons si le fichier n'est pas trop gros
     if ($_FILES['adresse_image']['size'] <= 1000000)
      {
       // Testons si l'extension est autorisée
       $infosfichier =pathinfo($_FILES['adresse_image']['name']);
       $extension_upload = $infosfichier['extension'];
       $extensions_autorisees = array('jpg', 'jpeg', 'gif','png');
       if (in_array($extension_upload,$extensions_autorisees))
        {
		  $adresse_image ='../Modele/'.($id_max+1) .'_'.basename($_FILES['adresse_image']['name']);
		  // On peut valider le fichier et le stocker définitivement
          move_uploaded_file($_FILES['adresse_image']['tmp_name'], '../Modele/'.($id_max+1) .'_'.basename($_FILES['adresse_image']['name']));
		  //Rend inoffencive un eventuelle code html contenue dans les variable du formulair 
		    
          $_POST['type_engin'] =htmlspecialchars($_POST['type_engin']);
		  $_POST['marque_engin'] =htmlspecialchars($_POST['marque_engin']);
		  $_POST['num_serie'] =htmlspecialchars($_POST['num_serie']);
          $_POST['fiche_technique'] =htmlspecialchars($_POST['fiche_technique']); 
		  $adresse_image=htmlspecialchars('../Modele/'.($id_max+1) .'_'.basename($_FILES['adresse_image']['name']));
		  $image=$_FILES['adresse_image'];
          //Insertion d'un engin dans la base de donnee 	
          $req=$bdd->prepare('INSERT INTO engin(marque_engin,num_serie,fiche_technique,adresse_image,type_engin,etat_engin,date_ajout)            
		                                 VALUES(:marque_engin,:num_serie,:fiche_technique,:adresse_image,:type_engin,"afficher",CURDATE())');
          $req->execute(array('marque_engin'=>$_POST['marque_engin'],
		                      'num_serie'=>$_POST['num_serie'],
                              'fiche_technique'=>$_POST['fiche_technique'], 
					          'adresse_image'=>$adresse_image,
							  'type_engin'=>$_POST['type_engin']
					          ));
	      $compteur_id = fopen('compteur_id_engin.txt','r+');
		  fseek($compteur_id,0);
          fputs($compteur_id,($id_max+1));
          fclose($compteur_id);				  					 
          
		  echo "L'envoi a bien été effectué !"; 
          	
         
		
        }else{('Format du fichier non conforme(extension autorise:.jpg,.jpeg,.gif,.png)');}
	  }else{ echo('Fichier trop volumineux(>1MO)');}
   }else 
   {
     switch($_FILES['adresse_image']['error'])
     {
	  case '1' : echo (' Le fichier téléchargé excède la taille de upload_max_filesize, configurée dans le php.ini.');break;
      case '2': echo(' Le fichier téléchargé excède la taille de MAX_FILE_SIZE, qui a été spécifiée dans le formulaire HTML. ');break;
      case '3': echo(' Le fichier n\'a été que partiellement téléchargé');break;
	  case '4': echo(' Aucun fichier n\'a été téléchargé.');break;
      case '6': echo(' Un dossier temporaire est manquant. ');break;
	  case '7': echo(' Échec de l\'écriture du fichier sur le disque.');break;
	  case '8': echo(' Une extension PHP a arrêté l\'envoi de fichier. ');break;
	  default:echo('ERREUR lors du telechaargement du Fichier');break;
	 }
    } 
}

?>      
		   <table width="1200" border="1" cellspacing="2">
                      <tr>
                          <th scope="col">ID</th>
                          <th scope="col">Selection</th>
                          <th scope="col">Illustration</th>
						  <th scope="col">Type_engin</th>
                          <th scope="col">Marque_engin</th>
                          <th scope="col">Num_serie</th>	 
                          <th scope="col">Fiche_technique</th>
						  <th scope="col">Adresse image</th>
						  <th scope="col">Etat engin</th>
					      <th scope="col">Date ajout</th>
                          
                     </tr>

	<?php 
	//Definie la partie du forum demande 
	 if(isset($_GET['index_page']) )
		 { 
		  if($_GET['index_page']>=0) $index_page=(int) htmlspecialchars($_GET['index_page']);
		     else{echo('index de page non autorisée');$index_page=0;}
			 if(isset($_GET['marque'])) $_POST['critere_marque']= htmlspecialchars($_GET['marque']);
			 if(isset($_GET['type_engin'])) $_POST['critere_type_engin']= htmlspecialchars($_GET['type_engin']);
			 if(isset($_GET['etat_engin'])) $_POST['critere_etat_engin']= htmlspecialchars($_GET['etat_engin']);
		 }
		 else $index_page=0;
	 $flag=0;
	 if (isset($_POST['critere_marque']) and !empty($_POST['critere_marque'])) $flag=1;
	 if (isset($_POST['critere_type_engin']) and !empty($_POST['critere_type_engin'])) $flag=2;
	 if (isset($_POST['critere_marque']) and !empty($_POST['critere_marque']) and isset($_POST['critere_type_engin']) and !empty($_POST['critere_type_engin']))
	 $flag=3;
	 if (isset($_POST['critere_etat_engin']) and !empty($_POST['critere_etat_engin'])) $flag=4;
	 if (isset($_POST['critere_marque']) and !empty($_POST['critere_marque']) and isset($_POST['critere_etat_engin']) and !empty($_POST['critere_etat_engin'])) $flag=5;
	 if ( isset($_POST['critere_type_engin']) and !empty($_POST['critere_type_engin']) and  isset($_POST['critere_etat_engin']) and !empty($_POST['critere_etat_engin'])) $flag=6;
	 if (isset($_POST['critere_marque']) and !empty($_POST['critere_marque']) and isset($_POST['critere_type_engin']) and !empty($_POST['critere_type_engin']) and  isset($_POST['critere_etat_engin']) and !empty($_POST['critere_etat_engin'])) $flag=7;
	 
	 switch($flag)
		{ 
		case 1:{
			    $_POST['critere_marque']=htmlspecialchars($_POST['critere_marque']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM engin WHERE marque_engin=?');
				$req->execute(array($_POST['critere_marque']));
		        $nbr_messages=$req->fetch();
				$nbr_liens=$nbr_messages['nbr_message']/10;
				$_GET['marque']=$_POST['critere_marque'];
	            $rep = $bdd->prepare('SELECT * FROM engin WHERE marque_engin=? ORDER BY id DESC LIMIT '.( $index_page*10).',10');
	            $rep->execute(array($_POST['critere_marque']));
	           }break; 
		case 2:{
			    $_POST['critere_type_engin']=htmlspecialchars($_POST['critere_type_engin']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM engin WHERE type_engin=?');
				$req->execute(array($_POST['critere_type_engin']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
				$nbr_liens=$nbr_messages['nbr_message']/10;
				$_GET['type_engin']=$_POST['critere_type_engin'];
	            $rep = $bdd->prepare('SELECT * FROM engin WHERE type_engin=? ORDER BY id DESC LIMIT '.( $index_page*10).',10');
	            $rep->execute(array($_POST['critere_type_engin']));
	           }break; 
		case 3:{
			    $_POST['critere_marque']=htmlspecialchars($_POST['critere_marque']);
				$_POST['critere_type_engin']=htmlspecialchars($_POST['critere_type_engin']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM engin WHERE marque_engin=? AND type_engin=?');
				$req->execute(array($_POST['critere_marque'],$_POST['critere_type_engin']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
				$nbr_liens=$nbr_messages['nbr_message']/10;
				$_GET['marque']=$_POST['critere_marque'];
				$_GET['type_engin']=$_POST['critere_type_engin'];
	            $rep = $bdd->prepare('SELECT * FROM engin WHERE marque_engin=? AND type_engin=? ORDER BY id DESC LIMIT '.( $index_page*10).',10');
	            $rep->execute(array($_POST['critere_marque'],$_POST['critere_type_engin']));
	           }break; 
		case 4:{
			    $_POST['critere_etat_engin']=htmlspecialchars($_POST['critere_etat_engin']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM engin WHERE etat_engin=?');
				$req->execute(array($_POST['critere_etat_engin']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
				$nbr_liens=$nbr_messages['nbr_message']/10;
				$_GET['etat_engin']=$_POST['critere_date_sup'];
	            $rep = $bdd->prepare('SELECT * FROM engin WHERE etat_engin=? ORDER BY id DESC LIMIT '.( $index_page*10).',10');
	            $rep->execute(array($_POST['critere_etat_engin']));
	           }break; 
		case 5:{
			    $_POST['critere_marque']=htmlspecialchars($_POST['critere_marque']);
				$_POST['critere_etat_engin']=htmlspecialchars($_POST['critere_etat_engin']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM engin WHERE marque_engin=? AND etat_engin=?');
				$req->execute(array($_POST['critere_marque'],$_POST['critere_etat_engin']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
				$nbr_liens=$nbr_messages['nbr_message']/10;
				$_GET['marque']=$_POST['critere_marque'];
				$_GET['etat_engin']=$_POST['critere_etat_engin'];
	            $rep = $bdd->prepare('SELECT * FROM engin WHERE marque_engin=? AND etat_engin=? ORDER BY id DESC LIMIT '.( $index_page*10).',10');
	            $rep->execute(array($_POST['critere_marque'],$_POST['critere_etat_engin']));
	           }break; 
		case 6:{
				$_POST['critere_type_engin']=htmlspecialchars($_POST['critere_type_engin']);
				$_POST['critere_etat_engin']=htmlspecialchars($_POST['critere_etat_engin']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM engin WHERE type_engin=? AND etat_engin=?');
				$req->execute(array($_POST['critere_type_engin'],$_POST['critere_etat_engin']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
				$nbr_liens=$nbr_messages['nbr_message']/10;
				$_GET['type_engin']=$_POST['critere_type_engin'];
				$_GET['etat_engin']=$_POST['critere_etat_engin'];
	            $rep = $bdd->prepare('SELECT * FROM engin WHERE type_engin=? AND etat_engin=? ORDER BY id DESC LIMIT'.( $index_page*10).',10');
	            $rep->execute(array($_POST['critere_type_engin'],$_POST['critere_etat_engin']));
	           }break; 	
		case 7:{
			    $_POST['critere_marque']=htmlspecialchars($_POST['critere_marque']);
				$_POST['critere_type_engin']=htmlspecialchars($_POST['critere_type_engin']);
				$_POST['critere_etat_engin']=htmlspecialchars($_POST['critere_etat_engin']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM engin WHERE marque_engin=? AND type_engin=? AND etat_engin=?');
				$req->execute(array($_POST['critere_marque'],$_POST['critere_type_engin'],$_POST['critere_etat_engin']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
	            $nbr_liens=$nbr_messages['nbr_message']/10;
				$_GET['marque']=$_POST['critere_marque'];
				$_GET['type_engin']=$_POST['critere_type_engin'];
				$_GET['etat_engin']=$_POST['critere_etat_engin'];
	            $rep = $bdd->prepare('SELECT * FROM engin WHERE marque_engin=? AND type_engin=? AND etat_engin=? ORDER BY id DESC LIMIT'.( $index_page*10).',10');
	            $rep->execute(array($_POST['critere_marque'],$_POST['critere_type_engin'],$_POST['critere_etat_engin']));
	           }break; 	      	   	   	   	   
	    default:
		        { $req=$bdd->query('SELECT COUNT(*) AS nbr_message FROM engin');
		          $nbr_messages=$req->fetch();
		          $req->closeCursor();
	              $nbr_liens=$nbr_messages['nbr_message']/10;
	              $rep = $bdd->query('SELECT * FROM engin ORDER BY id DESC LIMIT '.( $index_page*10).',10');
				  
	            }
		}
		   	  
	 
	 
	 //Inclue un a un les engin sous forme de case a cocher 	   
	 while ($donnees = $rep->fetch())
        {
		 $info='id:'.$donnees['id'].' type:'.$donnees['type_engin'].'<br/>'.nl2br($donnees['fiche_technique']).'<br/>'.$donnees['adresse_image'].'<br/>';
	     $img=image($donnees['adresse_image'],'129','129','0','0');
		 
         echo(' <tr>
		        <td>'.$donnees['id'].'</td>
		        <td><input type="checkbox" name="'.$donnees['id'].'" id="'.$donnees['id'] .'" /><label for="'.$donnees['id'].'"></label></td>
				<td>'.$img.'</td>
				<td>'.$donnees['type_engin'].'</td> 
				<td>'.$donnees['marque_engin'].'</td> 
				<td>'.$donnees['num_serie'].'</td> 
				<td>'.nl2br($donnees['fiche_technique']).'</td>
				<td>'.$donnees['adresse_image'].'</td>
				<td>'.$donnees['etat_engin'].'</td>
				<td>'.$donnees['date_ajout'].'</td>
				</tr>');
        }
		
	?>
	</table>
    <table width="1200" border="0" cellspacing="0">
      <tr>
       <?php
	   if(isset($_GET['pseudo']) )$pseudo=$_GET['pseudo'];
	      else $pseudo='';
	   if(isset($_GET['type_engin']) )$type_engin=$_GET['type_engin'];
	      else $type_engin='';
	   if(isset($_GET['etat_engin']) )$etat_engin=$_GET['etat_engin'];
	      else $etat_engin='';
	   $i=0;
    while($i<$nbr_liens)
	{ 
	   echo('<th scope="col"> <a href=gestion_engin.php?index_page='.$i.'&amp;pseudo='.$pseudo.'&amp;type_engin='.$type_engin.'&amp;etat_engin='.$etat_engin.'>'.($i+1).'</a></th>');
	   $i++;
	}
	    ?>
	</tr>
    </table>
	<input type="radio" name="tache" value="supprimer" id="tache1"/><label for="tache1">Supprimer un engin </label>
	<input type="radio" name="tache" value="modifier" id="tache2"/><label for="tache2">Modifier un engin </label><br/>	
	
 <table width="1200" border="1" cellspacing="2">
                      <tr>
						  <th scope="col">Type_engin</th>
						  <th scope="col">Etat engin</th>
					      <th scope="col">Fiche technique</th>            
                     </tr>   
    <tr>
    <td><select id="type_engin_modif" name="type_engin_modif" >
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
 </select>
 </td>
 <td>
 <select name="etat_engin" id="etat_engin">
 <option value="afficher"> -------- </option>
 <option value="afficher"> Afficher </option>
 <option value="masque"> Masque </option>
 <option value="indesirable"> Indesirable </option>
 </select></td>
 <td> <textarea name="modif_fiche_technique" id="modif_fiche_technique"></textarea></td>
 </tr>
 </table>
        <input type="submit" name="afficher_engin" value="Confirmer" /> 
    	<a href="http://127.0.0.1/MTP_pro/Admin/gestion_engin.php"> <input type="button" name="actualiser" value="Actualiser"/></a>
	</fieldset> <br/>
	</form>	


<form method="post" action="gestion_engin.php" enctype="multipart/form-data">
<fieldset>
<legend><h1> AJOUTER UN ENGIN </h1></legend>
 <table width="1200" border="1" cellspacing="2">
                      <tr>
                          <th scope="col">Type</th>
                          <th scope="col">Marque</th>	 
                          <th scope="col">Numero_Serie</th>
                          <th scope="col">Fiche technique</th>
                          <th scope="col">Adresse de l'image </th>
                          
                     </tr>
<tr>
<td>
<select id="type_engin" name="type_engin" >
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
 </select></td>
 <td><input type="text" name="marque_engin" id="marque_engin"/></td>
 <td><input type="text" name="num_serie" id="num_serie"/></td>
<td><textarea name="fiche_technique" id="fiche_technique"></textarea></td>
<td><input type="file" name="adresse_image" id="adresse_image"/></td>
</tr>
<tr ><td colspan="5"><input type="submit" name="ajout_engin" value="Confirmer" /></td></tr>
</table>
</fieldset>
</form>

</section>
</center>
<footer>
</footer>
</body>
</html>
