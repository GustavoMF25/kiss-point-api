<?php

$login = isset($_POST['usuario']) ? $_POST['usuario'] : null;
$senha = isset($_POST['senha']) ? $_POST['senha'] : null;


if (isset($login) && isset($senha)) {
    include './app/config/conMysql.php';

    function validaLogin($login, $senha, $con)
    {
        $return = [];
        $token = '';
        $codSenha = md5($senha);
        $sqlVerificaUsuario = "select idusuario, nome, email, login from usuario where login = '{$login}' && senha = '${$codSenha}'";
        $respVerificaUsuario = mysqli_query($con, $sqlVerificaUsuario);
        $validaUsuario = mysqli_fetch_array($respVerificaUsuario);
        if (isset($validaUsuario[0])) {
            $data = ['id' => $validaUsuario[0], 'nome' => $validaUsuario[1], 'email' => $validaUsuario[2], 'login' => $validaUsuario[3],'token' => $token];
            return ['status' => true, 'data' => $data];
        } else {
            $return = ['status' => false, 'error' => 'Usuário não encontrado.'];
        }
        return $return;
    }

    $response = validaLogin($login, $senha, $con);
    echo json_encode($response);
}
