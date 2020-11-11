<?php
session_start();
require_once 'db/db.php';

$products = $connection->query("SELECT * FROM products")
                    ->fetchAll(PDO::FETCH_ASSOC);

$cats = $connection->query("SELECT cat FROM cats")
                    ->fetchAll(PDO::FETCH_ASSOC);

$colors = $connection->query("SELECT color FROM colors")
                    ->fetchAll(PDO::FETCH_ASSOC);

$weights = $connection->query("SELECT weight FROM weights")
                    ->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>Ajax</title>
</head>
<body>
   <div class="container">
       <div class="select">
           <select name="cat" id="cat">
               <option value="all">Все категории</option>
               <? foreach ($cats as $cat) { ?>
                   <option value="<?= $cat['cat']?>" <? if($_SESSION['cat'] == $cat['cat']) {echo 'selected';}?>><?= $cat['cat']?></option>
               <? } ?>
           </select>

           <select name="color" id="color">
               <option value="all">Все цвета</option>
               <? foreach ($colors as $color) { ?>
                   <option value="<?= $color['color']?>" <? if($_SESSION['color'] == $color['color']) {echo 'selected';}?>><?= $color['color']?></option>
               <? } ?>
           </select>

           <select name="weight" id="weight">
               <option value="all">Любой вес</option>
               <? foreach ($weights as $weight) { ?>
                   <option value="<?= $weight['weight']?>" <? if($_SESSION['weight'] == $weight['weight']) {echo 'selected';}?>><?= $weight['weight']?></option>
               <? } ?>
           </select>
       </div>

       <div class="row cards-block">
           <?
            require_once 'actions/query.php';
           ?>
       </div>
   </div>

   <script src="js/jquery-3.5.1.min.js"></script>
   <script src="js/ajax.js"></script>
</body>
</html>
