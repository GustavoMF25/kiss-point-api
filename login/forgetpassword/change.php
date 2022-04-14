<?php
include '../../app/config/config.php';
include '../../app/config/conMysql.php';

$newPassword = isset($_GET['newPassword']) ? $_GET['newPassword'] : NULL;
$idusuario = isset($_GET['idusuario']) ? $_GET['idusuario'] : NULL;
$token = isset($_GET['token']) ? $_GET['token'] : NULL;

$response = [];
function alterPassword($con, $newPassword, $idusmuario)
{
    $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT); //password encryption
    $resp = [];
  echo  $sqlUpdatePassword = "UPDATE user SET password  = '{$hashed_password}' WHERE iduser = {$idusuario}";
    if (mysqli_query($con, $sqlUpdatePassword)) {
        $resp = ['status' => true, 'dados' => 'Senha alterada com sucesso'];
    }
    return $resp;
}

if (isset($newPassword) && isset($newPassword) && isset($token)) {

    $validaToken = "select count(*) from tokenemail where code = '{$token}'";
    $respValida = mysqli_query($con, $validaToken);
    $validar = mysqli_fetch_array($respValida);
    if ($validar > 0) {
        $response = alterPassword($con, $newPassword, $idusuario);
    } else {
        $response = ['status' => false, 'dados' => 'Token inválida.'];
    }
} else {
    $response = ['status' => false, 'dados' => 'Sem dados informados.'];
}
echo json_encode($response);
