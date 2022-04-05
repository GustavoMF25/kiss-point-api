<?php 

$type = $_POST['type'];
print_r( $_POST['type']);
if($type == 'email'){
    $num = rand(1000,9999);
    print_r(explode('',$num));
}
