<?php
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
$type = isset($_GET['type']) ? $_GET['type'] : null;
$modo = isset($_GET['modo']) ? $_GET['modo'] : null;
if ($type == 'email') {
    $num = str_split(rand(1000, 9999));
    echo $modo;

}



if ($type == 'telefone') {
    $num = str_split(rand(1000, 9999));

    print_r($num);
}
