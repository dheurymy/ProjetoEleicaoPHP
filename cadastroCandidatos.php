<?php include('header.php') ?>

<main role="main" class="container-fluid">
  <div class="row">
    <aside class="col-sm-3 blog-sidebar border">
      <div class="p-3 mb-3 bg-light rounded">
        <h4 class="font-italic">Você está aqui:</h4>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Eleições On-line</a></li>
            <li class="breadcrumb-item active" aria-current="page">Configuração da Urna</li>
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
        <h2 class="my-4">Cadastro de Candidatos</h2>
        <div>
          <form action="cadastroCandidatos.php" method="post" enctype="multipart/form-data" class="border border-dark rounded-lg p-3">
            <div class="row mb-4">
              <label for="nomeCandidato" class="col-sm-4 col-form-label">Nome do Candidato:</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="inputNomeCandidato" name="nomeCandidato" placeholder="Nome do Candidato" required>
              </div>
            </div>
            <div class="row mb-4">
              <label for="numeroCandidato" class="col-sm-4 col-form-label">Número do Candidato:</label>
              <div class="col-sm-8">
                <input type="number" class="form-control" id="inputNumeroCandidato" name="numeroCandidato" placeholder="Número do Candidato" required>
              </div>
            </div>
            <div class="row mb-4">
              <label for="partidoCandidato" class="col-sm-4 col-form-label">Partido do Candidato:</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="inputPartidoCandidato" name="partidoCandidato" placeholder="Partido do Candidato" required>
              </div>
            </div>
            <div class="row mb-4">
              <label for="cargoCandidato" class="col-sm-4 col-form-label">Cargo do Candidato:</label>
              <div class="col-sm-8">
                <select class="form-select form-control custom-select" name="cargoCandidato" id="inputCargoCandidato" required>
                  <option value="none" selected>Selecione...</option>
                  <option value="cargoPresidente">Presidente</option>
                  <option value="cargoSenador">Senador</option>
                  <option value="cargoDeputadoFederal">Deputado Federal</option>
                </select>
              </div>
            </div>
  
            <div class="row mb-4">
              <label for="fotoCandidato" class="col-sm-4 col-form-label">Foto do Candidato:</label>
              <div class="col-sm-8">
                <input type="file" class="form-control" id="inputFotoCandidato" name="fotoCandidato" required>
              </div>
            </div>
  
  
            <div class="row mb-4">
              <div class="col-sm-1"></div>
              <button type="submit" class="btn btn-primary col-sm-4">Enviar Candidatura</button>
              <div class="col-sm-2"></div>
  
              <button type="reset" class="btn btn-warning col-sm-4">Limpar Campos</button>
              <div class="col-sm-1"></div>
            </div>
  
  
  
          </form>
        </div>
      </div>
    </div>
  </div>
</main>

<?php include('footer.php') ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Inicializar variáveis
  $nome = $numero = $partido = $cargo = $upload_file = '';
  $votos = 0;

  // Capturar e sanitizar dados do formulário se existirem
  if (isset($_POST['nomeCandidato'])) {
    $nome = htmlspecialchars($_POST['nomeCandidato']);
  }
  if (isset($_POST['numeroCandidato'])) {
    $numero = htmlspecialchars($_POST['numeroCandidato']);
  }
  if (isset($_POST['partidoCandidato'])) {
    $partido = htmlspecialchars($_POST['partidoCandidato']);
  }
  if (isset($_POST['cargoCandidato'])) {
    $cargo = htmlspecialchars($_POST['cargoCandidato']);
  }

  // Verificar se um arquivo foi enviado
  if (isset($_FILES['fotoCandidato']) && $_FILES['fotoCandidato']['error'] == UPLOAD_ERR_OK) {
    $foto = $_FILES['fotoCandidato'];

    // Definir o diretório de upload
    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) {
      mkdir($upload_dir, 0777, true);
    }

    // Definir o caminho completo para salvar o arquivo
    $upload_file = $upload_dir . basename($foto['name']);

    // Mover o arquivo para o diretório de upload
    if (move_uploaded_file($foto['tmp_name'], $upload_file)) {
      echo "Arquivo enviado com sucesso.<br>";
    } else {
      echo "Erro ao enviar o arquivo.<br>";
    }
  } else {
    echo "Nenhum arquivo enviado ou erro no envio.<br>";
  }

  // Definir o nome do arquivo CSV baseado no cargo
  switch ($cargo) {
    case 'cargoPresidente':
      $csv_file = 'candidatos/candidatos_presidente.csv';
      break;
    case 'cargoSenador':
      $csv_file = 'candidatos/candidatos_senador.csv';
      break;
    case 'cargoDeputadoFederal':
      $csv_file = 'candidatos/candidatos_deputado_federal.csv';
      break;
    default:
      echo "Cargo inválido.";
      exit;
  }

  // Preparar os dados para serem salvos no CSV
  $data = [$nome, $numero, $partido, $cargo, $upload_file, $votos];

  // Salvar os dados no arquivo CSV
  $file_handle = fopen($csv_file, 'a');
  if ($file_handle !== false) {
    fputcsv($file_handle, $data);
    fclose($file_handle);
    echo "Dados salvos com sucesso no arquivo CSV.<br>";
  } else {
    echo "Erro ao abrir o arquivo CSV.<br>";
  }
}
?>