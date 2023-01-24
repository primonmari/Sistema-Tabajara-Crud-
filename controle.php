<?php
session_start();
include 'includes/conectar.php';
include 'includes/funcoes.php';
$operacao = mysqli_real_escape_string($con, $_GET['operacao']);

switch ($operacao) {
	case 'edita_pessoa':
		$id_pessoa = mysqli_real_escape_string($con,$_GET['id_pessoa']);
		$nome = mysqli_real_escape_string($con,$_GET['nome']);
		$email = mysqli_real_escape_string($con,$_GET['email']);
		$cpf = mysqli_real_escape_string($con,$_GET['cpf']);
		$rg = mysqli_real_escape_string($con,$_GET['rg']);
		$celular = mysqli_real_escape_string($con,$_GET['celular']);
		$endereco = mysqli_real_escape_string($con,$_GET['endereco']);
		$observacao= mysqli_real_escape_string($con,$_GET['observacao']);

		$sql = "UPDATE `pessoa` set `nome`='$nome', `cpf`='$cpf', `rg`='$rg', `celular`='$celular', `email`='$email', `endereco`='$endereco', `observacao`='$observacao' WHERE id_pessoa = '$id_pessoa'";
		
		if ($abc = mysqli_query($con,$sql)){
			salva_log($_SESSION['login'], $_SERVER['REMOTE_ADDR'],"Usuario alterou o cadastro da pessoa $id_pessoa $nome ");
			echo "Alteração realizada <a href='index.php'>Voltar</a>";
			header('Location: index.php?operacao=pessoas');
		}else{
			echo "Erro na Alteração <a href='index.php'>Volta</a>";
		}
		break;
	
	case 'excluir_pessoa':
		$id_pessoa = mysqli_real_escape_string($con, $_GET['id_pessoa']);
		$sql = "DELETE from pessoa where id_pessoa = '$id_pessoa'";
		if ($abc = mysqli_query($con, $sql)){
			salva_log($_SESSION['login'], $_SERVER['REMOTE_ADDR'],"Usuario excluiu o cadastro da pessoa $id_pessoa ");/*variaveis de sessao e servidor*/ 
			echo "Exclusão realizada <a href='index.php'>Voltar</a>";
			header('Location: index.php?operacao=pessoas');
		}else{
			echo "Erro na Exclusão da pessoa <a href='index.php'>Volta</a>";
		}
		break;

	case 'nova_pessoa':
		
		$nome = mysqli_real_escape_string($con,$_GET['nome']);
		$email = mysqli_real_escape_string($con,$_GET['email']);
		$cpf = mysqli_real_escape_string($con,$_GET['cpf']);
		$rg = mysqli_real_escape_string($con,$_GET['rg']);
		$celular = mysqli_real_escape_string($con,$_GET['celular']);
		$endereco = mysqli_real_escape_string($con,$_GET['endereco']);
		$observacao= mysqli_real_escape_string($con,$_GET['observacao']);

		$sql = "INSERT into `pessoa` (`nome`, `email`, `cpf`, `rg`, `celular`, `endereco`, `observacao`) value ('$nome', '$email', '$cpf', '$rg', '$celular', '$endereco', '$observacao')";
		if ($abc = mysqli_query($con, $sql)){
			salva_log($_SESSION['login'], $_SERVER['REMOTE_ADDR'],"Usuario inseriu novo cadastro da pessoa $nome ");
			echo "Cadastro de nova pessoa  realizada <a href='index.php'>Voltar</a>";
			header('Location: index.php?operacao=pessoas');
		}else{
			echo "Erro no cadastro de pessoa <a href='index.php?operacao=pessoas'>Volta</a>";
		}

	default:
		echo "operacao nao encontrada";
		break;
}

?>