<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: multipart/form-data');
header("Access-Control-Allow-Methods: POST");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Authentication, X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

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
            $data = ['id' => $validaUsuario[0], 'nome' => $validaUsuario[1], 'email' => $validaUsuario[2], 'login' => $validaUsuario[3], 'token' => $token];
            return ['status' => true, 'data' => $data];
        } else {
            $return = ['status' => false, 'error' => 'Usuário não encontrado.'];
        }
        return $return;
    }

    $response = validaLogin($login, $senha, $con);

    if (count($response) > 0) {
        echo json_encode($response);
    }elsE{
        echo json_encode([]);
    }
}
