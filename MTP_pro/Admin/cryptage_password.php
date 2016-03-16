<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<link rel="stylesheet" href="style.css"/>
<title>cryptage_passwords</title>
</head>

<body>
<header><header/>
<nav><nav/>
<section>
<?php
if (isset($_POST['login']) and isset($_POST['pass']))
{
$login = $_POST['login'];
$pass_crypte = crypt($_POST['pass']); // On crypte le mot depasse
echo ('Ligne à copier dans le htpasswd :<br />'.$login.':'.$pass_crypte.'<br/>');
}
else // On n'a pas encore rempli le formulaire
{
echo('
<p>Entrez votre login et votre mot de passe pour le crypter.</p><br/><br/><br/><br/><br/>
<form method="post" >
<p>
Login : <input type="text" name="login"><br />
Mot de passe : <input type="text" name="pass"><br /><br />
<input type="submit" value="Crypter !">
</p>
</form>
');
}
?>
<section/>
<footer><footer/>
</body>
</html>
