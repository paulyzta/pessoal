<?php


$xml = simplexml_load_file('includes/meuguia.tv.channels.xml');

foreach ($xml->channels AS $channel) {

    foreach ($channel AS $c) {

        echo $c.'<br>';
        echo $c['site_id'];
        die();
    }
}










die();




















require('includes/conecta.php');

$sql = "SELECT * FROM `listaIPTV` WHERE category = 'Canal-TV' AND logo LIKE '%imgur%' LIMIT 100";


$stmt = $pdo->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($rows as $row) {
    echo $row['logo'];


//    if (@getimagesize($row['logo'])) {
//        echo  'image exists ';
//        echo '<img src="'.$row['logo'].'">';
//    } else {
//        echo  'image does not exist ';
//    }

    $im = @imagecreatefrompng($row['logo']);
    if($im) {
        //var_dump($im);
        echo '<img src="'.$row['logo'].'" title="'.$row['name'].'" alt="'.$row['id'].'" width="20">';
    } else {
        echo 'nada';
        var_dump($im);
    }


    echo '<br>';


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