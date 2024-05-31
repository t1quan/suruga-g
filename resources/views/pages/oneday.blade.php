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
            <div class="timeline_inner">
                <div class="timeline_flex">
                    <div class="timeline_box js-fadein">
                        <h3 class="time"><span>9:00</span>出勤</h3>
                        <p class="text">家からたった約15分で会社に到着。出勤後、前日の生産実績・受注量を確認し生産の準備をします。</p>
                    </div>
                    <div class="timeline_box js-fadein">
                        <h3 class="time"><span>9:30</span>朝礼</h3>
                        <p class="text">各エリア管理者が集まり、昨日の生産実績と今日の予定や安全・品質状況について共有しています。</p>
                    </div>
                    <div class="timeline_box js-fadein">
                        <h3 class="time"><span>10:00</span>生産管理</h3>
                        <p class="text">各エリアのミーティングに参加し、メンバーの体調を確認しながら必要な情報を共有します。</p>
                        <div class="img">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/oneday/onedayTimeline_01_sp.png')}}">
                                <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/oneday/onedayTimeline_01_pc.png')}}">
                                <img src="{{asset('images/contentBox/oneday/onedayTimeline_01_pc.png')}}" alt="">
                            </picture>
                        </div>
                    </div>
                    <div class="timeline_box js-fadein">
                        <h3 class="time"><span>12:00</span>お昼休憩</h3>
                        <p class="text">お昼ご飯を食べて、車の中で仮眠を取り、ゆったりとした時間を過ごします。</p>
                    </div>
                    <div class="timeline_box js-fadein">
                        <h3 class="time"><span>13:00</span>上司との打ち合わせ</h3>
                        <p class="text">日常の業務だけではなく、生産や改善活動の進捗を共有し指導・アドバイスを受け計画の見直しを行います。</p>
                        <div class="img">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/oneday/onedayTimeline_02_sp.png')}}">
                                <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/oneday/onedayTimeline_02_pc.png')}}">
                                <img src="{{asset('images/contentBox/oneday/onedayTimeline_02_pc.png')}}" alt="">
                            </picture>
                        </div>
                    </div>
                    <div class="timeline_box js-fadein">
                        <h3 class="time"><span>15:00</span>技術担当者と打ち合わせ</h3>
                        <p class="text">新しい工具の選定・方法の見直し、改善活動に繋がる打ち合わせをします。</p>
                        <div class="img">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/oneday/onedayTimeline_03_sp.png')}}">
                                <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/oneday/onedayTimeline_03_pc.png')}}">
                                <img src="{{asset('images/contentBox/oneday/onedayTimeline_03_pc.png')}}" alt="">
                            </picture>
                        </div>
                    </div>
                    <div class="timeline_box js-fadein">
                        <h3 class="time"><span>17:00</span>生産進捗確認</h3>
                        <p class="text">当日納期の進捗状況を確認し、翌日の計画を各エリア管理者と協議しています。メンバーとのコミュニケーションを取るように意識しています。</p>
                    </div>
                    <div class="timeline_box js-fadein">
                        <h3 class="time"><span>18:00</span>退勤</h3>
                        <p class="text">夜勤出勤メンバーに必要な情報を共有し退勤。その後はフィットネスジムにてトレーニングを行いパンプアップするのが日課です。</p>
                    </div>
                </div>
            </div>
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
        <div class="sc-oneday_timeline sc-oneday_timeline_02">
            <div class="timeline_inner">
                <div class="timeline_flex">
                    <div class="timeline_box js-fadein">
                        <h3 class="time"><span>9:00</span>出勤</h3>
                        <p class="text">家から約20分で会社に到着。出勤後、業務メールのチェックを行います。<br />
                            その後本社からの貨物確認・仕分けをして配布します。</p>
                    </div>
                    <div class="timeline_box js-fadein">
                        <h3 class="time"><span>9:30</span>在庫補充</h3>
                        <p class="text">各作業現場の欠品がないかを確認。<br />
                            材料が入荷されるので受入作業と同時に補充に専念します。</p>
                        <div class="img">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/oneday/onedayTimeline_04_sp.png')}}">
                                <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/oneday/onedayTimeline_04_pc.png')}}">
                                <img src="{{asset('images/contentBox/oneday/onedayTimeline_04_pc.png')}}" alt="">
                            </picture>
                        </div>
                    </div>
                    <div class="timeline_box js-fadein">
                        <h3 class="time"><span>11:30</span>ミーティング</h3>
                        <p class="text">在庫管理グループのメンバーがそろうので、メンバーの体調を確認しながら当日の作業内容をお互いに確認と必要な情報を周知します。</p>
                        <div class="img">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/oneday/onedayTimeline_05_sp.png')}}">
                                <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/oneday/onedayTimeline_05_pc.png')}}">
                                <img src="{{asset('images/contentBox/oneday/onedayTimeline_05_pc.png')}}" alt="">
                            </picture>
                        </div>
                    </div>
                    <div class="timeline_box js-fadein">
                        <h3 class="time"><span>12:00</span>お昼休憩</h3>
                        <p class="text">お昼ご飯を食べて、車の中で仮眠を取り、ゆったりとした時間を過ごします。</p>
                    </div>
                    <div class="timeline_box js-fadein">
                        <h3 class="time"><span>13:00</span>発注業務</h3>
                        <p class="text">購入依頼のあるデータに対して、システムにて発注作業をします。</p>
                        <div class="img">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/oneday/onedayTimeline_06_sp.png')}}">
                                <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/oneday/onedayTimeline_06_pc.png')}}">
                                <img src="{{asset('images/contentBox/oneday/onedayTimeline_06_pc.png')}}" alt="">
                            </picture>
                        </div>
                    </div>
                    <div class="timeline_box js-fadein">
                        <h3 class="time"><span>14:00</span>受入業務</h3>
                        <p class="text">海外から届いた材料を受入し、在庫に補充・バックヤードに入庫をしていきます。</p>
                        <div class="img">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/oneday/onedayTimeline_07_sp.png')}}">
                                <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/oneday/onedayTimeline_07_pc.png')}}">
                                <img src="{{asset('images/contentBox/oneday/onedayTimeline_07_pc.png')}}" alt="">
                            </picture>
                        </div>
                    </div>
                    <div class="timeline_box js-fadein">
                        <h3 class="time"><span>17:00</span>出荷完了確認</h3>
                        <p class="text">当日の出荷に対して、100％完了しているかデータで突き合わせしながら現場への確認をします。</p>
                    </div>
                    <div class="timeline_box js-fadein">
                        <h3 class="time"><span>18:00</span>退勤</h3>
                        <p class="text">出荷が完了していない商品について担当者へ完了予想時刻を共有し、退勤します。時折、コンビニへ行ってデザートを買って食べることが楽しみです。</p>
                    </div>
                </div>
            </div>
        </div>

    </main>

    {{--html埋め込み部分 end--}}

</div>

@endsection