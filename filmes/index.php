<?php
/**
 * Created by PhpStorm.
 * User: danilo
 * Date: 28/11/18
 * Time: 09:46
 */


require ('../includes/conecta.php');

function getCategories($pdo) {
    $sql = 'SELECT * FROM vw_Generos';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $generos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $html = '<ul>';
    foreach ($generos as $value) {
        $html .= '<li><a href="listaFilme.php?genero='.$value['id'].'"> '.$value['genero'].' ('.$value['qtdFilmes'].')</a></li>';
    }
    $html .= '</ul>';

    return $html;

}


//
//$stmt = $pdo->prepare("SELECT * FROM listaIPTV WHERE category = :category ORDER BY name ASC ");
//$stmt->execute(array(':category' => 'filme'));
//$filmes = $stmt->fetchAll(PDO::FETCH_ASSOC);
//
//
//echo '<ul>';
//foreach ($filmes as $value) {
//    echo '<li>'.$value['name'].'</li>';
////    print_r($value);
////    die();
//}
//echo '</ul>';
//die();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de conteúdo da IPTV</title>
</head>
<body>
    <?php
        echo $t = getCategories($pdo);
    ?>
</body>
</html>