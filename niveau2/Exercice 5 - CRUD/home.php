<?php
session_start();
$bdd = new PDO('mysql:host=127.0.0.1;dbname=connexions', 'root', 'root');
/* Fonction adresse IP*/
function getIpAddr(){
    if (!empty($_SERVER['HTTP_CLIENT_IP'])){
        $ipAddr=$_SERVER['HTTP_CLIENT_IP'];
    }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        $ipAddr=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ipAddr=$_SERVER['REMOTE_ADDR'];
    }
    return $ipAddr;
}
echo getIpAddr();
if (isset($_GET['id']) && $_GET['id'] > 0){

    $getId  = intval($_GET['id']);
    $reqUser = $bdd->prepare('SELECT * FROM connexions WHERE id = ?');
    $reqUser->execute(array($getId));
    $userInfo = $reqUser->fetch(PDO::FETCH_ASSOC);

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

<h2>Profil de <?php echo $userInfo['email']?></h2>
<h3><?php echo $_SESSION['id'] ?></h3>
<h3><?php echo $_SESSION['email'] ?></h3>
<h3><?php echo $_SESSION['mdp'] ?></h3>
<h3><?php echo $_SESSION['date'] ?></h3>

</body>
</html>
