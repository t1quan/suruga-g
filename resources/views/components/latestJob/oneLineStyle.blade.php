<div id="latestJob" class="latestJob">
    <div class="latestJobInner">
        <h2 class="latestJobTitle">
            <span class="en">NEW JOBS</span>
            <span class="ja">新着の求人情報</span>
        </h2>

        <div id="latestJobSwiper" class="latestJobBox swiper-latestOneLine">

        </div>

        <a href="{{route('search.query')}}" class="latestJobMoreButton">
            <span class="buttonText">MORE</span>
        </a>
    </div>
</div>

<script>
    $(function() {

        searchNewJob();

        function searchNewJob() {

            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
            $.ajax({
                type: 'POST',
                url: "{{ route('ajax.latestJobs') }}",
                data: {},
            })
                .then((...args) => { // done
                    const [data, textStatus, jqXHR] = args;

                    let dataStr = data;
                    if(!dataStr){
                        return(-1);
                        // dataStr = '<li class="notJob">新着の求人が見つかりませんでした。</li>';
                    }

                    let parent = document.getElementById('latestJobSwiper');
                    let div = document.createElement('div');
                    div.className = 'latestJobList swiper-wrapper';
                    div.innerHTML = dataStr;

                    parent.append(div);
                    $('.latestJob').show();

                    loadSwiperOneLine();

                })
                .catch((...args) => { // fail
                    const [jqXHR, textStatus, errorThrown] = args;
                });
        }

        //スライドスクリプトswiper
        //latestJob 新着案件1行スライド表示用
        function loadSwiperOneLine() {
            let mySwiperLatestJob = new Swiper('.swiper-latestOneLine', {
                loop: true,
                effect: 'slide',
                speed: 900,
                autoplay: {
                    delay: 3000,
                    stopOnLastSlide: false,
                    disableOnInteraction: false,
                    reverseDirection: false
                },
                slidesPerView: 1,
                spaceBetween: 10,
                centeredSlides: false,
                simulateTouch: false,
                autoResize: true,
                autoHeight: true,
                resizeReInit: true,
                watchOverflow: true
            });
        }

    });

</script>