<?php
// FLASHCLIP 2026/2 — Mini projeto didático de PHP.
// O formulário não grava nenhum dado: apenas recebe, valida e exibe na tela.

$nome = "";
$idade = "";
$mensagem = "";
$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 1) Receber os dados enviados pelo formulário.
    $nome = trim($_POST["nome"] ?? "");
    $idade = trim($_POST["idade"] ?? "");

    // 2) Validar antes de exibir.
    if ($nome === "") {
        $erro = "Informe seu nome para continuar.";
    } elseif (strlen($nome) > 320) {
        $erro = "O nome informado é muito longo.";
    } elseif (filter_var($idade, FILTER_VALIDATE_INT, [
        "options" => ["min_range" => 1, "max_range" => 120]
    ]) === false) {
        $erro = "Informe uma idade válida, entre 1 e 120.";
    } else {
        // 3) Processar: criar uma mensagem personalizada.
        $primeiroNome = explode(" ", $nome)[0];
        $mensagem = "Olá, " . $primeiroNome . "! Seu cadastro de demonstração foi concluído.";
    }
}

// Evita que o navegador interprete textos enviados como HTML.
function seguro(string $texto): string {
    return htmlspecialchars($texto, ENT_QUOTES, "UTF-8");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro demonstrativo | FLASHCLIP 2026/2</title>
    <style>
        :root { color-scheme: dark; --bg:#090d10; --card:#141b1c; --red:#f13e45; --green:#19b676; --cream:#f6e6bc; --ink:#f8f6f0; --muted:#b3bab7; }
        * { box-sizing: border-box; }
        body { margin:0; min-height:100vh; color:var(--ink); font-family:Arial, sans-serif; background:radial-gradient(circle at 20% 10%,#203b29 0,transparent 35%),radial-gradient(circle at 84% 88%,#42191c 0,transparent 40%),var(--bg); }
        .topline { height:6px; background:linear-gradient(90deg,var(--green),var(--cream),var(--red)); }
        main { width:min(92vw,580px); margin:40px auto 60px; }
        .brand { text-align:center; margin-bottom:28px; }
        .brand img { width:128px; height:128px; object-fit:contain; }
        .brand h1 { margin:4px 0; font-size:clamp(2.2rem,8vw,3.3rem); letter-spacing:1.5px; }
        .brand h1 span { color:var(--red); }
        .tagline { font-size:.85rem; letter-spacing:3px; text-transform:uppercase; color:var(--cream); }
        .card { padding:28px; border-radius:20px; background:rgba(20,27,28,.96); border:1px solid #3d4e45; box-shadow:0 18px 55px #0008; }
        .eyebrow { color:var(--green); text-transform:uppercase; font-weight:bold; letter-spacing:2px; font-size:.78rem; }
        h2 { margin:12px 0 5px; font-size:1.5rem; }
        .intro { color:var(--muted); line-height:1.5; margin:0 0 25px; }
        label { display:block; margin:16px 0 8px; font-weight:bold; }
        input { width:100%; padding:15px; font:inherit; color:white; border:1px solid #58615d; background:#0b1011; border-radius:12px; }
        input:focus { outline:2px solid var(--green); outline-offset:2px; }
        button { cursor:pointer; margin-top:24px; width:100%; border:0; border-radius:12px; padding:16px; background:linear-gradient(105deg,#db2937,var(--red)); color:white; font-weight:800; font-size:1.05rem; }
        button:hover { filter:brightness(1.12); }
        .result { margin-top:22px; background:#103327; border-left:5px solid var(--green); padding:18px; border-radius:10px; line-height:1.6; }
        .error { margin-top:22px; background:#3f1b1e; border-left:5px solid var(--red); padding:18px; border-radius:10px; }
        footer { text-align:center; color:#a9b0ac; padding:28px 0; font-size:.83rem; line-height:1.6; }
    </style>
</head>
<body>
<div class="topline"></div>
<main>
    <header class="brand">
        <img src="assets/emblema-flashclip.png" alt="Emblema do FLASHCLIP">
        <h1>FLASH<span>CLIP</span></h1>
        <div class="tagline">2026/2 · PHP do zero</div>
    </header>
    <section class="card">
        <div class="eyebrow">Minicurso de PHP</div>
        <h2>Cadastro demonstrativo</h2>
        <p class="intro">Preencha os campos e veja como o PHP recebe informações e cria uma resposta.</p>
        <form method="POST" action="">
            <label for="nome">Nome</label>
            <input id="nome" name="nome" type="text" maxlength="80" required placeholder="Digite seu nome" value="<?= seguro($nome) ?>">
            <label for="idade">Idade</label>
            <input id="idade" name="idade" type="number" min="1" max="120" required placeholder="Digite sua idade" value="<?= seguro($idade) ?>">
            <button type="submit">REALIZAR CADASTRO →</button>
        </form>
        <?php if ($erro !== ""): ?>
            <div class="error" role="alert"><?= seguro($erro) ?></div>
        <?php elseif ($mensagem !== ""): ?>
            <div class="result" role="status">
                <strong>✓ Cadastro realizado!</strong><br>
                <?= seguro($mensagem) ?><br>
                Idade informada: <strong><?= seguro($idade) ?> anos</strong>.<br>
                Seja bem-vindo(a) ao FLASHCLIP 2026/2!
            </div>
        <?php endif; ?>
    </section>
    <footer>
        Projeto educativo do minicurso · ULBRA Palmas<br>
        Seus dados não são armazenados neste exemplo.
    </footer>
</main>
</body>
</html>
