<?php
$sliderImgList = array(
    'pc' => array(
//        'mv_movie_pc.mp4',
        'top_img_main_01_pc.png',
    ),
    'sp' => array(
//        'mv_movie_sp.mp4',
        'top_img_main_01_sp.png',
    ),
);
$mvCatchCopy = '';//メインビジュアルのキャッチコピーを「''」内に入力してください
?>

@if(($sliderImgList['pc'] && count($sliderImgList['pc']) > 0) || ($sliderImgList['sp'] && count($sliderImgList['sp']) > 0))

<div id="mvSlider">
    <div class="mvWrapper">
        <div class="mvInner">
            <?php
            $imgListPc = $sliderImgList[ 'pc' ];
            $imgListSp = $sliderImgList[ 'sp' ];
            ?>
            <?php if(count($imgListPc) == 1): ?>
            <div class="mvOnlyOne">
                <picture>
                    <source media="(max-width: 767px)" srcset="{{asset('images/mvSlider/'. $imgListSp[0])}}">
                    <source media="(min-width: 768px)" srcset="{{asset('images/mvSlider/'. $imgListPc[0])}}">
                    <img class="mvPicture" src="{{asset('images/mvSlider/'. $imgListPc[0])}}" alt="<?php echo $mvCatchCopy; ?>">
                </picture>
            </div>
            <?php elseif(count($imgListPc) > 1): ?>
            <div class="mvMultiple js-mvSlider">
                <div class="swiper-wrapper">
                    <?php foreach($imgListPc as $key => $imgName): ?>
                    <div class="swiper-slide">
                        <picture>
                            <source media="(max-width: 767px)" srcset="{{asset('images/mvSlider/'. $imgListSp[$key])}} 2x">
                            <source media="(min-width: 768px)" srcset="{{asset('images/mvSlider/'. $imgName)}} 2x">
                            <img class="mvPicture" src="{{asset('images/mvSlider/'. $imgName)}}" alt="<?php echo $mvCatchCopy; ?>">
                        </picture>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
            <a href="#template01">
                <div class="scrollDownGuide">
                    SCROLL DOWN
                </div>
            </a>
        </div>
    </div>

    <script>
        $(function() {
            var mySwiperTop = new Swiper('#mvSlider .js-mvSlider', {// Swiperオプション
                loop: true,
                effect: 'fade',// アニメーションを指定（'slide' 'fade' 'coverflow' 'flip'）
                speed: 3000,// 移動速度（3000=3秒）
                autoplay: {
                    delay: 3000,// スライド間の間隔（3000=3秒）
                    stopOnLastSlide: false,
                    disableOnInteraction: false,
                    reverseDirection: false
                },
                breakpoints: {
                    767: {// スマホのみ
                        speed: 3000,// 移動速度（3000=3秒）
                        autoplay: {
                            delay: 3000,// スライド間の間隔（3000=3秒）
                        }
                    }
                },
                slidesPerView: 1,
                spaceBetween: 0,
                centeredSlides: false,
                simulateTouch: false,
                autoResize: false,
                autoHeight: false,
                resizeReInit: true,
                watchOverflow: true
            });
            $('#mvSlider .mvMultiple .swiper-slide').on('touchmove', function(){
                return true;
            });
        });
    </script>
</div>

@endif
