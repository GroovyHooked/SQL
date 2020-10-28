<?php
session_start();
error_reporting(E_ALL ^ E_DEPRECATED);
$bdd = new PDO('mysql:host=127.0.0.1;dbname=espace_membre', 'root', '');
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
<form method="get" action="">
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
if(isset($_GET['submit'])){

    include 'sendemail.php'; 

    // $adresse = $_SERVER['HTTP_REFERER'];
    $email = htmlspecialchars($_GET['email']);
  

    /*Si les champs sont remplis */
    if(!empty($_GET['email']) && isset($_GET['email'])) {

        /* On interoge la bdd pour savoir si l'utilisateur existe */ 
        $verifUserEmail = $bdd->prepare("SELECT * FROM connexions WHERE email = ?");
        $verifUserEmail->execute(array($email));
        $userExistEmail = $verifUserEmail->rowCount();

        /* On crée une url personnalisée */ 
        $assamblageAdr = 'http://localhost/SQL/B-Niveau-II/Exercice4-Page_reset_password/newpassword.php?email=';
        $emailHashe = hash('sha1', $email);
        $reelAdress = $assamblageAdr. urlencode($emailHashe);

        /* si il existe */
        if ($userExistEmail >= 1) {
            echo $reelAdress;

            /*Insertion du hash + date dans la bdd */
            $insertHash = $bdd->prepare("UPDATE connexions SET hash = '$emailHashe', dateHash = NOW() WHERE email = '$email'");
            $insertHash->execute(array());

            /* Préparation du mail */
            $subject = 'Réinitialisation du mot de passe';
            $body = "Voici le lien de réinitialisation : ". $reelAdress ;

            /* Envoi du mail  */
            send_mail('thomascariot@gmail.com', $subject, $body);
            $erreurs = '<script>alert("Un mail vous a été envoyé afin de réinitialiser votre mot de passe")</script>';
            $_SESSION['mailHash'] = $emailHashe;

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