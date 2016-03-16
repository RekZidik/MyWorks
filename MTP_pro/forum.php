<?php
include("Controle/initialisation_session.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<link rel="stylesheet" href="style.css"/>
<title> Forum </title>
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
<form method="post" action="forum.php">
<fieldset>
<legend> Tapez votre commentaire </legend>
<?php 
//Definie la partie du forum demande 
	 if(isset($_GET['index_page']) )
		 {
		  if($_GET['index_page']>=0) $index_page=(int) htmlspecialchars($_GET['index_page']);
		     else {echo('index de page non autorisée');$index_page=0;}
		 }
		 else $index_page=0;
          if (!isset($_SESSION['pseudo'])) echo('<label for="pseudo"> Pseudo  </label> <input id="pseudo" name="pseudo" type="text" placeholder="pseudo" required /><br/>'); ?>

<label for="message"> Message  </label> <textarea id='message'  name="message" cols="30" rows="8"  required   ></textarea><br/>
<input type="submit" value="valider"/>
</fieldset>
</form>
<?php

include('Controle/connexion_bdd.php');
if(  isset($_POST["message"])and  ( !empty($_POST['message']) or !($_POST["message"]=='MESSAGE!!!!') ))
{   $_POST["message"]=htmlspecialchars($_POST["message"]);
    $ban_word = fopen('./Modele/mots_interdit.txt','r+');
    $flag=false;
    while( ($mot = fgets($ban_word)) and !$flag)
	{    echo"qiw";
	     echo $mot ;
		 $mot=strtoupper($mot);
		 $_POST["message"]=strtoupper($_POST["message"]);
	     $tm=strlen($mot);
		 echo $tm;
		$flag=preg_match('#'.$mot.'#i',$_POST["message"],$tm);
		
		echo $flag;
	}
	if ( isset($_POST["pseudo"]))
	{  if (!$flag)
	     {
            $req=$bdd->prepare('INSERT INTO mini_chat(id,pseudo, message,etat_message,date) VALUES("",?,?,"afficher",NOW())');
            $req->execute(array($_POST['pseudo'],$_POST['message']));
            $req->closeCursor();
	        $compteur_id = fopen('./Modele/compteur_id_forum.txt','r+');
            $id_max = fgets($compteur_id);
	        fseek($compteur_id,0);
            fputs($compteur_id,($id_max+1));
            fclose($compteur_id);
		 }else echo '<script type="text/javascript">alert("Nous n\'autorisons pas d\'insulte sur ce forum")</script> ';
	}else
		{ 
		    if (!$flag)
	           {
                 $req=$bdd->prepare('INSERT INTO mini_chat(id,pseudo, message,etat_message,date) VALUES("",?,?,"afficher",NOW())');
                 $req->execute(array($_SESSION['pseudo'],$_POST['message']));
                 $req->closeCursor();
		         $compteur_id = fopen('Modele/compteur_id_forum.txt','r+');
                 $id_max = fgets($compteur_id);
	             fseek($compteur_id,0);
                 fputs($compteur_id,($id_max+1));
                 fclose($compteur_id);
			   }else echo '<script type="text/javascript">alert("Nous n\'autorisons pas d\'insulte sur ce forum")</script> ';
	    }
}
else
{
 echo("<strong>ENTRER DES INFORMATION POUR AJOUTER LE MESSAGE</strong>");
}
$req=$bdd->query('SELECT COUNT(*) AS nbr_message FROM mini_chat WHERE etat_message="afficher" ');
		        $nbr_messages=$req->fetch();
		        $req->closeCursor();
	            $nbr_liens=$nbr_messages['nbr_message']/10;
$rep=$bdd->query('SELECT pseudo, message FROM mini_chat WHERE etat_message="afficher" ORDER BY id DESC LIMIT '.( $index_page*10).',10');
echo '<table width="650" cellspacing="0" border="0" class="tableau" id="tableau_forum">
       <caption> FORUM </caption>
	    <tr>
           <th scope="row">Pseudo</th>
           <td><strong>Message</strong></td>
        </tr>';
while ($donnees = $rep->fetch())
{
echo  ' <tr>
    <th scope="row"><strong>'.htmlspecialchars($donnees['pseudo']) .'</strong> </th>
    <td>' .nl2br(htmlspecialchars($donnees['message'])) . '</td>
  </tr> ';
}
echo '</table>';
$rep->closeCursor();



?>
 <table width="650" border="0" cellspacing="0">
      <tr>
       <?php
	   if(isset($_GET['type_engin']) )$type_engin=$_GET['type_engin'];
	      else $type_engin='';
	   if(isset($_GET['marque_engin']) )$marque_engin=$_GET['marque_engin'];
	      else $marque_engin='';
	   if(isset($_GET['etat_reclamation']) )$etat_demande=$_GET['etat_reclamation'];
	      else $etat_reclamation='';
	   $i=0;
    while($i<$nbr_liens)
	{ 
	   echo('<th scope="col"> <a href=forum.php?index_page='.$i.'>'.($i+1).'</a></th>');
	   $i++;
	}
	?>
	</tr>
	</table>


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
