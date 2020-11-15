<?php
if(isset($_POST['submit'])){
    session_destroy();
    header('location:login.php');
}
?>
<header>
    <div class="divLogo">
        <img src="thomas_proj.png" alt="logo" class="logo">
    </div>
    <form method="post" action="">
    <div class="divList">
        <ul class="list">
            <li><input type="submit" value="Se déconnecter" id="deconnexion" name="submit"></li>
        </ul>
    </div>
    </form>
</header>
