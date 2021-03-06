<?php
$connection = new PDO ('mysql:host=localhost; dbname=academy; charset=utf8', 'root', 'Relationship7109');
if (isset($_POST['submit'])) {
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileType = $_FILES['file']['type'];
    $fileError = $_FILES['file']['error'];
    $fileSize = $_FILES['file']['size'];

    $array = explode('.', $fileName);
    $fileExtension = strtolower(end($array));
    $fileName = explode('.', $fileName)[0];
    $fileName = preg_replace('/[0-9]/', '', $fileName);
    $allowedExtension = ['jpg', 'jpeg', 'png'];

    if (in_array($fileExtension, $allowedExtension)) {
      if ($fileSize < 5000000) {
            if ($fileError === 0) {
                $connection->query("INSERT INTO `images` (`imgname`, `extension`) VALUES ('$fileName', '$fileExtension');");
                $lastID = $connection->query("SELECT MAX(id) FROM `images`");
                $lastID = $lastID->fetchAll();
                $lastID = $lastID[0][0];
                $fileNameNew = $lastID . $fileName . '.' . $fileExtension;
                $fileDestination = 'uploads/' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                echo 'Успех';
            } else {
                echo 'Что-то пошло не так';
            }
      } else {
          echo 'Слишком большой размер файла';
      }
    } else {
        echo 'Неверный тип файла';
    }
}

$data = $connection->query("SELECT * FROM `images`");
echo "<div style='display: flex; align-items: flex-end; flex-wrap: wrap'>";
foreach ($data as $img) {

    $delete = "delete".$img['id'];
    $image = "uploads/" . $img['id'].$img['imgname'].'.'.$img['extension'];
    if (isset($_POST[$delete])) {
        $imageID = $img['id'];
        $connection->query("DELETE FROM `academy`.`images` WHERE id = '$imageID'");
        if (file_exists($image)) {
            unlink($image);
        }
    }


    if (file_exists($image)) {
        echo "<div>";
        echo "<img width='150' height='150' src='$image'>";
        echo "<form method='POST'><button name='delete".$img['id']."' style='display: block; margin: auto'>Удалить</button></form></div>";
    }
}
echo "</div>";
?>

<style>
    body {
        margin: 50px 100px;
        font-size: 25px;
    }
    input, button {
        outline: none;
        font-size: 25px;
    }
</style>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<form method="POST" enctype="multipart/form-data">
    <input type="file" name="file" required>
    <button name="submit">Отправить</button>
</form>
</body>
</html>
