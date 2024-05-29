@extends('layouts.app')

@section('title', $page->title ?? '')

@section('content')

<div id="contentArea">

    {{--html埋め込み部分 start--}}

    <link rel="stylesheet" href="{{asset('css/page_single.css')}}">
    <link rel="stylesheet" href="{{asset('css/oneday2.css')}}">
    <main id="main_wrap">

        <!-- banner -->
        <div class="sc-page_banner">
            <div class="container_inner">
                <div class="banner_container">
                    <div class="banner_container-inner js-fadein">
                        <h1 class="banner_title">ONEDAY</h1>
                        <p class="text">社員の1日</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- intro -->
        <div class="sc-oneday_intro">
            <div class="container_inner">
                <div class="intro_container">
                    <div class="intro_img js-fadein">
                        <div class="intro_img-item">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/oneday/onedayIntro_01_sp.png')}}">
                                <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/oneday/onedayIntro_01_pc.png')}}">
                                <img src="{{asset('images/contentBox/oneday/onedayIntro_01_pc.png')}}" alt="">
                            </picture>
                        </div>
                        <div class="intro_img-item">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/oneday/onedayIntro_02_sp.png')}}">
                                <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/oneday/onedayIntro_02_pc.png')}}">
                                <img src="{{asset('images/contentBox/oneday/onedayIntro_02_pc.png')}}" alt="">
                            </picture>
                        </div>
                    </div>
                    <div class="intro_link js-fadein">
                        <a href="#oneday01" class="scroll intro_link-link">
                            <span class="num">01</span>
                            <span class="text-sm">製造管理者</span>
                            <span class="text">松田 裕太</span>
                        </a>
                        <a href="#oneday02" class="scroll intro_link-link">
                            <span class="num">02</span>
                            <span class="text-sm">在庫管理・総務</span>
                            <span class="text">石橋 成悦</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- movie -->
        <div class="sc-page_movie">
            <div class="container_inner">
                <div class="movie_container page_container">
                    <div class="movie_head js-fadein">
                        <p class="sub-title">30 SECONDS MOVIE</p>
                        <h2 class="title">動画で知るサクセスストーリー</h2>
                    </div>
                    <div class="movie_video js-fadein">
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

        <!-- info 01 -->
        <div class="sc-onday_info" id="oneday01">
            <div class="info_container">
                <div class="info_text js-fadein">
                    <div class="info_text-inner">
                        <p class="num">01</p>
                        <small class="position">製造管理者</small>
                        <h2 class="name">
                            <span class="ja">松田 裕太<span class="join">（2012年入社）</span></span>
                            <span class="en">Yuta Matsuda</span>
                        </h2>
                        <h3 class="company">駿河プラットフォーム<span class="space"></span>IM関西工場</h3>
                        <p class="desc">入社11年目。ものづくりが好きで機械オペレーターとして入社しました。今ではマネジャーとして現場管理を担当。様々な課題にメンバーと挑戦し、やりがいのある日々を過ごしています。</p>
                    </div>
                </div>
                <div class="info_img js-fadein">
                    <picture>
                        <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/oneday/onedayCharactor_01_sp.png')}}">
                        <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/oneday/onedayCharactor_01_pc.png')}}">
                        <img src="{{asset('images/contentBox/oneday/onedayCharactor_01_pc.png')}}" alt="">
                    </picture>
                </div>
            </div>
        </div>

        <!-- timeline 01 -->
        <div class="sc-oneday_timeline">
            <div class="container_inner"></div>
        </div>

        <!-- info 02 -->
        <div class="sc-onday_info" id="oneday02">
            <div class="info_container">
                <div class="info_text js-fadein">
                    <div class="info_text-inner">
                        <p class="num">02</p>
                        <small class="position">在庫管理・総務</small>
                        <h2 class="name">
                            <span class="ja">石橋 成悦<span class="join">（2010年入社）</span></span>
                            <span class="en">Masayoshi Ishibashi</span>
                        </h2>
                        <h3 class="company">駿河プラットフォーム 関西金型製造部 管理グループ</h3>
                        <p class="desc">入社13年目。過去の職務経歴を生かすべく、間接的な業務をしたいと思い入社しました。現在、在庫管理から総務関係まで手広く作業しており、工場を支えている実感とやりがいを感じています。</p>
                    </div>
                </div>
                <div class="info_img js-fadein">
                    <picture>
                        <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/oneday/onedayCharactor_02_sp.png')}}">
                        <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/oneday/onedayCharactor_02_pc.png')}}">
                        <img src="{{asset('images/contentBox/oneday/onedayCharactor_02_pc.png')}}" alt="">
                    </picture>
                </div>
            </div>
        </div>

        <!-- timeline 02 -->
        <div class="sc-oneday_timeline">
            <div class="container_inner"></div>
        </div>

    </main>

    {{--html埋め込み部分 end--}}

</div>

@endsection