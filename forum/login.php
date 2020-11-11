<?php
session_start();
$connection = new PDO ('mysql:host=localhost; dbname=forum; charset=utf8', 'root', 'Relationship7109');
$data = $connection->query('SELECT * FROM `admin`');
if ($_POST['login']) {
    foreach ($data as $info) {
        if ($_POST['login'] == $info['login'] && $_POST['password'] == $info['password']) {
            $_SESSION['login'] = $_POST['login'];
            $_SESSION['password'] = $_POST['password'];
            header('Location: admin.php');
        }

    }
}
?>

<style>
    body {
        margin: 50px;
        font-family: Arial, sans-serif;
    }
    input, textarea, button {
        margin: 15px;
        display: block;
        font-size: 30px;
    }
</style>

<h2>Вход в админку</h2>

<form method="POST">
    <input type="text" name="login" placeholder="Логин" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <button>Отправить</button>
</form>