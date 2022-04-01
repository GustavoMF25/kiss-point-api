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
//emailVerified
echo "CONEXÃO OK";
die();
$login = isset($_GET['login']) ? $_GET['login'] : null;
$password = isset($_GET['password']) ? $_GET['password'] : null;
$name = isset($_GET['name']) ? $_GET['name'] : null;
$email = isset($_GET['email']) ? $_GET['email'] : null;
//$login = isset($_GET['photo']) ? $_GET['photo'] : null;
$country = isset($_GET['country']) ? $_GET['country'] : null;
$state = isset($_GET['state']) ? $_GET['state'] : null;
$city = isset($_GET['city']) ? $_GET['city'] : null;

if (
    isset($login) && isset($password) &&
    isset($name) && isset($email) &&
    isset($country) && isset($state) && isset($city)
) {

    include '../../app/config/conMysql.php';
    $response = [];
    $response = validaLogin($login, $senha, $con);

    if (count($response) > 0) {
        echo json_encode($response);
    }
} else {
    echo json_encode(['status' => false, 'error' => 'Digite um usuário e senha.']);
}
