<?php
$id_pessoa = mysqli_real_escape_string($con, $_GET['id_pessoa']);
$xyz = "SELECT * from `pessoa` WHERE id_pessoa = '$id_pessoa'";
$abc = mysqli_query($con, $xyz);
$pessoa = mysqli_fetch_array($abc, MYSQLI_BOTH);
?>
<div class="container">
<div class="row">
<div class="col-sm-12">
<h3> Edita Pessoa </h3>

<form method="GET" action="controle.php"> 
	<div class="form-group"> 
		<label for="id_pessoa">ID</label>
		<input type="text" class="form-control form-control-sm" name="id_pessoa" value="<?php echo $pessoa['id_pessoa'];?>" readonly="true"> 
		<input type="hidden" name="operacao" value="edita_pessoa">
	</div>
	<div class="form-group"> 
		<label for="nome">Nome:</label>
    	<input type="text" class="form-control form-control-sm" name="nome" value="<?=$pessoa['nome'];?>">
	</div>
	<div class="form-group"> 
		<label for="cpf">CPF:</label>
    	<input type="text" class="form-control form-control-sm" name="cpf" value="<?php echo $pessoa['cpf'];?>">
    </div>
    <div class="form-group">
    	<label for="rg">RG:</label>
    	<input type="text" class="form-control form-control-sm" name="rg" value="<?php echo $pessoa['rg'];?>">
    </div>
    <div class="form-group">
    	<label for="celular">Celular:</label>
    	<input type="text" class="form-control form-control-sm" name="celular"value="<?php echo $pessoa['celular'];?>">
    </div>
    <div class="form-group">
    	<label for="email">Email:</label>
    	<input type="text" class="form-control form-control-sm" name="email" value="<?php echo $pessoa['email'];?>">
    </div>
    <div class="form-group">
    	<label for="endereco">Endereço:</label>
    	<input type="text" class="form-control form-control-sm" name="endereco" value="<?php echo $pessoa['endereco'];?>">
    </div>
    <div class="form-group">
    	<label for="observacao">Observacao:</label> 
    	<input type="text" class="form-control form-control-sm" name="observacao" value="<?php echo $pessoa['observacao'];?>">
    </div>
    <div class="form-group">
    	<input type="submit" class="btn btn-dark" value="Editar">
    </div>
</form>

</div>
</div>
</div>