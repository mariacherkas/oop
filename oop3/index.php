<?php

include_once('istorage.php');
include_once('article.php');
include_once('filestorage.php');
$path = 'articles2.txt';
$ms = FileStorage::getInstance($path);


$array = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5];
$art1 = new Article($ms);
$art1->create($array);
$art1->title = 'New art';
$art1->content = 'Content new art';
$art1->save();

$art2 = new Article($ms);
$art2->load(1);
echo '<pre>';
print_r($art2);
echo '</pre>';

$art2->title = 'NZ';
$art2->save(); 

$art3 = new Article($ms);
try {
    $art3->load(1);
} catch (Exception $e) {
    echo $e->getMessage();
}
echo '<pre>';
print_r($art3);
echo '</pre>';