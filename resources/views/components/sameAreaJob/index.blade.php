@if($jobId && count($arrayPrefCode)>0)

@php
/* @var $arrayPrefCode */
$arrayPrefCodeJson = json_encode($arrayPrefCode);
@endphp

<div id="sameAreaJob">
    <div id="box_sameAreaJobContent">
        <div id="sameAreaJobBox">

            <div class="sameAreaJobTitle"></div>

            <div id="sameAreaJobListWrapper">

            </div>
        </div>
    </div>
</div>

<script>
    $(function() {

        let $job_id = {{$jobId}};
        let $pref_cds = {{$arrayPrefCodeJson}};

        searchSameAreaJob($job_id, $pref_cds);

        function searchSameAreaJob($job_id, $pref_cds) {

            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
            $.ajax({
                type: 'POST',
                url: "{{ route('ajax.sameAreaJobs') }}",
                data: {
                    'jobId': $job_id,
                    'prefCds': $pref_cds,
                },
            })
                .then((...args) => { // done
                    const [data, textStatus, jqXHR] = args;

                    let dataStr = data;

                    if(dataStr){
                        let parent = document.getElementById('sameAreaJobListWrapper');
                        let ul = document.createElement('ul');
                        ul.innerHTML = dataStr;

                        parent.append(ul);
                        $('#sameAreaJob').show();
                    }

                })
                .catch((...args) => { // fail
                    const [jqXHR, textStatus, errorThrown] = args;
                });
        }

    });

</script>
@endif