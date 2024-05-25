<div id="data" class="contentData">
    <div class="contentDataWrapper">
        <div class="contentDataInner">
            <h2 class="contentHeading">
                <span class="en">DATA</span>
                <span class="ja">データで見るUACJ物流</span>
            </h2>
            <div class="contentDataBox">
                <div class="data">
                    <picture>
                        <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/data/data_001_pc.png')}}">
                        <img src="{{asset('images/contentBox/data/data_001_pc.png')}}" alt="">
                    </picture>
                </div>
                <div class="data">
                    <picture>
                        <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/data/data_002_pc.png')}}">
                        <img src="{{asset('images/contentBox/data/data_002_pc.png')}}" alt="">
                    </picture>
                </div>
                <div class="data">
                    <picture>
                        <source media="(min-width: 768px)" srcset="{{asset('images/contentBox/data/data_003_pc.png')}}">
                        <img src="{{asset('images/contentBox/data/data_003_pc.png')}}" alt="">
                    </picture>
                </div>
                <div class="swiperDataSlide">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide data">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/data/data_001_sp.png')}} 2x">
                                <img src="{{asset('images/contentBox/data/data_001_sp.png')}}" alt="">
                            </picture>
                        </div>
                        <div class="swiper-slide data">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/data/data_002_sp.png')}} 2x">
                                <img src="{{asset('images/contentBox/data/data_002_sp.png')}}" alt="">
                            </picture>
                        </div>
                        <div class="swiper-slide data">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{asset('images/contentBox/data/data_003_sp.png')}} 2x">
                                <img src="{{asset('images/contentBox/data/data_003_sp.png')}}" alt="">
                            </picture>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="contentLinkBtn js-clickitem">
            <span class="linkText">READ MORE</span>
            <i class="fas fa-arrow-right"></i>
            <a href="{{Route('xxxx')}}"></a>
        </div>
    </div>
</div>

<script>
$(function() {
    var mySwiperData = new Swiper('#data .swiperDataSlide', {// Swiperオプション
        loop: true,
        effect: 'slide',// アニメーションを指定（'slide' 'fade' 'coverflow' 'flip'）
        speed: 3000,// 移動速度（3000=3秒）
        simulateTouch: false,
        autoResize: true,
        autoHeight: true,
        resizeReInit: true,
        watchOverflow: false,
        slidesPerView: 2,
        centeredSlides: true,
        autoplay: {
            delay: 3000,// スライド間の間隔（3000=3秒）
            stopOnLastSlide: false,
            disableOnInteraction: false,
            reverseDirection: false
        },
        spaceBetween: 0,
    });
    $('#contentDataBox .swiper-slide').on('touchmove', function(){
        return true;
    });
});
</script>
