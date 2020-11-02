<?php
require '/Users/thomascariot/vendor/autoload.php';
use Medoo\Medoo;
include 'functions.php';
$pdo = new PDO('mysql:dbname=connexions;host=127.0.0.1;port=3306', 'root', 'root');
$bdd = new Medoo([
    // Initialized and connected PDO object
    'pdo' => $pdo,

    // [optional] Medoo will have different handle method according to different database type
    'database_type' => 'mysql'
]);
/* On récupère le token dans l'url */
$token = $_GET['email'];
echo $token .'<br>';
/* On récupère l'email lié au token */
$userMail = $bdd->select("ip","email", ["token" => $token]);
var_dump($userMail);

/* On lance le scipt au click */
if(isset($_POST['submit'])){
    $mdp1 = htmlspecialchars($_POST['mdp1']);
    $mdp2 = htmlspecialchars($_POST['mdp2']);
    /* Vérification du format de mdp */
    if(verificationPassword($mdp1)){
        /* Vérification de comparaison mdp */
        if ($mdp1 === $mdp2){

        } else {
            $err = 'Vos mots de passe ne sont pas similaire !';
        }
    } else {
        $err = 'Votre mot de passe n\'est pas dans un format valide';
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
    <div>
        <label><b>Saisisez un nouveau mot de passe :</b></label>
        <input type="text" placeholder="Entrer le mot de passe" name="mdp1">
    </div>
    <div>
        <label><b>Ressaisissez votre mot de passe :</b></label>
        <input type="text" placeholder="Entrer le mot de passe" name="mdp2">
    </div>
    <input type="submit" value='Envoyer' name="submit">
</form>
<?php
if(isset($err)){
    echo $err;
}
?>
</body>
</html>