
<div class="container">
<div class="row">
<div class="col-sm-12">
<h3> Nova  Pessoa </h3>

<form method="GET" action="controle.php">  
    
    <div class="form-group"> 
        <input type="text" name="nome" placeholder="Nome"> 
        <input type="hidden" name="operacao" value="nova_pessoa">
    </div>
    <div class="form-group">
        <input type="text" name="cpf" placeholder="CPF:">
    </div>
    <div class="form-group">
        <input type="text" name="rg" placeholder="RG">
    </div>
    <div class="form-group">
        <input type="text" name="celular" placeholder="Celular"> 
    </div>
    <div class="form-group">
        <input type="text" name="email" placeholder="E-mail:">
    </div>
    <div class="form-group">
        <input type="text" name="endereco" placeholder="endereco">
    </div>
    <div class="form-group">
        <input type="text" name="observacao" placeholder="Observacao">
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-dark" value="Cadastrar">
    </div>
   </form>
   
</div>
</div>
</div>