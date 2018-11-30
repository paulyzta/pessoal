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



//require('../includes/conecta.php');

$arquivo = '../includes/lista.m3u';
$arrErros = array();
$grupos = [];



function trata($link) {
    $result = [];
    $str = explode(',', $link)[0];
    $itens = array('tvg-id', 'name', 'logo', 'group-title');

    foreach ($itens as $v) {
        $inicio = substr( $str, ( strpos($str, $v.'=') + (strlen($v) +2) ) );
        $fim    = substr( $inicio, 0,  strpos($inicio, '"') );

        $result[$v] = utf8_decode( mb_strtolower($fim !== '' ? $fim : '-' ) );
    }

    $result['name']   = $result['name'];
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

    $regExGrupo = '/^\(.*\)$/'; //Reconhece o ANO de producao do filme para definir que é um filme
    $regExFilmes = '/\s\((\d{4})\)/'; //Reconhece o ANO de producao do filme para definir que é um filme
    $regExSeries = '/([Ss]?)([0-9]{1,2})\s([eE\.\-]?)([0-9]{1,2})/'; //Busca por Sxx Exx para identificar uma serie

    if ( preg_match($regExGrupo, $arr['grupo']) ) {
        //Filmes
        preg_match_all($regExFilmes, $arr['name'], $resultado);

        $name = str_replace($resultado[0], '', $arr['name']);
        $name = str_replace('(leg)', '[LEGENDADO]', $name);

        $arr['name']     = $name;
        $arr['Ano']      = isset($resultado[1][0]) ? $resultado[1][0] : '1900';
        $arr['grupo']    = substr($arr['grupo'] , 1, -1); //Remove os parenteses do grupo
        $arr['category'] = 'Filme';

        //echo $arr['grupo'];die();
    } elseif ( preg_match_all($regExSeries, $arr['name'], $resultado) ) {
        //Series
        $arr['temporada'] = intval($resultado[2][0]);
        $arr['episodio']  = intval($resultado[4][0]);
        $arr['category']  = 'Serie';
    } else {
        //Canais de TV
        $arr['category'] = 'Canal-TV';
    }
    $arr['grupo'] = ucwords($arr['grupo']);
    $arr['name'] = ucwords($arr['name']);

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
            //salvaRegistro($result, $pdo);

            $teste[] =$result;
        }
    }
    //$index++;
    if ($index >= 20) {
        echo 'Interrompendo...';
        break;
    }

}
echo '<pre>';
print_r($teste);//die();

echo 'terminou de inserir no DB...';
$tempoTotal = microtime(true) - $inicio;
echo 'Tempo de execução do primeiro script: ' . $tempoTotal;