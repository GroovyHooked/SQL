<?php
$bdd = new PDO('mysql:dbname=connexions;host=127.0.0.1;port=3306', 'root', 'root');

if(isset($_POST['forminscription'])){
    $choix = $_POST['pro_or_not'];
    $cgu = $_POST['cgu'];
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    $mdp = sha1($_POST['mdp']);

    if(empty($choix) || empty($cgu)) {
        $erreur = 'Vous devez cocher toutes les cases';

    } else if(empty($nom) || empty($prenom) || empty($email) || empty($mdp)){
            $erreur = 'Vous devez remplir tous les champs';
        } else{
            $insertMbre = $bdd->prepare("INSERT INTO utilisateur(nom, prenom, email, mdp) VALUES(?, ?, ?, ?)");
            $insertMbre->execute(array($nom, $prenom, $email, $mdp));
            $erreur = 'Votre compte a bien été crée';
        }


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
                    <input type="text" placeholder="Votre nom" id="nom" name="nom" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>" />
                </td>
            </tr>
            <tr>
                <td align="right">
                    <label for="mail">Prénom :</label>
                </td>
                <td>
                    <input type="text" placeholder="Votre prenom" id="prenom" name="prenom" value="<?php if(isset($mail)) { echo $mail; } ?>" />
                </td>
            </tr>
            <tr>
                <td align="right">
                    <label for="mail2">Mail :</label>
                </td>
                <td>
                    <input type="email" placeholder="Confirmez votre mail" id="email" name="email" value="<?php if(isset($mail2)) { echo $mail2; } ?>" />
                </td>
            </tr>
            <tr>
                <td align="right">
                    <label for="mdp">Mot de passe :</label>
                </td>
                <td>
                    <input type="password" placeholder="Votre mot de passe" id="mdp" name="mdp" />
                </td>
            </tr>
            <tr>
                <td align="right">
                    <label for="pro">Professionnel :</label>
                    <input type="radio" id="pro" name="pro_or_not">
                </td>
                <td>
                    <label for="pro">Particulier :</label>
                    <input type="radio" id="particulier" name="pro_or_not">
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