// JavaScript Document
<!--
// ==========================
// Script réalisé par Eric Marcus - Aout 2006
// ==========================

// conteneur = id du bloc (<div>, <p> ...) contenant les checkbox
// a_faire = '0' pour tout décocher
// a_faire = '1' pour tout cocher
// a_faire = '2' pour inverser la sélection
//-->
function GereChkbox( a_faire) {
var blnEtat=null;
var Chckbox = document.querySelectorAll(' table tr td input ');
var long =  Chckbox.length;
var i =0;
	while (Chckbox!=null  && i< long) {
		
			if (Chckbox.getAttribute("type")=="checkbox") {
				blnEtat = (a_faire=='0') ? false : (a_faire=='1') ? true : (Chckbox[i].checked) ? false : true;
				Chckbox[i].checked=blnEtat;
			}
		i++;
	}
}
