<?php

namespace App\Goods;
require_once "../../App/Goods/Goods.php";
require_once "../../App/Goods/DigitalGoods.php";
require_once "../../App/Goods/PieceGoods.php";
require_once "../../App/Goods/WeightGoods.php";

//use App\Goods as AppGoods;
use App\Goods;

$goods = ['id' => 1, 'name' => 'Ключ активации DrWeb', 'price' => 1999, 'amount' => 3];
$digitalGoods = new Goods\DigitalGoods($goods);
$digitalGoods->call();

$goods = ['id' => 23, 'name' => 'Яйцо куриное', 'price' => 6, 'count' => 10, 'amount' => 26];
$pieceGoods = new Goods\PieceGoods($goods);
$pieceGoods->call();

$goods = ['id' => 45, 'name' => 'Сахар-песок', 'price' => 39.9, 'count' => 3, 'amount' => 7];
$weightGoods = new Goods\WeightGoods($goods);
$weightGoods->call();

//2

namespace App\DB;
require_once "../../App/DB/DB.php";

$db = DB::createConnection();

echo '<pre>';
var_dump(!empty($db));
echo '</pre>';

namespace App;
require_once "../../App/Singleton.php";

MainObject::getInstance()->doAction();
MainObject::getInstance()->doAction();

MainObject2::getInstance()->doAction();
MainObject2::getInstance()->doAction();
MainObject2::getInstance()->doAction();