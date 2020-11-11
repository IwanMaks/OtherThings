<?php
session_start();

if (count($_POST) > 0) {
    header('Location: admin.php');
}

if ($_POST['unlogin']) {
    session_destroy();
    header('Location: login.php');
}

$connection = new PDO('mysql:host=localhost; dbname=forum; charset=utf8', 'root', 'Relationship7109');
$data = $connection->query('SELECT * FROM `comments` WHERE moderation="new" ORDER by date DESC');
?>

<style>
    body {
        margin: 20px;
        font-family: Arial, sans-serif;
    }
    * {
        font-size: 30px;
    }
    button {
        margin-top: 20px;
    }
</style>

<h1>Админка злобного админа</h1>

<form method="POST">
    <? foreach ($data as $comment) { ?>
    <select name="<?= $comment['id']?>" id="<?= $comment['id']?>">
        <option value="ok">ОК</option>
        <option value="rejected">ОТКЛОНИТЬ</option>
    </select>
    <label for="<?= $comment['id']?>">
        <?= $comment['username'] . ' оставил комментарий "' . $comment['commenties'] . "\"<br/>" ?>
    </label>
    <? } ?>
    <button>Модерировать</button>
</form>

<hr>
<form method="POST">
    <input type="submit" name="unlogin" value="Выйти из админки">
</form>

<?php
foreach ($_POST as $num=>$checked) {
    if ($checked == 'ok') {
        $connection->query("UPDATE `comments` SET moderation='ok' WHERE id=$num");
    } else {
        $connection->query("UPDATE `comments` SET moderation='rejected' WHERE id=$num");
    }
}