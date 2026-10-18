<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="twitter:card" content="summary" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Digital Smart Agent (DSA) — We make your work easy</title>

    <link rel="dns-prefetch" href="https://www.digitalsmartagent.com/">
    <link rel="dns-prefetch" href="https://www.google.com/">

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">

    <!-- Site Icons -->
    <link rel="shortcut icon" href="{{ asset('assets/trans-app-icon.png') }}" type="image/x-icon" />
    <link rel="apple-touch-icon" href="{{ asset('assets/trans-app-icon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/trans-app-icon.png') }}">

    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="author" content="https://www.digitalsmartagent.com/" />
    <meta http-equiv="Content-Language" content="en">
    <meta name="Copyright" content="Copyright 2026 @  digitalsmartagent.com" />
    <meta name="country" content="India" />
    <meta name="robots" content="index, follow" />
    <meta name="description"
        content="Digital Smart Agent (DSA) — an innovative platform to streamline and optimize various aspects for your Post Office Agents, Collection Agents to manage daily customer collections, transactions, expenses, Monthly Posting Reports, WhatsApp updates." />
    <meta name="Robots" content="noodp, noydir" />
    <meta property="og:title" content="Digital Smart Agent (DSA) — We make your work easy">
    <meta property="og:description"
        content="Digital Smart Agent (DSA) — an innovative platform to streamline and optimize various aspects for your Post Office Agents, Collection Agents to manage daily customer collections, transactions, expenses, Monthly Posting Reports, WhatsApp updates.">
    <meta property="og:image" content="{{ asset('assets/og_image.png') }}">
    <meta property="og:url" content="https://www.digitalsmartagent.com">
    <meta property="og:type" content="website">


    <link rel="canonical" href="https://www.digitalsmartagent.com/" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/index.css') }}" />
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Sora:wght@600;700;800&display=swap"
        rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#001d41',
                        secondary: '#800000',
                        accent: '#870a30',
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        display: ['Sora', 'sans-serif'],
                    },
                    boxShadow: {
                        'glow': '0 10px 40px -10px rgba(135,10,48,0.5)',
                        'soft': '0 20px 60px -20px rgba(0,29,65,0.25)',
                    }
                }
            }
        }
    </script>
    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #0b1220;
            background: #ffffff;
        }

        .font-display {
            font-family: 'Sora', sans-serif;
        }

        .gradient-text {
            background: linear-gradient(90deg, #001d41 0%, #870a30 60%, #800000 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #001d41 0%, #3a0a26 55%, #870a30 100%);
        }

        .gradient-soft {
            background: radial-gradient(1200px 600px at 10% -10%, rgba(0, 29, 65, 0.08), transparent 60%),
                radial-gradient(900px 500px at 100% 0%, rgba(135, 10, 48, 0.10), transparent 60%);
        }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.6);
        }

        .glass-dark {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, #870a30, #800000);
            color: #fff;
            transition: all .3s ease;
            box-shadow: 0 10px 30px -10px rgba(135, 10, 48, 0.6);
        }

        .btn-dark {
            background: linear-gradient(135deg, #001d41, #800000);
            color: #fff;
            transition: all .3s ease;
            box-shadow: 0 10px 30px -10px rgba(135, 10, 48, 0.6);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 40px -10px rgba(135, 10, 48, 0.75);
        }

        .btn-ghost {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.25);
            transition: all .3s ease;
        }

        .btn-ghost:hover {
            background: rgba(255, 255, 255, 0.18);
        }

        .card {
            background: #ffffff;
            border: 1px solid rgba(0, 29, 65, 0.08);
            border-radius: 20px;
            box-shadow: 0 10px 30px -12px rgba(0, 29, 65, 0.18), 0 4px 12px -4px rgba(135, 10, 48, 0.08);
            transition: all .35s ease;
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 30px 60px -20px rgba(0, 29, 65, 0.35), 0 12px 24px -8px rgba(135, 10, 48, 0.18);
            border-color: rgba(135, 10, 48, 0.2);
        }

        .icon-wrap {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: linear-gradient(135deg, rgba(0, 29, 65, 0.08), rgba(135, 10, 48, 0.12));
            color: #870a30;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .step-num {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, #001d41, #870a30);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .phone {
            width: 280px;
            height: 560px;
            border-radius: 42px;
            background: linear-gradient(180deg, #0a0f1c, #1b0a16);
            padding: 14px;
            box-shadow: 0 40px 80px -20px rgba(0, 29, 65, 0.45), 0 0 0 1px rgba(255, 255, 255, 0.05) inset;
            position: relative;
        }

        .phone::before {
            content: '';
            position: absolute;
            top: 14px;
            left: 50%;
            transform: translateX(-50%);
            width: 110px;
            height: 22px;
            background: #000;
            border-radius: 14px;
            z-index: 5;
        }

        .phone-screen {
            width: 100%;
            height: 100%;
            border-radius: 30px;
            overflow: hidden;
            background: linear-gradient(160deg, #fff 0%, #fdf3f6 100%);
            position: relative;
        }

        .reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: all .8s ease;
        }

        .reveal.in {
            opacity: 1;
            transform: translateY(0);
        }

        .nav-link {
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -4px;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #870a30, #001d41);
            transition: width .3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .floating {
            animation: floaty 6s ease-in-out infinite;
        }

        @keyframes floaty {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-12px);
            }
        }

        .blob {
            position: absolute;
            filter: blur(60px);
            opacity: .5;
            border-radius: 50%;
            pointer-events: none;
        }

        .phone-img {
            border-radius: 28px;
            overflow: hidden;
            position: relative;
            background: linear-gradient(180deg, #0a0f1c, #1b0a16);
            padding: 8px;
            box-shadow: 0 30px 60px -20px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.06) inset;
            aspect-ratio: 9/19;
        }

        .phone-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 22px;
            display: block;
        }

        .phone-label {
            position: absolute;
            bottom: 14px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.6);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 999px;
            backdrop-filter: blur(8px);
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .phone-cta {
            background: linear-gradient(160deg, #001d41, #870a30);
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body class="antialiased">

    <!-- NAV -->
    <header class="fixed top-0 inset-x-0 z-50">
        <div class="max-w-7xl mx-auto px-6 mt-4">
            <nav class="glass rounded-2xl px-5 py-3 flex items-center justify-between shadow-soft">
                <a href="#home" class="flex items-center gap-2">
                    <img src="assets/trans_app_logo.png" alt="DSA app icon"
                        class="w-11 h-11 p-1 rounded-xl shadow-glow object-contain bg-white" />
                    <div class="leading-tight">
                        <div class="font-display font-extrabold text-primary text-lg">DigitalSmartAgent</div>
                        <div class="text-[10px] uppercase tracking-widest text-accent font-semibold">Make Your Work Easy
                        </div>
                    </div>
                </a>
                <div class="hidden md:flex items-center gap-8 text-sm font-medium text-primary/80">
                    <a href="#about" class="nav-link">About</a>
                    <a href="#features" class="nav-link">Features</a>
                    <a href="#benefits" class="nav-link">Benefits</a>
                    <a href="#how" class="nav-link">How it works</a>
                    <a href="#testimonials" class="nav-link">Reviews</a>
                    <a href="#contact" class="nav-link">Contact</a>
                </div>
                <div class="hidden sm:flex items-center gap-2">
                    <button onclick="openRequestModal()"
                        class="btn-ghost text-primary border border-primary/15 bg-white text-sm font-semibold px-4 py-2.5 rounded-xl inline-flex items-center gap-2 hover:border-accent hover:text-accent transition">
                        <i class="fa-solid fa-file-signature text-xs"></i> Request Software
                    </button>
                </div>
                <div class="gap-4">
                    <a href="/agents"
                        class="btn-dark text-sm font-semibold px-5 py-2.5 rounded-xl hidden sm:inline-flex items-center gap-2">
                        <i class="fa-solid fa-chalkboard-user text-xs"></i> Agent Login
                    </a>
                </div>
                <button id="menuBtn" class="md:hidden text-primary text-xl"><i class="fa-solid fa-bars"></i></button>
            </nav>
            <div id="mobileMenu" class="hidden md:hidden glass mt-2 rounded-2xl p-4 space-y-3 text-primary font-medium">
                <a href="#about" class="block">About</a>
                <a href="#features" class="block">Features</a>
                <a href="#benefits" class="block">Benefits</a>
                <a href="#how" class="block">How it works</a>
                <a href="#testimonials" class="block">Reviews</a>
                <a href="#contact" class="block">Contact</a>
            </div>
        </div>
    </header>

    <!-- HERO -->
    <section id="home" class="relative pt-36 pb-24 overflow-hidden gradient-bg text-white">
        <div class="blob bg-accent w-[400px] h-[400px] -top-20 -left-20"></div>
        <div class="blob bg-secondary w-[500px] h-[500px] -bottom-40 -right-20 opacity-40"></div>
        <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center relative">
            <div class="reveal">
                <span
                    class="inline-flex items-center gap-2 glass-dark text-xs font-semibold px-4 py-2 rounded-full mb-6">
                    <span class="w-2 h-2 rounded-full bg-accent animate-pulse"></span>
                    Built for Post Office & Collection Agents
                </span>
                <h1 class="font-display text-5xl md:text-6xl lg:text-7xl font-extrabold leading-[1.05] tracking-tight">
                    Digital <span class="block">Smart Agent</span>
                </h1>
                <p class="mt-5 text-xl md:text-2xl text-white/80 font-medium">"We make your work easy"</p>
                <p class="mt-6 text-white/70 text-lg max-w-xl leading-relaxed">
                    The all-in-one mobile app to manage customers, track daily & monthly collections,
                    record expenses, generate professional PDF reports, and notify customers on WhatsApp —
                    all from your pocket.
                </p>
                <div class="mt-9 flex gap-2">
                     <button onclick="openRequestModal()"
                        class="btn-ghost text-primary border border-primary/15 bg-white text-sm font-semibold px-4 py-2.5 rounded-xl inline-flex items-center gap-2 hover:border-accent hover:text-accent transition">
                        <i class="fa-solid fa-file-signature text-xs"></i>Onboarding Request
                    </button>
                    <a href="#contact"
                        class="btn-ghost px-4 py-4 rounded-xl font-semibold inline-flex items-center gap-2">
                        <i class="fa-regular fa-envelope"></i> Contact Us
                    </a>
                </div>
                <div class="mt-10 flex items-center gap-8 text-sm text-white/70">
                    <div class="flex items-center gap-2"><i class="fa-solid fa-shield-halved text-accent"></i> Secure
                        &
                        Private</div>
                    <div class="flex items-center gap-2"><i class="fa-solid fa-mobile-screen text-accent"></i> Android
                        Ready</div>
                    <div class="flex items-center gap-2"><i class="fa-solid fa-star text-accent"></i> 4.9 Rated</div>
                </div>
            </div>

            <!-- Phone mockup -->
            <div class="relative flex justify-center reveal">
                <div class="absolute -inset-10 bg-accent/30 rounded-full blur-3xl"></div>
                <div class="phone floating relative">
                    <div class="phone-screen p-5 pt-10">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-[10px] text-primary/60 font-semibold uppercase">Welcome back</div>
                                <div class="font-display font-bold text-primary">Ravi Kumar</div>
                            </div>
                            <div
                                class="w-9 h-9 rounded-full gradient-bg text-white flex items-center justify-center text-sm font-bold">
                                R</div>
                        </div>
                        <div class="mt-4 rounded-2xl p-4 text-white"
                            style="background:linear-gradient(135deg,#001d41,#870a30)">
                            <div class="text-[11px] uppercase tracking-wider opacity-80">Today's Collection</div>
                            <div class="font-display text-2xl font-extrabold mt-1">₹ 24,580</div>
                            <div class="flex justify-between text-[11px] mt-3 opacity-90">
                                <span><i class="fa-solid fa-arrow-up"></i> Cash 14,200</span>
                                <span><i class="fa-solid fa-arrow-up"></i> Online 10,380</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-2 mt-4">
                            <div class="bg-white rounded-xl p-3 text-center shadow-sm">
                                <i class="fa-solid fa-users text-accent"></i>
                                <div class="text-[10px] mt-1 font-semibold text-primary">128</div>
                                <div class="text-[9px] text-primary/60">Customers</div>
                            </div>
                            <div class="bg-white rounded-xl p-3 text-center shadow-sm">
                                <i class="fa-solid fa-receipt text-accent"></i>
                                <div class="text-[10px] mt-1 font-semibold text-primary">42</div>
                                <div class="text-[9px] text-primary/60">Today</div>
                            </div>
                            <div class="bg-white rounded-xl p-3 text-center shadow-sm">
                                <i class="fa-solid fa-clock text-accent"></i>
                                <div class="text-[10px] mt-1 font-semibold text-primary">07</div>
                                <div class="text-[9px] text-primary/60">Pending</div>
                            </div>
                        </div>
                        <div class="mt-4 bg-white rounded-2xl p-3 shadow-sm">
                            <div class="flex items-center justify-between mb-2">
                                <div class="text-[11px] font-bold text-primary">Recent Activity</div>
                                <i class="fa-solid fa-ellipsis text-primary/40"></i>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between text-[11px]">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-7 h-7 rounded-lg bg-accent/10 text-accent flex items-center justify-center">
                                            <i class="fa-solid fa-indian-rupee-sign text-[10px]"></i>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-primary">Suresh M.</div>
                                            <div class="text-primary/50 text-[9px]">Cash · 10:32 AM</div>
                                        </div>
                                    </div>
                                    <div class="font-bold text-primary">₹ 1,200</div>
                                </div>
                                <div class="flex items-center justify-between text-[11px]">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-7 h-7 rounded-lg bg-primary/10 text-primary flex items-center justify-center">
                                            <i class="fa-solid fa-mobile text-[10px]"></i>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-primary">Anita R.</div>
                                            <div class="text-primary/50 text-[9px]">UPI · 11:05 AM</div>
                                        </div>
                                    </div>
                                    <div class="font-bold text-primary">₹ 850</div>
                                </div>
                                <div class="flex items-center justify-between text-[11px]">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-7 h-7 rounded-lg bg-accent/10 text-accent flex items-center justify-center">
                                            <i class="fa-brands fa-whatsapp text-[10px]"></i>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-primary">Reminder sent</div>
                                            <div class="text-primary/50 text-[9px]">12 customers</div>
                                        </div>
                                    </div>
                                    <i class="fa-solid fa-check text-green-500"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- floating badges -->
                <div class="absolute -left-6 top-16 glass rounded-2xl p-3 shadow-soft hidden md:flex items-center gap-2 floating"
                    style="animation-delay:-2s">
                    <div class="w-9 h-9 rounded-lg gradient-bg text-white flex items-center justify-center"><i
                            class="fa-solid fa-cloud-arrow-up"></i></div>
                    <div class="text-xs">
                        <div class="font-bold text-primary">DOP Portal</div>
                        <div class="text-primary/60">Auto-sync lots</div>
                    </div>
                </div>
                <div class="absolute -right-6 bottom-24 glass rounded-2xl p-3 shadow-soft hidden md:flex items-center gap-2 floating"
                    style="animation-delay:-4s">
                    <div class="w-9 h-9 rounded-lg gradient-bg text-white flex items-center justify-center"><i
                            class="fa-solid fa-file-pdf"></i></div>
                    <div class="text-xs">
                        <div class="font-bold text-primary">PDF Report</div>
                        <div class="text-primary/60">One tap export</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ABOUT -->
    <section id="about" class="py-24 gradient-soft relative">
        <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-14 items-center">
            <div class="reveal">
                <span class="text-accent font-bold uppercase text-xs tracking-[0.2em]">About DSA</span>
                <h2 class="font-display text-4xl md:text-5xl font-extrabold text-primary mt-3 leading-tight">
                    Simplify collections, <span class="gradient-text">digitally</span>.
                </h2>
                <p class="mt-5 text-primary/70 text-lg leading-relaxed">
                    Digital Smart Agent (DSA) is a purpose-built mobile application that helps Post Office Agents
                    and collection agents replace messy notebooks and spreadsheets with a clean, professional digital
                    workflow.
                </p>
                <p class="mt-4 text-primary/70 text-lg leading-relaxed">
                    From customer onboarding and daily collections to expense tracking, pending reports, and
                    WhatsApp customer updates — DSA brings everything you need into one elegant, easy-to-use app.
                </p>
                <div class="mt-8 grid grid-cols-3 gap-4">
                    <div class="card p-5 text-center">
                        <div class="font-display text-3xl font-extrabold gradient-text">10k+</div>
                        <div class="text-xs text-primary/60 mt-1 font-semibold">Customers Managed</div>
                    </div>
                    <div class="card p-5 text-center">
                        <div class="font-display text-3xl font-extrabold gradient-text">100+</div>
                        <div class="text-xs text-primary/60 mt-1 font-semibold">Active Agents</div>
                    </div>
                    <div class="card p-5 text-center">
                        <div class="font-display text-3xl font-extrabold gradient-text">99%</div>
                        <div class="text-xs text-primary/60 mt-1 font-semibold">Accuracy</div>
                    </div>
                </div>
            </div>
            <div class="relative reveal">
                <div class="card p-8 shadow-soft">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="icon-wrap"><i class="fa-solid fa-briefcase"></i></div>
                        <div>
                            <div class="font-display font-bold text-primary">Built for Agents</div>
                            <div class="text-xs text-primary/60">Trusted by field collectors</div>
                        </div>
                    </div>
                    <ul class="space-y-3 text-primary/80 text-sm">
                        <li class="flex gap-3"><i class="fa-solid fa-check text-accent mt-1"></i> Replace paper logs
                            with a professional digital record</li>
                        <li class="flex gap-3"><i class="fa-solid fa-check text-accent mt-1"></i> Instantly find any
                            customer's history & dues</li>
                        <li class="flex gap-3"><i class="fa-solid fa-check text-accent mt-1"></i> Auto-generate
                            monthly summary reports</li>
                        <li class="flex gap-3"><i class="fa-solid fa-check text-accent mt-1"></i> Share receipts &
                            reminders via WhatsApp</li>
                        <li class="flex gap-3"><i class="fa-solid fa-check text-accent mt-1"></i> Track both cash and
                            online (UPI) payments separately</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <section id="features" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto reveal">
                <span class="text-accent font-bold uppercase text-xs tracking-[0.2em]">Features</span>
                <h2 class="font-display text-4xl md:text-5xl font-extrabold text-primary mt-3">
                    Everything you need, <span class="gradient-text">in one app</span>
                </h2>
                <p class="mt-4 text-primary/60 text-lg">Powerful tools designed specifically for collection agents.</p>
            </div>
            <div class="mt-14 grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="card p-7 reveal">
                    <div class="icon-wrap"><i class="fa-solid fa-wand-magic-sparkles"></i></div>
                    <h3 class="font-display font-bold text-primary mt-5 text-lg">One-tap Lot Building</h3>
                    <p class="text-primary/60 mt-2 text-sm">Enter short codes (150, 145, 160…) and DSA auto-adds all
                        accounts to the lot in seconds.</p>
                </div>
                <div class="card p-7 reveal">
                    <div class="icon-wrap"><i class="fa-solid fa-cloud-arrow-up"></i></div>
                    <h3 class="font-display font-bold text-primary mt-5 text-lg">Direct DOP Portal Sync</h3>
                    <p class="text-primary/60 mt-2 text-sm">Push lots directly to the India Post DOP portal — no
                        re-typing, no CSV, no errors.</p>
                </div>
                <div class="card p-7 reveal">
                    <div class="icon-wrap"><i class="fa-solid fa-file-invoice-dollar"></i></div>
                    <h3 class="font-display font-bold text-primary mt-5 text-lg">Auto Deposit Slips</h3>
                    <p class="text-primary/60 mt-2 text-sm">Every synced lot generates a branded deposit slip and
                        receipt bundle instantly.</p>
                </div>
                <div class="card p-7 reveal">
                    <div class="icon-wrap"><i class="fa-solid fa-calculator"></i></div>
                    <h3 class="font-display font-bold text-primary mt-5 text-lg">Auto Commission & TDS</h3>
                    <p class="text-primary/60 mt-2 text-sm">Commission, TDS, rebates and default fees are calculated
                        per lot — no manual math.</p>
                </div>
                <div class="card p-7 reveal">
                    <div class="icon-wrap"><i class="fa-solid fa-triangle-exclamation"></i></div>
                    <h3 class="font-display font-bold text-primary mt-5 text-lg">Over-limit Auto-move</h3>
                    <p class="text-primary/60 mt-2 text-sm">Cross the ₹20,000 lot limit? DSA auto-moves overflow into
                        the next lot — zero effort.</p>
                </div>
                <div class="card p-7 reveal">
                    <div class="icon-wrap"><i class="fa-brands fa-whatsapp"></i></div>
                    <h3 class="font-display font-bold text-primary mt-5 text-lg">WhatsApp Auto-updates</h3>
                    <p class="text-primary/60 mt-2 text-sm">Customers get receipts, reminders and monthly posting
                        reports on WhatsApp automatically.</p>
                </div>
                <div class="card p-7 reveal">
                    <div class="icon-wrap"><i class="fa-solid fa-users-gear"></i></div>
                    <h3 class="font-display font-bold text-primary mt-5 text-lg">Multi-Agent Workspace</h3>
                    <p class="text-primary/60 mt-2 text-sm">Onboard DOP agents & ground-floor sub-agents. Each gets
                        their own field workspace.</p>
                </div>
                <div class="card p-7 reveal">
                    <div class="icon-wrap"><i class="fa-solid fa-file-pdf"></i></div>
                    <h3 class="font-display font-bold text-primary mt-5 text-lg">MPR & PDF Reports</h3>
                    <p class="text-primary/60 mt-2 text-sm">Monthly Posting Reports and daily summaries — ready to
                        download & share, professionally branded.</p>
                </div>
                <!-- Feature cards -->
                <div class="card p-7 reveal">
                    <div class="icon-wrap"><i class="fa-solid fa-users"></i></div>
                    <h3 class="font-display font-bold text-primary mt-5 text-lg">Customer Management</h3>
                    <p class="text-primary/60 mt-2 text-sm leading-relaxed">Add, edit, and organize all your customers
                        in one secure place with searchable profiles.</p>
                </div>
                <div class="card p-7 reveal">
                    <div class="icon-wrap"><i class="fa-solid fa-calendar-days"></i></div>
                    <h3 class="font-display font-bold text-primary mt-5 text-lg">Daily & Monthly Collections</h3>
                    <p class="text-primary/60 mt-2 text-sm leading-relaxed">Log every collection effortlessly and view
                        daily, weekly, and monthly totals at a glance.</p>
                </div>
                <div class="card p-7 reveal">
                    <div class="icon-wrap"><i class="fa-solid fa-wallet"></i></div>
                    <h3 class="font-display font-bold text-primary mt-5 text-lg">Expense Tracking</h3>
                    <p class="text-primary/60 mt-2 text-sm leading-relaxed">Record business expenses with categories so
                        your profit and balance stay accurate.</p>
                </div>
                <div class="card p-7 reveal">
                    <div class="icon-wrap"><i class="fa-solid fa-money-bill-transfer"></i></div>
                    <h3 class="font-display font-bold text-primary mt-5 text-lg">Cash & Online Collection</h3>
                    <p class="text-primary/60 mt-2 text-sm leading-relaxed">Separately track cash and UPI/online
                        payments with automatic totals and breakdowns.</p>
                </div>
                <div class="card p-7 reveal">
                    <div class="icon-wrap"><i class="fa-solid fa-chart-line"></i></div>
                    <h3 class="font-display font-bold text-primary mt-5 text-lg">Daily Summary Reports</h3>
                    <p class="text-primary/60 mt-2 text-sm leading-relaxed">Get a clean end-of-day snapshot of
                        collections, expenses, and net balance in seconds.</p>
                </div>
                <div class="card p-7 reveal">
                    <div class="icon-wrap"><i class="fa-solid fa-user-clock"></i></div>
                    <h3 class="font-display font-bold text-primary mt-5 text-lg">Pending Customer Reports</h3>
                    <p class="text-primary/60 mt-2 text-sm leading-relaxed">Identify customers with pending dues
                        instantly and follow up with a single tap.</p>
                </div>
                <div class="card p-7 reveal">
                    <div class="icon-wrap"><i class="fa-solid fa-file-pdf"></i></div>
                    <h3 class="font-display font-bold text-primary mt-5 text-lg">PDF Report Download</h3>
                    <p class="text-primary/60 mt-2 text-sm leading-relaxed">Export beautifully formatted PDF reports
                        for records, sharing, or audit at any time.</p>
                </div>
                <div class="card p-7 reveal">
                    <div class="icon-wrap"><i class="fa-brands fa-whatsapp"></i></div>
                    <h3 class="font-display font-bold text-primary mt-5 text-lg">WhatsApp Notifications</h3>
                    <p class="text-primary/60 mt-2 text-sm leading-relaxed">Send instant receipts, reminders, and
                        updates to customers directly via WhatsApp.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- BENEFITS -->
    <section id="benefits" class="py-24 gradient-soft">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto reveal">
                <span class="text-accent font-bold uppercase text-xs tracking-[0.2em]">Benefits</span>
                <h2 class="font-display text-4xl md:text-5xl font-extrabold text-primary mt-3">
                    Why agents <span class="gradient-text">love DSA</span>
                </h2>
            </div>

            <div class="mt-14 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="card p-7 reveal">
                    <div class="icon-wrap"><i class="fa-solid fa-stopwatch"></i></div>
                    <h3 class="font-display font-bold text-primary mt-5 text-lg">Save Time</h3>
                    <p class="text-primary/60 mt-2 text-sm">Cut hours of manual bookkeeping into a few minutes a day.
                    </p>
                </div>
                <div class="card p-7 reveal">
                    <div class="icon-wrap"><i class="fa-solid fa-hand-sparkles"></i></div>
                    <h3 class="font-display font-bold text-primary mt-5 text-lg">Reduce Manual Work</h3>
                    <p class="text-primary/60 mt-2 text-sm">No more registers, calculators, or rewriting entries.</p>
                </div>
                <div class="card p-7 reveal">
                    <div class="icon-wrap"><i class="fa-solid fa-coins"></i></div>
                    <h3 class="font-display font-bold text-primary mt-5 text-lg">Easy Financial Tracking</h3>
                    <p class="text-primary/60 mt-2 text-sm">Always know your cash flow, expenses, and balance.</p>
                </div>
                <div class="card p-7 reveal">
                    <div class="icon-wrap"><i class="fa-solid fa-bell"></i></div>
                    <h3 class="font-display font-bold text-primary mt-5 text-lg">Instant Customer Updates</h3>
                    <p class="text-primary/60 mt-2 text-sm">Keep customers informed automatically through WhatsApp.</p>
                </div>
                <div class="card p-7 reveal">
                    <div class="icon-wrap"><i class="fa-solid fa-handshake"></i></div>
                    <h3 class="font-display font-bold text-primary mt-5 text-lg">Better Collection Management</h3>
                    <p class="text-primary/60 mt-2 text-sm">Never miss pending dues with smart pending reports.</p>
                </div>
                <div class="card p-7 reveal">
                    <div class="icon-wrap"><i class="fa-solid fa-medal"></i></div>
                    <h3 class="font-display font-bold text-primary mt-5 text-lg">Professional Reporting</h3>
                    <p class="text-primary/60 mt-2 text-sm">Share clean, branded PDF reports that look the part.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section id="how" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto reveal">
                <span class="text-accent font-bold uppercase text-xs tracking-[0.2em]">How it works</span>
                <h2 class="font-display text-4xl md:text-5xl font-extrabold text-primary mt-3">
                    Up & running in <span class="gradient-text">4 simple steps</span>
                </h2>
            </div>
            <div class="mt-14 grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="card p-7 reveal">
                    <div class="step-num">1</div>
                    <h3 class="font-display font-bold text-primary mt-5 text-lg">Add Customer</h3>
                    <p class="text-primary/60 mt-2 text-sm leading-relaxed">Enter the mobile number — if the customer
                        exists, the name appears instantly. Otherwise fill the customer details and add the <span
                            class="font-semibold text-primary">RM Detail (Sub Account)</span>.</p>
                </div>
                <div class="card p-7 reveal">
                    <div class="step-num">2</div>
                    <h3 class="font-display font-bold text-primary mt-5 text-lg">Search & Collect</h3>
                    <p class="text-primary/60 mt-2 text-sm leading-relaxed">Search the customer, tap to open, select
                        the collection account, and record the entry in seconds.</p>
                </div>
                <div class="card p-7 reveal">
                    <div class="step-num">3</div>
                    <h3 class="font-display font-bold text-primary mt-5 text-lg">Send WhatsApp</h3>
                    <p class="text-primary/60 mt-2 text-sm leading-relaxed">Instantly share the receipt and
                        confirmation with the customer through a WhatsApp message — one tap.</p>
                </div>
                <div class="card p-7 reveal">
                    <div class="step-num">4</div>
                    <h3 class="font-display font-bold text-primary mt-5 text-lg">Generate Reports</h3>
                    <p class="text-primary/60 mt-2 text-sm leading-relaxed">Get daily summaries, monthly statements,
                        and pending dues as clean PDF reports ready to share.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- APP PREVIEW -->
    <section class="py-24 gradient-bg text-white relative overflow-hidden">
        <div class="blob bg-accent w-[500px] h-[500px] -top-32 -left-32"></div>
        <div class="blob bg-secondary w-[500px] h-[500px] -bottom-32 -right-32"></div>
        <div class="max-w-7xl mx-auto px-6 relative">
            <div class="text-center max-w-2xl mx-auto reveal">
                <span class="text-white/70 font-bold uppercase text-xs tracking-[0.2em]">App Preview</span>
                <h2 class="font-display text-4xl md:text-5xl font-extrabold mt-3">A glimpse of the real app</h2>
                <p class="mt-4 text-white/70 text-lg">Actual screens from the Digital Smart Agent mobile app.</p>
            </div>

            <div class="mt-16 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8 reveal">
                <div class="phone-img floating" style="animation-delay:-0.5s"><img
                        src="assets/screens/customer-list.jpeg" alt="Customer List" />
                    <div class="phone-label">Customer List</div>
                </div>
                <div class="phone-img floating" style="animation-delay:-1.5s"><img
                        src="assets/screens/rm-detail.jpeg" alt="RM Detail" />
                    <div class="phone-label">RM Detail</div>
                </div>
                <div class="phone-img floating" style="animation-delay:-2.5s"><img src="assets/screens/entry.jpeg"
                        alt="Collection Entry" />
                    <div class="phone-label">Collection Entry</div>
                </div>
                <div class="phone-img floating" style="animation-delay:-3.5s"><img
                        src="assets/screens/collection.jpeg" alt="Collection History" />
                    <div class="phone-label">Collection History</div>
                </div>
                <div class="phone-img floating" style="animation-delay:-1s"><img
                        src="assets/screens/collection-list.jpeg" alt="Daily Collections" />
                    <div class="phone-label">Daily Collections</div>
                </div>
                <div class="phone-img floating" style="animation-delay:-2s"><img
                        src="assets/screens/daily-summary.jpeg" alt="Daily Summary" />
                    <div class="phone-label">Daily Summary</div>
                </div>
                <div class="phone-img floating" style="animation-delay:-3s"><img
                        src="assets/screens/report-dashboard.jpeg" alt="Reports Dashboard" />
                    <div class="phone-label">Reports Dashboard</div>
                </div>
                <div class="phone-img phone-cta floating" style="animation-delay:-4s">
                    <div class="text-center px-4">
                        <img src="assets/app-icon.png" alt="DSA"
                            class="w-20 h-20 mx-auto mb-3 drop-shadow-xl" />
                        <div class="font-display font-extrabold text-white text-lg leading-tight">Digital Smart Agent
                        </div>
                        <div class="text-white/70 text-xs mt-1">We make your work easy</div>
                        <a href="#download"
                            class="mt-4 inline-flex btn-primary px-4 py-2 rounded-lg text-xs font-bold"><i
                                class="fa-solid fa-download mr-2"></i>Download</a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- TESTIMONIALS -->
    <section id="testimonials" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto reveal">
                <span class="text-accent font-bold uppercase text-xs tracking-[0.2em]">Testimonials</span>
                <h2 class="font-display text-4xl md:text-5xl font-extrabold text-primary mt-3">Trusted by <span
                        class="gradient-text">agents like you</span></h2>
            </div>
            <div class="mt-14 grid md:grid-cols-3 gap-6">
                <div class="card p-7 reveal">
                    <div class="flex text-accent gap-1"><i class="fa-solid fa-star"></i><i
                            class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                            class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <p class="mt-4 text-primary/80 italic leading-relaxed">"DSA replaced my notebook completely. I now
                        finish my daily reporting in 5 minutes."</p>
                    <div class="mt-6 flex items-center gap-3">
                        <div
                            class="w-12 h-12 rounded-full gradient-bg text-white font-bold flex items-center justify-center">
                            R</div>
                        <div>
                            <div class="font-bold text-primary">Ramesh Iyer</div>
                            <div class="text-xs text-primary/60">Post Office Agent, Chennai</div>
                        </div>
                    </div>
                </div>
                <div class="card p-7 reveal">
                    <div class="flex text-accent gap-1"><i class="fa-solid fa-star"></i><i
                            class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                            class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <p class="mt-4 text-primary/80 italic leading-relaxed">"The WhatsApp reminders alone have improved
                        my on-time collections by over 40%."</p>
                    <div class="mt-6 flex items-center gap-3">
                        <div
                            class="w-12 h-12 rounded-full gradient-bg text-white font-bold flex items-center justify-center">
                            P</div>
                        <div>
                            <div class="font-bold text-primary">Priya Sharma</div>
                            <div class="text-xs text-primary/60">Collection Agent, Pune</div>
                        </div>
                    </div>
                </div>
                <div class="card p-7 reveal">
                    <div class="flex text-accent gap-1"><i class="fa-solid fa-star"></i><i
                            class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                            class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <p class="mt-4 text-primary/80 italic leading-relaxed">"My monthly PDF reports look so professional
                        now. Customers and management both love it."</p>
                    <div class="mt-6 flex items-center gap-3">
                        <div
                            class="w-12 h-12 rounded-full gradient-bg text-white font-bold flex items-center justify-center">
                            A</div>
                        <div>
                            <div class="font-bold text-primary">Arun Krishnan</div>
                            <div class="text-xs text-primary/60">Senior Agent, Kochi</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTACT -->
    <section id="contact" class="py-24 gradient-soft">
        <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-12">
            <div class="reveal">
                <span class="text-accent font-bold uppercase text-xs tracking-[0.2em]">Contact</span>
                <h2 class="font-display text-4xl md:text-5xl font-extrabold text-primary mt-3 leading-tight">
                    Let's get you <span class="gradient-text">started</span>.
                </h2>
                <p class="mt-5 text-primary/70 text-lg">Have a question or want a demo? We'll get back to you within
                    one business day.</p>

                <div class="mt-8 space-y-4">
                    <a href="https://wa.me/917665629201" class="flex items-center gap-4 card p-5">
                        <div
                            class="w-12 h-12 rounded-xl gradient-bg text-white flex items-center justify-center text-xl">
                            <i class="fa-brands fa-whatsapp"></i>
                        </div>
                        <div>
                            <div class="font-bold text-primary">WhatsApp</div>
                            <div class="text-primary/60 text-sm">Chat with us instantly</div>
                        </div>
                    </a>
                    <a href="mailto:hello@dsa.app" class="flex items-center gap-4 card p-5">
                        <div
                            class="w-12 h-12 rounded-xl gradient-bg text-white flex items-center justify-center text-xl">
                            <i class="fa-regular fa-envelope"></i>
                        </div>
                        <div>
                            <div class="font-bold text-primary">Email</div>
                            <div class="text-primary/60 text-sm">work.divyank@gmail.com</div>
                        </div>
                    </a>
                    <a href="tel:+917665629201" class="flex items-center gap-4 card p-5">
                        <div
                            class="w-12 h-12 rounded-xl gradient-bg text-white flex items-center justify-center text-xl">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <div class="font-bold text-primary">Phone</div>
                            <div class="text-primary/60 text-sm">+91 76656 29201</div>
                        </div>
                    </a>
                </div>
            </div>

            <form class="card p-8 reveal"
                onsubmit="event.preventDefault(); alert('Thanks! We will reach out shortly.');">
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-bold text-primary uppercase">First Name</label>
                        <input type="text" required
                            class="mt-2 w-full px-4 py-3 rounded-xl border border-primary/10 focus:border-accent focus:ring-2 focus:ring-accent/20 outline-none transition" />
                    </div>
                    <div>
                        <label class="text-xs font-bold text-primary uppercase">Last Name</label>
                        <input type="text"
                            class="mt-2 w-full px-4 py-3 rounded-xl border border-primary/10 focus:border-accent focus:ring-2 focus:ring-accent/20 outline-none transition" />
                    </div>
                </div>
                <div class="mt-4">
                    <label class="text-xs font-bold text-primary uppercase">Email</label>
                    <input type="email" required
                        class="mt-2 w-full px-4 py-3 rounded-xl border border-primary/10 focus:border-accent focus:ring-2 focus:ring-accent/20 outline-none transition" />
                </div>
                <div class="mt-4">
                    <label class="text-xs font-bold text-primary uppercase">Phone</label>
                    <input type="tel"
                        class="mt-2 w-full px-4 py-3 rounded-xl border border-primary/10 focus:border-accent focus:ring-2 focus:ring-accent/20 outline-none transition" />
                </div>
                <div class="mt-4">
                    <label class="text-xs font-bold text-primary uppercase">Message</label>
                    <textarea rows="4"
                        class="mt-2 w-full px-4 py-3 rounded-xl border border-primary/10 focus:border-accent focus:ring-2 focus:ring-accent/20 outline-none transition"></textarea>
                </div>
                <button
                    class="btn-primary mt-6 w-full py-4 rounded-xl font-bold inline-flex items-center justify-center gap-2">
                    Send Message <i class="fa-solid fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="gradient-bg text-white pt-16 pb-8 relative overflow-hidden">
        <div class="blob bg-accent w-[400px] h-[400px] -top-40 right-1/4 opacity-40"></div>
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-4 gap-10 relative">
            <div class="md:col-span-2">
                <div class="flex items-center gap-2">
                    <img src="assets/trans-app-icon.png" alt="DSA"
                        class="w-11 h-11 rounded-xl bg-white p-1 object-contain" />
                    <div>
                        <div class="font-display font-extrabold text-lg">Digital Smart Agent</div>
                        <div class="text-[10px] uppercase tracking-widest text-white/60">We make your work easy</div>
                    </div>
                </div>
                <p class="mt-5 text-white/70 max-w-md">The modern way for Post Office and collection agents to manage
                    customers, payments, and reports — all from one app.</p>
                <div class="mt-6 flex gap-3">
                    <a href="#"
                        class="w-10 h-10 rounded-xl glass-dark flex items-center justify-center hover:bg-white/20 transition"><i
                            class="fa-brands fa-facebook-f"></i></a>
                    <a href="#"
                        class="w-10 h-10 rounded-xl glass-dark flex items-center justify-center hover:bg-white/20 transition"><i
                            class="fa-brands fa-instagram"></i></a>
                    <a href="#"
                        class="w-10 h-10 rounded-xl glass-dark flex items-center justify-center hover:bg-white/20 transition"><i
                            class="fa-brands fa-x-twitter"></i></a>
                    <a href="#"
                        class="w-10 h-10 rounded-xl glass-dark flex items-center justify-center hover:bg-white/20 transition"><i
                            class="fa-brands fa-linkedin-in"></i></a>
                    <a href="#"
                        class="w-10 h-10 rounded-xl glass-dark flex items-center justify-center hover:bg-white/20 transition"><i
                            class="fa-brands fa-whatsapp"></i></a>
                </div>
            </div>
            <div>
                <div class="font-bold mb-4">Quick Links</div>
                <ul class="space-y-2 text-white/70 text-sm">
                    <li><a href="#about" class="hover:text-white">About</a></li>
                    <li><a href="#features" class="hover:text-white">Features</a></li>
                    <li><a href="#benefits" class="hover:text-white">Benefits</a></li>
                    <li><a href="#how" class="hover:text-white">How it works</a></li>
                    <li><a href="#contact" class="hover:text-white">Contact</a></li>
                </ul>
            </div>
            <div>
                <div class="font-bold mb-4">Get in touch</div>
                <ul class="space-y-2 text-white/70 text-sm">
                    <li><i class="fa-regular fa-envelope mr-2 text-accent"></i> hello@dsa.app</li>
                    <li><i class="fa-solid fa-phone mr-2 text-accent"></i> +91 7665629201</li>
                    <li><i class="fa-brands fa-whatsapp mr-2 text-accent"></i> Chat on WhatsApp</li>
                </ul>
            </div>
        </div>
        <div
            class="max-w-7xl mx-auto px-6 mt-12 pt-6 border-t border-white/10 flex flex-col md:flex-row items-center justify-between gap-4 text-white/60 text-xs">
            <div>© 2026 Digital Smart Agent. All rights reserved.</div>
            <div class="flex gap-5"><a href="#" class="hover:text-white">Privacy</a><a href="#"
                    class="hover:text-white">Terms</a></div>
        </div>
    </footer>
    <div id="requestModal" class="modal-back" onclick="if(event.target===this)closeRequestModal()">
        @livewire('onboarding-wizard')
    </div>

    <!-- Floating WhatsApp -->
    <a href="https://wa.me/917665629201"
        class="fixed bottom-6 right-6 z-40 w-14 h-14 rounded-full text-white text-2xl flex items-center justify-center shadow-glow"
        style="background:linear-gradient(135deg,#25D366,#128C7E)">
        <i class="fa-brands fa-whatsapp"></i>
    </a>

    <script>
        // Reveal on scroll
        const io = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.classList.add('in');
                    io.unobserve(e.target);
                }
            });
        }, {
            threshold: 0.12
        });
        document.querySelectorAll('.reveal').forEach(el => io.observe(el));

        // Mobile menu toggle
        const btn = document.getElementById('menuBtn');
        const menu = document.getElementById('mobileMenu');
        btn?.addEventListener('click', () => menu.classList.toggle('hidden'));
        menu?.querySelectorAll('a').forEach(a => a.addEventListener('click', () => menu.classList.add('hidden')));

        // Smooth scroll without showing hash in URL
        document.querySelectorAll('a[href^="#"]').forEach(link => {
            link.addEventListener('click', (e) => {
                const href = link.getAttribute('href');
                if (!href || href === '#') return;
                const target = document.querySelector(href);
                if (!target) return;
                e.preventDefault();
                const headerOffset = 90;
                const top = target.getBoundingClientRect().top + window.pageYOffset - headerOffset;
                window.scrollTo({
                    top,
                    behavior: 'smooth'
                });
                if (history.replaceState) history.replaceState(null, '', window.location.pathname + window
                    .location.search);
            });
        });

        // ---- Request modal ----
        const rm = document.getElementById('requestModal');

        function openRequestModal() {
            rm.classList.add('show');
            document.body.style.overflow = 'hidden';
            setStep(1);
        }

        function closeRequestModal() {
            rm.classList.remove('show');
            document.body.style.overflow = '';
        }

        function setStep(n) {
            ['step1', 'step2', 'step3', 'step4', 'stepDone'].forEach((id) => document.getElementById(id).classList.add(
                'hidden'));
            if (n <= 4) document.getElementById('step' + n).classList.remove('hidden');
            else document.getElementById('stepDone').classList.remove('hidden');
            const bar = document.getElementById('stepBar');
            bar.style.width = (n === 1 ? '10%' : n === 2 ? '35%' : n === 3 ? '70%' : n === 4 ? '95%' : '100%');
            const dots = [document.getElementById('dot1'), document.getElementById('dot2'), document.getElementById('dot3'),
                document.getElementById('dot4')
            ];
            dots.forEach((d, i) => {
                const active = (i + 1) <= n;
                d.className = 'step-dot ' + (active ? 'gradient-bg text-white' : 'bg-slate-200 text-slate-500');
            });
            if (n === 3 || n === 4) calcTotal();
        }

        function calcTotal() {
            let total = 0;
            const rows = [];
            // Software base always
            rows.push({
                label: 'DSA Software (Base)',
                val: 'Included'
            });
            if (document.getElementById('pl_agent')?.checked) {
                const q = +document.getElementById('pl_agent_qty').value || 1;
                const amt = 150 * q;
                total += amt;
                rows.push({
                    label: `DOP Agents × ${q}`,
                    val: '₹' + amt + ' /mo'
                });
            }
            if (document.getElementById('pl_mob')?.checked) {
                const mode = document.querySelector('input[name="pl_mob_mode"]:checked')?.value || 'trial';
                if (mode === 'trial') {
                    rows.push({
                        label: 'Mobile Collection App',
                        val: 'Free (3 mo trial)'
                    });
                } else {
                    total += 250;
                    rows.push({
                        label: 'Mobile Collection App',
                        val: '₹250 /mo'
                    });
                }
            }
            if (document.getElementById('pl_wa')?.checked) {
                total += 200;
                rows.push({
                    label: 'WhatsApp Automation',
                    val: '₹200 /mo'
                });
            }
            const tEl = document.getElementById('rf_total');
            if (tEl) tEl.textContent = total;
            const note = document.getElementById('rf_total_note');
            if (note) note.textContent = 'Billed monthly · Cancel anytime';
            // Summary on payment step
            const sum = document.getElementById('rf_summary');
            if (sum) {
                sum.innerHTML = rows.map(r =>
                    `<div class="flex items-center justify-between py-2"><span class="text-primary/70">${r.label}</span><span class="font-semibold text-primary">${r.val}</span></div>`
                    ).join('');
            }
            const pay = document.getElementById('rf_payable');
            if (pay) pay.textContent = total;
            const payBtn = document.getElementById('rf_pay_btn');
            if (payBtn) payBtn.textContent = total;
        }

        function rfNext(from) {
            if (from === 1) {
                const m = document.getElementById('rf_mobile').value.trim();
                const c = document.getElementById('rf_company').value.trim();
                const o = document.getElementById('rf_owner').value.trim();
                const e = document.getElementById('rf_email').value.trim();
                if (!c || !o || !m || !e) {
                    alert('Please fill all fields.');
                    return;
                }
                if (!/^\d{10}$/.test(m)) {
                    alert('Enter a valid 10-digit mobile.');
                    return;
                }
                document.getElementById('otpTo').textContent = '+91 ' + m;
                setStep(2);
                setTimeout(() => document.querySelector('#otpWrap input')?.focus(), 100);
            } else if (from === 2) {
                const otp = [...document.querySelectorAll('#otpWrap input')].map(i => i.value).join('');
                if (otp.length < 6) {
                    alert('Enter the 6-digit OTP (any digits for demo).');
                    return;
                }
                setStep(3);
            } else if (from === 3) {
                const dop = document.getElementById('rf_dop').value,
                    po = document.getElementById('rf_po').value.trim();
                if (!dop || !po) {
                    alert('Please fill DOP agents and Post Office.');
                    return;
                }
                setStep(4);
            }
        }

        function rfBack(from) {
            setStep(from - 1);
        }

        function rfPay() {
            const total = +document.getElementById('rf_payable').textContent || 0;
            openConfirmModal(
                'Proceed to UPI payment?',
                'You will be redirected to Razorpay to complete a UPI payment of ₹' + total +
                '. No card or wallet charges apply.',
                () => setStep(5)
            );
        }
    </script>
</body>

</html>
