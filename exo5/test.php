<?php

function verificationPassword2($var){
    $upper = preg_match('@[A-Z]@', $var);
    $lower = preg_match('@[a-z]@', $var);
    $number = preg_match('@[0-9]@', $var);
    if (strlen($var) >= 8 && $upper && $lower && $number){
        return true;
    } else {
        return false;
    }
}

if(isset($_POST['submit'])){
    $mdp = $_POST['password'];
    var_dump(verificationPassword2($mdp));
    echo 'ok';
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
<form action="" method="post">
    <div>
        <label><b>Mot de passe</b></label>
        <input type="password" placeholder="Entrer le mot de passe" name="password">
    </div>
    <div>
        <input type="submit" id='submit' value='LOGIN' name="submit">
    </div>
</form>

</body>
</html>
