<?php
class MultiException
    extends Exception
{
    protected $storage = [];

    public function add(Exception $exception){
        $this->storage[] = $exception;
    }

    /**
     * @return array
     */
    public function getExceptions()
    {
        return $this->storage;
    }

    /**
     * @return array
     */
    public function isEmpty()
    {
        return empty($this->storage);
    }
}

/**
 * @throws MultiException
 */
function validateUser($login, $password){
    $errors = new MultiException();
    if (empty($login)){
        $errors->add(new Exception('Empty login'));
    }
    if (empty($password)){
        $errors->add(new Exception('Empty password'));
    }
    if (!$errors->isEmpty()){
        throw $errors;
    }
}

try {
    validateUser('', '');
}
catch (MultiException $exception){
    foreach ($exception->getExceptions() as $error){
        echo $error->getMessage()."<br>";
    }
}

