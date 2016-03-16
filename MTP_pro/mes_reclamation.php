<?php
include("Controle/initialisation_session.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<link rel="stylesheet" href="style.css"/>
<title> Mes Reclamations </title>
</head>
<body>
<div id="corp_page">
<header></header>
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
<form method="post" action="mes_reclamation.php" >
<fieldset>
<legend>Gerer vos reclamations </legend>
<table width="600" border="0" class="tableau">
  <tr>
    <th scope="col">Type</th>
    <th scope="col">Marque</th>
    <th scope="col">Etat</th>
  </tr>
  <tr>
    <td><select id="critere_type_engin" name="critere_type_engin" >
<option value="">----------</option>
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
 <td> <input type="text" name="critere_marque_engin" id="critere_marque_engin" /> </td>
 <td> 
 <select name="critere_etat_reclamation" id="critere_etat_reclamation">
      <option value="">--------</option>
      <option value="afficher"> Afficher </option>
      <option value="confirmer"> Confirmer </option>
      <option value="confirmer_admin"> Confirmer admin </option>
      <option value="annuler"> Annuler </option>
 </select>  </td>
  </tr>
</table>


    <table width="600" border="0" class="tableau">
  <tr>
    <th scope="col">°</th>
    <th scope="col">NRS</th>
    <th scope="col">Type</th>
    <th scope="col">Num tel</th>
    <th scope="col">Marque</th>
    <th scope="col">Num serie</th>
    <th scope="col">Matricule</th>
    <th scope="col">Commentaire</th>
    <th scope="col">Etat</th>
  </tr>




<?php
$id_max=0; 
//Renvoie dans "$rep" les entr�s de la table "engin" et recherche le plus grand'id'
$rep = $bdd->query('SELECT COUNT(*) AS nbr_message FROM reclamation ');
$donnees=$rep->fetch();
$id_max=$donnees['nbr_message'];

$cpt=0;
if (isset($_POST['tache']) and $_POST['tache']=='modifier')
{		
     while ($cpt <= $id_max )
        { 
         if ( isset($_POST[$cpt])) 
          { 
		   $_POST['etat_reclamation']=htmlspecialchars($_POST['etat_reclamation']);
		   $rep = $bdd->prepare('UPDATE reclamation SET etat_reclamation=:etat_reclamation  WHERE id =:id_a_modif AND etat_reclamation="afficher" ');
	       $rep->execute(array('etat_reclamation'=>$_POST['etat_reclamation'],
								 'id_a_modif'=>$cpt));
	       $rep->closeCursor();
		  }
         $cpt++;
        }
}
//Definie la partie du forum demande 
	 if(isset($_GET['index_page']) )
		 { 
		  if($_GET['index_page']>=0) $index_page=(int) htmlspecialchars($_GET['index_page']);
		     else {echo('index de page non autorisée');$index_page=0;}
			 if(isset($_GET['type_engin'])) $_POST['critere_type_engin']= htmlspecialchars($_GET['type_engin']);
			 if(isset($_GET['marque_engin'])) $_POST['critere_marque_engin']= htmlspecialchars($_GET['marque_engin']);
			 if(isset($_GET['etat_reclamation'])) $_POST['critere_etat_reclamation']= htmlspecialchars($_GET['etat_reclamation']);
		 }
		 else $index_page=0;
	//initialisation des drapeaux selon les cas
	
	 $flag=0;
	 if (isset($_POST['critere_type_engin']) and !empty($_POST['critere_type_engin'])) $flag=1;
	 if (isset($_POST['critere_marque_engin']) and !empty($_POST['critere_marque_engin'])) $flag=2;
	 if (isset($_POST['critere_type_engin']) and !empty($_POST['critere_type_engin']) and isset($_POST['critere_marque_engin']) and !empty($_POST['critere_marque_engin']))
	 $flag=3;
	 if (isset($_POST['critere_etat_reclamation']) and !empty($_POST['critere_etat_reclamation'])) $flag=4;
	 if (isset($_POST['critere_type_engin']) and !empty($_POST['critere_type_engin']) and isset($_POST['critere_etat_reclamation']) and !empty($_POST['critere_etat_reclamation'])) $flag=5;
	 if ( isset($_POST['critere_marque_engin']) and !empty($_POST['critere_marque_engin']) and  isset($_POST['critere_etat_reclamation']) and !empty($_POST['critere_etat_reclamation'])) $flag=6;
	 if (isset($_POST['critere_type_engin']) and !empty($_POST['critere_type_engin']) and isset($_POST['critere_marque_engin']) and !empty($_POST['critere_marque_engin']) and  isset($_POST['critere_etat_reclamation']) and !empty($_POST['critere_etat_reclamation'])) $flag=7;
	 
		//introduction dans la base de données selon les cas
	    switch($flag)
		{ 
		case 1:{
			    $_POST['critere_type_engin']=htmlspecialchars($_POST['critere_type_engin']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM reclamation WHERE type_engin=?');
				$req->execute(array($_POST['critere_type_engin']));
		        $nbr_messages=$req->fetch();
				$req->closeCursor();
				$nbr_liens=$nbr_messages['nbr_message']/10;
				$_GET['type_engin']=$_POST['critere_type_engin'];
	            $rep = $bdd->prepare('SELECT * FROM reclamation WHERE type_engin=? ORDER BY id DESC LIMIT '.( $index_page*10).',10');
	            $rep->execute(array($_POST['critere_type_engin']));
				
	           }break; 
		case 2:{
			    $_POST['critere_marque_engin']=htmlspecialchars($_POST['critere_marque_engin']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM reclamation WHERE marque_engin=?');
				$req->execute(array($_POST['critere_marque_engin']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
				$nbr_liens=$nbr_messages['nbr_message']/10;
				$_GET['marque_engin']=$_POST['critere_marque_engin'];
	            $rep = $bdd->prepare('SELECT * FROM reclamation WHERE marque_engin=? ORDER BY id DESC LIMIT '.( $index_page*10).',10');
	            $rep->execute(array($_POST['critere_marque_engin']));
				
	           }break; 
		case 3:{
			    $_POST['critere_type_engin']=htmlspecialchars($_POST['critere_type_engin']);
				 $_POST['critere_marque_engin']=htmlspecialchars($_POST['critere_marque_engin']);
				 $req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM reclamation WHERE type_engin=? AND marque_engin=?');
				$req->execute(array($_POST['critere_type_engin'],$_POST['critere_marque_engin']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
				$nbr_liens=$nbr_messages['nbr_message']/10;
				$_GET['type_engin']=$_POST['critere_type_engin'];
				$_GET['marque_engin']=$_POST['critere_marque_engin'];
	            $rep = $bdd->prepare('SELECT * FROM reclamation WHERE type_engin=? AND marque_engin=? ORDER BY id DESC LIMIT '.( $index_page*10).',10');
	            $rep->execute(array($_POST['critere_type_engin'],$_POST['critere_marque_engin']));
				
	           }break; 
		case 4:{
			    $_POST['critere_etat_reclamation']=htmlspecialchars($_POST['critere_etat_reclamation']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM reclamation WHERE etat_reclamation=?');
				$req->execute(array($_POST['critere_etat_reclamation']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
				$nbr_liens=$nbr_messages['nbr_message']/10;
				$_GET['etat_reclamation']=$_POST['critere_etat_reclamation'];
	            $rep = $bdd->prepare('SELECT * FROM reclamation WHERE etat_reclamation=? ORDER BY id DESC LIMIT '.( $index_page*10).',10');
	            $rep->execute(array($_POST['critere_etat_reclamation']));
				
	           }break; 
		case 5:{
			    $_POST['critere_type_engin']=htmlspecialchars($_POST['critere_type_engin']);
				$_POST['critere_etat_reclamation']=htmlspecialchars($_POST['critere_etat_reclamation']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM reclamation WHERE type_engin=? AND etat_reclamation=?');
				$req->execute(array($_POST['critere_type_engin'],$_POST['critere_etat_reclamation']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
				$nbr_liens=$nbr_messages['nbr_message']/10;
				$_GET['type_engin']=$_POST['critere_type_engin'];
				$_GET['etat_reclamation']=$_POST['critere_etat_reclamation'];
	            $rep = $bdd->prepare('SELECT * FROM reclamation WHERE type_engin=? AND etat_reclamation=? ORDER BY id DESC LIMIT '.( $index_page*10).',10');
	            $rep->execute(array($_POST['critere_type_engin'],$_POST['critere_etat_reclamation']));
				
	           }break; 
		case 6:{
			    $_POST['critere_marque_engin']=htmlspecialchars($_POST['critere_marque_engin']);
				$_POST['critere_etat_reclamation']=htmlspecialchars($_POST['critere_etat_reclamation']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM reclamation WHERE marque_engin=? AND etat_reclamation=?');
				$req->execute(array($_POST['critere_marque_engin'],$_POST['critere_etat_reclamation']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
				$nbr_liens=$nbr_messages['nbr_message']/10;
				$_GET['marque_engin']=$_POST['critere_marque_engin'];
				$_GET['etat_reclamation']=$_POST['critere_etat_reclamation'];
	            $rep = $bdd->prepare('SELECT * FROM reclamation WHERE marque_engin=? AND etat_reclamation=? ORDER BY id DESC LIMIT'.( $index_page*10).',10');
	            $rep->execute(array($_POST['critere_marque_engin'],$_POST['critere_etat_reclamation']));
				
	           }break; 	
		case 7:{
			    $_POST['critere_type_engin']=htmlspecialchars($_POST['critere_type_engin']);
				$_POST['critere_marque_engin']=htmlspecialchars($_POST['critere_marque_engin']);
				$_POST['critere_etat_reclamation']=htmlspecialchars($_POST['critere_etat_reclamation']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM reclamation WHERE type_engin=? AND marque_engin=? AND etat_reclamation=?');
				$req->execute(array($_POST['critere_type_engin'],$_POST['critere_marque_engin'],$_POST['critere_etat_reclamation']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
	            $nbr_liens=$nbr_messages['nbr_message']/10;
				$_GET['type_engin']=$_POST['critere_type_engin'];
				$_GET['marque_engin']=$_POST['critere_marque_engin'];
				$_GET['etat_reclamation']=$_POST['critere_etat_reclamation'];
	            $rep = $bdd->prepare('SELECT * FROM reclamation WHERE type_engin=? AND marque_engin=? AND etat_reclamation=? ORDER BY id DESC LIMIT'.( $index_page*10).',10');
	            $rep->execute(array($_POST['critere_type_engin'],$_POST['critere_date'],$_POST['critere_etat_reclamation']));
				
	           }break; 	      	   	   	   	   
	    default:
		        { $req=$bdd->query('SELECT COUNT(*) AS nbr_message FROM reclamation');
		          $nbr_messages=$req->fetch();
		          $req->closeCursor();
	              $nbr_liens=$nbr_messages['nbr_message']/10;
	              $rep = $bdd->query('SELECT * FROM reclamation ORDER BY id DESC LIMIT '.( $index_page*10).',10');
				  
	            }
		}

	
	 //Inclue un a un les engin sous forme de case a cocher 
	 	   
	 while ($donnees = $rep->fetch())
        {
         echo(' <tr>
		        <td><input type="checkbox" name="'.$donnees['id'].'" id="'.$donnees['id'] .'" /><label for="'.$donnees['id'].'"></label></td>
				<td>'.$donnees['nrs'].'</td>
				<td>'.$donnees['type_engin'].'</td>
				<td>'.$donnees['num_tel'].'</td>
				<td>'.$donnees['marque_engin'].'</td>
				<td>'.$donnees['num_serie'].'</td>
				<td>'.$donnees['matricule_engin'].'</td>
				<td>'.$donnees['commentaire'].'</td>
				<td>'.$donnees['etat_reclamation'].'</td>
				</tr>');
		
        }
		$rep->closeCursor();
		?>
     </table>
     
   
    <table width="600" border="0" cellspacing="0">
      <tr>
       <?php
	   if(isset($_GET['type_engin']) )$type_engin=$_GET['type_engin'];
	      else $type_engin='';
	   if(isset($_GET['marque_engin']) )$marque_engin=$_GET['marque_engin'];
	      else $marque_engin='';
	   if(isset($_GET['etat_reclamation']) )$etat_reclamation=$_GET['etat_reclamation'];
	      else $etat_reclamation='';
	   $i=0;
    while($i<$nbr_liens)
	{ 
	   echo('<th scope="col"> <a href=mes_reclamation.php?index_page='.$i.'&amp;type_engin='.$type_engin.'&amp;marque_engin='.$marque_engin.'&amp;etat_reclamation='.$etat_reclamation.'>'.($i+1).'</a></th>');
	   $i++;
	}
	?>
	</tr>
	</table>
    	<input type="radio" name="tache" value="modifier" id="tache"/><label for="tache">Modifier une commande </label><br/>
        <select name="etat_reclamation" id="etat_reclamation">
 <option value="afficher"> -------- </option>
 <option value="confirmer"> Confirmer </option>
 <option value="annuler"> Annuler </option>
 </select><br/>	
	</br><center><input type="submit" name="afficher_reclamation" value="Confirmer" class="bouton"/> </center></br>
	<center><a href="http://127.0.0.1/MTP_pro/mes_reclamation.php"> <input type="button" name="actualiser" value="Actualiser" class="bouton"/></a></center>
	 <br/>
     </fieldset>
	</form>	

    <?php
		

?>
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

