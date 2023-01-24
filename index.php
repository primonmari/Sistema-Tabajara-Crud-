<?php 
session_start();
if ($_SESSION['validacao'] != '1'){/*validacao e uma variavel, se diferenrte de 1*/ 
  echo "Nao está logado, redirecionando para login";
  header('location: login.php');/*direciona p essa pag de login*/ 
  exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Sistema Tabajara</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<?php
include 'includes/conectar.php';
include 'includes/funcoes.php';
?>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <a class="navbar-brand" href="index.php">Tabajara</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.php?operacao=pessoas">Pessoas</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">OutraCoisa</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php?operacao=logs">Logs</a>
      </li>    
    </ul>
  </div>  
</nav>

<?php

if (isset($_GET['operacao'])){ // inicio operacao

  $operacao = mysqli_real_escape_string($con,$_GET['operacao']); //echo "operacao = $operacao"; 
  
  switch ($operacao) {
    case 'pessoas':
        include 'cadastro/pessoas.php';
        break;
    case 'edita_pessoa':
        include 'cadastro/edita_pessoas.php';
        break;
    case 'nova_pessoa':
        include 'cadastro/nova_pessoa.php';
        break;
    case 'logs':
        include 'cadastro/logs.php';
        break;

  }


}else{ // nao existe operacao, mostrar pagina inicial 
  ?>
  <!-- CORPO DO SISTEMA -->
  <div class="container" style="margin-top:30px">
    <div class="row">
      <div class="col-sm-8">
        
        <div class="card">
          <div class="card-header bg-dark text-white">Sistema Tabajara</div>
          <div class="card-body">
            <p>Usuario: <?php echo $_SESSION['login']; ?></p>
            <p>IP: <? echo $_SERVER['REMOTE_ADDR']; ?> </p>
            <p>Data: <?php echo date("d-m-Y"); ?> </p>
          </div>
          <div class="card-footer"></div>
        </div>
      
      </div>

      <div class="col-sm-4">
        <div class="card">
          <div class="card-header bg-dark text-white">Titulo</div>
          <div class="card-body">Informações </div>
          <div class="card-footer"></div>
        </div>
      </div>

      </div>

    </div>
  
  <!-- FIM CORPO DO SISTEMA -->
<?php } // fim do else ?>

<div class="jumbotron text-center" style="margin-bottom:0">
  <p>Sistema Tabajara 2022 Todos os direitos reservados</p>
</div>

</body>
</html>
