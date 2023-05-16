<?php
if(count($_POST) > 0) {    
//1 pegar valores do formulario
$nome = $_POST["nome"];
$senha = $_POST["senha"];
//2 conexao com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";

try {
  $conn = new PDO("mysql:host=$servername;dbname=restaurante_bd", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 // echo "conexão realizada com sucesso";
  $consulta = $conn->prepare("SELECT id FROM `login` WHERE nome=:nome and senha=md5(:senha)");
  $consulta->bindParam(':nome', $nome, PDO::PARAM_STR);
  $consulta->bindParam(':senha', $senha, PDO::PARAM_STR);
  $consulta->execute();

  // set the resulting array to associative
  $result = $consulta->fetchall();
  $qtd_usuarios = count($result);
  if($qtd_usuarios ==1) {
    //todos substituir pelo redirecionamento
    $resultado["msg"] = "usuario encontrado!";
    $resultado["cod"] = 1;
  } else if($qtd_usuarios ==0) {
    $resultado["msg"] = "usuario nao encontrado";
    $resultado["cod"] = 0;
  }
  
}
 catch(PDOException $e) {
  echo "conexão falhou: " . $e->getMessage();
  $conn = null;
}
//3 verificar usuario
}
include("index.php");

?>