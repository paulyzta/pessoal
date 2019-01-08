<?php
/**
 * Created by PhpStorm.
 * User: danilo
 * Date: 08/01/19
 * Time: 14:40
 */

require('../includes/conecta.php');

$teste = array(
    'SporTV' => [
        'SPortv 2',
        'SPortv 3',
    ],
    'Fox Sports' => [
        'Fox SPorts 2',
    ],
    'ESPN' => [
        'ESPn 2',
        'ESPn Brasil',
        'ESPn Extra',
    ],
    'HBO' => [
        'Hbo 2',
        'Hbo Family',
        'Hbo Plus',
        'Hbo Signature',
    ],
    'HBO Plus' => [
        'Hbo Plus E'
    ],
    'Max Prime' => [
        'Max Prime E'
    ],
    'Max' => [
        'Max Prime',
        'Max Up'
    ],
    'TNT' => [
        'Tnt Séries'
    ],
    'Fox' => [
        'Fox Life',
        'Fox Premium 1',
        'Fox Premium 2'
    ],
    'MTV' => [
        'Mtv Live'
    ],
);


$sql = "SELECT nomeListaIPTV AS canal, claro_id AS id, 'clarotv.com.br' AS site, grupo  FROM nomeCanaisEPG WHERE claro_id > 0 LIMIT 1000";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

//foreach ($rows AS $r) {
//    echo $r['canal'].'<br>';
//}
//
//die();

foreach ($rows as $row) {
    $_sql = "SELECT name, grupo FROM listaIPTV WHERE grupo = ? AND name LIKE ?";
    $arr[] = $row['grupo'];
    $arr[] = "%{$row['canal']}%";
    //verifica se o canal é um dos problematicos
    if ( array_key_exists($row['canal'], $teste) ) {
        foreach ( $teste[$row['canal']] AS $k => $v ) {
            $arr[] = "%{$v}%";
            $_sql .= ' AND name NOT LIKE ?';
        }
    }
    $_sql .= ' ORDER BY name';
    $_stmt = $pdo->prepare($_sql);
    for ($i = 0; $i < count($arr); $i++) {
        $_stmt->bindValue(($i+1), $arr[$i], PDO::PARAM_STR);
    }
    $_stmt->execute();
//    $_stmt->debugDumpParams();
//    echo $_sql;
//    echo $_stmt->rowCount();



    $variacoes = $_stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($variacoes AS $k => $v) {
        $nomeCanal  = str_replace('&','&amp;',$v['name']);
        if ($k === 0) {
            //Primeira opcao do canal.
            //Esse ganha o EPG e os demais (FHD, HD, alternativos e etc) ficam referenciados à ele.
            $canalPai = $nomeCanal;
            //echo '<channel update="i" site="'.$row['site'].'" site_id="'.$row['id'].'" xmltv_id="'.$nomeCanal.'">'.$nomeCanal.'</channel>'."\n";
            echo htmlspecialchars('<channel update="i" site="'.$row['site'].'" site_id="'.$row['id'].'" xmltv_id="'.$nomeCanal.'">'.$nomeCanal.'</channel>').'<br>';
        } else {
            //echo '<channel offset="0" same_as="'.$canalPai.'" xmltv_id="'.$nomeCanal.'">'.$nomeCanal.'</channel>'."\n";
            echo htmlspecialchars('<channel offset="0" same_as="'.$canalPai.'" xmltv_id="'.$nomeCanal.'">'.$nomeCanal.'</channel>').'<br>';
        }
    }
    //Limpa o array
    unset($arr);



}