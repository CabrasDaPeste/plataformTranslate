<?php
 
// constantes com as credenciais de acesso ao banco MySQL :: HOST1 cabrasdapeste
define('DB_HOST_CDP', 'localhost');
define('DB_USER_CDP', 'root');
define('DB_PASS_CDP', 'root');
define('DB_NAME_CDP', 'cabrasdapeste');

// constantes com as credenciais de acesso ao banco MySQL :: HOST2 mangos
define('DB_HOST_MANGOS', 'localhost');
define('DB_USER_MANGOS', 'root');
define('DB_PASS_MANGOS', 'root');
define('DB_NAME_MANGOS', 'tbcmangos');
 
// habilita todas as exibições de erros
ini_set('display_errors', true);
error_reporting(E_ALL);
 
// inclui o arquivo de funçõees
require_once 'functions.php';