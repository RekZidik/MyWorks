<?php
$magik1=date("n");$magik2=date("Y");$magik3=date("w", mktime(0,0,0,$magik1,1,$magik2));
$magik4=date("t");$magik6=date("d");
$magik1e=array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aout", "Septembre","Octobre","Novembre","Décembre");
if ($magik3==0) {$magik3=7;}
echo"<table border=0 style='font-size:8pt;font-family:verdana,arial,tahoma'>\n
<th colspan=7 align=center>".$magik1e[$magik1-1]." ".$magik2."</th>
<tr>\n<td>Lu</td><td>Ma</td><td>Me</td><td>Je</td><td>Ve</td><td>Sa</td><td>Di</td></tr>\n<tr>\n";
$i=1;while ($i<$magik3) { echo "<td>&nbsp;</td>";$i++; }
$i=1;while ($i<=$magik4){
$magik5=($i+$magik3-1)%7;
echo"<td>";
if ($i==$magik6) { echo"<span style='color:#ffffff; background-color:#0000ff;font-size:8pt;font-family:verdana,arial,tahoma'>$i</span>"; }
else if ($magik5==0) { echo"<span style='color:#ff0000;font-size:9pt;font-family:verdana,arial,tahoma'>$i</span>"; }
else { echo "$i"; }
echo"</td>\n";
if ($magik5==0) { echo "</tr>\n<tr>\n"; }
$i++;}
echo"</tr></td></table>\n";
?>