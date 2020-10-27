<?php
$bdd = new PDO('mysql:host=127.0.0.1;dbname=connexions', 'root', 'root');

if(isset($_POST['submit'])){
    $mdp1 = htmlspecialchars($_POST['mdp1']);
    $mdp2 = htmlspecialchars($_POST['mdp2']);
    if(!empty($mdp1) && !empty($mdp2)){
        if($mdp1 === $mdp2){

        } else {
            $error = 'Les mdp rentrés ne sont pas similaire !';
        }
    } else {
        $error = 'Vous devez remplir tous les champs';
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
    <title>Document</title>
</head>
<body>
<h3>Modification du mot de passe</h3>
<form action="" method="post">
    <div>
        <label for="mdp1">Entrez votre nouveau mot de passe : </label>
        <input name="mdp1" id="mdp1" type="text">
    </div>
    <div>
        <label for="mdp2">Entrez une seconde fois votre nouveau mot de passe : </label>
        <input name="mdp2" id="mdp2" type="password">
    </div>
    <div>
        <button type="submit" name="submit">Envoyer</button>
    </div>
</form>
</body>
</html>
<?php
if(isset($error)){
    echo '<strong style="color:red;">' . $error . '</strong>';
}
?>