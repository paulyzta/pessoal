<pre>
<?php
/**
 * Created by PhpStorm.
 * User: danilo
 * Date: 26/11/18
 * Time: 09:14
 */

//echo dirname("/etc/passwd") . PHP_EOL;
//echo dirname("/etc/") . PHP_EOL;
//echo dirname(".") . PHP_EOL;
//echo dirname("/usr/local/lib", 2);
//die();

$lines = file("teste.txt");
$x = file("includes/lista.m3u");

var_dump($x);

// Percorre o array, mostrando o fonte HTML com numeração de linhas.
foreach ($lines as $line_num => $line) {
    echo "Linha #<b>{$line_num}</b> : " . htmlspecialchars($line) . "<br>\n";
}