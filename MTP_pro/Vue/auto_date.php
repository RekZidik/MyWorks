<?php
$date = getdate();

$jour{0} = "Dimanche";
$jour{1} = "Lundi";
$jour{2} = "Mardi";
$jour{3} = "Mercredi";
$jour{4} = "Jeudi";
$jour{5} = "Vendredi";
$jour{6} = "Samedi";

$mois{1} = "Janvier";
$mois{2} = "Février";
$mois{3} = "Mars";
$mois{4} = "Avril";
$mois{5} = "Mai";
$mois{6} = "Juin";
$mois{7} = "Juillet";
$mois{8} = "Août";
$mois{9} = "Septembre";
$mois{10} = "Octobre";
$mois{11} = "Novembre";
$mois{12} = "Décembre";

// Le jour de la semaine
$jrsem = $jour{$date['wday']};

// Le jour du mois
$jour = $date['mday'];

// Le mois de l'année
$mois = $mois{$date['mon']};

// L'année
$annee = $date['year'];

// La date complète

echo($jrsem.'.'. $jour.'.'. $mois.'.'. $annee);
?>

