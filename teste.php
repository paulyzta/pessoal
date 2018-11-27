<pre>
<?php
/**
 * Created by PhpStorm.
 * User: danilo
 * Date: 26/11/18
 * Time: 09:14
 */


//$pdo = new PDO("mysql:host=localhost;dbname=dev_db", "user_db", "123456");

date_default_timezone_set('America/Sao_Paulo');
//$date = date('m/d/Y h:i:s a', time());
$now = date('Y-m-d h:i:s', time());

echo $date;
die();









try{
    $pdo = new pdo( 'mysql:host=127.0.0.1:3306;dbname=dev_db',
        'user_db',
        '123456');
}
catch(PDOException $ex){
    die(json_encode(array('outcome' => false, 'message' => 'Unable to connect')));
}

$result = $pdo->prepare('SELECT * FROM teste');
$result->execute();

foreach ($pdo->query('SELECT * FROM teste') as $item) {
    echo $item['id'];
    echo '<hr>';
    
}

var_dump($result);


die('------');


if ($_COOKIE['nome']) {
    echo 'cookie existe';
} else {
    echo 'cookie NAO existe';
    // Cria o novo cookie para durar duas horas
    setcookie('nome', 'Ciclano', (time() + (20)));
    echo '<br>cookie criado agora';
}


echo '<pre>';
print_r($_COOKIE);

die('FIM');




if ($_SESSION['teste']) {
//    session_start();
    echo 'existe e é igual :';
    echo $_SESSION['teste'];
//    $_SESSION['teste'] = true;
} else {
    echo 'nao existe...';
    session_start();
    $_SESSION['teste'] = 'porra';
    if ($_SESSION['teste']) {
        echo 'agora sim';
    }
}


die();

?>

<script>
    <?php
    echo 'var teste = '.json_encode($teste).';';
    ?>

    var test = '';
console.log('>>>', teste);

if (typeof(Storage) !== "undefined") {
    localStorage.setItem("porra", JSON.stringify(test));
    setTimeout(function() {
        var itens = JSON.parse(localStorage.getItem("porra"));
        for (var s of itens) {
            var node = document.createElement("LI");
            node.innerHTML = s;
            document.getElementById("result").appendChild(node);
        };
  }, 5000);
} else {
    var node = document.createElement("LI");
    node.innerHTML = "'localStorage' Não suportado";
    document.getElementById("result").appendChild(node);

}

if (localStorage.getItem("porras") ) {
    alert('sim')
} else {
    alert('nao')
    localStorage.setItem('porras', 'testando...')
}

</script>
