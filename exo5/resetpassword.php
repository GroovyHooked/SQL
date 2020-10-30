<?php
//session_start();
include '/sendemail.php';
$bdd = new PDO('mysql:dbname=espace_membre;host=127.0.0.1;port=3306', 'root', 'root');
/* On lance le script */
if(isset($_POST['submit'])){
    $email = htmlspecialchars($_POST['email']);
    /* Si le format mail est valide */
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        /* On intéroge la base de donnée*/
        $verifUserQuery = $bdd->prepare('SELECT COUNT(*) FROM utilisateurs WHERE email = ?');
        $verifUserQuery->execute(array($email));
        $verifUser = $verifUserQuery->fetch(PDO::FETCH_ASSOC);

        /* Si l'utilisateur fait parti de la bdd*/
        if($verifUser["COUNT(*)"] > 0){
            $token = password_hash($email, PASSWORD_DEFAULT);
            $url = 'http://localhost/SQL/Module2/exo5/newpassword.php?email=';
            $urlComplete = $url . $token;
            $objet = 'Réinitialisation de mot de passe';
            $contenu = 'Veuillez vous rendre à cette adresse afin de réinitialiser votre mot de passe : ' . $urlComplete;
            send_mail($email, $objet, $contenu);
            $_SESSION['token'] = $token;

        } else {
            $err = "Vous n'etes pas inscrits, veuillez vous rendre sur http://localhost/SQL/Module2/exo5/signin.php pour vous inscrire.";
        }
    } else {
        $err = 'Votre adresse mail n\'est pas valide';
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modification de mot de passe</title>
</head>
<body>
<form action="" method="post">
<h3>Modification du mot de passe</h3>
    <h4>Saisissez votre adresse mail</h4>
<div>
    <label><b>Adresse mail :</b></label>
    <input type="text" placeholder="Entrer una adresse mail" name="email">
</div>
<div>
    <input type="submit" value='Envoyer' name="submit">
</div>
</form>
</body>
</html>
