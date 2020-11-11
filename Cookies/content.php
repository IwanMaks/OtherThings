<?php
session_start();
//if ($_SESSION['login'] || $_SESSION['password']) {
//    header("Location: login.php");
//    die();
//}

if ($_POST['unlogin']) {
    session_destroy();
    header("Location: login.php");
}
?>

<body style="font-size: 40px">
<p>Сайт только для авторизованных пользователей</p>
<? echo "Привет, " . $_SESSION['login'] . "<br>" ?>
<img src="horse.jpg" alt="Horse" width="600" style="display: block">

<form method="POST" style="margin: 40px; font-size: 40px">
    <input type="submit" style="font-size: 30px" name="unlogin" value="НА СТРАНИЦУ АВТОРИЗАЦИИ">
</form>
</body>
