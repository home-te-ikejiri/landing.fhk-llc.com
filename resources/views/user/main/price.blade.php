@extends('user.layouts.application')

@section('title', '料金案内 | 珈琲えんがわ')

@section('content')

    {{-- ページヘッダー --}}
    <section class="page-header bg-sub-color">
        <div class="container py-4 text-center">
            <h1 class="text-base-color mb-1">レンタルルーム 料金案内</h1>
            <p class="text-base-color opacity-75 mb-0">ご利用スタイルに合わせてお選びください</p>
        </div>
    </section>

    {{-- ① 共有利用 --}}
    <section class="py-5 bg-cream text-sub-color" id="shared">
        <div class="container py-3">
            <div class="row pb-3">
                <div class="col text-center">
                    <h2 class="section-heading">共有利用</h2>
                    <p>同じレンタルルームを他のお客様と共有してご利用いただけます。</p>
                </div>
            </div>

            {{-- 基本料金 --}}
            <div class="row justify-content-center mb-5">
                <div class="col-md-8">
                    <div class="price-card">
                        <h5 class="price-card-title"><i class="bi bi-calculator me-2"></i>基本料金</h5>
                        <p class="price-formula">300円 × 人数 × 時間</p>
                        <p class="text-muted small mb-0">※ 1時間あたりの最低料金は 1,000円 となります。</p>
                    </div>
                </div>
            </div>

            {{-- パック料金 --}}
            <div class="row justify-content-center mb-5">
                <div class="col-md-8">
                    <h5 class="text-center mb-3">お得なパック料金（おひとりあたり）</h5>
                    <div class="table-responsive">
                        <table class="table price-table text-center">
                            <thead>
                                <tr>
                                    <th>ご利用時間</th>
                                    <th>料金</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>3時間まで</td>
                                    <td class="price-amount">800円</td>
                                </tr>
                                <tr>
                                    <td>5時間まで</td>
                                    <td class="price-amount">1,200円</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="price-notes">
                        <p class="mb-1"><i class="bi bi-info-circle me-1 text-accent"></i>5時間を超える場合は +300円／時間 となります。</p>
                        <p class="mb-1"><i class="bi bi-info-circle me-1 text-accent"></i>未就学児は無料です。</p>
                        <p class="mb-1"><i class="bi bi-info-circle me-1 text-accent"></i>小学生以上は1名として料金計算いたします。</p>
                        <p class="mb-0"><i class="bi bi-info-circle me-1 text-accent"></i>小学生以下のみでのご利用はできません。</p>
                    </div>
                </div>
            </div>

            {{-- ご利用例 --}}
            <div class="row pb-2">
                <div class="col text-center">
                    <h5>ご利用例</h5>
                </div>
            </div>
            <div class="row g-3 justify-content-center">
                {{-- 1名 --}}
                <div class="col-sm-6 col-lg-3">
                    <div class="example-card">
                        <div class="example-card-header">
                            <i class="bi bi-person-fill me-1"></i>1名
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm price-table text-center mb-0">
                                <thead>
                                    <tr>
                                        <th>利用時間</th>
                                        <th>料金</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>3時間まで</td><td>1,000円</td></tr>
                                    <tr><td>5時間まで</td><td>1,200円</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- 2名 --}}
                <div class="col-sm-6 col-lg-3">
                    <div class="example-card">
                        <div class="example-card-header">
                            <i class="bi bi-people-fill me-1"></i>2名
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm price-table text-center mb-0">
                                <thead>
                                    <tr>
                                        <th>利用時間</th>
                                        <th>料金</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>2時間まで</td><td>1,000円</td></tr>
                                    <tr><td>3時間まで</td><td>1,600円</td></tr>
                                    <tr><td>5時間まで</td><td>2,400円</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- 3名 --}}
                <div class="col-sm-6 col-lg-3">
                    <div class="example-card">
                        <div class="example-card-header">
                            <i class="bi bi-people-fill me-1"></i>3名
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm price-table text-center mb-0">
                                <thead>
                                    <tr>
                                        <th>利用時間</th>
                                        <th>料金</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>1時間まで</td><td>1,000円</td></tr>
                                    <tr><td>2時間まで</td><td>1,800円</td></tr>
                                    <tr><td>3時間まで</td><td>2,400円</td></tr>
                                    <tr><td>5時間まで</td><td>3,600円</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- 4名 --}}
                <div class="col-sm-6 col-lg-3">
                    <div class="example-card">
                        <div class="example-card-header">
                            <i class="bi bi-people-fill me-1"></i>4名
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm price-table text-center mb-0">
                                <thead>
                                    <tr>
                                        <th>利用時間</th>
                                        <th>料金</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>1時間まで</td><td>1,200円</td></tr>
                                    <tr><td>2時間まで</td><td>2,400円</td></tr>
                                    <tr><td>3時間まで</td><td>3,200円</td></tr>
                                    <tr><td>5時間まで</td><td>4,800円</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ② 占有利用（フロア貸し） --}}
    <section class="py-5 bg-light-gray text-sub-color" id="exclusive">
        <div class="container py-3">
            <div class="row pb-3">
                <div class="col text-center">
                    <h2 class="section-heading">占有利用（フロア貸し）</h2>
                    <p>レンタルルームを、仲間やグループのみでご利用いただけます。<br>人数にかかわらず同一料金です。</p>
                    <p class="text-muted small">※ 未就学児は人数に含みません</p>
                </div>
            </div>

            <div class="row justify-content-center mb-4">
                <div class="col-md-6 text-center">
                    <div class="price-card">
                        <h5 class="price-card-title"><i class="bi bi-door-open-fill me-2"></i>基本料金</h5>
                        <p class="price-formula">1,500円 ／ 時間</p>
                        <p class="text-muted small mb-0">人数にかかわらず一律料金</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h5 class="text-center mb-3">ご利用人数の目安</h5>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="capacity-card">
                                <div class="capacity-icon"><i class="bi bi-table"></i></div>
                                <div>
                                    <p class="capacity-label">テーブル利用の場合</p>
                                    <p class="capacity-num">〜 6名まで</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="capacity-card">
                                <div class="capacity-icon"><i class="bi bi-calendar-event"></i></div>
                                <div>
                                    <p class="capacity-label">イベント利用の場合<br><small class="text-muted">（テーブルなし）</small></p>
                                    <p class="capacity-num">〜 8名まで</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 text-center text-muted">
                        <i class="bi bi-lightbulb me-1 text-accent"></i>ヨガ教室・ベビーマッサージ・女子会などでご利用いただけます。
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ③ オプション料金 --}}
    <section class="py-5 bg-cream text-sub-color" id="options">
        <div class="container py-3">
            <div class="row pb-3">
                <div class="col text-center">
                    <h2 class="section-heading">オプション料金</h2>
                    <p>コーヒー・紅茶のバッグをご用意しました。セルフにてご利用いただけます。</p>
                </div>
            </div>

            {{-- 飲み物 --}}
            <div class="row g-4 justify-content-center mb-4">
                <div class="col-md-5">
                    <div class="option-card h-100">
                        <div class="option-card-header">
                            <i class="bi bi-cup-hot-fill me-2"></i>コーヒー
                        </div>
                        <div class="option-card-body">
                            <p class="option-price">200円 <small>／ 個</small></p>
                            <p class="option-desc">小布施の「クローバーcoffee」さまのコーヒーバッグをご用意しました。</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="option-card h-100">
                        <div class="option-card-header">
                            <i class="bi bi-cup-fill me-2"></i>紅茶
                        </div>
                        <div class="option-card-body">
                            <p class="option-price">100円 <small>／ 個</small></p>
                            <p class="option-desc">お手軽にお楽しみいただけるティーバッグをご用意しました。</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- その他オプション --}}
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <h5 class="text-center mb-3">備品・機器オプション</h5>
                    <div class="table-responsive">
                        <table class="table price-table text-center">
                            <thead>
                                <tr>
                                    <th>オプション</th>
                                    <th>料金</th>
                                    <th class="d-none d-md-table-cell">用途</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>テレビモニター（40インチ）</td>
                                    <td class="price-amount">500円 <small>／ 回</small></td>
                                    <td class="d-none d-md-table-cell text-muted small">プロジェクター代わりの利用を想定</td>
                                </tr>
                                <tr>
                                    <td>パソコンモニター（24インチ）</td>
                                    <td class="price-amount">300円 <small>／ 回</small></td>
                                    <td class="d-none d-md-table-cell text-muted small">パソコン作業のサブモニター利用を想定</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ④ ご利用上の注意 --}}
    <section class="py-5 bg-light-gray text-sub-color" id="notes">
        <div class="container py-3">
            <div class="row pb-3">
                <div class="col text-center">
                    <h2 class="section-heading">ご利用上の注意</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <ul class="notes-list">
                        <li><i class="bi bi-x-circle-fill text-danger me-2"></i>室内は禁煙です。</li>
                        <li><i class="bi bi-volume-mute-fill text-accent me-2"></i>大音量での音楽再生や、大きな声での会話はご遠慮ください。</li>
                        <li><i class="bi bi-slash-circle text-accent me-2"></i>飲酒目的でのご利用はご遠慮ください。</li>
                        <li><i class="bi bi-recycle text-accent me-2"></i>ゴミは分別にご協力ください。</li>
                        <li><i class="bi bi-tools text-accent me-2"></i>備品や設備を破損された場合は、修理費をご負担いただく場合があります。</li>
                        <li><i class="bi bi-house-fill text-accent me-2"></i>ご利用後は簡単な片付けにご協力をお願いいたします。</li>
                        <li><i class="bi bi-bag-fill text-accent me-2"></i>貴重品の管理はご自身でお願いいたします。</li>
                        <li><i class="bi bi-person-x-fill text-accent me-2"></i>小学生以下のお子さまのみでのご利用はできません。</li>
                        <li><i class="bi bi-emoji-smile text-accent me-2"></i>他のお客様や近隣のご迷惑となる行為はご遠慮ください。</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- お問い合わせ CTA --}}
    <section class="py-5" id="contact">
        <div class="container py-3">
            <div class="row pb-3">
                <div class="col text-center">
                    <h2 class="text-sub-color mb-3">ご予約・お問い合わせ</h2>
                    <p class="text-sub-color">ご不明な点やご予約は、お気軽にお問い合わせください。</p>
                </div>
            </div>
            <div class="row pb-3 justify-content-center">
                <div class="col-md-6">
                    <a href="{{ route('user.contact') }}" class="w-100 btn btn-contact">
                        <i class="bi bi-envelope-fill me-2"></i>お問い合わせ・ご予約はこちら
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection
