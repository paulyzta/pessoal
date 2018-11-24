<?php
/**
 * Created by PhpStorm.
 * User: danilo
 * Date: 23/11/18
 * Time: 15:32
 */

$arquivo = 'lista.m3u';
$arrErros = array();
$grupos = [];

function  trata($link) {
    echo '<pre>';
    $xxx = [];


    $str = explode(',', $link);
    $title = trim($str[1]);

//    echo $str[0];
//    echo '<hr>';

    $itens = array('id', 'name', 'logo', 'group-title');

    $id = '';

    foreach ($itens as $v) {
        $xxx['title'] = $title;
        $inicio = substr( $str[0], ( strpos($str[0], $v.'=') + (strlen($v) +2) ) );
//
//
//        echo strpos($inicio, '"');
//
//        echo substr( $inicio, 0,  strpos($inicio, '"') );
//        echo '<hr>';

        $xxx[$v] = substr( $inicio, 0,  strpos($inicio, '"') );


        //echo strpos($str[0], $v.'=');
//        echo ( strpos($str[0], $v.'=') + strlen($v) );
//
//        echo substr( $str[0], ( strpos($str[0], $v.'=') + (strlen($v) +2) ) );
//        die();

    }





//    print_r($xxx);

    return $xxx;


}




$linhas= file($arquivo);

foreach($linhas as $linha) {


    if ( !strpos($linha, 'EXTM3U') ) {
        if ( strpos($linha, 'EXTINF') ) {
//        echo 'aqui';
            //echo $linha;
        }
        if ( strpos($linha, 'EXTINF') ) {
            //echo '<p>sem link</p>';
            $xxx = trata($linha);
        } else {
            //echo '<p>link</p>';
        }
    } else {
        //echo 'deu ruim';
        $arrErros[] = $linha;
    }


    $grupos[$xxx['group-title']][] = $xxx;


}
echo '<pre>';
echo 'porra';

    print_r($grupos);
    echo '<hr>';

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
