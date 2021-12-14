<?php

class Computer // Общий класс компьютер (родитель)
{
    protected $processor; // Процессор
    protected $memory; // Память
    protected $graphic; // Видеокарта

    protected function __construct($processor = null, $memory = null, $graphic = null)
    {
        $this->processor = $processor;
        $this->memory = $memory;
        $this->graphic = $graphic;
    }

    public function aboutMe() // Функция формирует информацию о компьютере
    {
        echo $this->prepareContent();
    }

    protected function prepareContent()
    {
        return "<p>Процессор: {$this->processor}</p>
                <p>Память: {$this->memory} GB</p>
                <p>Видеокарта: {$this->graphic}</p>";
    }

    public function compareCharacteristic(Computer $computer) // Функция сравнения характеристик
    {
        echo "<h3>Сравнение:</h3>
              {$this->processor} - {$computer->processor}<br>
              {$this->memory} - {$computer->memory}<br>
              {$this->graphic} - {$computer->graphic}";
    }
}

class Notebook extends Computer // Ветвь класса компьютер - ноутбук (наследник)
{
    protected $mobility; // Дополнительное свойство наследника ноутбук (наследование - расширение функционала)

    public function __construct($processor = null, $memory = null, $graphic = null, $mobility = null)
    {
        parent::__construct($processor, $memory, $graphic);
        $this->mobility = $mobility;
    }

    public function aboutMe()
    {
        parent::aboutMe();
        echo "<p>Мобильность: {$this->mobility}</p>"; // (наследование - расширение функционала)
    }
}

class PersonalComputer extends Computer // Ветвь класса компьютер - персональный компьютер (наследник)
{
    protected $noiseLevel; // Дополнительное свойство наследника персональный компьютер (наследование - расширение функционала)

    public function __construct($processor = null, $memory = null, $graphic = null, $noiseLevel = null)
    {
        parent::__construct($processor, $memory, $graphic);
        $this->noiseLevel = $noiseLevel;
    }

    public function aboutMe()
    {
        parent::aboutMe();
        echo "<p>Уровень шума: {$this->noiseLevel} дБ</p>"; // (наследование - расширение функционала)
    }
}

function showOptions(Computer $options) // Метод для пользователя (внешка) (покажи но, не говори кто ты и откуда это взял)
{
    $options->aboutMe();
}

$notebook = new Notebook("Intel", 32, "Nvidia", "Да"); // Экземпляр класса Ноутбук
showOptions($notebook); // Запуск функции в контексте класса Notebook (полиморфизм)
var_dump($notebook);

$personalComputer = new PersonalComputer("AMD", 16, "AMD Radeon", 51); // Экземпляр класса Персональный компьютер
showOptions($personalComputer); // Запуск функции в контексте класса PersonalComputer (полиморфизм)
var_dump($personalComputer);

$notebook->compareCharacteristic($personalComputer);

// Инкапсуляция организована благодаря классам (все методы завернуты внутрь классов)

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
<?php

class A {
    public function foo() {
        static $x = 0; // Статичная переменная, принадлежит функции, функция в свое время классу, т.е. переменная будет        
        // созвана вне зависимости от того созданны экземпляры класса или нет
        echo ++$x; // Префиксный инкремент (увеличиваем -> выводим)
    }
}

$a1 = new A(); // Создаем екземпляр класса А (одна область памяти)
$a2 = new A(); // Создаем второй екземпляр класса А (ссылка на ту же область памяти)
$a1->foo(); // Будет выполнена операция инкремента и выведено значение 1
$a2->foo(); // Так как это экземпляр класса А static переменная x принадлежит классу А и хранит значение 1, будет выполнена операция инкремента и выведено значение 2
$a1->foo(); //x хранит значение 2, будет выполнена операция инкремента и выведено значение 3
$a2->foo(); // x хранит 3, будет выполнена операция инкремента и выведено значение 4


class A {
    public function foo() {
        static $x = 0; // Статичная переменная, принадлежит функции, функция в свое время классу, т.е. переменная будет
        // созвана вне зависимости от того созданны экземпляры класса или нет
       echo ++$x; // Префиксный инкремент (увеличиваем -> выводим)
   }
}

class B extends A { // Представим что скопировали весь код из класса A в класс B
    public function foo() {
        static $x = 0; // При этом переменная x создана и принадлежит уже классу B
        echo ++$x;
    }
}

$a1 = new A(); // Создаем екземпляр класса А (одна область памяти)
$b1 = new B(); // Создаем екземпляр класса B (другая область памяти)
$a1->foo(); // Инкрементируем переменную в классе A, получаем 1
$b1->foo(); // Инкрементируем переменную в классе B, получаем 1
$a1->foo(); // Инкрементируем переменную в классе A, получаем 2
$b1->foo(); // Инкрементируем переменную в классе B, получаем 2