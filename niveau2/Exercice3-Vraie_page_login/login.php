<?php
$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', '');

if(isset($_POST['username']) && isset($_POST['password'])){
    $pseudo = htmlspecialchars($_POST['username']);
    $mdp = sha1($_POST['password']);

    if(!empty($_POST['username']) && !empty($_POST['password'])){
        $insertmbr = $bdd->prepare("INSERT INTO membres(pseudo, password, date) VALUES (?, ?, NOW())");
        $insertmbr->execute(array($pseudo, $mdp));
        $erreur = 'Votre compte à bien été crée';
    } else{
        $erreur = 'Tous les champs doivent être completés';
    }
}

?> 
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
 ;</head>
<body>
<div id="container">
            <!-- zone de connexion -->
            
            <form action="" method="POST">
                <h1>Connexion</h1>
                
                <label for="username">Email utilisateur: </label>
                <input type="text" placeholder="Entrer le nom d'utilisateur" name="username"  value='<?php if(isset($pseudo)){echo $pseudo; } ?>'>
                <br><br>
                <label for="password">Mot de passe</label>
                <input type="password" placeholder="Entrer le mot de passe" name="password">
                <br><br>
                <input type="submit" id='submit' value='LOGIN' >
            
            </form>

            <?php
            if (isset($erreur)){
                echo '<font color="red">'. $erreur .'</font>';
            }
            ?>
        </div>
</body>
</html>