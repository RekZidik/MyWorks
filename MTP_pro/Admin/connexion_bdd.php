<?php
try
{
$bdd = new PDO('mysql:host=localhost;dbname=mtp', 'root', '');
}
catch(Exception $e)
{
die('Erreur : '.$e->getMessage());
}
