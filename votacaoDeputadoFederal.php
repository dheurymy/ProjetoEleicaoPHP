<?php

$arquivoCsv = 'candidatos/candidatos_deputado_federal.csv';
$textoInformativo = "Vote com consciência!";

// Abre o arquivo para leitura
if (($handle = fopen($arquivoCsv, 'r')) !== FALSE) {
  $candidatos = [];

  while (($linha = fgetcsv($handle, 1000, ',')) !== FALSE) {
    $candidatos[] = $linha;
  }

  fclose($handle);
} else {
  echo 'Não foi possível abrir o arquivo.';
}

// Função para ler todo o conteúdo do arquivo CSV e armazenar em um array
function lerCsv($arquivoCsv)
{
  $dados = [];
  if (($handle = fopen($arquivoCsv, 'r')) !== FALSE) {
    while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
      $dados[] = $row;
    }
    fclose($handle);
  }
  return $dados;
}

// Função para escrever todo o conteúdo de um array de volta para o arquivo CSV
function escreverCsv($arquivoCsv, $dados)
{
  if (($handle = fopen($arquivoCsv, 'w')) !== FALSE) {
    foreach ($dados as $linha) {
      fputcsv($handle, $linha);
    }
    fclose($handle);
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $numeroCandidatoVotado = 0;

  if (isset($_POST['numeroCandidatoVotado'])) {
    $numeroCandidatoVotado = htmlspecialchars($_POST['numeroCandidatoVotado']);
  }

  $candidatos = lerCsv($arquivoCsv);

  foreach ($candidatos as $indice => $linha) {
    if ($numeroCandidatoVotado == $linha[1]) {
      $linhaParaAlterar = $indice;
      $colunaParaAlterar = 5;

      if (isset($candidatos[$linhaParaAlterar][$colunaParaAlterar])) {
        $candidatos[$linhaParaAlterar][$colunaParaAlterar] = ($candidatos[$linhaParaAlterar][$colunaParaAlterar] + 1);
      }

      escreverCsv($arquivoCsv, $candidatos);
      $textoInformativo = "Voto registrado com sucesso.";
    }
  }
}
?>

<?php include('header.php') ?>

<main role="main" class="container-fluid">
  <div class="row">
    <aside class="col-sm-3 blog-sidebar border">
      <div class="p-3 mb-3 bg-light rounded">
        <h4 class="font-italic">Você está aqui:</h4>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Eleições On-line</a></li>
            <li class="breadcrumb-item" aria-current="page">Processo de Votação</li>
            <li class="breadcrumb-item active" aria-current="page">Votação para Deputado Federal</li>
          </ol>
        </nav>
      </div>
      <div class="p-3 mb-3 bg-light rounded">
        <h4 class="font-italic">Sobre nós:</h4>
        <p class="mb-0">Somos um time de <strong><em>pessoas legais</em></strong> que gostam de <strong><em>programação</em></strong> e foram <strong><em>obrigadas</em></strong> a programar em PHP para obter nota.</p>
      </div>
    </aside>

    <div class="col-sm-9 blog-main">
      <div class="blog-post text-center">
        <h2 class="my-3">Votação para Deputado Federal</h2>

        <div class="alert alert-success">
          <?php echo "$textoInformativo"; ?>
        </div>

        <form action="votacaoDeputadoFederal.php" method="post" enctype="multipart/form-data" class="border border-dark rounded-lg p-3">
          <div class="row mb-4">
            <?php
            if (empty($candidatos)) {
              echo '<div class="alert alert-warning mx-3 w-100"><p class="text-align-center m-0">Não há candidatos disponíveis!</p></div>';
            } else {
              foreach ($candidatos as $indice => $linha) {
                if ($linha[4] == '') {
                  $template = '<div class="col-sm-2 mb-2"><div class="img img-thumbnail semfoto mx-auto">Sem foto</div>';
                } else {
                  $template = '<div class="col-sm-2 mb-2"><div class="img-avatar">
                    <img src="' . $linha[4] . '" class="img-fluid img card-img img-thumbnail"></div>';
                }

                $template = $template .
                  'Candidato: <br> <strong>' . $linha[0] . '</strong><br>' .
                  'Número: ' . $linha[1] . '<br>' .
                  'Partido: ' . $linha[2] .
                  '</div>';

                echo $template;
              }
            }
            ?>
          </div>

          <div class="row mb-4">
            <label for="numeroCandidatoVotado" class="col-sm-4 col-form-label">Digite o número do candidato:</label>
            <div class="col-sm-8">
              <input type="number" class="form-control" id="inputnumeroCandidatoVotado" name="numeroCandidatoVotado" placeholder="Número do Candidato">
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-sm-1"></div>
            <button type="submit" class="btn btn-primary col-sm-4">Votar</button>
            <div class="col-sm-2"></div>

            <button type="reset" class="btn btn-warning col-sm-4">Limpar Campos</button>
            <div class="col-sm-1"></div>
          </div>
        </form>
      </div>
    </div>
</main>

<?php include('footer.php') ?>