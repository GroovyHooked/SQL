<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', '');

if(isset($_POST['submit'])){
    $isValidNom = !empty($_POST['nom']);
    $isValidPrenom = !empty($_POST['prenom']);
    $isValidMail = !empty($_POST['mail']);
    $isValidPass = !empty($_POST['password']);
    $isValidAll = $isValidNom && $isValidPrenom && $isValidMail && $isValidPass;

    if($isValidAll){
        $email = $_POST['mail'];
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            if(isset($_POST['cgu'])){
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $mail = $_POST['mail'];
                $mdp = $_POST['password'];
                $mdpHash = password_hash($mdp, PASSWORD_DEFAULT);

                $insertUser = $bdd->prepare('INSERT INTO `utilisateurs` (`nom`, `prenom`, `email`, `mdp`) VALUES ( ?, ?, ?, ?)');
                $insertUser->execute(array($nom, $prenom, $mail, $mdpHash));

                $err = 'Votre compte a été créé';
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
        <legend align="center"></legend>
    <form action="" method="POST" style="text-align: center;">
        <h1>Connexion</h1>
        <div>
        <label>Nom</label>
        <input type="text" placeholder="Entrer le nom d'utilisateur" name="nom" style="margin: 5px;">
        </div>
        <div>
        <label>Prénom</label>
        <input type="text" placeholder="Entrer le nom d'utilisateur" name="prenom" style="margin: 5px;">
        </div>
        <div>
        <label>Email</label>
        <input type="email" placeholder="Entrer le nom d'utilisateur" name="mail" style="margin: 5px;">
        </div>
        <div>
        <label>Mot de passe</label>
        <input type="password" placeholder="Entrer le mot de passe" name="password" style="margin: 5px;">
        </div>
        <div>
        Pro :<input type="radio" name="pro_or_not" value="1" checked>
        Particulier :<input type="radio" name="pro_or_not" value="0">    
        </div>   
        <div>
        <input type="checkbox" name="cgu">
        <label style="margin: 5px;">Conditions générales d'utilisateur</label>
        </div>
        <input type="submit" id='submit' value='LOGIN' name="submit" style="margin: 5px;">
        <?php
        if (isset($err)){
            echo '<br>';
            echo $err;
        }
        ?>
    </form>
    </fieldset>
</body>

</html>