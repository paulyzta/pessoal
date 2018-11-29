<pre>
<?php
/**
 * Created by PhpStorm.
 * User: danilo
 * Date: 26/11/18
 * Time: 09:14
 */


// Hora atual
echo date('h:i:s') . "\n";

// Dorme por 10 segundos
sleep(10);

// Acorde!
echo date('h:i:s') . "\n";
die();

$inicio = microtime(true);
sleep(10);


$tempoTotal = microtime(true) - $inicio;
echo 'Tempo de execução do primeiro script: ' . $tempoTotal;