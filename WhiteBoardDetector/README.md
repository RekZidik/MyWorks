------------------------------------------------RAPPORT-----------------------------------------------------------------

Dans le cadre du projet de python 2015-2016 nous avons essayer de faire la totalité des point (nous n'avons pas vraiment réussi):

Difficulté:
------------
-Les temps d'executions se révèle important quand les image sont de grande résolution. 
-Définition technique d'un tableau difficile a déterminé.


Demarche suivi:
---------------
-On charge une image avec le package OpenCV (imread()).
-On la redimensionne. 
-On la transforme en niveaux de gris.
-On détecte les bords avec l’algorithme de « Canny » implémentait par OpenCV.
-On applique ensuite l’algorithme de détection des droites de OpenCV(HoughLines()) en lui passant le résultat de « Canny ». 
-Nous trions les lignes trouvés :
	+Entre horizontales et verticales.
	+Dans chaque catégorie nous repérant celles qui ont un minimum de distance entre elle.
	+Nous formant les quadrilatères (2 verticales, 2 horizontales) pouvant être un tableau :
		•Deux angles minimum sont égaux.
		•Les angles du quadrilatère sont dans l’intervalle [85 ; 95] 
-Après détection nous traçons les lignes du quadrilatère pour l’affichage en mode débogage.
-Nous calculons les points d’intersection et nous les représentant sous forme de cercles (toujours pour le mode débogage)
-On redresse la partie de l’image extraite (cv2.getPerspectiveTransform()puis cv2.warpPerspective()).
-La partie amélioration de l’image n’est pas très aboutie(On ne la pas incluse dans le résultat final).
-Nous retournons le résultat sous forme d’image JPEG (resultat.jpg) après l’avoir affiché a l’écran.


Utilisation:
------------
Il suffit de lancer le fichier projet.py avec le terminal en lui passant le PATH de l'image comme premier argument
Les options :
	-Un "D" comme deuxieme argumentpour le mode débogage
	-Un "A" pour une amélioration du rendu final.