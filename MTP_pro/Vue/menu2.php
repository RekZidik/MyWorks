<ul>
<a href="../index.php"><li> Acceuil</li></a>
<a href="../location_de_materiel.php"><li> Location de materiel </li></a>
<a href="../forum.php"><li> Forum </li></a>
<a href="../service_client.php"><li> Service cllient </li></a>
</ul>
<span id="date_heure" class="styling">
<span id="date">
<?php
include("auto_date.php");
?>
</span>
<span id="digitalclock" >
<script>
<!--

/*****************************************
* LCD Clock script- by Javascriptkit.com
* Featured on/available at http://www.dynamicdrive.com/
* This notice must stay intact for use
*****************************************/

var alternate=0
var standardbrowser=!document.all&&!document.getElementById

if (standardbrowser)
document.write('<form name="tick"><input type="text" name="tock" size="6"></form>')

function show(){
if (!standardbrowser)
var clockobj=document.getElementById? document.getElementById("digitalclock") : document.all.digitalclock
var Digital=new Date()
var hours=Digital.getHours()
var minutes=Digital.getMinutes()
var dn="AM"

if (hours==12) dn="PM" 
if (hours>12){
dn="PM"
hours=hours-12
}
if (hours==0) hours=12
if (hours.toString().length==1)
hours="0"+hours
if (minutes<=9)
minutes="0"+minutes

if (standardbrowser){
if (alternate==0)
document.tick.tock.value=hours+" : "+minutes+" "+dn
else
document.tick.tock.value=hours+"   "+minutes+" "+dn
}
else{
if (alternate==0)
clockobj.innerHTML=hours+"<font color='white'> : </font>"+minutes+" "+"<sup style='font-size:1px'>"+dn+"</sup>"
else
clockobj.innerHTML=hours+"<font color='black'> : </font>"+minutes+" "+"<sup style='font-size:1px'>"+dn+"</sup>"
}
alternate=(alternate==0)? 1 : 0
setTimeout("show()",1000)
}
window.onload=show

//-->
</script>
</span>
</span>
