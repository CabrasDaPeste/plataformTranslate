<?php

// Conecta com o MySQL utilizando PDO :: No HOST1 do Cabras da Peste
function conecta_banco_cabrasdapeste()
{
	// Instancia uma nova conexão PDO dentro da variável $PDO.
    $PDO = new PDO('mysql:host=' . DB_HOST_CDP . ';dbname=' . DB_NAME_CDP . ';charset=utf8', DB_USER_CDP, DB_PASS_CDP);
	// Retorna para quem chama a função conecta_banco_cabrasdapeste o conteúdo da variável $PDO.
    return $PDO;
}

// Conecta com o MySQL utilizando PDO :: No HOST2 do Mangos
function conecta_banco_mangos()
{
	// Instancia uma nova conexão PDO dentro da variável $PDO.
    $PDO = new PDO('mysql:host=' . DB_HOST_MANGOS . ';dbname=' . DB_NAME_MANGOS . ';charset=utf8', DB_USER_MANGOS, DB_PASS_MANGOS);
	// Retorna para quem chama a função conecta_banco_cabrasdapeste o conteúdo da variável $PDO.
    return $PDO;
}
 
// Recebe uma string e a criptografa utilizando a tecnologia sha1.
function criar_hash($str)
{
	// Retorna a string recém
    return sha1($str);
}
 
 
// Função que verifica se o usuário está logado
function usuarioLogado()
{
	// Se a sessão usuário logado não existir, ou se a sessão usuarioLogado não for verdadeira, então:
    if (!isset($_SESSION['usuarioLogado']) || $_SESSION['usuarioLogado'] !== true)
    {
		// Retorne que a função é falsa.
        return false;
    }
	
	// Senão, retorne que a função é verdadeira.
    return true;
}

// Recebe o nível de permissão, e transforma-o em texto.
function nivelPermissao($permissao)
{
	$cargo = "Sem cargo";

	switch ($permissao) {
		case 0:
			$cargo = "Tradutor";
			break;
		case 1:
			$cargo = "Corretor";
			break;
		case 2:
			$cargo = "Administrador";
			break;
	}

	return $cargo;

}


// Função que recebe a quantidade de missões traduzidas
function missoesQueFaltamTraduzir()
{
	$PDO = conecta_banco_mangos();
	
	// Cria a string para selecionar o usuário baseado no login e senha digitado
	$sql = "SELECT entry FROM quest_template";
	// Prepara a string dentro da instância do PDO.
	$stmm = $PDO->prepare($sql);

	// Executa a consulta no banco de dados
	$stmm->execute();
	
	return $stmm->rowCount();
}

// Função que recebe a quantidade de missões traduzidas
function missoesTraduzidas()
{
	$PDO = conecta_banco_cabrasdapeste();
	
	// Cria a string para selecionar o usuário baseado no login e senha digitado
	$sql = "SELECT id FROM cdp_trad_quests";
	// Prepara a string dentro da instância do PDO.
	$stmm = $PDO->prepare($sql);

	// Executa a consulta no banco de dados
	$stmm->execute();
	
	return $stmm->rowCount();
}

function missoesTraduzidasUsuario($id)
{
	$PDO = conecta_banco_cabrasdapeste();
	
	// Cria a string para selecionar o usuário baseado no login e senha digitado
	$sql = "SELECT id FROM cdp_trad_quests WHERE tradutorId = :id";
	// Prepara a string dentro da instância do PDO.
	$stmm = $PDO->prepare($sql);
	
	// Coloca o id dentro da string. Desta forma evita SQL Injection.
	$stmm->bindParam(':id', $id);

	// Executa a consulta no banco de dados
	$stmm->execute();
	
	return $stmm->rowCount();
}

function missoesCorrigidasUsuario($id)
{
	$PDO = conecta_banco_cabrasdapeste();
	
	// Cria a string para selecionar o usuário baseado no login e senha digitado
	$sql = "SELECT id FROM cdp_trad_quests WHERE corretorId = :id";
	// Prepara a string dentro da instância do PDO.
	$stmm = $PDO->prepare($sql);
	
	// Coloca o id dentro da string. Desta forma evita SQL Injection.
	$stmm->bindParam(':id', $id);

	// Executa a consulta no banco de dados
	$stmm->execute();
	
	return $stmm->rowCount();
}

