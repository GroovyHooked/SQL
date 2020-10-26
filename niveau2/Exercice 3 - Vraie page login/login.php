<?php
session_start();
$bdd = new PDO('mysql:host=127.0.0.1;dbname=connexions', 'root', 'root');


/* On déclanche le script au click */
if(isset($_POST['submit'])){

    /* On vérifie que les champs soit bien remplis */
    if(!empty($_POST['email']) && !empty($_POST['mdp'])){

        $email = htmlspecialchars($_POST['email']);
        $mdpClair = htmlspecialchars($_POST['mdp']);

        /* On vérifie que l'adresse mail soit dans un format valide*/
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){

            $verifUserEmail = $bdd->prepare("SELECT * FROM connexions WHERE email = ?");
            $verifUserEmail->execute(array($email));
            $userExistEmail = $verifUserEmail->rowCount();

            /* On vérifie si l'utlisateur est dans la bdd */
            if ($userExistEmail >= 1) {

                /* Récupération de la version hashée du mdp */
                $verifUserQueryMdp = $bdd->query('SELECT mdp FROM connexions WHERE email="' . $email . '"');
                $verifUserMdp = $verifUserQueryMdp->fetch(PDO::FETCH_ASSOC);

                /* Calcul du nombre de tentatives de connexions toutes les 5mn */
                $resultQuery = $bdd->query( "SELECT COUNT(*) FROM `connexions` WHERE `email` LIKE '$email' AND `date` > (now() - interval 5 minute)");
                $result = $resultQuery->fetch(PDO::FETCH_ASSOC);
                if($result["COUNT(*)"] > 5){
                    ECHO "<script>alert('Vous n\'avez le droit qu\'à 5 essais toutes les 5 minutes')</script>";
                }

                echo '<pre>';
                echo var_dump($resultQuery);
                echo '</pre>';

                /* Insertion de la tentative de connexion + date dans la bdd */
                $insertConnex = $bdd->prepare("INSERT INTO connexions(email, mdp, date) VALUES(?, ?, NOW())");
                $insertConnex->execute(array($email, $mdpClair));

                /* On vérifie le mdp */
                if (password_verify($mdpClair, $verifUserMdp['mdp'])) {

                    $userInfo = $verifUserEmail->fetch();
                    $_SESSION['id'] = $userInfo['id'];
                    $_SESSION['email'] = $userInfo['email'];
                    $_SESSION['mdp'] = $userInfo['mdp'];
                    $_SESSION['date'] = $userInfo['date'];
                    header('Location:home.php?id=' . $_SESSION['id']);

                } else {
                    $_SESSION = [];
                    session_destroy();
                    $erreurs = '<script>alert("Vos identifiants sont incorrects")</script>';
                }
            } else {
                $erreurs = '<script>alert("Vous n\'etes pas inscrit")</script>';
            }

        } else {
            $erreurs = '<script>alert("Votre adresse mail n\'est pas valide")</script>';
        }
    } else {
        $erreurs = '<script>alert("Vous devez remplir tous les champs")</script>';
    }
}
if(isset($erreurs)){
    echo $erreurs;
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
<h3>Connexion</h3>
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

