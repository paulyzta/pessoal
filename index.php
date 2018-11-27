<?php
/**
 * Created by PhpStorm.
 * User: danilo
 * Date: 23/11/18
 * Time: 15:32
 */
//header('Content-Type: text/html; charset=utf-8');
header('Content-Type: text/html; charset=iso-8859-1');




require('conecta.php');

$arquivo = 'lista.m3u';
$arrErros = array();
$grupos = [];



function  trata($link) {
    $result = [];
    $str = explode(',', $link)[0];
    $itens = array('tvg-id', 'name', 'logo', 'group-title');

    foreach ($itens as $v) {
        $inicio = substr( $str, ( strpos($str, $v.'=') + (strlen($v) +2) ) );
        $fim    = substr( $inicio, 0,  strpos($inicio, '"') );

        $result[$v] = utf8_decode( mb_strtolower($fim !== '' ? $fim : '-' ) );
    }

    

    $result['name']   = ucwords($result['name']);
    $result['grupo']  = $result['group-title'];
    $result['idList'] = $result['tvg-id'];
    unset($result['group-title'], $result['tvg-id']);

    //echo '<pre>';print_r($result);die('qqq');

    //serie($result);
    $result = categorizar($result);

    return $result;
}

function salvaRegistro ($array, $pdo) {

    //Insert ou update
    $link = $array['link'];

    $stmt = $pdo->prepare("SELECT * FROM listaIPTV WHERE link = '$link'");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        //Existe! Entao vamos atualizar
        date_default_timezone_set('America/Sao_Paulo');
        $now = date('Y-m-d h:i:s', time());
        $sql = "UPDATE listaIPTV SET name = :name, logo = :logo, grupo = :grupo, idList = :idList, category = :category, updated = '".$now."' WHERE link = :link";
        //echo '<h4>UPDATE</h4>';
    } else {
        //NAO Existe! Entao vamos cadastrar
        $sql = "INSERT INTO listaIPTV (name, logo, grupo, idList, link, category) VALUES(:name, :logo, :grupo, :idList, :link, :category)";
//        echo '<h4>INSERT</h4>';
//        print_r($array);
    }

    $pdo->prepare($sql)->execute($array);

    //echo $pdo->lastInsertId(); //retorna o ID do item inserido

    return;
}

function categorizar($arr) {
    $regExFilmes = '/^\(.*\)$/'; //testa nome do grupo entre parenteses
    $regExSeries = '/([Ss]?)([0-9]{1,2})\s([eE\.\-]?)([0-9]{1,2})/'; //Busca por Sxx Exx para identificar uma serie

    if ( preg_match($regExFilmes, $arr['grupo']) ) {
        $arr['grupo']    = substr($arr['grupo'] , 1, -1);
        $arr['category'] = 'Filme';
    } elseif ( preg_match($regExSeries, $arr['name']) ) {
        
        $arr['category'] = 'Serie';
    } else {
        $arr['category'] = 'Canal-TV';
    }
    $arr['grupo'] = ucwords($arr['grupo']);

    //echo '<pre>';print_r($arr);echo '</pre>';die();

    //die('wwwwwwww');

    return $arr;
}




$linhas= file($arquivo);
//echo count($linhas);
$index = 0;

foreach($linhas as $linha) {

    if ( !strpos($linha, 'EXTM3U') ) {
        //remove a primeira linha
        if ( strpos($linha, 'EXTINF') ) {
            //trata a string com os dados do link
            $result = trata($linha);
        } else {
            //adiciona o link ao registro
            $result['link'] = $linha;
            //chama a funcao que vai gravar os dados no banco de dados
            salvaRegistro($result, $pdo);
        }
    }
    //$index++;

    if ($index >= 20) {
        echo 'Interrompendo...';
        break;
    }



//    $grupos[$xxx['group-title']][] = $xxx;


}

echo 'terminou de inserir no DB...';
die();

















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
