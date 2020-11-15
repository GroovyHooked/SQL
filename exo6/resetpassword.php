<?php
session_start();
date_default_timezone_set('Europe/Paris');
include 'functions.php';
/* On lance le script au click */
if (isset($_POST['submit'])){
    $email = htmlspecialchars($_POST['email']);
    /* Si le format mail est valide */
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        /* on intérroge la bdd pour asvoir si l'utilisateur en fait parti */
        $verifUser = verifUser($email);
        /* Si l'utilisateur fait partie de la bdd */
        if($verifUser){
            $token = password_hash($email, PASSWORD_DEFAULT);
            $url = 'http://localhost/SQL/Module2/exo6/newpassword.php?email=';
            $urlComplete = $url . $token;
            $objet = 'Réinitialisation de mot de passe';
            $contenu = 'Veuillez vous rendre à cette adresse afin de réinitialiser votre mot de passe : ' . $urlComplete;
            $date  = date('Y-m-d H-i-s');
            /* On insère le token dans la bdd et on l'affecte à son email correspondant */
            insertInToken($token, $email, $date);

            $_SESSION['email'] = $email;
            $_SESSION['token'] = $token;
            header('Location:' . $urlComplete);
        } else {
            $err = 'Vous n\'êtes pas inscrit';
        }
    } else {
        $err = 'Votre email n\'est pas valide';
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
    <link rel="stylesheet" href="style.css">
    <title>Procédure de modification de mot de passe</title>
    <style>
        h3{
            margin-bottom: 50px;
            color: rgb(74, 78, 105);
        }
        h4, label{
            color: whitesmoke;
        }
        form{
            display: flex;
            height: 50%;
            width: 50%;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
        }
        div{
            margin: 20px auto;
        }
    </style>
</head>
<body>
<?php include 'headerSimple.php'?>
<form action="" method="post">
    <h3>Procédure de modification du mot de passe</h3>

    <h4>Saisissez votre adresse mail :</h4>
    <div>
        <label><b>Adresse mail :</b></label>
        <input type="text" placeholder="Entrer una adresse mail" name="email">
    </div>
    <div>
        <input type="submit" value='Envoyer' name="submit">
    </div>
</form>
<?php if(isset($err)){echo $err;} ?>
<?php if(isset($_SESSION['err'])){echo $_SESSION['err'];} ?>
<?php include 'footer.php'?>
</body>
</html>

