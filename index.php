<?php
// Defina a URL base do Rumble
$rumble_base = 'https://rumble.com';

// Pegue o caminho da URL requisitada
$path = isset($_GET['url']) ? $_GET['url'] : '/';

// Construa a URL completa a ser requisitada
$target_url = $rumble_base . $path;

// Inicialize o cURL
$ch = curl_init($target_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] ?? 'Mozilla/5.0');

// Pegue o conteúdo
$response = curl_exec($ch);

// Obtenha o tipo de conteúdo (Content-Type)
$content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
curl_close($ch);

// Envie o cabeçalho de conteúdo para o navegador
if ($content_type) {
    header("Content-Type: $content_type");
}

// Substitui links absolutos do Rumble pelo seu proxy
$response = str_replace(
    ['href="/', 'src="/'],
    ['href="?url=/', 'src="?url=/'],
    $response
);

// Exibe o conteúdo
echo $response;
