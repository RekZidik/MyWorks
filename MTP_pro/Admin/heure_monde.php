<?php
//********************************************************/
//*                                                      */
/*                 _____      _______                   */
/*                / ___/     / _____/                   */
/*               / /        / /                         */
/*              / /__      / /____                      */
/*             /___ /     /  ____/                      */
/*               / /     / /                            */
/*           ___/ /     / /                             */
/*          /____/  .  /_/ ischer                       */
/*                                                      */
/*         http://www.villalespensees.fr                */
/********************************************************/

//Vous n'avez pas le droit de diffuser ou vendre ce script
//il n'est disponique que sur http://www.villalespensees.fr/ephemeride/


//P A R A M E T R E Z    I C I      (Partie 1) allez à la partie 2 pour paramètrer la ville Ici la ville est Cannes
//Changez les valeurs pour adapter aux couleur de votre site

$police="verdana";
$taille="-2";
$color='#000000';
$color1="#999999";
$color2="#ffffff";//Coloris de $texte
$width='90%'; //Taille de la table
$border='0';  //Bord de la table 0 = non 1 = oui
$bordercolor='#999999'; //Couleur du bord de la table
$cellspacing='5';// Espacement dans la table horzontal
$cellpadding='5';
$texte='Ephéméride';
$retour='';
$entete="Saint du jour";
$entete2="Dicton du jour";



//F I N  D E         P A R A M E T R A G E


$gmt= 0;
$hiver = -2;
?>
 <SCRIPT LANGUAGE=JavaScript>

ejs_server_date = new Date(0,0,0,<?php echo $paris = date("H, i, s", time()+$gmt*3600); ?>)
ejs_server_heu = ejs_server_date.getHours();

ejs_server_min = ejs_server_date.getMinutes();
ejs_server_sec = ejs_server_date.getSeconds();

function ejs_server_calc()
{
if (ejs_server_sec < 10)
        ejs_server_sec = "0"+Math.round(ejs_server_sec);
else if(ejs_server_sec >= 60)
        {
        ejs_server_sec = "00";
        ejs_server_min++;
        }
if (ejs_server_min < 10)
        ejs_server_min = "0"+Math.round(ejs_server_min);
else if(ejs_server_min >= 60)
        {
        ejs_server_min = "00";
        ejs_server_heu++;
        }





if (ejs_server_heu < 10)
        ejs_server_heu = "0"+Math.round(ejs_server_heu);
else if(ejs_server_heu >= 24)
        {
        ejs_server_heu = "00";
        }




ejs_server_texte = ejs_server_heu + ":" + ejs_server_min + ":" + ejs_server_sec;

if (document.getElementById){
        document.getElementById("ejs_server_heure").innerHTML=ejs_server_texte;
        }



ejs_server_sec++;
}
setInterval("ejs_server_calc()", 1000);
</script>

<SCRIPT LANGUAGE=JavaScript>

ejs_server_date2 = new Date(0,0,0,<?php echo $anchorage = date("H,i,s", time()+$gmt-9*3600); ?>)
ejs_server_heu2 = ejs_server_date2.getHours();

ejs_server_min2 = ejs_server_date2.getMinutes();
ejs_server_sec2 = ejs_server_date2.getSeconds();

function ejs_server_calc2()
{
if (ejs_server_sec2 < 10)
        ejs_server_sec2 = "0"+Math.round(ejs_server_sec2);
else if(ejs_server_sec2 >= 60)
        {
        ejs_server_sec2 = "00";
        ejs_server_min2++;
        }
if (ejs_server_min2 < 10)
        ejs_server_min2 = "0"+Math.round(ejs_server_min2);
else if(ejs_server_min2 >= 60)
        {
        ejs_server_min2 = "00";
        ejs_server_heu2++;
        }





if (ejs_server_heu2 < 10)
        ejs_server_heu2 = "0"+Math.round(ejs_server_heu2);
else if(ejs_server_heu2 >= 24)
        {
        ejs_server_heu2 = "00";
        }




ejs_server_texte2 = ejs_server_heu2 + ":" + ejs_server_min2 + ":" + ejs_server_sec2;

if (document.getElementById){
        document.getElementById("ejs_server_heure2").innerHTML=ejs_server_texte2;
        }



ejs_server_sec2++;
}
setInterval("ejs_server_calc2()", 1000);
</script>


<SCRIPT LANGUAGE=JavaScript>

ejs_server_date3 = new Date(0,0,0,<?php echo $losangeles = date("H,i,s", time()+$gmt-8*3600); ?>)
ejs_server_heu3 = ejs_server_date3.getHours();

