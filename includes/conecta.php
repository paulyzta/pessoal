<?php
/**
 * Created by PhpStorm.
 * User: danilo
 * Date: 26/11/18
 * Time: 16:49
 */

//header('Content-Type: text/html; charset=iso-8859-1');
//header('Content-Type: text/html; charset=UTF-8');

$host = 'localhost:3306';
$dbname = 'dev_db';

//$user = 'user_db';
//$pass = '123456';
//home
$user = 'usuario';
$pass = 'abc@123';

try{
    $pdo = new pdo( "mysql:host=$host;dbname=$dbname",
        "$user",
        "$pass");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $ex){
    echo 'Error: ' . $ex->getMessage();
    die(json_encode(array('outcome' => false, 'message' => 'Unable to connect')));
}
