<?php
/* ===================================================================================================
 image($chemin,$width_max="",$height_max="",$border="0",$force="0") : fonction d'insertion d'une image
 =====================================================================================================

 Auteur :       Marc Guillaume
 Cr�ation :     24/14/2002
 Statut :       GNU/GPL


              FONCTION D'INSERTION D'UNE IMAGE PAR UN TAG <img src=...

Param�tres en entr�e :
        $chemin : Le chemin d'acc�s au fichier image
	$width_max : la largeur maximale que l'on autorise pour l'image affich�e. Par d�faut aucune.
	$height_max : la hauteur maximale que l'on autorise pour l'image affich�e. Par d�faut aucune.
	$border : la largeur de l'encadrement. Par d�faut aucun cadre.
	$force : flag qui force l'affichage avec les dimensions sp�cifi�es, quitte � d�former l'image.

Param�tres en sortie :
        Le tag HTML form� complet exemple <img src="imgage.gif" width="201" height="54" border="0">

Utilisation :  cette fonction permet de d�finir une zone d'affichage de l'image qui soit fixe et de s'assurer
que n'importe quelle image s'affichera en utilisant au mieux l'espace qui lui est attribu� sans d�formation (si
$force est � 0). Ce qui est utile par exemple pour l'affichage d'images dans une liste de produits d'un site marchand
cr��e dynamiquement depuis une base de donn�es.

Elle utilise simplement la fonction php getimagesize et les valeur qu'elle renvoit en tableau (voir doc php).
En gros si l'image est plus petite que l'espace allou� elle s'affiche avec sa taille � elle. Sinon on d�termine
si l'image est verticale ou horizontale. Dans le premier cas c'est la hauteur qui est la dimension directrice, dans
le cas inverse c'est la largeur.

On applique alors une simple r�gle de trois pour modifier la taille de l'image de fa�on homoth�tique. On fixe la
dimension directrice � la valeur maximale autoris�e puis on calcule l'autre dimension proportionnelle. On peut n'imposer
qu'une seule des dimensions.


Bien entendu cela ne dispense pas d'avoir des images de taille "raisonnable", car si vous afficherez correctement une
image de 500x600 dans un cadre de 120x60 le poids de l'image � t�l�charger sera, lui toujours le m�me.


*/
if(!isset($existefoncImage)){ // protection contre un rechargement de la fonction
$existefoncImage=1;

	function image($chemin,$width_max="",$height_max="",$border="0",$force="0"){

		$dim_image=getimagesize($chemin);
		$largeur_image=$dim_image[0];
		$hauteur_image=$dim_image[1];

		if($width_max=="" && $height_max==""){
			$dim=$dim_image[3];
		}
		else{
			if($width_max=="" xor $height_max==""){
				if($width_max==""){
					if($hauteur_image<=$height_max){
						$dim=$dim_image[3];
					}
					else{
						$hauteur_affichage=$height_max;
						$largeur_affichage=round(($largeur_image*$hauteur_affichage)/$hauteur_image,0);
						$dim=" width=\"".$largeur_affichage."\" height=\"".$hauteur_affichage."\"";
					}
				}
				else{
					if($largeur_image<=$width_max){
						$dim=$dim_image[3];
					}
					else{
						$largeur_affichage=$width_max;
						$hauteur_affichage=round(($hauteur_image*$largeur_affichage)/$largeur_image,0);
						$dim=" width=\"".$largeur_affichage."\" height=\"".$hauteur_affichage."\"";
					}
				}

			}
			else {
				if($force!=0){
				        $dim=" width=\"".$width_max."\" height=\"".$height_max."\"";
				}
				else{
					if($largeur_image<=$width_max && $hauteur_image<=$height_max){
						$dim=$dim_image[3];
					}
					else{
						if(($largeur_image - $width_max)>=($hauteur_image - $height_max)){
							$largeur_affichage=$width_max;
							$hauteur_affichage=round(($hauteur_image*$largeur_affichage)/$largeur_image,0);
						}
						else{
							$hauteur_affichage=$height_max;
							$largeur_affichage=round(($largeur_image*$hauteur_affichage)/$hauteur_image,0);
						}
						$dim=" width=\"".$largeur_affichage."\" height=\"".$hauteur_affichage."\"";
					}
				}
			}
		}
		if($border==""){
			$border=" border=\"0\"";
		}
		else{
			$border=" border=\"".$border."\"";
		}

		return "<img src=\"".$chemin."\" ".$dim.$border.">";
	} // fin de fonction image

}// fin de protection fonction image
// ===================================================================================

?>