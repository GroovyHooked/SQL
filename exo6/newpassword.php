
<?php
session_start();
include 'functions.php';
date_default_timezone_set('Europe/Paris');
if(isset($_SESSION['token'])) {
    /* On récupère le token dans l'url */
    $token = $_GET['email'];
    /* On récupère l'email lié au token */
    $userMail = getUserMailToken($token);
    /* On vérifie que le hash a été enregistré depuis un certain temp */
    $dateHash = date('Y-m-d H:i:s', strtotime('-15 minutes'));
    $verifUserReset = verifHashTime($userMail, $dateHash);
    /* Si le hash a été enregistré pdt la periode voulue */
    if($verifUserReset > 0 ) {
        /* On récupère le nom de l'utilisateur */
        $userName = getNameUtilisateurs($userMail);
        /* On lance le scipt au click */
        if (isset($_POST['submit'])) {
            $mdp1 = htmlspecialchars($_POST['mdp1']);
            $mdp2 = htmlspecialchars($_POST['mdp2']);
            /* Vérification du format de mdp */
            if (verifPass($mdp1)) {
                /* Vérification de comparaison mdp */
                if ($mdp1 === $mdp2) {
                    $newPass = password_hash($mdp1, PASSWORD_DEFAULT);
                    /* On modifie le mot de passe dans la bdd */
                    mofidPassUtilisateurs($userMail, $newPass);
                    $err = '<p>Vous avez changé votre mot de passe, veuillez vous rendre sur <a href="login.php">la page de login</a> pour vous reconnecter</p>';
                } else {
                    $err = '<p>Vos mots de passe ne sont pas similaire !</p>';
                }
            } else {
                $err = '<p>Votre mot de passe n\'est pas dans un format valide</p>';
            }
        }
    } else {
        $err = "<p>Vous avez dépassé le délais requis pour changer de mot de passe, veuillez recommencer la procédure.</p>";
        $_SESSION['err'] = "<p>Vous avez dépassé le délais requis pour changer de mot de passe, veuillez recommencer la procédure .</p>";
        // header('Location:resetpassword.php');
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
    <title>Modification de mot de passe</title>
    <style>
        h3{
            margin-bottom: 20px;
            color: rgb(74, 78, 105);
        }
        label{
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
            margin: 10px auto;
        }
        .send{
            margin-top: 20px;
        }
        .erreur{
            margin: 0 auto;
            height: 50%;
            width: 40%;
        }
    </style>
</head>
<body>
<?php include 'headerSimple.php'?>
<form action="" method="post">
    <h3>Modification du mot de passe</h3>
    <div>
        <label><b>Saisisez un nouveau mot de passe :</b></label>
        <input type="text" placeholder="Entrer le mot de passe" name="mdp1">
    </div>
    <div>
        <label><b>Ressaisissez votre mot de passe :</b></label>
        <input type="text" placeholder="Entrer le mot de passe" name="mdp2">
    </div>
    <input type="submit" value='Envoyer' name="submit" class="send">
</form>
<div class="erreur">
    <?php
    if(isset($err)){
        echo $err;
    }
    ?>
</div>
<?php include 'footer.php'?>
</body>
</html>

