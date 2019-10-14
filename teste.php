<?php

echo date("\yY\mm\wW");
echo '<br>';
echo date("YmW");
echo '<br>';
echo date('l jS \of F Y h:i:s A');

die();

$output = shell_exec('ls -lart');
echo "<pre>$output</pre>";



























die();

require('includes/conecta.php');

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
        //echo $v['name'].'<br>';
        $nomeCanal  = str_replace('&','&amp;',$v['name']);
        if ($k === 0) {
            $canalPai = $nomeCanal;
            echo '<channel update="i" site="'.$row['site'].'" site_id="'.$row['id'].'" xmltv_id="'.$nomeCanal.'">'.$nomeCanal.'</channel>'."\n";
        } else {
            echo '<channel offset="0" same_as="'.$canalPai.'" xmltv_id="'.$nomeCanal.'">'.$nomeCanal.'</channel>'."\n";
        }
    }
    //Limpa o array
    unset($arr);



}

die();










$filtro = array(
    ' - Alternativo',
    ' - FHD',
    ' -FHD',
    ' -H265',
    ' Alternativo',
    ' FHD',
    ' H265',
    ' HD',
    ' HD Alternativo',
    ' HD ‐ Alternativo',
    ' UHD - 4K',
    ' -Alternativo',
    ' - LEG',
    ' ‐FHD',
    ' H65',
    '-H265',
    ' Aternativo',
    ' 24h',
);

$f = array(
    ' Aternativo',

    ' Alternativo',
    ' -Alternativo',
    ' - Alternativo',

    ' alternativo',
    ' -alternativo',
    ' - alternativo',

    ' Alternativo HD',
    ' -Alternativo HD',
    ' - Alternativo HD',

    ' HD Alternativo',
    ' -Alternativo',
    ' - Alternativo',

);

$sql = "SELECT nomeListaIPTV AS canal, claro_id AS id, 'clarotv.com.br' AS site  FROM nomeCanaisEPG WHERE claro_id > 0 LIMIT 1000";
//$sql = "SELECT nomeListaIPTV AS canal, TVMagazine_id AS id, 'tvmagazine.com.br' AS site  FROM nomeCanaisEPG WHERE TVMagazine_id <> '' AND TVMagazine_id <> -1 LIMIT 1000";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($rows as $row) {
    $canal  = str_replace('&','&amp;',$row['canal']);
    echo '<channel update="i" site="'.$row['site'].'" site_id="'.$row['id'].'" xmltv_id="'.$canal.'">'.$canal.'</channel>'."\n";
    //echo $canal."<br>";

    foreach ($filtro AS $f) {
        echo '<channel offset="0" same_as="'.$canal.'" xmltv_id="'.$canal.$f.'">'.$canal.$f.'</channel>'."\n";


        //echo $canal.$f.'<br>';

        //<channel update="i" site="clarotv.com.br" site_id="110" xmltv_id="TV Senado">TV Senado</channel>
        //<channel offset="0" same_as="TV Senado" xmltv_id="TV Senado - Alternativo">TV Senado - Alternativo</channel>
    }
    die();
}


die();


















$external_link = 'https://i.imgur.com/45r6wmn.png';



$im = @imagecreatefromjpeg($external_link);
if($im) {
    var_dump($im);
} else {
    echo 'nada';
}

die();
function checkRemoteFile($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    // don't download content
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($ch);
    curl_close($ch);
    if($result !== false) {
        echo 'aha';
        return true;
    } else {
        return false;
    }
}

var_dump(@getimagesize($external_link));

if (@getimagesize($external_link)) {
    echo  'image exists ';
    echo '<img src="'.$external_link.'">';
} else {
    echo  'image does not exist ';
}

echo checkRemoteFile($external_link);