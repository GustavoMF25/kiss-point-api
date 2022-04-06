<?php
include '../../app/config/config.php';
include '../../app/config/conMysql.php';

$number1 = $_GET['num1'];
$number2 = $_GET['num2'];
$number3 = $_GET['num3'];
$number4 = $_GET['num4'];
$email = $_GET['email'];
$response = [];


$verify_email = "select iduser from user where email = '{$email}'";
$respUser = mysqli_query($con, $verify_email);
$usuario = mysqli_fetch_array($respUser)[0];
if (isset($usuario)) {
    $codeInsert = intval($number1 . $number2 . $number3 . $number4);
    $validaToken = "select code from tokenemail where iduser = $usuario and code = '{$codeInsert}'";
    $respValidaToken = mysqli_query($con, $validaToken);
    $tokenInsert = mysqli_fetch_array($respValidaToken);
    if (isset($tokenInsert)) {
        $response = ['status' => true, 'dados' => 'Altere a sua senha.'];
    } else {
        $response = ['status' => false, 'error' => 'Token invalida.'];
    }
}
echo json_encode($response);
