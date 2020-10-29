<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', '');

if(isset($_POST['submit'])){
    if(!empty($_POST['username']) && !empty($_POST['password'])){
        $mdp =  htmlspecialchars($_POST['password']);
        $mdpHash = password_hash($mdp, PASSWORD_DEFAULT);
        $email = htmlspecialchars($_POST['username']);

        if(filter_var($email, FILTER_VALIDATE_EMAIL)){

            $enterUser = $bdd->prepare("INSERT INTO `nouvelletable` ( `login`, `mdp`, `date`)VALUES ( ?, ?, NOW())");
            $enterUser->execute(array($email, $mdpHash));
            $err = 'Vos identifiants ont été inserés dans la base de donnée';
        } else {
            $err = "Votre adresse mail n'est pas valide";
        }
    } else {
        $err = 'Vous devez remplir tous les champs';
    }
} else {
    $err = 'Veuillez rentrer votre adresse mail et votre mot de passe';
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="POST">
        <h1>Connexion</h1>

        <label><b>Email :</b></label>
        <input type="text" placeholder="Entrer le mail d'utilisateur" name="username">

        <label><b>Mot de passe</b></label>
        <input type="password" placeholder="Entrer le mot de passe" name="password">

        <input type="submit" id='submit' value='LOGIN' name="submit">
        <?php
        if (isset($err)){
            echo '<br>';
            echo $err;
        }
        ?>
    </form>
</body>

</html>