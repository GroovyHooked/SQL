<?php
session_start();
require_once 'functions.php';
if(isset($_POST['supp'])){
    eraseUserById($_POST['id']);
}
if(isset($_POST['modif'])){
    $_SESSION['id'] = $_POST['id'];
    //echo $_POST['id'];
    header('location:formuser.php');
}
if(isset($_POST['create'])){
    $_SESSION['id'] = null;
    header('location:formuser.php');
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
<?php include "header.php"; ?>
<body>
<h3 class="tableHome">Bonjour <?= $_SESSION['email'] ?></h3>

<table class="tableHome">
    <thead>
    <tr class="tableHome">
        <th class="tableHome">Nom</th>
        <th class="tableHome">Prenom</th>
        <th class="tableHome">Email</th>
        <th class="tableHome">Pro & Par</th>
        <th class="tableHome">Action</th>
    </tr>
    </thead>
    <tbody>
<?php
$datas = getAllInfos();
//var_dump($datas);
//echo '<br>';
foreach ($datas as $data){
?>
    <tr class="tableHome" class="tableHome">
        <td class="tableHome"><?= $data['nom'] ?></td>
        <td class="tableHome"><?= $data['prenom'] ?></td>
        <td class="tableHome"><?= $data['email'] ?></td>
        <td class="tableHome"><?= $data['pro_or_not'] ?></td>
        <td class="tableHome">
            <form action="" method="post" style="display: inline-block;">
                <input type="hidden" name="id" value="<?= $data['id'] ?>">
                <input type="submit" value="Supprimer" name="supp" class="button">
            </form>
            <form action="" method="post" style="display: inline-block;">
                <input type="hidden" name="id" value="<?= $data['id'] ?>">
                <input type="submit" value="Modifier" name="modif" class="button">
            </form>
        </td>
    </tr>
    <?php
}
?>
    </tbody>
</table>
<div>
    <form action="" method="post" class="tableHome">
        <input class="tableHome create" type="submit" value="Créer un nouvel utilisateur" name="create">
    </form>
</div>
<?php include "footer.php"; ?>
</body>
</html>

