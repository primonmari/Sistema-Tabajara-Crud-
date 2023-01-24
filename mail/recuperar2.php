<?php

include("conectar.php");

$usuario = mysqli_real_escape_string($con, $_POST['usuario']);
$pass = mysqli_real_escape_string($con, $_POST['pass']);
$chave = mysqli_real_escape_string($con, $_POST['chave']);
$validade = date("d-m-Y");

//echo "usuario $usuario pass $pass chave $chave";

//echo "utilizador $utilizador pass $pass ";
$var="SELECT COUNT(*) FROM recupera_senha WHERE usuario = '$usuario' AND chave = '$chave' and validade = '$validade'"; 		
$q = mysqli_query($con, $var);

 echo"$var";
if( mysqli_num_rows($q) == "1"  ){
	mysqli_query($con, "DELETE FROM recupera_senha WHERE usuario = '$usuario' AND chave = '$chave'");
	mysqli_query($con, "UPDATE usuarios set senha = '$pass' where login = '$usuario'");
	echo "<h2>SENHA ALTERADA COM SUCESSO </h2>";
	//echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"2; URL= ..\index.php\">";
} else {
	echo "erro algum dado inválido";
	
}// edita senha

?>