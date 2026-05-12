<!doctype html>
<html lang="ja" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="珈琲えんがわは、長野県篠ノ井にある喫茶店・レンタルルームです。「木」と「コーヒー」を軸に、ゆるやかにつながれる場を提供しています。合同会社FHK（フィーカ）運営。">
    <meta name="keywords" content="珈琲えんがわ,FHK,フィーカ,レンタルルーム,コーヒー,木製アクセサリー,長野,篠ノ井,ハンドメイド,喫茶店">
    <meta name="author" content="合同会社FHK（フィーカ）" />
    <title>@yield('title', '珈琲えんがわ | 長野・篠ノ井の喫茶店・レンタルルーム（合同会社FHK運営）')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/assets/admin_lte_3.2.0/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('/assets/bootstrap-5.3.0/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/bootstrap-5.3.0/font/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/user/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/slick-1.8.1/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/slick-1.8.1/slick/slick-theme.css') }}">

    @if (config('app.debug'))
        <meta name="robots" content="noindex" />
        <meta name="googlebot" content="noarchive" />
    @else
        @include('user.components.ga')
    @endif

</head>
<body class="h-100 vstack" data-bs-spy="scroll" data-bs-target="#navbar">

    <nav class="navbar navbar-expand-lg fixed-top text-dark" id="navbar">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="/">
                <img class="main-logo" src="{{ asset('images/user/fhk-logo.png') }}" alt="合同会社FHK（フィーカ）">
                <span class="navbar-brand-text">珈琲えんがわ</span>
            </a>
            {{-- トグルボタン --}}
    
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- リンク一覧 -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}#concept">コンセプト</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}#services">サービス</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}#calendar">カレンダー・予約</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.price') }}">料金</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}#news">お知らせ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}#store">アクセス</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}#faq">よくある質問</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-contact-btn" href="{{ route('user.contact') }}">お問い合わせ</a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>

    @yield('content')


    <input type="hidden" id="csrf-token" content="{{ csrf_token() }}">

    <section class="py-5 bg-footer-color">
        <div class="container">
            <div class="row pt-3">
                <div class="col-md-4 mb-4">
                    <img src="{{ asset('images/user/fhk-logo.png') }}" height="120px" alt="合同会社FHK（フィーカ）ロゴ" class="mb-2 footer-logo">
                    <p class="footer-brand-text">珈琲えんがわ</p>
                </div>
                <div class="col-md-4 mb-4">
                    <dl>
                        <dt class="footer-dt">合同会社FHK（フィーカ）</dt>
                        <dd class="mb-1">〒388-8004 長野県長野市篠ノ井会３４３−７</dd>
                        <dd class="mb-1">営業時間：10:00〜17:00（週末・不定休）</dd>
                    </dl>
                </div>
                <div class="col-md-4 mb-4">
                    <dl>
                        <dt class="footer-dt">事業内容</dt>
                        <dd class="mb-1">レンタルルーム</dd>
                        <dd class="mb-1">喫茶店「珈琲えんがわ」</dd>
                        <dd class="mb-1">ハンドメイド販売 / EC</dd>
                    </dl>
                </div>
            </div>
            {{-- <div class="row border-top pt-3 mt-2">
                <div class="col text-center">
                    <a href="#contact" class="footer-link me-3">お問い合わせ</a>
                </div>
            </div> --}}
        </div>
    </section>

    <footer class="mt-auto py-2 bg-footer-color">
        <div class="container text-center footer">
            <span>© FHK All Rights Reserved.</span>
        </div>
    </footer>

    <!-- Bootstrap 4 -->
    <script src="{{ asset('/assets/admin_lte_3.2.0/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/assets/bootstrap-5.3.0/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/slick-1.8.1/slick/slick.min.js') }}" defer></script>
    @stack('scripts')

</body>
</html>