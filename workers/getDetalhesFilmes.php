<?php
/**
 * Created by PhpStorm.
 * User: danilo
 * Date: 29/11/18
 * Time: 10:57
 */

require ('../includes/conecta.php');

header('Content-Type: text/html; charset=UTF-8');
$inicio = microtime(true);


function tirarAcentos($str) {
    $acentos = array('À', 'Á','Â','Ã','Ä','Å','Ç','È','É','Ê','Ë','Ì',
        'Í','Î','Ï','Ò','Ó','Ô','Õ','Ö','Ù','Ú','Û','Ü','Ý','à','á','â','ã','ä','å','ç','è'
    ,'é','ê','ë','ì','í','î','ï','ð','ò','ó','ô','õ','ö','ù','ú','û','ü','ý','ÿ', ' ');

    $sem_acentos = array('A','A','A','A','A','A','C','E','E','E','E','I','I','I',
        'I','O','O','O','O','O','U','U','U','U','Y','a','a','a','a','a','a','c','e','e','e'
    ,'e','i','i','i','i','o','o','o','o','o','o','u','u','u','u','y','y', '+');

    return str_replace($acentos, $sem_acentos, utf8_encode($str));
}

function atualizaRegistro ($array, $pdo) {
    date_default_timezone_set('America/Sao_Paulo');
    $array['updated'] = date('Y-m-d h:i:s', time());

    $sql  = "UPDATE listaIPTV SET idTMDB = :idTMDB, trailler = :trailler, poster = :poster, originalTitle = :originalTitle, backdrop = :backdrop, sinopse = :sinopse, nota = :nota, updated = :updated WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $resp = $stmt->execute($array);

    if ($resp){
        //registro salvo
        return true;
    } else {
        //registro nao salvo
        echo 'Deu ruim aqui...<pre>';
        print_r($array);
        die('<hr>');
    }
}


function getDetalhes($titulo, $ano) {
    $titulo = tirarAcentos($titulo);
    $apiURL = "https://api.themoviedb.org/3/search/movie?api_key=e83b1bc134fdaad358d19fff2edc74f9&language=pt-BR&query=$titulo&year=$ano";
    $json = json_decode(file_get_contents($apiURL), true);

    return $json['results'][0];
}

$sql = 'SELECT * FROM vw_Filmes WHERE idTMDB = 0 LIMIT 20';
//$sql = 'SELECT * FROM vw_Filmes WHERE Titulo LIKE \'%vingadores%\'';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$filmes = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($filmes as $filme) {
    $tmdb = getDetalhes($filme['Titulo'], $filme['Ano']);

    if ( !empty($tmdb) ) {
        $res = [
            'id' => $filme['id'],
            'idTMDB' => $tmdb['id'],
            'trailler' => (isset($tmdb['video']) ? true : false),
            'poster' => $tmdb['poster_path'],
            'originalTitle' => $tmdb['original_title'],
            'backdrop' => $tmdb['backdrop_path'],
            'sinopse' => utf8_decode($tmdb['overview']),
            'nota' => $tmdb['vote_average'],
        ];

        atualizaRegistro($res, $pdo);
        //sleep(5);
    } else {
        $erro[] = $filme;
    }

}

echo 'Algum erro?';
print_r($erro);

$tempoTotal = microtime(true) - $inicio;
echo 'Tempo de execução (segundos): ' . (microtime(true) - $inicio);

echo '<br>Fim<hr>';