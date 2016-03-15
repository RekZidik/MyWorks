import cv2
import imutils
import numpy as np
import math

nom_de_fichier = 'imgg.jpg'
source = cv2.imread(nom_de_fichier)#....................................lire le fichier
source = imutils.resize(source, width=450, height=350)#.................redimensionner l'image
source_gray = cv2.cvtColor (source,cv2.COLOR_BGR2GRAY)#.................transformer l'image au niveau de gris
autre_gray= cv2.cvtColor (source,cv2.COLOR_BGR2GRAY)
#detecter les contours de l'image en ninveau de gris avec le filtre de canny
canny_source = cv2.Canny(source,20,150,apertureSize = 3)

#HoughLinesP() se filtre retourne toutes #les droite a partir d'une image donnee
#cette methode selectionne tout les droites avec le vote de tout les pixels
lines = cv2.HoughLinesP(canny_source, 1, math.pi/180.0, 100, np.array([]), 20, 100)

a,b,c = lines.shape
for i in range(a):
   #cette methode trace les lignes en noir
    cv2.line(source_gray, (lines[i][0][0], lines[i][0][1]), (lines[i][0][2], lines[i][0][3]), (0, 0, 255), 2, cv2.LINE_AA)

#
gray = np.float32(source_gray)
#cette methode retourn les corners a partir de l'image dans laquelle en a appliquer le filtre canny
dst = cv2.cornerHarris(gray,2,3,0.001)

#resultat est dilater pour marquer les coins , qui ne sont pas important
dst = cv2.dilate(dst,None)
# Seuil pour une valeur optimale , il peut varier en fonction de l'image
autre_gray[dst>0.01*dst.max()]=[0]

#afficher l'image dans laquelle on a detecter les contours
cv2.imshow("image__avec_filtre_canny", canny_source)
if cv2.waitKey(0) & 0xff == 27:
    cv2.destroyAllWindows()

#afficher l'image en detectent les lignes droite sur l'image qui est au niveau de gris
cv2.imshow("dessiner_les_arretes", source_gray)
if cv2.waitKey(0) & 0xff == 27:
    cv2.destroyAllWindows()

    #afficher l'image avec detection des corners (deux arrete  se croise) par des points,
cv2.imshow('dst',dst)
cv2.imshow('dst',autre_gray)
if cv2.waitKey(0) & 0xff == 27:
    cv2.destroyAllWindows()

cv2.waitKey(0)
