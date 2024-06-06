<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Projeto - Eleições On-line</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <!--<link rel="stylesheet" href="ESTILO/bootstrap-4.6.2-dist/css/bootstrap.min.css">-->
  <link rel="stylesheet" href="ESTILO/style.css">
</head>

<body>
  <div class="container-fluid border">
    <header class="blog-cabecalho py-3">
      <div class="container-fluid text-center">
        <h1 class="display-2">Eleições On-line</h1>
        <small class="text-muted">
          <h4>Facilitando seu acesso a democracia!</h4>
        </small>
        <br>
      </div>
    </header>
    <nav class="navbar navbar-expand-md navbar-light bg-light">
      <a href="index.php" class="navbar-brand">
        <h2>Eleições On-line</h2>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navegacao" aria-controls="navegacao" aria-expanded="true" aria-label="Alterna navegação">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navegacao">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a href="cadastroCandidatos.php" class="nav-link">Configuração da Urna
              <span class="sr-only">(atual)</span>
            </a>
          </li>
          <li class="nav-item active">
            <div class="dropdown">
              <a class="btn btn-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Processo de Votação
              </a>

              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="votacaoPresidente.php">Votação para Presidente</a>
                <a class="dropdown-item" href="votacaoSenador.php">Votação para Senador</a>
                <a class="dropdown-item" href="votacaoDeputadoFederal.php">Votação para Deputado Federal</a>
              </div>
            </div>
          </li>
          <li class="nav-item active">
            <div class="dropdown">
              <a class="btn btn-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Resultados da Eleição
              </a>

              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="resultadoPresidente.php">Resultado para Presidente</a>
                <a class="dropdown-item" href="resultadoSenador.php">Resultado para Senador</a>
                <a class="dropdown-item" href="resultadoDeputadoFederal.php">Resultado para Deputado Federal</a>
              </div>
            </div>
          </li>
        </ul>

      </div>
    </nav>
  </div>