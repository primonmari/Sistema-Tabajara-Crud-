<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CADASTRO DE PESSOAS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
      <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
  </head>
  <body>
  <div class="container" style="margin-top:20px">
    <div class="row">
      <div class="col-sm-12">
       <h1> PAGINA PESSOAS </h1>
        <form method="POST" action="index.php?operacao=pessoas">
          <input type="text" name="nome" id="nome" placeholder="Pesquise...">
          <input type="submit" value="pesquisar">
        </form>
<br>
<br>
    </div>
    <a href="index.php?operacao=nova_pessoa"><button class="btn btn-dark">Nova Pessoa</button></a>
        
    <table  class = "table table-bordered table-striped table-sm">
    <thead>
        <tr>
	        <th>Nome</th>
			<th>CPF</th>
			<th>RG</th>
			<th>celular</th>
	        <th>e-mail</th>
			<th>Endereço</th>
	        <th>editar</th>
	        <th>excluir</th>
	      	</tr>
    	</thead>
    	<tbody>
</body>
</html>        
<?php
//--------------- PESQUISA DE NOME ---------------------- 
if(isset($_POST['nome'])){
    echo "Pesquisando...";
    $nome = $_POST['nome'];

    $termos = explode(" ", $nome);
    $termos_qtd = count($termos);
 }
 	$registros = '10';
 	if ( !isset($_GET['pag'])){
   		$pagina=1; 
 }
 	else{
   		$pagina=$_GET['pag'];
 }	
 $total_cliente=mysqli_query($con, "select count(id_pessoa) as total FROM pessoa");
 $total=mysqli_fetch_array($total_cliente, MYSQLI_BOTH);
	 
 if (isset($_POST['nome'])){
	$nome = $_POST['nome'];
		$termos = explode(" ", $nome);
		$termos_qtd = count($termos);

		switch ($termos_qtd){
			case "1":
				$consulta = "SELECT * from pessoa WHERE nome like '%$nome%' order by nome ASC";
			break;

			case "2":
				$consulta = "SELECT * FROM pessoa WHERE nome like '%$nome' 
				OR (nome like '%$termos[0]%' AND nome like '%$termos[1]%') 
				order by nome ASC";
			break;

			default:
				$consulta = "SELECT * from pessoa WHERE nome like
				'%$nome%' order by nome ASC";
		}

		$executa = mysqli_query($con, $consulta);

		while($pessoas=mysqli_fetch_array($executa, MYSQLI_BOTH)){
			echo "<tr>
					<td>$pessoas[nome]</td>
					<td>$pessoas[cpf]</td>
					<td>$pessoas[rg]</td>
					<td>$pessoas[celular]</td>
					<td>$pessoas[email]</td>
					<td>$pessoas[endereco]</td>
				<td><a href='controle.php?operacao=exclui_pessoa&id_pessoa=$pessoas[id_pessoa]'> EXCLUIR </a> </td>
				<td><a href ='index.php?operacao=edita_pessoa&id_pessoa=$pessoas[id_pessoa]'> EDITAR </a> </td>
				</tr>";
		}
	}
