<?php
session_start();
require_once 'functions.php';
date_default_timezone_set('Europe/Paris');
$date = date('Y-m-d H-i-s');
if(isset($_SESSION['id'])){
$infoUser = getUserInfos($_SESSION['id']);

    if(isset($_POST['submit1'])){
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $email = htmlspecialchars($_POST['email']);
        $pro_or_not = htmlspecialchars($_POST['pro_or_not']);
        $mdp = htmlspecialchars($_POST['mdp']);
        $id = $_SESSION['id'];
        if(empty($mdp)){
            updateUser($id, $nom, $prenom, $email, $pro_or_not, $date);
            header('location:home.php');
        } else {
            updateUserPass($id, $nom, $prenom, $email, $pro_or_not, $mdp, $date);
            header('location:home.php');
        }
    }
    if(isset($_POST['submit4'])){
        header('location:home.php');
    }
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
<?php include "header.php"; ?>
<form action="" method="post">
<table class="formUser">
    <thead class="formUser">
    <tr class="formUser">
        <th class="formUser">Nom</th>
        <th class="formUser">Prenom</th>
        <th class="formUser">Email</th>
        <th class="formUser">Pro & Par</th>
        <th class="formUser">Mot de passe</th>
        <th class="formUser"></th>
    </tr>
    </thead>
    <tbody class="formUser">
    <tr class="formUser">
        <td class="formUser"><input type="text" name="nom" value="<?=$infoUser['nom']?>"></td>
        <td class="formUser"><input type="text" name="prenom" value="<?=$infoUser['prenom']?>"></td>
        <td class="formUser"><input type="text" name="email" value="<?=$infoUser['email']?>"></td>
        <td class="formUser"><input type="text" name="pro_or_not" value="<?=$infoUser['pro_or_not']?>"></td>
        <td class="formUser"><input type="text" name="mdp" value=""></td>
        <td >
            <input class="formUser" type="submit" value="Modifier" name="submit1">
            <input class="formUser" type="submit" value="Annuler" name="submit4">
        </td>
    </tr>
    </tbody>
</table>
</form>
<?php include "footer.php"; ?>
</body>
</html>
<?php } else {
    if(isset($_POST['submit2'])){
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $email = htmlspecialchars($_POST['email']);
        $pro_or_not = htmlspecialchars($_POST['pro_or_not']);
        $mdp = htmlspecialchars($_POST['mdp']);
        createUserUtil($nom, $prenom, $email, $pro_or_not, $mdp, $date);
        header('location:home.php');
    }
    if(isset($_POST['submit3'])){
        header('location:home.php');
    }
    ?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
<?php include "header.php"; ?>
<form action="" method="post">
<table class="formUser">
    <thead class="formUser">
    <tr class="formUser">
        <th class="formUser">Nom</th>
        <th class="formUser">Prenom</th>
        <th class="formUser">Email</th>
        <th class="formUser">Pro & Par</th>
        <th class="formUser">Mot de passe</th>
        <th class="formUser">Action</th>
    </tr>
    </thead>
    <tbody>
    <tr class="formUser">
        <th class="formUser"><input type="text" name="nom"></th>
        <th class="formUser"><input type="text" name="prenom"></th>
        <th class="formUser"><input type="text" name="email"></th>
        <th class="formUser"><input type="text" name="pro_or_not"></th>
        <th class="formUser"><input type="text" name="mdp"></th>
        <th ><input class="formUser" type="submit" value="Créer" name="submit2">
        <input class="formUser" type="submit" value="Annuler" name="submit3"></th>
    </tr>
    </tbody>
</table>
</form>
<?php include "footer.php"; ?>
</body>
</html>
<?php }
