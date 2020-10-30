<?php
session_start();
include 'functions.php';
$bdd = new PDO('mysql:dbname=espace_membre;host=localhost', 'root', 'root');

/* On démarre le script */
if(isset($_POST['submit'])){
    $isValidNom = !empty($_POST['nom']);
    $isValidPrenom = !empty($_POST['prenom']);
    $isValidMail = !empty($_POST['mail']);
    $isValidPass = !empty($_POST['password']);
    $isValidAll = $isValidNom && $isValidPrenom && $isValidMail && $isValidPass;

    $mdp = htmlspecialchars($_POST['password']);
    $mdp2 = htmlspecialchars($_POST['password2']);

    /* Si tous les champs sont remplis */
    if($isValidAll){
        $email = $_POST['mail'];
        /* Si le format d'adrese mail est valide  */
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            /* Si les conditions d'utilisateurs ont été acceptées */
            if(isset($_POST['cgu'])){
                /* Si les mdp de passe sont identiques */
                if($mdp == $mdp2) {
                    /* Si le mdp est dans un format valide (voir fonction dans functions) */
                    if (verificationPassword($mdp)) {
                        $nom = htmlspecialchars($_POST['nom']);
                        $prenom = htmlspecialchars($_POST['prenom']);
                        $mail = htmlspecialchars($_POST['mail']);
                        $pro_or_not = $_POST['pro_or_not'];
                        $mdpHash = password_hash($mdp, PASSWORD_DEFAULT);
                        /* On intérroge la table utilisateur pour savoir si l'utilisateur existe */
                        $verifMailQuery = $bdd->prepare('SELECT * FROM utilisateurs WHERE email = ?');
                        $verifMailQuery->execute(array($mail));
                        $mailExist = $verifMailQuery->rowCount();
                        /* Si l'utilisateur n'est pas encore inscrit */
                        if($mailExist < 1){
                            /* On inscrit l'utilisateur dans la bdd */
                            $insertUser = $bdd->prepare('INSERT INTO `utilisateurs` (`nom`, `prenom`, `email`, `mdp`, `pro_or_not`, `date`) VALUES ( ?, ?, ?, ?, ?, NOW())');
                            $insertUser->execute(array($nom, $prenom, $mail, $mdpHash, $pro_or_not));

                            $err = 'Votre compte a été créé';
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
    <title>Document</title>
</head>

<body>
    <fieldset>
        <legend align="center"><strong>Formulaire</strong></legend>
    <form action="" method="POST" style="text-align: center;">
        <h3>Inscription</h3>
        <div>
        <label>Nom</label>
        <input type="text" placeholder="Entrer le nom d'utilisateur" name="nom" style="margin: 5px;" value="<?php if(isset($nom)){echo $nom;} ?>">
        </div>
        <div>
        <label>Prénom</label>
        <input type="text" placeholder="Entrer le nom d'utilisateur" name="prenom" style="margin: 5px;" value="<?php if(isset($nom)){echo $prenom;} ?>">
        </div>
        <div>
        <label>Email</label>
        <input type="email" placeholder="Entrer le nom d'utilisateur" name="mail" style="margin: 5px;" value="<?php if(isset($nom)){echo $mail;} ?>">
        </div>
        <div>
        <label>Mot de passe</label>
        <input type="password" placeholder="8 caractères, 1 chiffre, 1 majuscule" name="password" style="margin: 5px;">
        </div>
        <div>
            <label>Ressaisissez votre mot de passe</label>
            <input type="password" placeholder="Entrer le mot de passe" name="password2" style="margin: 5px;">
        </div>
        <div>
        Pro :<input type="radio" name="pro_or_not" value="1" checked>
        Particulier :<input type="radio" name="pro_or_not" value="0">    
        </div>   
        <div>
        <input type="checkbox" name="cgu">
        <label style="margin: 5px;">Conditions générales d'utilisateur</label>
        </div>
        <input type="submit" id='submit' value='Inscription' name="submit" style="margin: 5px;">
        <?php
        if (isset($err)){
            echo '<br>';
            echo   $err;
        }
        ?>
    </form>
    </fieldset>
</body>

</html>