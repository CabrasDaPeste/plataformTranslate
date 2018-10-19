<?php
 
// Inclui o arquivo de inicialização
require 'init.php';
 
// Resgata variáveis do formulário, caso elas existem.
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
 
// Se o usuário não digitou nem o username, nem a senha, então ele será redirecionado.
if (empty($username) || empty($password)) {
	header('Location: login.php?msg=1');
	exit;
}
 
// Cria o hash da senha
$passwordHash = criar_hash($password);

// Instancia a conexão com o banco de dados cabras da peste
$PDO = conecta_banco_cabrasdapeste();
 
// Cria a string para selecionar o usuário baseado no login e senha digitado
$sql = "SELECT id, username, access FROM cdp_trad_users WHERE username = :username AND password = :password";
// Prepara a string dentro da instância do PDO.
$stmm = $PDO->prepare($sql);

// Coloca o usuário dentro da string. Desta forma evita SQL Injection.
$stmm->bindParam(':username', $username);
// Coloca a senha criada com hash dentro da string. Dessa forma evita SQL Injection.
$stmm->bindParam(':password', $passwordHash);
// Executa a consulta no banco de dados
$stmm->execute();

// Puxa do banco de dados todos os usuário que batem com a consulta.
$users = $stmm->fetchAll(PDO::FETCH_ASSOC);
 
// Se o número de usuários for menor que 0 (Ou seja, não bateu com a consulta), o usuário é redirecionado com erro.
if (count($users) <= 0) {
	header('Location: login.php?msg=2');
	exit;
}
 
// pega o primeiro usuário que bate.
$user = $users[0];

// Inicia Sessão
session_start();
// Diz que o usuário está logado é TRUE.
$_SESSION['usuarioLogado'] = true;
// Diz que a session user_name atribui o nome do banco de dados
$_SESSION['id'] = $user['id'];
// Diz que a session user_name atribui o nome do banco de dados
$_SESSION['username'] = $user['username'];
// Atribui a session access o nível do usuário
$_SESSION['access'] = $user['access'];

// Redireciona para a página de login
header('Location: index.php');