<?php 
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
$type = isset($_GET['type'])? $_GET['type'] : null;
if($type == 'email'){
    $num = rand(1000,9999);

    print_r(str_split($num));
    // print_r(explode('',$num));
}