ejs_server_min3 = ejs_server_date3.getMinutes();
ejs_server_sec3 = ejs_server_date3.getSeconds();

function ejs_server_calc3()
{
if (ejs_server_sec3 < 10)
        ejs_server_sec3 = "0"+Math.round(ejs_server_sec3);
else if(ejs_server_sec3 >= 60)
        {
        ejs_server_sec3 = "00";
        ejs_server_min3++;
        }
if (ejs_server_min3 < 10)
        ejs_server_min3 = "0"+Math.round(ejs_server_min3);
else if(ejs_server_min3 >= 60)
        {
        ejs_server_min3 = "00";
        ejs_server_heu3++;
        }





if (ejs_server_heu3 < 10)
        ejs_server_heu3 = "0"+Math.round(ejs_server_heu3);
else if(ejs_server_heu3 >= 24)
        {
        ejs_server_heu3 = "00";
        }




ejs_server_texte3 = ejs_server_heu3 + ":" + ejs_server_min3 + ":" + ejs_server_sec3;

if (document.getElementById){
        document.getElementById("ejs_server_heure3").innerHTML=ejs_server_texte3;
        }



ejs_server_sec3++;
}
setInterval("ejs_server_calc3()", 1000);
</script>


<SCRIPT LANGUAGE=JavaScript>

ejs_server_date4 = new Date(0,0,0,<?php echo $newyork = date("H,i,s", time()+$gmt-5*3600); ?>)
ejs_server_heu4 = ejs_server_date4.getHours();

ejs_server_min4 = ejs_server_date4.getMinutes();
ejs_server_sec4 = ejs_server_date4.getSeconds();

function ejs_server_calc4()
{
if (ejs_server_sec4 < 10)
        ejs_server_sec4 = "0"+Math.round(ejs_server_sec4);
else if(ejs_server_sec4 >= 60)
        {
        ejs_server_sec4 = "00";
        ejs_server_min4++;
        }
if (ejs_server_min4 < 10)
        ejs_server_min4 = "0"+Math.round(ejs_server_min4);
else if(ejs_server_min4 >= 60)
        {
        ejs_server_min4 = "00";
        ejs_server_heu4++;
        }





if (ejs_server_heu4 < 10)
        ejs_server_heu4 = "0"+Math.round(ejs_server_heu4);
else if(ejs_server_heu4 >= 24)
        {
        ejs_server_heu4 = "00";
        }




ejs_server_texte4 = ejs_server_heu4 + ":" + ejs_server_min4 + ":" + ejs_server_sec4;

if (document.getElementById){
        document.getElementById("ejs_server_heure4").innerHTML=ejs_server_texte4;
        }



ejs_server_sec4++;
}
setInterval("ejs_server_calc4()", 1000);
</script>

<SCRIPT LANGUAGE=JavaScript>

ejs_server_date5 = new Date(0,0,0,<?php echo $moscou = date("H,i,s", time()+$gmt+3*3600); ?>)
ejs_server_heu5 = ejs_server_date5.getHours();

ejs_server_min5 = ejs_server_date5.getMinutes();
ejs_server_sec5 = ejs_server_date5.getSeconds();

function ejs_server_calc5()
{
if (ejs_server_sec5 < 10)
        ejs_server_sec5 = "0"+Math.round(ejs_server_sec5);
else if(ejs_server_sec5 >= 60)
        {
        ejs_server_sec5 = "00";
        ejs_server_min5++;
        }
if (ejs_server_min5 < 10)
        ejs_server_min5 = "0"+Math.round(ejs_server_min5);
else if(ejs_server_min5 >= 60)
        {
        ejs_server_min5 = "00";
        ejs_server_heu5++;
        }





if (ejs_server_heu5 < 10)
        ejs_server_heu5 = "0"+Math.round(ejs_server_heu5);
else if(ejs_server_heu5 >= 24)
        {
        ejs_server_heu5 = "00";
        }




ejs_server_texte5 = ejs_server_heu5 + ":" + ejs_server_min5 + ":" + ejs_server_sec5;

if (document.getElementById){
        document.getElementById("ejs_server_heure5").innerHTML=ejs_server_texte5;
        }



ejs_server_sec5++;
}
setInterval("ejs_server_calc5()", 1000);
</script>

<SCRIPT LANGUAGE=JavaScript>

ejs_server_date6 = new Date(0,0,0,<?php echo $pekin = date("H,i,s", time()+$gmt+8*3600); ?>)
ejs_server_heu6 = ejs_server_date6.getHours();

ejs_server_min6 = ejs_server_date6.getMinutes();
ejs_server_sec6 = ejs_server_date6.getSeconds();

