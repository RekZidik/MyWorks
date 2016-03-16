<?php
include("Controle/initialisation_session.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<link rel="stylesheet" href="style.css"/>
<title>Location de materiel</title>
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

<form method="post" action="location_de_materiel.php">
<fieldset>
<legend> AFFICHAGE DES ENGINS</legend>
<fieldset>
 <legend>Critére de recherche </legend>
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
 <td> <input type="text" name="critere_etat_engin" id="critere_etat_engin" /> </td>
  </tr>
</table>
</fieldset>

<?php
include('Controle/connexion_bdd.php');
include('Controle/fonction_image.php');

?>
</table>
 <table width="600" border="0" cellspacing="0" class="tableau">
  <tr>
    <th scope="col">Selection</th>
    <th scope="col">Type engin</th>
    <th scope="col">Illustration</th>
	<th scope="col">Fiche technique</th>
	<th scope="col">Quantité</th>
	<th scope="col">Durée location</th>
  </tr>
<?php

if (isset($_POST['louer']))
  {
  if (isset($_POST['num_tel']))
     {
       $_POST['num_tel'] = htmlspecialchars($_POST['num_tel']); 
       //On rend inoffensives les balises HTML que le visiteur a pu entrer
       if ((preg_match("#^0[5-7]([-. ]?[0-9]{2}){4}$#",$_POST['num_tel']) or preg_match("#^0[2-4][0-9]([-. ]?[0-9]{2}){3}$#",$_POST['num_tel'] )) )
         {
            $flag_telephone=true;
         }
        else
          {
            if(!empty($_POST['num_tel']))echo 'Le ' . $_POST['num_tel'] . 'numéro de telephone n\'est pas valide,recommencez !</br>';
			$flag_telephone=false;
          }
     }
  if (isset($_POST['email_location']) )
  {
     $_POST['email_location'] = htmlspecialchars($_POST['email_location']); // On rend inoffensives les balises HTML que le visiteur a pu rentrer
     if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#",$_POST['email_location']) )
       {
	    $flag_email=true;
       }
    else
      {
       if ( !empty($_POST['email_location']))echo 'Le ' . $_POST['email_location'] . ' email n\'est pas valide,recommencez !</br>';
       $flag_email=false;
      }
  }
  if (isset($_POST['nrs']) ) 
  { $_POST['nrs'] = htmlspecialchars($_POST['nrs']);
  $flag_nrs=true;
  }
    else 
	 {
	  if (!empty($_POST['nrs']))echo 'Le ' . $_POST['nrs'] . ' NRS n\'est pas valide,recommencez !</br>';
				$flag_nrs=false;
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
	 $id_max=0; 
    //Renvoie dans "$rep" les entrés de la table "engin" et recherche le plus grand'id'
     $flag_cocher=false;
     $rep = $bdd->query('SELECT * FROM engin ');
while ($donnees=$rep->fetch())
 {
  if ($donnees['id']>$id_max) $id_max=$donnees['id'];
  $flag_cocher=true;
 }
 $rep->closeCursor();
 $i=1;
 while (($i <= $id_max) and $flag_nrs and $flag_email and $flag_telephone and $flag_duree_pseudo and $flag_cocher )
 {
   if (isset($_POST[$i])  and isset($_POST[$i.'duree'])  and isset($_POST[$i.'quant']))
    {
	 $rep = $bdd->prepare('SELECT * FROM engin WHERE id=? ');
	 $rep->execute(array($i));
	 $donnees=$rep->fetch();
	 $rep->closeCursor();
	 $donnees['type_engin']=htmlspecialchars($donnees['type_engin']);
	 $_POST[$i.'duree'] = htmlspecialchars($_POST[$i.'duree']);
	 if($_POST[$i.'duree']<2)  $_POST[$i.'duree']=2;
	 $_POST[$i.'quant'] = htmlspecialchars($_POST[$i.'quant']);
	 if($_POST[$i.'quant']<1)  $_POST[$i.'quant']=1;
	 $req=$bdd->prepare('INSERT INTO location VALUES("",?,?,?,?,?,?,?,?,?,"afficher",NOW())');
     $req->execute(array($_POST['nrs'],$_SESSION['pseudo'],$_POST['num_tel'],$_POST['email_location'],$donnees['type_engin'],$donnees['marque_engin'],$donnees['num_serie'],$_POST[$i.'duree'],$_POST[$i.'quant']));	
	 $req->closeCursor();
	 $compteur_id = fopen('Modele/compteur_id_location.txt','r+');
     $id_max = fgets($compteur_id);
	 fseek($compteur_id,0);
     fputs($compteur_id,($id_max+1));
     fclose($compteur_id);			
	 echo('Commandes effectué</br>
	       NRS:'.$_POST['nrs'].'</br>
		   PSEUDONYME:'.$_SESSION['pseudo'].'</br>
		   NUM TEL:'.$_POST['num_tel'].'</br>
		   EMAIL:'.$_POST['email_location'].'</br>
		   TYPE :'.$donnees['type_engin'].'</br>
		   MARQUE :'.$donnees['marque_engin'].'</br>
		   NUM SERIE :'.$donnees['num_serie'].'</br>
		   DUREE:'.$_POST[$i.'duree'].'</br>
		   QUANTITE:'.$_POST[$i.'quant'].'</br>
		   '); 
	} 
	$i++;
 }
	 
}	
//Definie la partie du forum demande 
	 if(isset($_GET['index_page']) )
		 { 
		  if($_GET['index_page']>=0) $index_page=(int) htmlspecialchars($_GET['index_page']);
		     else {echo('index de page non autorisée');$index_page=0;}
			 if(isset($_GET['type_engin'])) $_POST['critere_type_engin']= htmlspecialchars($_GET['type_engin']);
			 if(isset($_GET['marque_engin'])) $_POST['critere_marque_engin']= htmlspecialchars($_GET['marque_engin']);
			 if(isset($_GET['etat_engin'])) $_POST['critere_etat_engin']= htmlspecialchars($_GET['etat_engin']);
		 }
		 else $index_page=0;
	//initialisation des drapeaux selon les cas
	
	 $flag=0;
	 if (isset($_POST['critere_type_engin']) and !empty($_POST['critere_type_engin'])) $flag=1;
	 if (isset($_POST['critere_marque_engin']) and !empty($_POST['critere_marque_engin'])) $flag=2;
	 if (isset($_POST['critere_type_engin']) and !empty($_POST['critere_type_engin']) and isset($_POST['critere_marque_engin']) and !empty($_POST['critere_marque_engin']))
	 $flag=3;
	 if (isset($_POST['critere_etat_engin']) and !empty($_POST['critere_etat_engin'])) $flag=4;
	 if (isset($_POST['critere_type_engin']) and !empty($_POST['critere_type_engin']) and isset($_POST['critere_etat_engin']) and !empty($_POST['critere_etat_engin'])) $flag=5;
	 if ( isset($_POST['critere_marque_engin']) and !empty($_POST['critere_marque_engin']) and  isset($_POST['critere_etat_engin']) and !empty($_POST['critere_etat_engin'])) $flag=6;
	 if (isset($_POST['critere_type_engin']) and !empty($_POST['critere_type_engin']) and isset($_POST['critere_marque_engin']) and !empty($_POST['critere_marque_engin']) and  isset($_POST['critere_etat_engin']) and !empty($_POST['critere_etat_engin'])) $flag=7;
	 
		//introduction dans la base de données selon les cas
	    switch($flag)
		{ 
		case 1:{
			    $_POST['critere_type_engin']=htmlspecialchars($_POST['critere_type_engin']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM engin WHERE type_engin=?');
				$req->execute(array($_POST['critere_type_engin']));
		        $nbr_messages=$req->fetch();
				$req->closeCursor();
				$nbr_liens=$nbr_messages['nbr_message']/5;
				$_GET['type_engin']=$_POST['critere_type_engin'];
	            $rep = $bdd->prepare('SELECT * FROM engin WHERE type_engin=? ORDER BY id DESC LIMIT '.( $index_page*5).',5');
	            $rep->execute(array($_POST['critere_type_engin']));
				
	           }break; 
		case 2:{
			    $_POST['critere_marque_engin']=htmlspecialchars($_POST['critere_marque_engin']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM engin WHERE marque_engin=?');
				$req->execute(array($_POST['critere_marque_engin']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
				$nbr_liens=$nbr_messages['nbr_message']/5;
				$_GET['marque_engin']=$_POST['critere_marque_engin'];
	            $rep = $bdd->prepare('SELECT * FROM engin WHERE marque_engin=? ORDER BY id DESC LIMIT '.( $index_page*5).',5');
	            $rep->execute(array($_POST['critere_marque_engin']));
				
	           }break; 
		case 3:{
			    $_POST['critere_type_engin']=htmlspecialchars($_POST['critere_type_engin']);
				 $_POST['critere_marque_engin']=htmlspecialchars($_POST['critere_marque_engin']);
				 $req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM engin WHERE type_engin=? AND marque_engin=?');
				$req->execute(array($_POST['critere_type_engin'],$_POST['critere_marque_engin']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
				$nbr_liens=$nbr_messages['nbr_message']/5;
				$_GET['type_engin']=$_POST['critere_type_engin'];
				$_GET['marque_engin']=$_POST['critere_marque_engin'];
	            $rep = $bdd->prepare('SELECT * FROM engin WHERE type_engin=? AND marque_engin=? ORDER BY id DESC LIMIT '.( $index_page*5).',5');
	            $rep->execute(array($_POST['critere_type_engin'],$_POST['critere_marque_engin']));
				
	           }break; 
		case 4:{
			    $_POST['critere_etat_engin']=htmlspecialchars($_POST['critere_etat_engin']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM engin WHERE etat_engin=?');
				$req->execute(array($_POST['critere_etat_engin']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
				$nbr_liens=$nbr_messages['nbr_message']/5;
				$_GET['etat_engin']=$_POST['critere_etat_engin'];
	            $rep = $bdd->prepare('SELECT * FROM engin WHERE etat_engin=? ORDER BY id DESC LIMIT '.( $index_page*5).',5');
	            $rep->execute(array($_POST['critere_etat_engin']));
				
	           }break; 
		case 5:{
			    $_POST['critere_type_engin']=htmlspecialchars($_POST['critere_type_engin']);
				$_POST['critere_etat_engin']=htmlspecialchars($_POST['critere_etat_engin']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM engin WHERE type_engin=? AND etat_engin=?');
				$req->execute(array($_POST['critere_type_engin'],$_POST['critere_etat_engin']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
				$nbr_liens=$nbr_messages['nbr_message']/5;
				$_GET['type_engin']=$_POST['critere_type_engin'];
				$_GET['etat_engin']=$_POST['critere_etat_engin'];
	            $rep = $bdd->prepare('SELECT * FROM engin WHERE type_engin=? AND etat_engin=? ORDER BY id DESC LIMIT '.( $index_page*5).',5');
	            $rep->execute(array($_POST['critere_type_engin'],$_POST['critere_etat_engin']));
				
	           }break; 
		case 6:{
			    $_POST['critere_marque_engin']=htmlspecialchars($_POST['critere_marque_engin']);
				$_POST['critere_etat_engin']=htmlspecialchars($_POST['critere_etat_engin']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM engin WHERE marque_engin=? AND etat_engin=?');
				$req->execute(array($_POST['critere_marque_engin'],$_POST['critere_etat_engin']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
				$nbr_liens=$nbr_messages['nbr_message']/5;
				$_GET['marque_engin']=$_POST['critere_marque_engin'];
				$_GET['etat_reclamation']=$_POST['critere_etat_reclamation'];
	            $rep = $bdd->prepare('SELECT * FROM engin WHERE marque_engin=? AND etat_engin=? ORDER BY id DESC LIMIT'.( $index_page*5).',5');
	            $rep->execute(array($_POST['critere_marque_engin'],$_POST['critere_etat_engin']));
				
	           }break; 	
		case 7:{
			    $_POST['critere_type_engin']=htmlspecialchars($_POST['critere_type_engin']);
				$_POST['critere_marque_engin']=htmlspecialchars($_POST['critere_marque_engin']);
				$_POST['critere_etat_engin']=htmlspecialchars($_POST['critere_etat_engin']);
				$req=$bdd->prepare('SELECT COUNT(*) AS nbr_message FROM engin WHERE type_engin=? AND marque_engin=? AND etat_engin=?');
				$req->execute(array($_POST['critere_type_engin'],$_POST['critere_marque_engin'],$_POST['critere_etat_engin']));
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
	            $nbr_liens=$nbr_messages['nbr_message']/5;
				$_GET['type_engin']=$_POST['critere_type_engin'];
				$_GET['marque_engin']=$_POST['critere_marque_engin'];
				$_GET['etat_engin']=$_POST['critere_etat_engin'];
	            $rep = $bdd->prepare('SELECT * FROM engin WHERE type_engin=? AND marque_engin=? AND etat_engin=? ORDER BY id DESC LIMIT'.( $index_page*5).',5');
	            $rep->execute(array($_POST['critere_type_engin'],$_POST['critere_date'],$_POST['critere_etat_engin']));
				
	           }break; 	      	   	   	   	   
	    default:
		        { $req=$bdd->query('SELECT COUNT(*) AS nbr_message FROM engin');
		          $nbr_messages=$req->fetch();
		          $req->closeCursor();
	              $nbr_liens=$nbr_messages['nbr_message']/5;
	              $rep = $bdd->query('SELECT * FROM engin ORDER BY id DESC LIMIT '.( $index_page*5).',5');
				  
	            }
		}

	
	//Inclue un a un les engin sous forme de case a cocher 	   
while ($donnees = $rep->fetch())
{ if($donnees['etat_engin']=='afficher')
{
 $img=image('Modele/'.basename($donnees['adresse_image']),'129','129','0','0');
 echo('<tr>
       <td><input type="checkbox" name="'.$donnees['id'].'" id="'.$donnees['id'] .'" /></td>
	   <td>'.$donnees['type_engin'].'</td>
	   <td><span id="image_engin">'.$img.'</span></td>
	   <td>'.nl2br($donnees['marque_engin'].'<br/>'.$donnees['num_serie'].'<br/>'.$donnees['fiche_technique']).'</td>
	   <td> <select name="'.$donnees['id'].'quant" id="'.$donnees['id'].'quant" aria-label="Mois" class=""><option value="-1">Quant&nbsp;:</option><option value="1">1</option>            <option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option>            <option value="8">8</option></select>
	   </td>
	   <td> <select name="'.$donnees['id'].'duree" id="'.$donnees['id'].'duree" aria-label="Mois" class=""><option value="-1">Mois&nbsp;:<option value="2">2</option><option            value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option            value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option> <option value="14">14            </option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18"> 18</option><option value="19">19</option><option            value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option> <option value="25">25            </option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30 </option><option            value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option><option value="35">35</option><option value="36">36            </option></select>
	   </td>
	   </tr> ');
 }
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
	   if(isset($_GET['etat_engin']) )$etat_engin=$_GET['etat_engin'];
	      else $etat_engin='';
	   $i=0;
    while($i<$nbr_liens)
	{ 
	   echo('<th scope="col"> <a href=location_de_materiel.php?index_page='.$i.'&amp;type_engin='.$type_engin.'&amp;marque_engin='.$marque_engin.'&amp;etat_engin='.$etat_engin.'>'.($i+1).'</a></th>');
	   $i++;
	}
	?>
	</tr>
	</table>  
     
<input type="text" name="nrs"  placeholder='non ou raison sociale' /></br>
<input type="tel" name="num_tel"  placeholder='numero pour vous joindre' /></br>
<input type="email" name="email_location"  placeholder='Email' /></br>
    <?php if (isset($_SESSION['pseudo']))
 echo('</br><center><input type="submit" name="louer" value="confirmer" class="bouton"/></center>');
 else echo('connecter_vous');
?> 
</fieldset>
</form>

</section>
</div>

<footer >
<section class="s_footer"> 
        
		 <?php include("Vue/pied_de_page_1.php"); ?>
		  
</section>

<section class="s_footer" > 
        
		<?php include("Vue/eufemeride.php"); ?>		

</section > 
<section class="s_footer"> 

        <?php include("Vue/pied_de_page_3.php"); ?>

</section>
</footer>
</div>
</body>
</html>
