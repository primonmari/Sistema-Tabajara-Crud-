<?php
include'pessoas.php';
include '../includes/conectar.php';

//registros a serem mostrados por páginas
$registros='10';

// verificando se esta vindo alguma pagina
if ( !isset($_GET['pag'])){//!se nao existe pagina entao atribuo 1 pq eh minha 1° pagina
$pagina=1; 
}

//Se não, atribuir p/ váriavel pagina o valor retornado
else{
	$pagina=$_GET['pag'];//entao a pagina pesquisada eh retornada
}	

//Conta o valor de pessoas no cadastro da tabela 
$total_cliente=mysqli_query($con, "select count(id_pessoa) as total FROM pessoa");

//Atribui para um array a quantidd de pessoas q foi encontradas
$total=mysqli_fetch_array($total_cliente, MYSQLI_BOTH);

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
$imprime .= "<li><a href=\"#\"> <span class=\"badge pull-right\">$total[total]</span>Registros</a></li>
<li><a href=\"#\"> <span class=\"badge pull-right\">$cont_pag</span>Paginas</a></li>";
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
	$imprime .= '<li><a href="http://alunos.suportelab.com.br:15000/alunos/gideone/index.php?operacao=pessoas&pag='.$anterior.'">anterior</a></li>';
}else{	
	$imprime .= '';//exibo nada  	
}

// <= 5 -- 1 2 3 4 5 6 7 8 9 10  
// >5 -- 7 aux1 2  12  -> 2 3 4 5 6 7 8 9 10 11
// pagina(10)+2 > paginas 11 -  aux1 =2  aux2 10+2 12 - 2 3 4 5 6 10 11

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
for( $a=$aux1; $a<$aux2; $a++ ){ // loop para gerar as paginas
	if ($a == $pagina) 	{ // para destacar a pagina atual
		$imprime .= '<li class="active"><a href="http://alunos.suportelab.com.br:15000/alunos/gideone/index.php?operacao=pessoas&pag='.$a.'">'.$a.'</a></li>';				
	} else {
		$imprime .= '<li><a href="http://alunos.suportelab.com.br:15000/alunos/gideone/index.php?operacao=pessoas&pag='.$a.'">'.$a.'</a></li>';	
	}
}							
	
	// 10 , prox 9					
if ($proxima <= $paginas )	{
	$imprime .= '<li><a href="http://alunos.suportelab.com.br:15000/alunos/gideone/index.php?operacao=pessoaspag='.$proxima.'">pr&oacute;xima &raquo;</a></li>';
}

echo $imprime;
echo ' </ul> </div>';