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
        <div class="sc-page_intro">
            <div class="container_inner">
                <div class="intro_container page_container">
                    <div class="intro_img">
                        <div class="intro_img-item">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/welfare/topWelfare_01_pc.png')}}">
                                <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/welfare/topWelfare_01_pc.png')}}">
                                <img src="{{asset('images/contentBox/welfare/topWelfare_01_pc.png')}}" alt="">
                            </picture>
                        </div>
                        <div class="intro_img-item">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/welfare/topWelfare_02_pc.png')}}">
                                <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/welfare/topWelfare_02_pc.png')}}">
                                <img src="{{asset('images/contentBox/welfare/topWelfare_02_pc.png')}}" alt="">
                            </picture>
                        </div>
                        <div class="intro_img-item">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/welfare/topWelfare_03_pc.png')}}">
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

        <!-- info -->
        <div class="sc-page_info">
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
                                    <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/welfare/welfare_box_01_sp.png')}}">
                                    <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/welfare/welfare_box_01_pc.png')}}">
                                    <img src="{{asset('images/contentBox/welfare/welfare_box_01_pc.png')}}" alt="">
                                </picture>
                            </div>
                            <h3 class="info_box-title">社員持株会制度 </h3>
                            <p class="text">従業員持株会の会員になることで、少額資金を継続的に拠出することにより、ミスミグループ本社の株式を容易に取得できます。</p>
                        </div>
                        <div class="info_box">
                            <div class="info_box-img">
                                <picture>
                                    <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/welfare/welfare_box_01_sp.png')}}">
                                    <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/welfare/welfare_box_01_pc.png')}}">
                                    <img src="{{asset('images/contentBox/welfare/welfare_box_01_pc.png')}}" alt="">
                                </picture>
                            </div>
                            <h3 class="info_box-title">生命保険団体契約</h3>
                            <p class="text">会社が契約者となり、役員・従業員を被保険者（保険の対象となる方）とする契約で、一般の生命保険より保険料が安くなります。</p>
                        </div>
                        <div class="info_box">
                            <div class="info_box-img">
                                <picture>
                                    <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/welfare/welfare_box_01_sp.png')}}">
                                    <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/welfare/welfare_box_01_pc.png')}}">
                                    <img src="{{asset('images/contentBox/welfare/welfare_box_01_pc.png')}}" alt="">
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

        <!-- info -->
        <div class="sc-page_info sc-gray">
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

                    </div>
                </div>
            </div>
        </div>

    </main>

    {{--html埋め込み部分 end--}}

</div>

@endsection