function montarTabelaParaTraduzir($nivel)
{
	$PDO = conecta_banco_mangos();
	
	// Cria a string para selecionar o usuário baseado no login e senha digitado
	$sql = "SELECT Entry, ZoneOrSort, Title FROM quest_template LIMIT 10";
	// Prepara a string dentro da instância do PDO.
	$stmm = $PDO->prepare($sql);

	// Executa a consulta no banco de dados
	$stmm->execute();
	
	$quest = $stmm->fetchAll(PDO::FETCH_ASSOC);
	
	
	
	foreach($quest as $quests) {
		
		
		$valid = checarSeFoiTraduzida($quests["Entry"]);
		
		
		if ($valid != 1) {
			
			if ($valid === "0" && $nivel > 0) {
				echo '<tr>';
				echo '<td>'.$quests["Entry"].'</td>';
				echo '<td>'.$quests["Title"].'</td>';
				echo '<td>'.pegarNomeDaArea($quests["ZoneOrSort"]).'</td>';
				echo '<td><button type="button" class="btn btn-warning">Corrigir!</button></td>';
				echo '</tr>';
			} elseif($valid != "0") {
				echo '<tr>';
				echo '<td>'.$quests["Entry"].'</td>';
				echo '<td>'.$quests["Title"].'</td>';
				echo '<td>'.pegarNomeDaArea($quests["ZoneOrSort"]).'</td>';
				echo '<td><button type="button" class="btn btn-primary">Traduzir!</button></td>';
				echo '</tr>';
			}
		}
	}
	
}

function pegarNomeDaArea($zona)
{
	$PDO = conecta_banco_cabrasdapeste();
	
	// Cria a string para selecionar o usuário baseado no login e senha digitado
	$sql = "SELECT id, Name FROM cdp_trad_questarea WHERE id = :zona";
	// Prepara a string dentro da instância do PDO.
	$stmm = $PDO->prepare($sql);
	
	// Coloca o id dentro da string. Desta forma evita SQL Injection.
	$stmm->bindParam(':zona', $zona);

	// Executa a consulta no banco de dados
	$stmm->execute();
	
	$zona = $stmm->fetch(PDO::FETCH_ASSOC);
	
	if ($stmm->rowCount() == 0) {
		$zona['Name'] = "Special";
	}
	
	return $zona['Name'];
}

function checarSeFoiTraduzida($entry)
{
	$PDO = conecta_banco_cabrasdapeste();
	
	// Cria a string para selecionar o usuário baseado no login e senha digitado
	$sql = "SELECT quest, valid FROM cdp_trad_quests WHERE quest = :quest";
	// Prepara a string dentro da instância do PDO.
	$stmm = $PDO->prepare($sql);
	
	// Coloca o id dentro da string. Desta forma evita SQL Injection.
	$stmm->bindParam(':quest', $entry);

	// Executa a consulta no banco de dados
	$stmm->execute();
	
	$quest = $stmm->fetch(PDO::FETCH_ASSOC);
	
	return $quest['valid'];
}

/* ----------
  DB_SCRIPT
------------*/

function montarTabelaDbScript()
{
	$PDO = conecta_banco_mangos();
	
	// Cria a string para selecionar o usuário baseado no login e senha digitado
	$sql = "SELECT entry, content_default, comment FROM dbscript_string WHERE sound=0";
	// Prepara a string dentro da instância do PDO.
	$stmm = $PDO->prepare($sql);

	// Executa a consulta no banco de dados
	$stmm->execute();
	
	$frase = $stmm->fetchAll(PDO::FETCH_ASSOC);
	
	
	
	foreach($frase as $frases) {
		
		$valid = checarTraduzidasDbScript($frases["entry"]);
		
		if ($frases["comment"] == "") {
			$frases["comment"] = "Nenhum";
		}
		
		if ($valid == "") {
			echo '<tr>';
			echo '<td>'.$frases["entry"].'</td>';
			echo '<td>'.$frases["content_default"].'</td>';
			echo '<td>'.$frases["comment"].'</td>';
			echo '<td><form action="translate_dbscript_type.php" method="GET"><button type="submit" name="entry" value="'.$frases["entry"].'" class="btn btn-primary">Traduzir!</button></form></td>';
			echo '</tr>';
		}
		
	}
	
}


