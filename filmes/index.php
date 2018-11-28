<?php
/**
 * Created by PhpStorm.
 * User: danilo
 * Date: 28/11/18
 * Time: 09:46
 */
header('Content-Type: text/html; charset=iso-8859-1');

require ('../includes/conecta.php');

function getCategories($pdo) {
    $sql = 'SELECT  grupo, count(name) AS total FROM listaIPTV WHERE category = :category GROUP BY grupo ORDER BY grupo ASC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':category' => 'filme'));
    $generos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $html = '<ul>';
    foreach ($generos as $value) {
        $html .= '<li>'.$value['grupo'].' ('.$value['total'].')</li>';
    }
    $html .= '</ul>';

    return $html;

}

echo $t = getCategories($pdo);
var_dump($t);
die();


$stmt = $pdo->prepare("SELECT * FROM listaIPTV WHERE category = :category ORDER BY name ASC ");
$stmt->execute(array(':category' => 'filme'));
$filmes = $stmt->fetchAll(PDO::FETCH_ASSOC);


echo '<ul>';
foreach ($filmes as $value) {
    echo '<li>'.$value['name'].'</li>';
//    print_r($value);
//    die();
}
echo '</ul>';
die();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de conteúdo da IPTV</title>
</head>
<body>
    <?php

    foreach ($filmes as $key => $value) {
        print_r($value);
        break;
    }
    ?>
</body>
</html>