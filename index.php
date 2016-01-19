<?php

class Dealer
{
    /** 
     * Игроки онлайн
     * @var array 
     */
    public $players;
    /**
     * Колода эталонная
     * @var array
     */
    static $deckEtalon = [
        ['2','♠','2♠'],  ['2','♥','2♥'],  ['2','♣','2♣'],  ['2','♦','2♦'],
        ['3','♠','3♠'],  ['3','♥','3♥'],  ['3','♣','3♣'],  ['3','♦','3♦'],
        ['4','♠','4♠'],  ['4','♥','4♥'],  ['4','♣','4♣'],  ['4','♦','4♦'],
        ['5','♠','5♠'],  ['5','♥','5♥'],  ['5','♣','5♣'],  ['5','♦','5♦'],
        ['6','♠','6♠'],  ['6','♥','6♥'],  ['6','♣','6♣'],  ['6','♦','6♦'],
        ['7','♠','7♠'],  ['7','♥','7♥'],  ['7','♣','7♣'],  ['7','♦','7♦'],
        ['8','♠','8♠'],  ['8','♥','8♥'],  ['8','♣','8♣'],  ['8','♦','8♦'],
        ['9','♠','9♠'],  ['9','♥','9♥'],  ['9','♣','9♣'],  ['9','♦','9♦'],
        ['10','♠','10♠'],['10','♥','10♥'],['10','♣','10♣'],['10','♦','10♦'],
        ['11','♠','J♠'], ['11','♥','J♥'], ['11','♣','J♣'], ['11','♦','J♦'],
        ['12','♠','Q♠'], ['12','♥','Q♥'], ['12','♣','Q♣'], ['12','♦','Q♦'],
        ['13','♠','K♠'], ['13','♥','K♥'], ['13','♣','K♣'], ['13','♦','K♦'],
        ['14','♠','A♠'], ['14','♥','A♥'], ['14','♣','A♣'], ['14','♦','A♦']
    ];
    private $deck = [];
    /**
     * Масти карт
     * @var array
     */
    private $suits = ['♠', '♥', '♣', '♦'];
    /**
     * Карты на столе
     * @var array
     */
    private $cards;
    /**
     * Банк
     * @var int
     */
    private $bank;
    /**
     * ID стола
     * @var string
     */
    private $table;
    /**
     *  Кол-во столов
     * @var int
     */
    static private $countTables = 0;
    /**
     * Игровой раунд
     * @var int
     */
    public $round = 0;
    /**
     * Фаза раздачи
     * @var array
     */
    public $phase = ['pre-flop','flop','turn','river'];
    /**
     * Большой блайнд
     * @var int
     */
    public $blind = 30;
    
            
    function __construct()
    {
        $this->table = 'table '.self::$countTables;
        self::$countTables++;
        
        $this->deck = $this->generateDeck();
        
        foreach ($this->deck as $key => $value) {
            echo $value[2].' ';
        }
    }
    /**
     * Перетасовка колоды
     * @return array
     */
    function generateDeck() {
        $tempDeck = self::$deckEtalon;
        $resultDeck = [];
        while (count($resultDeck) < 52) {
            $r = rand(0, 51);
            if (!isset($tempDeck[$r])) {
                continue;
            }
            $resultDeck[] = $tempDeck[$r] ;
            unset($tempDeck[$r]);
        }
        return $resultDeck;
    }
    
    /**
     * Раздача карт
     * @param int $number
     * @return array
     */
    function dealCards($number) {
        $temp = [];
        for ($i= 0; $i < $number; $i++) {
            $temp[] = array_pop($this->deck);
            
        }
//        echo '----'.count($this->deck).'-----';
        return $temp;
    }
    
    /**
     * Добавление нового игрока
     */      
    function addPlayer() {
        $this->players[]  = new Player(count($this->players), $this);
    }
    
    /**
     * Старт игры
     */
    function startGame() {
        echo 'Стол №'.$this->table.'<br>';
        foreach ($this->players as $key => $player) {
            echo '<br>'.$player->id.' ';
            $player->cards += $this->dealCards(2);
            foreach ($player->cards as $key => $value) {
                echo $value[2];
            }
        }
    }
    
    
    
    
}

class Player
{
    /**
     * Имя игрока
     * @var string
     */
    public $id;
    /**
     * Фишки
     * @var int
     */
    public $chips=1000;
    /**
     * Карты на руках
     * @var array 
     */
    public $cards=[];
    /**
     * Позиция за столом
     * @var int 1-9
     */
    public $position;
    /**
     * ссылка на текущего дилера
     * @var Dealer
     */
    public $dealer;
                
    function __construct($id, $dealer)
    {
        $this->id = $id;
        $this->dealer = $dealer;
        echo 'Игрок с id'.$id.' создан.<br>';
    }
    

    function decision () {
        
    }
}

$Dealer = new Dealer();
echo '<br>';
$Dealer->addPlayer();
$Dealer->addPlayer();
$Dealer->addPlayer();
$Dealer->startGame();
echo '<br>Количество игроков: '.count($Dealer->players).'<br><br>';
