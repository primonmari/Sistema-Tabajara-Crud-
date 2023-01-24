<?php

//Inclui o arquivo class.phpmailer.php locdalizado na pasta phpmailer
require("phpmailer/class.phpmailer.php");

//inicia a classe phpmailer considerando que ele e programado orientado a objetos
$mail = new PHPMailer();// a variavel mail eh um objeto da classe php mailer, as informacoesficam dentro 
//deste objeto

// ========= === Define os dados do servidor e o tipo da conexao  ========= === 
//variavel -(menos) e sinal de > e o metodo que esta utilizando que queremos atribuir alguma coisa 
$mail-> IsSMTP(); //setando/ definindo q a mensagem sera SMTP, que eh o tipo de email que vamos utilizar 
$mail-> Host = "smtp.office365.com";//endereco de servidor smtp do meu outlook, em configuraxcoes pesquisa smtp , conf smtp
$mail->SMTPAuth = true; // usa autenticacao smtp? sim pois tanto o gmail ciomo o outlook necessitam de autenticacao 
$mail->SMTPSecure = "tls"; // eh o start la do meu outlook 
$mail->Username= "marisprimoon@outlook.com"; //meu usuario de servidor SMTP - ENDERECO REAL
$mail->Password = "marizinha23062000"; //senha do servidor SMTP 

//========= === DEFINE O REMETENTE ========= === 
$mail->From = "marisprimoon@outlook.com";/// ENDERECO QUE APARECE PARA OS OUTROS 
$mail->FromName = "Suportelabmari"; //Um nome amigavel 

//========= === DEFINE O DESTINATARIO ========= === 
$mail->AddAddress("marisprimoon@gmail.com", "Mari");//vinculado ao email da tabela 
$mail->AddAddress("marisprimoon@gmail.com", "Mari"); //coloca duas vezes, motivo inexplicado

//========= === DEFINE OS DADOS TECNICOS DA MENSAGEM ========= === 

$mail->IsHTML(true);//define q o email sera enviado como HTML, posso colocar as tags do html p/ email ficar bonito na hora de aparecer no nagegador 
$mail->CharSet = 'utf8';

//========= === DEFINE A MENSAGEM (Texto e Assunto) ========= === 

$mail->Subject = "Aula tabajara Sistem[observacao]"; //assunto da mensagem e a seguir em $mail->body a mensagem
//os links vai aq no corpo na tag <a href>
$mail->Body = "<h3> Olá </h3>
<p> Você ganhou 1 milhao na loteria <p>

<p>Me envie 10 mil para liberar seu premio<p>

<a href='http://alunos.suportelab.com.br:15000/alunos/marislene/'>SUPORTELAB </a>
";

//corpo para quando nbao carrega a imagem e aparece coisa escrito
$mail->AltBody = "<h3> Olá </h3>
<p> Você ganhou 1 milhao na loteria <p>

<p>Me envie 10 mil para liberar seu premio<p>"
;
//========= === DEFINE OS ANEXOS (opcional) envia pdf ou imagem, executavel nao ========= === 
//a funcao do exemplo e do suporte lab do prof  que envia exames por email
//$mail->AddAttachment("../tmp/exame$idaatendimento.pdf"), "exame$idaatendimento.pdf";//origem do arquivo e nome qiue quero q ele va

//Envia o e-mail
$enviado = $mail->Send();//envia o emiail e o resultado vai para $enviado

//limpa os destinatariios e os anexos
$mail->ClearAllRecipients();
$mail->ClearAttachments();

//exibe uma mensagem de resultado
if ($enviado){//se verdadeiro
echo "E-mail enviado com sucesso!";
}else{
echo "Não foi possível enviar o e-mail.<br /><br />";
echo "<b>Informações do erro:</b> <br />" . $mail-> 
    ErrorInfo;//mostra o tipo do erro

}

//$mensagem="Laudo por E-MAIL: $destinatario_nome email: $destinatario_address Atendimento: $idatendimento"
//mensagem para log , todos sao os logs do henrique 
//salvalog($mensagem); //chamado funcao de inserir log 

?>

