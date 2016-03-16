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
			 echo(' <table width="100" border="0" cellspacing="20" id="tableau_connexion" >
                    <tr>
                       <th scope="row">Membre:</th>
                       <td>'.$_SESSION['pseudo'].'</td>
                       <td><a href="../deconnexion.php"> Deconnexion </a> </td>
                       <td><a href="modif_info.php"> Modifier  </a></td>
                       <td><a href="mes_commandes.php"> Commandes </a></td>
                    </tr>
                    </table>
                  ');
	        } 
        }
		/* else
	        {
	          echo('<map>bienvenue Monssieur :<strong>'.$_SESSION['pseudo'].'</strong> <a href="deconnexion.php"> Deconnexion </a>  </map> ');
	        } */
	}
else
   { 
     include("./Controle/connexion.php");
   }
   ?>