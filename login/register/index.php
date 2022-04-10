<?php
include 'FuncSendEmail.php';

$login = isset($_GET['login']) ? $_GET['login'] : null;
$password = isset($_GET['password']) ? $_GET['password'] : null;
$name = isset($_GET['name']) ? $_GET['name'] : null;
$email = isset($_GET['email']) ? $_GET['email'] : null;
$photo = isset($_GET['photo']) ? $_GET['photo'] : null;
$phone = isset($_GET['phone']) ? $_GET['phone'] : null;
$datebirth = isset($_GET['datebirth']) ? implode('-', array_reverse(explode('/', $_GET['datebirth']))) : null;
$country = isset($_GET['country']) ? $_GET['country'] : null;
$state = isset($_GET['state']) ? $_GET['state'] : null;
$city = isset($_GET['city']) ? $_GET['city'] : null;

$token = '';
$namePhoto = '';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT); //password encryption

function verifyCode($code, $con)
{
    $verifyCode = "select count(idtokenemail) from tokenemail where code = '{$code}'";
    $respCode = mysqli_query($con, $verifyCode);
    $verCode = mysqli_fetch_array($respCode)[0];

    return $verCode;
}

function register($login, $hashedPassword, $name, $email, $namePhoto, $phone, $datebirth, $country, $state, $city, $con)
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
        $sqlRegisterUser = "insert into user values (null,
                                                     '{$login}',
                                                     '{$hashedPassword}',   
                                                     '{$name}',   
                                                     '{$email}', 
                                                     '{$namePhoto}',
                                                     '{$phone}',
                                                     'y',
                                                     '{$datebirth}',
                                                     '{$country}',
                                                     '{$state}',
                                                     '{$city}',
                                                     'n')";

        if (mysqli_query($con, $sqlRegisterUser)) {
            $idUser = mysqli_insert_id($con);

            $code = rand(1000, 9999);
            while (verifyCode($code, $con) > 0) {
                $code = rand(1000, 9999);
            }

            $nowDate = date('Y-m-d');
            $nowHora = date("H:i:s");
            $insertCode = "insert into tokenemail values(null,{$idUser},{$code},'{$nowDate}','{$nowHora}')";

            if (mysqli_query($con, $insertCode)) {
                $mensagem = "Segue abaixo códogo solicitádo <br> $code";
                if (sendEmail($email, $mensagem) == true) {
                    $response = ['status' => true, 'sendEmail' => true];
                } else {
                    $response = ['status' => true, 'sendEmail' => false];
                }
            } else {
                $response = ['status' => false, 'error' => 'Erro ao enviar o código ao E-mail.'];
            }
        } else {
            $response = ['status' => false, 'error' => 'Erro ao cadastrar usuário'];
        }
    }
    return $response;
}

if (
    isset($login) && isset($password) &&
    isset($name) && isset($email)
    //isset($country) && isset($state) &&
    //isset($city) && isset($datebirth)
) {
    include '../../app/config/conMysql.php';
    $response = [];
    $response = register($login, $hashedPassword, $name, $email, $namePhoto, $phone, $datebirth, $country, $state, $city, $con);
} else {
    $response = ['status' => false, 'error' => 'Preencha todos os campos.'];
}

echo json_encode($response);
mysqli_close($con);
