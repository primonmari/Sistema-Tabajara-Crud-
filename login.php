<?php 
session_start();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Sistema Tabajara</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container">
	<div class="row">
		<div class="col-sm-12">
		
		<form action="verifica_login.php" method="POST"> <!-- post p/ n exibir na url usuario e senha digigtado-->
		  <div class="form-group">
		    <label for="login">Login</label>
		    <input type="login" class="form-control" placeholder="Usuario/email" id="login" name="login">
		  </div>
		  <div class="form-group">
		    <label for="senha">Senha</label>
		    <input type="senha" class="form-control" placeholder="Senha" id="senha" name="senha">
		  </div>
		  <button type="submit" class="btn btn-dark" href="verifica_login.php">ENTRAR</button>
		   <!--<button type="submit" class="btn btn-primary">Submit</button>-->
		</form>
		</div>
			<br>
		   <a href="http://alunos.suportelab.com.br:15000/alunos/marislene/mail/recuperar_senha.php" <button 	class="btn btn-dark" href="recuperar_senha.php">RECUPERAR SENHA</button> </a>
	</div>
</div>
</body>
</html>