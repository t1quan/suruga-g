@extends('layouts.app')

@section('title', $page->title ?? '')

@section('content')

<div id="contentArea">

    {{--html埋め込み部分 start--}}

    <link rel="stylesheet" href="{{asset('css/page_single.css')}}">
    <link rel="stylesheet" href="{{asset('css/work.css')}}">
    <main id="main_wrap">

        <!-- banner -->
        <div class="sc-page_banner">
            <div class="container_inner">
                <div class="banner_container">
                    <div class="banner_container-inner js-fadein">
                        <h1 class="banner_title">OUR WORK</h1>
                        <p class="text">部門紹介</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- intro -->
        <div class="sc-work_intro">
            <div class="container_inner">
                <div class="intro_container">
                    <div class="intro_img  js-fadein">
                        <div class="intro_img-item">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/work/workCharactor_01_sp.png')}}">
                                <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/work/workCharactor_01_pc.png')}}">
                                <img src="{{asset('images/contentBox/work/workCharactor_01_pc.png')}}" alt="">
                            </picture>
                        </div>
                        <div class="intro_img-item">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/work/workCharactor_02_sp.png')}}">
                                <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/work/workCharactor_02_pc.png')}}">
                                <img src="{{asset('images/contentBox/work/workCharactor_02_pc.png')}}" alt="">
                            </picture>
                        </div>
                        <div class="intro_img-item">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/work/workCharactor_03_sp.png')}}">
                                <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/work/workCharactor_03_pc.png')}}">
                                <img src="{{asset('images/contentBox/work/workCharactor_03_pc.png')}}" alt="">
                            </picture>
                        </div>
                        <div class="intro_img-item">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/work/workCharactor_04_sp.png')}}">
                                <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/work/workCharactor_04_pc.png')}}">
                                <img src="{{asset('images/contentBox/work/workCharactor_04_pc.png')}}" alt="">
                            </picture>
                        </div>
                    </div>
                    <div class="intro_link js-fadein">
                        <a href="#work01" class="scroll intro_link-link">
                            <span class="num">01</span>
                            <span class="text">FA部品事業</span>
                        </a>
                        <a href="#work02" class="scroll intro_link-link">
                            <span class="num">02</span>
                            <span class="text">金型部品事業</span>
                        </a>
                        <a href="#work03" class="scroll intro_link-link">
                            <span class="num">03</span>
                            <span class="text">meviy部品事業</span>
                        </a>
                        <a href="#work04" class="scroll intro_link-link">
                            <span class="num">04</span>
                            <span class="text">製造サポート部</span>
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
                        <h2 class="title">動画で知る部門紹介</h2>
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
        <div class="sc-work_info" id="work01">
            <div class="info_head js-fadein">
                <div class="info_container">
                    <div class="info_head-inner">
                        <div class="info_head-text">
                            <h2 class="info_head-title">Work 01</h2>
                            <p class="text">FA部品事業</p>
                        </div>
                        <div class="info_head-img">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/work/workInfo_1_01_sp.png')}}">
                                <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/work/workInfo_1_01_pc.png')}}">
                                <img src="{{asset('images/contentBox/work/workInfo_1_01_pc.png')}}" alt="">
                            </picture>
                        </div>
                    </div>
                </div>
            </div>
            <div class="info_content">
                <div class="info_container">
                    <div class="info_content-text js-fadein">
                        <h3 class="info_content-text_title">
                            ファクトリーオートメーション向けの<br class="SPbr" />部材をNC旋盤を使用して製作
                        </h3>
                        <p class="text">数年の現場勤務を経験し、ものづくりや製品に関する知識を身につけた後、製造間接部門にて生産管理・品質管理・在庫管理など業務を習得していただきます。</p>
                        <span class="space"></span>
                        <h3 class="info_content-text_title">
                            圧倒的な量産体制確立、<br class="SPbr" />世界中の生産ラインを下支えする<br class="SPbr" />ものづくり
                        </h3>
                        <p class="text">IM製造部は、FA（Factory Automation=ファクトリー・オートメーション：生産工程の自動化）など自動化関連部品の製造を担っています。あらゆる工場において、その構築の成否が競争力に直結するFA。IMユニットでは、そうした生産ラインを支える様々な部品を量産しています。<br />
                            主に、連結部品の支柱（円形・六角・四角）、機構部品の回転軸を製造、1日当たり10,000本を超える生産アウトプットを保持しています。培ってきた技術力の上に、デジタル、ICTを駆使し、継続的な進化を遂げています。各種追加工、鍍金ユニットでの表面処理にも対応しており、お客様のニーズに合わせた高品質、且つ確実短納期の量産体制は、グローバルスタンダードとして、世界各国に展開しています。</p>
                    </div>
                    <div class="info_content-img js-fadein">
                        <div class="info_content-img_item">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/work/workInfo_1_02_sp.png')}}">
                                <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/work/workInfo_1_02_pc.png')}}">
                                <img src="{{asset('images/contentBox/work/workInfo_1_02_pc.png')}}" alt="">
                            </picture>
                        </div>
                        <div class="info_content-img_item">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/work/workInfo_1_03_sp.png')}}">
                                <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/work/workInfo_1_03_pc.png')}}">
                                <img src="{{asset('images/contentBox/work/workInfo_1_03_pc.png')}}" alt="">
                            </picture>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- info 02 -->
        <div class="sc-work_info" id="work02">
            <div class="info_head js-fadein">
                <div class="info_container">
                    <div class="info_head-inner">
                        <div class="info_head-text">
                            <h2 class="info_head-title">Work 02</h2>
                            <p class="text">金型部品事業</p>
                        </div>
                        <div class="info_head-img">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/work/workInfo_2_01_sp.png')}}">
                                <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/work/workInfo_2_01_pc.png')}}">
                                <img src="{{asset('images/contentBox/work/workInfo_2_01_pc.png')}}" alt="">
                            </picture>
                        </div>
                    </div>
                </div>
            </div>
            <div class="info_content">
                <div class="info_container">
                    <div class="info_content-text js-fadein">
                        <h3 class="info_content-text_title">
                            金型に組付けられる<br class="SPbr" />パンチ・ブッシュ等部品を<br class="SPbr" />自動機・汎用機を使い製造
                        </h3>
                        <p class="text">数年の現場勤務を経験しものづくりや製品に関する知識を身につけた後、製造間接部門にて生産管理、品質管理、在庫管理など業務を習得していただきます。　</p>
                        <span class="space"></span>
                        <h3 class="info_content-text_title">
                            磨き込まれた<br class="SPbr" />「精密加工技術」のものづくり
                        </h3>
                        <p class="text">金型製造部は、自動車や電子・電気機器などの金型用部品製造を担っています。身の回りにある多くのプラスチック製品は、金型（モールド）に流し込む射出成形で加工されます。</p>
                        <p class="text">プレスユニットでは、金型成型に使用するパンチ＆ダイの国内トップクラスシェアを有し、半世紀を超え、精密加工技術（切削・研削・研磨）を培ってきた当社の土台です。</p>
                        <p class="text">モールドユニットでは、主要部品となるコアピン、エジェクターピンなどを製造しており、世界各国の金型製造業、成形加工業を、幅広く縁の下で支えています。<br />
                            ミクロン単位の精度で、高品質な製品を、且つ短納期でお客様のニーズに対応しています。</p>
                    </div>
                    <div class="info_content-img js-fadein">
                        <div class="info_content-img_item">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/work/workInfo_2_02_sp.png')}}">
                                <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/work/workInfo_2_02_pc.png')}}">
                                <img src="{{asset('images/contentBox/work/workInfo_2_02_pc.png')}}" alt="">
                            </picture>
                        </div>
                        <div class="info_content-img_item">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/work/workInfo_2_03_sp.png')}}">
                                <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/work/workInfo_2_03_pc.png')}}">
                                <img src="{{asset('images/contentBox/work/workInfo_2_03_pc.png')}}" alt="">
                            </picture>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- info 03 -->
        <div class="sc-work_info" id="work03">
            <div class="info_head js-fadein">
                <div class="info_container">
                    <div class="info_head-inner">
                        <div class="info_head-text">
                            <h2 class="info_head-title">Work 03</h2>
                            <p class="text">meviy部品事業</p>
                        </div>
                        <div class="info_head-img">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/work/workInfo_3_01_sp.png')}}">
                                <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/work/workInfo_3_01_pc.png')}}">
                                <img src="{{asset('images/contentBox/work/workInfo_3_01_pc.png')}}" alt="">
                            </picture>
                        </div>
                    </div>
                </div>
            </div>
            <div class="info_content">
                <div class="info_container">
                    <div class="info_content-text js-fadein">
                        <h3 class="info_content-text_title">
                            ミスミの3Dものづくりプラットフォーム<br class="SPbr" />meviyにおける、国内製造を担っています
                        </h3>
                        <p class="text">主に機械加工製品における特注品の切削加工を中心に製作しています。数年の現場勤務を経験しものづくりや製品に関する知識を身につけた後、製造間接部門にて生産管理・品質管理・在庫管理など業務を習得し管理者を目指していただきます。</p>
                        <span class="space"></span>
                        <h3 class="info_content-text_title">
                            機械部品調達のAIプラットフォーム<br class="SPbr" />「meviy」、国内製造拠点のマザー工場
                        </h3>
                        <p class="text">meviy製造部は、特注品（型番レス）デジタルものづくりを担っています。<br />
                            「第9回ものづくり日本大賞：2013年1月」において、最高峰「内閣総理大臣賞」を受賞したmeviyは、ミスミによって実現された、他に類を見ないものづくりDX（Digital Transformation）の姿です。<br />
                            金型・IM製造部の商品は標準品（型番カタログ品）、一方、meviyは特注品（型番レス）であり、受注・見積もり・加工プログラム生成まで、圧倒的な時間価値を創出する仕掛けとなっています。さらにこれらのDX革新に追従するmeviy製造部は、デジタルものづくりの体制を確立し、確実短納期、生産性向上、高品質を以ってmeviyの発展に貢献しています。<br />
                            meviyデジタルマニュファクチュアリングシステム（変種変量ものづくりの無人生産）の礎となり更なる進化を遂げるロードマップを歩み続けています。</p>
                    </div>
                    <div class="info_content-img js-fadein">
                        <div class="info_content-img_item">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/work/workInfo_3_02_sp.png')}}">
                                <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/work/workInfo_3_02_pc.png')}}">
                                <img src="{{asset('images/contentBox/work/workInfo_3_02_pc.png')}}" alt="">
                            </picture>
                        </div>
                        <div class="info_content-img_item">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/work/workInfo_3_03_sp.png')}}">
                                <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/work/workInfo_3_03_pc.png')}}">
                                <img src="{{asset('images/contentBox/work/workInfo_3_03_pc.png')}}" alt="">
                            </picture>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- info 04 -->
        <div class="sc-work_info" id="work04">
            <div class="info_head js-fadein">
                <div class="info_container">
                    <div class="info_head-inner">
                        <div class="info_head-text">
                            <h2 class="info_head-title">Work 04</h2>
                            <p class="text">製造サポート部</p>
                        </div>
                        <div class="info_head-img">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/work/workInfo_4_01_sp.png')}}">
                                <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/work/workInfo_4_01_pc.png')}}">
                                <img src="{{asset('images/contentBox/work/workInfo_4_01_pc.png')}}" alt="">
                            </picture>
                        </div>
                    </div>
                </div>
            </div>
            <div class="info_content">
                <div class="info_container">
                    <div class="info_content-text js-fadein">
                        <h3 class="info_content-text_title">
                            生産現場を裏から支える役割のチーム
                        </h3>
                        <p class="text">お客様が求める高品質・低コスト・確実短納期に応える生産現場を裏から支える役割のチームになります。主には在庫管理業務と機械の保全・開発業務を担います。在庫管理業務では自社開発したグローバル在庫管理方法により、確実短納期の実現ができています。機械保全・開発業務は機械に精通した技術者が保全業務で蓄えた経験を自動加工機開発、マテハン機器開発に活かし製造部の高品質、低コストに貢献しております。製造サポートチームでは専門的な作業が多いですが専門的・技術的なスキルを習得できます。</p>
                    </div>
                    <div class="info_content-img js-fadein">
                        <div class="info_content-img_item">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/work/workInfo_4_02_sp.png')}}">
                                <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/work/workInfo_4_02_pc.png')}}">
                                <img src="{{asset('images/contentBox/work/workInfo_4_02_pc.png')}}" alt="">
                            </picture>
                        </div>
                        <div class="info_content-img_item">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/work/workInfo_4_03_sp.png')}}">
                                <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/work/workInfo_4_03_pc.png')}}">
                                <img src="{{asset('images/contentBox/work/workInfo_4_03_pc.png')}}" alt="">
                            </picture>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    {{--html埋め込み部分 end--}}

</div>

@endsection