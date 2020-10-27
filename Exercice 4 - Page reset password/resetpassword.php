<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$bdd = new PDO('mysql:host=127.0.0.1;dbname=connexions', 'root', 'root');

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
<h3>Modif du mdp</h3>
<form method="post" action="">
    <div>
        <label for="mail">Entrez votre email :</label>
        <input type="email" name="email" value="<?php if(isset($_POST['email'])){echo $_POST['email'];}?>">
    </div>
    <div>
        <button type="submit" name="submit">Vérifier</button>
    </div>
</form>
</body>
</html>
<?php
if(isset($_POST['submit'])){
    include '.sendemail.php';

    $email = htmlspecialchars($_POST['email']);

    if(!empty($_POST['email']) && isset($_POST['email'])) {
        $verifUserEmail = $bdd->prepare("SELECT * FROM connexions WHERE email = ?");
        $verifUserEmail->execute(array($email));
        $userExistEmail = $verifUserEmail->rowCount();


        if ($userExistEmail >= 1) {
            send_mail('francoisdupont@yopmail.com', 'Test', 'Autre test');
            $erreurs = '<script>alert("Un mail vous a été envoyé afin de réinitialiser votre mot de passe")</script>';
        } else {
            $erreurs = '<script>alert("Vos identifiants sont incorrects")</script>';
        }
    } else {
        $erreurs = '<script>alert("Veuillez remplir le champs")</script>';
    }
}
if(isset($erreurs)){
    echo $erreurs;
}
?>

