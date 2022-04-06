<?php
//login
//password
//name
//email
//photo
//active ('y','n')
//datebirth
//country
//state
//city

// echo "CONEXÃO OK!";
// die();

require '../../vendor/autoload.php';
// include 'FuncSendEmail.php';

$login = isset($_GET['login']) ? $_GET['login'] : null;
$password = isset($_GET['password']) ? $_GET['password'] : null;
$name = isset($_GET['name']) ? $_GET['name'] : null;
$email = isset($_GET['email']) ? $_GET['email'] : null;
$photo = isset($_GET['photo']) ? $_GET['photo'] : null;
$datebirth = isset($_GET['datebirth']) ? $_GET['datebirth'] : null;
$country = isset($_GET['country']) ? $_GET['country'] : null;
$state = isset($_GET['state']) ? $_GET['state'] : null;
$city = isset($_GET['city']) ? $_GET['city'] : null;

$token = '';
$namePhoto = '';
$hashed_password = password_hash($password, PASSWORD_DEFAULT); //password encryption

function register($login, $hashed_password, $name, $email, $namePhoto, $datebirth, $country, $state, $city, $con)
{
    $return = [];

    $sqlVerifyLogin = "select 1 from user where login = '{$login}'";
    $resultVerifyLogin = mysqli_query($con, $sqlVerifyLogin);

    $sqlVerifyEmail = "select 1 from user where email = '{$email}'";
    $resultVerifyEmail = mysqli_query($con, $sqlVerifyEmail);

    if (mysqli_num_rows($resultVerifyLogin) > 0) {
        $return = ['status' => false, 'error' => 'Login indisponível.'];
    } elseif (mysqli_num_rows($resultVerifyEmail) > 0) {
        $return = ['status' => false, 'error' => 'Usuário já cadastrado'];
    } else {
        $sqlRegisterUser = "insert into user values (null,
                                                     '{$login}',
                                                     '{$hashed_password}',   
                                                     '{$name}',   
                                                     '{$email}', 
                                                     '{$namePhoto}',
                                                     '{$datebirth}',
                                                     '{$country}',
                                                     '{$state}',
                                                     '{$city}',
                                                     'n')";
        echo $sqlRegisterUser;
        if (mysqli_query($con, $sqlRegisterUser)) {
            $code = rand(100000, 999999);
            $sqlVerifyCode = "select 1 from tokenEmail 
                                  where code = '{$code}'";
            $resultVerifyCode  = mysqli_query($con, $sqlVerifyCode);
            if (mysqli_num_rows($resultVerifyCode) > 0) {
                $code = rand(100000, 999999);
            }

            // if (sendEmail($email, $code) == true) {
            //     $return = ['status' => true, 'sendEmail' => true];
            // } else {
            //     $return = ['status' => true, 'sendEmail' => false];
            // }
        } else {
            $return = ['status' => false, 'error' => 'Erro ao cadastrar usuário'];
        }
    }
    return $return;
}

if (
    isset($login) && isset($password) &&
    isset($name) && isset($email)

    // isset($country) && isset($state) &&
    // isset($city) && isset($datebirth)
) {
    include '../../app/config/conMysql.php';
    $response = [];
    $response = register($login, $hashed_password, $name, $email, $namePhoto, $datebirth, $country, $state, $city, $con);
} else {
    echo json_encode(['status' => false, 'error' => 'Preencha todos os campos.']);
}
print_r($response);
