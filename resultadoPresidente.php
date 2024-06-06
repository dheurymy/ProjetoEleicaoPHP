<?php

// Caminho para o arquivo CSV
$arquivoCSVPresidente = 'candidatos/candidatos_presidente.csv';

$textoInformativo = "Votacao ainda não encerrada!";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $textoInformativo = "Votacao encerrada!";
    $mostrador = "";

    // Função para ler um arquivo CSV e retornar os dados como um array
    function lerCSV($arquivoCSVPresidente)
    {
        $dados = [];
        if (($handle = fopen($arquivoCSVPresidente, "r")) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $dados[] = $row;
            }
            fclose($handle);
        }
        return $dados;
    }

    // Função para ordenar as linhas de um array CSV com base na última coluna
    function ordenarPorUltimaColuna($dados)
    {
        // Função de comparação personalizada para usar com usort
        usort($dados, function ($a, $b) {
            return $b[count($b) - 1] <=> $a[count($a) - 1];
        });
        return $dados;
    }

    // Função para escrever os dados ordenados de volta para o arquivo CSV original
    function escreverCSV($arquivoCSVPresidente, $dados)
    {
        if (($handle = fopen($arquivoCSVPresidente, "w")) !== FALSE) {
            foreach ($dados as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        }
    }

    // Ler os dados do arquivo CSV
    $dados = lerCSV($arquivoCSVPresidente);

    // Ordenar as linhas com base na última coluna
    $dadosOrdenados = ordenarPorUltimaColuna($dados);

    // Escrever os dados ordenados de volta para o mesmo arquivo CSV
    escreverCSV($arquivoCSVPresidente, $dadosOrdenados);

    // Criar variáveis para cada item do CSV
    foreach ($dadosOrdenados as $i => $linha) {
        foreach ($linha as $j => $item) {
            ${"L{$i}C{$j}"} = $item;
        }
    }

    $totalVotos = $L0C5 + $L1C5 + $L2C5;

    if ($totalVotos > 0) {
        $percentualPrimeiroLugar = ($L0C5 / $totalVotos) * 100;
        $percentualSegundoLugar = ($L1C5 / $totalVotos) * 100;
        $percentualTerceiroLugar = ($L2C5 / $totalVotos) * 100;
    } else {
        $percentualPrimeiroLugar = 0;
        $percentualSegundoLugar = 0;
        $percentualTerceiroLugar = 0;
    }
} else {
    $mostrador = 'style="display:none;"';
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
                        <li class="breadcrumb-item" aria-current="page">Resultados da Eleição</li>
                        <li class="breadcrumb-item active" aria-current="page">Resultado para Presidente</li>
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
                <br><br>
                <h2>Resultado para Presidente</h2>
                <br>

                <form action="resultadoPresidente.php" method="post" enctype="multipart/form-data" class="border border-dark rounded-lg p-3">
                    <div class="row mb-4">
                        <div class="col-sm-4"></div>
                        <p class="col-sm-4">
                            <?php
                            echo "$textoInformativo";
                            ?>
                        </p>
                        <div class="col-sm-4"></div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-4"></div>
                        <button type="submit" class="btn btn-primary col-sm-4">Resultado para Presidente</button>
                        <div class="col-sm-4"></div>
                    </div>

                    <ul class="list list-group" <?php echo $mostrador; ?>>
                        <li class="list list-group-item">
                            <div class="row mb-4">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-6">
                                    <h3>Primeiro Lugar:</h3>
                                </div>
                                <div class="col-sm-3"></div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-2">
                                    <?php echo '<img src="' . $L0C4 . '" class="img-fluid img card-img img-thumbnail ">' ?>
                                </div>
                                <p class="col-sm-3">
                                    Candidato: <?php echo "<strong>$L0C0</strong>"; ?> <br>
                                    Número: <?php echo "$L0C1"; ?> <br>
                                    Partido: <?php echo "$L0C2"; ?> <br>
                                    Votos: <?php echo "$L0C5"; ?> votos válidos.<br>
                                    Percentual de Votos: <?php echo "$percentualPrimeiroLugar"; ?>%<br>
                                    <strong>CANDIDATO ELEITO</strong>
                                </p>
                                <div class="col-sm-2">
                                    <img src="IMAGENS/candidatoEleito.png" class="img-fluid img card-img img-thumbnail " alt="">
                                </div>
                            </div>
                        </li>
                        <li class="list list-group-item">
                            <div class="row mb-4">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-6">
                                    <h3>Segundo Lugar:</h3>
                                </div>
                                <div class="col-sm-3"></div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-2">
                                    <?php echo '<img src="' . $L1C4 . '" class="img-fluid img card-img img-thumbnail ">' ?>
                                </div>
                                <p class="col-sm-3">
                                    Candidato: <?php echo "<strong>$L1C0</strong>"; ?> <br>
                                    Número: <?php echo "$L1C1"; ?> <br>
                                    Partido: <?php echo "$L1C2"; ?> <br>
                                    Votos: <?php echo "$L1C5"; ?> votos válidos.<br>
                                    Percentual de Votos: <?php echo "$percentualSegundoLugar"; ?>%<br>
                                    <strong>CANDIDATO NÃO ELEITO</strong>
                                </p>
                                <div class="col-sm-2">
                                    <img src="IMAGENS/candidatoPerdedor.png" class="img-fluid img card-img img-thumbnail " alt="">
                                </div>
                            </div>
                        </li>
                        <li class="list list-group-item">
                            <div class="row mb-4">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-6">
                                    <h3>Terceiro Lugar:</h3>
                                </div>
                                <div class="col-sm-3"></div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-2">
                                    <?php echo '<img src="' . $L2C4 . '" class="img-fluid img card-img img-thumbnail ">' ?>
                                </div>
                                <p class="col-sm-3">
                                    Candidato: <?php echo "<strong>$L2C0</strong>"; ?> <br>
                                    Número: <?php echo "$L2C1"; ?> <br>
                                    Partido: <?php echo "$L2C2"; ?> <br>
                                    Votos: <?php echo "$L2C5"; ?> votos válidos.<br>
                                    Percentual de Votos: <?php echo "$percentualTerceiroLugar"; ?>%<br>
                                    <strong>CANDIDATO NÃO ELEITO</strong>
                                </p>
                                <div class="col-sm-2">
                                    <img src="IMAGENS/candidatoPerdedor.png" class="img-fluid img card-img img-thumbnail " alt="">
                                </div>
                            </div>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include('footer.php') ?>
