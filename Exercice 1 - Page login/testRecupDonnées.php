<?php
//session_start();
$bdd = new PDO('mysql:host=127.0.0.1;dbname=connexions', 'root', 'root');
$mail = 'dafrenchie2002@yahoo.fr';
if(isset($_POST['submit'])) {
    $result = $bdd->query('SELECT mdp FROM connexions WHERE email ="' .$mail. '"');
    $resultTest = $result->fetch(PDO::FETCH_ASSOC);

    if ($result === false){
        die('Erreur SQL');
    }
}
/*function setInterval($f, $milliseconds)
{
    $seconds=(int)$milliseconds/1000;
    while(true)
    {
        $f();
        sleep($seconds);
    }
}


setInterval(function(){
    echo "hi!\n";
}, 1000);*/
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test PHP/SQL</title>
</head>
<body>
<h1>Test PHP/SQL</h1>
<div>
    <form action="" method="post">
        <button type="submit" value="Cliquez" name="submit">Submit</button>
    </form>
</div>
<div>
    <?php
    echo ('Votre adresse IP est <strong>' . $_SERVER['REMOTE_ADDR'] . '</strong>');
    ?>
</div>
<div>
    <br><br>
    <?php if(isset($_POST)){
       echo '<pre>';
       echo  var_dump($resultTest);
       echo '</pre>';
       echo '<br>';
       echo '<pre>' . var_dump($bdd->errorInfo()) . '</pre>';

    } ?>
</div>
<div>

</div>
</body>
</html>
<?php
/**
 * Ce code va tester votre serveur pour déterminer quel serait le meilleur "cost".
 * Vous souhaitez définir le "cost" le plus élevé possible sans trop ralentir votre serveur.
 * 8-10 est une bonne base, mais une valeur plus élevée est aussi un bon choix à partir
 * du moment où votre serveur est suffisament rapide ! Le code suivant espère un temps
 * ≤ à 50 millisecondes, ce qui est une bonne base pour les systèmes gérants les identifications
 * intéractivement.
 */
/*$timeTarget = 0.05; // 50 millisecondes

$cost = 8;
do {
    $cost++;
    $start = microtime(true);
    password_hash("test", PASSWORD_BCRYPT, ["cost" => $cost]);
    $end = microtime(true);
} while (($end - $start) < $timeTarget);

echo "Valeur de 'cost' la plus appropriée : " . $cost;
?>