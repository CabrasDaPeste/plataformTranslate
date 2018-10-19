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
		<h1>Olá, <?php echo $_SESSION['username']; ?> <?php echo $_SESSION['access']; ?>!</h1>
		<h3>Existem <?php $missoesTraduzidas = missoesTraduzidas(); echo (missoesQueFaltamTraduzir() - $missoesTraduzidas); ?> missões para traduzir.</h3>
		<h5>E <?php echo missoesTraduzidas(); ?> missões já traduzidas.</h5>
		<br>
		<h5>Você traduziu <?php echo missoesTraduzidasUsuario($_SESSION['id']); ?> missões.</h5>
		<h5>Você corrigiu <?php echo missoesCorrigidasUsuario($_SESSION['id']); ?> missões.</h5>
	</div>
	
	<input class="form-control" id="myInput" type="text" placeholder="Search..">
		<br>
		<button type="button" class="btn btn-primary btn-lg btn-block">Ir para missões já traduzidas!</button>
		<br>

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