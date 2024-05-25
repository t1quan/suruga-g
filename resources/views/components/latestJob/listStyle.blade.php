<div id="latestJob" class="latestJob">
    <div id="latestJobBox">
        <div class="latestJobTitle"></div>

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

                    let parent = document.getElementById('latestJobBox');
                    let ul = document.createElement('ul');
                    ul.innerHTML = dataStr;

                    parent.append(ul);
                    $('.latestJob').show();

                })
                .catch((...args) => { // fail
                    const [jqXHR, textStatus, errorThrown] = args;
                });
        }

    });

</script>
