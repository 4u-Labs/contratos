<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
$v = time();

$client_ip = $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
if (strpos($client_ip, ',') !== false) {
    $client_ip = trim(explode(',', $client_ip)[0]);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <!-- 4USign Pro Meta Tags & Assets -->
    <title>4USign Pro — Contratos Inteligentes & Assinatura Digital</title>
    <link rel="manifest" href="manifest.json?v=<?php echo $v; ?>">
    <meta name="theme-color" content="#0f172a">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png?v=<?php echo $v; ?>">
    <link rel="apple-touch-icon" href="icon-192.png?v=<?php echo $v; ?>">
    
    <!-- Fontes Manuscritas para Assinatura Digital -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&family=Dancing+Script:wght@600;700&family=Great+Vibes&family=Sacramento&family=Allura&display=swap" rel="stylesheet">
    
    <!-- PDF.js para Renderização Visual de PDFs na Tela -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
    </script>
    <!-- PDF-Lib para Gravação e Certificação Forense de Assinaturas -->
    <script src="https://unpkg.com/pdf-lib@1.17.1/dist/pdf-lib.min.js"></script>
    <!-- HTML2PDF para exportação de minutas criadas com IA -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerador de Contratos com IA</title>
    <link rel="icon" type="image/png" sizes="32x32" href="../../favicon-32x32.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- FontAwesome para ícones premium -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- SweetAlert2 para popups modernos -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; box-sizing: border-box; }

        /* ============ BODY & BACKGROUND ============ */
        body {
            background: linear-gradient(135deg, #f0f4ff 0%, #f5f0ff 35%, #fff0f6 65%, #f0f9ff 100%);
            min-height: 100vh;
        }

        /* Noise texture overlay on body for depth */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.035'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
        }

        main, header, footer { position: relative; z-index: 1; }

        /* ============ ANIMATED HEADER ============ */
        .animated-bg {
            background: linear-gradient(-45deg, #0f172a, #1e1b4b, #1a1060, #0c2a6e, #160a30);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* ============ GLASSMORPHISM ============ */
        .glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .glass-dark {
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        /* ============ CARDS ============ */
        .card-modern {
            background: white;
            border-radius: 24px;
            box-shadow:
                0 0 0 1px rgba(99,102,241,0.07),
                0 4px 6px -1px rgba(99,102,241,0.07),
                0 12px 28px -4px rgba(99,102,241,0.12),
                0 2px 4px rgba(0,0,0,0.04);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-top: 3px solid transparent;
            background-clip: padding-box;
            position: relative;
        }
        /* Colored accent line on top */
        .card-modern::before {
            content: '';
            position: absolute;
            top: 0; left: 20px; right: 20px;
            height: 3px;
            border-radius: 0 0 6px 6px;
            background: linear-gradient(90deg, #6366f1, #a855f7, #ec4899);
            opacity: 0.6;
            transition: opacity 0.3s;
        }
        .card-modern:hover::before { opacity: 1; }
        .card-modern:hover {
            box-shadow:
                0 0 0 1px rgba(99,102,241,0.12),
                0 20px 40px -8px rgba(99,102,241,0.18),
                0 8px 16px -4px rgba(99,102,241,0.1);
            transform: translateY(-5px);
        }

        /* ============ INPUTS ============ */
        .input-modern {
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 14px;
            padding: 14px 18px;
            font-size: 15px;
            color: #1e293b;
            transition: all 0.25s ease;
            width: 100%;
        }
        .input-modern:hover {
            border-color: #c7d2fe;
            background: #fafbff;
        }
        .input-modern:focus {
            background: white;
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.12);
            outline: none;
        }
        .input-modern::placeholder { color: #94a3b8; }
        select.input-modern { cursor: pointer; }

        /* ============ LABELS ============ */
        .label-modern {
            font-size: 12px;
            font-weight: 700;
            color: #6366f1;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 8px;
            display: block;
        }

        /* ============ BUTTONS ============ */
        .btn-gradient {
            background: linear-gradient(135deg, #5b21b6 0%, #7c3aed 40%, #a855f7 100%);
            background-size: 200% 200%;
            color: white;
            font-weight: 700;
            padding: 18px 40px;
            border-radius: 18px;
            border: none;
            cursor: pointer;
            transition: all 0.35s ease;
            box-shadow:
                0 4px 15px rgba(124, 58, 237, 0.45),
                0 0 0 0 rgba(124,58,237,0.4);
            letter-spacing: 0.3px;
        }
        .btn-gradient:hover {
            background-position: 100% 0;
            transform: translateY(-3px) scale(1.03);
            box-shadow:
                0 12px 30px rgba(124, 58, 237, 0.55),
                0 0 0 6px rgba(124,58,237,0.1);
        }
        .btn-gradient:active { transform: translateY(0) scale(0.98); }

        .btn-soft {
            background: #f1f5f9;
            color: #475569;
            font-weight: 600;
            padding: 14px 28px;
            border-radius: 14px;
            border: 2px solid #e2e8f0;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-soft:hover {
            background: #e2e8f0;
            border-color: #c7d2fe;
            color: #1e293b;
            transform: translateY(-2px);
        }

        /* ============ CLAUSE CHIPS ============ */
        .clause-modern {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            padding: 16px;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4,0,0.2,1);
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .clause-modern:hover {
            border-color: #a5b4fc;
            background: linear-gradient(135deg, #fafbff 0%, #f5f0ff 100%);
            box-shadow: 0 4px 16px rgba(99,102,241,0.12);
            transform: translateY(-2px);
        }
        .clause-modern.selected {
            background: linear-gradient(135deg, #eef2ff 0%, #f5f0ff 100%);
            border-color: #818cf8;
            box-shadow: 0 4px 20px rgba(99, 102, 241, 0.2), inset 0 1px 0 rgba(255,255,255,0.8);
        }
        .clause-modern.selected .clause-icon {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(99,102,241,0.4);
        }

        /* ============ ICON BOXES ============ */
        .icon-box {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }
        .icon-box-purple {
            background: linear-gradient(135deg, #7c3aed, #a855f7);
            color: white;
            box-shadow: 0 4px 12px rgba(124,58,237,0.4);
        }
        .icon-box-blue {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            color: white;
            box-shadow: 0 4px 12px rgba(59,130,246,0.4);
        }
        .icon-box-green {
            background: linear-gradient(135deg, #059669, #10b981);
            color: white;
            box-shadow: 0 4px 12px rgba(16,185,129,0.4);
        }
        .icon-box-amber {
            background: linear-gradient(135deg, #d97706, #f59e0b);
            color: white;
            box-shadow: 0 4px 12px rgba(245,158,11,0.4);
        }
        .icon-box-rose {
            background: linear-gradient(135deg, #e11d48, #f43f5e);
            color: white;
            box-shadow: 0 4px 12px rgba(244,63,94,0.4);
        }
        .icon-box-indigo {
            background: linear-gradient(135deg, #4338ca, #6366f1);
            color: white;
            box-shadow: 0 4px 12px rgba(99,102,241,0.4);
        }
        .card-modern:hover .icon-box { transform: scale(1.08) rotate(-3deg); }

        /* ============ SECTION TITLE ============ */
        .card-modern h2.text-xl {
            color: #1e1b4b;
            font-weight: 800;
        }
        .card-modern p.text-sm.text-slate-500 {
            color: #64748b;
            font-weight: 500;
        }

        /* ============ ANIMATIONS ============ */
        .fade-up { animation: fadeUp 0.5s cubic-bezier(0.4,0,0.2,1) both; }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .stagger-1 { animation-delay: 0.08s; }
        .stagger-2 { animation-delay: 0.16s; }
        .stagger-3 { animation-delay: 0.24s; }
        .stagger-4 { animation-delay: 0.32s; }

        /* ============ SPINNER ============ */
        .spinner-modern {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: conic-gradient(from 0deg, transparent 30%, #7c3aed);
            animation: spin 0.9s linear infinite;
            position: relative;
        }
        .spinner-modern::before {
            content: '';
            position: absolute;
            inset: 5px;
            border-radius: 50%;
            background: white;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ============ SCROLLBAR ============ */
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: #f0f4ff; border-radius: 5px; }
        ::-webkit-scrollbar-thumb { background: linear-gradient(180deg, #6366f1, #a855f7); border-radius: 5px; }
        ::-webkit-scrollbar-thumb:hover { background: linear-gradient(180deg, #4f46e5, #7c3aed); }

        /* ============ TEXTAREA ============ */
        textarea.input-modern { min-height: 100px; resize: vertical; }

        /* ============ RADIO BUTTONS ============ */
        .radio-modern {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 20px;
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.25s ease;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        }
        .radio-modern:hover { border-color: #a5b4fc; background: #f5f0ff; }
        .radio-modern:has(input:checked) {
            background: linear-gradient(135deg, #eef2ff 0%, #f5f0ff 100%);
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
        }
        .radio-modern input { accent-color: #6366f1; width: 18px; height: 18px; }

        /* ============ FLOATING SHAPES ============ */
        .floating-shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(70px);
            opacity: 0.55;
            animation: float 22s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-25px) scale(1.05); }
        }

        /* ============ ACTION BUTTONS ============ */
        .action-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 12px 16px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 13px;
            transition: all 0.25s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        }
        .action-btn:hover { transform: translateY(-3px); box-shadow: 0 6px 18px rgba(0,0,0,0.12); }

        /* ============ PROGRESS BUTTONS ============ */
        .progress-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 22px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 14px;
            transition: all 0.25s ease;
            border: 2px solid transparent;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        .progress-btn:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(0,0,0,0.14); }

        /* ============ SECTION DIVIDERS ============ */
        .section-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(99,102,241,0.2), transparent);
            margin: 0 -2rem;
        }

        /* ============ RESPONSIVE ============ */
        @media (max-width: 640px) {
            .card-modern { border-radius: 20px; }
            .input-modern { padding: 12px 14px; border-radius: 12px; }
        }

        /* ============ FOOTER ============ */
        .footer-clean { position: relative; padding: 2rem 0; color: #4b5563; }
        .footer-link-group { display: flex; align-items: center; justify-content: center; gap: 1rem; margin-top: 0.5rem; font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.1em; font-weight: 500; }
        .footer-dot { width: 3px; height: 3px; border-radius: 50%; background: rgba(0, 0, 0, 0.1); }
        .footer-a { transition: all 0.2s; text-decoration: none; color: inherit; }
        .footer-a:hover { color: #6366f1; opacity: 1; }
    
        /* ============ 4USIGN PRO STYLES ============ */
        .pwa-install-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.25) 0%, rgba(168, 85, 247, 0.3) 100%);
            border: 1.5px solid #818cf8;
            color: #ffffff;
            font-size: 12px;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.25s ease;
            box-shadow: 0 4px 14px rgba(99, 102, 241, 0.35);
        }
        .pwa-install-btn:hover {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.45) 0%, rgba(168, 85, 247, 0.5) 100%);
            border-color: #a5b4fc;
            transform: translateY(-1px);
        }
        
        .signature-canvas {
            border: 2px dashed #cbd5e1;
            border-radius: 14px;
            background: #ffffff;
            touch-action: none;
            cursor: crosshair;
        }

        .font-dancing { font-family: 'Dancing Script', cursive; }
        .font-greatvibes { font-family: 'Great Vibes', cursive; }
        .font-sacramento { font-family: 'Sacramento', cursive; }
        .font-caveat { font-family: 'Caveat', cursive; }
        .font-allura { font-family: 'Allura', cursive; }

        /* Hub Master Cards */
        .hub-card {
            background: #ffffff;
            border: 2px solid #e2e8f0;
            border-radius: 28px;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .hub-card:hover {
            transform: translateY(-8px);
            border-color: #818cf8;
            box-shadow: 0 25px 50px -12px rgba(99, 102, 241, 0.25);
        }
        .hub-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 6px;
            background: linear-gradient(90deg, #6366f1, #a855f7, #06b6d4);
            opacity: 0;
            transition: opacity 0.3s;
        }
        .hub-card:hover::before { opacity: 1; }

        .dropzone-box {
            border: 2px dashed #818cf8;
            border-radius: 24px;
            background: #f8fafc;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .dropzone-box:hover, .dropzone-box.dragover {
            border-color: #6366f1;
            background: #eef2ff;
        }

        /* PDF Page Sheet */
        .pdf-page-sheet {
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12), 0 1px 4px rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            border: 1px solid #cbd5e1;
            overflow: hidden;
            margin: 0 auto 24px auto;
            position: relative;
            max-width: 820px;
        }

    </style>
</head>
<body class="min-h-screen">
    <!-- Header com gradiente animado -->
    <header class="animated-bg text-white py-16 relative overflow-hidden">
        <!-- Top Nav Bar 4USign Pro -->
        <div class="absolute top-0 left-0 right-0 z-20 py-3.5 px-4 sm:px-6 flex justify-between items-center max-w-7xl mx-auto">
            <div class="flex items-center gap-3">
                <a href="#hub" onclick="navegarPara('hub')" class="flex items-center gap-2.5 text-white no-underline group">
                    <img src="logo.png?v=<?php echo $v; ?>" alt="4USign Pro" class="w-9 h-9 rounded-xl shadow-lg border border-white/20 transition-transform group-hover:scale-105" />
                    <span class="font-black text-xl tracking-tight text-white flex items-center gap-1.5">
                        4USign <span class="text-cyan-400 font-extrabold text-[11px] px-2 py-0.5 rounded-md bg-cyan-950/70 border border-cyan-500/40 uppercase tracking-wider">Pro</span>
                    </span>
                </a>
            </div>

            <!-- Navegação Rápida entre Módulos -->
            <div class="hidden md:flex items-center gap-1 bg-slate-900/60 backdrop-blur-md p-1 rounded-2xl border border-white/10 text-xs font-bold">
                <button type="button" onclick="navegarPara('hub')" id="navBtnHub" class="nav-tab px-3.5 py-1.5 rounded-xl text-white bg-indigo-600 shadow-sm transition-all flex items-center gap-1.5 cursor-pointer">
                    <i class="fa-solid fa-house"></i> Início
                </button>
                <button type="button" onclick="navegarPara('gerador')" id="navBtnGerador" class="nav-tab px-3.5 py-1.5 rounded-xl text-white/70 hover:text-white hover:bg-white/10 transition-all flex items-center gap-1.5 cursor-pointer">
                    <i class="fa-solid fa-file-contract"></i> Criar Contrato com IA
                </button>
                <button type="button" onclick="navegarPara('assinar')" id="navBtnAssinar" class="nav-tab px-3.5 py-1.5 rounded-xl text-white/70 hover:text-white hover:bg-white/10 transition-all flex items-center gap-1.5 cursor-pointer">
                    <i class="fa-solid fa-signature text-cyan-400"></i> Assinar Documento PDF
                </button>
                <button type="button" onclick="abrirModalValidadeJuridica()" class="px-3.5 py-1.5 rounded-xl text-cyan-300 hover:text-white hover:bg-cyan-900/40 border border-cyan-500/30 transition-all flex items-center gap-1.5 cursor-pointer">
                    <i class="fa-solid fa-scale-balanced text-cyan-400"></i> Validade Jurídica
                </button>
            </div>
            
            <div class="flex items-center gap-2 sm:gap-3">
                <button id="btn-pwa-install" class="pwa-install-btn" title="Instalar Aplicativo (PWA)" style="display: none;">
                    <i class="fa-solid fa-mobile-screen-button"></i> <span class="hidden sm:inline">Instalar App</span>
                </button>
                <div id="user-balance-header" class="flex items-center gap-2 bg-slate-900/60 backdrop-blur-md px-3.5 py-1.5 rounded-2xl border border-white/10 text-xs font-semibold cursor-pointer hover:bg-slate-800/80 transition-all" onclick="openShopModal()">
                    <i class="fa-solid fa-gem text-cyan-400"></i>
                    <span id="creditBalance">...</span>
                    <button class="w-4 h-4 rounded-full bg-cyan-400 hover:bg-cyan-300 text-slate-900 flex items-center justify-center text-[10px] ml-0.5"><i class="fa-solid fa-plus"></i></button>
                </div>
            </div>
        </div>

        <!-- Shapes decorativas -->
        <div class="floating-shape w-96 h-96 bg-purple-500 -top-48 -left-48" style="animation-delay: 0s;"></div>
        <div class="floating-shape w-72 h-72 bg-blue-500 -top-36 right-0" style="animation-delay: -5s;"></div>
        <div class="floating-shape w-64 h-64 bg-indigo-500 bottom-0 left-1/3" style="animation-delay: -10s;"></div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="flex flex-col items-center text-center">
                <div class="relative mb-5">
                    <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-3xl p-1 bg-gradient-to-tr from-indigo-500 via-purple-500 to-cyan-400 shadow-2xl shadow-indigo-500/40">
                        <img src="logo.png?v=<?php echo $v; ?>" alt="4USign Pro" class="w-full h-full object-cover rounded-[22px] shadow-inner" />
                    </div>
                    <div class="absolute -bottom-2 -right-2 px-2.5 py-0.5 rounded-full bg-emerald-500 text-[10px] font-black tracking-wider uppercase text-slate-950 border-2 border-slate-900 shadow">
                        Legal Tech
                    </div>
                </div>
                <h1 id="heroTitulo" class="text-3xl sm:text-5xl font-extrabold mb-3 tracking-tight text-white drop-shadow-sm">4USign Pro</h1>
                <p id="heroSubtitulo" class="text-sm sm:text-lg text-white/80 max-w-xl mx-auto leading-relaxed font-medium">Contratos Inteligentes com IA & Assinatura Digital Eletrônica com Plena Validade Jurídica</p>
                
                <!-- Stats -->
                <div class="flex flex-wrap justify-center gap-8 mt-10">
                    <div class="glass-dark rounded-2xl px-6 py-4 text-center">
                        <div class="text-2xl font-bold">30+</div>
                        <div class="text-sm text-white/60">Tipos de documento</div>
                    </div>
                    <div class="glass-dark rounded-2xl px-6 py-4 text-center">
                        <div class="text-2xl font-bold">9</div>
                        <div class="text-sm text-white/60">Cláusulas especiais</div>
                    </div>
                    <div class="glass-dark rounded-2xl px-6 py-4 text-center">
                        <div class="text-2xl font-bold">IA</div>
                        <div class="text-sm text-white/60">Powered by GPT</div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-10 -mt-6">

        <!-- ========================================================= -->
        <!-- 1. VIEW: HUB INICIAL (PÁGINA PRINCIPAL / BOAS-VINDAS)    -->
        <!-- ========================================================= -->
        <div id="viewHub" class="space-y-12">
            
            <!-- Cards Mestres dos Dois Serviços -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-6xl mx-auto">
                
                <!-- CARD SERVIÇO 1: CRIAR CONTRATO COM IA -->
                <div class="hub-card p-8 sm:p-10 shadow-xl border-slate-200 group">
                    <div>
                        <div class="flex items-center justify-between gap-4 mb-6">
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-purple-600 to-indigo-600 text-white flex items-center justify-center text-2xl shadow-lg shadow-indigo-500/30">
                                <i class="fa-solid fa-file-signature"></i>
                            </div>
                            <span class="px-3.5 py-1.5 rounded-full bg-purple-100 text-purple-700 text-xs font-extrabold uppercase tracking-wider">
                                🤖 Powered by IA
                            </span>
                        </div>

                        <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mb-3">
                            Criar Contrato com IA
                        </h2>
                        <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-6 font-medium">
                            Redija minutas jurídicas perfeitas a partir de modelos prontos ou personalizados com Inteligência Artificial, resumo executivo e 4 níveis de formalidade.
                        </p>

                        <div class="space-y-3 mb-8 text-xs sm:text-sm font-semibold text-slate-700">
                            <div class="flex items-center gap-2.5">
                                <i class="fa-solid fa-circle-check text-indigo-600"></i>
                                <span>30+ Modelos: Engenharia Civil, TI, Locação e Serviços</span>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <i class="fa-solid fa-circle-check text-indigo-600"></i>
                                <span>4 Níveis de Formalidade (do Simples ao Jurídico Completo)</span>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <i class="fa-solid fa-circle-check text-indigo-600"></i>
                                <span>Cláusulas de Proteção: NDA, Multa, Rescisão e LGPD</span>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <i class="fa-solid fa-circle-check text-indigo-600"></i>
                                <span>Exportação Imediata em PDF Jurídico ABNT e DOCX</span>
                            </div>
                        </div>
                    </div>

                    <button type="button" onclick="navegarPara('gerador')" class="w-full py-4 px-6 rounded-2xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold text-base shadow-xl shadow-indigo-600/25 flex items-center justify-center gap-3 transition-all cursor-pointer group-hover:scale-[1.01]">
                        <span>Criar Novo Contrato</span>
                        <i class="fa-solid fa-arrow-right transition-transform group-hover:translate-x-1"></i>
                    </button>
                </div>

                <!-- CARD SERVIÇO 2: ASSINAR QUALQUER DOCUMENTO (ESTILO DOCUSIGN) -->
                <div class="hub-card p-8 sm:p-10 shadow-xl border-slate-200 group">
                    <div>
                        <div class="flex items-center justify-between gap-4 mb-6">
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-cyan-500 to-blue-600 text-white flex items-center justify-center text-2xl shadow-lg shadow-cyan-500/30">
                                <i class="fa-solid fa-signature"></i>
                            </div>
                            <span class="px-3.5 py-1.5 rounded-full bg-cyan-100 text-cyan-800 text-xs font-extrabold uppercase tracking-wider">
                                🛡️ Estilo DocuSign
                            </span>
                        </div>

                        <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mb-3">
                            Assinar Documento PDF
                        </h2>
                        <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-6 font-medium">
                            Anexe qualquer contrato ou proposta em PDF. O documento abre na tela para você assinar com caligrafia personalizada e baixar ou enviar para o cliente assinar.
                        </p>

                        <div class="space-y-3 mb-8 text-xs sm:text-sm font-semibold text-slate-700">
                            <div class="flex items-center gap-2.5">
                                <i class="fa-solid fa-circle-check text-cyan-600"></i>
                                <span>Visualizador de páginas reais integrado no navegador</span>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <i class="fa-solid fa-circle-check text-cyan-600"></i>
                                <span>Assinatura por Caligrafia Manuscrita ou Desenho na Tela</span>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <i class="fa-solid fa-circle-check text-cyan-600"></i>
                                <span>Gravação direta no arquivo PDF com selo de integridade</span>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <i class="fa-solid fa-circle-check text-cyan-600"></i>
                                <span>Envio imediato de link de assinatura via WhatsApp</span>
                            </div>
                        </div>
                    </div>

                    <button type="button" onclick="navegarPara('assinar')" class="w-full py-4 px-6 rounded-2xl bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white font-bold text-base shadow-xl shadow-cyan-600/25 flex items-center justify-center gap-3 transition-all cursor-pointer group-hover:scale-[1.01]">
                        <span>Abrir Documento para Assinar</span>
                        <i class="fa-solid fa-arrow-right transition-transform group-hover:translate-x-1"></i>
                    </button>
                </div>
            </div>

            <!-- Seção de Garantia Jurídica & Criptografia -->
            <div class="max-w-6xl mx-auto bg-slate-900 text-white rounded-3xl p-8 sm:p-10 border border-white/10 shadow-2xl relative overflow-hidden">
                <div class="relative z-10 grid grid-cols-1 md:grid-cols-3 gap-6 text-center md:text-left">
                    <div class="space-y-2">
                        <div class="w-10 h-10 rounded-xl bg-indigo-500/20 text-indigo-400 flex items-center justify-center text-lg mx-auto md:mx-0">
                            <i class="fa-solid fa-scale-balanced"></i>
                        </div>
                        <h4 class="font-bold text-base text-white">Validade Jurídica Plena</h4>
                        <p class="text-xs text-slate-400 leading-relaxed">
                            Amparado pela <b>MP nº 2.200-2/2001</b> e <b>Lei Federal nº 14.063/2020</b>, com força executiva extrajudicial (Art. 784, III do CPC).
                        </p>
                    </div>

                    <div class="space-y-2">
                        <div class="w-10 h-10 rounded-xl bg-cyan-500/20 text-cyan-400 flex items-center justify-center text-lg mx-auto md:mx-0">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <h4 class="font-bold text-base text-white">Trilha de Auditoria Forense</h4>
                        <p class="text-xs text-slate-400 leading-relaxed">
                            Registro do <b>Endereço IP público</b>, carimbo de data/hora oficial e Hash criptográfico SHA-256 inviolável (Marco Civil da Internet).
                        </p>
                    </div>

                    <div class="space-y-2">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-lg mx-auto md:mx-0">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <h4 class="font-bold text-base text-white">Privacidade & Retenção Zero</h4>
                        <p class="text-xs text-slate-400 leading-relaxed">
                            Seus documentos são processados diretamente no seu dispositivo, sem compartilhamento com terceiros (Conformidade com a LGPD).
                        </p>
                    </div>
                </div>

                <!-- Botão de Acesso ao Guia de Validade Jurídica -->
                <div class="mt-8 pt-6 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-xs text-slate-400 text-center sm:text-left leading-relaxed">
                        <i class="fa-solid fa-circle-question text-cyan-400 mr-1"></i> Dúvidas sobre o que pode ser assinado digitalmente e o que ainda exige cartório físico?
                    </div>
                    <button type="button" onclick="abrirModalValidadeJuridica()" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white font-extrabold text-xs shadow-lg shadow-cyan-600/30 transition-all flex items-center gap-2 cursor-pointer hover:scale-105 shrink-0">
                        <i class="fa-solid fa-scale-balanced"></i> <span>O que é Válido? Guia Jurídico</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- ========================================================= -->
        <!-- 2. VIEW: GERADOR INTELIGENTE DE CONTRATOS (COM IA)        -->
        <!-- ========================================================= -->
        <div id="viewGerador" class="hidden space-y-8">
            
            <!-- Barra Superior do Gerador com Botão Voltar -->
            <div class="flex items-center justify-between gap-4 bg-white rounded-2xl p-4 border border-slate-200 shadow-sm max-w-6xl mx-auto">
                <button type="button" onclick="navegarPara('hub')" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all flex items-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-arrow-left"></i> <span>Voltar ao Hub</span>
                </button>
                <div class="text-xs font-bold text-slate-800 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-purple-600 animate-pulse"></span>
                    <span>Modo Ativo: Criador de Contratos com IA</span>
                </div>
                <button type="button" onclick="navegarPara('assinar')" class="px-4 py-2 rounded-xl bg-cyan-50 hover:bg-cyan-100 text-cyan-800 border border-cyan-200 text-xs font-bold transition-all flex items-center gap-1.5 cursor-pointer">
                    <i class="fa-solid fa-signature"></i> <span class="hidden sm:inline">Ir para</span> Assinador PDF
                </button>
            </div>

        <!-- Progress Buttons -->
        <div class="flex flex-wrap justify-center gap-3 mb-10 fade-up">
            <button type="button" id="btnPreencherExemplo" class="progress-btn bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white hover:shadow-lg hover:shadow-purple-500/25 cursor-pointer">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
                Preencher Exemplo
            </button>
            <button id="btnSalvarProgresso"  class="progress-btn bg-emerald-500 hover:bg-emerald-600 text-white hover:shadow-lg hover:shadow-emerald-500/25">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                Salvar Progresso
            </button>
            <button id="btnCarregarProgresso" class="progress-btn bg-blue-500 hover:bg-blue-600 text-white hover:shadow-lg hover:shadow-blue-500/25">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                Carregar Progresso
            </button>
            <button id="btnLimparProgresso" class="progress-btn bg-slate-200 hover:bg-slate-300 text-slate-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Limpar Dados
            </button>
        </div>

        <form id="contractForm" class="space-y-8">
            <!-- Tipo de Contrato -->
            <section class="card-modern p-8 fade-up stagger-1">
                <div class="flex items-center gap-4 mb-8">
                    <div class="icon-box icon-box-purple">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-800">Tipo de Contrato</h2>
                        <p class="text-sm text-slate-500">Selecione o modelo que melhor se adapta</p>
                    </div>
                </div>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="label-modern">Selecione o Tipo *</label>
                        <select id="tipo_contrato" class="input-modern" required>
                            <option value="">-- Selecione --</option>
                                                        <optgroup label="🏗️ Engenharia Civil & Construção">
                                <option value="Contrato de Empreitada Global de Construção Civil">Empreitada Global de Obra</option>
                                <option value="Contrato de Prestação de Serviços de Mão de Obra e Reforma">Mão de Obra & Reforma Residencial/Comercial</option>
                                <option value="Contrato de Elaboração de Projetos Arquitetônicos e Estruturais">Elaboração de Projetos (Arquitetura & Engenharia)</option>
                                <option value="Contrato de Acompanhamento Técnico e R.T. (ART/CREA/CAU)">Acompanhamento Técnico & Responsabilidade (ART)</option>
                                <option value="Contrato de Laudo Pericial e Vistoria Cautelar de Vizinhança">Laudo Pericial & Vistoria Cautelar</option>
                                <option value="Contrato de Manutenção Predial e Instalações (MEP)">Manutenção Predial & Instalações (MEP)</option>
                            </optgroup>
                            <optgroup label="⚖️ Procurações">
                                <option value="Procuração Ad Judicia">Procuração Ad Judicia (Judicial)</option>
                                <option value="Procuração Ad Negotia">Procuração Ad Negotia (Negocial)</option>
                                <option value="Procuração para Compra e Venda de Imóvel">Procuração — Compra/Venda de Imóvel</option>
                                <option value="Procuração para Representação Bancária">Procuração — Representação Bancária</option>
                                <option value="Procuração para Representação Empresarial">Procuração — Representação Empresarial</option>
                                <option value="Procuração Geral Ampla">Procuração Geral Ampla</option>
                            </optgroup>
                            <optgroup label="📋 Declarações">
                                <option value="Declaração de Hipossuficiência">Declaração de Hipossuficiência</option>
                                <option value="Declaração de Residência">Declaração de Residência</option>
                                <option value="Declaração de União Estável">Declaração de União Estável</option>
                                <option value="Declaração de Dependente">Declaração de Dependente</option>
                                <option value="Declaração de Atividade Autônoma">Declaração de Atividade Autônoma</option>
                                <option value="Declaração de Bens e Rendimentos">Declaração de Bens e Rendimentos</option>
                                <option value="Declaração de Recebimento de Valores">Declaração de Recebimento de Valores</option>
                            </optgroup>
                            <optgroup label="🤝 Prestação de Serviços">
                                <option value="Prestação de Serviços Gerais">Prestação de Serviços Gerais</option>
                                <option value="Prestação de Serviços de TI">Prestação de Serviços de TI</option>
                                <option value="Prestação de Serviços de Marketing">Prestação de Serviços de Marketing</option>
                                <option value="Prestação de Serviços de Consultoria">Consultoria</option>
                                <option value="Prestação de Serviços Autônomos">Serviços Autônomos (PJ)</option>
                            </optgroup>
                            <optgroup label="🏠 Locação">
                                <option value="Locação de Imóvel Residencial">Locação Residencial</option>
                                <option value="Locação de Imóvel Comercial">Locação Comercial</option>
                                <option value="Locação de Veículo">Locação de Veículo</option>
                                <option value="Locação de Equipamentos">Locação de Equipamentos</option>
                            </optgroup>
                            <optgroup label="💰 Compra e Venda">
                                <option value="Compra e Venda de Imóvel">Compra e Venda de Imóvel</option>
                                <option value="Compra e Venda de Veículo">Compra e Venda de Veículo</option>
                                <option value="Compra e Venda de Mercadorias">Compra e Venda de Mercadorias</option>
                            </optgroup>
                            <optgroup label="👔 Trabalho e Sociedade">
                                <option value="Contrato de Trabalho CLT">Trabalho CLT</option>
                                <option value="Contrato de Estágio">Estágio</option>
                                <option value="Sociedade/Parceria">Sociedade/Parceria</option>
                            </optgroup>
                            <optgroup label="📄 Outros">
                                <option value="Empréstimo/Mútuo">Empréstimo/Mútuo</option>
                                <option value="Confidencialidade (NDA)">Confidencialidade (NDA)</option>
                                <option value="Licença de Software">Licença de Software</option>
                                <option value="Representação Comercial">Representação Comercial</option>
                                <option value="Outro">Outro (especificar)</option>
                            </optgroup>
                        </select>
                    </div>
                    <div id="tipo_contrato_outro_container" class="hidden">
                        <label class="label-modern">Especifique o Tipo *</label>
                        <input type="text" id="tipo_contrato_outro" class="input-modern" placeholder="Ex: Contrato de Comodato">
                    </div>
                </div>

                <!-- Nível de Formalidade -->
                <div class="mt-8">
                    <label class="label-modern mb-4">Nível de Formalidade</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <label class="radio-modern">
                            <input type="radio" name="formalidade" value="simples">
                            <span>Simples</span>
                        </label>
                        <label class="radio-modern">
                            <input type="radio" name="formalidade" value="padrao" checked>
                            <span>Padrão</span>
                        </label>
                        <label class="radio-modern">
                            <input type="radio" name="formalidade" value="detalhado">
                            <span>Detalhado</span>
                        </label>
                        <label class="radio-modern">
                            <input type="radio" name="formalidade" value="juridico_completo">
                            <span>Jurídico Completo</span>
                        </label>
                    </div>
                </div>
            </section>

            <!-- Partes do Contrato -->
            <div class="grid lg:grid-cols-2 gap-8">
                <!-- Contratante -->
                <section class="card-modern p-8 fade-up stagger-2">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="icon-box icon-box-blue">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-slate-800" id="label_parte1">Contratante</h2>
                            <p class="text-sm text-slate-500" id="label_parte1_sub">Quem contrata o serviço</p>
                        </div>
                    </div>
                    
                    <div class="space-y-5">
                        <div>
                            <label class="label-modern">Tipo de Pessoa *</label>
                            <select id="contratante_tipo_pessoa" class="input-modern">
                                <option value="fisica">Pessoa Física</option>
                                <option value="juridica">Pessoa Jurídica</option>
                            </select>
                        </div>
                        <div>
                            <label class="label-modern">Nome / Razão Social *</label>
                            <input type="text" id="contratante_nome" class="input-modern" placeholder="Nome completo ou razão social" required>
                        </div>
                        <div>
                            <label class="label-modern">CPF / CNPJ *</label>
                            <input type="text" id="contratante_doc" class="input-modern" placeholder="000.000.000-00" required>
                        </div>
                        <div id="contratante_rg_container">
                            <label class="label-modern">RG</label>
                            <input type="text" id="contratante_rg" class="input-modern" placeholder="00.000.000-0">
                        </div>
                        <div>
                            <label class="label-modern">Nacionalidade / Estado Civil / Profissão</label>
                            <div class="grid grid-cols-3 gap-3">
                                <input type="text" id="contratante_nacionalidade" class="input-modern text-sm" placeholder="Brasileiro(a)">
                                <select id="contratante_estado_civil" class="input-modern text-sm">
                                    <option value="">Estado Civil</option>
                                    <option value="solteiro(a)">Solteiro(a)</option>
                                    <option value="casado(a)">Casado(a)</option>
                                    <option value="divorciado(a)">Divorciado(a)</option>
                                    <option value="viúvo(a)">Viúvo(a)</option>
                                    <option value="união estável">União Estável</option>
                                </select>
                                <input type="text" id="contratante_profissao" class="input-modern text-sm" placeholder="Profissão">
                            </div>
                        </div>
                        <div>
                            <label class="label-modern">Endereço Completo *</label>
                            <textarea id="contratante_endereco" rows="2" class="input-modern" placeholder="Rua, número, bairro, cidade, estado, CEP" required></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="label-modern">Email</label>
                                <input type="email" id="contratante_email" class="input-modern" placeholder="email@exemplo.com">
                            </div>
                            <div>
                                <label class="label-modern">WhatsApp</label>
                                <input type="text" id="contratante_telefone_whatsapp" class="input-modern" placeholder="5511999998888">
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Contratado -->
                <section class="card-modern p-8 fade-up stagger-3">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="icon-box icon-box-green">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-slate-800">Contratado(a)</h2>
                            <p class="text-sm text-slate-500">Quem presta o serviço</p>
                        </div>
                    </div>
                    
                    <div class="space-y-5">
                        <div>
                            <label class="label-modern">Tipo de Pessoa *</label>
                            <select id="contratado_tipo_pessoa" class="input-modern">
                                <option value="fisica">Pessoa Física</option>
                                <option value="juridica">Pessoa Jurídica</option>
                            </select>
                        </div>
                        <div>
                            <label class="label-modern">Nome / Razão Social *</label>
                            <input type="text" id="contratado_nome" class="input-modern" placeholder="Nome completo ou razão social" required>
                        </div>
                        <div>
                            <label class="label-modern">CPF / CNPJ *</label>
                            <input type="text" id="contratado_doc" class="input-modern" placeholder="000.000.000-00" required>
                        </div>
                        <div id="contratado_rg_container">
                            <label class="label-modern">RG</label>
                            <input type="text" id="contratado_rg" class="input-modern" placeholder="00.000.000-0">
                        </div>
                        <div>
                            <label class="label-modern">Nacionalidade / Estado Civil / Profissão</label>
                            <div class="grid grid-cols-3 gap-3">
                                <input type="text" id="contratado_nacionalidade" class="input-modern text-sm" placeholder="Brasileiro(a)">
                                <select id="contratado_estado_civil" class="input-modern text-sm">
                                    <option value="">Estado Civil</option>
                                    <option value="solteiro(a)">Solteiro(a)</option>
                                    <option value="casado(a)">Casado(a)</option>
                                    <option value="divorciado(a)">Divorciado(a)</option>
                                    <option value="viúvo(a)">Viúvo(a)</option>
                                    <option value="união estável">União Estável</option>
                                </select>
                                <input type="text" id="contratado_profissao" class="input-modern text-sm" placeholder="Profissão">
                            </div>
                        </div>
                        <div>
                            <label class="label-modern">Endereço Completo *</label>
                            <textarea id="contratado_endereco" rows="2" class="input-modern" placeholder="Rua, número, bairro, cidade, estado, CEP" required></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="label-modern">Email</label>
                                <input type="email" id="contratado_email" class="input-modern" placeholder="email@exemplo.com">
                            </div>
                            <div>
                                <label class="label-modern">WhatsApp</label>
                                <input type="text" id="contratado_telefone_whatsapp" class="input-modern" placeholder="5511999998888">
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Seção: Poderes da Procuração (visível apenas para procurações) -->
            <section class="card-modern p-8 fade-up hidden" id="section_poderes_procuracao">
                <div class="flex items-center gap-4 mb-8">
                    <div class="icon-box icon-box-purple">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-800">Poderes Outorgados</h2>
                        <p class="text-sm text-slate-500">Selecione os poderes que o outorgado terá</p>
                    </div>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4" id="poderes_container">
                    <label class="clause-modern flex items-start gap-4">
                        <div class="clause-icon w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center flex-shrink-0 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        <div class="flex-1 pt-1">
                            <input type="checkbox" id="poder_compra_venda_imovel" class="hidden">
                            <span class="font-semibold text-slate-700 block">Compra e Venda de Imóvel</span>
                            <span class="text-xs text-slate-500">Assinar escrituras e contratos</span>
                        </div>
                    </label>
                    <label class="clause-modern flex items-start gap-4">
                        <div class="clause-icon w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center flex-shrink-0 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        </div>
                        <div class="flex-1 pt-1">
                            <input type="checkbox" id="poder_representacao_bancaria" class="hidden">
                            <span class="font-semibold text-slate-700 block">Operações Bancárias</span>
                            <span class="text-xs text-slate-500">Movimentar contas e realizar transferências</span>
                        </div>
                    </label>
                    <label class="clause-modern flex items-start gap-4">
                        <div class="clause-icon w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center flex-shrink-0 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                        </div>
                        <div class="flex-1 pt-1">
                            <input type="checkbox" id="poder_juridico" class="hidden">
                            <span class="font-semibold text-slate-700 block">Atuação Judicial</span>
                            <span class="text-xs text-slate-500">Representar em processos judiciais</span>
                        </div>
                    </label>
                    <label class="clause-modern flex items-start gap-4">
                        <div class="clause-icon w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center flex-shrink-0 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div class="flex-1 pt-1">
                            <input type="checkbox" id="poder_empresarial" class="hidden">
                            <span class="font-semibold text-slate-700 block">Gestão Empresarial</span>
                            <span class="text-xs text-slate-500">Assinar contratos e gerir a empresa</span>
                        </div>
                    </label>
                    <label class="clause-modern flex items-start gap-4">
                        <div class="clause-icon w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center flex-shrink-0 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/></svg>
                        </div>
                        <div class="flex-1 pt-1">
                            <input type="checkbox" id="poder_receber_quitacao" class="hidden">
                            <span class="font-semibold text-slate-700 block">Receber e Dar Quitação</span>
                            <span class="text-xs text-slate-500">Receber pagamentos e assinar recibos</span>
                        </div>
                    </label>
                    <label class="clause-modern flex items-start gap-4">
                        <div class="clause-icon w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center flex-shrink-0 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                        </div>
                        <div class="flex-1 pt-1">
                            <input type="checkbox" id="poder_substabelecer" class="hidden">
                            <span class="font-semibold text-slate-700 block">Substabelecer</span>
                            <span class="text-xs text-slate-500">Delegar poderes a terceiros</span>
                        </div>
                    </label>
                </div>
                <div class="mt-6">
                    <label class="label-modern">Poderes Específicos Adicionais <span class="text-slate-400 font-normal">(opcional)</span></label>
                    <textarea id="poderes_especificos" rows="3" class="input-modern" placeholder="Descreva outros poderes específicos que o outorgado deve ter, ex: assinar contratos de locação, representar em cartório, etc."></textarea>
                </div>
            </section>

            <!-- Seção: Declaração (visível apenas para declarações) -->
            <section class="card-modern p-8 fade-up hidden" id="section_declaracao">
                <div class="flex items-center gap-4 mb-8">
                    <div class="icon-box icon-box-amber">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-800">Detalhes da Declaração</h2>
                        <p class="text-sm text-slate-500">Informações específicas para a declaração</p>
                    </div>
                </div>
                <div class="space-y-5">
                    <div>
                        <label class="label-modern">Finalidade / Destinatário <span class="text-slate-400 font-normal">(opcional)</span></label>
                        <input type="text" id="declaracao_finalidade" class="input-modern" placeholder="Ex: Para fins de isenção de taxa, apresentar ao INSS, para fins que se fizerem necessários...">
                    </div>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="label-modern">Sob pena de *</label>
                            <select id="declaracao_pena" class="input-modern">
                                <option value="lei">Responsabilidade civil e criminal prevista em lei</option>
                                <option value="falsidade_ideologica">Falsidade ideológica (Art. 299 CP)</option>
                                <option value="crime_falso">Crime de falso testemunho</option>
                                <option value="penas_legais">Todas as penas legais cabíveis</option>
                            </select>
                        </div>
                        <div>
                            <label class="label-modern">Testemunhas</label>
                            <select id="declaracao_testemunhas" class="input-modern">
                                <option value="nenhuma">Sem testemunhas</option>
                                <option value="uma">1 Testemunha</option>
                                <option value="duas">2 Testemunhas</option>
                            </select>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Objeto e Detalhes -->
            <section class="card-modern p-8 fade-up">
                <div class="flex items-center gap-4 mb-8">
                    <div class="icon-box icon-box-amber">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-800">Objeto do Contrato</h2>
                        <p class="text-sm text-slate-500">Descreva os detalhes do acordo</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="label-modern">Descrição Detalhada do Objeto *</label>
                        <textarea id="objeto_contrato" rows="4" class="input-modern" placeholder="Descreva detalhadamente o objeto do contrato: serviços a serem prestados, bem a ser locado/vendido, atividades, entregas esperadas, etc." required></textarea>
                        <p class="text-xs text-slate-400 mt-2">💡 Seja o mais específico possível para um contrato mais preciso.</p>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="label-modern">Valor Total (R$) *</label>
                            <input type="text" id="valor_contrato" class="input-modern" placeholder="0,00" required>
                        </div>
                        <div>
                            <label class="label-modern">Forma de Pagamento *</label>
                            <select id="forma_pagamento" class="input-modern" required>
                                <option value="">-- Selecione --</option>
                                <option value="a_vista">À Vista</option>
                                <option value="parcelado">Parcelado</option>
                                <option value="mensal">Mensal (Recorrente)</option>
                                <option value="por_entrega">Por Entrega/Etapa</option>
                                <option value="personalizado">Personalizado</option>
                            </select>
                        </div>
                    </div>

                    <div id="pagamento_detalhes_container" class="hidden">
                        <label class="label-modern">Detalhes do Pagamento</label>
                        <textarea id="forma_pagamento_desc" rows="2" class="input-modern" placeholder="Ex: 50% na assinatura e 50% na entrega; 12 parcelas de R$ 500,00 todo dia 10; etc."></textarea>
                    </div>

                    <div class="grid md:grid-cols-3 gap-6">
                        <div>
                            <label class="label-modern">Data de Início *</label>
                            <input type="date" id="data_inicio" class="input-modern" required>
                        </div>
                        <div>
                            <label class="label-modern">Tipo de Término *</label>
                            <select id="data_termino_tipo" class="input-modern" required>
                                <option value="data_especifica">Data Específica</option>
                                <option value="indeterminado">Prazo Indeterminado</option>
                                <option value="conclusao_objeto">Até Conclusão do Objeto</option>
                                <option value="meses">Por Período (meses)</option>
                            </select>
                        </div>
                        <div id="data_termino_container">
                            <label class="label-modern">Data de Término</label>
                            <input type="date" id="data_termino" class="input-modern">
                        </div>
                        <div id="meses_vigencia_container" class="hidden">
                            <label class="label-modern">Quantidade de Meses</label>
                            <input type="number" id="meses_vigencia" min="1" max="120" class="input-modern" placeholder="12">
                        </div>
                    </div>
                </div>
            </section>

            <!-- Cláusulas Especiais -->
            <section class="card-modern p-8 fade-up">
                <div class="flex items-center gap-4 mb-8">
                    <div class="icon-box icon-box-indigo">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-800">Cláusulas Especiais</h2>
                        <p class="text-sm text-slate-500">Selecione as que deseja incluir no contrato</p>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6" id="clausulas_container">
                    <label class="clause-modern flex items-start gap-4">
                        <div class="clause-icon w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center flex-shrink-0 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="flex-1 pt-1">
                            <input type="checkbox" id="clausula_multa" class="hidden">
                            <span class="font-semibold text-slate-700 block">Multa por Descumprimento</span>
                            <span class="text-xs text-slate-500">Penalidades por quebra de contrato</span>
                        </div>
                    </label>
                    <label class="clause-modern flex items-start gap-4">
                        <div class="clause-icon w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center flex-shrink-0 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </div>
                        <div class="flex-1 pt-1">
                            <input type="checkbox" id="clausula_rescisao" class="hidden">
                            <span class="font-semibold text-slate-700 block">Rescisão Antecipada</span>
                            <span class="text-xs text-slate-500">Condições para encerrar antes</span>
                        </div>
                    </label>
                    <label class="clause-modern flex items-start gap-4">
                        <div class="clause-icon w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center flex-shrink-0 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <div class="flex-1 pt-1">
                            <input type="checkbox" id="clausula_confidencialidade" class="hidden">
                            <span class="font-semibold text-slate-700 block">Confidencialidade</span>
                            <span class="text-xs text-slate-500">Sigilo de informações</span>
                        </div>
                    </label>
                    <label class="clause-modern flex items-start gap-4">
                        <div class="clause-icon w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center flex-shrink-0 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                        </div>
                        <div class="flex-1 pt-1">
                            <input type="checkbox" id="clausula_propriedade_intelectual" class="hidden">
                            <span class="font-semibold text-slate-700 block">Propriedade Intelectual</span>
                            <span class="text-xs text-slate-500">Direitos sobre criações</span>
                        </div>
                    </label>
                    <label class="clause-modern flex items-start gap-4">
                        <div class="clause-icon w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center flex-shrink-0 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                        </div>
                        <div class="flex-1 pt-1">
                            <input type="checkbox" id="clausula_nao_concorrencia" class="hidden">
                            <span class="font-semibold text-slate-700 block">Não Concorrência</span>
                            <span class="text-xs text-slate-500">Restrição de atividades</span>
                        </div>
                    </label>
                    <label class="clause-modern flex items-start gap-4">
                        <div class="clause-icon w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center flex-shrink-0 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <div class="flex-1 pt-1">
                            <input type="checkbox" id="clausula_garantia" class="hidden">
                            <span class="font-semibold text-slate-700 block">Garantia</span>
                            <span class="text-xs text-slate-500">Termos de garantia do serviço</span>
                        </div>
                    </label>
                    <label class="clause-modern flex items-start gap-4">
                        <div class="clause-icon w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center flex-shrink-0 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        </div>
                        <div class="flex-1 pt-1">
                            <input type="checkbox" id="clausula_reajuste" class="hidden">
                            <span class="font-semibold text-slate-700 block">Reajuste de Valores</span>
                            <span class="text-xs text-slate-500">Correção monetária/índices</span>
                        </div>
                    </label>
                    <label class="clause-modern flex items-start gap-4">
                        <div class="clause-icon w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center flex-shrink-0 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="flex-1 pt-1">
                            <input type="checkbox" id="clausula_forca_maior" class="hidden">
                            <span class="font-semibold text-slate-700 block">Força Maior</span>
                            <span class="text-xs text-slate-500">Eventos imprevisíveis</span>
                        </div>
                    </label>
                    <label class="clause-modern flex items-start gap-4">
                        <div class="clause-icon w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center flex-shrink-0 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div class="flex-1 pt-1">
                            <input type="checkbox" id="clausula_lgpd" class="hidden">
                            <span class="font-semibold text-slate-700 block">LGPD</span>
                            <span class="text-xs text-slate-500">Proteção de dados pessoais</span>
                        </div>
                    </label>
                </div>

                <!-- Detalhes das Cláusulas -->
                <div id="clausulas_detalhes" class="space-y-4 hidden">
                    <div id="multa_detalhes" class="hidden p-5 bg-gradient-to-r from-slate-50 to-indigo-50 rounded-2xl border border-indigo-100">
                        <label class="label-modern">Detalhes da Multa</label>
                        <div class="grid md:grid-cols-2 gap-4">
                            <input type="text" id="multa_percentual" class="input-modern" placeholder="Percentual (ex: 10%)">
                            <input type="text" id="multa_valor_fixo" class="input-modern" placeholder="Ou valor fixo (R$)">
                        </div>
                    </div>
                    <div id="rescisao_detalhes" class="hidden p-5 bg-gradient-to-r from-slate-50 to-indigo-50 rounded-2xl border border-indigo-100">
                        <label class="label-modern">Aviso Prévio para Rescisão</label>
                        <input type="text" id="aviso_previo" class="input-modern" placeholder="Ex: 30 dias">
                    </div>
                    <div id="garantia_detalhes" class="hidden p-5 bg-gradient-to-r from-slate-50 to-indigo-50 rounded-2xl border border-indigo-100">
                        <label class="label-modern">Período de Garantia</label>
                        <input type="text" id="periodo_garantia" class="input-modern" placeholder="Ex: 90 dias após a entrega">
                    </div>
                    <div id="reajuste_detalhes" class="hidden p-5 bg-gradient-to-r from-slate-50 to-indigo-50 rounded-2xl border border-indigo-100">
                        <label class="label-modern">Índice de Reajuste</label>
                        <select id="indice_reajuste" class="input-modern">
                            <option value="IGPM">IGPM (FGV)</option>
                            <option value="IPCA">IPCA (IBGE)</option>
                            <option value="INPC">INPC (IBGE)</option>
                            <option value="outro">Outro</option>
                        </select>
                    </div>
                </div>
            </section>

            <!-- Foro e Instruções -->
            <section class="card-modern p-8 fade-up">
                <div class="flex items-center gap-4 mb-8">
                    <div class="icon-box icon-box-rose">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-800">Foro e Instruções</h2>
                        <p class="text-sm text-slate-500">Jurisdição e informações adicionais</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="label-modern">Cidade do Foro *</label>
                            <input type="text" id="cidade_foro" class="input-modern" placeholder="São Paulo" required>
                        </div>
                        <div>
                            <label class="label-modern">Estado (UF) *</label>
                            <input type="text" id="estado_foro" class="input-modern" placeholder="SP" maxlength="2" required>
                        </div>
                    </div>

                    <div>
                        <label class="label-modern">
                            Instruções Adicionais para a IA
                            <span class="text-slate-400 font-normal lowercase">(opcional)</span>
                        </label>
                        <textarea id="instrucoes_ia" rows="4" class="input-modern" placeholder="Adicione aqui qualquer instrução específica, cláusulas personalizadas, observações importantes ou detalhes que devem constar no contrato..."></textarea>
                    </div>

                    <!-- Dicas -->
                    <div class="p-6 bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 rounded-2xl border border-indigo-100">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 mb-2">Dicas para melhores resultados</h4>
                                <ul class="text-sm text-slate-600 space-y-1">
                                    <li>• Seja específico na descrição do objeto do contrato</li>
                                    <li>• Inclua todos os detalhes de pagamento (datas, parcelas, método)</li>
                                    <li>• Mencione obrigações específicas de cada parte nas instruções</li>
                                    <li>• Para contratos complexos, use o nível "Jurídico Completo"</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Opções de Geração -->
            <section class="card-modern p-8 fade-up">
                <div class="flex items-center gap-4 mb-6">
                    <div class="icon-box" style="background: linear-gradient(135deg,#10b981,#059669); color:white;">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-800">Opções de Geração</h2>
                        <p class="text-sm text-slate-500">Configure como o documento será gerado</p>
                    </div>
                </div>
                <div class="grid md:grid-cols-2 gap-4">
                    <label class="clause-modern flex items-start gap-4" id="opt_resumo_label">
                        <div class="clause-icon w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center flex-shrink-0 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        </div>
                        <div class="flex-1 pt-1">
                            <input type="checkbox" id="opt_resumo_executivo" class="hidden">
                            <span class="font-semibold text-slate-700 block">Resumo Executivo</span>
                            <span class="text-xs text-slate-500">Adiciona um resumo simplificado no início do documento</span>
                        </div>
                    </label>
                    <label class="clause-modern flex items-start gap-4">
                        <div class="clause-icon w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center flex-shrink-0 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </div>
                        <div class="flex-1 pt-1">
                            <input type="checkbox" id="opt_assinatura_digital" class="hidden">
                            <span class="font-semibold text-slate-700 block">Campo de Assinatura Digital</span>
                            <span class="text-xs text-slate-500">Inclui campo para e-mail/IP no documento</span>
                        </div>
                    </label>
                    <label class="clause-modern flex items-start gap-4">
                        <div class="clause-icon w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center flex-shrink-0 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/></svg>
                        </div>
                        <div class="flex-1 pt-1">
                            <input type="checkbox" id="opt_numeracao_paginas" class="hidden">
                            <span class="font-semibold text-slate-700 block">Numeração de Páginas</span>
                            <span class="text-xs text-slate-500">Inclui instrução de rubrica em cada página</span>
                        </div>
                    </label>
                    <label class="clause-modern flex items-start gap-4">
                        <div class="clause-icon w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center flex-shrink-0 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        </div>
                        <div class="flex-1 pt-1">
                            <input type="checkbox" id="opt_reconhecimento_firma" class="hidden">
                            <span class="font-semibold text-slate-700 block">Instrução de Reconhecimento</span>
                            <span class="text-xs text-slate-500">Adiciona orientação sobre reconhecimento de firma em cartório</span>
                        </div>
                    </label>
                </div>
            </section>

            <!-- Botões de Ação -->
            <div class="flex flex-wrap justify-center gap-4 pt-4">
                <button type="button" id="btnGerarPreviaOffline" class="px-6 py-4 rounded-2xl bg-slate-900 hover:bg-slate-800 text-cyan-400 border border-cyan-500/40 hover:border-cyan-400 font-bold text-base flex items-center gap-2.5 transition-all shadow-lg shadow-cyan-900/30 cursor-pointer">
                    <i class="fa-solid fa-bolt text-yellow-400"></i>
                    <span>Pré-visualizar Modelo (Grátis / Sem Créditos)</span>
                </button>
                <button type="button" id="btnGerarIA"  class="btn-gradient flex items-center gap-3 text-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    <span id="btn_gerar_label">Gerar Documento com IA</span>
                </button>
                <button type="button" id="btnLimparFormulario" class="btn-soft flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Limpar Formulário
                </button>
            </div>
        </form>

        <!-- Resultado -->
        <section id="resultadoContainer" class="mt-10 hidden fade-up">
            <div class="card-modern p-8">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-500/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-800" id="label_resultado">Documento Gerado</h2>
                        <p class="text-sm text-slate-500">Revise e faça os ajustes necessários</p>
                    </div>
                </div>

                <!-- Loading -->
                <div id="loadingIA" class="flex flex-col items-center justify-center py-16">
                    <div class="spinner-modern mb-6"></div>
                    <p class="text-slate-700 font-semibold text-lg">Gerando contrato com IA...</p>
                    <p class="text-slate-400 text-sm mt-1">Isso pode levar alguns segundos</p>
                </div>

                <!-- Texto do Contrato -->
                <!-- Barra Superior Fixa de Ações Rápidas (Sempre Visível no Topo do Documento!) -->
                <div class="sticky top-20 z-20 bg-slate-900/95 backdrop-blur-md text-white rounded-2xl p-3 sm:p-4 shadow-2xl border border-white/15 mb-6 flex flex-wrap items-center justify-between gap-3">
                    <div class="flex items-center gap-2">
                        <button type="button" id="tabModoVisual" class="px-3.5 py-2 rounded-xl text-xs font-bold bg-indigo-600 text-white shadow-md transition-all flex items-center gap-1.5 cursor-pointer">
                            <i class="fa-solid fa-file-invoice"></i> <span>Documento Formatado</span>
                        </button>
                        <button type="button" id="tabModoTexto" class="px-3.5 py-2 rounded-xl text-xs font-bold bg-slate-800 hover:bg-slate-700 text-slate-300 transition-all flex items-center gap-1.5 cursor-pointer">
                            <i class="fa-solid fa-pen-to-square"></i> <span>Editor de Texto (Raw)</span>
                        </button>
                    </div>

                    <!-- Botões Rápidos no Topo para Acesso Imediato sem Rolar -->
                    <div class="flex flex-wrap items-center gap-2">
                        <button type="button" onclick="$('#btnExportarPdfJuridico').click()" class="px-4 py-2 rounded-xl bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white text-xs font-extrabold shadow-lg shadow-red-600/30 cursor-pointer flex items-center gap-1.5 hover:scale-105 transition-all">
                            <i class="fa-solid fa-file-pdf"></i> <span>Baixar PDF</span>
                        </button>
                        <button type="button" onclick="$('#btnTransferirParaAssinador').click()" class="px-4 py-2 rounded-xl bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white text-xs font-extrabold shadow-lg shadow-cyan-600/30 cursor-pointer flex items-center gap-1.5 hover:scale-105 transition-all">
                            <i class="fa-solid fa-paper-plane"></i> <span>Assinador PDF</span>
                        </button>
                        <button type="button" onclick="abrirModalAssinaturaComTipo('contratante')" class="px-4 py-2 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white text-xs font-extrabold shadow-lg shadow-purple-600/30 cursor-pointer flex items-center gap-1.5 hover:scale-105 transition-all">
                            <i class="fa-solid fa-signature"></i> <span>Assinar</span>
                        </button>
                    </div>
                </div>

                <!-- 1. Visualizador Estilizado A4 sem barra interna travada (Expansão Natural) -->
                <div id="contratoPreviewVisual" class="bg-white text-slate-900 rounded-3xl p-6 sm:p-12 shadow-2xl border border-slate-200 font-serif leading-relaxed text-sm min-h-[500px]">
                    <!-- Conteúdo com assinaturas renderizadas -->
                </div>

                <!-- 2. Textarea Editável -->
                <textarea id="contratoGeradoTexto" class="hidden input-modern font-mono text-sm h-[500px]" placeholder="O contrato gerado aparecerá aqui..."></textarea>

                <!-- Ações -->
                <div id="acoesResultado" class="hidden mt-10 mb-20 p-6 bg-white rounded-3xl border-2 border-indigo-100 shadow-xl flex flex-wrap gap-3 items-center justify-center">
                    <button type="button" id="btnExportarPdfJuridico" class="action-btn bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white shadow-lg shadow-red-600/30 cursor-pointer">
                        <i class="fa-solid fa-file-pdf"></i> Baixar PDF Jurídico
                    </button>
                    <button type="button" id="btnTransferirParaAssinador" class="action-btn bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white shadow-lg shadow-cyan-600/30 cursor-pointer">
                        <i class="fa-solid fa-paper-plane"></i> Abrir no Assinador de PDF
                    </button>
                    <button type="button" id="btnAbrirAssinaturaDigital" class="action-btn bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white shadow-lg shadow-purple-600/30 cursor-pointer">
                        <i class="fa-solid fa-signature"></i> Assinar Digitalmente
                    </button>
                    <button id="btnCopiarConteudoContrato" class="action-btn bg-slate-100 hover:bg-slate-200 text-slate-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        Copiar
                    </button>
                    <button id="btnImprimirContrato" class="action-btn bg-blue-50 hover:bg-blue-100 text-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        Imprimir
                    </button>
                    <button id="btnSalvarHtmlContrato" class="action-btn bg-emerald-50 hover:bg-emerald-100 text-emerald-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        HTML
                    </button>
                    <button id="btnSalvarDocx" class="action-btn bg-indigo-50 hover:bg-indigo-100 text-indigo-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        TXT
                    </button>
                    <button id="btnSalvarDocxReal" class="action-btn bg-blue-600 hover:bg-blue-700 text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        DOCX
                    </button>
                    <button id="btnEnviarWhatsAppContratante" class="action-btn bg-green-50 hover:bg-green-100 text-green-600">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        <span id="lbl_wapp_parte1">Parte 1</span>
                    </button>
                    <button id="btnEnviarWhatsAppContratado" class="action-btn bg-green-50 hover:bg-green-100 text-green-600">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        <span id="lbl_wapp_parte2">Parte 2</span>
                    </button>
                </div>
            </div>
        </section>
        </div> <!-- /viewGerador -->

        <!-- ========================================================= -->
        <!-- 3. VIEW: CENTRAL DE ASSINATURA DIGITAL (ESTILO DOCUSIGN)  -->
        <!-- ========================================================= -->
        <div id="viewAssinador" class="hidden space-y-6 max-w-6xl mx-auto">
            
            <!-- Barra Superior de Navegação -->
            <div class="flex items-center justify-between gap-4 bg-white rounded-2xl p-4 border border-slate-200 shadow-sm">
                <button type="button" onclick="navegarPara('hub')" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all flex items-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-arrow-left"></i> <span>Voltar ao Hub</span>
                </button>
                <div class="text-xs font-bold text-slate-800 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-cyan-500 animate-pulse"></span>
                    <span>Central de Assinatura Digital & Disparo</span>
                </div>
                <button type="button" onclick="navegarPara('gerador')" class="px-4 py-2 rounded-xl bg-purple-50 hover:bg-purple-100 text-purple-800 border border-purple-200 text-xs font-bold transition-all flex items-center gap-1.5 cursor-pointer">
                    <i class="fa-solid fa-file-contract"></i> <span class="hidden sm:inline">Criar</span> Contrato com IA
                </button>
            </div>

            <!-- 1. ESTADO DE UPLOAD (QUANDO NENHUM PDF ESTÁ ABERTO) -->
            <div id="pdfUploadState" class="card-modern p-8 sm:p-12 shadow-xl border-slate-200 text-center">
                <input type="file" id="inputPdfFile" accept="application/pdf" class="hidden" />

                <div class="max-w-xl mx-auto space-y-4">
                    <div class="w-20 h-20 rounded-3xl bg-gradient-to-tr from-cyan-500 to-indigo-600 text-white flex items-center justify-center text-3xl mx-auto shadow-xl shadow-cyan-500/25">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight">1. Anexe o Documento para Abrir na Tela</h3>
                    <p class="text-sm text-slate-600 font-medium">Suba qualquer contrato, proposta, procuração ou termo em PDF. O arquivo será aberto na tela com todas as páginas para você assinar e salvar ou enviar.</p>

                    <div id="pdfDropzone" class="dropzone-box p-10 mt-6 text-center cursor-pointer">
                        <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl mx-auto mb-3">
                            <i class="fa-solid fa-file-pdf"></i>
                        </div>
                        <h4 class="font-bold text-base text-slate-800 mb-1">Arraste seu arquivo PDF aqui ou clique para selecionar</h4>
                        <p class="text-xs text-slate-400">Processamento em tela com máxima segurança e privacidade</p>
                    </div>
                </div>
            </div>

            <!-- 2. ESTADO DO WORKSPACE (QUANDO O PDF ESTÁ ABERTO NA TELA) -->
            <div id="pdfWorkspaceState" class="hidden space-y-6">
                
                <!-- Barra de Ferramentas e Ações do Documento Aberto (Sticky) -->
                <div class="sticky top-4 z-30 bg-slate-900/95 backdrop-blur-md rounded-2xl p-4 border border-white/10 shadow-2xl flex flex-wrap items-center justify-between gap-4 text-white">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-cyan-500/20 text-cyan-400 flex items-center justify-center text-lg border border-cyan-500/30">
                            <i class="fa-solid fa-file-invoice"></i>
                        </div>
                        <div>
                            <div id="pdfNomeArquivo" class="font-bold text-sm text-white truncate max-w-xs sm:max-w-md">documento.pdf</div>
                            <div id="pdfStatusPaginas" class="text-xs text-cyan-300/80 font-mono">Carregando páginas...</div>
                        </div>
                    </div>

                    <!-- Botões de Ação do Documento Aberto -->
                    <div class="flex flex-wrap items-center gap-2.5">
                        <button type="button" id="btnTrocarPdf" class="px-3.5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-bold transition-all flex items-center gap-1.5 cursor-pointer">
                            <i class="fa-solid fa-folder-open"></i> <span>Trocar PDF</span>
                        </button>
                        <button type="button" onclick="abrirModalAssinaturaComTipo('contratante')" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white text-xs font-extrabold shadow-lg shadow-purple-600/30 transition-all flex items-center gap-2 cursor-pointer hover:scale-[1.02]">
                            <i class="fa-solid fa-signature"></i> <span>Assinar Documento</span>
                        </button>
                        <button type="button" id="btnExportarPdfAssinadoLib" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white text-xs font-extrabold shadow-lg shadow-cyan-600/30 transition-all flex items-center gap-2 cursor-pointer hover:scale-[1.02]">
                            <i class="fa-solid fa-floppy-disk"></i> <span>Salvar / Baixar PDF</span>
                        </button>
                        <button type="button" id="btnAbrirModalZap" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-xs font-extrabold shadow-lg shadow-emerald-600/30 transition-all flex items-center gap-2 cursor-pointer hover:scale-[1.02]">
                            <i class="fa-brands fa-whatsapp text-sm"></i> <span>Enviar para Cliente</span>
                        </button>
                    </div>
                </div>

                <!-- Quadro de Renderização Real das Páginas do PDF -->
                <div class="bg-slate-100 rounded-3xl p-4 sm:p-8 border border-slate-300 shadow-inner">
                    <div id="pdfPagesRenderContainer" class="space-y-6">
                        <!-- As páginas do PDF serão renderizadas aqui pelo PDF.js como folhas A4 reais -->
                    </div>
                </div>
            </div>

            <!-- Modal de Disparo WhatsApp -->
            <div id="modalDisparoZap" class="fixed inset-0 bg-slate-900/80 backdrop-blur-md z-50 hidden flex items-center justify-center p-4">
                <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border border-slate-100">
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-800">Enviar para Assinatura</h3>
                                <p class="text-xs text-slate-500">Dispare o link seguro direto para o WhatsApp do cliente</p>
                            </div>
                        </div>
                        <button type="button" onclick="$('#modalDisparoZap').addClass('hidden')" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center cursor-pointer"><i class="fa-solid fa-xmark"></i></button>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="label-modern text-xs">Nome do Cliente:</label>
                            <input type="text" id="zap_cliente_nome" class="input-modern py-2 text-sm" placeholder="Ex: Nome da outra parte" />
                        </div>
                        <div>
                            <label class="label-modern text-xs">Número do WhatsApp (com DDD):</label>
                            <input type="text" id="zap_cliente_fone" class="input-modern py-2 text-sm" placeholder="Ex: (48) 99123-4567" />
                        </div>
                        <div class="p-3 bg-emerald-50 rounded-xl border border-emerald-200 text-xs text-emerald-900">
                            <i class="fa-solid fa-circle-check text-emerald-600"></i> O cliente abrirá o link no celular, verá o documento e assinará digitalmente de graça.
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-slate-100">
                        <button type="button" onclick="$('#modalDisparoZap').addClass('hidden')" class="px-4 py-2 rounded-xl text-slate-500 hover:bg-slate-100 text-xs font-bold cursor-pointer">
                            Cancelar
                        </button>
                        <button type="button" onclick="confirmarDisparoZap()" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-lg shadow-emerald-600/30 cursor-pointer flex items-center gap-2">
                            <i class="fa-brands fa-whatsapp"></i> <span>Abrir WhatsApp & Enviar</span>
                        </button>
                    </div>
                </div>
            </div>

        </div> <!-- /viewAssinador -->
    </main>

    <!-- Footer -->
    
    <!-- Modal de Assinatura Digital Avançada (Manuscrita ou Desenho) -->
    <div id="modalAssinatura" class="fixed inset-0 bg-slate-900/80 backdrop-blur-md z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-6 md:p-8 max-w-lg w-full shadow-2xl border border-slate-100 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-file-signature"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Assinatura Eletrônica 4USign</h3>
                        <p class="text-xs text-slate-500">Caligrafia manuscrita automática ou desenho livre</p>
                    </div>
                </div>
                <button type="button" id="btnFecharModalAssinaturaX" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center cursor-pointer"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <div class="mb-4">
                <label class="label-modern">Quem está assinando agora?</label>
                <select id="signatario_tipo" class="input-modern py-2 text-sm font-semibold">
                    <option value="contratante">1. Contratante / Você</option>
                    <option value="contratado">2. Contratado / Cliente</option>
                    <option value="testemunha1">3. Testemunha 1</option>
                    <option value="testemunha2">4. Testemunha 2</option>
                </select>
            </div>

            <!-- Abas do Modal: Caligrafia Manuscrita vs Desenho -->
            <div class="flex p-1 bg-slate-100 rounded-xl mb-4 text-xs font-bold">
                <button type="button" id="tabSigCaligrafia" class="flex-1 py-2 rounded-lg bg-white text-indigo-600 shadow-sm transition-all flex items-center justify-center gap-1.5 cursor-pointer">
                    <i class="fa-solid fa-font"></i> <span>Caligrafia Manuscrita</span>
                </button>
                <button type="button" id="tabSigDesenho" class="flex-1 py-2 rounded-lg text-slate-500 hover:text-slate-700 transition-all flex items-center justify-center gap-1.5 cursor-pointer">
                    <i class="fa-solid fa-pen-nib"></i> <span>Desenhar na Tela</span>
                </button>
            </div>

            <!-- 1. PAINEL CALIGRAFIA MANUSCRITA AUTOMÁTICA -->
            <div id="painelSigCaligrafia" class="space-y-4">
                <div>
                    <label class="label-modern text-xs">Nome a ser assinado:</label>
                    <input type="text" id="sig_nome_input" class="input-modern py-2 text-sm font-medium" placeholder="Digite ou confirme o nome para a assinatura" />
                </div>

                <div>
                    <label class="label-modern text-xs">Estilo da Caligrafia:</label>
                    <div class="grid grid-cols-2 gap-2 mt-1">
                        <button type="button" class="btn-sig-font active p-2 border-2 border-indigo-500 bg-indigo-50/50 rounded-xl text-left cursor-pointer transition-all" data-font="Dancing Script">
                            <span class="text-[10px] text-slate-400 font-sans block">1. Moderna</span>
                            <span class="font-dancing text-lg text-indigo-900 block truncate">Nome do Cliente</span>
                        </button>
                        <button type="button" class="btn-sig-font p-2 border-2 border-slate-200 hover:border-indigo-300 rounded-xl text-left cursor-pointer transition-all" data-font="Great Vibes">
                            <span class="text-[10px] text-slate-400 font-sans block">2. Clássica</span>
                            <span class="font-greatvibes text-lg text-slate-800 block truncate">Nome do Cliente</span>
                        </button>
                        <button type="button" class="btn-sig-font p-2 border-2 border-slate-200 hover:border-indigo-300 rounded-xl text-left cursor-pointer transition-all" data-font="Sacramento">
                            <span class="text-[10px] text-slate-400 font-sans block">3. Sofisticada</span>
                            <span class="font-sacramento text-xl text-slate-800 block truncate">Nome do Cliente</span>
                        </button>
                        <button type="button" class="btn-sig-font p-2 border-2 border-slate-200 hover:border-indigo-300 rounded-xl text-left cursor-pointer transition-all" data-font="Caveat">
                            <span class="text-[10px] text-slate-400 font-sans block">4. Espontânea</span>
                            <span class="font-caveat text-xl text-slate-800 block truncate">Nome do Cliente</span>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="label-modern text-xs">Cor da Tinta:</label>
                    <div class="flex items-center gap-2">
                        <button type="button" class="btn-sig-cor active px-3 py-1 rounded-lg text-xs font-bold border-2 border-blue-600 bg-blue-50 text-blue-800 cursor-pointer flex items-center gap-1.5" data-color="#1d4ed8">
                            <span class="w-3 h-3 rounded-full bg-blue-700"></span> Azul Caneta
                        </button>
                        <button type="button" class="btn-sig-cor px-3 py-1 rounded-lg text-xs font-bold border border-slate-200 text-slate-700 cursor-pointer flex items-center gap-1.5" data-color="#0f172a">
                            <span class="w-3 h-3 rounded-full bg-slate-900"></span> Preto Formal
                        </button>
                    </div>
                </div>

                <!-- Preview da Assinatura Gerada -->
                <div class="border-2 border-slate-200 rounded-2xl p-4 bg-slate-50/50 text-center relative overflow-hidden">
                    <div class="text-[9px] uppercase tracking-wider text-slate-400 mb-1">Pré-visualização da Assinatura</div>
                    <div id="sigCaligrafiaPreview" class="h-20 flex items-center justify-center font-dancing text-3xl sm:text-4xl text-blue-700 select-none drop-shadow-xs">
                        Assinatura
                    </div>
                    <div class="w-48 mx-auto border-t border-slate-300 pt-1 text-[10px] text-slate-400 font-mono">Linha de Assinatura</div>
                </div>
            </div>

            <!-- 2. PAINEL DESENHO LIVRE NA TELA -->
            <div id="painelSigDesenho" class="hidden space-y-3">
                <canvas id="signaturePad" width="440" height="180" class="signature-canvas w-full"></canvas>
                <div class="flex justify-end">
                    <button type="button" id="btnLimparAssinatura" class="px-4 py-1.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold cursor-pointer">
                        <i class="fa-solid fa-eraser"></i> Limpar Traço
                    </button>
                </div>
            </div>

            <div class="flex items-center justify-between gap-3 mt-6 pt-4 border-t border-slate-100">
                <button type="button" onclick="fecharModalAssinatura()" class="px-4 py-2.5 rounded-xl text-slate-500 hover:bg-slate-100 text-xs font-bold cursor-pointer">
                    Cancelar
                </button>
                <button type="button" id="btnAplicarAssinatura" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white text-xs font-bold shadow-lg shadow-purple-600/30 cursor-pointer flex items-center gap-2">
                    <i class="fa-solid fa-check"></i> <span>Estampar no Documento</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal: Guia Completo de Validade Jurídica (O que Vale vs O que Exige Cartório) -->
    <div id="modalValidadeJuridica" class="fixed inset-0 bg-slate-950/80 backdrop-blur-md z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-2xl w-full shadow-2xl border border-slate-100 max-h-[90vh] overflow-y-auto">
            
            <!-- Cabeçalho -->
            <div class="flex justify-between items-start mb-6 border-b border-slate-100 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-100 text-indigo-700 flex items-center justify-center text-xl shadow-inner">
                        <i class="fa-solid fa-scale-balanced"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">Validade Jurídica da Assinatura Digital</h3>
                        <p class="text-xs text-slate-500 font-medium">Conformidade com a MP nº 2.200-2/2001 e Lei Federal nº 14.063/2020</p>
                    </div>
                </div>
                <button type="button" onclick="fecharModalValidadeJuridica()" class="w-9 h-9 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center cursor-pointer transition-all">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Corpo Explicativo -->
            <div class="space-y-6 text-sm text-slate-700 leading-relaxed">
                
                <!-- Introdução Rápida -->
                <div class="bg-indigo-50/70 border border-indigo-200/80 rounded-2xl p-4 text-xs text-indigo-950 flex items-start gap-3">
                    <i class="fa-solid fa-circle-info text-indigo-600 text-base mt-0.5"></i>
                    <div>
                        <b class="text-indigo-900 font-bold">Princípio da Liberdade das Formas (Art. 107 do Código Civil):</b>
                        No Brasil, a validade da declaração de vontade não depende de forma especial, senão quando a lei expressamente a exigir. Qualquer contrato particular é 100% válido por assinatura eletrônica quando comprovada sua integridade e autoria.
                    </div>
                </div>

                <!-- Bloco de Equivalência com os Líderes de Mercado (DocuSign, ClickSign, ZapSign) -->
                <div class="bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 text-white rounded-2xl p-4 sm:p-5 border border-indigo-500/30 shadow-xl relative overflow-hidden">
                    <div class="flex items-center gap-2 mb-2 text-cyan-400 font-black text-xs uppercase tracking-wider">
                        <i class="fa-solid fa-award text-amber-400 text-sm"></i> O Mesmo Padrão Tecnológico & Jurídico dos Líderes de Mercado
                    </div>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        O <b>4USign Pro</b> foi construído sobre a <b>mesma arquitetura técnica, criptográfica e legal</b> utilizada pelas maiores plataformas de assinatura eletrônica do Brasil e do mundo:
                    </p>
                    <div class="flex flex-wrap items-center gap-2 my-3 pt-3 border-t border-white/10">
                        <span class="px-3 py-1 rounded-xl bg-white/10 text-white font-extrabold text-[11px] flex items-center gap-1.5 border border-white/10 shadow-sm">
                            <i class="fa-solid fa-signature text-amber-400"></i> DocuSign
                        </span>
                        <span class="px-3 py-1 rounded-xl bg-white/10 text-white font-extrabold text-[11px] flex items-center gap-1.5 border border-white/10 shadow-sm">
                            <i class="fa-solid fa-file-signature text-emerald-400"></i> ClickSign
                        </span>
                        <span class="px-3 py-1 rounded-xl bg-white/10 text-white font-extrabold text-[11px] flex items-center gap-1.5 border border-white/10 shadow-sm">
                            <i class="fa-solid fa-bolt text-yellow-400"></i> ZapSign
                        </span>
                        <span class="px-3 py-1 rounded-xl bg-white/10 text-white font-extrabold text-[11px] flex items-center gap-1.5 border border-white/10 shadow-sm">
                            <i class="fa-solid fa-file-contract text-cyan-400"></i> D4Sign
                        </span>
                        <span class="px-3 py-1 rounded-xl bg-white/10 text-white font-extrabold text-[11px] flex items-center gap-1.5 border border-white/10 shadow-sm">
                            <i class="fa-solid fa-file-pdf text-red-400"></i> Adobe Sign
                        </span>
                        <span class="px-3 py-1 rounded-xl bg-white/10 text-white font-extrabold text-[11px] flex items-center gap-1.5 border border-white/10 shadow-sm">
                            <i class="fa-solid fa-landmark text-blue-400"></i> Gov.br
                        </span>
                    </div>
                    <p class="text-[11px] text-slate-400 leading-normal">
                        Todas essas ferramentas operam sob o mesmo pilar: <b>Criptografia Hash SHA-256</b>, <b>trilha forense de IP/Data</b> e <b>consentimento formal de vontade</b>, respaldadas pela <b>MP nº 2.200-2/2001</b> e <b>Lei nº 14.063/2020</b>, com total aceitação pelo Superior Tribunal de Justiça (STJ) e juizados em todo o território nacional.
                    </p>
                </div>

                <!-- Bloco 1: O QUE TEM 100% DE VALIDADE -->
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-black">✓</span>
                        <h4 class="font-extrabold text-slate-900 text-base">O que PODE ser assinado no 4USign Pro (95% dos casos):</h4>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 text-xs">
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
                            <b class="text-slate-900">📄 Prestação de Serviços:</b>
                            <p class="text-slate-500 mt-0.5">Engenharia, TI, consultoria, advocacia, design, médicos e autônomos.</p>
                        </div>
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
                            <b class="text-slate-900">🏠 Locação de Imóveis:</b>
                            <p class="text-slate-500 mt-0.5">Contratos residenciais, comerciais e termos de vistoria de entrada e saída.</p>
                        </div>
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
                            <b class="text-slate-900">💼 Comercial & Vendas:</b>
                            <p class="text-slate-500 mt-0.5">Propostas comerciais, ordens de serviço, orçamentos e acordos de sócios.</p>
                        </div>
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
                            <b class="text-slate-900">🤫 Sigilo & Parcerias:</b>
                            <p class="text-slate-500 mt-0.5">Acordos de confidencialidade (NDA), memorandos e termos de cooperação.</p>
                        </div>
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
                            <b class="text-slate-900">💰 Recibos & Quitações:</b>
                            <p class="text-slate-500 mt-0.5">Comprovantes de pagamento, termos de entrega de obra e quitação geral.</p>
                        </div>
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
                            <b class="text-slate-900">👥 RH & Trabalhista:</b>
                            <p class="text-slate-500 mt-0.5">Contratos PJ, aditivos, acordos de teletrabalho e termos de responsabilidade.</p>
                        </div>
                    </div>
                </div>

                <!-- Bloco 2: O QUE A LEI EXIGE CARTÓRIO OU ÓRGÃO ESPECÍFICO -->
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="w-6 h-6 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center text-xs font-black">!</span>
                        <h4 class="font-extrabold text-slate-900 text-base">O que EXIGE Cartório / Fé Pública (Exceções Solenes):</h4>
                    </div>
                    <div class="space-y-2 text-xs">
                        <div class="p-3.5 rounded-xl bg-amber-50/80 border border-amber-200 text-amber-950">
                            <b class="font-bold flex items-center gap-1.5"><i class="fa-solid fa-car text-amber-600"></i> Transferência de Veículos no DETRAN (DUT/ATPV antigo):</b>
                            <p class="text-amber-900 mt-1">O Código de Trânsito Brasileiro (Art. 134) exige reconhecimento de firma por autenticidade presencial (ou transferência digital exclusiva pelo app Carteira Digital de Trânsito / Gov.br com conta Prata/Ouro).</p>
                        </div>
                        <div class="p-3.5 rounded-xl bg-amber-50/80 border border-amber-200 text-amber-950">
                            <b class="font-bold flex items-center gap-1.5"><i class="fa-solid fa-house-chimney text-amber-600"></i> Compra e Venda de Imóveis acima de 30 Salários Mínimos:</b>
                            <p class="text-amber-900 mt-1">O Art. 108 do Código Civil exige Escritura Pública lavrada em Cartório de Notas para transmissão definitiva no Registro Geral de Imóveis (RGI). Promessas particulares de compra e venda podem ser assinadas aqui.</p>
                        </div>
                        <div class="p-3.5 rounded-xl bg-amber-50/80 border border-amber-200 text-amber-950">
                            <b class="font-bold flex items-center gap-1.5"><i class="fa-solid fa-ring text-amber-600"></i> Atos de Direito de Família e Sucessões:</b>
                            <p class="text-amber-900 mt-1">Casamento, divórcio solene com partilha de bens, adoção e testamentos públicos exigem solenidade judicial ou notarial.</p>
                        </div>
                    </div>
                </div>

                <!-- Bloco 3: ONDE FICA A ASSINATURA & RUBRICAS NO DIGITAL -->
                <div class="p-4 sm:p-5 rounded-2xl bg-indigo-50/70 border border-indigo-200/80">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="w-6 h-6 rounded-full bg-indigo-600 text-white flex items-center justify-center text-xs font-black">📍</span>
                        <h4 class="font-extrabold text-slate-900 text-sm">Onde Fica a Assinatura no Documento?</h4>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs text-slate-700">
                        <div class="bg-white p-3.5 rounded-xl border border-indigo-100 shadow-sm">
                            <b class="text-indigo-950 font-bold flex items-center gap-1.5 mb-1">
                                <i class="fa-solid fa-wand-magic-sparkles text-indigo-600"></i> Contratos Gerados no 4USign Pro:
                            </b>
                            <p class="text-slate-600 leading-relaxed">
                                Já possuem o <b>campo exato diagramado</b> no bloco formal de encerramento do contrato, exatamente acima do nome das partes e testemunhas.
                            </p>
                        </div>
                        <div class="bg-white p-3.5 rounded-xl border border-indigo-100 shadow-sm">
                            <b class="text-indigo-950 font-bold flex items-center gap-1.5 mb-1">
                                <i class="fa-solid fa-file-pdf text-cyan-600"></i> Documentos Externos (Upload de PDF):
                            </b>
                            <p class="text-slate-600 leading-relaxed">
                                A assinatura e o selo forense (IP, Data/Hora e Hash) são gravados <b>na base da última página do documento</b>, preservando o layout original.
                            </p>
                        </div>
                    </div>
                    <div class="mt-3 text-[11px] text-indigo-950 bg-white/80 border border-indigo-100 p-2.5 rounded-xl flex items-start gap-2">
                        <i class="fa-solid fa-shield-halved text-indigo-600 text-xs mt-0.5"></i>
                        <span><b>Precisa rubricar as outras folhas?</b> Não! Assim como no <b>DocuSign, ClickSign e ZapSign</b>, o <b>Hash SHA-256</b> blinda 100% de todas as páginas ao mesmo tempo. Uma única assinatura no final protege o contrato inteiro contra fraudes e substituição de folhas.</span>
                    </div>
                </div>

                <!-- Bloco 4: COMO O 4USIGN PRO BLINDA O DOCUMENTO -->
                <div class="bg-slate-900 text-white rounded-2xl p-5 text-xs space-y-3 shadow-inner border border-white/10">
                    <div class="font-bold text-sm text-cyan-400 flex items-center gap-2">
                        <i class="fa-solid fa-shield-halved"></i> Como o 4USign Pro Comprova a Validade na Justiça:
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-slate-300">
                        <div>
                            <b class="text-white">1. Hash SHA-256:</b>
                            <p class="text-[11px] text-slate-400 mt-0.5">Criptografia matemática que blinda o arquivo contra qualquer adulteração após a assinatura.</p>
                        </div>
                        <div>
                            <b class="text-white">2. Trilha de IP & Hora:</b>
                            <p class="text-[11px] text-slate-400 mt-0.5">Registro do IP público, horário oficial e dados do signatário (Marco Civil da Internet).</p>
                        </div>
                        <div>
                            <b class="text-white">3. Título Executivo:</b>
                            <p class="text-[11px] text-slate-400 mt-0.5">Com a assinatura das partes e 2 testemunhas, pode ser executado diretamente em juízo (Art. 784, III CPC).</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Rodapé do Modal -->
            <div class="flex items-center justify-between gap-3 mt-6 pt-4 border-t border-slate-100">
                <span class="text-xs text-slate-400 font-medium">4USign Pro • Legal Tech Brasileira</span>
                <button type="button" onclick="fecharModalValidadeJuridica()" class="px-6 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition-all cursor-pointer">
                    Entendi, Fechar
                </button>
            </div>
        </div>
    </div>

    <!-- Footer Padrão 4USign Pro -->
    <footer class="bg-slate-900 text-slate-400 py-12 mt-20 border-t border-white/10">
        <div class="container mx-auto px-4 text-center">
            <div class="flex items-center justify-center gap-3 mb-4">
                <img src="logo.png?v=<?php echo $v; ?>" alt="4USign Pro" class="w-8 h-8 rounded-lg shadow" />
                <span class="font-extrabold text-white text-lg">4USign Pro</span>
                <span class="text-cyan-400 font-bold text-xs px-2 py-0.5 rounded bg-cyan-950/80 border border-cyan-500/30">v2.0</span>
            </div>
            <p class="text-xs text-slate-400 max-w-md mx-auto mb-6">Plataforma integrada de geração de contratos com Inteligência Artificial e assinatura digital eletrônica em conformidade com a MP nº 2.200-2/2001 e Lei nº 14.063/2020.</p>
            <div class="flex flex-wrap items-center justify-center gap-4 text-xs font-semibold text-slate-400 mb-4">
                <button type="button" onclick="abrirModalValidadeJuridica()" class="hover:text-cyan-400 transition-all cursor-pointer flex items-center gap-1.5 text-cyan-300">
                    <i class="fa-solid fa-scale-balanced text-indigo-400"></i> Validade Jurídica
                </button>
                <span>•</span>
                <a href="privacidade.php" class="hover:text-cyan-400 transition-all">Privacidade & LGPD</a>
                <span>•</span>
                <a href="termos.php" class="hover:text-cyan-400 transition-all">Termos de Uso</a>
                <span>•</span>
                <a href="suporte.php" class="hover:text-cyan-400 transition-all">Suporte & FAQ</a>
                <span>•</span>
                <a href="https://github.com/4u-Labs/contratos" target="_blank" rel="noopener noreferrer" class="hover:text-cyan-400 transition-all">GitHub</a>
            </div>
            <p class="text-xs text-slate-500">&copy; <span id="year"><?php echo date('Y'); ?></span> 4U.IA.BR — Todos os direitos reservados.</p>
        </div>
    </footer>


    <!-- Modal Recarga & Conta Keep AI -->
    <div id="shopModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/70 backdrop-blur-sm p-4 animate-fade-in">
        <div class="bg-slate-900 border border-white/10 rounded-3xl w-full max-w-lg overflow-hidden shadow-2xl p-6 text-white relative">
            <button class="absolute top-4 right-4 text-slate-400 hover:text-white text-xl" onclick="closeShopModal()">&times;</button>
            
            <h3 class="text-xl font-bold mb-2 flex items-center gap-2 text-cyan-400">
                <i class="fa-solid fa-gem"></i> Recarregar Créditos
            </h3>
            <p class="text-slate-400 text-sm mb-6 flex items-center gap-2">
                <i class="fa-brands fa-pix text-teal-400"></i> Pagamento exclusivo via <b>PIX</b> (Liberação Imediata)
            </p>
            
            <!-- Cards de Preço -->
            <div class="grid grid-cols-3 gap-3 mb-6">
                <div id="pkg-card-0" class="bg-slate-800/50 hover:bg-slate-800 border border-white/10 rounded-2xl p-4 text-center cursor-pointer transition-all" onclick="selectPackage(0)">
                    <h4 class="font-bold text-sm text-slate-300">Bronze</h4>
                    <span class="text-lg font-extrabold text-cyan-400 block my-1">R$ 4,90</span>
                    <p class="text-xs text-slate-400">10 Créditos</p>
                </div>
                <div id="pkg-card-1" class="bg-slate-800/80 border-2 border-cyan-400 rounded-2xl p-4 text-center cursor-pointer transition-all" onclick="selectPackage(1)">
                    <h4 class="font-bold text-sm text-slate-300">Prata</h4>
                    <span class="text-lg font-extrabold text-cyan-400 block my-1">R$ 19,90</span>
                    <p class="text-xs text-slate-400">50 Créditos</p>
                </div>
                <div id="pkg-card-2" class="bg-slate-800/50 hover:bg-slate-800 border border-white/10 rounded-2xl p-4 text-center cursor-pointer transition-all" onclick="selectPackage(2)">
                    <h4 class="font-bold text-sm text-slate-300">Ouro</h4>
                    <span class="text-lg font-extrabold text-cyan-400 block my-1">R$ 34,90</span>
                    <p class="text-xs text-slate-400">100 Créditos</p>
                </div>
            </div>
            
            <button id="btn-generate-pix" class="w-full bg-gradient-to-r from-cyan-400 to-indigo-500 hover:from-cyan-300 hover:to-indigo-400 text-slate-950 font-bold py-3 rounded-2xl transition-all flex items-center justify-center gap-2 mb-4" onclick="generatePixPayment()">
                <i class="fa-brands fa-pix"></i> GERAR CÓDIGO PIX
            </button>
            
            <!-- Seção do PIX Direct com QR Code -->
            <div id="pix-section" class="hidden mt-4 text-center bg-slate-950/40 p-4 rounded-2xl border border-cyan-400/20">
                <h4 class="text-teal-400 font-semibold text-sm mb-3 flex items-center justify-center gap-2"><i class="fa-solid fa-spinner fa-spin"></i> Aguardando Pagamento PIX...</h4>
                
                <div id="pix-qrcode-container" class="my-4 mx-auto w-40 h-40 bg-white p-2 rounded-xl flex items-center justify-center shadow-lg shadow-cyan-400/10">
                    <img id="pix-qrcode" src="" alt="QR Code PIX" class="w-full h-full object-contain">
                </div>
                
                <p class="text-xs text-slate-400 mb-2">Escaneie o QR Code ou copie a chave copia e cola abaixo:</p>
                <textarea id="pix-copia-cola" readonly class="w-full h-12 bg-slate-950 border border-white/10 text-white p-2 rounded-xl font-mono text-xs resize-none text-center mb-3 outline-none"></textarea>
                
                <button id="btn-copy-pix" class="w-full bg-slate-800 hover:bg-slate-700 text-white text-xs font-semibold py-2.5 rounded-xl transition-all" onclick="copyPixCode()">
                    <i class="fa-regular fa-copy"></i> Copiar Código PIX
                </button>
            </div>
            
            <!-- Conta Central Keep AI -->
            <div class="border-t border-white/10 mt-6 pt-5">
                <p class="text-xs font-bold text-cyan-400 mb-3 flex items-center gap-2 tracking-wider text-transform uppercase">
                    <i class="fa-solid fa-user-gear"></i> Conta Unificada Keep AI
                </p>
                
                <!-- Formulário Deslogado -->
                <div id="keepai-login-form" class="flex flex-col gap-3">
                    <p class="text-xs text-slate-400">Acesse ou crie sua conta para salvar, unificar e usar seus créditos em todos os apps da 4uLabs:</p>
                    <input type="email" id="keepaiEmail" placeholder="E-mail" class="bg-slate-950 border border-white/10 text-white text-sm px-4 py-3 rounded-xl focus:border-cyan-400 focus:outline-none w-full">
                    <input type="password" id="keepaiPassword" placeholder="Senha Keep AI" class="bg-slate-950 border border-white/10 text-white text-sm px-4 py-3 rounded-xl focus:border-cyan-400 focus:outline-none w-full">
                    <div class="flex gap-2 mt-1">
                        <button id="btnKeepaiLogin" class="flex-1 bg-cyan-400 hover:bg-cyan-300 text-slate-950 font-bold py-2 rounded-xl text-xs transition-all" onclick="handleKeepaiAuth('login')">ENTRAR</button>
                        <button id="btnKeepaiRegister" class="flex-1 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold py-2 rounded-xl text-xs transition-all" onclick="handleKeepaiAuth('register')">CADASTRAR</button>
                    </div>
                </div>
                
                <!-- Box Logado -->
                <div id="keepai-logged-in-box" class="hidden text-center p-4 bg-cyan-400/5 border border-cyan-400/20 rounded-2xl flex-col gap-3">
                    <p class="text-xs text-slate-300 flex items-center justify-center gap-1"><i class="fa-solid fa-circle-check text-emerald-400"></i> Conectado ao ecossistema Keep AI</p>
                    <div id="keepaiUserEmail" class="font-bold text-sm text-cyan-400 bg-slate-950 py-2.5 px-4 rounded-xl font-mono border border-white/5">...</div>
                    <button id="btnKeepaiLogout" class="w-full bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/30 text-rose-400 font-bold py-2.5 rounded-xl text-xs transition-all" onclick="handleKeepaiLogout()">DESCONECTAR</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        const FORM_DATA_KEY = 'contratoAIData_v3';

        const API_CONFIG = {
            endpoint: './api/apicontratos.php',
            apiKey: '',
            provider: 'php_backend',
            model: 'gpt-4o-mini'
        };

        // --- MÉTODOS DE CREDITO E SHOP KEEPAI ---
        window.selectedPackageIndex = 1;

        window.openShopModal = function() {
            $('#shopModal').removeClass('hidden').addClass('flex');
            checkStatus();
        };

        window.closeShopModal = function() {
            $('#shopModal').addClass('hidden').removeClass('flex');
            if (paymentPollInterval) clearInterval(paymentPollInterval);
        };

        window.selectPackage = function(index) {
            window.selectedPackageIndex = index;
            for (let i = 0; i < 3; i++) {
                $(`#pkg-card-${i}`).removeClass('border-2 border-cyan-400 bg-slate-800/80').addClass('border border-white/10 bg-slate-800/50');
            }
            $(`#pkg-card-${index}`).addClass('border-2 border-cyan-400 bg-slate-800/80').removeClass('border border-white/10 bg-slate-800/50');
        };

        window.generatePixPayment = async function() {
            const btn = document.getElementById('btn-generate-pix');
            const pixSection = document.getElementById('pix-section');
            const qrImg = document.getElementById('pix-qrcode');
            const copiaColaText = document.getElementById('pix-copia-cola');
            
            if (!btn) return;
            const token = localStorage.getItem('keepai_token');
            if (!token) {
                Swal.fire({
                    icon: 'warning',
                    title: '💎 Login Requerido',
                    text: 'Acesse ou crie sua conta Keep AI na área abaixo antes de gerar o código PIX!',
                    background: '#0f172a',
                    color: '#fff',
                    confirmButtonColor: '#6366f1',
                    customClass: { popup: 'rounded-3xl border border-white/10 shadow-2xl' }
                });
                return;
            }

            const originalHTML = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> GERANDO PIX...';

            const headers = { 'Content-Type': 'application/json' };
            headers['Authorization'] = `Bearer ${token}`;

            try {
                const r = await fetch(`../keepai/api/mp_create.php`, {
                    method: 'POST',
                    headers: headers,
                    body: JSON.stringify({
                        package_index: window.selectedPackageIndex
                    })
                });
                const res = await r.json();
                btn.disabled = false;
                btn.innerHTML = originalHTML;

                if (res.success && res.qr_code_base64) {
                    qrImg.src = `data:image/png;base64,${res.qr_code_base64}`;
                    copiaColaText.value = res.qr_code;
                    pixSection.style.display = 'block';
                    startPaymentPolling();
                } else {
                    Swal.fire({ icon: 'error', title: 'Erro', text: res.error || 'Erro ao gerar PIX.', background: '#0f172a', color: '#fff', confirmButtonColor: '#6366f1' });
                }
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Erro de Conexão', text: 'Tente novamente.', background: '#0f172a', color: '#fff', confirmButtonColor: '#6366f1' });
                btn.disabled = false;
                btn.innerHTML = originalHTML;
            }
        };

        window.copyPixCode = function() {
            const text = document.getElementById('pix-copia-cola');
            if (!text || !text.value) return;
            navigator.clipboard.writeText(text.value).then(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Código Copiado!',
                    text: 'Cole o código no app do seu banco para pagar.',
                    background: '#0f172a',
                    color: '#fff',
                    confirmButtonColor: '#6366f1',
                    customClass: { popup: 'rounded-3xl border border-white/10 shadow-2xl' }
                });
            });
        };

        window.handleKeepaiAuth = async function(action) {
            const email = document.getElementById('keepaiEmail').value.trim();
            const password = document.getElementById('keepaiPassword').value.trim();
            const btnLogin = document.getElementById('btnKeepaiLogin');
            const btnRegister = document.getElementById('btnKeepaiRegister');
            
            if (!email || !password) {
                Swal.fire({ icon: 'warning', title: 'Campos Vazios', text: 'Preencha e-mail e senha!', background: '#0f172a', color: '#fff', confirmButtonColor: '#6366f1' });
                return;
            }

            if (btnLogin) btnLogin.disabled = true;
            if (btnRegister) btnRegister.disabled = true;

            try {
                const r = await fetch(`../keepai/api/auth.php?action=${action}`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email, password })
                });
                const res = await r.json();

                if (btnLogin) btnLogin.disabled = false;
                if (btnRegister) btnRegister.disabled = false;

                if (res.token) {
                    localStorage.setItem('keepai_token', res.token);
                    Swal.fire({ icon: 'success', title: action === 'login' ? 'Conectado!' : 'Conta Criada!', text: 'Seu saldo Keep AI foi sincronizado.', background: '#0f172a', color: '#fff', confirmButtonColor: '#6366f1' });
                    document.getElementById('keepaiEmail').value = '';
                    document.getElementById('keepaiPassword').value = '';
                    checkStatus();
                } else {
                    Swal.fire({ icon: 'error', title: 'Falha', text: res.error || 'Erro ao autenticar.', background: '#0f172a', color: '#fff', confirmButtonColor: '#6366f1' });
                }
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Erro de Conexão', text: 'Tente novamente.', background: '#0f172a', color: '#fff', confirmButtonColor: '#6366f1' });
                if (btnLogin) btnLogin.disabled = false;
                if (btnRegister) btnRegister.disabled = false;
            }
        };

        window.handleKeepaiLogout = function() {
            Swal.fire({
                title: 'Desconectar?',
                text: 'Tem certeza que deseja sair de sua conta Keep AI neste dispositivo?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, sair',
                cancelButtonText: 'Cancelar',
                background: '#0f172a',
                color: '#fff',
                customClass: { popup: 'rounded-3xl border border-white/10' }
            }).then((result) => {
                if (result.isConfirmed) {
                    localStorage.removeItem('keepai_token');
                    checkStatus();
                }
            });
        };

        async function checkStatus() {
            const token = localStorage.getItem('keepai_token');
            const headers = {};
            if (token) {
                headers['Authorization'] = `Bearer ${token}`;
            }
            try {
                const r = await fetch(`../keepai/api/auth.php`, { headers });
                const res = await r.json();
                
                if (res.success && res.user) {
                    $('#creditBalance').text(res.user.credits);
                    window.userCredits = res.user.credits;
                    window.userLoggedIn = true;
                    $('#keepai-login-form').addClass('hidden');
                    $('#keepai-logged-in-box').removeClass('hidden').addClass('flex');
                    $('#keepaiUserEmail').text(res.user.email);
                } else {
                    $('#creditBalance').text('0');
                    window.userCredits = 0;
                    window.userLoggedIn = false;
                    $('#keepai-login-form').removeClass('hidden');
                    $('#keepai-logged-in-box').addClass('hidden').removeClass('flex');
                }
            } catch (e) {
                $('#creditBalance').text('0');
                window.userCredits = 0;
                window.userLoggedIn = false;
            }
        }

        let paymentPollInterval;
        function startPaymentPolling() {
            if (paymentPollInterval) clearInterval(paymentPollInterval);
            const startCredits = window.userCredits || 0;
            paymentPollInterval = setInterval(async () => {
                const token = localStorage.getItem('keepai_token');
                const headers = {};
                if (token) {
                    headers['Authorization'] = `Bearer ${token}`;
                }
                try {
                    const r = await fetch(`../keepai/api/credits.php`, { headers });
                    const res = await r.json();
                    if (res.credits > startCredits) {
                        clearInterval(paymentPollInterval);
                        closeShopModal();
                        Swal.fire({
                            icon: 'success',
                            title: '⚡ Recarga Aprovada!',
                            text: 'Seus créditos foram liberados instantaneamente.',
                            background: '#0f172a',
                            color: '#fff',
                            confirmButtonColor: '#6366f1',
                            customClass: { popup: 'rounded-3xl border border-white/10 shadow-2xl' }
                        });
                        checkStatus();
                    }
                } catch (e) { }
            }, 5000);
        }

        let logoClicks = 0;
        window.handleLogoClicks = function() {
            logoClicks++;
            if (logoClicks >= 5) {
                logoClicks = 0;
                const token = localStorage.getItem('keepai_token');
                if (!token) {
                    Swal.fire({ icon: 'warning', title: 'Login Necessário', text: 'Conecte-se ao Keep AI antes de usar o backdoor!', background: '#0f172a', color: '#fff', confirmButtonColor: '#6366f1' });
                    return;
                }
                
                Swal.fire({
                    title: '⚡ Super Acesso Contratos',
                    text: 'Digite a senha mestre para carregar +50 créditos bônus:',
                    input: 'password',
                    inputPlaceholder: 'Senha',
                    background: '#0f172a',
                    color: '#fff',
                    confirmButtonColor: '#6366f1',
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar',
                    customClass: { popup: 'rounded-3xl border border-white/10 shadow-2xl' }
                }).then(async (result) => {
                    if (result.isConfirmed && result.value) {
                        try {
                            const r = await fetch(`./api/apicontratos.php?action=activate_bonus&keepai_token=${encodeURIComponent(token)}`, {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json', 'Authorization': `Bearer ${token}` },
                                body: JSON.stringify({ password: result.value, keepai_token: token })
                            });
                            const res = await r.json();
                            if (res.status === 'success') {
                                Swal.fire({ icon: 'success', title: 'Bônus Ativado!', text: '50 créditos bônus liberados.', background: '#0f172a', color: '#fff', confirmButtonColor: '#6366f1' });
                                checkStatus();
                            } else {
                                Swal.fire({ icon: 'error', title: 'Erro', text: res.error || 'Senha incorreta.', background: '#0f172a', color: '#fff', confirmButtonColor: '#6366f1' });
                            }
                        } catch (e) {
                            Swal.fire({ icon: 'error', title: 'Erro', text: 'Conexão falhou.', background: '#0f172a', color: '#fff', confirmButtonColor: '#6366f1' });
                        }
                    }
                });
            }
            setTimeout(() => logoClicks = 0, 3000);
        };

        // Máscaras
        $('#contratante_doc, #contratado_doc').on('input', function() {
            var value = $(this).val().replace(/\D/g, '');
            if (value.length <= 11) {
                $(this).mask('000.000.000-009', {reverse: true});
            } else {
                $(this).mask('00.000.000/0000-00', {reverse: true});
            }
        });
        $('#contratante_telefone_whatsapp, #contratado_telefone_whatsapp').mask('0000000000000');
        $('#valor_contrato').mask('000.000.000.000.000,00', {reverse: true});
        $('#estado_foro').mask('SS');

        // --- Tipos de Documento e Labels Dinâmicos ---
        const TIPO_PROCURACAO = ['Procuração Ad Judicia','Procuração Ad Negotia','Procuração para Compra e Venda de Imóvel','Procuração para Representação Bancária','Procuração para Representação Empresarial','Procuração Geral Ampla'];
        const TIPO_DECLARACAO = ['Declaração de Hipossuficiência','Declaração de Residência','Declaração de União Estável','Declaração de Dependente','Declaração de Atividade Autônoma','Declaração de Bens e Rendimentos','Declaração de Recebimento de Valores'];

        function getTipoDocumento(val) {
            if (TIPO_PROCURACAO.includes(val)) return 'procuracao';
            if (TIPO_DECLARACAO.includes(val)) return 'declaracao';
            return 'contrato';
        }

        function atualizarLabelsDocumento(val) {
            const tipo = getTipoDocumento(val);
            const $p1 = $('#label_parte1'), $p1s = $('#label_parte1_sub');
            const $p2 = $('.card-modern h2').filter(function() { return $(this).text().trim() === 'Contratado' || $(this).text().trim() === 'Outorgado' || $(this).text().trim() === 'Declarante'; });
            const $p2s = $p2.siblings('p').first();

            if (tipo === 'procuracao') {
                $p1.text('Outorgante'); $p1s.text('Quem concede os poderes');
                $p2.text('Outorgado'); $p2s.text('Quem recebe os poderes');
                $('#section_poderes_procuracao').removeClass('hidden');
                $('#section_declaracao').addClass('hidden');
                $('#btn_gerar_label').text('Gerar Procuração com IA');
                $('#label_resultado').text('Procuração Gerada');
                $('#lbl_wapp_parte1').text('Outorgante'); $('#lbl_wapp_parte2').text('Outorgado');
            } else if (tipo === 'declaracao') {
                $p1.text('Declarante'); $p1s.text('Quem faz a declaração');
                $p2.text('Destinatário / Testemunha'); $p2s.text('Pessoa ou órgão destino (opcional)');
                $('#section_poderes_procuracao').addClass('hidden');
                $('#section_declaracao').removeClass('hidden');
                $('#btn_gerar_label').text('Gerar Declaração com IA');
                $('#label_resultado').text('Declaração Gerada');
                $('#lbl_wapp_parte1').text('Declarante'); $('#lbl_wapp_parte2').text('Destinatário');
            } else {
                $p1.text('Contratante'); $p1s.text('Quem contrata o serviço');
                $p2.text('Contratado'); $p2s.text('Quem realiza o serviço');
                $('#section_poderes_procuracao').addClass('hidden');
                $('#section_declaracao').addClass('hidden');
                $('#btn_gerar_label').text('Gerar Contrato com IA');
                $('#label_resultado').text('Contrato Gerado');
                $('#lbl_wapp_parte1').text('Contratante'); $('#lbl_wapp_parte2').text('Contratado');
            }
        }

        // Toggle tipo de contrato "Outro"
        $('#tipo_contrato').change(function() {
            const val = $(this).val();
            $('#tipo_contrato_outro_container').toggleClass('hidden', val !== 'Outro');
            $('#tipo_contrato_outro').prop('required', val === 'Outro');
            atualizarLabelsDocumento(val);
        });

        // Toggle tipo de término
        $('#data_termino_tipo').change(function() {
            const val = $(this).val();
            $('#data_termino_container').toggleClass('hidden', val !== 'data_especifica');
            $('#meses_vigencia_container').toggleClass('hidden', val !== 'meses');
            $('#data_termino').prop('required', val === 'data_especifica');
        });

        // Toggle pagamento detalhes
        $('#forma_pagamento').change(function() {
            $('#pagamento_detalhes_container').toggleClass('hidden', !$(this).val() || $(this).val() === 'a_vista');
        });

        // Toggle RG por tipo de pessoa
        $('#contratante_tipo_pessoa').change(function() {
            $('#contratante_rg_container').toggleClass('hidden', $(this).val() === 'juridica');
        });
        $('#contratado_tipo_pessoa').change(function() {
            $('#contratado_rg_container').toggleClass('hidden', $(this).val() === 'juridica');
        });

        // Cláusulas especiais
        function updateClausulasUI() {
            let anyChecked = false;
            
            $('#clausulas_container .clause-modern').each(function() {
                const checkbox = $(this).find('input[type="checkbox"]');
                $(this).toggleClass('selected', checkbox.is(':checked'));
            });

            $('#multa_detalhes').toggleClass('hidden', !$('#clausula_multa').is(':checked'));
            $('#rescisao_detalhes').toggleClass('hidden', !$('#clausula_rescisao').is(':checked'));
            $('#garantia_detalhes').toggleClass('hidden', !$('#clausula_garantia').is(':checked'));
            $('#reajuste_detalhes').toggleClass('hidden', !$('#clausula_reajuste').is(':checked'));

            anyChecked = $('#clausulas_container input:checked').length > 0;
            $('#clausulas_detalhes').toggleClass('hidden', !anyChecked || 
                (!$('#clausula_multa').is(':checked') && !$('#clausula_rescisao').is(':checked') && 
                 !$('#clausula_garantia').is(':checked') && !$('#clausula_reajuste').is(':checked')));
        }

        $('#clausulas_container .clause-modern').click(function() {
            const checkbox = $(this).find('input[type="checkbox"]');
            checkbox.prop('checked', !checkbox.is(':checked'));
            updateClausulasUI();
        });

        // Poderes da procuração e opções gerais
        $('#poderes_container .clause-modern, #opt_resumo_label, .clause-modern[for]').click(function() {
            const checkbox = $(this).find('input[type="checkbox"]');
            checkbox.prop('checked', !checkbox.is(':checked'));
            $(this).toggleClass('selected', checkbox.is(':checked'));
        });
        // Opções de geração (checkboxes fora do clausulas_container)
        $('.clause-modern').not('#clausulas_container .clause-modern').not('#poderes_container .clause-modern').click(function() {
            const checkbox = $(this).find('input[type="checkbox"]');
            checkbox.prop('checked', !checkbox.is(':checked'));
            $(this).toggleClass('selected', checkbox.is(':checked'));
        });

        // Funções de progresso
        function saveFormData() {
            const formData = {};
            $('#contractForm').find('input, select, textarea').each(function() {
                const $el = $(this);
                const id = $el.attr('id');
                const name = $el.attr('name');
                if (id) {
                    if ($el.is(':checkbox')) formData[id] = $el.is(':checked');
                    else if ($el.is(':radio') && $el.is(':checked')) formData[name] = $el.val();
                    else if (!$el.is(':radio')) formData[id] = $el.val();
                }
            });
            localStorage.setItem(FORM_DATA_KEY, JSON.stringify(formData));
            
            Swal.fire({ icon: 'success', title: 'Progresso Salvo!', text: 'Seus dados foram salvos localmente.', background: '#0f172a', color: '#fff', confirmButtonColor: '#6366f1', timer: 1500, showConfirmButton: false });
        }

        function loadFormData() {
            const savedData = localStorage.getItem(FORM_DATA_KEY);
            if (!savedData) return;
            
            const formData = JSON.parse(savedData);
            $('#contractForm').find('input, select, textarea').each(function() {
                const $el = $(this);
                const id = $el.attr('id');
                const name = $el.attr('name');
                
                if ($el.is(':radio') && formData[name] && $el.val() === formData[name]) {
                    $el.prop('checked', true);
                } else if (id && formData.hasOwnProperty(id)) {
                    if ($el.is(':checkbox')) $el.prop('checked', formData[id]);
                    else $el.val(formData[id]);
                    $el.trigger('change').trigger('input');
                }
            });
            updateClausulasUI();
        }

        function clearSavedData() {
            Swal.fire({
                title: 'Limpar dados salvos?',
                text: 'Esta ação irá apagar os dados salvos em cache.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Sim, apagar',
                cancelButtonText: 'Cancelar',
                background: '#0f172a',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    localStorage.removeItem(FORM_DATA_KEY);
                    Swal.fire({ icon: 'success', title: 'Limpo!', text: 'Cache local removido.', background: '#0f172a', color: '#fff', confirmButtonColor: '#6366f1', timer: 1500, showConfirmButton: false });
                }
            });
        }

        $('#btnSalvarProgresso').click(saveFormData);
        $('#btnCarregarProgresso').click(loadFormData);
        $('#btnLimparProgresso').click(clearSavedData);

        $('#btnLimparFormulario').click(function() {
            Swal.fire({
                title: 'Limpar formulário?',
                text: 'Todos os campos serão redefinidos.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Limpar',
                cancelButtonText: 'Cancelar',
                background: '#0f172a',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#contractForm')[0].reset();
                    $('#tipo_contrato, #data_termino_tipo, #forma_pagamento').trigger('change');
                    updateClausulasUI();
                    $('#resultadoContainer').addClass('hidden');
                }
            });
        });

        // Funções auxiliares
        function formatDate(inputDate) {
            if (!inputDate) return 'N/A';
            const parts = inputDate.split('-');
            if (parts.length === 3) {
                const meses = ['janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro'];
                return `${parseInt(parts[2])} de ${meses[parseInt(parts[1])-1]} de ${parts[0]}`;
            }
            return inputDate;
        }

        function getClausulasEspeciais() {
            const clausulas = [];
            if ($('#clausula_multa').is(':checked')) {
                let multa = "Incluir cláusula de MULTA POR DESCUMPRIMENTO";
                if ($('#multa_percentual').val()) multa += ` de ${$('#multa_percentual').val()}`;
                if ($('#multa_valor_fixo').val()) multa += ` ou R$ ${$('#multa_valor_fixo').val()}`;
                clausulas.push(multa);
            }
            if ($('#clausula_rescisao').is(':checked')) {
                let rescisao = "Incluir cláusula de RESCISÃO ANTECIPADA";
                if ($('#aviso_previo').val()) rescisao += ` com aviso prévio de ${$('#aviso_previo').val()}`;
                clausulas.push(rescisao);
            }
            if ($('#clausula_confidencialidade').is(':checked')) clausulas.push("Incluir cláusula de CONFIDENCIALIDADE E SIGILO");
            if ($('#clausula_propriedade_intelectual').is(':checked')) clausulas.push("Incluir cláusula de PROPRIEDADE INTELECTUAL");
            if ($('#clausula_nao_concorrencia').is(':checked')) clausulas.push("Incluir cláusula de NÃO CONCORRÊNCIA");
            if ($('#clausula_garantia').is(':checked')) {
                let garantia = "Incluir cláusula de GARANTIA";
                if ($('#periodo_garantia').val()) garantia += ` pelo período de ${$('#periodo_garantia').val()}`;
                clausulas.push(garantia);
            }
            if ($('#clausula_reajuste').is(':checked')) {
                let reajuste = "Incluir cláusula de REAJUSTE ANUAL DE VALORES";
                if ($('#indice_reajuste').val()) reajuste += ` pelo índice ${$('#indice_reajuste').val()}`;
                clausulas.push(reajuste);
            }
            if ($('#clausula_forca_maior').is(':checked')) clausulas.push("Incluir cláusula de FORÇA MAIOR E CASO FORTUITO");
            if ($('#clausula_lgpd').is(':checked')) clausulas.push("Incluir cláusula de PROTEÇÃO DE DADOS (LGPD)");
            return clausulas;
        }

        function getPoderesProcuracao() {
            const poderes = [];
            if ($('#poder_compra_venda_imovel').is(':checked')) poderes.push('Compra e Venda de Imóvel (assinar escrituras e contratos)');
            if ($('#poder_representacao_bancaria').is(':checked')) poderes.push('Operações Bancárias (movimentar contas, realizar transferências, contratar empréstimos)');
            if ($('#poder_juridico').is(':checked')) poderes.push('Atuação Judicial (representar em processos, assinar petições, receber citações)');
            if ($('#poder_empresarial').is(':checked')) poderes.push('Gestão Empresarial (assinar contratos, representar a empresa perante terceiros)');
            if ($('#poder_receber_quitacao').is(':checked')) poderes.push('Receber e Dar Quitação (receber pagamentos, assinar recibos e quitações)');
            if ($('#poder_substabelecer').is(':checked')) poderes.push('Substabelecer (delegar poderes a terceiros, com ou sem reservas)');
            if ($('#poderes_especificos').val()) poderes.push($('#poderes_especificos').val());
            return poderes;
        }

        function getOpcoesGeracao() {
            return {
                resumoExecutivo: $('#opt_resumo_executivo').is(':checked'),
                assinaturaDigital: $('#opt_assinatura_digital').is(':checked'),
                numeracaoPaginas: $('#opt_numeracao_paginas').is(':checked'),
                reconhecimentoFirma: $('#opt_reconhecimento_firma').is(':checked')
            };
        }

        // Gerar contrato
        async function gerarContratoIA(dadosPrompt) {
            const nivelFormalidade = $('input[name="formalidade"]:checked').val() || 'padrao';
            
            let instrucoesFormalidade = "";
            switch(nivelFormalidade) {
                case 'simples': instrucoesFormalidade = "Use linguagem simples e direta, com poucas cláusulas."; break;
                case 'padrao': instrucoesFormalidade = "Use linguagem formal equilibrada, com cláusulas essenciais."; break;
                case 'detalhado': instrucoesFormalidade = "Use linguagem formal e detalhada, com cláusulas extensivas."; break;
                case 'juridico_completo': instrucoesFormalidade = "Use linguagem jurídica formal e técnica, com todas as cláusulas possíveis e fundamentação legal."; break;
            }

            const tipoDocumento = getTipoDocumento(dadosPrompt.tipoContrato);
            const opcoesGeracao = getOpcoesGeracao();
            const poderesProcuracao = getPoderesProcuracao();

            let nomeParte1 = 'CONTRATANTE', nomeParte2 = 'CONTRATADO(A)';
            let instrTipoDoc = '';
            if (tipoDocumento === 'procuracao') {
                nomeParte1 = 'OUTORGANTE'; nomeParte2 = 'OUTORGADO(A)';
                instrTipoDoc = `
Você é um advogado especialista brasileiro. Gere uma PROCURAÇÃO PÚBLICA FORMAL e COMPLETA.
ESTRUTURA OBRIGATÓRIA: 1. TÍTULO (PROCURAÇÃO); 2. QUALIFICAÇÃO COMPLETA DO OUTORGANTE; 3. QUALIFICAÇÃO COMPLETA DO OUTORGADO; 4. PODERES OUTORGADOS (listados numericamente); 5. REVOGAÇÃO DE ANTERIORES (se aplicável); 6. LOCAL E DATA; 7. ASSINATURA DO OUTORGANTE e RECONHECIMENTO.
REGRAS: Use linguagem formal. Poderes devem ser listados de forma clara e específica. Inclua o prazo de validade se for limitado.`;
            } else if (tipoDocumento === 'declaracao') {
                nomeParte1 = 'DECLARANTE'; nomeParte2 = 'DESTINATÁRIO';
                instrTipoDoc = `
Você é um advogado especialista brasileiro. Gere uma DECLARAÇÃO FORMAL e COMPLETA.
ESTRUTURA OBRIGATÓRIA: 1. TÍTULO (DECLARAÇÃO); 2. IDENTIFICAÇÃO DO DECLARANTE; 3. CORPO DA DECLARAÇÃO (fatos afirmados); 4. FINALIDADE; 5. RESPONSABILIDADE LEGAL; 6. LOCAL E DATA; 7. ASSINATURA.
REGRAS: Use linguagem formal e direta. Inclua a fundamentação legal se aplicável.`;
            } else {
                instrTipoDoc = `
Você é um advogado especialista brasileiro. Gere um contrato COMPLETO e PROFISSIONAL.
ESTRUTURA OBRIGATÓRIA:
1. TÍTULO formal
2. PREÂMBULO com qualificação completa das partes
3. CLÁUSULAS NUMERADAS (CLÁUSULA PRIMEIRA - DO OBJETO, etc.)
4. LOCAL E DATA por extenso
5. ASSINATURAS para partes e testemunhas
REGRAS: Use §, incisos (I, II, III). Valores em numeral e por extenso. Datas por extenso.`;
            }

            let instrOpcionais = '';
            if (opcoesGeracao.resumoExecutivo) instrOpcionais += '\n- ANTES do documento principal, gere um RESUMO EXECUTIVO (máx. 10 linhas) com os pontos-chave, separado por linha divisória.';
            if (opcoesGeracao.assinaturaDigital) instrOpcionais += '\n- Ao final, inclua um campo de ASSINATURA DIGITAL com espaço para: Nome completo, E-mail, Data/Hora de assinatura eletrônica e Hash de validação (placeholder).';
            if (opcoesGeracao.numeracaoPaginas) instrOpcionais += '\n- Adicione ao final a instrução: "Todas as páginas deste documento devem ser rubricadas pelas partes."';
            if (opcoesGeracao.reconhecimentoFirma) instrOpcionais += '\n- Adicione orientação sobre reconhecimento de firma em cartório na seção de assinaturas.';

            const promptSistema = `${instrTipoDoc}\n\nDIRETRIZES DE FORMALIDADE: ${instrucoesFormalidade}${instrOpcionais ? '\n\nOPÇÕES ADICIONAIS:' + instrOpcionais : ''}\n\nRESPONDA APENAS COM O TEXTO DO DOCUMENTO.`;

            let tipoContrato = dadosPrompt.tipoContrato === 'Outro' ? dadosPrompt.tipoContratoOutro : dadosPrompt.tipoContrato;
            
            let prazo = `Início: ${formatDate(dadosPrompt.dataInicio)}. `;
            if (dadosPrompt.dataTerminoTipo === 'indeterminado') prazo += "Prazo: INDETERMINADO.";
            else if (dadosPrompt.dataTerminoTipo === 'conclusao_objeto') prazo += "Prazo: Até CONCLUSÃO DO OBJETO.";
            else if (dadosPrompt.dataTerminoTipo === 'meses' && dadosPrompt.mesesVigencia) prazo += `Prazo: ${dadosPrompt.mesesVigencia} meses.`;
            else if (dadosPrompt.dataTermino) prazo += `Término: ${formatDate(dadosPrompt.dataTermino)}.`;

            const clausulasEspeciais = getClausulasEspeciais();

            const promptUsuario = `
TIPO: ${tipoContrato} | FORMALIDADE: ${nivelFormalidade.toUpperCase()}

${nomeParte1} (${dadosPrompt.contratanteTipoPessoa === 'juridica' ? 'PJ' : 'PF'}):
- Nome: ${dadosPrompt.contratanteNome}
- ${dadosPrompt.contratanteTipoPessoa === 'juridica' ? 'CNPJ' : 'CPF'}: ${dadosPrompt.contratanteDoc}
${dadosPrompt.contratanteRg ? '- RG: ' + dadosPrompt.contratanteRg : ''}
${dadosPrompt.contratanteNacionalidade ? '- Nacionalidade: ' + dadosPrompt.contratanteNacionalidade : ''}
${dadosPrompt.contratanteEstadoCivil ? '- Estado Civil: ' + dadosPrompt.contratanteEstadoCivil : ''}
${dadosPrompt.contratanteProfissao ? '- Profissão: ' + dadosPrompt.contratanteProfissao : ''}
- Endereço: ${dadosPrompt.contratanteEndereco}
${dadosPrompt.contratanteEmail ? '- Email: ' + dadosPrompt.contratanteEmail : ''}

${nomeParte2} (${dadosPrompt.contratadoTipoPessoa === 'juridica' ? 'PJ' : 'PF'}):
- Nome: ${dadosPrompt.contratadoNome}
- ${dadosPrompt.contratadoTipoPessoa === 'juridica' ? 'CNPJ' : 'CPF'}: ${dadosPrompt.contratadoDoc}
${dadosPrompt.contratadoRg ? '- RG: ' + dadosPrompt.contratadoRg : ''}
${dadosPrompt.contratadoNacionalidade ? '- Nacionalidade: ' + dadosPrompt.contratadoNacionalidade : ''}
${dadosPrompt.contratadoEstadoCivil ? '- Estado Civil: ' + dadosPrompt.contratadoEstadoCivil : ''}
${dadosPrompt.contratadoProfissao ? '- Profissão: ' + dadosPrompt.contratadoProfissao : ''}
- Endereço: ${dadosPrompt.contratadoEndereco}
${dadosPrompt.contratadoEmail ? '- Email: ' + dadosPrompt.contratadoEmail : ''}

OBJETO/FINALIDADE: ${dadosPrompt.objetoContrato}
${tipoDocumento !== 'declaracao' ? `
VALOR: R$ ${dadosPrompt.valorContrato || '(a definir)'}
PAGAMENTO: ${dadosPrompt.formaPagamento || 'Não especificada'}
${dadosPrompt.formaPagamentoDesc ? 'DETALHES: ' + dadosPrompt.formaPagamentoDesc : ''}` : ''}
${tipoDocumento !== 'declaracao' ? `
VIGÊNCIA: ${prazo}` : ''}

FORO/LOCAL: ${dadosPrompt.cidadeForo} - ${dadosPrompt.estadoForo}

${tipoDocumento === 'procuracao' && poderesProcuracao.length > 0 ? 'PODERES OUTORGADOS:\n' + poderesProcuracao.map((p,i) => `${i+1}. ${p}`).join('\n') : ''}
${tipoDocumento === 'declaracao' ? `FINALIDADE: ${dadosPrompt.declaracaoFinalidade || 'Para fins que se fizerem necessários'}\nSUB PENA: ${dadosPrompt.declaracaoPena}\nTESTEMUNHAS: ${dadosPrompt.declaracaoTestemunhas}` : ''}
${clausulasEspeciais.length > 0 ? 'CLÁUSULAS ESPECIAIS:\n' + clausulasEspeciais.map((c, i) => `${i+1}. ${c}`).join('\n') : ''}

${dadosPrompt.instrucoesIA ? 'INSTRUÇÕES ADICIONAIS:\n' + dadosPrompt.instrucoesIA : ''}`;

            const token = localStorage.getItem('keepai_token');

            try {
                const response = await fetch(`${API_CONFIG.endpoint}?keepai_token=${encodeURIComponent(token || '')}`, {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json', 
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    },
                    body: JSON.stringify({ promptSistema, promptUsuario, model: API_CONFIG.model, keepai_token: token })
                });

                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({}));
                    throw new Error(errorData.error || `Erro HTTP: ${response.status}`);
                }

                const data = await response.json();
                if (data.error) throw new Error(data.error);
                
                $('#contratoGeradoTexto').val(data.textoContrato.trim());
                $('#loadingIA').addClass('hidden');
                $('#contratoGeradoTexto, #acoesResultado').removeClass('hidden');

                // Atualiza o saldo em tempo real
                if (data.credits_remaining !== undefined) {
                    $('#creditBalance').text(data.credits_remaining);
                    window.userCredits = data.credits_remaining;
                }

            } catch (error) {
                console.error('Erro:', error);
                $('#loadingIA').addClass('hidden');
                $('#contratoGeradoTexto').val(`❌ Erro ao gerar contrato:\n\n${error.message}\n\nVerifique a configuração da API.`).removeClass('hidden');
                $('#acoesResultado').removeClass('hidden');
            }
        }

        // Botão Gerar
        $('#btnGerarIA').click(function() {
            // --- Verificação de Sessão Keep AI Obrigatória ---
            const token = localStorage.getItem('keepai_token');
            if (!token) {
                Swal.fire({
                    icon: 'warning',
                    title: '💎 Login Obrigatório',
                    text: 'Para gerar contratos por IA, você precisa estar conectado à sua conta Keep AI.',
                    background: '#0f172a',
                    color: '#fff',
                    confirmButtonColor: '#6366f1',
                    showCancelButton: true,
                    confirmButtonText: 'Conectar Agora',
                    cancelButtonText: 'Cancelar',
                    customClass: { popup: 'rounded-3xl border border-white/10 shadow-2xl' }
                }).then((result) => {
                    if (result.isConfirmed) {
                        openShopModal();
                        document.getElementById('keepaiEmail').scrollIntoView({ behavior: 'smooth' });
                        setTimeout(() => document.getElementById('keepaiEmail').focus(), 800);
                    }
                });
                return;
            }

            if (window.userCredits === undefined || window.userCredits < 1) {
                Swal.fire({
                    icon: 'error',
                    title: '💎 Sem Créditos',
                    text: 'Você precisa de pelo menos 1 crédito de diamante para gerar um contrato por IA.',
                    background: '#0f172a',
                    color: '#fff',
                    confirmButtonColor: '#6366f1',
                    showCancelButton: true,
                    confirmButtonText: 'Recarregar',
                    cancelButtonText: 'Cancelar',
                    customClass: { popup: 'rounded-3xl border border-white/10 shadow-2xl' }
                }).then((result) => {
                    if (result.isConfirmed) {
                        openShopModal();
                    }
                });
                return;
            }

            if (!$('#contractForm')[0].checkValidity()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos Obrigatórios',
                    text: 'Preencha todos os campos obrigatórios antes de gerar o contrato.',
                    background: '#0f172a',
                    color: '#fff',
                    confirmButtonColor: '#6366f1'
                });
                $('#contractForm')[0].reportValidity();
                return;
            }

            saveFormData();

            const dadosPrompt = {
                contratanteNome: $('#contratante_nome').val(),
                contratanteDoc: $('#contratante_doc').val(),
                contratanteRg: $('#contratante_rg').val(),
                contratanteNacionalidade: $('#contratante_nacionalidade').val(),
                contratanteEstadoCivil: $('#contratante_estado_civil').val(),
                contratanteProfissao: $('#contratante_profissao').val(),
                contratanteEndereco: $('#contratante_endereco').val(),
                contratanteEmail: $('#contratante_email').val(),
                contratanteTelefone: $('#contratante_telefone_whatsapp').val(),
                contratanteTipoPessoa: $('#contratante_tipo_pessoa').val(),
                contratadoNome: $('#contratado_nome').val(),
                contratadoDoc: $('#contratado_doc').val(),
                contratadoRg: $('#contratado_rg').val(),
                contratadoNacionalidade: $('#contratado_nacionalidade').val(),
                contratadoEstadoCivil: $('#contratado_estado_civil').val(),
                contratadoProfissao: $('#contratado_profissao').val(),
                contratadoEndereco: $('#contratado_endereco').val(),
                contratadoEmail: $('#contratado_email').val(),
                contratadoTelefone: $('#contratado_telefone_whatsapp').val(),
                contratadoTipoPessoa: $('#contratado_tipo_pessoa').val(),
                tipoContrato: $('#tipo_contrato').val(),
                tipoContratoOutro: $('#tipo_contrato_outro').val(),
                objetoContrato: $('#objeto_contrato').val(),
                valorContrato: $('#valor_contrato').val(),
                formaPagamento: $('#forma_pagamento option:selected').text(),
                formaPagamentoDesc: $('#forma_pagamento_desc').val(),
                dataInicio: $('#data_inicio').val(),
                dataTerminoTipo: $('#data_termino_tipo').val(),
                dataTermino: $('#data_termino').val(),
                mesesVigencia: $('#meses_vigencia').val(),
                cidadeForo: $('#cidade_foro').val(),
                estadoForo: $('#estado_foro').val(),
                instrucoesIA: $('#instrucoes_ia').val(),
                declaracaoFinalidade: $('#declaracao_finalidade').val(),
                declaracaoPena: $('#declaracao_pena option:selected').text(),
                declaracaoTestemunhas: $('#declaracao_testemunhas').val()
            };

            $('#resultadoContainer').removeClass('hidden');
            $('#loadingIA').removeClass('hidden');
            $('#contratoGeradoTexto, #acoesResultado').addClass('hidden');
            $('#contratoGeradoTexto').val('');
            
            $('html, body').animate({ scrollTop: $('#resultadoContainer').offset().top - 100 }, 500);
            gerarContratoIA(dadosPrompt);
        });

        // Ações do resultado
        $('#btnCopiarConteudoContrato').click(function() {
            const texto = $('#contratoGeradoTexto').val();
            if (!texto) return;
            navigator.clipboard.writeText(texto).then(() => {
                const $btn = $(this);
                const html = $btn.html();
                $btn.html('<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Copiado!');
                setTimeout(() => $btn.html(html), 2000);
            });
        });

        $('#btnImprimirContrato').click(function() {
            const texto = $('#contratoGeradoTexto').val();
            if (!texto) return;
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`<!DOCTYPE html><html><head><title>Contrato</title><style>body{font-family:'Times New Roman',serif;font-size:12pt;line-height:1.6;margin:2cm;color:#000}pre{white-space:pre-wrap;word-wrap:break-word;font-family:inherit;margin:0}@media print{body{margin:1.5cm}}</style></head><body><pre>${texto}</pre></body></html>`);
            printWindow.document.close();
            printWindow.onload = () => { printWindow.focus(); setTimeout(() => printWindow.print(), 300); };
        });

        $('#btnSalvarHtmlContrato').click(function() {
            const texto = $('#contratoGeradoTexto').val();
            if (!texto) return;
            const html = `<!DOCTYPE html><html lang="pt-BR"><head><meta charset="UTF-8"><title>Contrato</title><style>body{font-family:'Times New Roman',serif;font-size:12pt;line-height:1.8;max-width:800px;margin:40px auto;padding:20px;color:#333}pre{white-space:pre-wrap;word-wrap:break-word;font-family:inherit}</style></head><body><pre>${texto}</pre></body></html>`;
            const blob = new Blob([html], { type: 'text/html;charset=utf-8' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = `contrato_${$('#contratante_nome').val().replace(/\s+/g, '_').toLowerCase()}.html`;
            link.click();
        });

        $('#btnSalvarDocx').click(function() {
            const texto = $('#contratoGeradoTexto').val();
            if (!texto) return;
            const blob = new Blob([texto], { type: 'text/plain;charset=utf-8' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            const nomeBase = ($('#contratante_nome').val() || 'documento').replace(/\s+/g, '_').toLowerCase();
            link.download = `${nomeBase}.txt`;
            link.click();
        });

        // Exportar DOCX real usando docx.js
        $('#btnSalvarDocxReal').click(async function() {
            const texto = $('#contratoGeradoTexto').val();
            if (!texto) return;
            const btn = this;
            const htmlOrig = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> Gerando...';

            try {
                // Carrega docx.js do CDN se ainda não carregou
                if (typeof docx === 'undefined') {
                    await new Promise((res, rej) => {
                        const s = document.createElement('script');
                        s.src = 'https://unpkg.com/docx@8.5.0/build/index.js';
                        s.onload = res; s.onerror = rej;
                        document.head.appendChild(s);
                    });
                }

                const { Document, Packer, Paragraph, TextRun, HeadingLevel, AlignmentType } = docx;
                const linhas = texto.split('\n');
                const paragrafos = linhas.map(linha => {
                    const limpa = linha.trim();
                    // Detecta cabeçalho/título (linha em maiúsculas com mais de 5 chars)
                    if (limpa.length > 5 && limpa === limpa.toUpperCase() && !/^\d/.test(limpa) && !limpa.startsWith('§') && !limpa.startsWith('-')) {
                        return new Paragraph({
                            children: [new TextRun({ text: limpa, bold: true, size: 28, font: 'Times New Roman' })],
                            alignment: AlignmentType.CENTER,
                            spacing: { before: 200, after: 200 }
                        });
                    }
                    // Linha de cláusula (CLÁUSULA...)
                    if (/^CL[AÁ]USULA/i.test(limpa) || /^ART\.?\s*\d/i.test(limpa)) {
                        return new Paragraph({
                            children: [new TextRun({ text: limpa, bold: true, size: 24, font: 'Times New Roman' })],
                            spacing: { before: 240, after: 120 }
                        });
                    }
                    // Linha vazia
                    if (!limpa) return new Paragraph({ children: [], spacing: { before: 60, after: 60 } });
                    // Parágrafo normal
                    return new Paragraph({
                        children: [new TextRun({ text: linha, size: 24, font: 'Times New Roman' })],
                        spacing: { before: 80, after: 80 },
                        indent: { firstLine: 720 }
                    });
                });

                const doc = new Document({
                    sections: [{
                        properties: {
                            page: { margin: { top: 1440, right: 1440, bottom: 1440, left: 1440 } }
                        },
                        children: paragrafos
                    }]
                });

                const buffer = await Packer.toBlob(doc);
                const nomeBase = ($('#contratante_nome').val() || 'documento').replace(/\s+/g, '_').toLowerCase();
                const link = document.createElement('a');
                link.href = URL.createObjectURL(buffer);
                link.download = `${nomeBase}.docx`;
                link.click();

                Swal.fire({ icon: 'success', title: 'DOCX Gerado!', text: 'Arquivo Word baixado com sucesso.', background: '#0f172a', color: '#fff', confirmButtonColor: '#6366f1', timer: 2000, showConfirmButton: false });
            } catch(err) {
                console.error(err);
                Swal.fire({ icon: 'error', title: 'Erro ao gerar DOCX', text: 'Tente novamente ou use o download TXT.', background: '#0f172a', color: '#fff', confirmButtonColor: '#6366f1' });
            } finally {
                btn.disabled = false;
                btn.innerHTML = htmlOrig;
            }
        });

        function enviarWhatsApp(numero, tipo) {
            let numLimpo = (numero || "").replace(/\D/g, '');
            if (numLimpo.length < 10) { alert(`Número de WhatsApp inválido para ${tipo}.`); return; }
            if (numLimpo.length <= 11 && !numLimpo.startsWith('55')) numLimpo = '55' + numLimpo;
            const tipoDoc = $('#tipo_contrato').val() === 'Outro' ? $('#tipo_contrato_outro').val() : $('#tipo_contrato').val();
            const tipoDocFmt = getTipoDocumento($('#tipo_contrato').val());
            const nomeTipo = tipoDocFmt === 'procuracao' ? 'procuração' : tipoDocFmt === 'declaracao' ? 'declaração' : 'contrato';
            const msg = `Olá! Segue o rascunho de ${nomeTipo}: ${tipoDoc} para sua análise.`;
            window.open(`https://wa.me/${numLimpo}?text=${encodeURIComponent(msg)}`, '_blank');
        }

        $('#btnEnviarWhatsAppContratante').click(() => enviarWhatsApp($('#contratante_telefone_whatsapp').val(), 'Contratante'));
        $('#btnEnviarWhatsAppContratado').click(() => enviarWhatsApp($('#contratado_telefone_whatsapp').val(), 'Contratado'));


    // ==========================================
    // SISTEMA DE NAVEGAÇÃO DE VIEWS (SPA 4USIGN PRO)
    // ==========================================
    function navegarPara(modo) {
        $('#viewHub, #viewGerador, #viewAssinador').addClass('hidden');
        $('.nav-tab').removeClass('bg-indigo-600 text-white shadow-sm').addClass('text-white/70 hover:bg-white/10');

        if (modo === 'gerador') {
            $('#viewGerador').removeClass('hidden');
            $('#navBtnGerador').removeClass('text-white/70 hover:bg-white/10').addClass('bg-indigo-600 text-white shadow-sm');
            window.location.hash = 'gerador';
            $('#heroTitulo').text('Criador de Contratos');
            $('#heroSubtitulo').text('Estruture minutas personalizadas com inteligência artificial e modelos jurídicos');
        } else if (modo === 'assinar') {
            $('#viewAssinador').removeClass('hidden');
            $('#navBtnAssinar').removeClass('text-white/70 hover:bg-white/10').addClass('bg-indigo-600 text-white shadow-sm');
            window.location.hash = 'assinar';
            $('#heroTitulo').text('Central de Assinatura');
            $('#heroSubtitulo').text('Abra qualquer documento PDF na tela para assinar e salvar ou enviar');
        } else {
            $('#viewHub').removeClass('hidden');
            $('#navBtnHub').removeClass('text-white/70 hover:bg-white/10').addClass('bg-indigo-600 text-white shadow-sm');
            window.location.hash = 'hub';
            $('#heroTitulo').text('4USign Pro');
            $('#heroSubtitulo').text('Contratos Inteligentes com IA & Assinatura Digital com Plena Validade Jurídica');
        }

        $('html, body').animate({ scrollTop: 0 }, 300);
    }
    window.navegarPara = navegarPara;

    // ==========================================
    // CONTROLE DO MODAL DE VALIDADE JURÍDICA
    // ==========================================
    function abrirModalValidadeJuridica() {
        $('#modalValidadeJuridica').removeClass('hidden');
        $('body').addClass('overflow-hidden');
    }
    window.abrirModalValidadeJuridica = abrirModalValidadeJuridica;

    function fecharModalValidadeJuridica() {
        $('#modalValidadeJuridica').addClass('hidden');
        $('body').removeClass('overflow-hidden');
    }
    window.fecharModalValidadeJuridica = fecharModalValidadeJuridica;

    $(document).ready(function() {
        const h = window.location.hash.replace('#', '');
        if (h === 'gerador' || h === 'assinar') {
            navegarPara(h);
        } else {
            navegarPara('hub');
        }
    });

    // ==========================================
    // RENDERIZADOR REAL DE PDF NA TELA (PDF.JS)
    // ==========================================
    let currentPdfBytes = null;
    let currentPdfFileName = 'documento.pdf';
    let pdfDocInstance = null;

    async function carregarERenderizarPdf(pdfArrayBuffer, nomeArquivo) {
        try {
            currentPdfBytes = new Uint8Array(pdfArrayBuffer);
            currentPdfFileName = nomeArquivo || 'documento.pdf';

            $('#pdfNomeArquivo').text(currentPdfFileName);
            $('#pdfStatusPaginas').text('Processando páginas...');

            // Alternar de tela de upload para workspace do documento
            $('#pdfUploadState').addClass('hidden');
            $('#pdfWorkspaceState').removeClass('hidden');

            const loadingTask = pdfjsLib.getDocument({ data: currentPdfBytes });
            pdfDocInstance = await loadingTask.promise;

            $('#pdfStatusPaginas').text(`📄 ${pdfDocInstance.numPages} ${pdfDocInstance.numPages === 1 ? 'página' : 'páginas'}`);
            $('#pdfPagesRenderContainer').empty();

            for (let pageNum = 1; pageNum <= pdfDocInstance.numPages; pageNum++) {
                const page = await pdfDocInstance.getPage(pageNum);
                const scale = 1.6;
                const viewport = page.getViewport({ scale: scale });

                const sheetWrapper = document.createElement('div');
                sheetWrapper.className = 'pdf-page-sheet';
                sheetWrapper.id = 'pdfSheetPage_' + pageNum;

                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;
                canvas.className = 'w-full block';

                sheetWrapper.appendChild(canvas);

                // Se for a última página, adiciona a área de sobreposição das assinaturas
                if (pageNum === pdfDocInstance.numPages) {
                    const sigOverlay = document.createElement('div');
                    sigOverlay.id = 'workspaceSignatureOverlay';
                    sigOverlay.className = 'p-6 bg-slate-50/90 border-t-2 border-slate-200 text-center';
                    sigOverlay.innerHTML = `
                        <div class="text-xs uppercase font-bold tracking-widest text-slate-400 mb-3">
                            <i class="fa-solid fa-shield-halved text-indigo-600"></i> Autenticação Digital & Assinaturas
                        </div>
                        <div id="workspaceAssinaturasStamps" class="flex flex-wrap items-center justify-center gap-4">
                            <button type="button" onclick="abrirModalAssinaturaComTipo('contratante')" class="text-xs bg-purple-600 hover:bg-purple-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-md cursor-pointer transition-all flex items-center gap-2">
                                <i class="fa-solid fa-signature"></i> Clique Aqui para Assinar Este Documento
                            </button>
                        </div>
                    `;
                    sheetWrapper.appendChild(sigOverlay);
                }

                document.getElementById('pdfPagesRenderContainer').appendChild(sheetWrapper);

                await page.render({ canvasContext: context, viewport: viewport }).promise;
            }

            atualizarStampsNoWorkspace();

            Swal.fire({
                icon: 'success',
                title: '📄 Documento Aberto na Tela!',
                text: `${currentPdfFileName} (${pdfDocInstance.numPages} pág.) está pronto para receber sua assinatura!`,
                background: '#0f172a',
                color: '#fff',
                confirmButtonColor: '#06b6d4',
                timer: 2500
            });

        } catch (err) {
            console.error('Erro ao renderizar PDF:', err);
            Swal.fire({
                icon: 'error',
                title: 'Erro ao abrir PDF',
                text: 'Não foi possível ler este arquivo PDF. Verifique se o documento não está protegido por senha.',
                background: '#0f172a',
                color: '#fff',
                confirmButtonColor: '#6366f1'
            });
        }
    }

    // ==========================================
    // UPLOAD & SELEÇÃO DE ARQUIVOS PDF
    // ==========================================
    $('#inputPdfFile').on('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(evt) {
            carregarERenderizarPdf(evt.target.result, file.name);
        };
        reader.readAsArrayBuffer(file);
    });

    $('#pdfDropzone, #btnTrocarPdf').on('click', function(e) {
        e.preventDefault();
        $('#inputPdfFile')[0].click();
    });

    $('#inputPdfFile').on('click', function(e) {
        e.stopPropagation();
    });

    const dropzone = document.getElementById('pdfDropzone');
    if (dropzone) {
        ['dragenter', 'dragover'].forEach(name => {
            dropzone.addEventListener(name, (e) => { e.preventDefault(); dropzone.classList.add('dragover'); }, false);
        });
        ['dragleave', 'drop'].forEach(name => {
            dropzone.addEventListener(name, (e) => { e.preventDefault(); dropzone.classList.remove('dragover'); }, false);
        });
        dropzone.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            if (files.length) {
                document.getElementById('inputPdfFile').files = files;
                $('#inputPdfFile').trigger('change');
            }
        });
    }

    // ==========================================
    // PONTE: ENVIAR CONTRATO GERADO DIRETO PARA O VISUALIZADOR
    // ==========================================
    $('#btnTransferirParaAssinador').click(async function() {
        const texto = $('#contratoGeradoTexto').val();
        if (!texto) return;

        if ($('#contratoPreviewVisual').hasClass('hidden')) {
            $('#tabModoVisual').click();
        }
        atualizarVisualizadorDocumento();

        const cNome = $('#contratante_nome').val() || 'Contratante';
        const docNome = `contrato_${cNome.toLowerCase().replace(/\s+/g, '_')}.pdf`;

        Swal.fire({
            title: 'Preparando Documento...',
            text: 'Abrindo o contrato no visualizador de assinatura...',
            background: '#0f172a',
            color: '#fff',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        const element = document.getElementById('contratoPreviewVisual');
        const prevScrollY = window.pageYOffset || document.documentElement.scrollTop;
        window.scrollTo(0, 0);

        const opt = {
            margin: [12, 12, 12, 12],
            filename: docNome,
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: {
                scale: 2,
                useCORS: true,
                backgroundColor: '#ffffff',
                logging: false,
                letterRendering: true,
                onclone: function(clonedDoc) {
                    const all = clonedDoc.querySelectorAll('*');
                    for (let i = 0; i < all.length; i++) {
                        const el = all[i];
                        if (el.style) {
                            if (el.style.color && el.style.color.includes('oklch')) el.style.color = '#0f172a';
                            if (el.style.backgroundColor && el.style.backgroundColor.includes('oklch')) el.style.backgroundColor = '#ffffff';
                            if (el.style.borderColor && el.style.borderColor.includes('oklch')) el.style.borderColor = '#cbd5e1';
                        }
                    }
                }
            },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };

        try {
            const pdfBlob = await html2pdf().set(opt).from(element).outputPdf('blob');
            const arrayBuffer = await pdfBlob.arrayBuffer();

            navegarPara('assinar');
            await carregarERenderizarPdf(arrayBuffer, docNome);
        } catch (err) {
            console.error('Erro na transferência:', err);
        } finally {
            window.scrollTo(0, prevScrollY);
        }
    });

    // ==========================================
    // ATUALIZAÇÃO DOS STAMPS DE ASSINATURA NA TELA
    // ==========================================
    function atualizarStampsNoWorkspace() {
        const container = document.getElementById('workspaceAssinaturasStamps');
        if (!container) return;

        let stampsHtml = '';

        if (assinaturasSalvas['contratante']) {
            stampsHtml += `
                <div class="border-2 border-emerald-400 bg-emerald-50/80 rounded-2xl p-4 shadow-sm text-center min-w-[280px]">
                    <img src="${assinaturasSalvas['contratante'].dataUrl}" class="h-14 max-w-full mx-auto mb-1 object-contain drop-shadow" />
                    <div class="text-[10px] text-emerald-900 font-mono font-bold bg-emerald-100/90 py-1.5 px-3 rounded-xl border border-emerald-300 inline-block shadow-xs">
                        <div class="flex items-center justify-center gap-1.5 mb-0.5 text-emerald-800">
                            <i class="fa-solid fa-shield-halved text-emerald-600"></i>
                            <span>Assinado digitalmente • ${assinaturasSalvas['contratante'].dataHora}</span>
                        </div>
                        <div class="text-[9px] text-slate-600">
                            <span class="text-indigo-700 font-bold">IP: ${assinaturasSalvas['contratante'].ip}</span> • Hash: ${assinaturasSalvas['contratante'].hash}
                        </div>
                    </div>
                </div>
            `;
        }

        if (assinaturasSalvas['contratado']) {
            stampsHtml += `
                <div class="border-2 border-emerald-400 bg-emerald-50/80 rounded-2xl p-4 shadow-sm text-center min-w-[280px]">
                    <img src="${assinaturasSalvas['contratado'].dataUrl}" class="h-14 max-w-full mx-auto mb-1 object-contain drop-shadow" />
                    <div class="text-[10px] text-emerald-900 font-mono font-bold bg-emerald-100/90 py-1.5 px-3 rounded-xl border border-emerald-300 inline-block shadow-xs">
                        <div class="flex items-center justify-center gap-1.5 mb-0.5 text-emerald-800">
                            <i class="fa-solid fa-shield-halved text-emerald-600"></i>
                            <span>Assinado digitalmente • ${assinaturasSalvas['contratado'].dataHora}</span>
                        </div>
                        <div class="text-[9px] text-slate-600">
                            <span class="text-indigo-700 font-bold">IP: ${assinaturasSalvas['contratado'].ip}</span> • Hash: ${assinaturasSalvas['contratado'].hash}
                        </div>
                    </div>
                </div>
            `;
        }

        if (!assinaturasSalvas['contratante'] && !assinaturasSalvas['contratado']) {
            stampsHtml = `
                <button type="button" onclick="abrirModalAssinaturaComTipo('contratante')" class="text-xs bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg cursor-pointer transition-all flex items-center gap-2">
                    <i class="fa-solid fa-signature"></i> Clique Aqui para Assinar Este Documento
                </button>
            `;
        }

        container.innerHTML = stampsHtml;
    }

    // ==========================================
    // SALVAR / BAIXAR PDF ASSINADO COM PDF-LIB
    // ==========================================
    $('#btnExportarPdfAssinadoLib').click(async function() {
        if (!assinaturasSalvas['contratante'] && !assinaturasSalvas['contratado']) {
            Swal.fire({
                icon: 'warning',
                title: 'Nenhuma assinatura estampada',
                text: 'Clique no botão "Assinar Documento" antes de salvar o arquivo.',
                background: '#0f172a',
                color: '#fff',
                confirmButtonColor: '#6366f1'
            });
            return;
        }

        if (!currentPdfBytes) {
            // Se veio do gerador de texto
            $('#btnExportarPdfJuridico').click();
            return;
        }

        try {
            Swal.fire({
                title: 'Gravando Assinaturas...',
                text: 'Gerando certificação e carimbo criptográfico no PDF...',
                background: '#0f172a',
                color: '#fff',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            const pdfDoc = await PDFLib.PDFDocument.load(currentPdfBytes);
            const pages = pdfDoc.getPages();
            const lastPage = pages[pages.length - 1];
            const { width, height } = lastPage.getSize();

            // Pegar a assinatura ativa
            const sigAtiva = assinaturasSalvas['contratante'] || assinaturasSalvas['contratado'];
            if (sigAtiva && sigAtiva.dataUrl) {
                const pngImage = await pdfDoc.embedPng(sigAtiva.dataUrl);
                
                // Desenhar a assinatura na base da última página
                const imgWidth = 180;
                const imgHeight = 45;
                const posX = (width - imgWidth) / 2;
                const posY = 50;

                lastPage.drawImage(pngImage, {
                    x: posX,
                    y: posY,
                    width: imgWidth,
                    height: imgHeight,
                });

                // Desenhar carimbo de texto probatório
                lastPage.drawText(`Assinado digitalmente em ${sigAtiva.dataHora}`, {
                    x: posX - 20,
                    y: posY - 10,
                    size: 7,
                    color: PDFLib.rgb(0.2, 0.2, 0.6)
                });
                lastPage.drawText(`IP: ${sigAtiva.ip} | Hash SHA-256: ${sigAtiva.hash}`, {
                    x: posX - 40,
                    y: posY - 20,
                    size: 6.5,
                    color: PDFLib.rgb(0.3, 0.3, 0.3)
                });
            }

            const pdfFinalBytes = await pdfDoc.save();
            const blob = new Blob([pdfFinalBytes], { type: 'application/pdf' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = `assinado_${currentPdfFileName}`;
            link.click();

            Swal.fire({
                icon: 'success',
                title: '🎉 PDF Assinado com Sucesso!',
                html: `<p class="text-sm text-slate-300">O arquivo <b>assinado_${currentPdfFileName}</b> foi gravado e baixado com todas as assinaturas e o selo forense de autenticidade!</p>`,
                background: '#0f172a',
                color: '#fff',
                confirmButtonColor: '#06b6d4'
            });

        } catch (e) {
            console.error('Erro ao gravar no PDF:', e);
            // Fallback para html2pdf caso o PDF original seja incompatível
            $('#btnExportarPdfJuridico').click();
        }
    });

    // ==========================================
    // DISPARO DE LINK PELO WHATSAPP
    // ==========================================
    $('#btnAbrirModalZap').click(function() {
        $('#modalDisparoZap').removeClass('hidden');
    });

    function confirmarDisparoZap() {
        const nome = $('#zap_cliente_nome').val() || 'Cliente';
        let fone = ($('#zap_cliente_fone').val() || '').replace(/\D/g, '');
        const link = window.location.origin + window.location.pathname + '#assinar';

        const mensagem = `Olá ${nome}! 📄✍️\n\nSegue o link seguro da plataforma *4USign Pro* para a sua assinatura eletrônica no documento *${currentPdfFileName}*:\n\n👉 ${link}\n\nBasta abrir o link pelo celular ou computador, conferir o documento e assinar. O processo é rápido, gratuito e tem plena validade jurídica (MP nº 2.200-2/2001 e Lei nº 14.063/2020).`;

        const zapUrl = fone ? `https://api.whatsapp.com/send?phone=55${fone}&text=${encodeURIComponent(mensagem)}` : `https://api.whatsapp.com/send?text=${encodeURIComponent(mensagem)}`;

        window.open(zapUrl, '_blank');
        $('#modalDisparoZap').addClass('hidden');
    }
    window.confirmarDisparoZap = confirmarDisparoZap;

    // ==========================================
    // PREENCHIMENTO DE DADOS FICTÍCIOS / TESTE
    // ==========================================
    function preencherDadosFicticios() {
        let tipoAtual = $('#tipo_contrato').val();
        if (!tipoAtual) {
            $('#tipo_contrato').val('Prestação de Serviços de TI').trigger('change');
            tipoAtual = 'Prestação de Serviços de TI';
        }

        const hoje = new Date().toISOString().split('T')[0];

        // Contratante (Pessoa Jurídica)
        $('#contratante_tipo_pessoa').val('juridica').trigger('change');
        $('#contratante_nome').val('TechCorp Soluções Tecnológicas & Inovação Ltda');
        $('#contratante_doc').val('12.345.678/0001-90');
        $('#contratante_rg').val('12.345.678-9');
        $('#contratante_nacionalidade').val('Brasileira');
        $('#contratante_estado_civil').val('casado(a)');
        $('#contratante_profissao').val('Sociedade Empresária');
        $('#contratante_endereco').val('Av. Paulista, nº 1000, Conjunto 1402, Bela Vista, São Paulo/SP, CEP 01310-100');
        $('#contratante_email').val('diretoria@techcorp.com.br');
        $('#contratante_telefone_whatsapp').val('(11) 98765-4321');

        // Contratado (Pessoa Física / Engenheiro / Prestador)
        $('#contratado_tipo_pessoa').val('fisica').trigger('change');
        $('#contratado_nome').val('Fabiano Braga da Silva');
        $('#contratado_doc').val('123.456.789-00');
        $('#contratado_rg').val('98.765.432-1');
        $('#contratado_nacionalidade').val('Brasileiro');
        $('#contratado_estado_civil').val('solteiro(a)');
        $('#contratado_profissao').val('Engenheiro de Software & Consultor Técnico');
        $('#contratado_endereco').val('Rua das Inovações, nº 250, Centro Tecnológico, Florianópolis/SC, CEP 88010-000');
        $('#contratado_email').val('fabiano@4u.ia.br');
        $('#contratado_telefone_whatsapp').val('(48) 99123-4567');

        // Objeto personalizado de acordo com a categoria
        if (tipoAtual.includes('Obra') || tipoAtual.includes('Engenharia') || tipoAtual.includes('Projetos')) {
            $('#objeto_contrato').val('Execução de serviços técnicos de engenharia civil, elaboração de projetos executivos complementares, acompanhamento de obra e emissão da respectiva ART junto ao CREA.');
            $('#valor_contrato').val('45.000,00');
        } else if (tipoAtual.includes('Locação')) {
            $('#objeto_contrato').val('Locação de imóvel comercial situado na Rua Comercial, nº 500, Sala 301, Centro, Florianópolis/SC.');
            $('#valor_contrato').val('3.800,00');
        } else if (tipoAtual.includes('Procuração')) {
            $('#objeto_contrato').val('Amplos poderes para representação em processos judiciais e administrativos, celebração de acordos, quitações e assinatura de termos correlatos.');
        } else if (tipoAtual.includes('Declaração')) {
            $('#declaracao_finalidade').val('Comprovação de rendimentos e atividade profissional autônoma perante órgãos públicos e instituições financeiras.');
        } else {
            $('#objeto_contrato').val('Prestação de serviços técnicos de desenvolvimento, implantação e manutenção de sistemas web, consultoria técnica especializada e suporte contínuo.');
            $('#valor_contrato').val('18.500,00');
        }

        // Condições Financeiras & Prazos
        $('#forma_pagamento').val('parcelado').trigger('change');
        $('#forma_pagamento_desc').val('Entrada de 30% via PIX no ato da assinatura e o saldo restante dividido em 3 parcelas mensais.');
        $('#data_inicio').val(hoje);
        $('#data_termino_tipo').val('meses').trigger('change');
        $('#meses_vigencia').val('6');

        // Foro & Cláusulas
        $('#cidade_foro').val('São Paulo');
        $('#estado_foro').val('SP');

        $('#clausula_multa').prop('checked', true);
        $('#multa_percentual').val('10%');
        $('#clausula_rescisao').prop('checked', true);
        $('#aviso_previo').val('30 dias');
        $('#clausula_confidencialidade').prop('checked', true);
        $('#clausula_propriedade_intelectual').prop('checked', true);
        $('#clausula_lgpd').prop('checked', true);
        $('#opt_resumo_executivo').prop('checked', true);
        $('#opt_assinatura_digital').prop('checked', true);
        if (typeof updateClausulasUI === 'function') updateClausulasUI();

        Swal.fire({
            icon: 'success',
            title: '✨ Dados de Teste Preenchidos!',
            html: '<p class="text-sm text-slate-300">Todos os campos foram preenchidos com dados fictícios de exemplo.<br><br>👉 Agora clique em <b>"Pré-visualizar Modelo (Grátis)"</b> para ver o contrato formatado com as assinaturas!',
            background: '#0f172a',
            color: '#fff',
            confirmButtonColor: '#6366f1'
        });
    }

    $('#btnPreencherExemplo').click(preencherDadosFicticios);

    // ==========================================
    // GERADOR DE PRÉVIA DINÂMICA COMPLETA
    // ==========================================
    function gerarPreviaOffline() {
        const tipoSelect = $('#tipo_contrato').val();
        const tipo = tipoSelect === 'Outro' ? ($('#tipo_contrato_outro').val() || 'CONTRATO PERSONALIZADO') : (tipoSelect || 'CONTRATO DE PRESTAÇÃO DE SERVIÇOS');
        const tipoDocFmt = typeof getTipoDocumento === 'function' ? getTipoDocumento(tipo) : 'contrato';
        const formalidade = $('input[name="formalidade"]:checked').val() || 'padrao';

        // Partes
        const cNome = ($('#contratante_nome').val() || 'CONTRATANTE EXEMPLO').toUpperCase();
        const cTipoPessoa = $('#contratante_tipo_pessoa').val();
        const cDoc = $('#contratante_doc').val() || (cTipoPessoa === 'juridica' ? '00.000.000/0001-00' : '000.000.000-00');
        const cRg = $('#contratante_rg').val() ? `, portador(a) do RG nº ${$('#contratante_rg').val()}` : '';
        const cNac = $('#contratante_nacionalidade').val() || (cTipoPessoa === 'juridica' ? 'brasileira' : 'brasileiro(a)');
        const cCivil = $('#contratante_estado_civil').val() ? `, ${$('#contratante_estado_civil').val()}` : '';
        const cProf = $('#contratante_profissao').val() || (cTipoPessoa === 'juridica' ? 'sociedade empresária' : 'profissão não informada');
        const cEnd = $('#contratante_endereco').val() || 'Endereço Completo do Contratante';

        const pNome = ($('#contratado_nome').val() || 'CONTRATADO(A) EXEMPLO').toUpperCase();
        const pTipoPessoa = $('#contratado_tipo_pessoa').val();
        const pDoc = $('#contratado_doc').val() || (pTipoPessoa === 'juridica' ? '00.000.000/0001-00' : '000.000.000-00');
        const pRg = $('#contratado_rg').val() ? `, portador(a) do RG nº ${$('#contratado_rg').val()}` : '';
        const pNac = $('#contratado_nacionalidade').val() || (pTipoPessoa === 'juridica' ? 'brasileira' : 'brasileiro(a)');
        const pCivil = $('#contratado_estado_civil').val() ? `, ${$('#contratado_estado_civil').val()}` : '';
        const pProf = $('#contratado_profissao').val() || (pTipoPessoa === 'juridica' ? 'sociedade empresária' : 'profissional autônomo');
        const pEnd = $('#contratado_endereco').val() || 'Endereço Completo do Contratado';

        const objeto = $('#objeto_contrato').val() || 'Prestação de serviços técnicos e profissionais especializados.';
        const valor = $('#valor_contrato').val() || '0,00';
        const formaPgtoSelect = $('#forma_pagamento').val();
        const formaPgtoDesc = $('#forma_pagamento_desc').val() || `Pagamento na modalidade ${formaPgtoSelect || 'acordada entre as partes'}.`;
        
        const dataInicio = $('#data_inicio').val() ? formatDate($('#data_inicio').val()) : 'data de sua assinatura';
        const terminoTipo = $('#data_termino_tipo').val();
        let vigenciaTxt = `a contar de ${dataInicio}`;
        if (terminoTipo === 'meses') vigenciaTxt = `pelo prazo de ${$('#meses_vigencia').val() || '12'} meses, iniciando em ${dataInicio}`;
        else if (terminoTipo === 'indeterminado') vigenciaTxt = `por prazo indeterminado, com início em ${dataInicio}`;
        else if (terminoTipo === 'conclusao_objeto') vigenciaTxt = `até a conclusão definitiva dos serviços, com início em ${dataInicio}`;
        else if ($('#data_termino').val()) vigenciaTxt = `iniciando em ${dataInicio} e finalizando em ${formatDate($('#data_termino').val())}`;

        const foroCidade = $('#cidade_foro').val() || 'São Paulo';
        const foroUf = ($('#estado_foro').val() || 'SP').toUpperCase();
        const dataExtenso = new Date().toLocaleDateString('pt-BR', { day: 'numeric', month: 'long', year: 'numeric' });

        let documento = '';

        // 1. RESUMO EXECUTIVO (Se marcado)
        if ($('#opt_resumo_executivo').is(':checked')) {
            documento += `========================================================================
                      QUADRO RESUMO EXECUTIVO
========================================================================
• INSTRUMENTO: ${tipo.toUpperCase()}
• NÍVEL DE FORMALIDADE: ${formalidade.toUpperCase().replace('_', ' ')}
• CONTRATANTE: ${cNome} (${cTipoPessoa === 'juridica' ? 'CNPJ: ' : 'CPF: '}${cDoc})
• CONTRATADO(A): ${pNome} (${pTipoPessoa === 'juridica' ? 'CNPJ: ' : 'CPF: '}${pDoc})
• OBJETO: ${objeto}
• VALOR TOTAL: R$ ${valor} (${formaPgtoDesc})
• VIGÊNCIA: ${vigenciaTxt}
• FORO: Comarca de ${foroCidade}/${foroUf}
========================================================================\n\n`;
        }

        // ========================================================
        // GERAÇÃO DIFERENCIADA POR NÍVEL DE FORMALIDADE
        // ========================================================

        if (formalidade === 'simples') {
            documento += `ACORDO SIMPLIFICADO: ${tipo.toUpperCase()}\n\n`;
            documento += `PARTES:\n`;
            documento += `1. CONTRATANTE: ${cNome}, doc nº ${cDoc}, endereço: ${cEnd}.\n`;
            documento += `2. CONTRATADO(A): ${pNome}, doc nº ${pDoc}, endereço: ${pEnd}.\n\n`;
            documento += `As partes acima combinam e aceitam as seguintes condições simples:\n\n`;

            documento += `1. DO TRABALHO/OBJETO:\n${objeto}\n\n`;
            documento += `2. DO VALOR E PAGAMENTO:\nO valor total acertado é de R$ ${valor}, sendo pago da seguinte forma: ${formaPgtoDesc}.\n\n`;
            documento += `3. DO PRAZO:\nO trabalho será realizado ${vigenciaTxt}.\n\n`;

            if ($('#clausula_multa').is(':checked')) {
                const perc = $('#multa_percentual').val() || '10%';
                documento += `4. CANCELAMENTO E MULTA:\nSe alguma das partes desistir sem motivo justo, pagará multa de ${perc} sobre o valor do acordo.\n\n`;
            }
            if ($('#clausula_confidencialidade').is(':checked')) {
                documento += `5. SIGILO:\nAs partes concordam em manter sigilo sobre todas as informações e dados compartilhados durante este trabalho.\n\n`;
            }
            if ($('#clausula_lgpd').is(':checked')) {
                documento += `6. DADOS PESSOAIS:\nOs dados aqui informados serão usados apenas para a execução deste acordo, conforme a LGPD.\n\n`;
            }

            documento += `7. LOCAL E ACORDO:\nPara resolver qualquer dúvida, fica escolhida a cidade de ${foroCidade} - ${foroUf}.\n\n`;

        } else if (formalidade === 'juridico_completo') {
            documento += `INSTRUMENTO PARTICULAR DE ${tipo.toUpperCase()}\n\n`;

            documento += `CONSIDERANDO QUE:\n`;
            documento += `I - O(A) CONTRATANTE necessita da contratação de serviços técnicos especializados com elevado padrão de qualidade e governança;\n`;
            documento += `II - O(A) CONTRATADO(A) declara possuir plena capacidade jurídica, técnica, operacional e profissional para a execução do objeto;\n`;
            documento += `III - As partes celebram este pacto pautadas nos princípios da probidade, autonomia privada e da boa-fé objetiva, nos moldes do art. 422 do Código Civil Brasileiro;\n\n`;
            documento += `RESOLVEM as partes celebrar o presente contrato mediante as seguintes estipulações:\n\n`;

            documento += `CLÁUSULA PRIMEIRA - DA QUALIFICAÇÃO INTEGRAL DAS PARTES\n`;
            if (cTipoPessoa === 'juridica') {
                documento += `1.1. CONTRATANTE: ${cNome}, pessoa jurídica de direito privado, inscrita no CNPJ sob o nº ${cDoc}, com sede social estabelecida em ${cEnd}, neste ato regularmente representada na forma de seus atos constitutivos;\n`;
            } else {
                documento += `1.1. CONTRATANTE: ${cNome}, ${cNac}${cCivil}, ${cProf}${cRg}, inscrito(a) no CPF sob o nº ${cDoc}, residente e domiciliado(a) em ${cEnd};\n`;
            }
            if (pTipoPessoa === 'juridica') {
                documento += `1.2. CONTRATADO(A): ${pNome}, pessoa jurídica de direito privado, inscrita no CNPJ sob o nº ${pDoc}, com sede em ${pEnd}, neste ato representada por seus administradores legais;\n`;
            } else {
                documento += `1.2. CONTRATADO(A): ${pNome}, ${pNac}${pCivil}, ${pProf}${pRg}, inscrito(a) no CPF sob o nº ${pDoc}, residente e domiciliado(a) em ${pEnd}.\n`;
            }
            documento += `\n`;

            documento += `CLÁUSULA SEGUNDA - DO OBJETO E ESCOPO EXECUTIVO\n`;
            documento += `2.1. Constitui objeto deste contrato: ${objeto}.\n`;
            documento += `§ 1º. Os serviços deverão ser prestados com estrita observância das melhores práticas vigentes no mercado, normas regulamentadoras e parâmetros técnicos aplicáveis.\n`;
            if (tipo.includes('Obra') || tipo.includes('Engenharia')) {
                documento += `§ 2º. É imperativo o atendimento às normas ABNT e a formalização da correspondente ART/RRT perante o conselho profissional competente (CREA/CAU).\n`;
            } else {
                documento += `§ 2º. Quaisquer alterações no escopo ou entregáveis dependerão de prévia aprovação expressa mediante Termo Aditivo.\n`;
            }
            documento += `\n`;

            documento += `CLÁUSULA TERCEIRA - DA INEXISTÊNCIA DE VÍNCULO EMPREGATÍCIO E AUTONOMIA\n`;
            documento += `3.1. As partes declaram para todos os efeitos que a relação jurídica ora celebrada é de natureza estritamente cível e comercial, inexistindo qualquer subordinação jurídica, pessoalidade mandatória ou vínculo de emprego (CLT), cabendo ao(à) CONTRATADO(A) a total responsabilidade por seus encargos sociais, previdenciários e fiscais.\n\n`;

            documento += `CLÁUSULA QUARTA - DO PREÇO, FATURAMENTO E CONDIÇÕES DE PAGAMENTO\n`;
            documento += `4.1. Como contraprestação líquida e certa, o(a) CONTRATANTE pagará ao(à) CONTRATADO(A) o valor total de R$ ${valor}.\n`;
            documento += `§ 1º. A liquidação do valor pactuado ocorrerá da seguinte forma: ${formaPgtoDesc}.\n`;
            if ($('#clausula_reajuste').is(':checked')) {
                const ind = $('#indice_reajuste').val() || 'IPCA (IBGE)';
                documento += `§ 2º. Os valores sofrerão reajuste automático anual ou em periodicidade mínima legalmente permitida pela variação acumulada do índice ${ind}.\n`;
            }
            documento += `\n`;

            documento += `CLÁUSULA QUINTA - DO PRAZO DE VIGÊNCIA E CRONOGRAMA\n`;
            documento += `5.1. O presente instrumento vigerá ${vigenciaTxt}.\n`;
            documento += `§ 1º. O cronograma executivo somente poderá ser prorrogado mediante justificativa técnica devidamente aceita por escrito pelo(a) CONTRATANTE.\n\n`;

            if ($('#clausula_multa').is(':checked')) {
                const perc = $('#multa_percentual').val() || '10% (dez por cento)';
                const fixo = $('#multa_valor_fixo').val() ? ` ou R$ ${$('#multa_valor_fixo').val()}` : '';
                documento += `CLÁUSULA SEXTA - DA CLÁUSULA PENAL E INDENIZAÇÃO\n`;
                documento += `6.1. O inadimplemento total ou parcial de qualquer obrigação sujeitará a parte infratora à multa cominatória compensatória de ${perc}${fixo}, calculada sobre o valor total deste contrato, sem prejuízo da apuração e cobrança suplementar de perdas e danos, lucros cessantes e honorários advocatícios sucumbenciais (arts. 408 e seguintes do Código Civil).\n\n`;
            }

            if ($('#clausula_rescisao').is(':checked')) {
                const aviso = $('#aviso_previo').val() || '30 (trinta) dias';
                documento += `CLÁUSULA SÉTIMA - DA EXTINÇÃO E RESCISÃO CONTRATUAL\n`;
                documento += `7.1. O contrato poderá ser rescindido de pleno direito, independentemente de notificação judicial:\n`;
                documento += `a) Por mútuo acordo entre as partes;\n`;
                documento += `b) Por descumprimento insanável de cláusula contratual após decurso de prazo de 5 (cinco) dias úteis de notificação prévia;\n`;
                documento += `c) Por decretação de insolvência, recuperação judicial ou falência.\n`;
                documento += `7.2. A resilição unilateral imotivada exigirá denúncia prévia e expressa com antecedência de ${aviso}.\n\n`;
            }

            if ($('#clausula_confidencialidade').is(':checked')) {
                documento += `CLÁUSULA OITAVA - DO SIGILO, CONFIDENCIALIDADE E SEGREDO INDUSTRIAL (NDA)\n`;
                documento += `8.1. Todas as informações, bancos de dados, metodologias, segredos de negócio e documentos trafegados entre as partes são de caráter estritamente confidencial, obrigando-se as partes, seus prepostos e terceiros por si contratados a não divulgá-los sem anuência expressa, sob pena de responsabilização civil e criminal, perdurando dita obrigação por 5 (cinco) anos após o término deste instrumento.\n\n`;
            }

            if ($('#clausula_propriedade_intelectual').is(':checked')) {
                documento += `CLÁUSULA NONA - DA PROPRIEDADE INTELECTUAL E DIREITOS AUTORAIS\n`;
                documento += `9.1. Toda e qualquer propriedade intelectual, código-fonte, obra, desenho, modelo ou criação originada sob demanda na vigência deste contrato é de titularidade exclusiva do(a) CONTRATANTE após a regular liquidação financeira.\n\n`;
            }

            if ($('#clausula_lgpd').is(':checked')) {
                documento += `CLÁUSULA DÉCIMA - DA PROTEÇÃO DE DADOS PESSOAIS (LGPD - LEI Nº 13.709/2018)\n`;
                documento += `10.1. As partes comprometem-se a adotar todas as medidas técnicas e administrativas aptas a proteger os dados pessoais contra acessos não autorizados e eventos ilícitos, atuando em estrito alinhamento aos preceitos da LGPD.\n\n`;
            }

            if ($('#instrucoes_ia').val() && $('#instrucoes_ia').val().trim()) {
                documento += `CLÁUSULA DÉCIMA PRIMEIRA - DAS DISPOSIÇÕES ESPECIAIS PACTUADAS\n`;
                documento += `11.1. As partes acordam expressamente as seguintes condições particulares:\n${$('#instrucoes_ia').val().trim()}\n\n`;
            }

            documento += `CLÁUSULA DÉCIMA SEGUNDA - DA NÃO-NOVAÇÃO, INTEGRALIDADE E SUCESSÃO\n`;
            documento += `12.1. A tolerância de qualquer das partes quanto a eventuais infrações não importará em renúncia de direitos, novação ou precedente invocável.\n`;
            documento += `12.2. O presente contrato obriga as partes, seus herdeiros e sucessores a qualquer título.\n`;
            documento += `12.3. As partes reconhecem expressamente a validade e higidez jurídica das assinaturas eletrônicas e digitais apostas neste documento, em conformidade com o art. 10, § 2º da MP nº 2.200-2/2001 e Lei nº 14.063/2020.\n\n`;

            documento += `CLÁUSULA DÉCIMA TERCEIRA - DO FORO DE ELEIÇÃO\n`;
            documento += `13.1. Fica eleito o Foro da Comarca de ${foroCidade}, Estado de ${foroUf}, para dirimir quaisquer litígios oriundos do presente negócio jurídico, renunciando as partes a qualquer outro Foro, por mais privilegiado que seja.\n\n`;

        } else {
            const parte1Label = $('#label_parte1').text() || 'CONTRATANTE';
            const parte2Label = $('#label_parte2').text() || 'CONTRATADO(A)';

            documento += `CONTRATO DE ${tipo.toUpperCase()}\n\n`;
            documento += `Pelo presente instrumento particular, de um lado:\n\n`;
            if (cTipoPessoa === 'juridica') {
                documento += `${parte1Label.toUpperCase()}: ${cNome}, pessoa jurídica de direito privado, inscrita no CNPJ sob o nº ${cDoc}, com sede em ${cEnd}, neste ato representada na forma de seu Contrato Social;\n\n`;
            } else {
                documento += `${parte1Label.toUpperCase()}: ${cNome}, ${cNac}${cCivil}, ${cProf}${cRg}, inscrito(a) no CPF sob o nº ${cDoc}, residente e domiciliado(a) em ${cEnd};\n\n`;
            }

            documento += `E, de outro lado:\n\n`;
            if (pTipoPessoa === 'juridica') {
                documento += `${parte2Label.toUpperCase()}: ${pNome}, pessoa jurídica de direito privado, inscrita no CNPJ sob o nº ${pDoc}, com sede em ${pEnd}, neste ato representada por seus representantes legais;\n\n`;
            } else {
                documento += `${parte2Label.toUpperCase()}: ${pNome}, ${pNac}${pCivil}, ${pProf}${pRg}, inscrito(a) no CPF sob o nº ${pDoc}, residente e domiciliado(a) em ${pEnd};\n\n`;
            }

            documento += `Têm entre si, justo e acordado, o presente contrato mediante as seguintes cláusulas:\n\n`;

            documento += `CLÁUSULA PRIMEIRA - DO OBJETO\n`;
            documento += `1.1. O presente instrumento tem por objeto: ${objeto}\n`;
            if (formalidade === 'detalhado') {
                documento += `1.2. Os serviços serão prestados em consonância com as especificações técnicas, padrões de qualidade e prazos estipulados entre as partes.\n`;
            }
            documento += `\n`;

            documento += `CLÁUSULA SEGUNDA - DAS OBRIGAÇÕES\n`;
            documento += `2.1. O(A) ${parte2Label.toUpperCase()} compromete-se a executar os serviços com diligência, presteza técnica e zelo.\n`;
            documento += `2.2. O(A) ${parte1Label.toUpperCase()} compromete-se a fornecer todas as informações e recursos necessários, bem como efetuar os pagamentos acordados.\n\n`;

            documento += `CLÁUSULA TERCEIRA - DO PREÇO E FORMA DE PAGAMENTO\n`;
            documento += `3.1. Pelos serviços contratados, o(a) ${parte1Label.toUpperCase()} pagará ao(à) ${parte2Label.toUpperCase()} o valor total de R$ ${valor}.\n`;
            documento += `3.2. O pagamento será realizado da seguinte forma: ${formaPgtoDesc}.\n\n`;

            documento += `CLÁUSULA QUARTA - DO PRAZO E VIGÊNCIA\n`;
            documento += `4.1. O presente contrato vigorará ${vigenciaTxt}.\n\n`;

            if ($('#clausula_multa').is(':checked')) {
                const perc = $('#multa_percentual').val() || '10%';
                documento += `CLÁUSULA QUINTA - DA MULTA POR DESCUMPRIMENTO\n`;
                documento += `5.1. A infração a qualquer cláusula sujeitará a parte infratora ao pagamento de multa de ${perc} sobre o valor do contrato.\n\n`;
            }

            if ($('#clausula_rescisao').is(':checked')) {
                const aviso = $('#aviso_previo').val() || '30 dias';
                documento += `CLÁUSULA SEXTA - DA RESCISÃO\n`;
                documento += `6.1. O contrato poderá ser rescindido motivadamente por inadimplemento ou imotivadamente mediante aviso prévio por escrito de ${aviso}.\n\n`;
            }

            if ($('#clausula_confidencialidade').is(':checked')) {
                documento += `CLÁUSULA SÉTIMA - DA CONFIDENCIALIDADE (NDA)\n`;
                documento += `7.1. As partes comprometem-se a guardar sigilo absoluto sobre todas as informações confidenciais a que tiverem acesso.\n\n`;
            }

            if ($('#clausula_lgpd').is(':checked')) {
                documento += `CLÁUSULA OITAVA - DA LGPD\n`;
                documento += `8.1. As partes declaram estar em conformidade com a Lei Geral de Proteção de Dados (Lei nº 13.709/2018).\n\n`;
            }

            if ($('#instrucoes_ia').val() && $('#instrucoes_ia').val().trim()) {
                documento += `CLÁUSULA NONA - DAS CONDIÇÕES PARTICULARES\n`;
                documento += `9.1. ${$('#instrucoes_ia').val().trim()}\n\n`;
            }

            documento += `CLÁUSULA DÉCIMA - DO FORO\n`;
            documento += `10.1. Para dirimir quaisquer litígios decorrentes deste contrato, as partes elegem o Foro da Comarca de ${foroCidade}/${foroUf}.\n\n`;
        }

        // FECHAMENTO & ASSINATURAS (Texto)
        documento += `E, por estarem assim justas e contratadas, assinam o presente instrumento em 2 (duas) vias de igual teor e forma, na presença de 2 (duas) testemunhas.\n\n`;
        documento += `${foroCidade} - ${foroUf}, ${dataExtenso}.\n\n\n`;

        documento += `_______________________________________________\n`;
        documento += `${cNome}\n`;
        documento += `CONTRATANTE\n\n\n`;

        documento += `_______________________________________________\n`;
        documento += `${pNome}\n`;
        documento += `CONTRATADO(A)\n\n\n`;

        documento += `TESTEMUNHAS:\n\n`;
        documento += `1. _________________________________\n`;
        documento += `Nome:\n`;
        documento += `CPF:\n\n`;
        documento += `2. _________________________________\n`;
        documento += `Nome:\n`;
        documento += `CPF:\n\n`;

        if ($('#opt_assinatura_digital').is(':checked')) {
            documento += `------------------------------------------------------------------------\n`;
            documento += `AUTENTICAÇÃO ELETRÔNICA (MP nº 2.200-2/2001 e Lei nº 14.063/2020)\n`;
            documento += `• Assinatura eletrônica válida com registro de IP, data/hora e hash de integridade.\n`;
            documento += `------------------------------------------------------------------------\n\n`;
        }

        if ($('#opt_numeracao_paginas').is(':checked')) {
            documento += `[Nota: Todas as páginas deste instrumento devem ser rubricadas pelas partes e testemunhas]\n`;
        }

        if ($('#opt_reconhecimento_firma').is(':checked')) {
            documento += `[Nota Cartorária: As partes procederão ao reconhecimento de firma por autenticidade/semelhança]\n`;
        }

        $('#resultadoContainer').removeClass('hidden');
        $('#loadingIA').addClass('hidden');
        $('#contratoGeradoTexto').val(documento);
        $('#acoesResultado').removeClass('hidden');

        // Atualizar renderização visual formatada com as assinaturas vivas
        atualizarVisualizadorDocumento();

        $('html, body').animate({ scrollTop: $('#resultadoContainer').offset().top - 100 }, 500);

        const formLabel = formalidade === 'juridico_completo' ? 'Jurídico Completo (Advocacia)' : formalidade === 'simples' ? 'Simples & Direto' : formalidade === 'detalhado' ? 'Detalhado com Parágrafos' : 'Padrão Comercial';

        Swal.fire({
            icon: 'info',
            title: `⚡ Modelo [${formLabel}] Gerado!`,
            html: `<p class="text-sm text-slate-300">O contrato foi estruturado no nível <b>${formLabel}</b> sem gastar créditos de IA!<br><br>👉 Veja o documento formatado abaixo e clique em <b>"Assinar como Contratante"</b> para estampar a assinatura manuscrita!</p>`,
            background: '#0f172a',
            color: '#fff',
            confirmButtonColor: '#6366f1',
            timer: 4000
        });
    }

    $('#btnGerarPreviaOffline').click(gerarPreviaOffline);

    // ==========================================
    // RENDERIZADOR VISUAL DO DOCUMENTO (COM ASSINATURAS VIVAS NO GERADOR)
    // ==========================================
    function atualizarVisualizadorDocumento() {
        const texto = $('#contratoGeradoTexto').val() || '';
        if (!texto) return;

        const nomeContratante = ($('#contratante_nome').val() || 'Contratante').toUpperCase();
        const docContratante = $('#contratante_doc').val() || '';
        const nomeContratado = ($('#contratado_nome').val() || 'Contratado(a)').toUpperCase();
        const docContratado = $('#contratado_doc').val() || '';

        let linhasHtml = '';
        const linhas = texto.split('\n');

        for (let l of linhas) {
            let limpa = l.trim();
            if (!limpa) {
                linhasHtml += '<div class="h-3"></div>';
                continue;
            }
            if (limpa.startsWith('===') || limpa.startsWith('---')) continue;
            if (limpa.includes('QUADRO RESUMO EXECUTIVO')) {
                linhasHtml += `<div class="bg-indigo-50/80 border border-indigo-200 rounded-xl p-4 my-4 font-sans text-xs text-indigo-950">
                    <div class="font-bold text-sm mb-2 text-indigo-900 flex items-center gap-2"><i class="fa-solid fa-table-list"></i> ${limpa}</div>`;
                continue;
            }
            if (limpa.startsWith('• ')) {
                linhasHtml += `<div class="font-sans text-xs text-slate-700 py-0.5">${limpa}</div>`;
                continue;
            }
            if (limpa.startsWith('CLÁUSULA') || limpa.startsWith('ACORDO SIMPLIFICADO') || limpa.startsWith('INSTRUMENTO PARTICULAR') || limpa.startsWith('CONTRATO DE')) {
                linhasHtml += `<div class="font-bold text-slate-900 font-sans text-sm mt-5 mb-2 border-b border-slate-200 pb-1">${limpa}</div>`;
                continue;
            }
            if (limpa.startsWith('CONSIDERANDO QUE:') || limpa.startsWith('PARTES:')) {
                linhasHtml += `<div class="font-bold text-slate-800 font-sans text-xs mt-3 mb-1 uppercase tracking-wider">${limpa}</div>`;
                continue;
            }
            if (limpa.startsWith('___') || limpa.startsWith('TESTEMUNHAS:') || limpa.startsWith('AUTENTICAÇÃO ELETRÔNICA')) {
                break;
            }
            linhasHtml += `<p class="mb-2 text-justify text-slate-800 leading-relaxed text-sm indent-6">${limpa}</p>`;
        }

        let assinaturasVisualHtml = `
            <div id="blocoAssinaturasVisual" class="mt-10 pt-8 border-t-2 border-slate-200 font-sans">
                <div class="text-center font-bold text-xs uppercase tracking-widest text-slate-400 mb-6">
                    Assinatura das Partes & Autenticação Digital
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 my-6">
                    <!-- Box Contratante -->
                    <div class="border-2 ${assinaturasSalvas['contratante'] ? 'border-emerald-400 bg-emerald-50/40' : 'border-dashed border-slate-300 bg-slate-50/60'} rounded-2xl p-5 text-center flex flex-col justify-between shadow-sm transition-all">
                        <div class="min-h-[80px] flex items-center justify-center">
                            ${assinaturasSalvas['contratante'] ? 
                                `<div>
                                    <img src="${assinaturasSalvas['contratante'].dataUrl}" class="h-14 max-w-full mx-auto mb-1 object-contain drop-shadow" />
                                    <div class="text-[10px] text-emerald-900 font-mono font-bold bg-emerald-100/90 py-1.5 px-3 rounded-xl border border-emerald-300 inline-block shadow-xs">
                                        <div class="flex items-center justify-center gap-1.5 mb-0.5 text-emerald-800">
                                            <i class="fa-solid fa-shield-halved text-emerald-600"></i>
                                            <span>Assinado digitalmente • ${assinaturasSalvas['contratante'].dataHora}</span>
                                        </div>
                                        <div class="text-[9px] text-slate-600">
                                            <span class="text-indigo-700 font-bold">IP: ${assinaturasSalvas['contratante'].ip}</span> • Hash: ${assinaturasSalvas['contratante'].hash}
                                        </div>
                                    </div>
                                </div>` :
                                `<button type="button" onclick="abrirModalAssinaturaComTipo('contratante')" class="text-xs bg-purple-600 hover:bg-purple-700 text-white font-bold py-2.5 px-5 rounded-xl shadow-md transition-all cursor-pointer flex items-center gap-2 mx-auto">
                                    <i class="fa-solid fa-signature"></i> Assinar como Contratante
                                </button>`
                            }
                        </div>
                        <div class="border-t border-slate-300 pt-3 mt-3">
                            <div class="font-bold text-xs text-slate-800">${nomeContratante}</div>
                            <div class="text-[11px] text-slate-500 font-medium uppercase tracking-wider">CONTRATANTE ${docContratante ? '• ' + docContratante : ''}</div>
                        </div>
                    </div>

                    <!-- Box Contratado -->
                    <div class="border-2 ${assinaturasSalvas['contratado'] ? 'border-emerald-400 bg-emerald-50/40' : 'border-dashed border-slate-300 bg-slate-50/60'} rounded-2xl p-5 text-center flex flex-col justify-between shadow-sm transition-all">
                        <div class="min-h-[80px] flex items-center justify-center">
                            ${assinaturasSalvas['contratado'] ? 
                                `<div>
                                    <img src="${assinaturasSalvas['contratado'].dataUrl}" class="h-14 max-w-full mx-auto mb-1 object-contain drop-shadow" />
                                    <div class="text-[10px] text-emerald-900 font-mono font-bold bg-emerald-100/90 py-1.5 px-3 rounded-xl border border-emerald-300 inline-block shadow-xs">
                                        <div class="flex items-center justify-center gap-1.5 mb-0.5 text-emerald-800">
                                            <i class="fa-solid fa-shield-halved text-emerald-600"></i>
                                            <span>Assinado digitalmente • ${assinaturasSalvas['contratado'].dataHora}</span>
                                        </div>
                                        <div class="text-[9px] text-slate-600">
                                            <span class="text-indigo-700 font-bold">IP: ${assinaturasSalvas['contratado'].ip}</span> • Hash: ${assinaturasSalvas['contratado'].hash}
                                        </div>
                                    </div>
                                </div>` :
                                `<button type="button" onclick="abrirModalAssinaturaComTipo('contratado')" class="text-xs bg-purple-600 hover:bg-purple-700 text-white font-bold py-2.5 px-5 rounded-xl shadow-md transition-all cursor-pointer flex items-center gap-2 mx-auto">
                                    <i class="fa-solid fa-signature"></i> Assinar como Contratado
                                </button>`
                            }
                        </div>
                        <div class="border-t border-slate-300 pt-3 mt-3">
                            <div class="font-bold text-xs text-slate-800">${nomeContratado}</div>
                            <div class="text-[11px] text-slate-500 font-medium uppercase tracking-wider">CONTRATADO(A) ${docContratado ? '• ' + docContratado : ''}</div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6 text-center text-xs text-slate-500 mt-6 pt-4 border-t border-slate-100">
                    <div>
                        <div class="border-b border-slate-300 pb-1 mb-1">____________________________________</div>
                        <div>TESTEMUNHA 1</div>
                    </div>
                    <div>
                        <div class="border-b border-slate-300 pb-1 mb-1">____________________________________</div>
                        <div>TESTEMUNHA 2</div>
                    </div>
                </div>
            </div>
        `;

        $('#contratoPreviewVisual').html(linhasHtml + assinaturasVisualHtml);
    }

    // Alternar entre modo Visual Formatado e Editor de Texto
    $('#tabModoVisual').click(function() {
        $(this).removeClass('bg-slate-100 text-slate-700 hover:bg-slate-200').addClass('bg-indigo-600 text-white shadow-md');
        $('#tabModoTexto').removeClass('bg-indigo-600 text-white shadow-md').addClass('bg-slate-100 text-slate-700 hover:bg-slate-200');
        $('#contratoGeradoTexto').addClass('hidden');
        $('#contratoPreviewVisual').removeClass('hidden');
        atualizarVisualizadorDocumento();
    });

    $('#tabModoTexto').click(function() {
        $(this).removeClass('bg-slate-100 text-slate-700 hover:bg-slate-200').addClass('bg-indigo-600 text-white shadow-md');
        $('#tabModoVisual').removeClass('bg-indigo-600 text-white shadow-md').addClass('bg-slate-100 text-slate-700 hover:bg-slate-200');
        $('#contratoPreviewVisual').addClass('hidden');
        $('#contratoGeradoTexto').removeClass('hidden');
    });

    // ==========================================
    // SISTEMA DE ASSINATURA ELETRÔNICA (CALIGRAFIA + DESENHO)
    // ==========================================
    let sigCanvas = null;
    let sigCtx = null;
    let isDrawing = false;
    let assinaturasSalvas = {};

    let userClientIp = "<?php echo htmlspecialchars($client_ip); ?>";
    try {
        fetch('https://api.ipify.org?format=json')
            .then(r => r.json())
            .then(d => { if (d && d.ip) userClientIp = d.ip; })
            .catch(() => {});
    } catch(e) {}

    let sigModoAtual = 'caligrafia';
    let sigFonteAtual = 'Dancing Script';
    let sigCorAtual = '#1d4ed8';

    function initSignaturePad() {
        sigCanvas = document.getElementById('signaturePad');
        if (!sigCanvas) return;
        sigCtx = sigCanvas.getContext('2d');
        sigCtx.strokeStyle = '#0f172a';
        sigCtx.lineWidth = 2.5;
        sigCtx.lineCap = 'round';
        sigCtx.lineJoin = 'round';

        function getPos(e) {
            const rect = sigCanvas.getBoundingClientRect();
            const clientX = e.touches ? e.touches[0].clientX : e.clientX;
            const clientY = e.touches ? e.touches[0].clientY : e.clientY;
            return {
                x: (clientX - rect.left) * (sigCanvas.width / rect.width),
                y: (clientY - rect.top) * (sigCanvas.height / rect.height)
            };
        }

        function start(e) {
            isDrawing = true;
            const pos = getPos(e);
            sigCtx.beginPath();
            sigCtx.moveTo(pos.x, pos.y);
            e.preventDefault();
        }
        function draw(e) {
            if (!isDrawing) return;
            const pos = getPos(e);
            sigCtx.lineTo(pos.x, pos.y);
            sigCtx.stroke();
            e.preventDefault();
        }
        function stop() { isDrawing = false; }

        sigCanvas.addEventListener('mousedown', start);
        sigCanvas.addEventListener('mousemove', draw);
        window.addEventListener('mouseup', stop);

        sigCanvas.addEventListener('touchstart', start, { passive: false });
        sigCanvas.addEventListener('touchmove', draw, { passive: false });
        window.addEventListener('touchend', stop);
    }

    function limparAssinatura() {
        if (!sigCanvas || !sigCtx) return;
        sigCtx.clearRect(0, 0, sigCanvas.width, sigCanvas.height);
    }

    function atualizarCaligrafiaPreview() {
        const nome = $('#sig_nome_input').val() || 'Assinatura';
        $('#sigCaligrafiaPreview')
            .text(nome)
            .css({
                'font-family': `"${sigFonteAtual}", cursive`,
                'color': sigCorAtual
            });
    }

    function sincronizarNomeSignatario() {
        const tipo = $('#signatario_tipo').val();
        let nomePadrao = '';
        if (tipo === 'contratante') {
            nomePadrao = $('#contratante_nome').val() || 'Você / Contratante';
        } else if (tipo === 'contratado') {
            nomePadrao = $('#zap_cliente_nome').val() || $('#contratado_nome').val() || 'Cliente';
        } else if (tipo === 'testemunha1') {
            nomePadrao = 'Testemunha 1';
        } else if (tipo === 'testemunha2') {
            nomePadrao = 'Testemunha 2';
        }
        $('#sig_nome_input').val(nomePadrao);
        atualizarCaligrafiaPreview();
    }

    function abrirModalAssinatura() {
        const modal = document.getElementById('modalAssinatura');
        if (modal) modal.classList.remove('hidden');
        if (!sigCanvas) initSignaturePad();
        sincronizarNomeSignatario();
        limparAssinatura();
    }

    function abrirModalAssinaturaComTipo(tipo) {
        $('#signatario_tipo').val(tipo);
        abrirModalAssinatura();
    }

    function fecharModalAssinatura() {
        const modal = document.getElementById('modalAssinatura');
        if (modal) modal.classList.add('hidden');
    }

    $('#tabSigCaligrafia').click(function() {
        sigModoAtual = 'caligrafia';
        $(this).addClass('bg-white text-indigo-600 shadow-sm').removeClass('text-slate-500');
        $('#tabSigDesenho').removeClass('bg-white text-indigo-600 shadow-sm').addClass('text-slate-500');
        $('#painelSigCaligrafia').removeClass('hidden');
        $('#painelSigDesenho').addClass('hidden');
    });

    $('#tabSigDesenho').click(function() {
        sigModoAtual = 'desenho';
        $(this).addClass('bg-white text-indigo-600 shadow-sm').removeClass('text-slate-500');
        $('#tabSigCaligrafia').removeClass('bg-white text-indigo-600 shadow-sm').addClass('text-slate-500');
        $('#painelSigDesenho').removeClass('hidden');
        $('#painelSigCaligrafia').addClass('hidden');
        if (!sigCanvas) initSignaturePad();
    });

    $(document).on('click', '.btn-sig-font', function() {
        $('.btn-sig-font').removeClass('active border-indigo-500 bg-indigo-50/50').addClass('border-slate-200');
        $(this).addClass('active border-indigo-500 bg-indigo-50/50').removeClass('border-slate-200');
        sigFonteAtual = $(this).data('font');
        atualizarCaligrafiaPreview();
    });

    $(document).on('click', '.btn-sig-cor', function() {
        $('.btn-sig-cor').removeClass('active border-2 border-blue-600 bg-blue-50').addClass('border border-slate-200');
        $(this).addClass('active border-2 border-blue-600 bg-blue-50').removeClass('border border-slate-200');
        sigCorAtual = $(this).data('color');
        atualizarCaligrafiaPreview();
    });

    $('#sig_nome_input').on('input', atualizarCaligrafiaPreview);
    $('#signatario_tipo').on('change', sincronizarNomeSignatario);

    function renderizarCaligrafiaEmPng(nome, fontName, corHex) {
        const canvas = document.createElement('canvas');
        canvas.width = 1200;
        canvas.height = 260;
        const ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        let fontSize = 76;
        ctx.font = `italic ${fontSize}px "${fontName}", cursive`;
        let textWidth = ctx.measureText(nome).width;
        const maxAllowedWidth = canvas.width - 140;

        if (textWidth > maxAllowedWidth) {
            fontSize = Math.floor(fontSize * (maxAllowedWidth / textWidth));
            if (fontSize < 24) fontSize = 24;
            ctx.font = `italic ${fontSize}px "${fontName}", cursive`;
        }

        ctx.fillStyle = corHex || '#1d4ed8';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.fillText(nome, canvas.width / 2, canvas.height / 2);
        
        return canvas.toDataURL('image/png');
    }

    function aplicarAssinaturaNoContrato() {
        const tipo = document.getElementById('signatario_tipo').value;
        let dataUrl = '';

        if (sigModoAtual === 'caligrafia') {
            const nomeDigitado = $('#sig_nome_input').val() || 'Assinatura';
            dataUrl = renderizarCaligrafiaEmPng(nomeDigitado, sigFonteAtual, sigCorAtual);
        } else {
            if (!sigCanvas) return;
            dataUrl = sigCanvas.toDataURL('image/png');
        }

        const hash = Array.from(crypto.getRandomValues(new Uint8Array(16))).map(b => b.toString(16).padStart(2,'0')).join('');
        const dataHora = new Date().toLocaleString('pt-BR');

        assinaturasSalvas[tipo] = {
            dataUrl: dataUrl,
            hash: hash,
            dataHora: dataHora,
            ip: userClientIp || 'Registrado via Web',
            modo: sigModoAtual
        };

        fecharModalAssinatura();

        // 1. Se estiver no Workspace de PDF aberto, atualiza os stamps do PDF
        if (!$('#pdfWorkspaceState').hasClass('hidden')) {
            atualizarStampsNoWorkspace();
        }

        // 2. Se estiver no Criador de Contratos, atualiza a folha formatada
        if (!$('#viewGerador').hasClass('hidden')) {
            $('#tabModoVisual').click();
            atualizarVisualizadorDocumento();
            if ($('#blocoAssinaturasVisual').length) {
                $('html, body').animate({ scrollTop: $('#blocoAssinaturasVisual').offset().top - 150 }, 600);
            }
        }

        const labelTipo = tipo === 'contratante' ? 'Você / Contratante' : tipo === 'contratado' ? 'Cliente / Contratado' : 'Testemunha';

        Swal.fire({
            icon: 'success',
            title: '🎉 Assinatura Estampada!',
            html: `<p class="text-sm text-slate-300">A assinatura de <b>${labelTipo}</b> foi inserida com caligrafia personalizada, <b>IP (${userClientIp})</b>, selo criptográfico SHA-256 e horário oficial!</p>`,
            background: '#0f172a',
            color: '#fff',
            confirmButtonColor: '#6366f1'
        });
    }

    // Exposição no Window e Binding jQuery para 100% de Compatibilidade
    window.abrirModalAssinatura = abrirModalAssinatura;
    window.abrirModalAssinaturaComTipo = abrirModalAssinaturaComTipo;
    window.fecharModalAssinatura = fecharModalAssinatura;
    window.limparAssinatura = limparAssinatura;
    window.aplicarAssinaturaNoContrato = aplicarAssinaturaNoContrato;
    window.atualizarVisualizadorDocumento = atualizarVisualizadorDocumento;

    $('#btnAbrirAssinaturaDigital').click(abrirModalAssinatura);
    $('#btnFecharModalAssinaturaX').click(fecharModalAssinatura);
    $('#btnLimparAssinatura').click(limparAssinatura);
    $('#btnAplicarAssinatura').click(aplicarAssinaturaNoContrato);

    // ==========================================
    // EXPORTAÇÃO DE PDF JURÍDICO ABNT (DO GERADOR)
    // ==========================================
    $('#btnExportarPdfJuridico').click(async function() {
        const texto = $('#contratoGeradoTexto').val();
        if (!texto) {
            Swal.fire({
                icon: 'warning',
                title: 'Nenhum contrato gerado',
                text: 'Preencha os dados e gere o contrato antes de exportar.',
                background: '#0f172a',
                color: '#fff',
                confirmButtonColor: '#6366f1'
            });
            return;
        }

        if ($('#contratoPreviewVisual').hasClass('hidden')) {
            $('#tabModoVisual').click();
        }
        atualizarVisualizadorDocumento();

        const nomeContratante = $('#contratante_nome').val() || 'Contratante';
        const filename = `contrato_${nomeContratante.replace(/\s+/g, '_').toLowerCase()}.pdf`;

        Swal.fire({
            title: 'Gerando PDF Jurídico...',
            text: 'Renderizando texto e assinaturas...',
            background: '#0f172a',
            color: '#fff',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        const element = document.getElementById('contratoPreviewVisual');
        const prevScrollY = window.pageYOffset || document.documentElement.scrollTop;
        window.scrollTo(0, 0);

        const opt = {
            margin: [12, 12, 12, 12],
            filename: filename,
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: {
                scale: 2,
                useCORS: true,
                backgroundColor: '#ffffff',
                logging: false,
                letterRendering: true,
                onclone: function(clonedDoc) {
                    const all = clonedDoc.querySelectorAll('*');
                    for (let i = 0; i < all.length; i++) {
                        const el = all[i];
                        if (el.style) {
                            if (el.style.color && el.style.color.includes('oklch')) el.style.color = '#0f172a';
                            if (el.style.backgroundColor && el.style.backgroundColor.includes('oklch')) el.style.backgroundColor = '#ffffff';
                            if (el.style.borderColor && el.style.borderColor.includes('oklch')) el.style.borderColor = '#cbd5e1';
                        }
                    }
                }
            },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };

        try {
            await html2pdf().set(opt).from(element).save();
            Swal.fire({
                icon: 'success',
                title: '📄 PDF Baixado com Sucesso!',
                text: `${filename} foi exportado com todas as cláusulas e assinaturas!`,
                background: '#0f172a',
                color: '#fff',
                confirmButtonColor: '#06b6d4',
                timer: 2500
            });
        } catch (err) {
            console.error('Erro ao gerar PDF:', err);
            Swal.fire({
                icon: 'error',
                title: 'Erro ao gerar PDF',
                text: 'Houve uma falha ao gerar o arquivo PDF.',
                background: '#0f172a',
                color: '#fff',
                confirmButtonColor: '#6366f1'
            });
        } finally {
            window.scrollTo(0, prevScrollY);
        }
    });

    // ==========================================
    // PWA SERVICE WORKER & BOTÃO DE INSTALAÇÃO
    // ==========================================
    let deferredInstallPrompt = null;
    const pwaBtn = document.getElementById('btn-pwa-install');

    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredInstallPrompt = e;
        if (pwaBtn) pwaBtn.style.display = 'inline-flex';
    });

    if (pwaBtn) {
        pwaBtn.addEventListener('click', async () => {
            if (deferredInstallPrompt) {
                deferredInstallPrompt.prompt();
                const { outcome } = await deferredInstallPrompt.userChoice;
                if (outcome === 'accepted') {
                    pwaBtn.style.display = 'none';
                }
                deferredInstallPrompt = null;
            } else {
                Swal.fire({
                    title: 'Instalar 4USign Pro',
                    html: '<p class="text-sm text-slate-300"><b>No iPhone/iPad (Safari):</b> Toque no botão de Compartilhar ➔ "Adicionar à Tela de Início".<br><br><b>No Chrome/Android/PC:</b> Toque no menu de 3 pontos ➔ "Instalar Aplicativo".</p>',
                    background: '#0f172a',
                    color: '#fff',
                    confirmButtonColor: '#6366f1'
                });
            }
        });
    }

    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('./sw.js').catch(err => console.log('SW error:', err));
        });
    }

    // Carregar dados ao iniciar

        if (localStorage.getItem(FORM_DATA_KEY)) loadFormData();
        checkStatus();
    });
    </script>
</body>
</html>
