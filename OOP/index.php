<?php

interface iCompany
{
    public static function showCompanyInfo();
}

interface iPriceWithVAT
{
    public function getInfoWithVAT();
}

interface iPriceWithoutVAT
{
    public function getInfoWithoutVAT();
}

abstract class Product implements iCompany, iPriceWithoutVAT, iPriceWithVAT
{
    public $name;
    public $price;
    public $weight;
    public $count;
    static public $companyName = 'Coca-Cola';
    const YEAR_START = 1900;

    public static function showCompanyInfo()
    {
        echo "Компания: " . Product::$companyName . "<br>";
        echo "Год основания: " . Product::YEAR_START . "<br>";
    }

    public function __construct(string $name, int $price, int $weight)
    {
        $this->name = $name;
        $this->price = $price;
        $this->weight = $weight . " грамм";
        $this->count++;
    }

    public function getInfoWithVAT()
    {
        echo $this->name . "<br>";
        echo "Цена с учётом НДС: " . $this->price . " рублей<br>";
        echo "Вес: " . $this->weight . "<br>";
        echo "<br>";
    }

    public function getInfoWithoutVAT()
    {
        echo $this->name . "<br>";
        echo "Цена без учёта НДС: ";
        echo gettype($this->price) === 'integer' ? $this->price * 0.8 . " рублей<br>" : $this->price . " рублей<br>";
        echo "Вес: " . $this->weight . "<br>";
        echo "<br>";
    }

    public abstract function showImg();
}

class Chocolate extends Product
{
    public $cal;

    public function __set($name, $value)
    {
        echo "Не можете присвоить $value переменной $name";
    }

    public function __construct(string $name, int $price, int $weight, int $cal)
    {
        $this->cal = $cal;
        parent::__construct($name, $price, $weight);
        $this->showImg();
    }

    public function showImg()
    {
        echo "
        <div style='width: 200px; height: 200px;'>
            <img src='choc.jpg' style='width: 200px; height: 200px;'>
        </div>";
    }


}

class Candy extends Product
{
    public function __get($name)
    {
        echo "Не можете обратиться к переменной $name";
    }

    public function __construct(string $name, int $price, int $weight)
    {
        parent::__construct($name, $price, $weight);
        $this->showImg();
    }

    public function showImg()
    {
        echo "
        <div style='width: 100px; height: 100px;'>
            <img src='candy.jpg' style='width: 100px; height: 100px;'>
        </div>";
    }
}

$choc = new Chocolate('RiterSport', 150, 80, 200);
$candy = new Candy('Tofee', 180, 100);
$choc->showCompanyInfo();
Product::showCompanyInfo();