<?php
/**
 * Created by PhpStorm.
 * User: danilo
 * Date: 28/11/18
 * Time: 18:22
 */



/*
 * Link q pega varios dados do sistema
 * https://api.themoviedb.org/3/configuration?api_key=e83b1bc134fdaad358d19fff2edc74f9
 * */



if ( isset($_GET['filme']) ) {

    $_filme = urlencode($_GET['filme']);
    $url = 'https://api.themoviedb.org/3/search/movie?api_key=e83b1bc134fdaad358d19fff2edc74f9&language=pt-BR&page=1&include_adult=false&query=';
          //https://api.themoviedb.org/3/movie/157336?api_key=e83b1bc134fdaad358d19fff2edc74f9
    $json = $url.$_filme;


    $json_file = file_get_contents($json);
    $json_str = json_decode($json_file, true);

    echo '<pre>';
    print_r($json_str);

}


http://image.tmdb.org/t/p/