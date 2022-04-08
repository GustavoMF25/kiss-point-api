<?php
include '../app/config/config.php';
include '../app/config/conMysql.php';
$login = isset($_GET['usuario']) ? $_GET['usuario'] : null;
$senha = isset($_GET['senha']) ? md5($_GET['senha']) : null;

function validaLogin($login, $senha, $con)
{
    $return = [];
    $token = '';
    $sqlVerificaUsuario = "select iduser, name, email, login, photo from user where login = '{$login}' and password = '{$senha}'";
    $respVerificaUsuario = mysqli_query($con, $sqlVerificaUsuario);
    $validaUsuario = mysqli_fetch_array($respVerificaUsuario);
    if (isset($validaUsuario[0])) {
        $data = ['id' => $validaUsuario[0], 'nome' => $validaUsuario[1], 'email' => $validaUsuario[2], 'login' => $validaUsuario[3], 'token' => $token];
        return ['status' => true, 'dados' => $data];
    } else {
        $return = ['status' => false, 'error' => 'Usuário não encontrado.'];
    }
    return $return;
}

// print_r($_GET);
if (isset($login) && isset($senha)) {
    include '../app/config/conMysql.php';
    $response = [];
    $response = validaLogin($login, $senha, $con);

    if (count($response) > 0) {
        echo json_encode($response);
    }
} else {
    echo json_encode(['status' => false, 'error' => 'Digite um usuário e senha.']);
}
