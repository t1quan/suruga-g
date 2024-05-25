@if($arrayFEntJob)
@foreach($arrayFEntJob as $fEntJob)
    <li>
        <a href="{{Route('top')}}/job/{{ $fEntJob->jobId ?? '' }}">
            <div class="newInfoDate"><x-atoms.date :date="$fEntJob->updatedAt" format="Y.m.d" /></div>
            <div class="newInfoTag">
                {{$fEntJob->jobTitle}}
            </div>
            <div class="newInfoDetail">
                @if($fEntJob->kyuyoKbnName && $fEntJob->kyuyoMin)
                    <span>
                        {{$fEntJob->kyuyoKbnName}}：
                        <x-atoms.salary :kyuyoMin="$fEntJob->kyuyoMin" :kyuyoMax="$fEntJob->kyuyoMax" dispType="char" />
                    </span>
                @endif
                @if($fEntJob->workingTimes)
                    <span>
                    {{$fEntJob->workingTimes}}
                    </span>
                @endif
            </div>
        </a>
    </li>
@endforeach
@endif