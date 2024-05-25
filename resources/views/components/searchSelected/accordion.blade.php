<section class="mod_jobSearch">
    <div class="mod_jobSearchBox">
        @if($resultTitle)
        <div class="jobSearchBoxTitle">
            <span class="fa fa-search" aria-hidden="true"></span>
            {{($resultTitle)}}
        </div>
        @endif

        @if($fEntSearchAxisData->isSuccessGetAxis)
        <div class="jobSearchFormTgl close">
            現在の検索条件
        </div>

        <div id="jobSearchForm">
            <div class="searchCondHead">
                <div class="searchCondBoxTitle">現在の検索条件</div>

                <x-searchSelected.searchCondHead.headLocation :fEntSearchAxisData="$fEntSearchAxisData" :searchSelectedMasterList="$searchSelectedMasterList" :criteria="$criteria" />

                <x-searchSelected.searchCondHead.headJob :fEntSearchAxisData="$fEntSearchAxisData" :searchSelectedMasterList="$searchSelectedMasterList" :criteria="$criteria" />

                <x-searchSelected.searchCondHead.headKoyo :fEntSearchAxisData="$fEntSearchAxisData" :searchSelectedMasterList="$searchSelectedMasterList" :criteria="$criteria" />

                <x-searchSelected.searchCondHead.headKeyword :fEntSearchAxisData="$fEntSearchAxisData" :criteria="$criteria" />
            </div>

            <div class="searchCondList">

                <x-searchSelected.searchCondList.listLocation :fEntSearchAxisData="$fEntSearchAxisData" :criteria="$criteria" />

                <x-searchSelected.searchCondList.listJob :fEntSearchAxisData="$fEntSearchAxisData" :criteria="$criteria" />

                <x-searchSelected.searchCondList.listKoyo :fEntSearchAxisData="$fEntSearchAxisData" :criteria="$criteria" />

                <x-searchSelected.searchCondList.listKeyword :fEntSearchAxisData="$fEntSearchAxisData" :criteria="$criteria" />
            </div>

            <div class="jobSearchSubmitArea">
                <div>
                    <input type="button" value="再検索" class="jobSearchBtn">
                    <input type="hidden" id="search_url" value="{{route('search.query')}}">
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
