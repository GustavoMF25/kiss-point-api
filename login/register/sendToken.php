<?php
require '../../vendor/autoload.php';
include 'FuncSendEmail.php';

$login = isset($_GET['login']) ? $_GET['login'] : null;
$name = isset($_GET['name']) ? $_GET['name'] : null;
$email = isset($_GET['email']) ? $_GET['email'] : null;
$password = isset($_GET['password']) ? $_GET['password'] : null;

function verifyCode($code, $con)
{
    $verifyCode = "select count(idtokenemail) from tokenemail where code = '{$code}'";
    $respCode = mysqli_query($con, $verifyCode);
    $verCode = mysqli_fetch_array($respCode)[0];

    return $verCode;
}

function sendCode($login, $email, $con)
{
    $response = [];
    $sqlVerifyLogin = "select 1 from user where login = '{$login}'";
    $resultVerifyLogin = mysqli_query($con, $sqlVerifyLogin);

    $sqlVerifyEmail = "select 1 from user where email = '{$email}'";
    $resultVerifyEmail = mysqli_query($con, $sqlVerifyEmail);

    if (mysqli_num_rows($resultVerifyLogin) > 0) {
        $response = ['status' => false, 'error' => 'Login indisponível.'];
    } elseif (mysqli_num_rows($resultVerifyEmail) > 0) {
        $response = ['status' => false, 'error' => 'Usuário já cadastrado'];
    } else {
        $code = rand(1000, 9999);
        while (verifyCode($code, $con) > 0) {
            $code = rand(1000, 9999);
        }

        $nowDate = date('Y-m-d');
        $nowHora = date("H:i:s");
        $insertCode = "insert into tokenregister values(null,'{$email}',{$code},'{$nowDate}','{$nowHora}', 'n')";

        if (mysqli_query($con, $insertCode)) {
            $mensagem = "Segue abaixo o código solicitado <br> $code";
            if (sendEmail($email, $mensagem) == true) {
                $response = ['status' => true, 'dados' => 'Código enviado para o E-mail solicitado.'];
            } else {
                $response = ['status' => false, 'error' => "Erro ao enviar o código de E-mail."];
            }
        } else {
            $response = ['status' => false, 'error' => "Erro ao enviar o código de E-mail."];
        }
        return $response;
    }
}

if (
    isset($login) && isset($password) &&
    isset($name) && isset($email)
    //isset($country) && isset($state) &&
    //isset($city) && isset($datebirth)
) {
    include '../../app/config/conMysql.php';
    $response = [];
    $response = sendCode($login, $email, $con);
    mysqli_close($con);
} else {
    $response = ['status' => false, 'error' => 'Preencha todos os campos.'];
}

echo json_encode($response);