function ejs_server_calc6()
{
if (ejs_server_sec6 < 10)
        ejs_server_sec6 = "0"+Math.round(ejs_server_sec6);
else if(ejs_server_sec6 >= 60)
        {
        ejs_server_sec6 = "00";
        ejs_server_min6++;
        }
if (ejs_server_min6 < 10)
        ejs_server_min6 = "0"+Math.round(ejs_server_min6);
else if(ejs_server_min6 >= 60)
        {
        ejs_server_min6 = "00";
        ejs_server_heu6++;
        }





if (ejs_server_heu6 < 10)
        ejs_server_heu6 = "0"+Math.round(ejs_server_heu6);
else if(ejs_server_heu6 >= 24)
        {
        ejs_server_heu6 = "00";
        }




ejs_server_texte6 = ejs_server_heu6 + ":" + ejs_server_min6 + ":" + ejs_server_sec6;

if (document.getElementById){
        document.getElementById("ejs_server_heure6").innerHTML=ejs_server_texte6;
        }



ejs_server_sec6++;
}
setInterval("ejs_server_calc6()", 1000);
</script>

<SCRIPT LANGUAGE=JavaScript>

ejs_server_date7 = new Date(0,0,0,<?php echo $tokyo = date("H,i,s", time()+$gmt+9*3600); ?>)
ejs_server_heu7 = ejs_server_date7.getHours();

ejs_server_min7 = ejs_server_date7.getMinutes();
ejs_server_sec7 = ejs_server_date7.getSeconds();

function ejs_server_calc7()
{
if (ejs_server_sec7 < 10)
        ejs_server_sec7 = "0"+Math.round(ejs_server_sec7);
else if(ejs_server_sec7 >= 60)
        {
        ejs_server_sec7 = "00";
        ejs_server_min7++;
        }
if (ejs_server_min7 < 10)
        ejs_server_min7 = "0"+Math.round(ejs_server_min7);
else if(ejs_server_min7 >= 60)
        {
        ejs_server_min7 = "00";
        ejs_server_heu7++;
        }





if (ejs_server_heu7 < 10)
        ejs_server_heu7 = "0"+Math.round(ejs_server_heu7);
else if(ejs_server_heu7 >= 24)
        {
        ejs_server_heu7 = "00";
        }




ejs_server_texte7 = ejs_server_heu7 + ":" + ejs_server_min7 + ":" + ejs_server_sec7;

if (document.getElementById){
        document.getElementById("ejs_server_heure7").innerHTML=ejs_server_texte7;
        }



ejs_server_sec7++;
}
setInterval("ejs_server_calc7()", 1000);
</script>


<SCRIPT LANGUAGE=JavaScript>

ejs_server_date8 = new Date(0,0,0,<?php echo $sydney = date("H,i,s", time()+$gmt+10*3600); ?>)
ejs_server_heu8 = ejs_server_date8.getHours();

ejs_server_min8 = ejs_server_date8.getMinutes();
ejs_server_sec8 = ejs_server_date8.getSeconds();

function ejs_server_calc8()
{
if (ejs_server_sec8 < 10)
        ejs_server_sec8 = "0"+Math.round(ejs_server_sec8);
else if(ejs_server_sec8 >= 60)
        {
        ejs_server_sec8 = "00";
        ejs_server_min8++;
        }
if (ejs_server_min8 < 10)
        ejs_server_min8 = "0"+Math.round(ejs_server_min8);
else if(ejs_server_min8 >= 60)
        {
        ejs_server_min8 = "00";
        ejs_server_heu8++;
        }





if (ejs_server_heu8 < 10)
        ejs_server_heu8 = "0"+Math.round(ejs_server_heu8);
else if(ejs_server_heu8 >= 24)
        {
        ejs_server_heu8 = "00";
        }




ejs_server_texte8 = ejs_server_heu8 + ":" + ejs_server_min8 + ":" + ejs_server_sec8;

if (document.getElementById){
        document.getElementById("ejs_server_heure8").innerHTML=ejs_server_texte8;
        }



ejs_server_sec8++;
}
setInterval("ejs_server_calc8()", 1000);
</script>


<SCRIPT LANGUAGE=JavaScript>

ejs_server_date9 = new Date(0,0,0,<?php echo $casablanca= date("H,i,s", time()+$gmt*3600); ?>)
ejs_server_heu9 = ejs_server_date9.getHours();

ejs_server_min9 = ejs_server_date9.getMinutes();
ejs_server_sec9 = ejs_server_date9.getSeconds();

