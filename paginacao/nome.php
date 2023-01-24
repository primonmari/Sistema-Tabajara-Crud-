</br></br></br>
<?
$registros='50';

	if ( !isset($_GET['letra'])){ // inicia verificacao letra
		if ( !isset($_GET['pesquisa_cod'])){ // inicia verificacao codigo
			if ( !isset($_GET['pesquisa_nome'])){ // inicia verificacao nome
				if ( !isset($_GET['pag'])){
					$pagina=1; 
				}else{
				$pagina=$_GET['pag'];
				}						
						
				$total_cliente=mysqli_query($con, "select count(idpaciente) as total FROM paciente");
				$total=mysqli_fetch_array($total_cliente, MYSQLI_BOTH);
				$imprime = '<div align="center">  <ul class="pagination pagination-sm">';
				$paginas=(($total['total']/$registros)+1);
				$cont_pag=intval($paginas);
				$imprime .= "<li><a href=\"#\"> <span class=\"badge pull-right\">$total[total]</span>Registros</a></li>
							 <li><a href=\"#\"> <span class=\"badge pull-right\">$cont_pag</span>Paginas</a></li>";
		
				$registro_inicial=(( $pagina - 1) * $registros);
				$consulta_cliente="select * from paciente order by nome ASC limit ".$registro_inicial.", $registros";
				$sql_cliente=mysqli_query($con, "$consulta_cliente");
				$proxima = $pagina + 1;
				$anterior = $pagina - 1;
				
				if ($pagina>1) {
					$imprime .= '<li><a href="sistema.php?op=menu&action=paciente&pag='.$anterior.'">anterior</a></li>';
				}else{	
					$imprime .= ''; 	
				}
				if ($paginas > 10){ // verificando a paginacao
					if($pagina<=5){ $aux1=1; $aux2=11; }
					if($pagina>5){ $aux1=$pagina-5; $aux2=$pagina+6; }
					if($pagina+5 > $paginas) { $aux1=$pagina-5; $aux2=$pagina+5;}
					if($pagina+4 > $paginas) { $aux1=$pagina-6; $aux2=$pagina+4;}
					if($pagina+3 > $paginas) { $aux1=$pagina-7; $aux2=$pagina+3;}
					if($pagina+2 > $paginas) { $aux1=$pagina-8; $aux2=$pagina+2;}
					if($pagina+1 > $paginas) { $aux1=$pagina-9; $aux2=$pagina+1;}
				}else{ 
					$aux1=1;
					$aux2=$paginas;
				} 
	
				for( $a=$aux1; $a<$aux2; $a++ ){ // loop para gerar as paginas
				if ($a == $pagina) 	{ // para destacar a pagina atual
					$imprime .= '<li class="active"><a href="sistema.php?op=menu&action=paciente&pag='.$a.'">'.$a.'</a></li>';				
				} else {
					$imprime .= '<li><a href="sistema.php?op=menu&action=paciente&pag='.$a.'">'.$a.'</a></li>';	
				}
				}							
						
				if ($proxima <= $paginas )	{
				$imprime .= '<li><a href="sistema.php?op=menu&action=paciente&pag='.$proxima.'">pr&oacute;xima &raquo;</a></li>';
				}
			echo $imprime;
			echo ' </ul> </div>';
				
			}else{ // else nome
				
				if ( !isset($_GET['pagina'])){
					$pagina=1; 
				}else{
					$pagina=$_GET['pagina'];
				}
			
				$nome=mysqli_real_escape_string($con, $_REQUEST['nome']);
				///// nova consulta por nome com desmembramento dos valores
				$termos = explode(" ", $nome);
				$termos_qtd = count($termos);
				
				switch ($termos_qtd) {
				case "1":
					$total_cliente=mysqli_query($con, "select count(idpaciente) as total FROM paciente WHERE nome like '%$nome%'"); 
					break;
				case "2":
					$total_cliente=mysqli_query($con, "select count(idpaciente) as total FROM paciente WHERE nome like '%$nome%' OR ( nome like '%$termos[0]%' AND nome like '%$termos[1]%')"); 
					break;
				case "3":
					$total_cliente=mysqli_query($con, "select count(idpaciente) as total FROM paciente WHERE nome like '%$nome%' OR ( nome like '%$termos[0]%' AND nome like '%$termos[1]%' AND nome like '%$termos[2]%'"); 
					break;
				case "4":
					$total_cliente=mysqli_query($con, "select count(idpaciente) as total FROM paciente WHERE nome like '%$nome%' OR ( nome like '%$termos[0]%' AND nome like '%$termos[1]%' AND nome like '%$termos[2]%' AND nome like '%$termos[3]%'"); 
					break;
				default:
					$total_cliente=mysqli_query($con, "select count(idpaciente) as total FROM paciente WHERE nome like '%$nome%'"); 
				}				
				
				// consulta original simples, sem decomposicao dos termos
				//$total_cliente=mysql_query("select count(idpaciente) as total FROM paciente WHERE nome like '%$nome%'"); 
				
				$total=mysqli_fetch_array($total_cliente, MYSQLI_BOTH);
				$paginas=(($total['total']/$registros)+1);
				$imprime = '<div align="center"> <ul class="pagination pagination-sm">';
				$cont_pag=intval($paginas);
				$imprime .= "<li><a href=\"#\"> <span class=\"badge pull-right\">$total[total]</span>Registros</a></li>
							 <li><a href=\"#\"> <span class=\"badge pull-right\">$cont_pag</span>Paginas</a></li>";
		
				$registro_inicial=(( $pagina - 1) * $registros);
				// consulta original antes de decompor em termos
				//$consulta_cliente="select * from paciente where nome like '%$nome%' order by nome ASC limit ".$registro_inicial.", $registros";
				
				switch ($termos_qtd) {
				case "1":
					$consulta_cliente="select * FROM paciente WHERE nome like '%$nome%' order by nome ASC limit ".$registro_inicial.", $registros"; 
					//echo "$consulta_cliente";
					break;
				case "2":
					$consulta_cliente="select * FROM paciente WHERE nome like '%$nome%' OR ( nome like '%$termos[0]%' AND nome like '%$termos[1]%') order by nome ASC limit ".$registro_inicial.", $registros"; 
					//echo "$consulta_cliente";
					break;
				case "3":
					$consulta_cliente="select * FROM paciente WHERE nome like '%$nome%' OR ( nome like '%$termos[0]%' AND nome like '%$termos[1]%' AND nome like '%$termos[2]%') order by nome ASC limit ".$registro_inicial.", $registros"; 
					//echo "$consulta_cliente";
					break;
				case "4":
					$consulta_cliente="select * FROM paciente WHERE nome like '%$nome%' OR ( nome like '%$termos[0]%' AND nome like '%$termos[1]%' AND nome like '%$termos[2]%' AND nome like '%$termos[3]%') order by nome ASC limit ".$registro_inicial.", $registros"; 
					//echo "$consulta_cliente";
					break;
				default:
					$consulta_cliente="select * FROM paciente WHERE nome like '%$nome%' order by nome ASC limit ".$registro_inicial.", $registros"; 
					//echo "$consulta_cliente";
				}	
				
				
				$sql_cliente=mysqli_query($con, "$consulta_cliente");
					
				$proxima = $pagina + 1;
				$anterior = $pagina - 1;
				
				if ($pagina>1) {
					$imprime .= '<li><a href="sistema.php?op=menu&action=paciente&nome='.$nome.'&pesquisa_nome=sim&pagina='.$anterior.'">anterior</a></li>';
				}else{	
					$imprime .= ''; 	
				}
				if ($paginas > 10){ // verificando a paginacao
				if($pagina<=5){ $aux1=1; $aux2=11; }
				if($pagina>5){ $aux1=$pagina-5; $aux2=$pagina+6; }
				if($pagina+5 > $paginas) { $aux1=$pagina-5; $aux2=$pagina+5;}
				if($pagina+4 > $paginas) { $aux1=$pagina-6; $aux2=$pagina+4;}
				if($pagina+3 > $paginas) { $aux1=$pagina-7; $aux2=$pagina+3;}
				if($pagina+2 > $paginas) { $aux1=$pagina-8; $aux2=$pagina+2;}
				if($pagina+1 > $paginas) { $aux1=$pagina-9; $aux2=$pagina+1;}
				}else{ 
				$aux1=1;
				$aux2=$paginas;
				} 
				for( $a=$aux1; $a<$aux2; $a++ ){ // loop para gerar as paginas
					if ($a == $pagina) 	{ // para destacar a pagina atual
					$imprime .= '<li class="active"><a href="sistema.php?op=menu&action=paciente&nome='.$nome.'&pesquisa_nome=sim&pagina='.$a.'">'.$a.'</a></li>';				
					} else {
					$imprime .= '<li><a href="sistema.php?op=menu&action=paciente&nome='.$nome.'&pesquisa_nome=sim&pagina='.$a.'">'.$a.'</a></li>';	
					}
				}							
						
				if ($proxima <= $paginas )	{
				$imprime .= '<li><a href="sistema.php?op=menu&action=paciente&nome='.$nome.'&pesquisa_nome=sim&pagina='.$proxima.'">pr&oacute;xima &raquo;</a></li>';
				}
				echo $imprime;
				echo '</ul></div>';		
					
				} // fim nome
				
				}else{ // else codigo
				$codigo=mysqli_real_escape_string($con, $_REQUEST['codigo']);
				$total_cliente=mysqli_query($con, "select count(idpaciente) as total FROM paciente WHERE idpaciente = '$codigo'"); 
				$total=mysqli_fetch_array($total_cliente, MYSQLI_BOTH);
				$paginas=(($total['total']/$registros)+1);
				$imprime = '<div align="center"> <ul class="pagination pagination-sm">';
				$cont_pag=intval($paginas);
				$imprime .= "<li><a href=\"#\"> <span class=\"badge pull-right\">$total[total]</span>Registros</a></li>
							 <li><a href=\"#\"> <span class=\"badge pull-right\">$cont_pag</span>Paginas</a></li>";
					
				if ( !isset($_GET['pagina'])){
					$pagina=1; 
				}else{
					$pagina=$_GET['pagina'];
				}
					
				$registro_inicial=(( $pagina - 1) * $registros);
				$consulta_cliente="select * from paciente where idpaciente = '$codigo' order by nome ASC limit ".$registro_inicial.", $registros";
				$sql_cliente=mysqli_query($con, "$consulta_cliente");
							
				for ( $num=1; $num<=$paginas; $num++) {
				$imprime .= "<li><a href='sistema.php?op=menu&action=paciente&pesquisa_cod=sim&pagina=".$num."'>".$num."</a></li>";
				}
				echo $imprime;
				echo '</ul></div>';		
				} // fim codigo
				
			}else{ // else letra
			
			$letra=mysqli_real_escape_string($con, $_REQUEST['letra']);
			$total_cliente=mysqli_query($con, "select count(idpaciente) as total FROM paciente WHERE nome like '$letra%'"); 
			$total=mysqli_fetch_array($total_cliente, MYSQLI_BOTH);
			$paginas=(($total['total']/$registros)+1);
			$imprime = '<div align="center"> <ul class="pagination pagination-sm">';
			$cont_pag=intval($paginas);
			$imprime .= "<li><a href=\"#\"> <span class=\"badge pull-right\">$total[total]</span>Registros</a></li>
							 <li><a href=\"#\"> <span class=\"badge pull-right\">$cont_pag</span>Paginas</a></li>";
						
				if ( !isset($_GET['pagina'])){
					$pagina=1; 
				}else{
					$pagina=$_GET['pagina'];
				}
					
			$registro_inicial=(( $pagina - 1) * $registros);
			$consulta_cliente="select * from paciente where nome like '$letra%' order by nome ASC limit ".$registro_inicial.", $registros";
			$sql_cliente=mysqli_query($con, "$consulta_cliente");
			
			$proxima = $pagina + 1;
			$anterior = $pagina - 1;
				
			if ($pagina>1) {
			$imprime .= '<li><a href="sistema.php?op=menu&action=paciente&letra='.$letra.'&pagina='.$anterior.'">anterior</a></li>';
				}else{	
			$imprime .= ''; 	
			}
	if ($paginas > 10){ // verificando a paginacao
	if($pagina<=5){ $aux1=1; $aux2=11; }
	if($pagina>5){ $aux1=$pagina-5; $aux2=$pagina+6; }
	if($pagina+5 > $paginas) { $aux1=$pagina-5; $aux2=$pagina+5;}
	if($pagina+4 > $paginas) { $aux1=$pagina-6; $aux2=$pagina+4;}
	if($pagina+3 > $paginas) { $aux1=$pagina-7; $aux2=$pagina+3;}
	if($pagina+2 > $paginas) { $aux1=$pagina-8; $aux2=$pagina+2;}
	if($pagina+1 > $paginas) { $aux1=$pagina-9; $aux2=$pagina+1;}
	}else{ 
	$aux1=1;
	$aux2=$paginas;
	} 
	for( $a=$aux1; $a<$aux2; $a++ ){ // loop para gerar as paginas

			if ($a == $pagina) 	{ // para destacar a pagina atual
				$imprime .= '<li class="active"><a href="sistema.php?op=menu&action=paciente&letra='.$letra.'&pagina='.$a.'">'.$a.'</a></li>';
			} else {
				$imprime .= '<li><a href="sistema.php?op=menu&action=paciente&letra='.$letra.'&pagina='.$a.'">'.$a.'</a></li>';	
			}
		}							
						
	if ($proxima <= $paginas )	{
		$imprime .= '<li><a href="sistema.php?op=menu&action=paciente&letra='.$letra.'&pagina='.$proxima.'">pr&oacute;xima &raquo;</a></li>';
	}
	echo $imprime;
	echo '</ul></div>';
			
			} // fim letra
	   
	?>
	
	        <table class="table table-striped table-condensed table-hover">
		 <thead>
		 <tr>
		 <td colspan="7">
					<form class="navbar-form navbar-left" action="sistema.php" name="pesquisa_paciente">
						<div class="form-group "> 
						<input type="hidden" name="op" value="menu" />
						<input type="hidden" name="action" value="paciente" />
						<input type="hidden" name="pesquisa_nome" value="sim" />
						<input type="text" class="form-control input-sm" placeholder="nome paciente..." id="nomeid" name="nome" />
						</div> <button type="submit" class="btn btn-sm btn-primary">Busca</button>
					</form>
					<form class="navbar-form navbar-left" action="sistema.php" >
						<div class="col-xs-6"> 
						<input type="hidden" name="op" value="menu" />
						<input type="hidden" name="action" value="paciente" />
						<input type="hidden" name="pesquisa_cod" value="sim" />
						<input type="text" class="form-control input-sm" placeholder="codigo..." id="codigo" name="codigo" />
						</div> <button type="submit" class="btn btn-sm btn-primary">Busca</button>
					</form>
					<form class="navbar-form navbar-left" action="sistema.php" >
						<div class="form-group"> 
						<input type="hidden" name="op" value="menu" />
						<input type="hidden" name="action" value="paciente" />
						</div> <button type="submit" class="btn  btn-sm btn-primary">Listar Todos</button>
					</form>
					
					<form class="navbar-form navbar-right" action="sistema.php" >
						<div class="form-group"> 
						<input type="hidden" name="op" value="menu" />
						<input type="hidden" name="action" value="novo_paciente" />
						</div> <button type="submit" class="btn btn-sm btn-success">Novo Paciente</button>
					</form>
       </td>
		 </tr>
		 
            <tr>
              <th width="3%">&nbsp;</th>
			  <th width="3%">&nbsp;</th>
			  <th width="3%">&nbsp;</th>
              <th><div align="center">Codigo</div></th>
              <th>Nome</th>
              <th>Celular</th>
              <th>Data Nasc</th>
            </tr>
          </thead>
           <? While($cli_linha=mysqli_fetch_array($sql_cliente, MYSQLI_BOTH)){  ?>
          <tr> 
            <td align="center">
				<a title="CADASTRAR NOVO ATENDIMENTO  RAPIDO PARA PACIENTE" href="console.php?op=novo_atendimento_rapido&idpaciente=<?=$cli_linha['idpaciente'];?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-new-window"></span>Atendimento</a>
				
			</td>
			<td>
				<a href="sistema.php?op=menu&action=edita_paciente&idpaciente=<?=$cli_linha['idpaciente'];?>" class="btn btn-primary btn-xs" title="EDITAR PACIENTE"><span class="glyphicon glyphicon-edit"></span>Editar</a></td>
            <td>
			<form id="form1" name="form1" method="post" action="console.php?op=exclui_paciente&idpaciente=<?=$cli_linha['idpaciente'];?>">
				<button type="submit" title="EXCLUIR PACIENTE" class="btn btn-danger btn-xs " name="del" id="del" onclick="return confirma_excluir();" value='Excluir'><span class="glyphicon glyphicon-trash"></span>Excluir</button>
               </form>
			</td>
			<td><div align="center"><?=$cli_linha['idpaciente'];?></div></td>
            <td><a href="sistema.php?op=menu&action=edita_paciente&idpaciente=<?=$cli_linha['idpaciente'];?>"><?=$cli_linha['nome'];?></a></td>
            
            <td><?=$cli_linha['telefone'];?></td>
             <? $data_cadastro = dataparavisual($cli_linha['data_nascimento']); ?>
            <td><?=$data_cadastro;?></td>
          </tr>
          <?  } ?>
          
