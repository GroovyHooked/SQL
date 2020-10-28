<?php
session_start();
$bdd = new PDO('mysql:host=127.0.0.1;dbname=espace_membre', 'root', '');

$emailhash = $_GET['email'];
//echo $emailhash; 
$_SESSION['email'] = $emailhash;
echo $_SESSION['email'];
echo ' <br>';

/* On lance le script au click */
if(isset($_POST['submit'])){
    echo '1' .'<br>';
        /* On récupère les entrées */
        $mdp1 = htmlspecialchars($_POST['mdp1']);
        $mdp2 = htmlspecialchars($_POST['mdp2']);
    /* Si les champs ne sont pas vides */
    if(!empty($mdp1) && !empty($mdp2)){
        echo '2'. '<br>';

        /*On interoge la bdd */
        $verifUserQuery = $bdd->query("SELECT * FROM connexions WHERE hash = '$emailhash'");
        $verifUser = $verifUserQuery->rowCount();

        if ($verifUser >= 1){
            echo '3'. '<br>';
            if($mdp1 === $mdp2){
                echo  'ok';
                /*On hash le nouveau mdp */
                $mdpModifie = password_hash($mdp1, PASSWORD_DEFAULT);

                /*On modifie le mot de passe dans la bdd*/
                $modifMdpQuery = $bdd->prepare("UPDATE connexions SET mdp = '$mdpModifie' WHERE hash = ?");
                $modifMdpQuery->execute(array($emailhash));
                session_destroy();
                header('Location:reussi.php'); 
            } else {
                $error = 'Les mdp rentrés ne sont pas similaire !';
            }
        } else {
            $error = 'Vous n\'etes pas inscrit';
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

