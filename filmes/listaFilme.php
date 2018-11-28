<?php
/**
 * Created by PhpStorm.
 * User: danilo
 * Date: 28/11/18
 * Time: 17:18
 */

require ('../includes/conecta.php');

if ( isset($_GET['genero']) ) {

    $_genero = $_GET['genero'];


    $sql  = 'SELECT * FROM listaIPTV WHERE category = :category AND grupo = :grupo';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':category' => 'filme', ':grupo' => $_genero));
    $generos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $html = '<ul>';

    foreach ($generos AS $filme) {
        $titulo = substr($filme['name'], 0, strpos($filme['name'], '('));

        $url = 'https://api.themoviedb.org/3/search/movie?api_key=e83b1bc134fdaad358d19fff2edc74f9&language=pt-BR&page=1&include_adult=false&query=';

        echo "<a href=\"$url.$titulo\">$titulo</a>";
        //https://api.themoviedb.org/3/search/movie?api_key=e83b1bc134fdaad358d19fff2edc74f9&language=pt-br&query=os%20vingadores&page=1&include_adult=false
        die();




//        $html .= "
//            <li>
//                <strong>Título: </strong> ".$genero['name']."<br>
//                <strong>Logo: </strong> ".$genero['logo']."<br>
//                <strong>Grupo: </strong> ".$genero['grupo']."<br>
//                <strong>Link:</strong> ".$genero['link']."<br>
//                <strong>Category:</strong> ".$genero['category']."<br>
//            </li>";
//
//        $html .= "<img src=\"$genero[logo]\">";

        //https://www.themoviedb.org/search?query=os%20vingadores&language=pt-BR



    }
    $html .= '</ul>';
    echo $html;
    die('ssss');

    var_dump($genero);


    //echo $genero;

}