function montarTabelaDbScriptAdjust()
{
	$PDO = conecta_banco_cabrasdapeste();
	
	// Cria a string para selecionar o usuário baseado no login e senha digitado
	$sql = "SELECT * FROM cdp_trad_dbscript ORDER BY valid ASC";
	// Prepara a string dentro da instância do PDO.
	$stmm = $PDO->prepare($sql);

	// Executa a consulta no banco de dados
	$stmm->execute();
	
	$frase = $stmm->fetchAll(PDO::FETCH_ASSOC);
	
	
	
	foreach($frase as $frases) {
		switch($frases["valid"]) {
			case 0:
				$cor = 'warning">Corrigir!';
				break;
			case 1:
				$cor = 'dark" disabled>Corrigida';
				break;
		}

		echo '<tr>';
		echo '<td>'.$frases["frase"].'</td>';
		echo '<td></td>';
		echo '<td></td>';
		
		echo '<td>'.pegarNome($frases["tradutorId"]).'</td>';
		echo '<td>'.pegarNome($frases["corretorId"]).'</td>';
		echo '<td><form action="adjust_dbscript_type.php" method="GET"><button type="submit" name="entry" value="'.$frases["frase"].'" class="btn btn-'.$cor.'</button></form></td>';
		echo '</tr>';		
	}
	
}

function pegarNome($id) {

	// Instancia o objeto da conexão mysql
	$PDO = conecta_banco_cabrasdapeste();
	// Salva a query sql em uma string
	$sql = "SELECT id, username FROM cdp_trad_users WHERE id = :id";
	// Prepara a query sql dentro da conexão de banco de dados, e chama-a de stmm
	$stmm = $PDO->prepare($sql);
	// Substitui o valor :id dentro da query sql para evitar SQL Injection
	$stmm->bindParam(':id', $id);
	// Executa a query
	$stmm->execute();
	// Puxa todos os itens do banco de dados e salva na array puxando.
	$puxando = $stmm->fetch(PDO::FETCH_ASSOC);

	// Se o número de dados for puxado do banco de dados for igual a zero:
	if($stmm->rowCount() == 0) {
		// Usuário não existe, e salva na variavel nome ninguém.
		$nome = "Ninguém";
	// Se não
	} else {
		// salva na variavel nome do usuário no banco.
		$nome = $puxando['username'];
	}

	// Retorna para quem pediu a função o nome.
	return $nome;
}

// Função que retorna quantidade de frases para corrigir
function missoesParaCorrigir()
{
	$PDO = conecta_banco_cabrasdapeste();
	
	// Cria a string para selecionar o usuário baseado no login e senha digitado
	$sql = "SELECT id FROM cdp_trad_dbscript WHERE valid = :value";
	// Prepara a string dentro da instância do PDO.
	$stmm = $PDO->prepare($sql);

	// Bind param para evitar sql injection
	$stmm->bindValue(':value', 0, PDO::PARAM_INT);

	// Executa a consulta no banco de dados
	$stmm->execute();
	
	return $stmm->rowCount();
}

function checarTraduzidasDbScript($entry)
{
	$PDO = conecta_banco_cabrasdapeste();
	
	// Cria a string para selecionar o usuário baseado no login e senha digitado
	$sql = "SELECT frase, valid FROM cdp_trad_dbscript WHERE frase = :entry";
	// Prepara a string dentro da instância do PDO.
	$stmm = $PDO->prepare($sql);
	
	// Coloca o id dentro da string. Desta forma evita SQL Injection.
	$stmm->bindParam(':entry', $entry);

	// Executa a consulta no banco de dados
	$stmm->execute();
	
	$quest = $stmm->fetch(PDO::FETCH_ASSOC);
	
	return $quest['valid'];
}

function getDbScriptFraseMangos($entry)
{
	$PDO = conecta_banco_mangos();
	
	// Cria a string para selecionar o usuário baseado no login e senha digitado
	$sql = "SELECT content_default FROM dbscript_string WHERE entry = :entry";
	// Prepara a string dentro da instância do PDO.
	$stmm = $PDO->prepare($sql);
	
	// Coloca o id dentro da string. Desta forma evita SQL Injection.
	$stmm->bindParam(':entry', $entry);

	// Executa a consulta no banco de dados
	$stmm->execute();
	
	$quest = $stmm->fetch(PDO::FETCH_ASSOC);
	
	if ($quest['content_default'] == "") {
		$quest['content_default'] = "Frase incorreta";
	}
	
	return $quest['content_default'];
}

