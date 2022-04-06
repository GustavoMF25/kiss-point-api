<?php
include '../../app/config/config.php';
$type = isset($_GET['type']) ? $_GET['type'] : null;
$modo = isset($_GET['modo']) ? $_GET['modo'] : null;
$response = [];



function verificaCode($code, $con)
{
    $verifyCode = "select count(idtokenemail) from tokenemail where code = '{$code}'";
    $respCode = mysqli_query($con, $verifyCode);
    $verCode = mysqli_fetch_array($respCode)[0];

    return $verCode;
}
if ($type == 'email') {

    include '../../app/config/conMysql.php';

    $verificaEmail = "select iduser from user where email = '{$modo}'";
    $resp = mysqli_query($con, $verificaEmail);
    $verifyEmail = mysqli_fetch_row($resp);

    if (isset($verifyEmail) && count($verifyEmail) == 1) {
        $code = rand(1000, 9999);

        while (verificaCode($code, $con) > 0) {
            $code = rand(1000, 9999);
        }
        $nowDate = date('Y-m-d');
        $nowHora = date("H:i:s");
        $insertCode = "insert into tokenemail values(null,{$verifyEmail[0]},{$code},'{$nowDate}','{$nowHora}')";
        if (mysqli_query($con, $insertCode)) {
            $response = ['status' => true, 'dados' => 'Código enviado para o E-mail solicitado.'];
        }else{
            $response = ['status' => false, 'error' => 'Erro ao enviar o código ao E-mail.'];
        }
    } else {
        $response = ['status' => false, 'error' => 'Email não encontrado'];
    }
}



if ($type == 'telefone') {
    $num = str_split(rand(1000, 9999));

    print_r($num);
}


echo json_encode($response);
