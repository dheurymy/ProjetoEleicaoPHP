<?php

$arquivoCsv = 'candidatos/candidatos_deputado_federal.csv';

// Função para ler um arquivo CSV e retornar os dados como um array
function lerCSV($arquivoCsv)
{
  $candidatos = [];
  if (($handle = fopen($arquivoCsv, "r")) !== FALSE) {
    while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
      $candidatos[] = $row;
    }
    fclose($handle);
  }
  return $candidatos;
}

function percentualVotos($quantidadeVotos, $totalVotos)
{
  return round(($quantidadeVotos / $totalVotos) * 100, 2);
}

function calcularTotalVotos($candidatos)
{
  $votos = 0;

  foreach ($candidatos as $indice => $linha) {
    $colunaVotos = 5;

    if (isset($candidatos[$indice][$colunaVotos])) {
      $votos = $votos + ($candidatos[$indice][$colunaVotos]);
    }
  }

  return $votos;
}

function ordenarPorUltimaColuna($dados)
{
  // Função de comparação personalizada para usar com usort
  usort($dados, function ($a, $b) {
    return $b[count($b) - 1] <=> $a[count($a) - 1];
  });
  return $dados;
}

$candidatos = lerCSV($arquivoCsv);
$candidatosOrdenados = ordenarPorUltimaColuna($candidatos);
$totalVotos = calcularTotalVotos($candidatos);
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
            <li class="breadcrumb-item" aria-current="page">Resultados da Eleição</li>
            <li class="breadcrumb-item active" aria-current="page">Resultado para Deputado Federal</li>
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
        <h2 class="my-4">Resultado para Deputado Federal</h2>

        <form action="resultadoSenador.php" method="post" enctype="multipart/form-data" class="border border-dark rounded-lg p-3">
          <?php
          foreach ($candidatosOrdenados as $indice => $linha) {

            if ($indice < 3) {
              $template = '<div class="card mb-2">'
                .  '<div class="row">'
                .    '<div class="col-1">'
                .      '<h3>' . $indice + 1 . 'º</h3>'
                .      '<p>' . percentualVotos($linha[5], $totalVotos) . '%</p>'
                .      '<div class="px-2">'
                .        '<div class="alert alert-success w-100">✓</div>'
                .      '</div>'
                .    '</div>';
            } else {
              $template = '<div class="card mb-2">'
                .  '<div class="row">'
                .    '<div class="col-1">'
                .      '<h3>' . $indice + 1 . 'º</h3>'
                .      '<p>' . percentualVotos($linha[5], $totalVotos) . '%</p>'
                .    '</div>';
            }

            if ($linha[4] == '') {
              $template = $template
                .    '<div class="col-2 d-flex align-items-center justify-content-center">'
                .      '<div class="img-thumbnail semfoto mx-auto">Sem foto</div>'
                .    '</div>';
            } else {
              $template = $template
                .    '<div class="col-2 d-flex align-items-center justify-content-center">'
                .      '<div class="img-candidato"><img src="' . $linha[4] . '" class="img img-thumbnail"></div>'
                .    '</div>';
            }

            $template = $template
              . '<div class="col-9 d-flex justify-content-center align-items-center flex-column">'
              .      '<h4>' . $linha[0] . '</h4>'
              .      '<h5>' . $linha[1] . ' - Partido: ' . $linha[2] . '</h5>'
              .      '<p> Quantidade de Votos: ' . $linha[5] . '</p>'
              .    '</div>'
              .  '</div>'
              . '</div>';

            echo $template;
          }
          ?>
        </form>
      </div>
    </div>
</main>

<?php include('footer.php') ?>