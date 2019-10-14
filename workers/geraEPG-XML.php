<?php

$arquivoFinal = 'meu_guia.xml';
$qtdDias = 1; //0 é igual a um dia. Ou seja, hoje.
$qtdTentativas = 4;


$dom = new DOMDocument('1.0', 'utf-8');
$dom->appendChild($dom->createElement('settings'))
    ->appendChild($dom->createElement('filename', $arquivoFinal))
        ->parentNode
    ->appendChild($dom->createElement('mode'))
        ->parentNode
    ->appendChild($dom->createElement('postprocess', 'mdb'))
        ->setAttribute('grab', 'true')
            ->parentNode
        ->setAttribute('run', 'false')
            ->parentNode
        ->parentNode
    ->appendChild($dom->createElement('user-agent', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:29.0) Gecko/20100101 Firefox/29.0'))
        ->parentNode
    ->appendChild($dom->createElement('logging', 'on'))
        ->parentNode
    ->appendChild($dom->createElement('retry', $qtdTentativas))
        ->setAttribute('time-out', '5')
            ->parentNode
        ->parentNode
    ->appendChild($dom->createElement('timespan', $qtdDias))
        ->parentNode
    ->appendChild($dom->createElement('update', 'f'));



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

    $variacoes = $_stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($variacoes AS $k => $v) {
        $nomeCanal  = str_replace('&','&amp;',$v['name']);
        if ($k === 0) {
            //Primeira opcao do canal.
            //Esse ganha o EPG e os demais (FHD, HD, alternativos e etc) ficam referenciados à ele.
            $canalPai = $nomeCanal;
            $channel = $dom->createElement('channel', $nomeCanal);
            $dom->firstChild->appendChild($channel)
                ->setAttribute('update', 'i')->parentNode
                ->setAttribute('site', $row['site'])->parentNode
                ->setAttribute('site_id', $row['id'])->parentNode
                ->setAttribute('xmltv_id', $nomeCanal)->parentNode;
        } else {
            $channel = $dom->createElement('channel', $nomeCanal);
            $dom->firstChild->appendChild($channel)
                ->setAttribute('offset', '0')->parentNode
                ->setAttribute('same_as', $canalPai)->parentNode
                ->setAttribute('xmltv_id', $nomeCanal)->parentNode;
        }
    }
    //Limpa o array
    unset($arr);
}



$dom->formatOutput = true; // set the formatOutput attribute of domDocument to true

// save XML as string or file
$test1 = $dom->saveXML();
$dom->save('../includes/WebGrab++.config.xml');
