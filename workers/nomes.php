<?php
/**
 * Created by PhpStorm.
 * User: danilo
 * Date: 23/11/18
 * Time: 15:32
 */

$inicio = microtime(true);

require('../includes/conecta.php');

$arquivo = '../includes/lista.m3u';
$listaURL= 'https://tinyurl.com/21983556876';
$arrErros = array();
$grupos = [];



function trata($line) {
    $l = explode('",', $line)[0].'"';
    $itens = array(
        'idList' => 'tvg-id',
        'name'   => 'name',
        'logo'   => 'logo',
        'grupo'  => 'group-title'
    );

    foreach ($itens AS $k => $v) {
        $start = substr( $l, ( strpos($l, $v.'=') + (strlen($v) +2) ) );
        $end   = substr( $start, 0,  strpos($start, '"') );

        //$result[$k] = mb_strtolower($end !== '' ? $end : '-' );
        $result[$k] = ($end !== '' ? $end : '-' );
    }
//
//    $result['grupo']  = $result['group-title'];
//    $result['idList'] = $result['tvg-id'];
//    unset($result['group-title'], $result['tvg-id']);
//    print_r($result);die();

    $result = categorizar($result);

    return $result;
}



function categorizar($arr) {

    $regExGrupo = '/^\(.*\)$/'; //Reconhece o ANO de producao do filme para definir que é um filme
    $regExFilmes = '/\s\((\d{4})\)/'; //Reconhece o ANO de producao do filme para definir que é um filme
    $regExSeries = '/([Ss]?)([0-9]{1,2})\s([eE\.\-]?)([0-9]{1,2})/'; //Busca por Sxx Exx para identificar uma serie

    if ( preg_match($regExGrupo, $arr['grupo']) ) {
        //Filmes
        preg_match_all($regExFilmes, $arr['name'], $resultado);

        $name = str_replace($resultado[0], '', $arr['name']);
        $name = str_replace('(leg)', '[LEGENDADO]', $name);

        $arr['name']     = $name;
        $arr['ano']      = isset($resultado[1][0]) ? $resultado[1][0] : '5555';
        $arr['grupo']    = substr($arr['grupo'] , 1, -1); //Remove os parenteses do grupo
        $arr['category'] = 'Filme';
//        print_r($arr);

        //echo $arr['grupo'];die();
    } elseif ( preg_match_all($regExSeries, $arr['name'], $resultado) ) {
        //Series
        $arr['temporada'] = intval($resultado[2][0]);
        $arr['episodio']  = intval($resultado[4][0]);
        $arr['category']  = 'Serie';
    } else {
        //Canais de TV
        $arr['category'] = 'Canal-TV';
        //$arr['name'] = trataSiglas($arr['name']);
    }
    $arr['grupo'] = ucwords($arr['grupo']);
    //$arr['name'] = ucwords($arr['name']);

    return $arr;
}




$linhas= file($arquivo);
//echo count($linhas);
$index = 0;

foreach($linhas as $linha) {

    if ( !strpos($linha, 'EXTM3U') ) {
        //remove a primeira linha
        if ( strpos($linha, 'EXTINF') ) {
            //trata a string com os dados do link
            $naoCanais = array('Desenhos 24H', 'Programas De TV 24H', 'Radios', 'ADULTOS');
            $r = trata($linha);
            //print_r($r);die();
            if ( $r['category'] === 'Canal-TV' && !in_array($r['grupo'], $naoCanais) ) {
                //Pega so oq é "Canal-TV" e tira os "naoCanais" deixando apenas os canais de TV mesmo


                $result[] = $r['name'].' - '.$r['grupo'];
                //$result[] = $r['name'];


                $teste = array(
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

                if ( !preg_match('/'.implode('|', $teste).'/', $r['name']) ) {
                    $lixo[] = $r['name'];
                }

            }
        }
    }

    //$index++;
    if ($index >= 20) {
        echo 'Interrompendo...';
        break;
    }

}

echo '<pre>';
//sort($result);
//print_r($result);

//echo '<hr>';
sort($lixo);

//print_r($teste);die();
//print_r($lixo);



$xml = simplexml_load_file('../includes/clarotv.com.br.channels.xml');

foreach ($xml->channels AS $channel) {

    foreach ($channel AS $c) {
//        echo $c;
//        echo str_replace(' [Brazil]', '', $c);
//        die();
        $nome = str_replace(' [Brazil]', '', $c);
        if ( in_array($nome, $lixo) ){

            //<channel update="i" site="meuguia.tv" site_id="canal/BBC" xmltv_id="BBC World News [Brazil]">BBC World News [Brazil]</channel>
            echo '<channel update="i" site="clarotv.com.br" site_id="'.$c['site_id'].'" xmltv_id="'.$nome.'">'.$nome.'</channel>'."\n";

            foreach ($teste AS $item) {
                echo '<channel offset="0" same_as="'.$nome.'" xmltv_id="'.$nome.$item.'">'.$nome.$item.'</channel>'."\n";
            }
           // die();

            /*
             * <channel offset="0" same_as="SPORT.TV1" xmltv_id="SPORT TV 1 HD">SPORT TV 1 HD</channel>
<channel offset="0" same_as="SPORT.TV1" xmltv_id="SPORT TV 1 FHD">SPORT TV 1 FHD</channel>
<channel offset="0" same_as="SPORT.TV1" xmltv_id="SPORT TV 1 XXX">SPORT TV 1 XXX</channel>
             * */

//            echo 'sim';
//            echo $c.'<br>';
            //echo $c['site_id'];
            //die();
        }


    }
}
