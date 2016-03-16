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
			 echo(' <table width="100" border="0" cellspacing="20" id="tableau_connecte" >
                    <tr><th scope="row">Membre:</th></tr>
                       <tr><td>'.$_SESSION['pseudo'].'</td></tr>
                       <tr><td><a href="Controle/modif_info.php"> Modifier  </a></td></tr>
                       <tr><td><a href="Controle/mes_commandes.php"> Commandes </a></td></tr>
					   <tr><td><a href="deconnexion.php"> Deconnexion </a> </td></tr>
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