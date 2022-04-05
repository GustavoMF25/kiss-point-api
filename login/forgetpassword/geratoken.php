<?php 
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
$type = $_POST['type'];
print_r($_REQUEST);
print_r( $_POST['type']);
if($type == 'email'){
    $num = rand(1000,9999);
    print_r(explode('',$num));
}
