<?php 

$type = $_POST['type'];

if($type == 'email'){
    $num = $gera = rand(1000,9999);
    print_r(explode('',$num));
}