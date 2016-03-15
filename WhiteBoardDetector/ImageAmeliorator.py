import cv2
import imutils
import math


class Vote:
    def __init__(self, nbrV, bgr):
        self.__nbrV = nbrV
        self.__bgr = bgr


# class iter:
#     """ """
# __borne = 0
# __step = 1
# __now = 0
# __start = 0
#
# def __init__(self, borne, start=0, step=1):
#     self.__borne = borne
#     self.__step = step
#     self.__start = start
#
# def __iter__(self):
#     self.__now = self.__start
#
#
# def __next__(self):
#     self.__now += self.__step
#
#     return self.__now


def increaseContrast(img, coef=0.5):
    # Recuperation de l'histogram des trois couleurs
    # color = ('b', 'g', 'r')
    # hist = []
    # for channel in range(3):
    #     hist.append(cv2.calcHist([img], [channel], None, [256], [0, 256]))
    # minimum = [255, 255, 255]
    # maximum = [0, 0, 0]
    # for i in range(len(img)):
    #     for j in range(len(img[0])):
    #         # Max & min blue
    #         if img[i][j][0] > maximum[0]:
    #             maximum[0] = img[i][j][0]
    #         if img[i][j][0] < minimum[0]:
    #             minimum[0] = img[i][j][0]
    #
    #         # Max & min green
    #         if img[i][j][1] > maximum[1]:
    #             maximum[1] = img[i][j][1]
    #         if img[i][j][1] < minimum[1]:
    #             minimum[1] = img[i][j][1]
    #
    #         # Max & min red
    #         if img[i][j][2] > maximum[2]:
    #             maximum[2] = img[i][j][2]
    #         if img[i][j][2] < minimum[2]:
    #             minimum[2] = img[i][j][2]
    #
    # LUT = []
    #
    # for i in range(3):
    #     maximum[i] = maximum[i]-25
    #
    # for i in range(256):
    #
    #     if minimum[0] <= i <= maximum[0]:
    #         b = (i - minimum[0]) * 255 / (maximum[0] - minimum[0])
    #     else:
    #         if i < minimum[0]:
    #             b = 0
    #         else:
    #             b = 255
    #
    #     if minimum[1] <= i <= maximum[1]:
    #         g = (i - minimum[1]) * 255 / (maximum[1] - minimum[1])
    #     else:
    #         if i < minimum[1]:
    #             g = 0
    #         else:
    #             g = 255
    #
    #     if minimum[2] <= i <= maximum[2]:
    #         r = (i - minimum[2]) * 255 / (maximum[2] - minimum[2])
    #     else:
    #         if i < minimum[2]:
    #             r = 0
    #         else:
    #             r = 255
    #     LUT.append([b, g, r])
    # for i in range(len(im)):
    #     for j in range(len(im[0])):
    #         im[i][j] = [LUT[im[i][j][0]][0], LUT[im[i][j][1]][1], LUT[im[i][j][2]][2]]
    # print(im)
    # print(len(hist))
    # print(hist[0])
    # print(hist[1])
    # print(hist[2])

    for i in range(len(img)):
        for j in range(len(img[0])):
            a = img[i][j][0] * 0.114 + img[i][j][1] * 0.587 + img[i][j][2] * 0.299
            if a != 0:
                ab = 255 * math.pow(a / 255, coef)
            else:
                ab = 0
            img[i][j][0] = max(0, min(255, img[i][j][0] + ab - a))
            img[i][j][1] = max(0, min(255, img[i][j][1] + ab - a))
            img[i][j][2] = max(0, min(255, img[i][j][2] + ab - a))

    return img


def unifomizeBackground(img, threshold=215):
    h = len(img)
    w = len(img[0])
    born = 15
    moy = 0
    imB = [[0] * w] * h
    taille = 1 / (born * born)
    for i in range(0, h, born):
        for j in range(0, w, born):
            for k in range(born):
                if i + k >= h:
                    break
                for l in range(born):
                    if j + l >= w:
                        break
                    moy = max(moy, img[i + k][j + l][0] * 0.114 + img[i + k][j + l][1] * 0.587 + img[i + k][j + l][
                        2] * 0.299)

            imB[i:max(i + born, h)][j:max(i + born, w)] = [[moy * taille] * max(i + born, w)] * max(i + born, h)
            moy = 0

    for i in range(h):
        for j in range(w):
            # img[i][j][0] +=255*(0.5-0.5*math.cos(math.pow(min(1,img[i][j][0]/imB[i][j]),0.75)*math.pi))
            if imB[i][j] - 25 <= img[i][j][0] <= imB[i][j]:
                img[i][j][0] += 255 - imB[i][j]
            if imB[i][j] - 25 <= img[i][j][1] <= imB[i][j]:
                img[i][j][1] += 255 - imB[i][j]
            if imB[i][j] - 25 <= img[i][j][1] <= imB[i][j]:
                img[i][j][2] += 255 - imB[i][j]

    return img


def increaseColors(im, bac=50):
    img = im
    h = len(im)
    w = len(im[0])
    for i in range(h):
        for j in range(w):
            if im[i][j][0] < 215 and im[i][j][1] < 215 and im[i][j][2] < 215:
                im[i][j] = [int(img[i][j][0] / bac) * bac, int(img[i][j][1] / bac) * bac, int(img[i][j][2] / bac) * bac]

    return im


def show(im):
    msg = 'press any key to continue'
    cv2.namedWindow(msg, cv2.WINDOW_NORMAL)
    im = imutils.resize(im, width=700, height=500)
    cv2.imshow(msg, im)
    cv2.waitKey(0)
    cv2.destroyAllWindows()


def enhancementImage(img, threshold=255, bac=50):
    img = unifomizeBackground(img)
    img = increaseContrast(img)
    img = increaseColors(img, 30)
    return img


if __name__ == '__main__':
    im = cv2.imread('reultat.jpg')
    cv2.imshow('whiter', enhancementImage(im, 40, 50))
    cv2.waitKey(0)
    show(im)
