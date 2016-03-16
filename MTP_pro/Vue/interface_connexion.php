<?php 
if (isset($_SESSION['pseudo']) )
   {
     if ( isset($_SESSION['type_membres']))
	   {
	    if($_SESSION['type_membres']=='administrateur')
            {
	          header('Location:Admin/index.php');
	        }
	      else
	        { 
			 echo(' <table width="250" border="0" cellspacing="20" id="tableau_connecte" >
                    <tr><th scope="row"> Bienvenue  '.strtoupper($_SESSION['pseudo']).'</th></tr>
                       <tr><td></td></tr>
                       <tr><td class="test"><a href="modif_info.php"> Modifier  </a></td></tr>
                       <tr><td class="test"><a href="mes_commandes.php"> Commandes </a></td></tr>
					   <tr><td class="test"><a href="mes_reclamation.php"> Reclamation </a></td></tr>
					   <tr><td class="test"><a href="deconnexion.php"> Deconnexion </a> </td></tr>
                    </tr>
                    </table>
                  ');
	        } 
        }
	}
else
   { 
     include("./Controle/connexion.php");
   }
   ?>