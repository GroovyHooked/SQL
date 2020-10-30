<?php
session_start();
$bdd = new PDO('mysql:dbname=espace_membre;host=127.0.0.1;port=3306', 'root', 'root');

/* On lance le script */
if(isset($_POST['submit'])){
    /* ON récupère les données*/
    $email = $_POST['username'];
    $mdp =  htmlspecialchars($_POST['password']);
    $mdpHash = password_hash($mdp, PASSWORD_DEFAULT);

    /* On vérifie que l'utilisateur n'a pas été banni */
    $verifUserBanniQuery = $bdd->query("SELECT COUNT(*) FROM `ban` WHERE `email` LIKE'$email'AND `date` > (now() - interval 15 minute )");
    $verifUserBanni = $verifUserBanniQuery->fetch(PDO::FETCH_ASSOC);

    /* Si l'utilisateur n'est pas banni */
    if($verifUserBanni["COUNT(*)"] == 0) {
        /* Si les champs sont remplis */
        if (!empty($_POST['username']) && !empty($_POST['password'])) {
            /* Si l'adresse mail est valide */
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                /* On récupère le mot de passe de l'utilisateur dans la bdd */
                $verifUser = $bdd->prepare("SELECT `mdp` FROM `utilisateurs` WHERE `email` = ?");
                $verifUser->execute(array($email));
                $userExist = $verifUser->fetch(PDO::FETCH_ASSOC);
                $mdpHashBdd = $userExist['mdp'];

                /* On vérifie le nombre de tentatives par l'utilisateur */
                $verifUserTryQuery = $bdd->query("SELECT COUNT(*) FROM `connexions` WHERE `login` LIKE'$email' AND `date` > (now() - interval 15 minute )");
                $verifUsertry = $verifUserTryQuery->fetch(PDO::FETCH_ASSOC);
                //var_dump($verifUsertry);

                if($verifUsertry["COUNT(*)"] <= 4) {
                    /* Si le mot de passe est correct */
                    if (password_verify($mdp, $mdpHashBdd)) {
                        $_SESSION['email'] = $email;
                        header('Location:home.php');
                    } else {
                        $err = 'votre mot de passe est incorrect';
                        /*  insertion de la tentative de connexion */
                        $enterUserConex = $bdd->prepare("INSERT INTO `connexions` ( `login`, `mdp`, `date`)VALUES ( ?, ?, NOW())");
                        $enterUserConex->execute(array($email, $mdpHash));
                    }
                } else {
                    $enterUserBan = $bdd->prepare('INSERT INTO `ban` ( `email`, `date`) VALUES ( ?, NOW())');
                    $enterUserBan->execute(array($email));
                    $err = 'Vous êtes banni pendant 15mn !';
                }
            } else {
                $err = "Votre adresse mail n'est pas valide";
            }
        } else {
            $err = 'Vous devez remplir tous les champs';
        }
    } else {
        $err = 'Vous avez été banni, patientez quelques minutes avant de tenter de vous reconnecter !';
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
<form action="" method="POST">
    <h1>Connexion</h1>

    <label><b>Email :</b></label>
    <input type="text" placeholder="Entrer le mail d'utilisateur" name="username" value="<?php if(isset($email)){echo $email;}?>">

    <label><b>Mot de passe</b></label>
    <input type="password" placeholder="Entrer le mot de passe" name="password">

    <input type="submit" value='LOGIN' name="submit">
    <?php
    if (isset($err)){
        echo '<br>';
        echo $err;
    }
    ?>
</form>
<form action="resetpassword.php" method="post">
    <input type="submit" value='Mot de passe oublié' name="forgetPass">
</form>
</body>

</html>