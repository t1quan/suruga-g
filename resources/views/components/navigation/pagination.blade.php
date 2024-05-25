@if($fEntPager)
<nav class="pagination">
    <div class="count">該当件数<em>{{$fEntPager->totalCnt}}</em>件</div>
    <div class="new_pagenation">

        @if($fEntPager->prevPage)
            <a class="page_prev_n" href="{{$fEntPager->action}}{{$fEntPager->prevPage}}">
                <span>前のページ</span>
            </a>
        @endif

        <ul>
            @for($i = $fEntPager->pageSt; $i <= $fEntPager->pageEnd; $i++)
                @if($i == $fEntPager->currentPage)
                    <li class="first">
                        <span>{{$i}}</span>
                    </li>
                @else
                    <li>
                        <a class="" href="{{$fEntPager->action}}{{$i}}">{{$i}}</a>
                    </li>
                @endif
            @endfor
        </ul>

            @if($fEntPager->nextPage)
                <a class="page_next_n" href="{{$fEntPager->action}}{{$fEntPager->nextPage}}">
                    <span>次のページ</span>
                </a>
            @endif

    </div>
</nav>
@endif