<?php
/**
 * Created by PhpStorm.
 * User: danilo
 * Date: 28/11/18
 * Time: 17:18
 */

require ('../includes/conecta.php');

if ( isset($_GET['genero']) ) {

    $idGenero = $_GET['genero'];


    $sql  = 'SELECT * FROM vw_Filmes WHERE idGenero = :idGenero';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':idGenero' => $idGenero));
    $generos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $html = '<ul>';

    foreach ($generos AS $filme) {
        $poster = 'https://image.tmdb.org/t/p/w92/'.$filme['poster'];
        echo '<div style="border: 1px solid red; margin: 5px; padding: 5px;">';
        echo '<img src="'.$filme['logo'].'" alt="cartaz" title="cartaz">';
        echo '<img src="'.$poster.'" alt="cartaz" title="cartaz">';
        echo '<p>';
        echo $filme['name'];
        echo ' - '.$filme['ano'];
        echo $filme['nota'];
        echo '<span>'.$filme['originalTitle'].'</span>';

        echo '</p>';
        //https://image.tmdb.org/t/p/
        echo $filme['logo'];
        echo $filme['ano'];
        echo $filme['grupo'];
        echo $filme['idTMDB'];
        echo $filme['poster'];

        echo $filme['sinopse'];
        echo $filme['nota'];
        echo '</div>';
        die();






        print_r($filme);
//        $titulo = substr($filme['name'], 0, strpos($filme['name'], '('));
//
//        $url = 'https://api.themoviedb.org/3/search/movie?api_key=e83b1bc134fdaad358d19fff2edc74f9&language=pt-BR&page=1&include_adult=false&query=';
//
//        echo "<a href=\"filme.php?filme=$titulo\">$titulo</a>";
//        //https://api.themoviedb.org/3/search/movie?api_key=e83b1bc134fdaad358d19fff2edc74f9&language=pt-br&query=os%20vingadores&page=1&include_adult=false
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



/*



"base_url": "http://image.tmdb.org/t/p/",
    "secure_base_url": "https://image.tmdb.org/t/p/",
    "backdrop_sizes": [
      "w300",
      "w780",
      "w1280",
      "original"
    ],
    "logo_sizes": [
      "w45",
      "w92",
      "w154",
      "w185",
      "w300",
      "w500",
      "original"
    ],
    "poster_sizes": [
      "w92",
      "w154",
      "w185",
      "w342",
      "w500",
      "w780",
      "original"
    ],




 * */