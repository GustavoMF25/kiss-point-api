<?php
date_default_timezone_set('America/Sao_Paulo');

$code = isset($_GET['code']) ? $_GET['code'] : null;
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

if (
    isset($login) && isset($password) &&
    isset($name) && isset($email) &&
    isset($datebirth)
    //isset($country) && isset($state) &&
    //isset($city) && isset($datebirth)
) {
    include '../../app/config/conMysql.php';
    $response = [];
    $token = '';

    $sqlVerifyCode = "select dategen, hourgen from tokenregister where code = {$code} and emailuser = '{$email}'";
    $resultVerifyCode = mysqli_query($con, $sqlVerifyCode);

    $sqlVerifyLogin = "select 1 from user where login = '{$login}'";
    $resultVerifyLogin = mysqli_query($con, $sqlVerifyLogin);

    $sqlVerifyEmail = "select 1 from user where email = '{$email}'";
    $resultVerifyEmail = mysqli_query($con, $sqlVerifyEmail);

    if (mysqli_num_rows($resultVerifyLogin) > 0) {
        $response = ['status' => false, 'error' => 'Login indisponível.'];
    } elseif (mysqli_num_rows($resultVerifyEmail) > 0) {
        $response = ['status' => false, 'error' => 'Usuário já cadastrado'];
    } elseif (mysqli_num_rows($resultVerifyCode) > 0) {
        $rowVerifyCode = mysqli_fetch_array($resultVerifyCode);
        $dateTimeGenCode = date("$rowVerifyCode[0] $rowVerifyCode[1]");

        $time1 = new DateTime($dateTimeGenCode);
        $time2 = $time1->diff(new DateTime(date('Y-m-d H:i:s')));
        $differenceHours = $time2->format("%h");

        if ($differenceHours  <= 24) {
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
                                                     'y')";

            if (mysqli_query($con, $sqlRegisterUser)) {
                $idUser = mysqli_insert_id($con);
                $data = ['id' => $idUser, 'nome' => $name, 'email' => $email, 'login' => $login, 'token' => $token];

                $sqlUpdateToken = "update tokenregister set used = 'y' where where code = {$code} and emailuser = '{$email}'";
                mysqli_query($con, $sqlUpdateToken);

                $response = ['status' => true, 'response' => 'Usuário cadastrado com sucesso', 'dados' => $data];
            } else {
                $response = ['status' => false, 'error' => 'Erro ao cadastrar usuário'];
            }
        } else {
            $response = ['status' => false, 'error' => 'Código de confirmação expirado.'];
        }
    } else {
        $response = ['status' => false, 'error' => 'Código de confirmação inválido.'];
    }
} else {
    $response = ['status' => false, 'error' => 'Preencha todos os campos.'];
}

echo json_encode($response);
mysqli_close($con);