</table>


<div class="view" align="center" >
	<ul class="pagination pagination-sm">
	<li><a href="sistema.php?op=menu&action=paciente&letra=a" >A</a></li>
	<li><a href="sistema.php?op=menu&action=paciente&letra=b" >B</a></li>
	<li><a href="sistema.php?op=menu&action=paciente&letra=c" >C</a></li>
	<li><a href="sistema.php?op=menu&action=paciente&letra=d" >D</a></li>
	<li><a href="sistema.php?op=menu&action=paciente&letra=e" >E</a></li>
	<li><a href="sistema.php?op=menu&action=paciente&letra=f" >F</a></li>
	<li><a href="sistema.php?op=menu&action=paciente&letra=g" >G</a></li>
	<li><a href="sistema.php?op=menu&action=paciente&letra=h" >H</a></li>
	<li><a href="sistema.php?op=menu&action=paciente&letra=i" >I</a></li>
	<li><a href="sistema.php?op=menu&action=paciente&letra=j" >J</a></li>
	<li><a href="sistema.php?op=menu&action=paciente&letra=k" >K</a></li>
	<li><a href="sistema.php?op=menu&action=paciente&letra=l" >L</a></li>
	<li><a href="sistema.php?op=menu&action=paciente&letra=m" >M</a></li>
	<li><a href="sistema.php?op=menu&action=paciente&letra=n" >N</a></li>
	<li><a href="sistema.php?op=menu&action=paciente&letra=o" >O</a></li>
	<li><a href="sistema.php?op=menu&action=paciente&letra=p" >P</a></li>
	<li><a href="sistema.php?op=menu&action=paciente&letra=q" >Q</a></li>
	<li><a href="sistema.php?op=menu&action=paciente&letra=r" >R</a></li>
	<li><a href="sistema.php?op=menu&action=paciente&letra=s" >S</a></li>
	<li><a href="sistema.php?op=menu&action=paciente&letra=t" >T</a></li>
	<li><a href="sistema.php?op=menu&action=paciente&letra=u" >U</a></li>
	<li><a href="sistema.php?op=menu&action=paciente&letra=v" >V</a></li>
	<li><a href="sistema.php?op=menu&action=paciente&letra=w" >W</a></li>
	<li><a href="sistema.php?op=menu&action=paciente&letra=x" >X</a></li>
	<li><a href="sistema.php?op=menu&action=paciente&letra=y" >Y</a></li>
	<li><a href="sistema.php?op=menu&action=paciente&letra=z" >Z</a></li>

	</ul>	
</div>
		
<script type="text/javascript">
<!--
  document.pesquisa_paciente.nome.focus();
//-->
</script>
	<!-- fim div cliente -->