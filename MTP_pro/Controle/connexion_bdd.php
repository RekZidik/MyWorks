<?php
try
{
$bdd = new PDO('mysql:host=localhost;dbname=MTP', 'root', '');
}
catch(Exception $e)
{
die('Erreur : '.$e->getMessage());
}
