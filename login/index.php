<?php

$login = isset($_POST['usuario']) ? $_POST['usuario'] : null;
$senha = isset($_POST['senha']) ? $_POST['senha'] : null;


if (isset($login) && isset($senha)) {
    include './app/config/conMysql.php';

    function validaLogin($login, $senha, $con)
    {
        $codSenha = md5($senha);
        $sqlVerificaUsuario = "select idusuario, nome, email, login from usuario where login = '{$login}' && senha = '${$codSenha}'";
        $respVerificaUsuario = mysqli_query($con, $sqlVerificaUsuario);
        $validaUsuario = mysqli_fetch_array($respVerificaUsuario);
        print_r($validaUsuario);
    }

    $response = validaLogin($login, $senha, $con);
    // print_r($response);
}
