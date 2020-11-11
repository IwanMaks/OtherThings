
<!--<form action="answer.php" method="post">-->
<!--    <input type="text" name="name">-->
<!--    <input type="text" name="surname">-->
<!--    <input type="text" name="age">-->
<!--    <input type="submit">-->
<!--</form>-->
<!---->
<?php
//if (isset($_GET['name']) && isset($_GET['surname']) && isset($_GET['age'])) {
//    echo "Привет меня зовут " . $_GET['name'] . " " . $_GET['surname'] . ", мой возраст - " . $_GET['age'];
//}
//?>

<form>
    <input type="date" name="date">
    <input type="submit">
</form>

<?php
if (isset($_GET['date'])) {
    if (date('m') == substr($_GET['date'], 5, 2)) {

        if (date('d') <= substr($_GET['date'], 8, 2)) {

            echo date('Y') - substr($_GET['date'], 0, 4);

        } else {

            echo (date('Y') - substr($_GET['date'], 0, 4)) - 1;
        }

    } else if (date('m') > substr($_GET['date'], 5, 2)) {

        echo date('Y') - substr($_GET['date'], 0, 4);

    } else if (date('m') < substr($_GET['date'], 5, 2)){

        echo (date('Y') - substr($_GET['date'], 0, 4)) - 1;

    }
}
?>
