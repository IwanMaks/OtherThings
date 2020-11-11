<?php

if (count($_GET) > 0) {
    session_start();
    require_once '../db/db.php';

    foreach ($_GET as $key=>$value) {
        $currentKey = $key;
        $currentValue = $value;
    }

    $_SESSION[$currentKey] = $currentValue;
}

$query = "SELECT * FROM products WHERE";
foreach ($_SESSION as $key=>$value) {
    if ($value != 'all') {
        $query .= " $key='$value' AND";
    }
}

$query = trim($query, 'WHERE');
$query = trim($query, 'AND');

$products = $connection->query($query)
                        ->fetchAll(PDO::FETCH_ASSOC);

if (!$products) {
    echo 'Товаров не найдено';
}

foreach ($products as $product) { ?>
    <div class="col-3">
        <div class="card">
            <div class="card-title"><?= $product['cat']?> <?= $product['tittle']?></div>
            <div class="card-body">
                <p class="lead">Цвет: <?= $product['color']?></p>
                <p class="lead">Вес: <?= $product['weight']?></p>
            </div>
        </div>
    </div>
<?php } ?>