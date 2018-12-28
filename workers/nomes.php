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
            $naoCanais = array('Desenhos 24Hs', 'Desenhos Classicos 24Hs', 'Programas De TV 24Hs', 'Radios', 'ADULTOS');
            $r = trata($linha);
            //print_r($r);die();
            if ( $r['category'] === 'Canal-TV' && !in_array($r['grupo'], $naoCanais) ) {
                //Pega so oq é "Canal-TV" e tira os "naoCanais" deixando apenas os canais de TV mesmo
                //$result[] = $r['name'].' - '.$r['grupo'];
                $result[] = $r['name'];

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

                if ( !preg_match('/'.implode('|', $filtro).'/', $r['name']) ) {
                    //$filtrados[] = $r['name'];
                    //$filtrados[] = $r['name'].' - '.$r['grupo'];
                    $todosCanais[$r['grupo']][] = $r['name'];
                    //$filtrados[] = $r['name'].' HD';
                }

            }
        }
    }
}

//INSERT INTO `nomeCanaisEPG`(`id`, `nomeListaIPTV`, `nomeListaCLARO`, `nomeListaTVMAGAZINE`) VALUES ([value-1],[value-2],[value-3],[value-4])

echo '<pre>';
//sort($result);
//print_r($result);

//echo '<hr>';
//sort($teste);

//print_r($teste);die();
//print_r($todosCanais);die();

foreach ($todosCanais AS $grupo => $canais) {
    //echo $canais;
    //echo $grupo;
    foreach ($canais AS $canal) {
        //echo $canal;
        echo "INSERT INTO nomeCanaisEPG (grupo, nomeListaIPTV) VALUE ('$grupo', '$canal');<br>";

    }

    //echo "INSERT INTO nomeCanaisEPG (nomeListaIPTV) VALUE ('$i');<br>";
}


die();



//$xml = simplexml_load_file('../includes/clarotv.com.br.channels.xml');
$xml = simplexml_load_file('../includes/tvmagazine.com.br.channels.xml');

foreach ($xml->channels AS $channel) {
    foreach ($channel AS $c) {
        //echo $c->getName();
//        echo $c;
//        echo '<hr>';
        //print_r($c->getNamespaces());
//        echo $c->getName();
//        echo str_replace(' [Brazil]', '', $c);
//        var_dump($c);
//        die();
        $nome = str_replace(' [Brazil]', '', $c);
        //$nome = str_replace('+', 'Mais', $nome);
        //echo '|'.$nome.'|<br>';

        if ( in_array(strtolower($nome), array_map('strtolower', $filtrados)) ) {

            //<channel update="i" site="meuguia.tv" site_id="canal/BBC" xmltv_id="BBC World News [Brazil]">BBC World News [Brazil]</channel>
            //echo '<channel update="i" site="'.$c['site'].'" site_id="'.$c['site_id'].'" xmltv_id="'.$nome.'">'.$nome.'</channel>'."\n";

            foreach ($filtro AS $item) {
                //echo '<channel offset="0" same_as="'.$nome.'" xmltv_id="'.$nome.$item.'">'.$nome.$item.'</channel>'."\n";
            }

        } else {
            $deuRuim[] = $nome;
        }
    }
}
print_r($filtrados);
echo '<hr>';
print_r($deuRuim);
