<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notícias Mundiais</title>
    <link rel="stylesheet" href="estilocss.css">
</head>

<body>
    <div id="area-cabecalhomundo" role="banner">
        <div id="area-logo">
            <h1>Saúde em <span class="branco">Foco</span></h1>
            <h2 style="text-align: center;">Mundo</h2>
        </div>
        <div id="area-menu" role="navigation">
            <a href="index.php">Home</a>
            <a href="imc.html">Calculadora de IMC</a>
            <a href="mundo.html">Notícias Mundiais</a>
            <a target="_blank"
                href="https://www.saude.ce.gov.br/wp-content/uploads/sites/9/2018/06/relacao_postos_de_vacinacao.pdf">Pontos
                de vacina</a>
        </div>
    </div>

    <div id="area-principal" role="main">
        <div id="area-postagens">
            <?php
            // Carregar vídeos existentes
            $videos = file_exists('videos.json') ? json_decode(file_get_contents('videos.json'), true) : [];

            // Processar envio do formulário
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['video'])) {
                $diretorioAlvo = "uploads/";
                $arquivoAlvo = $diretorioAlvo . basename($_FILES["video"]["name"]);
                $uploadOk = 1;
                $tipoArquivoVideo = strtolower(pathinfo($arquivoAlvo, PATHINFO_EXTENSION));

                // Verificar se o arquivo é um vídeo real
                if (isset($_POST["submit"])) {
                    $check = mime_content_type($_FILES["video"]["tmp_name"]);
                    if (strpos($check, "video") !== false) {
                        $uploadOk = 1;
                    } else {
                        echo "O arquivo não é um vídeo.";
                        $uploadOk = 0;
                    }
                }

                // Verificar tamanho do arquivo
                if ($_FILES["video"]["size"] > 50000000) {
                    echo "Desculpe, o seu arquivo é muito grande.";
                    $uploadOk = 0;
                }

                // Permitir apenas certos formatos de arquivo
                if ($tipoArquivoVideo != "mp4" && $tipoArquivoVideo != "avi" && $tipoArquivoVideo != "mov" && $tipoArquivoVideo != "wmv") {
                    echo "Desculpe, apenas arquivos MP4, AVI, MOV e WMV são permitidos.";
                    $uploadOk = 0;
                }

                // Verificar se $uploadOk foi definido como 0 por algum erro
                if ($uploadOk == 0) {
                    echo "Desculpe, seu arquivo não foi enviado.";
                    // Se tudo estiver ok, tentar fazer o upload do arquivo
                } else {
                    if (move_uploaded_file($_FILES["video"]["tmp_name"], $arquivoAlvo)) {
                        $novoVideo = [
                            "titulo" => $_POST['titulo'],
                            "arquivo" => $arquivoAlvo,
                            "data" => date('d M Y - H:i')
                        ];
                        $videos[] = $novoVideo;
                        file_put_contents('videos.json', json_encode($videos));
                        echo "O arquivo " . htmlspecialchars(basename($_FILES["video"]["name"])) . " foi enviado.";
                    } else {
                        echo "Desculpe, houve um erro ao enviar seu arquivo.";
                    }
                }
            }

            // Exibir vídeos
            foreach ($videos as $video) {
                echo '<div class="postagem">';
                echo '<h2>' . htmlspecialchars($video['titulo']) . '</h2>';
                echo '<span class="data-postagem">postado em ' . $video['data'] . '</span>';
                echo '<video width="620px" controls src="' . htmlspecialchars($video['arquivo']) . '">';
                echo 'Seu navegador não suporta o elemento de vídeo.';
                echo '</video>';
                echo '</div>';
            }
            ?>
        </div>

        <div id="area-lateral">
            <div class="conteudo-lateral">
                <h3>Postagens recentes</h3>
                <div class="postagem-lateral">
                    <p>De filas longas a precariedade: 48 denúncias sobre hospitais de Fortaleza são feitas por mês ao
                        MPCE...</p>
                    <a href="">Leia mais</a>
                </div>
                <div class="postagem-lateral" style="border-bottom: none;">
                    <p>Vacinação contra a dengue em Fortaleza começa segunda (13), afirma Sarto...</p>
                    <a href="">Leia mais</a>
                </div>
            </div>
        </div>
    </div>

    <div id="rodape" role="contentinfo">
        Todos os direitos reservados
    </div>

    <div id="area-upload">
        <h2>Adicionar Novo Vídeo</h2>
        <form action="index.php" method="post" enctype="multipart/form-data">
            <label for="titulo">Título:</label><br>
            <input type="text" id="titulo" name="titulo" required><br><br>
            <label for="video">Selecione o vídeo:</label><br>
            <input type="file" id="video" name="video" accept="video/*" required><br><br>
            <input type="submit" value="Enviar Vídeo" name="submit">
        </form>
    </div>
</body>

</html>