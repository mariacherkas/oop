<?php

class FileStorage implements IStorage{
	protected array $records = [];
	protected int $ai = 0;
	protected string $dbPath;
    private static array $instances = [];

	private function __construct(){

	}

    public static function getInstance(string $dbPath): FileStorage
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        self::$instances[$cls]->dbPath = $dbPath;

        if(file_exists(self::$instances[$cls]->dbPath)){
            $data = json_decode(file_get_contents(self::$instances[$cls]->dbPath), true);

            self::$instances[$cls]->records = $data['records'];
            self::$instances[$cls]->ai = $data['ai'];
        }

        return self::$instances[$cls];
    }

	public function create(array $fields) : int{
		$id = ++$this->ai;
        $this->records[$id] = $fields;
		$this->save();
		return $id;
	}

	public function get(int $id) : ?array{
		return $this->records[$id] ?? null;
	}

	public function remove(int $id) : bool{
		if(array_key_exists($id, $this->records)){
			unset($this->records[$id]);
			$this->save();
			return true;
		}

		return false;
	}

	public function update(int $id, array $fields) : bool{
		if(array_key_exists($id, $this->records)){
			$this->records[$id] = $fields;
			$this->save();
			return true;
		}

		return false;
	}

	protected function save(){
		file_put_contents($this->dbPath, json_encode([
			'records' => $this->records,
			'ai' => $this->ai
		]),FILE_USE_INCLUDE_PATH);
	}
}