function getDbScriptFrase($entry)
{
	$PDO = conecta_banco_cabrasdapeste();
	
	// Cria a string para selecionar o usuário baseado no login e senha digitado
	$sql = "SELECT content_default FROM cdp_trad_textdbscript WHERE id = :entry";
	// Prepara a string dentro da instância do PDO.
	$stmm = $PDO->prepare($sql);
	
	// Coloca o id dentro da string. Desta forma evita SQL Injection.
	$stmm->bindParam(':entry', $entry);

	// Executa a consulta no banco de dados
	$stmm->execute();
	
	$quest = $stmm->fetch(PDO::FETCH_ASSOC);
	
	if ($quest['content_default'] == "") {
		$quest['content_default'] = "Frase incorreta";
	}
	
	return $quest['content_default'];
}

function getDbScriptComment($entry)
{
	$PDO = conecta_banco_mangos();
	
	// Cria a string para selecionar o usuário baseado no login e senha digitado
	$sql = "SELECT content_default FROM cdp_trad_textdbscript WHERE id = :entry";
	// Prepara a string dentro da instância do PDO.
	$stmm = $PDO->prepare($sql);
	
	// Coloca o id dentro da string. Desta forma evita SQL Injection.
	$stmm->bindParam(':entry', $entry);

	// Executa a consulta no banco de dados
	$stmm->execute();
	
	$quest = $stmm->fetch(PDO::FETCH_ASSOC);
	
	if ($quest['comment'] == "") {
		$quest['comment'] = "Sem comentário";
	}
	
	return $quest['comment'];
}

function checkTranslation() {
	$PDO = conecta_banco_mangos();
	
	// Cria a string para selecionar o usuário baseado no login e senha digitado
	$sql = "SELECT entry,content_default FROM dbscript_string WHERE content_default = :entry";
	// Prepara a string dentro da instância do PDO.
	$stmm = $PDO->prepare($sql);
	
	// Coloca o id dentro da string. Desta forma evita SQL Injection.
	$stmm->bindParam(':entry', $_POST["frase"]);

	// Executa a consulta no banco de dados
	$stmm->execute();
	
	// Se já existir no banco de dados
	if ($stmm->rowCount() > 0) {
		// Retorna já existe
		return true;
	// Se não
	} else {
		// Retorna não existe
		return false;
	}
}


function sendTranslationCabrasDaPeste() {
	$PDO = conecta_banco_cabrasdapeste();
	
	// Cria a string para selecionar o usuário baseado no login e senha digitado
	$sql = "INSERT INTO cdp_trad_dbscript (tradutorId,corretorId, frase, data, valid) VALUES (:tradutorId,:corretorId,:frase,:data,:valid)";
	// Prepara a string dentro da instância do PDO.
	$stmm = $PDO->prepare($sql);
	
	$zero = 0;
	$data = date('m/d/Y h:i:s a', time());
	
	// Coloca o id dentro da string. Desta forma evita SQL Injection.
	$stmm->bindParam(':tradutorId', $_SESSION['id']);
	$stmm->bindParam(':corretorId', $zero);
	$stmm->bindParam(':frase', $_POST["entry"]);
	$stmm->bindParam(':data', $data);
	$stmm->bindParam(':valid', $zero);

	// Executa a consulta no banco de dados
	$stmm->execute();
	
	if ($stmm->rowCount() > 0) {
		return true;
	} else {
		return false;
	}
}

function sendTranslationCabrasDaPesteText() {
	$PDO = conecta_banco_cabrasdapeste();
	
	// Cria a string para selecionar o usuário baseado no login e senha digitado
	$sql = "INSERT INTO cdp_trad_textdbscript (id,content_default, comment) VALUES (:id,:content_default,:comment)";
	// Prepara a string dentro da instância do PDO.
	$stmm = $PDO->prepare($sql);
	
	if (empty($_POST['comentario'])) {
		$_POST['comentario'] = "Nenhum comentário";
	}
	
	// Coloca o id dentro da string. Desta forma evita SQL Injection.
	$stmm->bindParam(':id', $_POST["entry"]);
	$stmm->bindParam(':content_default', $_POST["frase"]);
	$stmm->bindParam(':comment', $_POST['comentario']);

	// Executa a consulta no banco de dados
	$stmm->execute();
	
	if ($stmm->rowCount() > 0) {
		return true;
	} else {
		return false;
	}
}


