import math

import cv2
import imutils
import numpy as np
import sys

from ImageAmeliorator import enhancementImage


class Line:
    def __init__(self, l):
        self.point = l
        x1, y1, x2, y2 = l
        if x2 - x1 > 0:
            self.cof_d = (y2 - y1) / (x2 - x1)
            self.ord_orig = y2 - self.cof_d * x2
        else:
            self.cof_d = 0
            self.ord_orig = y2 - self.cof_d * x2

        self.c_x = abs(x2 - x1) / 2
        self.c_y = abs(y2 - y1) / 2
        self.theta = 0
        self.rho = 0

    def initPolarCoord(self, theta, rho):
        self.theta = theta
        self.rho = rho


def show(im):
    msg = 'appuyer sur n import quel touche'
    cv2.namedWindow(msg, cv2.WINDOW_NORMAL)
    im = imutils.resize(im, width=700, height=500)
    cv2.imshow(msg, im)
    cv2.waitKey(0)
    cv2.destroyAllWindows()


# la fonction qui revois les coordonnee de deux lignes croiser
def intersection(l1, l2):
    x1, y1, x2, y2 = l1.point
    x3, y3, x4, y4 = l2.point
    a1, b1 = y2 - y1, x1 - x2
    c1 = a1 * x1 + b1 * y1
    a2, b2 = y4 - y3, x3 - x4
    c2 = a2 * x3 + b2 * y3
    det = a1 * b2 - a2 * b1
    assert det, "lines are parallel"
    return (1. * (b2 * c1 - b1 * c2) / det, 1. * (a1 * c2 - a2 * c1) / det)


