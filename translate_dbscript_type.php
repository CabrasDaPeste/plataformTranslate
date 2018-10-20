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
  <body style="padding:20px; background-color:#AAAAAA;">
	
	<div class="login-form">
	<form method="POST" action="translate_dbscript_send.php">
		
		<?php
			if (!ISSET($_GET['entry'])) {
				header('Location: translate_dbscript.php');
			}
			
		?>
		
		<div class="form-group">
			<label for="exampleFormControlInput1"><strong><?php echo getDbScriptFraseMangos($_GET['entry']); ?></strong></label>
			<input type="hidden" class="form-control" name="entry" id="exampleFormControlInput1" value="<?php echo $_GET['entry']; ?>">
			<input type="input" class="form-control" name="frase" id="exampleFormControlInput1" placeholder="Traduza e digite a frase em português aqui.">
			<br>
			<label for="exampleFormControlInput1"><strong>Comentário pro corretor (não obrigatório)</strong></label>
			<textarea class="form-control" name="comentario" id="exampleFormControlTextarea1" placeholder="Caso precise, escreva algum comentário, ressalva ou anotação para a pessoa que vai revisar." rows="3"></textarea>
			<br>
			<button type="submit" class="btn btn-success btn-lg btn-block">Enviar Tradução</button>
			<button type="button" class="btn btn-danger btn-lg btn-block" onclick="window.location.href='translate_dbscript.php'">Voltar</button>
		</div>
	</form>
	<p><strong>Notações:</strong></p>
	<p><strong>$B</strong> - Pular Linha</p>
	<p><strong>$C</strong> - Classe</p>
	<p><strong>$R</strong> - Raça</p>
	<p><strong>$N</strong> - Nome do Jogador</p>
	<p><strong>$G</strong>ele<strong>:</strong>ela - Texto variado, de acordo com o gênero do personagem</p>
	</div>
	
	

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