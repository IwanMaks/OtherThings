<?php
session_start();
ini_set('session.gc.maxlifetime', 3600);
$connection = new PDO('mysql:host=localhost; dbname=academy; charset=utf8', 'root', 'Relationship7109');
$login = $connection->query("SELECT * FROM login");

if ($_POST['login']) {
    foreach ($login as $log) {
        if ($_POST['login'] == $log['login'] && $_POST['password'] == $log['passwords']) {
            $_SESSION['login'] = $_POST['login'];
            $_SESSION['password'] = $_POST['passwords'];
            header("Location: content.php");
        }
    }

    echo "Неверный логин или пароль";
}
?>

<style>
    body {
        margin: 200px 300px;
    }
    input, p {
        font-size: 30px;
        margin: 10px;
    }
</style>

<form method="POST">
    <p>Авторизуйтесь</p>
    <input type="text" name="login" required placeholder="Логин"> <br>
    <input type="password" name="password" required placeholder="Пароль"> <br>
    <input type="submit">
</form>

