<section id="recommendJob" class="recommendJob">
    <div class="recommendJobInner">
        <h2 class="recommendJobTitle">
            <span class="en">NEW JOBS</span>
            <span class="ja">新着の求人情報</span>
        </h2>
        <div class="recommendJobBox">

            <div id="recommendJobSlide" class="recommendJobSlide swiper-recommendJobSlide">

            </div>

            <button type="button" class="recommendJobButtonPrev">
                {{--<i class="fas fa-angle-left"></i>--}}
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="48.583" viewBox="0 0 30 48.583">
                    <path id="Icon_material-keyboard-arrow-right" data-name="Icon material-keyboard-arrow-right" d="M42.885,51.5,24.342,32.916,42.885,14.333,37.177,8.625,12.885,32.916,37.177,57.208Z" transform="translate(-12.885 -8.625)" fill="#fec400" />
                </svg>
            </button>
            <button type="button" class="recommendJobButtonNext">
                {{--<i class="fas fa-angle-right"></i>--}}
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="48.583" viewBox="0 0 30 48.583">
                    <path id="Icon_material-keyboard-arrow-right" data-name="Icon material-keyboard-arrow-right" d="M12.885,51.5,31.428,32.916,12.885,14.333l5.708-5.709L42.885,32.916,18.593,57.208Z" transform="translate(-12.885 -8.625)" fill="#fec400" />
                </svg>
            </button>
        </div>
    </div>
</section>

<script>
    $(function() {

        searchRecommendJob();

        function searchRecommendJob() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                    type: 'POST',
                    url: "{{ route('ajax.recommendJobs') }}",
                    data: {},
                })
                .then((...args) => { // done
                    const [data, textStatus, jqXHR] = args;

                    let dataStr = data;

                    if (dataStr) {
                        let parent = document.getElementById('recommendJobSlide');
                        let div = document.createElement('div');
                        div.className = 'recommendJobList swiper-wrapper';
                        div.innerHTML = dataStr;

                        parent.append(div);
                        $('.recommendJob').show();

                        loadSwiperRecommend();
                    }

                })
                .catch((...args) => { // fail
                    const [jqXHR, textStatus, errorThrown] = args;
                });
        }

        function loadSwiperRecommend() {
            let mySwiperRecommend = new Swiper('.swiper-recommendJobSlide', {
                loop: true,
                effect: 'slide',
                speed: 900,
                slidesPerView: 3,
                spaceBetween: 30,
                centeredSlides: false,
                // autoplay: {
                //     delay: 3000,
                //     stopOnLastSlide: false,
                //     disableOnInteraction: false,
                //     reverseDirection: false
                // },
                navigation: {
                    nextEl: '.recommendJobButtonNext',
                    prevEl: '.recommendJobButtonPrev'
                },
                breakpoints: {
                    767: {
                        slidesPerView: 1,
                        centeredSlides: true
                    }
                },
                simulateTouch: false,
                autoResize: true,
                autoHeight: false,
                resizeReInit: true,
                watchOverflow: true
            });
        }
    });
</script>