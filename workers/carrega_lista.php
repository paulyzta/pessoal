<?php
/**
 * Created by PhpStorm.
 * User: danilo
 * Date: 23/11/18
 * Time: 15:32
 */
//header('Content-Type: text/html; charset=utf-8');
header('Content-Type: text/html; charset=iso-8859-1');

$inicio = microtime(true);



require('includes/conecta.php');

$arquivo = 'includes/lista.m3u';
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

    $result = categorizar($result);

    return $result;
}

function salvaRegistro ($array, $pdo) {

    //Insert ou update
    $link = $array['link'];

    $stmt = $pdo->prepare("SELECT * FROM listaIPTV_testes WHERE link = '$link'");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        //Existe! Entao vamos atualizar
        date_default_timezone_set('America/Sao_Paulo');
        $now = date('Y-m-d h:i:s', time());
        $sql = "UPDATE listaIPTV_testes SET name = :name, logo = :logo, grupo = :grupo, idList = :idList, category = :category, updated = '".$now."' WHERE link = :link";
    } else {
        //NAO Existe! Entao vamos cadastrar
        $sql = "INSERT INTO listaIPTV_testes (name, logo, grupo, idList, link, category) VALUES(:name, :logo, :grupo, :idList, :link, :category)";
    }

    $pdo->prepare($sql)->execute($array);

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

}

echo 'terminou de inserir no DB...';
$tempoTotal = microtime(true) - $inicio;
echo 'Tempo de execução do primeiro script: ' . $tempoTotal;