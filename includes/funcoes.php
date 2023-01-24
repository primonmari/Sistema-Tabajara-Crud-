<?php 
// funcoes


function salva_log($login, $ip, $mensagem){

include 'includes/conectar.php';

$sql = "INSERT INTO log (`login`, `ip`, `mensagem`) values ('$login', '$ip', '$mensagem')";
//echo "$sql";/*teste p escrever no arquivo de log e ver oq esta dando erradoo*/ 

$exec = mysqli_query($con, $sql);

}
?>