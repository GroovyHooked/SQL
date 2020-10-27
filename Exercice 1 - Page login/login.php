<?php
$bdd = new PDO('mysql:dbname=connexions;host=127.0.0.1;port=3306', 'root', 'root');

if(isset($_POST['submit'])){
    $email = htmlspecialchars($_POST['email']);
    $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {

        if(!empty($mdp)){
            $insertMbre = $bdd->prepare("INSERT INTO connexions(email, mdp, date) VALUES(?, ?, NOW())");
            $insertMbre->execute(array($email, $mdp));
            $erreur = 'Votre compte a bien été crée';
        }
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
    <title>Exo 1</title>
</head>
<body>
<h3>Inscription</h3>
<form method="post" action="">
    <div>
        <label for="email">Mail : </label>
        <input type="text" name="email" value="<?php if(isset($email)) {echo $email;}?>">
    </div>
    <div>
        <label for="mdp">Mot de Passe : </label>
        <input type="text" name="mdp">
    </div>
    <div>
        <input type="submit" value="Soumettre" name="submit">
    </div>
</form>
</body>
</html>
<?php
if(!empty($erreurs)){
    echo '<p style="color:#ff0000;">' . $erreurs . '</p>';
}
?>
