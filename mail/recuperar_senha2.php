<?php
$debug = 0;
$mail_usuario='marisprimoon@outlook.com';
$mail_senha='marizinha23062000';
$IP=$_SERVER['REMOTE_ADDR'];//saber ip da pessoa que envio email
/* FUNCAO CODIGO 2: SE TIVER USUARIO VALIDO (consulta tabela) ENTAO CRIA CHAVE ALEATORIA E ENVIA ELA EM LINK PRO EMAIL
(registra na table quem pediu a senh, hrs, chave), AO CONFIRMAR A CHAVE ENVIA UMA REDEFINICAO DESENHA PRO EMAIL 
E AGORA VAI PRO ARQUIVO RECUPERAR.PHP
*/


//checa se veio o usuario digitado
if( empty($_POST['usuario']) ){
	die ('<p><h2>Não é possível alterar a senha: dados em falta</p></h2>');
	echo " URL= http://alunos.suportelab.com.br:15000/alunos/gideone/login.php\">";//se nao veio nada volta p tela inicial
}

//echo "verificando dados";
//se veio algo entao executa o codigo abaixo:
include("conectar.php");//conecta no banco de dados
include("recuperar_senha.php");


$consulta='';//limpa a variavel para nao ter nada debtro delas 
$usuario='';
		
//echo "obtendo usuario" ;
//verificando se o usuario esta no banco de dados:
$usuario=mysqli_real_escape_string($con, $_REQUEST['usuario']);//request pega valor q foi digitado no usuario e o mysqli faz a sanitizacao da string
//formando consulta SQL (consulta o trecho abaixo no BD)
$consulta="select * from usuarios where login = '$usuario'";
if ($debug == 1 ) { echo"$consulta"; }
//realizando consulta SQL(executando)
$cst_recuperacao=mysqli_query($con, $consulta);
/*se e igual a 1 o numero de linhas. se for igual a 0 n achou ngm, se for maior q 1 significa q tem dois usarios 
com mesmo login, caquinha no sistema por isso e importante o campo unic de usaurio no sql 
para nao haver repeticoes*/
if( mysqli_num_rows($cst_recuperacao) == 1 ){
	$validade = date("d-m-Y");//validade pega data 	
	$agora=date("H:i:s");//agora pega a hora
	
	$chave = sha1(uniqid( mt_rand(), true));/*chave aleatoria pesq do prof na net que gera um numero aleatorio,
	esse numero "doido" vai p email do destinatario e qnd volta p mim tem q ser oq esta no BD*/
	$pass = sha1(uniqid( mt_rand(), true));
	$uid = sha1(uniqid( mt_rand(), true));
	//echo "</br> chave $chave, validade $validade $usuario </br></br>";
	//insere na tabela recupera senha, o usuário q pediu senha, a chave q gerei e validade dessa chave:
	// a validade de chave e importante para q se outra pessoa ver o email tempo depois nao consiga mudar a senha 
	$arquiva_solicitacao="INSERT INTO recupera_senha (usuario, chave, validade) VALUES ('${usuario}', '$chave', '$validade')";
	//echo "</br> $arquiva_solicitacao";
	//link do local q tera a pagina p/ verificar se esta certo, nome do campo valor do campo, link e variavel p corpo do text
	$link="http://alunos.suportelab.com.br:15000/alunos/marislene/mail/mail/recuperar.php?uid=$uid&pass=$pass&usuario=${usuario}&confirmacao=$chave";
	//echo "$link";
	//link do redcuperar do prof: 
	//essa solicitacao grava no BD que tal usuario tal hora pediu p mudar a senha		
	$executa=mysqli_query($con, $arquiva_solicitacao);
	
	
	if ( $debug == 1 ) { echo "$arquiva_solicitacao"; }
	//enviar email
	// Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer
	//agora mando um email pro usuario

	require("phpmailer/class.phpmailer.php");

	// Inicia a classe PHPMailer
	$mail = new PHPMailer();

	// Define os dados do servidor e tipo de conexão
	// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	$mail->IsSMTP(); // Define que a mensagem será SMTP

	$mail->Host = "smtp.office365.com"; // Endereço do servidor SMTP
	$mail->SMTPAuth = true; // Usa autenticação SMTP? (opcional)
	$mail->SMTPSecure = "tls";
	$mail->Username = "$mail_usuario"; // Usuário do servidor SMTP
	$mail->Password = "$mail_senha"; // Senha do servidor SMTP

	// Define o remetente
	// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	$mail->From = "$mail_usuario"; // Seu e-mail
	$mail->FromName = "Tabajara Recuperação de Senha"; // Seu nome

	// Define os destinatário(s)
	// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	$mail->AddAddress("$usuario", "$usuario");
	$mail->AddAddress("$usuario");

	// Define os dados técnicos da Mensagem
	// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
	$mail->CharSet = 'utf8'; // Charset da mensagem (opcional)
	//ao inves de escrever td dentro do campo fiz variavel pro meu texto:
	//data=dia, hora=hora, ip = endereco de quem esta tentando fazer, e o link para recupera senha (cód. acima)
	$xpto="Existe uma solicitação de recuperação de senha para o seu usuário no sistema <b>TABAJARA</b>. </br> </br>
	Data: $validade </br> 
	Hora: $agora </br>
	IP: $IP </br> </br>
	Para recuperar a senha acesse o <a href='$link'>LINK</a> <br>

	Caso tenha problema, copie e cole o link no navegador </br>
	$link </br> </br>

	Mensagem gerada automaticamente, não responda
	";

	// Define a mensagem (Texto e Assunto)
	// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	$mail->Subject = "Recuperacao de Senha"; // Assunto da mensagem
	$mail->Body = "$xpto";
	$mail->AltBody = "$xpto";

	// Envia o e-mail
	$enviado = $mail->Send();

	// Limpa os destinatários e os anexos
	$mail->ClearAllRecipients();
	$mail->ClearAttachments();

	// Exibe uma mensagem de resultado, se foi enviado ou nao
	if ($enviado) {
		
		echo '<div align="center">
		</br> E-mail enviado com sucesso! </br>
		<img src=".../img/1.png	"> </br>
        </br></br>E-mail enviado. Por favor, verifique sua caixa de entrada spam.</br>
        </div>';

	} else {
		echo "Não foi possível enviar o e-mail.<br /><br />";
		echo "<b>Informações do erro:</b> <br />" . $mail->ErrorInfo;
	}

	//$mensagem="Mensagem de Aniversario E-MAIL: $destinatario_nome email: $destinatario_address "; // mensagem para log
	//salvalog($mensagem); // chamando funcao de inserir log
	
	}else{
	echo "nao encontrado";
	//echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1; URL= index.php?erro=usuario-nao-encontrado\">";
}
?>