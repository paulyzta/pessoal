<?php
/**
 * Created by PhpStorm.
 * User: danilo
 * Date: 23/11/18
 * Time: 15:32
 */

$inicio = microtime(true);

require('../includes/conecta.php');

$arquivo = '../includes/lista.m3u';
$listaURL= 'https://tinyurl.com/21983556876';
$arrErros = array();
$grupos = [];



function trata($line) {
//    $result = array(
//        'name'          => '',
//        'logo'          => '',
//        'grupo'         => '',
//        'idList'        => '',
//        'link'          => '',
//        'ano'           => '',
//        'category'      => '',
//        'temporada'     => '',
//        'episodio'      => '',
//        'idTMDB'        => '',
//        'trailler'      => '',
//        'poster'        => '',
//        'originalTitle' => '',
//        'backdrop'      => '',
//        'sinopse'       => '',
//        'nota'          => '',
//        );

    $l = explode('",', $line)[0].'"';
    $itens = array(
        'idList' => 'tvg-id',
        'name'   => 'name',
        'logo'   => 'logo',
        'grupo'  => 'group-title'
    );

    foreach ($itens AS $k => $v) {
        $start = substr( $l, ( strpos($l, $v.'=') + (strlen($v) +2) ) );
        $end   = substr( $start, 0,  strpos($start, '"') );

        $result[$k] = mb_strtolower($end !== '' ? $end : '-' );
    }
//
//    $result['grupo']  = $result['group-title'];
//    $result['idList'] = $result['tvg-id'];
//    unset($result['group-title'], $result['tvg-id']);
//    print_r($result);die();

    $result = categorizar($result);

    return $result;
}


function trataSiglas($name) {
    $minusculas = array('hd', 'fhd', 'rjhd', 'rjfhd', 'rj', 'sphd', 'spfhd', 'sp', '4k');
    $MAIUSCULAS = array('HD', 'FHD', 'RJHD', 'RJFHD', 'RJ', 'SPHD', 'SPFHD', 'SP', '4K');

    return str_replace($minusculas, $MAIUSCULAS, $name);
}



function salvaRegistro ($array, $pdo) {
    //Insert ou update
    $link = $array['link'];

    $stmt = $pdo->prepare("SELECT * FROM listaIPTV WHERE link = '$link'");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        //echo $log[] = 'UPDATE - '.$array['name'];
        return;
        //Existe! Entao vamos atualizar
        //date_default_timezone_set('America/Sao_Paulo');
        $array['updated'] = date('Y-m-d h:i:s', time());;
        $array['id'] = intval($row['id']);

        $update = '`updated` = :updated';
        foreach ($array AS $k => $v) {
            $update .= ", `$k` = :$k ";
        }
        //$sql = "UPDATE listaIPTV SET `name` = :name, logo = :logo, grupo = :grupo, idList = :idList, category = :category WHERE link = :link";
        $sql = "UPDATE listaIPTV SET  ".$update." WHERE id = :id";
    } else {
        //$log[] = 'INSERT INTO - '.$array['name'];
        //die('aqui'); INSERT INTO listaIPTV (name,logo,grupo,idList,category,link) VALUES (?,?,?,?,?,?)|
        //NAO Existe! Entao vamos cadastrar
        $columnString = implode(',', array_keys($array));
        //$valueString = implode(',', array_fill(0, count($array), '?'));
        $valueString = implode(', :', array_keys($array));

        //$sql = 'INSERT INTO `listaIPTV`(`name`, `logo`, `grupo`, `idList`, `link`, `ano`, `category`, `temporada`, `episodio`, `idTMDB`, `trailler`, `poster`, `originalTitle`, `backdrop`, `sinopse`, `nota`) VALUES (:name, :logo, :grupo, :idList, :link, :ano, :category, :temporada, :episodio, :idTMDB, :trailler, :poster, :originalTitle, :backdrop, :sinopse, :nota)';
        //$sql = "INSERT INTO listaIPTV ({$columnString}) VALUES ({$valueString})";
        $sql = "INSERT INTO listaIPTV ({$columnString}) VALUES (:{$valueString})";
    }
        //print_r($array);
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
        $arr['ano']      = isset($resultado[1][0]) ? $resultado[1][0] : '5555';
        $arr['grupo']    = substr($arr['grupo'] , 1, -1); //Remove os parenteses do grupo
        $arr['category'] = 'Filme';
//        print_r($arr);

        //echo $arr['grupo'];die();
    } elseif ( preg_match_all($regExSeries, $arr['name'], $resultado) ) {
        //Series
        $arr['temporada'] = intval($resultado[2][0]);
        $arr['episodio']  = intval($resultado[4][0]);
        $arr['category']  = 'Serie';
    } else {
        //Canais de TV
        $arr['category'] = 'Canal-TV';
        $arr['name'] = trataSiglas($arr['name']);
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
            salvaRegistro($result, $pdo);

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
//print_r($log);
print_r($teste);//die();

echo 'terminou de inserir no DB...';
$tempoTotal = microtime(true) - $inicio;
echo 'Tempo de execução do primeiro script: ' . $tempoTotal;
