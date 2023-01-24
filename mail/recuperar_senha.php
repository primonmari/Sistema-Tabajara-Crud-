<!DOCTYPE html>
<html lang="pt_br">
<head>
 <!--  fUNCAO COD 1: DIGITA O USUARIO E CLICA EM RECUPERAR e manda pro Arq RECUPERAR_SENHA2 -->
	<title>TABAJARA</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<meta name="description" content="">
  	<meta name="author" content="Henrique Golinelli, IFPR Ivaiporã, CODESI, ACISI">
  	<link rel="shortcut icon" href="sistema/img/favicon.gif">
  	<script src="js/secure.js"></script>
  	
  	<link href="sistema/css/bootstrap.min.css" rel="stylesheet">
	 <link href="sistema/css/style.css" rel="stylesheet">

</head>
<body>
	<div class="container">
    <div align="center">
              <img src="sistema/img/solidariza_logo.png"> </br>
            </div>
		<div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
            <div class="panel panel-success" >
            <div class="panel-heading">
            <div class="panel-title">Recuperar Senha</div>
            <div style="float:right; font-size: 80%; position: relative; top:-10px">
              <div align="right">
             </div>
             </div>
            </div>     
            <div style="padding-top:30px" class="panel-body " >
              
              <div class="alert alert-warning"> Olá, para redefinir sua senha digite o e-mail cadastrado e clique em recuperar. Logo após verifique o e-mail em sua caixa de entrada/spam. </div>
        <!-- quando digito o usario e clico em recuperar, entao manda pro arquivo recuperar senha 2 p/ prox intrucoes -->      
				<form name="loginform" id="loginform" class="form-horizontal" action="recuperar_senha2.php" method="post" > 
                	<div style="margin-bottom: 25px" class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <!-- digita usuario -->    
                    <input id="usuario" name="usuario" type="text" class="form-control" placeholder="usuario ou email">                                    
                    </div>
                    
                    <div style="margin-top:10px" class="form-group">
                    <!-- Button -->
	                <div class="col-sm-12 controls">
                    <input type="submit" name="submit" value="Recuperar" class="btn btn-default" />
                    </div>
                    </div>
                </form>
            </div>                     
            </div>  
       </div>

	</div>
	
</body>
</html>
       