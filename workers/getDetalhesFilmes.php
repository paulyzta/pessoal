<?php
/**
 * Created by PhpStorm.
 * User: danilo
 * Date: 29/11/18
 * Time: 10:57
 */

require ('../includes/conecta.php');

//header('Content-Type: text/html; charset=UTF-8');
$inicio = microtime(true);


function tirarAcentos($str) {
    $acentos = array('À', 'Á','Â','Ã','Ä','Å','Ç','È','É','Ê','Ë','Ì',
        'Í','Î','Ï','Ò','Ó','Ô','Õ','Ö','Ù','Ú','Û','Ü','Ý','à','á','â','ã','ä','å','ç','è'
    ,'é','ê','ë','ì','í','î','ï','ð','ò','ó','ô','õ','ö','ù','ú','û','ü','ý','ÿ', ' ', '[LEGENDADO]');

    $sem_acentos = array('A','A','A','A','A','A','C','E','E','E','E','I','I','I',
        'I','O','O','O','O','O','U','U','U','U','Y','a','a','a','a','a','a','c','e','e','e'
    ,'e','i','i','i','i','o','o','o','o','o','o','u','u','u','u','y','y', '+', '');

    return str_replace($acentos, $sem_acentos, $str);
}

function atualizaRegistro ($array, $pdo) {
    date_default_timezone_set('America/Sao_Paulo');
    echo date ("Y-m-d h:i:s");
    $array['updated'] = date('Y-m-d h:i:s', time());

    die($array['updated']);

    $update = '`updated` = :updated';
    foreach ($array AS $k => $v) {
        $update .= ", `$k` = :$k ";
    }
    $sql = "UPDATE listaIPTV SET  ".$update." WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $resp = $stmt->execute($array);

    return ($resp ? true : false);
//
//    if ($resp){
//        //registro salvo
//        return true;
//    } else {
//        //registro nao salvo
//        echo 'Deu ruim aqui...<pre>';
//        print_r($array);
//        die('<hr>');
//    }
}


function getDetalhes($titulo, $ano) {
    $titulo  = tirarAcentos($titulo);
    $apiURL  = 'https://api.themoviedb.org/3/search/movie?api_key=e83b1bc134fdaad358d19fff2edc74f9&language=pt-BR&query=';
    $minURL  = $apiURL.$titulo;
    $fullURL = $minURL."&year=$ano";


    $json = json_decode(file_get_contents($fullURL), true);
//    var_dump($json);
//    print_r($json['results'][0]);

    if ( empty($json['results'][0]) ) {
        $json = json_decode(file_get_contents($minURL), true);
    }


    return ( !empty($json['results'][0]) ? $json['results'][0] : false );
}

$sql = 'SELECT * FROM vw_Filmes WHERE idTMDB = -1 LIMIT 100';
//$sql = 'SELECT * FROM vw_Filmes WHERE Titulo LIKE \'%vingadores%\'';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$filmes = $stmt->fetchAll(PDO::FETCH_ASSOC);
$index = 0;

foreach ($filmes as $filme) {
    $tmdb = getDetalhes($filme['name'], $filme['ano']);

    if ( !empty($tmdb) ) {
        $res = [
            'id'            => $filme['id'],
            'idTMDB'        => $tmdb['id'],
            'trailler'      => (isset($tmdb['video']) ? true : false),
            'poster'        => $tmdb['poster_path'],
            'originalTitle' => $tmdb['original_title'],
            'backdrop'      => $tmdb['backdrop_path'],
            'sinopse'       => $tmdb['overview'],
            'nota'          => $tmdb['vote_average'],
        ];

        $index++;
        $update = atualizaRegistro($res, $pdo);

        if ( !$update ) {
            $erro['erro TMDB'][] = $filme;
        }
        //sleep(5);
    } else {
        echo 'Deu ruim...';
        $res = [
            'id' => $filme['id'],
            'idTMDB' => '-1',
        ];
        atualizaRegistro($res, $pdo);
        $erro[] = $filme;
    }

}


if ( isset($erro) ) {
    echo 'Alguns erro: <pre>';
    print_r($erro);
} else {
    echo '<h1>Nenhum erro!</h1>';
    echo "<h3>Total de pesquisas: $index</h3>";
}


$tempoTotal = microtime(true) - $inicio;
echo 'Tempo de execução (segundos): ' . (microtime(true) - $inicio);

echo '<br>Fim<hr>';