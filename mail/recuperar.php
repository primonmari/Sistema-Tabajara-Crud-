 <?php

 /*     FUNNCAO DO CODIGO 3: VERIFICA SE TA CERTO OS DADOS DA TABELA DO BD (USUARIO, CHAVE, VALIDADE),
TEM UM FORMULARIO QUE TEM O SENHA E NOVA SENHA E CONFIRMA NOVA SENHA, REALIZA A CRIPTOGRAFIA DA SENHA E 
ENVIA O FORMULARIO PARA RECUPERAR2.PHP
  */
//verifica se veio ou nao as variaveis
if( empty($_GET['usuario']) || empty($_GET['confirmacao']) ){
	die ('<p><h2>Não é possível alterar a senha: dados em falta</p></h2>');
}

//echo "verificando dados";
include("conectar.php");
//sanitiza usuario e confirmacao
$usuario = mysqli_real_escape_string($con, $_GET['usuario']);
$chave = mysqli_real_escape_string($con, $_GET['confirmacao']);
$validade = date("d-m-Y");//vejo q dia e agr
//consulto no BD se a chave e validade esta ok, p ver se eh chave falsa 
$var="SELECT COUNT(*) FROM recupera_senha WHERE usuario = '$usuario' AND chave = '$chave' and validade = '$validade'";
$q = mysqli_query($con, $var);
echo"$var";

 
if( mysqli_num_rows($q) == "1"  ){//se der uma consulta vamos executar abaixo:
	
// os dados estão corretos: eliminar o pedido e permitir alterar a password
//ainda nao vou eliminar o registro, pois vou eliminar no sql, para evitar tentantiva direta no arquivo sql.php
//mysql_query("DELETE FROM recupera_senha WHERE utilizador = '$utilizador' AND confirmacao = '$confirmacao'");
//echo 'Sucesso! (Mostrar formulário de alteração de password aqui)';   
?>
<!--   CAMPO DE FORMULARIO-->
<!DOCTYPE html>
<html lang="pt_br">
<head>
	<title>TABAJARAS</title><!-- campos de formulario abaixo-->
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<meta name="description" content="">
  	<meta name="author" content="Henrique Golinelli, IFPR Ivaiporã, CODESI, ACISI">
  	<link rel="shortcut icon" href="sistema/img/favicon.gif">
  	<script src="js/secure.js"></script>
  	
  	<link href="sistema/css/bootstrap.min.css" rel="stylesheet">
	 <link href="sistema/css/style.css" rel="stylesheet">
	 	<script type="text/javascript" src="js/secure.js"></script>
			<script type="text/JavaScript">
			<!--
			// criptografa o login e a senha no envio
			function criptoform() {
			var a = document.loginform.pass.value;
			var b = document.loginform.pass1.value;
			//depois de clicar em enviar la no final cód. verifica se as duas senhas ta em branco ou sesao diferentes
			if (( a == '' ) || ( b == '')) {
			alert ("senha em branco");
			return false;
			}//verifica se sao senhas diferentes	
			if ( a != b ){
			alert ("senhas nao conferem");
			return false;
			}//criptografia do sha e envio a senha do cara 
			document.loginform.pass.value =  SHA256(document.loginform.pass.value);
			document.loginform.pass1.value =  SHA256(document.loginform.pass1.value);
			
			}
			-->
			</script>
</head>
<body>
	<div class="container">
	<div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                  
    <div class="panel panel-success" >
    <div class="panel-heading">
		<!--   CAMPO ATUALIZAR SENHA-->
    <div class="panel-title">Atualizar Senha</div>
    <div style="float:right; font-size: 80%; position: relative; top:-10px">
    <div align="right"></div>
    </div>
    </div>   
	<!--   CAMPO FORMULARIO-->  
    <div style="padding-top:30px" class="panel-body " >
	<!-- =============== envia formulario para recuperar2 ==============================-->
	<form name="loginform" id="loginform" class="form-horizontal" action="recuperar2.php" method="post" onSubmit="return criptoform()">
    <!--   CAMPO SENHA E NOVA SENHA-->
    <div style="margin-bottom: 25px" class="input-group">
    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
    <!--senha  e nova senha-->
	<input id="pass1" name="pass1" type="password" class="form-control" placeholder="nova senha">
	</div>
	<!--   CAMPO CONFIRMA NOVA SENHA-->
	<div style="margin-bottom: 25px" class="input-group">
	<!--confirme a nova senha-->
    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
    <input id="pass" name="pass" type="password" class="form-control" placeholder="repita a nova senha">
    <input id="usuario" name="usuario" type="hidden" value="<?php echo $usuario; ?>">
	<input id="chave" name="chave" type="hidden" value="<?php echo $chave; ?>">
	</div>
   
	<!--CAMPO CLICA E ENVIAR-->         
    <div style="margin-top:10px" class="form-group">

    <!-- Button -->
	<div class="col-sm-12 controls">
    <input type="submit" name="submit" value="Alterar Senha" class="btn btn-default" />
    </div>
    </div>
    </form>
    </div>                     
    </div>  
    </div>
	
	</div>
	
</body>
</html>
       
<?
}
?>

		