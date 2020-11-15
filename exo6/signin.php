<?php
session_start();
include 'functions.php';
date_default_timezone_set('Europe/Paris');
$date  = date('Y-m-d H-i-s');
/* On démarre le script */
if(isset($_POST['submit'])){
    $isValidNom = !empty($_POST['nom']);
    $isValidPrenom = !empty($_POST['prenom']);
    $isValidMail = !empty($_POST['mail']);
    $isValidPass = !empty($_POST['password']);
    $isValidAll = $isValidNom && $isValidPrenom && $isValidMail && $isValidPass;

    $mdp = htmlspecialchars($_POST['password']);
    $mdp2 = htmlspecialchars($_POST['password2']);
    $email = htmlspecialchars($_POST['mail']);
    /* Si tous les champs sont remplis */
    if($isValidAll){
        /* Si le format d'adrese mail est valide  */
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            /* Si les conditions d'utilisateurs ont été acceptées */
            if(isset($_POST['cgu'])){
                /* Si les mdp de passe sont identiques */
                if($mdp == $mdp2) {
                    /* Si le mdp est dans un format valide (voir fonction dans functions) */
                    if (verifPass($mdp)) {
                        $nom = htmlspecialchars($_POST['nom']);
                        $prenom = htmlspecialchars($_POST['prenom']);
                        $mail = htmlspecialchars($_POST['mail']);
                        $pro_or_not = $_POST['pro_or_not'];
                        $mdpHash = password_hash($mdp, PASSWORD_DEFAULT);
                        /* On intérroge la table utilisateur pour savoir si l'utilisateur existe */
                        $doesUserExist = verifUser($mail);
                        /* Si l'utilisateur n'est pas encore inscrit */
                        if(!$doesUserExist){
                            /* On inscrit l'utilisateur dans la bdd */
                            createUserUtil($nom, $prenom, $email, $pro_or_not, $mdpHash, $date);
                            $err = '<p>Votre compte a été créé</p><p>Connectez vous sur <span><a href="login.php">la page de connexion !</a></span></p>';
                        } else {
                            $err = 'Vous êtes déjà inscrit';
                        }
                    } else {
                        $err = 'Le mot de passe doit être composé de 8 caractères minimum, avoir au moins une lettre minuscule et majuscule et être composé d\'au moins un chiffre';
                    }
                } else {
                    $err = 'Vos mots de passe ne sont pas similaires';
                }
            } else {
                $err = 'Vous devez accepter les conditions générales d\'utilisateur';
            }
        } else {
            $err = 'Votre adresse mail n\'est pas valide';
        }
    } else {
        $err = 'Vous devez remplir tous les champs';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
<?php include "headerSimple.php"; ?>

    <form action="" method="POST" class="signin">
        <h3>Inscription</h3>
        <div class="form-group signin">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Nom</label>
            <div class="col-sm-12">
                <input type="text" class="form-control signin" placeholder="Nom" name="nom" value="<?php if(isset($nom)){echo $nom;} ?>">
            </div>
        </div>
        <div class="form-group signin">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Prenom</label>
            <div class="col-sm-12">
                <input type="text" class="form-control signin" placeholder="Prénom" name="prenom" value="<?php if(isset($prenom)){echo $prenom;} ?>">
            </div>
        </div>
        <div class="form-group signin">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-12">
                <input type="email" class="form-control signin" placeholder="Email" name="mail" value="<?php if(isset($email)){echo $email;} ?>">
            </div>
        </div>
        <div class="form-group signin">
            <label for="inputEmail3" class="col-sm-6 col-form-label">Mot de passe</label>
            <div class="col-sm-12">
                <input type="text" class="form-control signin" placeholder="Mot de passe" name="password" value="">
            </div>
        </div>
        <div class="form-group signin">
            <label for="inputEmail3" class="col-sm-6 col-form-label">Ressaisissez votre mot de passe</label>
            <div class="col-sm-12">
                <input type="text" class="form-control signin" placeholder="Mot de passe" name="password2" value="">
            </div>
        </div>
        <div class="form-check">
            <input class="form-check-input radio" type="radio" name="pro_or_not" id="" value="Professionnel" checked>
            <label class="form-check-label radio" for="exampleRadios1">
                Professionnel
            </label>
            <input class="form-check-input radio" type="radio" name="pro_or_not" id="" value="Particulier" >
            <label class="form-check-label radio" for="exampleRadios1">
                Particulier
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="check" name="cgu" >
            <label class="form-check-label" for="check">
                Conditions générales d'utilisateur
            </label>
        </div>

        <div class="form-group row signinB">
            <div class="col-sm-10 offset-sm-1">
                <button type="submit" class="btn btn-primary signinB" name="submit">Inscription</button>
            </div>
        </div>
        <div class="form-group row signinA">
            <div class="col-sm-10 offset-sm-1">
                <a href="login.php">Page de connexion</a>
            </div>
        </div>
        <?php
        if (isset($err)){
            echo '<br>';
            echo   $err;
        }
        ?>
    </form>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></script>
<?php include "footer.php"; ?>
</body>

</html>
