<?php
/**
 * Created by PhpStorm.
 * User: danilo
 * Date: 28/11/18
 * Time: 18:22
 */


if ( isset($_GET['filme']) ) {

    $_filme = $_GET['filme'];

    $url = 'https://api.themoviedb.org/3/search/movie?api_key=e83b1bc134fdaad358d19fff2edc74f9&language=pt-BR&page=1&include_adult=false&query=';

//    echo $url . $_filme;
    echo htmlspecialchars($_filme, ENT_COMPAT,'ISO-8859-1', true);
    die();
    $json_file = file_get_contents($url . $_filme);
    $json_str = json_decode($json_file, true);

    var_dump($json_str);

}