<?php

Interface IStorage{
    public function add(string $key, mixed $data) : void;
    public function remove(string $key) : void;
    public function contains(string $key) : bool;
    public function get(string $key) : mixed;
}

class Storage implements IStorage, JsonSerializable{
    public array $storage = [];

    public function add(string $key, $data): void
    {
        // TODO: Implement add() method.
        $this->storage[$key] = $data;
    }


    public function remove(string $key): void
    {
        // TODO: Implement remove() method.
        unset($this->storage[$key]);
    }

    public function contains(string $key): bool
    {
        // TODO: Implement contains() method.
        return isset($this->storage[$key]);
    }

    /**
     * @param int|string $key
     * @return mixed
     */
    public function get(int|string $key): mixed
    {
        // TODO: Implement get() method.
        return $this->contains($key) ? $this->storage[$key] : false;
    }

    public function jsonSerialize(): mixed
    {
        // TODO: Implement jsonSerialize() method.
        return var_dump($this->storage);
    }

}


class Animal implements JsonSerializable{
    public string $name;
    public int $health;
    public bool $alive;
    public int $power;

    public function __construct(string $name, int $health, int $power){
        $this->name = $name;
        $this->health = $health;
        $this->power = $power;
        $this->alive = true;
    }

    public function calcDemage(){
        return $this->power * (mt_rand(100, 200) / 100);
    }

    public function applyDamage(int $damage){
        $this->health -= $damage;

        if($this->health <= 0){
            $this->health = 0;
            $this->alive = false;
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function jsonSerialize(): mixed
    {
        // TODO: Implement jsonSerialize() method.
        return "$this->name: $this->health, $this->power, $this->alive";
    }
}

class JSONLogger{
    protected array $objects = [];

    public function addObject($obj) : void{
        $this->objects[] = $obj;
    }

    /**
     * @return array
     */
    public function getObjects(): array
    {
        return $this->objects;
    }

    public function log(string $betweenLogs = ',') : string{
        //error hier
        $logs = array_map(function(JsonSerializable $obj){
            return $obj->jsonSerialize();
        }, $this->objects);

        return implode($betweenLogs, $logs);
    }
}

$gameStorage = new Storage();
$gameStorage->add('test', mt_rand(1, 10));
$gameStorage->add('test2', mt_rand(1, 10));
$a1 = new Animal('Kot', 20, 5);
$a2 = new Animal('Pes', 30, 3);

var_dump($a1->getName());
var_dump($gameStorage->get('test'));
var_dump($gameStorage->get('test2'));
var_dump($gameStorage->contains('test'));
echo "<br>";


$logger = new JSONLogger();
$logger->addObject($a1);
$logger->addObject($a2);
$logger->addObject($gameStorage);
var_dump($logger->getObjects());
echo "<br>";


echo $logger->log('<br>') . '<br>';

$a2->applyDamage($a1->calcDemage());
$a1->applyDamage($a2->calcDemage());
$gameStorage->add('other', mt_rand(1, 10));

echo $logger->log('<br>');