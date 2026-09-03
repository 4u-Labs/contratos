<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suporte & FAQ — Gerador de Contratos</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>* { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-950 text-slate-300 min-h-screen p-6 md:p-12">
    <div class="max-w-4xl mx-auto bg-slate-900 border border-white/10 rounded-3xl p-8 md:p-12 shadow-2xl">
        <div class="flex justify-between items-center mb-8 border-b border-white/10 pb-6">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-cyan-600/20 border border-cyan-500/30 text-cyan-400 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white">Central de Suporte & FAQ</h1>
                    <p class="text-xs text-slate-400">Gerador de Contratos com IA • 4U.IA.BR</p>
                </div>
            </div>
            <a href="index.php" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white rounded-xl text-xs font-bold transition-all"><i class="fa-solid fa-arrow-left"></i> Voltar ao App</a>
        </div>

        <div class="space-y-6 text-sm text-slate-300 leading-relaxed">
            <section class="bg-slate-950/60 p-6 rounded-2xl border border-white/5">
                <h2 class="text-base font-bold text-white mb-2">❓ As assinaturas na tela são aceitas na justiça?</h2>
                <p>Sim! A Medida Provisória nº 2.200-2/2001 (Art. 10, § 2º) e a Lei nº 14.063/2020 garantem a validade jurídica de contratos assinados eletronicamente por acordo entre as partes.</p>
            </section>
            <section class="bg-slate-950/60 p-6 rounded-2xl border border-white/5">
                <h2 class="text-base font-bold text-white mb-2">❓ Como funciona o modo grátis sem créditos?</h2>
                <p>O botão <b>Pré-visualizar Modelo (Grátis)</b> gera um contrato estruturado instantaneamente em seu navegador sem consumir créditos do Keep AI.</p>
            </section>
            <section class="bg-slate-950/60 p-6 rounded-2xl border border-white/5">
                <h2 class="text-base font-bold text-white mb-2">✉️ Contato Direto</h2>
                <p>Dúvidas ou sugestões? Envie um e-mail para <b>contato@4u.ia.br</b>.</p>
            </section>
        </div>
    </div>
</body>
</html>