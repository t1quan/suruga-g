@extends('layouts.app')

@section('title', $page->title ?? '')

@section('content')

<div id="contentArea">

    {{--html埋め込み部分 start--}}

    <link rel="stylesheet" href="{{asset('css/page_single.css')}}">
    <link rel="stylesheet" href="{{asset('css/welfare.css')}}">
    <main id="main_wrap">

        <!-- banner -->
        <div class="sc-page_banner">
            <div class="container_inner">
                <div class="banner_container page_container">
                    <div class="banner_container-inner">
                        <h1 class="banner_title">WELFARE</h1>
                        <p class="text">福利厚生</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- intro -->
        <div class="sc-welfare_intro">
            <div class="container_inner">
                <div class="intro_container page_container">
                    <div class="intro_img">
                        <div class="intro_img-item">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/welfare/topWelfare_01_sp.png')}}">
                                <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/welfare/topWelfare_01_pc.png')}}">
                                <img src="{{asset('images/contentBox/welfare/topWelfare_01_pc.png')}}" alt="">
                            </picture>
                        </div>
                        <div class="intro_img-item">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/welfare/topWelfare_02_sp.png')}}">
                                <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/welfare/topWelfare_02_pc.png')}}">
                                <img src="{{asset('images/contentBox/welfare/topWelfare_02_pc.png')}}" alt="">
                            </picture>
                        </div>
                        <div class="intro_img-item">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/welfare/topWelfare_03_sp.png')}}">
                                <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/welfare/topWelfare_03_pc.png')}}">
                                <img src="{{asset('images/contentBox/welfare/topWelfare_03_pc.png')}}" alt="">
                            </picture>
                        </div>
                    </div>
                    <div class="intro_text">
                        <p class="text">従業員の健康と働きやすい環境を考え、様々な福利厚生を用意しております。<br />
                            あわせて、仕事と家庭の両立を支援する制度や、継続した業務改善による生産性向上などで、従業員のワークライフバランスを充実させ、これら福利厚生を利用しやすい環境作りに力を入れています。</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- movie -->
        <div class="sc-page_movie">
            <div class="container_inner">
                <div class="movie_container page_container">
                    <div class="movie_head">
                        <p class="sub-title">30 SECONDS MOVIE</p>
                        <h2 class="title">動画で知るサクセスストーリー</h2>
                    </div>
                    <div class="movie_video">
                        <div class="movie_video-inner">
                            <script type="text/javascript">
                                var Eviry = Eviry || {};
                                Eviry.Player || (Eviry.Player = {});
                                Eviry.Player.embedkey = "EK1EKgyQyyBwAfa4_9HnChySg-t6m5GJ1HparpI2hfsTgrtPI5_QYCFKDJmNMoPNjy-K3l1KRaZrXlyiJUvKa2lNkOWRGsnaZQidwIpFqKTB6mA66yGO_jF3w..";
                            </script>
                            <script type="text/javascript" src="https://d1euehvbqdc1n9.cloudfront.net/001/eviry/js/eviry.player.min.js"></script>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- info future -->
        <div class="sc-welfare_info sc-welfare_info_col">
            <div class="container_inner">
                <div class="info_container page_container">
                    <div class="info_head">
                        <div class="info_head-img">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/welfare/welfare_icon_01_sp.png')}}">
                                <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/welfare/welfare_icon_01_pc.png')}}">
                                <img src="{{asset('images/contentBox/welfare/welfare_icon_01_pc.png')}}" alt="">
                            </picture>
                        </div>
                        <div class="info_head-text">
                            <p class="info_head-text_sub">For Your Future</p>
                            <h2 class="info_head-text_title">将来への備え</h2>
                        </div>
                    </div>
                    <div class="info_content">
                        <div class="info_box">
                            <div class="info_box-img">
                                <picture>
                                    <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/welfare/welfare_box_01_sp.png')}}">
                                    <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/welfare/welfare_box_01_pc.png')}}">
                                    <img src="{{asset('images/contentBox/welfare/welfare_box_01_pc.png')}}" alt="">
                                </picture>
                            </div>
                            <h3 class="info_box-title">財形貯蓄制度</h3>
                            <p class="text">給料やボーナスから天引きして積立てる貯蓄です。<br />
                                「一般財形」「住宅財形」「年金財形」3つのコースがあります。</p>
                        </div>
                        <div class="info_box">
                            <div class="info_box-img">
                                <picture>
                                    <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/welfare/welfare_box_02_sp.png')}}">
                                    <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/welfare/welfare_box_02_pc.png')}}">
                                    <img src="{{asset('images/contentBox/welfare/welfare_box_02_pc.png')}}" alt="">
                                </picture>
                            </div>
                            <h3 class="info_box-title">社員持株会制度 </h3>
                            <p class="text">従業員持株会の会員になることで、少額資金を継続的に拠出することにより、ミスミグループ本社の株式を容易に取得できます。</p>
                        </div>
                        <div class="info_box">
                            <div class="info_box-img">
                                <picture>
                                    <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/welfare/welfare_box_03_sp.png')}}">
                                    <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/welfare/welfare_box_03_pc.png')}}">
                                    <img src="{{asset('images/contentBox/welfare/welfare_box_03_pc.png')}}" alt="">
                                </picture>
                            </div>
                            <h3 class="info_box-title">生命保険団体契約</h3>
                            <p class="text">会社が契約者となり、役員・従業員を被保険者（保険の対象となる方）とする契約で、一般の生命保険より保険料が安くなります。</p>
                        </div>
                        <div class="info_box">
                            <div class="info_box-img">
                                <picture>
                                    <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/welfare/welfare_box_04_sp.png')}}">
                                    <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/welfare/welfare_box_04_pc.png')}}">
                                    <img src="{{asset('images/contentBox/welfare/welfare_box_04_pc.png')}}" alt="">
                                </picture>
                            </div>
                            <h3 class="info_box-title">退職金制度</h3>
                            <p class="text">【正社員】<br />
                                確定給付企業年金より老齢給付金・脱退一時金・遺族給付金の給付を行います。<br />
                                【契約社員・準社員・嘱託社員】<br />
                                退職時に規程による退職一時金をお支払いします。</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- info health -->
        <div class="sc-welfare_info sc-gray">
            <div class="container_inner">
                <div class="info_container page_container">
                    <div class="info_head">
                        <div class="info_head-img">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/welfare/welfare_icon_02_sp.png')}}">
                                <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/welfare/welfare_icon_02_pc.png')}}">
                                <img src="{{asset('images/contentBox/welfare/welfare_icon_02_pc.png')}}" alt="">
                            </picture>
                        </div>
                        <div class="info_head-text">
                            <p class="info_head-text_sub">For Your Health</p>
                            <h2 class="info_head-text_title">健康管理</h2>
                        </div>
                    </div>
                    <div class="info_content">
                        <div class="info_box">
                            <div class="info_box-img">
                                <picture>
                                    <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/welfare/welfare_box_05_sp.png')}}">
                                    <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/welfare/welfare_box_05_pc.png')}}">
                                    <img src="{{asset('images/contentBox/welfare/welfare_box_05_pc.png')}}" alt="">
                                </picture>
                            </div>
                            <h3 class="info_box-title">定期健康診断・特殊検診</h3>
                            <p class="text">常時雇用されている従業員に対し、所定の項目について医師による定期健康診断を毎年実施しています。また、一定の有害な業務に従事する従業員に対しては、特殊健康診断を実施しています。</p>
                        </div>
                        <div class="info_box">
                            <div class="info_box-img">
                                <picture>
                                    <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/welfare/welfare_box_06_sp.png')}}">
                                    <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/welfare/welfare_box_06_pc.png')}}">
                                    <img src="{{asset('images/contentBox/welfare/welfare_box_06_pc.png')}}" alt="">
                                </picture>
                            </div>
                            <h3 class="info_box-title">インフルエンザ予防接種</h3>
                            <p class="text">インフルエンザ予防接種の希望者は、インフルエンザ予防接種を無償で受けることができます。</p>
                        </div>
                        <div class="info_box">
                            <div class="info_box-img">
                                <picture>
                                    <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/welfare/welfare_box_07_sp.png')}}">
                                    <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/welfare/welfare_box_07_pc.png')}}">
                                    <img src="{{asset('images/contentBox/welfare/welfare_box_07_pc.png')}}" alt="">
                                </picture>
                            </div>
                            <h3 class="info_box-title">人間ドック・がん検診等の<br />補助金制度</h3>
                            <p class="text">人間ドック・がん検診等の受診希望者は、健康保険組合の補助（利用金額の一部を負担）を受けることができます。</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- info career  -->
        <div class="sc-welfare_info">
            <div class="container_inner">
                <div class="info_container page_container">
                    <div class="info_head">
                        <div class="info_head-img">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/welfare/welfare_icon_03_sp.png')}}">
                                <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/welfare/welfare_icon_03_pc.png')}}">
                                <img src="{{asset('images/contentBox/welfare/welfare_icon_03_pc.png')}}" alt="">
                            </picture>
                        </div>
                        <div class="info_head-text">
                            <p class="info_head-text_sub">For Your Career Up</p>
                            <h2 class="info_head-text_title">キャリアアップ制度</h2>
                        </div>
                    </div>
                    <div class="info_content">
                        <div class="info_box">
                            <div class="info_box-img">
                                <picture>
                                    <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/welfare/welfare_box_08_sp.png')}}">
                                    <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/welfare/welfare_box_08_pc.png')}}">
                                    <img src="{{asset('images/contentBox/welfare/welfare_box_08_pc.png')}}" alt="">
                                </picture>
                            </div>
                            <h3 class="info_box-title">各種表彰制度<br /><small>特殊奨励金・社長賞・永年勤続表彰等</small></h3>
                            <p class="text">業務上の目標達成、改善の成果を評価された者、業務外で貢献のあった者および永年勤続社員に賞が贈られます。</p>
                        </div>
                        <div class="info_box">
                            <div class="info_box-img">
                                <picture>
                                    <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/welfare/welfare_box_09_sp.png')}}">
                                    <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/welfare/welfare_box_09_pc.png')}}">
                                    <img src="{{asset('images/contentBox/welfare/welfare_box_09_pc.png')}}" alt="">
                                </picture>
                            </div>
                            <h3 class="info_box-title">教育研修費用補助制度</h3>
                            <p class="text">社員の自己啓発による能力開発とスキルの向上を支援し、一定の資金を援助します。</p>
                        </div>
                        <div class="info_box">
                            <div class="info_box-img">
                                <picture>
                                    <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/welfare/welfare_box_10_sp.png')}}">
                                    <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/welfare/welfare_box_10_pc.png')}}">
                                    <img src="{{asset('images/contentBox/welfare/welfare_box_10_pc.png')}}" alt="">
                                </picture>
                            </div>
                            <h3 class="info_box-title">資格取得支援制度</h3>
                            <p class="text">会社が指定する公的資格について社員の取得を支援し、一定の資金を援助します。</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- info pleasure -->
        <div class="sc-welfare_info sc-gray">
            <div class="container_inner">
                <div class="info_container page_container">
                    <div class="info_head">
                        <div class="info_head-img">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/welfare/welfare_icon_04_sp.png')}}">
                                <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/welfare/welfare_icon_04_pc.png')}}">
                                <img src="{{asset('images/contentBox/welfare/welfare_icon_04_pc.png')}}" alt="">
                            </picture>
                        </div>
                        <div class="info_head-text">
                            <p class="info_head-text_sub">For Your Pleasure</p>
                            <h2 class="info_head-text_title">休暇制度など</h2>
                        </div>
                    </div>
                    <div class="info_content">
                        <div class="info_box">
                            <div class="info_box-img">
                                <picture>
                                    <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/welfare/welfare_box_11_sp.png')}}">
                                    <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/welfare/welfare_box_11_pc.png')}}">
                                    <img src="{{asset('images/contentBox/welfare/welfare_box_11_pc.png')}}" alt="">
                                </picture>
                            </div>
                            <h3 class="info_box-title">誕生日休暇</h3>
                            <p class="text">本人の誕生日に、誕生日休暇を取得できます。<br />
                                また、業務の都合で該当する日に休暇が取得できない場合は、誕生日以降1カ月以内であれば振り替えて取得できます。</p>
                        </div>
                        <div class="info_box">
                            <div class="info_box-img">
                                <picture>
                                    <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/welfare/welfare_box_12_sp.png')}}">
                                    <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/welfare/welfare_box_12_pc.png')}}">
                                    <img src="{{asset('images/contentBox/welfare/welfare_box_12_pc.png')}}" alt="">
                                </picture>
                            </div>
                            <h3 class="info_box-title">ラフォーレ俱楽部<br />優待サービスと補助金制度</h3>
                            <p class="text">ラフォーレ倶楽部対象の宿泊施設をベストレートの会員価格で利用可能です。<br />年度ごとに1人当たり4泊まで宿泊料金を補助します。</p>
                        </div>
                        <div class="info_box">
                            <div class="info_box-img">
                                <picture>
                                    <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/welfare/welfare_box_13_sp.png')}}">
                                    <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/welfare/welfare_box_13_pc.png')}}">
                                    <img src="{{asset('images/contentBox/welfare/welfare_box_13_pc.png')}}" alt="">
                                </picture>
                            </div>
                            <h3 class="info_box-title">ディズニーリゾート補助制度</h3>
                            <p class="text">東京ディズニーランド・東京ディズニーシーのパークチケット購入時、ディズニーホテル宿泊時に使用できるコーポーレートプログラム利用券を、年度ごとに1人当たり8枚まで配布します。</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    {{--html埋め込み部分 end--}}

</div>

@endsection