<?php
include '../../app/config/config.php';
include '../../app/config/conMysql.php';


$newPassword = isset($_GET['newPassword']) ? $_GET['newPassword'] : NULL;
$idusuario = isset($_GET['idusuario']) ? $_GET['idusuario'] : NULL;

$response = [];
function alterPassword($con, $newPassword, $idusuario)
{
    $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT); //password encryption
    $resp = [];
    $sqlUpdatePassword = "UPDATE user SET password  = '{$hashed_password}' WHERE iduser = {$idusuario}";
    if (mysqli_query($con, $sqlUpdatePassword)) {
        $resp = ['status' => true, 'dados' => 'Senha alterada com sucesso'];
    }
    return $resp;
}

if (isset($newPassword) && isset($newPassword)) {
    $response = alterPassword($con, $newPassword, $idusuario);
}
echo json_encode($response);