function sendTranslationMangos() {
	$PDO = conecta_banco_mangos();
	
	// Cria a string para selecionar o usuário baseado no login e senha digitado
	$sql = "UPDATE dbscript_string SET content_default = :content_default WHERE entry = :entry";
	// Prepara a string dentro da instância do PDO.
	$stmm = $PDO->prepare($sql);
	
	// Coloca o id dentro da string. Desta forma evita SQL Injection.
	$stmm->bindParam(':content_default', $_POST["frase"]);
	$stmm->bindParam(':entry', $_POST["entry"]);

	// Executa a consulta no banco de dados
	$stmm->execute();
}

function dbscriptQueFaltamTraduzir()
{
	$PDO = conecta_banco_mangos();
	
	// Cria a string para selecionar o usuário baseado no login e senha digitado
	$sql = "SELECT entry FROM dbscript_string";
	// Prepara a string dentro da instância do PDO.
	$stmm = $PDO->prepare($sql);

	// Executa a consulta no banco de dados
	$stmm->execute();
	
	return $stmm->rowCount();
}

// Função que recebe a quantidade de missões traduzidas
function dbscriptTraduzidas()
{
	$PDO = conecta_banco_cabrasdapeste();
	
	// Cria a string para selecionar o usuário baseado no login e senha digitado
	$sql = "SELECT id FROM cdp_trad_dbscript";
	// Prepara a string dentro da instância do PDO.
	$stmm = $PDO->prepare($sql);

	// Executa a consulta no banco de dados
	$stmm->execute();
	
	return $stmm->rowCount();
}


function adjustTranslationCabrasDaPeste() {
	$PDO = conecta_banco_cabrasdapeste();
	
	// Cria a string para selecionar o usuário baseado no login e senha digitado
	$sql = "UPDATE cdp_trad_dbscript SET corretorId = :corretorId, valid = :validValue WHERE frase = :frase";
	// Prepara a string dentro da instância do PDO.
	$stmm = $PDO->prepare($sql);
	
	$stmm->bindParam(':corretorId', $_SESSION['id']);
	$stmm->bindValue(':validValue', 1, PDO::PARAM_INT);
	$stmm->bindParam(':frase', $_POST["entry"]);

	// Executa a consulta no banco de dados	
	$stmm->execute();
}

function adjustTranslationCabrasDaPesteText() {
	$PDO = conecta_banco_cabrasdapeste();
	
	// Cria a string para selecionar o usuário baseado no login e senha digitado
	$sql = "UPDATE cdp_trad_textdbscript SET content_default = :content_default WHERE id = :id";
	// Prepara a string dentro da instância do PDO.
	$stmm = $PDO->prepare($sql);
	
	// Coloca o id dentro da string. Desta forma evita SQL Injection.
	$stmm->bindParam(':id', $_POST["entry"]);
	$stmm->bindParam(':content_default', $_POST["frase"]);

	// Executa a consulta no banco de dados
	$stmm->execute();
}

function adjustTranslationCabrasDaPesteTextMangos() {
	$PDO = conecta_banco_mangos();
	
	// Cria a string para selecionar o usuário baseado no login e senha digitado
	$sql = "UPDATE dbscript_string SET content_default = :content_default WHERE entry = :id";
	// Prepara a string dentro da instância do PDO.
	$stmm = $PDO->prepare($sql);
	
	// Coloca o id dentro da string. Desta forma evita SQL Injection.
	$stmm->bindParam(':id', $_POST["entry"]);
	$stmm->bindParam(':content_default', $_POST["frase"]);

	// Executa a consulta no banco de dados
	$stmm->execute();
}

function createSqlFileDbScript() {
	$fp = fopen("dbscript_string/".$_POST['entry'].".sql", "a");
 
	// Escreve "exemplo de escrita" no bloco1.txt
	$escreve = fwrite($fp, 'UPDATE dbscript_string SET content_default = "'.$_POST["frase"].'" WHERE entry = "'.$_POST["entry"].'";');
	
	// Fecha o arquivo
	fclose($fp);
}