else{
//------------ PESQUISA DE PAGINA ----------------------------
//Imprime a paginação
$imprime = '<div align="center">  <ul class="pagination pagination-sm">';
//300 registros /50
//pagina= 6, no exemplo temos 6paginas
// Realiza a conta para verificar quantas páginas serão 
//necessárias para a exibição de todo conteúdo (N° de registros totais / registros por pagina)
$paginas=(($total['total']/$registros)+1);

//intval Transforma a quantidade de pág em número inteiro p n ter valor qubrado p/ atrapalha nas contas
$cont_pag=intval($paginas);//ex 6,3 vira 6

//codigo do bootstrap q imprime a quant total de registros encontrados e a quant de páginas(bolinha)
$imprime .= "<li class=page-item><a class=page-link href=\"#\"> <span class=\"badge pull-right\">$total[total]</span>Registros</a></li>
<li class=page-item><a class=page-link href=\"#\"> <span class=\"badge pull-right\">$cont_pag</span>Paginas</a></li>";
//.=concatenar 

//Lógica para encontrar o 1° e ultimo registro de uma pagina (n° da página - 1 x qtd de registros por páginas)
//ex: (pg 1 - 1) x 10 = 0 registros --- Os registros exibidos será do 0 ao 10
//ex: pagina = 3| registros 10
//(pg 3 -1)*10= 20 , entao aq eh exibido do 20 ate 39
$registro_inicial=(( $pagina - 1) * $registros);

//Realiza consulta no BD iniciando a busca pela váriavel registro inicial, tendo a variavel registros a Qtd de elementos mostrados
$consulta_cliente="select * from pessoas order by nome ASC limit ".$registro_inicial.", $registros";
$sql_cliente=mysqli_query($con, "$consulta_cliente");

// próxima se refere ao botão (a página atual + 1) ex pagina 12 a proxima recbe 1 e entao e a pag 13
$proxima = $pagina + 1;

// anterior se refere ao botão (a página atual - 1)
$anterior = $pagina - 1;

//se a pagina ehmaior que 1 o botão anterior é exibido, se não ele não vai ser exibido
if ($pagina>1) {
	$imprime .= '<li class="page-item"><a class="page-link" href="http://alunos.suportelab.com.br:15000/alunos/marislene/sistema/index.php?operacao=pessoas&pag='.$anterior.'">anterior</a></li>';
  }else{	
	$imprime .= ''; 	
  }

// <= 5 -- 1 2 3 4 5 6 7 8 9 10  
//----------EXEMPLO
// >5 -- imagino q to na pagina 7 ----- aux1 recebde 7 entao 7(q e a pagina)-5 = 2  E
//7+5=12 (aux2=$pagina+5)
//PAGINACAO 2 A 12
//NO 3 IF A PAGINACAO VAI DE 2 3 4 5 6 7 8 9 10 11


//mantendo os botões alinhados conforme a pág
if ($paginas > 10){ // verificando a paginacao, se for mais q 10 corto as iniciais e a sfinais 
	if($pagina<=5){ $aux1=1; $aux2=11; }//botao vai do 1 ate 11
	if($pagina>5){ $aux1=$pagina-5; $aux2=$pagina+6; }
	if($pagina+5 > $paginas) { $aux1=$pagina-5; $aux2=$pagina+5;}
	if($pagina+4 > $paginas) { $aux1=$pagina-6; $aux2=$pagina+4;}
	if($pagina+3 > $paginas) { $aux1=$pagina-7; $aux2=$pagina+3;}
	if($pagina+2 > $paginas) { $aux1=$pagina-8; $aux2=$pagina+2;}
	if($pagina+1 > $paginas) { $aux1=$pagina-9; $aux2=$pagina+1;}
}else{ 
	$aux1=1;
	$aux2=$paginas;
	// se eu tiver 4 paginas, vai ser de 1 ate 4
} 

//Gerando botões
for( $a=$aux1; $a<$aux2; $a++ ){ 
    if ($a == $pagina) 	{ 
      $imprime .= '<li class="page-item"><a class="page-link" href="http://alunos.suportelab.com.br:15000/alunos/marislene/sistema/index.php?operacao=pessoas&pag='.$a.'">'.$a.'</a></li>';				
    } else {
      $imprime .= '<li class="page-item"><a class="page-link" href="http://alunos.suportelab.com.br:15000/alunos/marislene/sistema/index.php?operacao=pessoas&pag='.$a.'">'.$a.'</a></li>';	
    }
  }						
	
	// 10 , proxima 9					
	if ($proxima <= $paginas )	{
		$imprime .= '<li class="page-item"><a class="page-link" href="http://alunos.suportelab.com.br:15000/alunos/marislene/sistema/index.php?operacao=pessoas&pag='.$proxima.'">pr&oacute;xima &raquo;</a></li>';
	}
echo $imprime;//imprime a quantidade de letras 
echo ' </ul> </div>';

$consulta_cliente="SELECT * FROM `pessoa` ORDER BY nome ASC LIMIT $registro_inicial, $registros";
$sql_cliente=mysqli_query($con, $consulta_cliente);

 while ($linha = mysqli_fetch_array($sql_cliente, MYSQLI_BOTH)) {
  echo"<tr> 
	<td>$linha[nome]</td>
	<td>$linha[cpf]</td>
	<td>$linha[rg]</td>
	<td>$linha[celular]</td>
	<td>$linha[email]</td>
	<td>$linha[endereco]</td>
	<td><a href='index.php?operacao=edita_pessoa&id_pessoa=$linha[id_pessoa]'>Editar </a></td>
	<td><a href='controle.php?operacao=excluir_pessoa&id_pessoa=$linha[id_pessoa]'>Excluir </a></td>
	</tr>"; 
 }
} 
 ?>

  </tbody>
</table>
</div>
</div>







   