def scannerLite(im, debug=False):
    # resize
    global hori, vert
    h, w, _ = im.shape

    min_w = 500
    scale = min(10., w * 1. / min_w)
    h_proc = int(h * 1. / scale)
    w_proc = int(w * 1. / scale)
    im_dis = cv2.resize(im, (w_proc, h_proc))

    # gray
    gray = cv2.cvtColor(im_dis, cv2.COLOR_BGR2GRAY)

    # blur
    gray = cv2.blur(gray, (3, 3))
    gray = cv2.GaussianBlur(gray, (3, 3), 0)

    # canny edges detection
    high_thres = cv2.threshold(gray, 0, 100, cv2.THRESH_BINARY | cv2.THRESH_OTSU)[0]
    low_thres = high_thres * 0.32
    canny = cv2.Canny(gray, 0, low_thres, apertureSize=3)

    if debug:
        show(canny)


    lines = cv2.HoughLines(canny, 1, math.pi / 180.0, 100, np.array([]), 0, 0)

    if debug:
        t = cv2.cvtColor(canny, cv2.COLOR_GRAY2BGR)

        # classify lines
    hori, vert = [], []
    a, b, c = lines.shape
    for l in range(a):

        rho = lines[l][0][0]
        theta = lines[l][0][1]
        a = np.cos(theta)
        b = np.sin(theta)
        x0 = a * rho
        y0 = b * rho
        dec_down = math.sqrt(math.pow(x0, 2) + math.pow(y0, 2))
        dec_up = math.sqrt(math.pow(w_proc - x0, 2) + math.pow(h_proc - y0, 2))
        x1 = int(x0 + dec_down * (-b))
        y1 = int(y0 + dec_down * (a))
        x2 = int(x0 - dec_up * (-b))
        y2 = int(y0 - dec_up * (a))

        temp = Line([x1, y1, x2, y2])
        temp.initPolarCoord(theta, rho)

        # apres avoir recuperer les point de chaque ligne retourner par Houghlines
        # on distingue les ligne horizontaux et verticaux
        if abs(x1 - x2) > abs(y1 - y2):
            hori.append(temp)
        else:
            vert.append(temp)

    print(len(hori))

    # not enough
    # si  y a que une ou zero line on prend les bord de l'image

    if len(hori) < 2:
        if not hori or hori[0].c_y > h_proc / 2:
            hori.append(Line((0, 0, w_proc - 1, 0)))
        if not hori or hori[0].c_y <= h_proc / 2:
            hori.append(Line((0, h_proc - 1, w_proc - 1, h_proc - 1)))

    if len(vert) < 2:
        if not vert or vert[0].c_x > w_proc / 2:
            vert.append(Line((0, 0, 0, h_proc - 1)))
        if not vert or vert[0].c_x <= w_proc / 2:
            vert.append(Line((w_proc - 1, 0, w_proc - 1, h_proc - 1)))

    hori.sort(key=lambda l: l.c_y)
    vert.sort(key=lambda l: l.c_x)

    # selectionner les ligne les plus eloigner
    temph = hori
    tempv = vert

    # liste des horizontaux dans laquel la distance entre les ligne et plus de h/2 de l image
    distList = []
    for l in range(len(temph)):
        r1 = temph[l].rho

        for s in range(len(temph)):
            if (s <= l): continue
            r2 = temph[s].rho
            t2 = temph[s].theta

            if ((abs(r1 - r2) >= ((h_proc / 2)))):

                distList.append([abs(r1 - r2), temph[l], temph[s]])

    distList.sort(key=lambda l: l[0])

    # liste des verticaux dans laquel la distance entre les ligne et plus de w/2 de l image
    distList1 = []
    for l in range(len(tempv)):
        r1 = tempv[l].rho

        for s in range(len(tempv)):
            if s <= l: continue
            r2 = tempv[s].rho

            if abs(r1 - r2) >= (w_proc / 2):
                distList1.append([abs(r1 - r2), tempv[l], tempv[s]])

    distList1.sort(key=lambda l: l[0])


    # mettre dans une liste toute les lines qui forment des quadrilateres a certain condition

    selection = []
    for l in range(len(distList1)):
        t1 = distList1[l][1].cof_d
        t2 = distList1[l][2].cof_d
        for s in range(len(distList)):

            t3 = distList[s][1].cof_d
            t4 = distList[s][2].cof_d

            tang1 = abs((t1 - t3) / 1 + (t1 * t3))
            tang2 = abs((t2 - t3) / 1 + (t2 * t3))
            tang3 = abs((t1 - t4) / 1 + (t1 * t4))
            tang4 = abs((t2 - t4) / 1 + (t2 * t4))
            alpha1 = math.degrees(math.atan(tang1))
            alpha2 = math.degrees(math.atan(tang2))
            alpha3 = math.degrees(math.atan(tang3))
            alpha4 = math.degrees(math.atan(tang4))
            beta1 = 180.0 - alpha1
            beta2 = 180.0 - alpha2
            beta3 = 180.0 - alpha3
            beta4 = 180.0 - alpha4
            if (((beta1 >= 85) and (beta1 <= 95)) and ((beta2 >= 85) and (beta2 <= 95))
                and ((beta3 >= 85) and (beta3 <= 95)) and ((beta4 >= 85) and (beta4 <= 95))):
                selection.append([beta1, beta2, beta3, beta4, distList1[l][1], distList1[l][2],
                                  distList[s][1], distList[s][2]])


    # mettre dans une liste tout les quadrilatere ayant plus au moins meme degree d'angle
    selectionNew = []

    for l in range(len(selection)):
        cpt = 0
        defer1 = abs(selection[l][0] - selection[l][2])
        defer2 = abs(selection[l][0] - selection[l][3])
        defer3 = abs(selection[l][1] - selection[l][2])
        defer4 = abs(selection[l][1] - selection[l][3])
        if ((defer1 <= 2) and (defer2 <= 2)):
            cpt += 1
        if ((defer1 <= 2) and (defer3 <= 2)):
            cpt += 1
        if (defer1 <= 2) and (defer4 <= 2):
            cpt += 1
        if ((defer2 <= 2) and (defer3 <= 2)):
            cpt = cpt + 1
        if ((defer2 <= 2) and (defer4 <= 5)):
            cpt = cpt + 1
        if ((defer3 <= 2) and (defer4 <= 2)):
            cpt = cpt + 1

        selectionNew.append([cpt, selection[l][4], selection[l][5],
                             selection[l][6], selection[l][7]])
    selectionNew.sort(key=lambda l: l[0])

    if len(selectionNew) == 0:
        selectionNew.append([0,
                             Line((0, 0, w_proc - 1, 0)),
                             Line((0, h_proc - 1, w_proc - 1, h_proc - 1)),
                             Line((0, 0, 0, h_proc - 1)),
                             Line((w_proc - 1, 0, w_proc - 1, h_proc - 1))])

    # tracer les lignes de quadrilatere qui a obtenue un compteur plus grand

    x1, y1, x2, y2 = selectionNew[0][1].point
    if debug:
        cv2.line(t, (x1, y1), (x2, y2), (0, 0, 255), 1)

    x1, y1, x2, y2 = selectionNew[0][2].point
    if debug:
        cv2.line(t, (x1, y1), (x2, y2), (0, 0, 255), 1)

    x1, y1, x2, y2 = selectionNew[0][3].point
    if debug:
        cv2.line(t, (x1, y1), (x2, y2), (0, 0, 255), 1)

    x1, y1, x2, y2 = selectionNew[0][4].point
    if debug:
        cv2.line(t, (x1, y1), (x2, y2), (0, 0, 255), 1)

    if debug:
        show(t)

    # corners
    # apres avoir selectionner les ligne on les trace en Gras avec le jaune
    if debug:
        for l in [selectionNew[0][1], selectionNew[0][2], selectionNew[0][3], selectionNew[0][4]]:
            x1, y1, x2, y2 = l.point
            cv2.line(t, (x1, y1), (x2, y2), (0, 255, 255), 3, cv2.LINE_AA)  # en jaune

    # on calcule les point d'intersection entre les lignes
    img_pts = [intersection(selectionNew[0][3], selectionNew[0][1]),
               intersection(selectionNew[0][3], selectionNew[0][2]),
               intersection(selectionNew[0][4], selectionNew[0][1]),
               intersection(selectionNew[0][4], selectionNew[0][2])]



    # circler les point d'intersection des lignes
    for i, p in enumerate(img_pts):
        x, y = p
        img_pts[i] = (x * scale, y * scale)
        if debug:
            cv2.circle(t, (int(x), int(y)), 3, (255, 255, 0), 3)
    if debug:
        show(t)

    # redresser l'image a partir des 4 points d'intersection,
    w_a4 = min(800, int(max(img_pts[0][0], max(img_pts[1][0], max(img_pts[2][0], img_pts[3][0])))
               -
               min(img_pts[0][0], min(img_pts[1][0], min(img_pts[2][0], img_pts[3][0])))))

    h_a4 = min(800, int(max(img_pts[0][1], max(img_pts[1][1], max(img_pts[2][1], img_pts[3][1])))
               -
               min(img_pts[0][1], min(img_pts[1][1], min(img_pts[2][1], img_pts[3][1])))))

    dst_pts = np.array(
        ((0, 0), (w_a4 - 1, 0), (0, h_a4 - 1), (w_a4 - 1, h_a4 - 1)),
        np.float32)
    img_pts = np.array(img_pts, np.float32)
    transmtx = cv2.getPerspectiveTransform(img_pts, dst_pts)
    return cv2.warpPerspective(im, transmtx, (w_a4, h_a4))


if __name__ == '__main__':
    am = False
    deb = False
    im = cv2.imread('imgg.jpg')
    if len(sys.argv)>1:
        im = cv2.imread(sys.argv[1])
    if len(sys.argv)>2:
        deb = str.upper(sys.argv[2]).find('D') >= 0
        am = str.upper(sys.argv[2]).find('A') >= 0
    dst = scannerLite(im, debug=deb)
    if am :
        enhancementImage(im, 40, 50)
    show(dst)
    cv2.imwrite('reultat.jpg', dst)
