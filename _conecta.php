<?php
// Defina as configurações do banco de dados
$db_host = 'localhost';
$db_name = 'nome_do_banco';
$db_user = 'usuario_do_banco';
$db_password = 'senha_do_banco';

try {
    // Crie uma conexão PDO segura
    $pdo = new PDO(
        "mysql:host=$db_host;dbname=$db_name;charset=utf8",
        $db_user,
        $db_password,
        [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_CASE => PDO::CASE_NATURAL
        ]
    );
} catch (PDOException $e) {
    // Em caso de erro na conexão, exiba uma mensagem e encerre o script
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
