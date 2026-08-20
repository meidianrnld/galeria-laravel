<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'GALERIA' }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700|space-grotesk:500,600,700" rel="stylesheet">
    <style>
        :root {
            --bg: #f3f7f4;
            --panel: rgba(255, 255, 255, .94);
            --text: #18231f;
            --muted: #65756e;
            --line: #dce7e1;
            --primary: #0f766e;
            --primary-dark: #0b514c;
            --accent: #2563eb;
            --warning: #b45309;
            --danger: #b91c1c;
            --shadow: 0 14px 34px rgba(23, 55, 45, .08);
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'DM Sans', ui-sans-serif, sans-serif;
            color: var(--text);
            background: radial-gradient(circle at 8% 0%, rgba(229, 169, 61, .14), transparent 26rem), radial-gradient(circle at 100% 20%, rgba(15, 118, 110, .11), transparent 30rem), var(--bg);
            line-height: 1.5;
        }
        a { color: var(--primary-dark); text-decoration: none; }
        a:hover { text-decoration: underline; }
        .topbar {
            background: rgba(255, 255, 255, .86);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--line);
            box-shadow: 0 1px 0 rgba(23, 55, 45, .06);
            position: sticky;
            top: 0;
            z-index: 5;
        }
        .wrap { max-width: 1240px; margin: 0 auto; padding: 0 20px; }
        .nav { display: flex; align-items: center; justify-content: space-between; min-height: 72px; gap: 18px; }
        .brand { font-family: 'Space Grotesk', sans-serif; font-weight: 700; font-size: 23px; letter-spacing: .08em; color: var(--text); }
        .brand span { color: #e5a93d; }
        .navlinks { display: flex; gap: 14px; flex-wrap: wrap; align-items: center; }
        .navlinks a { color: var(--muted); font-weight: 700; font-size: 14px; border-radius: 999px; padding: 8px 12px; }
        .navlinks a:hover { color: var(--primary-dark); background: #e8f3ef; text-decoration: none; }
        main { padding: 42px 0 64px; }
        .page-head { display: flex; justify-content: space-between; gap: 20px; align-items: flex-start; margin-bottom: 24px; padding: 30px 32px; border: 1px solid rgba(15, 118, 110, .14); border-radius: 18px; overflow: hidden; background: linear-gradient(112deg, #e1f1eb 0%, #f8fbf7 62%, #fff4dc 100%); box-shadow: var(--shadow); }
        h1, h2, h3, .stat-value { font-family: 'Space Grotesk', sans-serif; }
        h1 { margin: 0 0 8px; font-size: clamp(30px, 4vw, 46px); line-height: 1.15; letter-spacing: -.02em; }
        h2 { margin: 0 0 14px; font-size: 21px; }
        h3 { margin: 0 0 10px; font-size: 16px; }
        p { margin: 0 0 12px; }
        .muted { color: var(--muted); }
        .grid { display: grid; gap: 16px; }
        .stats { grid-template-columns: repeat(4, minmax(0, 1fr)); margin-bottom: 22px; }
        .cards { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .two { grid-template-columns: 1.2fr .8fr; }
        .card, .panel {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 18px;
            box-shadow: var(--shadow);
        }
        .stat-value { color: var(--primary-dark); font-size: 34px; font-weight: 800; margin-bottom: 2px; }
        .badge-row { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 12px; }
        .badge {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            border: 1px solid var(--line);
            padding: 4px 9px;
            font-size: 12px;
            font-weight: 700;
            color: var(--muted);
            background: #fff;
        }
        .badge.ok { color: #047857; border-color: #a7f3d0; background: #ecfdf5; }
        .badge.warn { color: var(--warning); border-color: #fed7aa; background: #fff7ed; }
        .filters {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr auto;
            gap: 10px;
            margin-bottom: 18px;
        }
        input, select, textarea {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 10px 11px;
            font: inherit;
            background: #fff;
        }
        textarea { min-height: 130px; resize: vertical; }
        label { display: block; font-weight: 700; font-size: 13px; margin-bottom: 6px; }
        .form-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }
        .full { grid-column: 1 / -1; }
        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 40px;
            padding: 9px 14px;
            border-radius: 10px;
            border: 1px solid var(--primary);
            background: var(--primary);
            color: #fff;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 7px 16px rgba(15, 118, 110, .17);
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .button:hover { transform: translateY(-1px); box-shadow: 0 10px 20px rgba(15, 118, 110, .24); text-decoration: none; }
        .button.secondary { color: var(--primary-dark); background: #fff; }
        .button.danger { background: var(--danger); border-color: var(--danger); }
        .actions { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }
        table { width: 100%; border-collapse: collapse; background: #fff; border: 1px solid var(--line); border-radius: 8px; overflow: hidden; }
        th, td { padding: 11px 12px; border-bottom: 1px solid var(--line); text-align: left; vertical-align: top; }
        th { background: #eef4f8; font-size: 13px; }
        tr:last-child td { border-bottom: 0; }
        .notice { border: 1px solid #bbf7d0; background: #f0fdf4; color: #166534; padding: 12px; border-radius: 8px; margin-bottom: 18px; }
        .errors { border: 1px solid #fecaca; background: #fef2f2; color: #991b1b; padding: 12px; border-radius: 8px; margin-bottom: 18px; }
        .list { display: grid; gap: 10px; padding: 0; margin: 0; list-style: none; }
        .list li { border-bottom: 1px solid var(--line); padding-bottom: 10px; }
        .list li:last-child { border-bottom: 0; padding-bottom: 0; }
        .pagination { margin-top: 18px; }
        @media (max-width: 900px) {
            .stats, .cards, .two, .filters, .form-grid { grid-template-columns: 1fr; }
            .page-head { display: block; }
            .actions { margin-top: 12px; }
            .page-head { padding: 24px; border-radius: 14px; }
            .nav { align-items: flex-start; flex-direction: column; padding-top: 14px; padding-bottom: 14px; }
            .navlinks { width: 100%; }
            h1 { font-size: 24px; }
        }
    </style>
</head>
<body>
    <header class="topbar">
        <div class="wrap nav">
            <a class="brand" href="{{ route('dashboard') }}">GALER<span>IA</span></a>
            <nav class="navlinks">
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('katalog.index') }}">Katalog</a>
                @auth
                    <a href="{{ route('admin.aplikasi.index') }}">Admin Aplikasi</a>
                    <form method="post" action="{{ route('logout') }}" style="margin:0">
                        @csrf
                        <button class="button secondary" type="submit" style="min-height:34px;padding:6px 10px">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Login</a>
                @endauth
            </nav>
        </div>
    </header>
    <main>
        <div class="wrap">
            @if (session('status'))
                <div class="notice">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="errors">
                    <strong>Periksa input:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>
</body>
</html>
