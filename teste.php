<pre>
<?php
/**
 * Created by PhpStorm.
 * User: danilo
 * Date: 26/11/18
 * Time: 09:14
 */





$x = '05';

//var_dump($x);

echo is_numeric($x);
die();
echo intval($x);
var_dump(intval('05.5'));
echo is_numeric($x);



die();











// Sua string:
$string = '22 milhas (2018) (leg)';

$array = array(
        'a descoberta (2017)',
        'a era do gelo 3 (2009)',
        '211: o grande assalto (2018)',
        '22 de julho (2018)',
        '22 milhas (2018) (leg)',

        'the walking dead s01 e01',
        'the walking dead s01 e02',
        'the walking dead s01 e03',
        'the walking dead s01 e04',
        'the walking dead s01 e05',
        'the walking dead s01 e06',
        'the walking dead s02 e01',
        'the walking dead s02 e02',

        'globo rpc tv paraná',
        'globo nsc tv florianopolis fhd',
        'globo nsc tv florianopolis hd',
        'globo nsc tv florianopolis',
        'globo nsc tv chapecó fhd',
        'globo nsc tv chapecó hd',
);

// Regex (leia o final para entender!):
$regrex = '/\s\((\d{4})\)/';
$regExSeries = '/([Ss]?)([0-9]{1,2})\s([eE\.\-]?)([0-9]{1,2})/';
//$regrex = '/\(([0-9]{1,2})\)/';

// Usa o REGEX:
$x = preg_match_all($regrex, $string, $resultado);

echo '<pre>';



foreach ($array AS $i) {
    if (preg_match_all($regrex, $i, $resultado)) {
        print_r($resultado);
        echo '|' . $resultado[1][0] . '|';
        echo '<hr>';
        echo 'Original: ' . $i . ' Novo: ';
        echo '|' . str_replace($resultado[0], '', $i) . '|';
        echo '<hr>';

        echo '>'.str_replace('(leg)', '[LEGENDADO]', $i).'<';
    }
    if (preg_match_all($regExSeries, $i, $resultado)) {
        print_r($resultado);
    }
}

function categorizar($arr) {
    $regExFilmes = '/\s\((\d{4})\)/'; //Reconhece o ANO de producao do filme para definir que é um filme
    $regExSeries = '/([Ss]?)([0-9]{1,2})\s([eE\.\-]?)([0-9]{1,2})/'; //Busca por Sxx Exx para identificar uma serie

    if ( preg_match_all($regExFilmes, $arr['name'], $resultado) ) {
        //Filmes
        $name = str_replace($resultado[0], '', $arr['name']);
        str_replace('(leg)', '[LEGENDADO]', $name);

        $arr['name']     = $name;
        $arr['Ano']      = $resultado[1][0];
        $arr['grupo']    = substr($arr['grupo'] , 1, -1); //Remove os parenteses do grupo
        $arr['category'] = 'Filme';
    } elseif ( preg_match_all($regExSeries, $arr['name'], $resultado) ) {
        //Series
        $arr['temporada'] = $resultado[2][0];
        $arr['episodio']  = $resultado[4][0];
        $arr['category']  = 'Serie';
    } else {
        //Canais de TV
        $arr['category'] = 'Canal-TV';
    }
    $arr['grupo'] = ucwords($arr['grupo']);
    $arr['name'] = ucwords($arr['name']);

    return $arr;
}