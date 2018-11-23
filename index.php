<?php
/**
 * Created by PhpStorm.
 * User: danilo
 * Date: 23/11/18
 * Time: 15:32
 */

$arquivo = 'lista.m3u';
$arrErros = array();




$linhas= file($arquivo);

foreach($linhas as $linha) {


    if ( !strpos($linha, 'EXTM3U') ) {
        if ( strpos($linha, 'EXTINF') ) {
//        echo 'aqui';
            //echo $linha;
        }
        if ( strpos($linha, 'EXTINF') ) {
            echo '<p>sem link</p>';
        } else {
            echo '<p>link</p>';
        }
    } else {
        echo 'deu ruim';
        $arrErros[] = $linha;
    }


}
echo '<pre>';
print_r($linha);
die();



$handle = @fopen($arquivo, 'r');
if ($handle) {
    while (($linha = fgets($handle, 4096)) !== false) {

        if ( strpos($linha, 'EXTINF') ) {
            echo 'aqui';
            //echo $linha;
        }
        if ( strpos($linha, 'http') ) {
            echo 'http?';
            echo $linha;die();

        } else {
            echo 'deu ruim';
            $arrErros[] = $linha;
        }

    }
    if (!feof($handle)) {
        echo "Erro: falha inexperada de fgets()\n";
    }

    fclose($handle);

    //var_dump($arrErros);
    echo '<pre>';
    print_r($linha);
}
