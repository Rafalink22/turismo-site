<?php

/*
 * Configuração da Conexão com o Banco de Dados
 * Usando PDO (PHP Data Objects)
 */

$host = 'localhost';
$db   = 'turismo_db';
$user = 'root';      // Usuário padrão do XAMPP
$pass = '';          // Senha padrão do XAMPP (vazia)
$charset = 'utf8mb4';

// DSN (Data Source Name) - A string que identifica o banco
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Opções do PDO para garantir performance e tratamento de erros
$options = [
    // Lança exceções em caso de erro (vital para debug)
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    // Retorna os dados como array associativo (['nome' => 'Bruno'] em vez de índice [0])
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    // Usa prepared statements nativos do banco (mais seguro)
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // Tentativa de conexão
    $pdo = new PDO($dsn, $user, $pass, $options);
    
    // Se quiser testar, descomente a linha abaixo e acesse o arquivo no navegador
    // echo "Conexão realizada com sucesso!"; 
    
} catch (\PDOException $e) {
    // Se der erro, captura a exceção e mostra a mensagem (em produção, logaríamos isso)
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// --- CARREGAR CONFIGURAÇÕES GERAIS ---
// Como isso roda em todas as páginas, otimizamos com try/catch silencioso
try {
    $stmtConfig = $pdo->query("SELECT * FROM site_config WHERE id = 1 LIMIT 1");
    $siteConfig = $stmtConfig->fetch(PDO::FETCH_ASSOC);

    // Valores padrão caso o banco falhe ou esteja vazio
    if (!$siteConfig) {
        $siteConfig = [
            'nome_site' => 'É De Maceió - Turismos',
            'whatsapp' => '82933004541',
            'instagram' => 'https://www.instagram.com/edemaceioturismo?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==',
            'facebook' => 'https://www.instagram.com/edemaceioturismo?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==',
            'email_contato' => 'brunonrafan@gmail.com',
            'endereco' => 'Brasil'
        ];
    }
} catch (Exception $e) {
    // Falha silenciosa para não travar o site se a tabela não existir ainda
}
?>