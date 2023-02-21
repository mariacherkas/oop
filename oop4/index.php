<?php

include_once('init.php');
use System\Router;
use System\Exceptions\Exc404;
use Articles\Controller;
const BASE_URL = '/oop4/';

/** @var TYPE_NAME $exception */
try {
    $router = new Router(BASE_URL);

    $router->addRoute('', Articles\Controller::class);
    $router->addRoute('article/1', Articles\Controller::class, 'item');
    $router->addRoute('article/2', Articles\Controller::class, 'item'); // e t.c post/99, post/100 lol :))

    $uri = $_SERVER['REQUEST_URI'];

    $activeRoute = $router->resolvePath($uri);

    $c = $activeRoute['controller'];
    $m = $activeRoute['method'];

    $c->$m();
    $html = $c->render();
    echo $html;
}
catch (Exc404 $exception){
    echo '404' . $exception->getMessage();
}
catch (Throwable $exception){
    echo 'nice show error:' . $exception->getMessage();
}

?>
<hr>
Menu
<a href="<?=BASE_URL?>">Home</a>
<a href="<?=BASE_URL?>article/1">Art 1</a>
<a href="<?=BASE_URL?>article/2">Art 2</a>