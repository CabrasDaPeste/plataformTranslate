<?php
session_start();
 
require 'check.php';
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Central de Traduções!</title>
  </head>
  <body style="padding:20px;">
	
	<h1>Olá, <?php echo $_SESSION['username']; ?>. <small style="font-size:50%;"><a href="index.php">Início</a></small> <small style="font-size:50%;"><a href="logout.php">Sair</a></small></h1>
	<h3>Existem <?php echo frasesParaCorrigir() ?> frases para corrigir.</h3>
	<hr>
	<?php 
		// Hackfix to javascript link on button onClick
		$hackfix = "'translate_dbscript.php'";
		// Se a permissão do usuário for maior que tradutor (Corretor ou administrador), então mostra o botão de corrigir.
		if($_SESSION['access'] > 0) { echo '<button type="button" class="btn btn-primary btn-lg btn-block" onclick="window.location.href='.$hackfix.'">Voltar para traduzir frases!</button><br>'; }
	?>
	<input class="form-control" id="myInput" type="text" placeholder="Procurar...">
	<br>
		<table id="basic-datatable" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>ID</th>
					<th>Frase</th>
					<th>Comentário</th>
					<th>Tradutor</th>
					<th>Corretor</th>
					<th>Alterar?</th>
				</tr>
			</thead>			
			<tbody id="myTable">
				<?php echo montarTabelaDbScriptAdjust(); ?>
			</tbody>

	</table>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
		<script>
		$(document).ready(function(){
			$("#myInput").on("keyup", function() {
				var value = $(this).val().toLowerCase();
				$("#myTable tr").filter(function() {
					$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
				});
			});
		});
		</script>
	</body>
</html>