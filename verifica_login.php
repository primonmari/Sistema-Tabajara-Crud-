<?php 
session_start();/*super global - inicia sessao, avisa o apache*/ 

include 'includes/conectar.php';
include 'includes/funcoes.php';
$debug = '1';/*p ver imprimir na tela*/ 
$login = mysqli_real_escape_string($con, $_POST['login']);/*analisa o que o usuario digitou sanitiza a string para q ela nao seja um ataque sql p estragar o BD*/ 
$senha = mysqli_real_escape_string($con, $_POST['senha']);
$senha_hash = hash('sha256', $senha);
$sql = "SELECT * FROM usuarios WHERE `login` ='$login' AND `senha` = '$senha_hash'";
if ($debug == '1'){ echo "Login $login - Senha $senha senha_hash $senha_hash  - SQL $sql <br>"; }/*}mesma linha economizar espaço*/ 

$result = mysqli_query($con, $sql);
$num_rows = mysqli_num_rows($result);
if ($num_rows == 0){
	echo "Nao encontrado, retornando para pagina de login";
	header('location: login.php');
	exit;
}else{
	echo "Encontrado redirecionando para o sistema";
	$_SESSION['validacao'] = '1';/**/ 
	$_SESSION['login'] = $login;
	
	salva_log($login, $_SERVER['REMOTE_ADDR'],'Usuario logou no sistema');
	header('location: index.php');/*a seguir vms criar uma protecao p/ secao e a forma q o php armazena um dado msm q vc mude p/ outras pag*/ 
}/*o header salva q o usuario entro no sistema*/ 
?>