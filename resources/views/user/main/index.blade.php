@extends('user.layouts.application')

@section('content')

    {{-- ① ファーストビュー --}}
    <section id="first-view">
        <div class="fv-content">
            <h1 class="fv-catch">
                人と人が、<br class="br-sp">ゆるやかにつながる場所。
            </h1>
            <p class="fv-sub">
                長野・篠ノ井の喫茶店・レンタルルーム。<br>
                「木」と「コーヒー」を軸に、<br>
                働く人・暮らす人・学ぶ人が集まる<br>
                場をつくっています。
            </p>
            <div class="d-flex flex-wrap gap-3 justify-content-center">
                <a href="#services" class="btn btn-accent px-4 py-2 shadow">
                    <i class="bi bi-door-open-fill me-1"></i> サービスを見る
                </a>
                <a href="https://stores.jp" target="_blank" class="btn btn-outline-light px-4 py-2">
                    <i class="bi bi-bag-fill me-1"></i> ECショップはこちら
                </a>
            </div>
        </div>
    </section>

    {{-- ② コンセプト --}}
    <section class="py-5 bg-cream" id="concept">
        <div class="container py-3">
            <div class="row pb-3">
                <div class="col text-center">
                    <h1 class="section-heading text-sub-color">「ちょうどいい距離感」<br class="br-sp">でつながる</h1>
                </div>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-md-8">
                    <p class="concept-lead">
                        忙しい毎日の中で、少しだけ立ち止まれる場所があったら。
                    </p>
                    <p class="concept-body mb-4">
                        「珈琲えんがわ」は、人と人、人と時間が無理なくつながれる「場」を大切にしたいという想いから、<br>
                        合同会社FHK（フィーカ）が生み出した喫茶店・コミュニティスペースです。
                    </p>
                    <p class="concept-lead">
                        「珈琲えんがわ」は、もともとおばあちゃんが暮らしていた民家を活用した場所です。
                    </p>
                    <p class="concept-body">
                        どこか懐かしく、ほっとできるその空間で、
                        コーヒーと木のぬくもりに囲まれながら、
                        ゆっくりとくつろいでいただきたい——
                        そんな想いから、この場所は生まれました。
                    </p>
                    <p class="concept-body">
                        仕事の合間に立ち寄る人、
                        誰かと学び合う人、
                        ゆっくりとコーヒーを楽しむ人。
                    </p>
                    <p class="concept-body">
                        それぞれの過ごし方が自然に共存する、
                        まるで「えんがわ」に座っているような心地よさを感じられる、
                        そんな空間を提供しています。
                    </p>
                </div>
                <div class="col-md-4 text-center d-flex align-items-center justify-content-center">
                    {{--
                        【画像が必要】コンセプトイメージ
                        イメージ：穏やかなひとときを感じる写真（屋内の柔らかい光、木製インテリア）
                        例）木のぬくもりのある空間で本を読む人、コーヒーを飲みながら会話する人たち
                        推奨サイズ：正方形または縦長 600px × 600px
                        ファイル名案：images/user/fhk-concept.jpg
                    --}}
                    {{-- <div class="img-placeholder w-100" style="height: 220px;">
                        【画像】コンセプト<br>
                        <small>穏やかなひとときを感じる空間写真<br>（例：木のテーブル・柔らかい光の室内）</small>
                    </div> --}}
                    <img src="{{ asset('images/user/fhk-concept2.png') }}" class="img-fluid rounded" alt="FHK コンセプトイメージ">
                </div>
            </div>
        </div>
    </section>

    {{-- ③ 利用シーン --}}
    <section class="py-5 text-sub-color" id="scenes">
        <div class="container py-3">
            <div class="row pb-3">
                <div class="col text-center">
                    <h1 class="section-heading">こんな使い方ができます</h1>
                </div>
            </div>
            <div class="row g-4">
                <!-- シーン1: ビジネス -->
                <div class="col-md-4">
                    <div class="scene-card">
                        <div class="scene-icon text-center">
                            <i class="bi bi-laptop"></i>
                        </div>
                        <div class="text-center mb-2">
                            <span class="scene-label">ビジネス</span>
                        </div>
                        <h5 class="text-center">仕事の合間に、ちょっと集中</h5>
                        <p>
                            オンライン会議や打ち合わせ前の時間調整に。
                            静かな空間で、短時間でもしっかり使えます。
                        </p>
                    </div>
                </div>

                <!-- シーン2: コミュニティ -->
                <div class="col-md-4">
                    <div class="scene-card">
                        <div class="scene-icon text-center">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="text-center mb-2">
                            <span class="scene-label">コミュニティ</span>
                        </div>
                        <h5 class="text-center">人と集まる場所として</h5>
                        <p>
                            ママさんサークルやヨガ教室など、
                            少人数での活動スペースとしてご利用いただけます。
                        </p>
                    </div>
                </div>

                <!-- シーン3: 専門利用 -->
                <div class="col-md-4">
                    <div class="scene-card">
                        <div class="scene-icon text-center">
                            <i class="bi bi-chat-dots-fill"></i>
                        </div>
                        <div class="text-center mb-2">
                            <span class="scene-label">専門利用</span>
                        </div>
                        <h5 class="text-center">安心して話せる場所に</h5>
                        <p>
                            カウンセリングや個別相談の場としてもご利用可能です。
                            プライバシーを大切にした静かな環境をご提供します。
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ④ サービス内容 --}}
    <section class="py-5 bg-light-gray text-sub-color" id="services">
        <div class="container py-3">
            <div class="row pb-3">
                <div class="col text-center">
                    <h1 class="section-heading">サービス</h1>
                </div>
            </div>
            <div class="row g-4 align-items-stretch">
                <!-- 左：写真 -->
                <div class="col-md-6">
                    {{--
                        【画像が必要】店舗・室内の写真（1枚）
                        イメージ：レンタルルームと喫茶スペース両方の雰囲気が伝わる、明るく温かみのある空間写真
                        例）木製テーブル・椅子が並ぶ室内、自然光、コーヒーカップが置かれた様子
                        推奨サイズ：縦長または正方形 800px × 900px
                        ファイル名案：images/user/fhk-space.jpg
                    --}}
                    {{-- <div class="img-placeholder h-100" style="min-height: 400px; border-radius: 12px;">
                        【画像】店舗・室内写真<br>
                        <small>レンタルルームと喫茶スペースの雰囲気が伝わる空間写真<br>（木製テーブル＋自然光＋コーヒーカップ）</small>
                    </div> --}}
                    <img src="{{ asset('images/user/fhk-space.png') }}" class="img-fluid rounded" alt="FHK レンタルルームと喫茶スペース">
                </div>

                <!-- 右：2サービス縦並び -->
                <div class="col-md-6 d-flex flex-column gap-4">
                    <!-- レンタルルーム -->
                    <div class="service-card flex-fill">
                        <div class="service-body">
                            <h5 class="service-title">
                                <i class="bi bi-door-open-fill me-2"></i>レンタルルーム
                            </h5>
                            <p>短時間から利用できる、使い勝手のよい空間です。利用スタイルに合わせて、柔軟にご利用いただけます。</p>
                            <ul class="service-list">
                                <li>オンライン会議</li>
                                <li>打ち合わせ前の待機</li>
                                <li>サークル活動</li>
                                <li>教室開催（ヨガ・講座など）</li>
                                <li>カウンセリング利用</li>
                            </ul>
                        </div>
                    </div>

                    <!-- 喫茶店 -->
                    <div class="service-card flex-fill">
                        <div class="service-body">
                            <h5 class="service-title">
                                <i class="bi bi-cup-hot-fill me-2"></i>喫茶店「珈琲えんがわ」
                            </h5>
                            <p>「コーヒーを楽しむ」だけでなく、「人が集まる」ことを大切にした喫茶店です。</p>
                            <ul class="service-list">
                                <li>木のぬくもりを感じる空間</li>
                                <li>手作りお菓子<!--（レアチーズケーキ、ババロア、アップルパイなど）--></li>
                                <li>コーヒー好きが集まるイベント開催</li>
                                <li>焙煎体験や学びの場</li>
                                <li>AI・プログラミングなど新しい学びの場（予定）</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ⑤ 商品・EC --}}
    <section class="py-5 text-sub-color" id="ec">
        <div class="container py-3">
            <div class="row pb-3">
                <div class="col text-center">
                    <h1 class="section-heading">ものづくりとオンライン販売</h1>
                    <p class="mt-2">木のぬくもりと、日常に寄り添うアイテムをお届けします。</p>
                </div>
            </div>
            <div class="row g-4">
                <!-- 木製アクセサリー -->
                <div class="col-md-6">
                    <div class="product-card">
                        <div class="product-img-wrap">
                            <img src="{{ asset('images/user/fhk-wood-accessories.png') }}" alt="木製アクセサリー商品写真">
                        </div>
                        <div class="product-body">
                            <span class="product-tag">ハンドメイド</span>
                            <h5 class="mt-2">木製アクセサリー</h5>
                            <p>檜（ひのき）を使用したハンドメイド作品。自然素材ならではの香りとやさしさをお楽しみください。</p>
                            <ul class="service-list">
                                <li>ネックレス</li>
                                <li>キーホルダー</li>
                                <li>匂い袋（檜チップ入り）</li>
                                <li>コーヒー豆の脱臭袋</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- コーヒー販売 -->
                <div class="col-md-6">
                    <div class="product-card">
                        <div class="product-img-wrap">
                            <img src="{{ asset('images/user/fhk-coffee-beans.png') }}" alt="コーヒー豆商品写真">
                        </div>
                        <div class="product-body">
                            <span class="product-tag">オンライン販売</span>
                            <h5 class="mt-2">コーヒー販売（EC）</h5>
                            <p>焙煎したコーヒー豆をオンラインで販売予定です。ご自宅でも「珈琲えんがわ」の味と時間をお楽しみいただけます。</p>
                            <div class="mt-3">
                                <a href="https://stores.jp" target="_blank" class="btn btn-accent">
                                    <i class="bi bi-bag-fill me-1"></i> ECショップを見る（Stores）
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ⑥ お知らせ --}}
    <section class="bg-light-gray py-5 text-sub-color" id="news">
        <div class="container py-3">
            <div class="row pb-3">
                <div class="col text-center">
                    <h1 class="section-heading">お知らせ</h1>
                </div>
            </div>
            @if($news->isNotEmpty())
                <div class="row pb-3">
                    <div class="col">
                        <ul class="list-unstyled history">
                            @foreach ($news as $n)
                                <li class="border-bottom">
                                    <a href="{{ url('news/' . $n->id) }}">
                                        <div class="row m-3">
                                            <span class="col-md-12 col-lg-3">{{ dateTimeFormat($n->publish_date, 'Y.m.d') }}</span>
                                            <span class="col-md-12 col-lg-9">{{ $n->title }}</span>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @else
                <div class="text-center pb-3">
                    <p>ただいま準備中です。</p>
                </div>
            @endif
        </div>
    </section>

    {{-- ⑦ 店舗情報・アクセス --}}
    <section class="py-5 text-sub-color" id="access">
        <div class="container">
            <div class="row pb-3">
                <div class="col text-center">
                    <h1 class="section-heading">アクセス</h1>
                    <p>お気軽にお立ち寄りください。お近くにお越しの際は、ぜひご利用ください。</p>
                </div>
            </div>
        </div>
        <!-- Google Map：横幅いっぱい -->
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1233.519055304985!2d138.14875743042714!3d36.57047615747342!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sja!2sjp!4v1774271897553!5m2!1sja!2sjp"
            width="100%" height="450" style="border:0; display:block;"
            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
            title="珈琲えんがわ 地図">
        </iframe>
        <div class="container">
            <p class="mt-3 text-sub-color">
                <i class="bi bi-geo-alt-fill me-1"></i>〒388-8007 長野県長野市篠ノ井会３４３−７
            </p>
        </div>
    </section>

    {{-- ⑧ よくある質問 --}}
    <section class="py-5 bg-cream text-sub-color" id="faq">
        <div class="container py-3">
            <div class="row pb-3">
                <div class="col text-center">
                    <h1 class="section-heading">よくある質問</h1>
                </div>
            </div>
        </div>

        @isset($faqs['faq'])
            <div class="container faq py-3">
                @foreach ($faqs['faq'] as $index => $f)
                    @if (count($f['items']) > 0)
                        <h5 class="faq-title">{{ $f['name'] }}</h5>
                    @endif
                    <div class="accordion">
                        @foreach ($f['items'] as $item)
                            <div class="accordion-item">
                                <h5 class="accordion-header" id="panelsStayOpen-heading{{ $item->id }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsStayOpen-collapse{{ $item->id }}" aria-expanded="false"
                                        aria-controls="panelsStayOpen-collapse{{ $item->id }}">
                                        <span class="faq-question">Q</span>{{ $item->title }}
                                    </button>
                                </h5>
                                <div id="panelsStayOpen-collapse{{ $item->id }}" class="accordion-collapse collapse"
                                    aria-labelledby="panelsStayOpen-heading{{ $item->id }}">
                                    <div class="accordion-body">
                                        {!! purify($item->body) !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        @else
            <div class="container faq py-3 text-center">
                <p>ただいま準備中です。</p>
            </div>
        @endisset
    </section>

    {{-- お問い合わせ --}}
    <section class="py-5" id="contact">
        <div class="container py-3">
            <div class="row pb-3">
                <div class="col text-center">
                    <h2 class="text-sub-color mb-3">お気軽にお問い合わせください</h2>
                    <p class="text-sub-color">レンタルルームのご予約、イベントのご相談など、なんでもお気軽にどうぞ。</p>
                </div>
            </div>
            <div class="row pb-3 justify-content-center">
                <div class="col-md-6">
                    <a href="{{ route('user.contact') }}" class="w-100 btn btn-contact">
                        <i class="bi bi-envelope-fill me-2"></i>お問い合わせ
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection
