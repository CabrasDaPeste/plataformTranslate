<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" href="assets/css/style.css">

    <title>Tradução de Missões | CDP WOW</title>
  </head>
  <body>
		
	<div class="login-form">

		<div class="logo"></div>
		<br>

		<?php

		if (isset($_GET['msg'])) {

			if ($_GET['msg'] == 1) {
				echo '<div class="alert alert-warning" role="alert">
				Você precisa preencher todos os campos!
				</div>';
			} elseif ($_GET['msg'] == 2) {
				echo '<div class="alert alert-danger" role="alert">
				Usuário ou senha incorreta!
				</div>';
			}

		}
		?>

		<br>

		<form action="doLogin.php" method="POST">
			<div class="form-group">
				<input type="input" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Informe seu usuário">
			</div>
			<div class="form-group">
				<input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Informe sua senha">
			</div>
			<button type="submit" class="btn btn-primary">Começar a traduzir!</button>
		</form>

	</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>