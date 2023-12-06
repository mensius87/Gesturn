<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>Control Horario de empleados</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="web/style/style.css">
</head>

<body id="login-body">

	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

	<div class="container">
		<div class="row text-center login-page">
			<div class="col-md-12 login-form">
				<form class="text-center" id="formularioLogin" action="Controller/Controlador_Principal.php" method="post">
					<div class="row">
						<div class="col-md-12 login-form-header">
							<img src="web/img/logo2.png" alt="logo">
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 login-from-row">
							<input name="action" type="hidden" value="login" hidden />
						</div>
					</div>

					<div class="container text-center">
						<div class="input-group md-12 mb-3">
							<span style="width: 16%;" class="input-group-text"><i class="bi bi-envelope"></i></span>
							<input style="width: 84%;" id="email" name="email" placeholder="Email"/>
						</div>

						<div class="input-group mb-4">
							<span style="width: 16%;" class="input-group-text"><i class="bi bi-key"></i></span>
							<input style="width: 84%;" name="password" type="password" placeholder="Contraseña"/>
						</div>
					</div>

					<div class="col-md-12 mb-3 login-form-row">
						<button class="btn btn-info" name="login" id="login" type="submit">login</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script src="web/js/validacion_formularios.js"></script>

</body>

</html>