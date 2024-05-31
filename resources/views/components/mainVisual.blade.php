<div class="sc-topSlide">
    <div class="topSlide_container">
        <div class="topSlide_text js-fadein">
            <p class="slide_sub"><span class="text">スペシャリストな個性派エンジニア集団</span></p>
            <h1 class="slide_title">今までにないものを創れる会社</h1>
            <div class="slide_logo">
                <picture>
                    <source media="(max-width: 767px)" srcset="{{asset('images/common/topSlide_logo_sp.png')}}">
                    <source media="(min-width: 768px)" srcset="{{asset('images/common/topSlide_logo_pc.png')}}">
                    <img src="{{asset('images/common/topSlide_logo_pc.png')}}" alt="">
                </picture>
            </div>
        </div>
    </div>
</div>
<?php
$sliderImgList = array(
    'pc' => array(
        //        'mv_movie_pc.mp4',
        'topSlide_01_pc.png',
        'topSlide_02_pc.png',
        'topSlide_03_pc.png',
    ),
    'sp' => array(
        //        'mv_movie_sp.mp4',
        'topSlide_01_sp.png',
        'topSlide_02_sp.png',
        'topSlide_03_sp.png',
    ),
);
$mvCatchCopy = ''; //メインビジュアルのキャッチコピーを「''」内に入力してください
?>

@if(($sliderImgList['pc'] && count($sliderImgList['pc']) > 0) || ($sliderImgList['sp'] && count($sliderImgList['sp']) > 0))

<div id="mvSlider">
    <div class="mvWrapper">
        <div class="mvInner">
            <?php
            $imgListPc = $sliderImgList['pc'];
            $imgListSp = $sliderImgList['sp'];
            ?>
            <?php if (count($imgListPc) == 1) : ?>
                <div class="mvOnlyOne">
                    <picture>
                        <source media="(max-width: 767px)" srcset="{{asset('images/mvSlider/'. $imgListSp[0])}}">
                        <source media="(min-width: 768px)" srcset="{{asset('images/mvSlider/'. $imgListPc[0])}}">
                        <img class="mvPicture" src="{{asset('images/mvSlider/'. $imgListPc[0])}}" alt="<?php echo $mvCatchCopy; ?>">
                    </picture>
                </div>
            <?php elseif (count($imgListPc) > 1) : ?>
                <div class="mvMultiple js-mvSlider">
                    <div class="swiper-wrapper">
                        <?php foreach ($imgListPc as $key => $imgName) : ?>
                            <div class="swiper-slide">
                                <picture>
                                    <source media="(max-width: 767px)" srcset="{{asset('images/mvSlider/'. $imgListSp[$key])}}">
                                    <source media="(min-width: 768px)" srcset="{{asset('images/mvSlider/'. $imgName)}}">
                                    <img class="mvPicture" src="{{asset('images/mvSlider/'. $imgName)}}" alt="<?php echo $mvCatchCopy; ?>">
                                </picture>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            {{--
            <a href="#template01">
                <div class="scrollDownGuide">
                    SCROLL DOWN
                </div>
            </a>
            --}}
        </div>
    </div>

    <script>
        $(function() {
            var mySwiperTop = new Swiper('#mvSlider .js-mvSlider', { // Swiperオプション
                loop: true,
                effect: 'slide', // アニメーションを指定（'slide' 'fade' 'coverflow' 'flip'）
                speed: 3000, // 移動速度（3000=3秒）
                autoplay: {
                    delay: 3000, // スライド間の間隔（3000=3秒）
                    stopOnLastSlide: false,
                    disableOnInteraction: false,
                    reverseDirection: false
                },
                breakpoints: {
                    767: { // スマホのみ
                        speed: 3000, // 移動速度（3000=3秒）
                        autoplay: {
                            delay: 3000, // スライド間の間隔（3000=3秒）
                        }
                    }
                },
                slidesPerView: 1.6,
                spaceBetween: 60,
                centeredSlides: true,
                simulateTouch: false,
                autoResize: false,
                autoHeight: false,
                resizeReInit: true,
                watchOverflow: true
            });
            $('#mvSlider .mvMultiple .swiper-slide').on('touchmove', function() {
                return true;
            });
        });
    </script>
</div>

@endif