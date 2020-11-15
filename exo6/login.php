<?php
session_start();
include_once 'functions.php';
date_default_timezone_set('Europe/Paris');
$date = date('Y-m-d H-i-s');
$howManyConnexTime = date('Y-m-d H:i:s', strtotime('-10 minutes'));
$dateban = date('Y-m-d H:i:s', strtotime('-15 minutes'));
if(isset($_POST['submit'])){
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $isFillUsername = !empty($username);
    $isFillPassword = !empty($password);
    $isAllFill = $isFillUsername && $isFillPassword;
    $isValidUser = verifUser($username);
    $isUserBan = verifUserBan($username, $dateban);
    if(!$isUserBan) {
        if ($isAllFill) {
            if ($isValidUser) {
                $mdpH = getUserPass($username);
                $isValidMdp = password_verify($password, $mdpH);
                if ($isValidMdp) {
                    $_SESSION['email'] = $username;
                    header('location:home.php');
                } else {
                    createUserConn($username, $date);
                    $tryToConnect = howManyTries($username, $howManyConnexTime);
                    if ($tryToConnect >= 5) {
                        insertInBan($username, $date);
                        $err = 'Vous avez été banni pendant 15mn';
                    } else {
                        $err = 'Votre mot de passe est érroné';
                    }
                }
            } else {
                $err = 'Vous n\'êtes pas inscrit !';
            }
        } else {
            $err = 'Veuillez remplir tous les champs';
        }
    } else {
        $err = 'Vous avez été banni, veuillez patienter quelques minutes avant de vous reconnecter';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Sign in</title>
</head>
<body>
<?php include_once 'headerSimple.php' ?>

<div class="main">
    <p class="sign" align="center">Connexion</p>
    <form class="form1" action="" method="POST">
        <input class="un " type="text" align="center" name="username" placeholder="Entrer le mail d'utilisateur" value="<?php if(isset($email)){echo $email;}?>">
        <input class="pass" type="password" align="center" placeholder="Mot de passe" name="password">
        <input type="submit" class="submit" value='Se connecter' name="submit" align="center">
        <p class="forgot" align="center"><a href="resetpassword.php">Mot de passe oublié ?</p>
        <p class="forgot" align="center"><a href="signin.php">Pas encore inscrit ?</p>
    </form>
    <div style="color: #ff0000; padding: 10px;">
        <?php
        if (isset($err)){
            echo $err;
        }
        ?>
    </div>
</div>
<?php include_once 'footer.php' ?>
</body>
</html>