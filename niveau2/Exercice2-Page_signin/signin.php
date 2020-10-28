<?php
$bdd = new PDO('mysql:host=127.0.0.1;dbname=espace_membre', 'root', '');

if(isset($_POST['forminscription']) && isset($_POST['cgu']) /*&& isset($_POST['nom']) && isset($_POST['prenom']) isset($_POST['email']) isset($_POST['mdp'])*/){

    $choix = $_POST['pro_or_not'];
    $cgu = $_POST['cgu'];
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    $email2 = htmlspecialchars($_POST['email2']);
    $mdp = sha1($_POST['mdp']);

 
    if(empty($nom) || empty($prenom) || empty($email) || empty($mdp)){

        $erreur = 'Vous devez remplir tous les champs';
    }
    if ($email != $email2){
         $erreur = 'Resaisissez votre adresse mail';
    } 
    if (!preg_match('@[A-Z]@', $mdp) && !preg_match('@[a-z]@', $mdp) && !preg_match('@[0-9]@', $mdp) && (strlen($mdp) >= 8)) {

        $erreur = 'Votre mot de passe doit être composé de 8 caractères, d\'au moins un chiffre et de lettres majuscules et minuscules';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){

        $erreur = 'Votre adresse mail n\'est pas valide';

    } else { 
        $reqmail = $bdd->prepare("SELECT * FROM utilisateurs WHERE email = ?");
	    $reqmail->execute(array($email));
        $mailexist = $reqmail->rowCount();
      
        if ($mailexist == 0){
            $insertmbr = $bdd->prepare("INSERT INTO utilisateurs(nom, prenom, email, mdp, is_pro_or_not) VALUES(?, ?, ?, ?, ?)");
            $insertmbr->execute(array($nom, $prenom, $email, $mdp, $choix));
            $erreur = "Votre compte a bien été créé !";
        } else{
            $erreur = 'Votre adresse email est déjà liée à un compte';
        }
    }
} else{
    $erreur = 'Veuillez cocher les cases appropriées';
}
?>
<!doctype html>
<html lang="fr">
<head>
    <title>EXO2 PHP</title>
    <meta charset="utf-8">
</head>
<body>
<div align="center">
    <h2>Inscription</h2>
    <br /><br />
    <form method="POST" action="">
        <table>
            <tr>
                <td align="right">
                    <label for="pseudo">Nom :</label>
                </td>
                <td>
                    <input type="text" placeholder="Votre nom" id="nom" name="nom" value="<?php if(isset($nom)) { echo $nom; } ?>" />
                </td>
            </tr>
            <tr>
                <td align="right">
                    <label for="mail">Prénom :</label>
                </td>
                <td>
                    <input type="text" placeholder="Votre prenom" id="prenom" name="prenom" value="<?php if(isset($prenom)) { echo $prenom; } ?>" />
                </td>
            </tr>
            <tr>
                <td align="right">
                    <label for="email">Mail :</label>
                </td>
                <td>
                    <input type="email" placeholder="Email" id="email" name="email" value="<?php if(isset($email)) { echo $email; } ?>" />
                </td>
            </tr>
            <tr>
                <td align="right">
                    <label for="email">Ressaisissez votre mail :</label>
                </td>
                <td>
                    <input type="email" placeholder="Verif email" id="email2" name="email2" value="<?php if(isset($email2)) { echo $email2; } ?>" />
                </td>
            </tr>
            <tr>
                <td align="right">
                    <label for="mdp">Mot de passe :</label>
                </td>
                <td>
                    <input type="password" placeholder="Votre mot de passe" id="mdp" name="mdp"/>
                </td>
            </tr>
            <tr>
                <td align="right">
                    <label for="pro">Professionnel :</label>
                    <input type="radio" id="pro" name="pro_or_not" value="1" checked>
                </td>
                <td>
                    <label for="pro">Particulier :</label>
                    <input type="radio" id="particulier" name="pro_or_not" value="2">
                </td>
            </tr>
            <tr>
                <td align="right">
                    <label for="pro">Conditions d'utilisation :</label>
                </td>
                <td>
                    <input type="checkbox" id="cgu" name="cgu">
                </td>
            </tr>
            <tr>
                <td></td>
                <td align="center">
                    <br />
                    <input type="submit" name="forminscription" value="Connexion" />
                </td>
            </tr>
        </table>
    </form>
    <?php
    if(isset($erreur)) {
        echo '<span color="red">'.$erreur."</span>";
    }
    ?>
</div>
</body>
</html>