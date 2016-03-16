<?php
/* ===================================================================================================
 image($chemin,$width_max="",$height_max="",$border="0",$force="0") : fonction d'insertion d'une image
 =====================================================================================================

 Auteur :       Marc Guillaume
 Création :     24/14/2002
 Statut :       GNU/GPL


              FONCTION D'INSERTION D'UNE IMAGE PAR UN TAG <img src=...

Paramètres en entrée :
        $chemin : Le chemin d'accès au fichier image
	$width_max : la largeur maximale que l'on autorise pour l'image affichée. Par défaut aucune.
	$height_max : la hauteur maximale que l'on autorise pour l'image affichée. Par défaut aucune.
	$border : la largeur de l'encadrement. Par défaut aucun cadre.
	$force : flag qui force l'affichage avec les dimensions spécifiées, quitte à déformer l'image.

Paramètres en sortie :
        Le tag HTML formé complet exemple <img src="imgage.gif" width="201" height="54" border="0">

Utilisation :  cette fonction permet de définir une zone d'affichage de l'image qui soit fixe et de s'assurer
que n'importe quelle image s'affichera en utilisant au mieux l'espace qui lui est attribué sans déformation (si
$force est à 0). Ce qui est utile par exemple pour l'affichage d'images dans une liste de produits d'un site marchand
créée dynamiquement depuis une base de données.

Elle utilise simplement la fonction php getimagesize et les valeur qu'elle renvoit en tableau (voir doc php).
En gros si l'image est plus petite que l'espace alloué elle s'affiche avec sa taille à elle. Sinon on détermine
si l'image est verticale ou horizontale. Dans le premier cas c'est la hauteur qui est la dimension directrice, dans
le cas inverse c'est la largeur.

On applique alors une simple règle de trois pour modifier la taille de l'image de façon homothétique. On fixe la
dimension directrice à la valeur maximale autorisée puis on calcule l'autre dimension proportionnelle. On peut n'imposer
qu'une seule des dimensions.


Bien entendu cela ne dispense pas d'avoir des images de taille "raisonnable", car si vous afficherez correctement une
image de 500x600 dans un cadre de 120x60 le poids de l'image à télécharger sera, lui toujours le même.


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