function ejs_server_calc9()
{
if (ejs_server_sec9 < 10)
        ejs_server_sec9 = "0"+Math.round(ejs_server_sec9);
else if(ejs_server_sec9 >= 60)
        {
        ejs_server_sec9 = "00";
        ejs_server_min9++;
        }
if (ejs_server_min9 < 10)
        ejs_server_min9 = "0"+Math.round(ejs_server_min9);
else if(ejs_server_min9 >= 60)
        {
        ejs_server_min9 = "00";
        ejs_server_heu9++;
        }





if (ejs_server_heu9 < 10)
        ejs_server_heu9 = "0"+Math.round(ejs_server_heu9);
else if(ejs_server_heu9 >= 24)
        {
        ejs_server_heu9 = "00";
        }




ejs_server_texte9 = ejs_server_heu9 + ":" + ejs_server_min9 + ":" + ejs_server_sec9;

if (document.getElementById){
        document.getElementById("ejs_server_heure9").innerHTML=ejs_server_texte9;
        }



ejs_server_sec9++;
}
setInterval("ejs_server_calc9()", 1000);
</script>
<table width="1200" height="40" cellpadding="0" border="0">
<tr>
<td   bgcolor="#999999" align="middle"><font  face=<?php echo '".$police."';?> size=<?php echo'".$taille."';?> color=<?php echo'".$color2."';?>>Paris </td>
<td  bgcolor="#999999" align="middle"><font  face=<?php echo '".$police."';?> size=<?php echo'".$taille."';?> color=<?php echo'".$color2."';?>>Anchorage </td>
<td  bgcolor="#999999" align="middle"><font  face=<?php echo '".$police."';?> size=<?php echo'".$taille."';?> color=<?php echo'".$color2."';?>>Los Angeles </td>
<td  bgcolor="#999999" align="middle"><font  face=<?php echo '".$police."';?> size=<?php echo'".$taille."';?> color=<?php echo'".$color2."';?>>New York </td>
<td  bgcolor="#999999" align="middle"><font  face=<?php echo '".$police."';?> size=<?php echo'".$taille."';?> color=<?php echo'".$color2."';?>>Moscou </td>
<td  bgcolor="#999999" align="middle"><font  face=<?php echo '".$police."';?> size=<?php echo'".$taille."';?> color=<?php echo'".$color2."';?>>Pekin </td>
<td  bgcolor="#999999" align="middle"><font  face=<?php echo '".$police."';?> size=<?php echo'".$taille."';?> color=<?php echo'".$color2."';?>>Tokyo </td>
<td  bgcolor="#999999" align="middle"><font  face=<?php echo '".$police."';?> size=<?php echo'".$taille."';?> color=<?php echo'".$color2."';?>>Sydney </td>
<td  bgcolor="#999999" align="middle"><font  face=<?php echo '".$police."';?> size=<?php echo'".$taille."';?> color=<?php echo'".$color2."';?>>Casablanca </td>

</tr><tr>
<td align="middle"><font  face=<?php echo '".$police."';?> size=<?php echo'".$taille."';?> color=<?php echo'".$color2."';?>><div id=ejs_server_heure></div></td>
<td align="middle"><font  face=<?php echo '".$police."';?> size=<?php echo'".$taille."';?> color=<?php echo'".$color2."';?>><div id=ejs_server_heure2></div></td>
<td align="middle"><font  face=<?php echo '".$police."';?> size=<?php echo'".$taille."';?> color=<?php echo'".$color2."';?>><div id=ejs_server_heure3></div></td>
<td align="middle"><font  face=<?php echo '".$police."';?> size=<?php echo'".$taille."';?> color=<?php echo'".$color2."';?>><div id=ejs_server_heure4></div></td>
<td align="middle"><font  face=<?php echo '".$police."';?> size=<?php echo'".$taille."';?> color=<?php echo'".$color2."';?>><div id=ejs_server_heure5></div></td>
<td align="middle"><font  face=<?php echo '".$police."';?> size=<?php echo'".$taille."';?> color=<?php echo'".$color2."';?>><div id=ejs_server_heure6> </div></td>
<td align="middle"><font  face=<?php echo '".$police."';?> size=<?php echo'".$taille."';?> color=<?php echo'".$color2."';?>><div id=ejs_server_heure7></div></td>
<td align="middle"><font  face=<?php echo '".$police."';?> size=<?php echo'".$taille."';?> color=<?php echo'".$color2."';?>><div id=ejs_server_heure8></div></td>
<td align="middle"><font  face=<?php echo '".$police."';?> size=<?php echo'".$taille."';?> color=<?php echo'".$color2."';?>><div id=ejs_server_heure9></div></td>


</tr></table>