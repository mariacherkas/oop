<?php

class FileStorage implements IStorage{
	protected array $records = [];
	protected int $ai = 0;
	protected string $dbPath;

	public function __construct(string $dbPath){
		$this->dbPath = $dbPath;

		if(file_exists($this->dbPath)){
			$data = json_decode(file_get_contents($this->dbPath), true);
			$this->records = $data['records'];
			$this->ai = $data['ai'];
		}
	}

	public function create() : int{
		$id = ++$this->ai;
		$this->records[$id] = [];
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
		]));
	}
}
