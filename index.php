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
	<div>
	<h1>Olá, <?php echo $_SESSION['username']; ?>. <small style="font-size:50%;"><a href="index.php">Início</a></small> <small style="font-size:50%;"><a href="logout.php">Sair</a></small></h1>
		<h2>Seu cargo é:  <?php echo nivelPermissao($_SESSION['access']); ?>.</h2>
		<hr>
		<button type="button" class="btn btn-primary btn-lg btn-block" onclick="window.location.href='translate_dbscript.php'">Ir traduzir frases!</button>
		<button type="button" class="btn btn-primary btn-lg btn-block" onclick="window.location.href='translate_gossip.php'" disabled>Ir traduzir gossips! (Indisponível)</button>
		<button type="button" class="btn btn-primary btn-lg btn-block" onclick="window.location.href='translate_quest.php'" disabled>Ir traduzir missões! (Indisponível)</button>
		<br>
		<h5>Missões: <br><?php echo missoesTraduzidasUsuario($_SESSION['id']); ?> traduzidas.<br><?php echo missoesAprovadasUsuario($_SESSION['id']); ?> aprovadas<br><?php echo missoesCorrigidasUsuario($_SESSION['id']); ?> corrigidas.</h5>
		<br>
		<h5>Frases: <br><?php echo dbscriptTraduzidasUsuario($_SESSION['id']); ?> traduzidas.<br><?php echo dbscriptAprovadasUsuario($_SESSION['id']); ?> aprovadas<br><?php echo dbscriptCorrigidasUsuario($_SESSION['id']); ?> corrigidas.</h5>
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