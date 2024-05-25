@props(['fEntSearchAxisData'=> null,'fEntConfig'])

@php
    //必須検索軸情報の取得
    $frontendSettings = $fEntConfig->frontendSettings ?? array();
    $arrayConfigRequiredAxis = $frontendSettings['searchAxisRequiredList'] ?? array();

    $arrayRequiredAxis = array();

    foreach($arrayConfigRequiredAxis As $configRequiredAxis) {

        //カスタム検索軸の場合は判定スキップ
        if($configRequiredAxis === 'area' || $configRequiredAxis === 'pref' || $configRequiredAxis === 'city') {
            if($frontendSettings['isCustomArea']) {
                continue;
            }
        }
        if($configRequiredAxis === 'jobbc' || $configRequiredAxis === 'job') {
            if($frontendSettings['isCustomJob']) {
                continue;
            }
        }

        $arrayRequiredAxis[] = $configRequiredAxis;
    }

    $isNothingAxis = true;

    if($frontendSettings['isCustomArea'] || $frontendSettings['isCustomJob']) {
        $isNothingAxis = false;
    }

    foreach($arrayRequiredAxis As $index => $value) {
        if($fEntSearchAxisData->fEntSearchAxis->$value !== null) {
            $isNothingAxis = false;
            break;
        }
    }
@endphp

@if($fEntSearchAxisData)
    @if($fEntSearchAxisData->isSuccessGetAxis && $isNothingAxis === false)
    <section id="searchBox">
        <div class="searchBoxWrapper">
            <div class="searchBoxBg">
                <h2 class="searchBoxTitle">
                    <span class="en">SEARCH JOBS</span>
                    <span class="ja">求人検索</span>
                </h2>
                <x-quickSearch :fEntSearchAxisData="$fEntSearchAxisData" :fEntConfig="$fEntConfig" />
            </div>

            <div class="searchBoxBody">
                <div class="searchBoxBodyWrapper">
                    <div class="searchSelect">
                        <div class="searchSelectWrapper">
                            <div class="container-area search-container">
                                <div class="search-function">
                                    <div class="search-form__form">
                                        <div class="search-tab">
                                            <ul class="search-tab__btn">
                                                @php
                                                    $isFirstViewJobAxis = false;
                                                    /**@var \App\Models\FEnt\FEntSearchAxisData $fEntSearchAxisData */
                                                    if(isset($fEntSearchAxisData->fEntSearchAxis->jobbc) || isset($fEntSearchAxisData->fEntSearchAxis->job)) {
                                                        if(!(isset($fEntSearchAxisData->fEntSearchAxis->area) || isset($fEntSearchAxisData->fEntSearchAxis->pref) || isset($fEntSearchAxisData->fEntSearchAxis->city))) {
                                                            $isFirstViewJobAxis = true;
                                                        }
                                                    }
                                                @endphp
                                                @if(isset($fEntSearchAxisData->fEntSearchAxis->area) || isset($fEntSearchAxisData->fEntSearchAxis->pref) || isset($fEntSearchAxisData->fEntSearchAxis->city))
                                                <li data-id="1" class="search-tab__ready search-tab__area js-clicked__blue">
                                                    <p class="PCdisp">エリアから選ぶ</p>
                                                    <p class="SPdisp">エリア</p>
                                                </li>
                                                @endif
                                                @if(isset($fEntSearchAxisData->fEntSearchAxis->jobbc) || isset($fEntSearchAxisData->fEntSearchAxis->job))
                                                <li data-id="2" class="search-tab__ready search-tab__job {{$isFirstViewJobAxis ? 'js-clicked__blue' : ''}}">
                                                    <p class="PCdisp">職種から選ぶ</p>
                                                    <p class="SPdisp">職種</p>
                                                </li>
                                                @endif
                                                @if(isset($fEntSearchAxisData->fEntSearchAxis->koy))
                                                <li data-id="3" class="search-tab__ready search-tab__employee">
                                                    <p class="PCdisp">雇用形態から選ぶ</p>
                                                    <p class="SPdisp">雇用形態</p>
                                                </li>
                                                @endif
                                            </ul>
                                        </div>

                                        {{--エリアから選ぶ start--}}
                                        @php
                                        $locationAxisType = '';
                                        //「エリアから選ぶ」の検索ボックスに何の項目を表示するか(表示優先順はpref > area > city としておく)

                                        /**@var \App\Models\FEnt\FEntSearchAxisData $fEntSearchAxisData */
                                        if(isset($fEntSearchAxisData->fEntSearchAxis->city)) {
                                            $locationAxisType = 'city';
                                        }

                                        if($fEntSearchAxisData->isCustomArea) {
                                            if(isset($fEntSearchAxisData->fEntSearchAxis->area)) {
                                                $locationAxisType = 'area';
                                            }
                                            if(isset($fEntSearchAxisData->fEntSearchAxis->pref)) {
                                                $locationAxisType = 'pref';
                                            }
                                        }
                                        else {
                                            if(isset($fEntSearchAxisData->fEntSearchAxis->area) && isset($fEntSearchAxisData->fEntSearchAxis->pref)) {
                                                $locationAxisType = 'area';
                                        }
                                            if(isset($fEntSearchAxisData->fEntSearchAxis->pref) && isset($fEntSearchAxisData->fEntSearchAxis->city)) {
                                                $locationAxisType = 'pref';
                                            }
                                        }
                                        @endphp

                                        @switch($locationAxisType)

                                        @case('area')
                                        <x-searchBox.searchBoxArea :areaAxis="$fEntSearchAxisData->fEntSearchAxis->area" :isCustomArea="$fEntSearchAxisData->isCustomArea" :isDispCount=true />
                                        @break

                                        @case('pref')
                                        <x-searchBox.searchBoxPref :prefAxis="$fEntSearchAxisData->fEntSearchAxis->pref" :isCustomArea="$fEntSearchAxisData->isCustomArea" :isDispCount=true />
                                        @break

                                        @case('city')
                                        <x-searchBox.searchBoxCity :cityAxis="$fEntSearchAxisData->fEntSearchAxis->city" :isCustomArea="$fEntSearchAxisData->isCustomArea" :isDispCount=true />
                                        @break

                                        @default
                                        @break
                                        @endswitch
                                        {{--エリアから選ぶ end--}}

                                        {{--職種から選ぶ start--}}
                                        @php
                                        $jobAxisType = '';
                                        //「職種から選ぶ」の検索ボックスに何の項目を表示するか(表示優先順はjobbc > job としておく)

                                        /**@var \App\Models\FEnt\FEntSearchAxisData $fEntSearchAxisData */
                                        if(isset($fEntSearchAxisData->fEntSearchAxis->job)) {
                                            $jobAxisType = 'job';
                                        }
                                        if(isset($fEntSearchAxisData->fEntSearchAxis->jobbc)) {
                                            $jobAxisType = 'jobbc';
                                        }
                                        @endphp

                                        @switch($jobAxisType)

                                        @case('jobbc')
                                        <x-searchBox.searchBoxJobGroup :jobbcAxis="$fEntSearchAxisData->fEntSearchAxis->jobbc" :isCustomJob="$fEntSearchAxisData->isCustomJob" :isDispCount=true :isFirstViewJobAxis="$isFirstViewJobAxis" />
                                        @break

                                        @case('job')
                                        <x-searchBox.searchBoxJob :jobAxis="$fEntSearchAxisData->fEntSearchAxis->job" :isCustomJob="$fEntSearchAxisData->isCustomJob" :isDispCount=true :isFirstViewJobAxis="$isFirstViewJobAxis" />
                                        @break

                                        @default
                                        @break
                                        @endswitch
                                        {{--職種から選ぶ end--}}

                                        {{--雇用形態から選ぶ end--}}
                                        @if(isset($fEntSearchAxisData->fEntSearchAxis->koy))
                                        <x-searchBox.searchBoxKoy :koyAxis="$fEntSearchAxisData->fEntSearchAxis->koy" :isDispCount=true />
                                        @endif
                                        {{--雇用形態から選ぶ end--}}



                                        <!-- モーダルエリアここから -->
{{--                                        <section id="modalArea" class="modalArea">--}}
{{--                                            <div id="modalBg" class="modalBg"></div>--}}
{{--                                            <div class="modalWrapper">--}}
{{--                                                <h2 class="modalTitle">検索詳細条件設定</h2>--}}
{{--                                                <div class="side-modal-guide">--}}
{{--                                                    <div id="modal-guide-1" class="guide-content" data-id="1">--}}
{{--                                                        <div class="modal-guide-picture area"></div>--}}
{{--                                                        <span class="ja">エリア</span>--}}
{{--                                                        <span class="en">AREA</span>--}}
{{--                                                    </div>--}}
{{--                                                    <div id="modal-guide-2" class="guide-content" data-id="2">--}}
{{--                                                        <div class="modal-guide-picture occupation"></div>--}}
{{--                                                        <span class="ja">職種</span>--}}
{{--                                                        <span class="en">OCCUPATION</span>--}}
{{--                                                    </div>--}}
{{--                                                    <div id="modal-guide-3" class="guide-content" data-id="3">--}}
{{--                                                        <div class="modal-guide-picture obsession"></div>--}}
{{--                                                        <span class="ja">こだわり</span>--}}
{{--                                                        <span class="en">OBSESSION</span>--}}
{{--                                                    </div>--}}
{{--                                                    <div id="modal-guide-4" class="guide-content" data-id="4">--}}
{{--                                                        <div class="modal-guide-picture salary"></div>--}}
{{--                                                        <span class="ja">給与</span>--}}
{{--                                                        <span class="en">SALARY</span>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}

{{--                                                <div id="modal-1" class="modalAxis">--}}
{{--                                                    <h2 class="axisTitle">エリアを選択</h2>--}}
{{--                                                    <div class="modalContents pcContent">--}}
{{--                                                        <x-searchBox.modal.modalListLocation :fEntSearchAxisData="$fEntSearchAxisData" />--}}
{{--                                                    </div>--}}
{{--                                                    <div class="modalContents spContent">--}}
{{--                                                        <x-searchBox.modal.modalListLocationSp :fEntSearchAxisData="$fEntSearchAxisData" />--}}
{{--                                                    </div>--}}
{{--                                                    <div id="closeModal" class="closeModal">--}}
{{--                                                        ×--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <div id="modal-2" class="modalAxis">--}}
{{--                                                    <h2 class="axisTitle">職種を選択</h2>--}}
{{--                                                    <div class="modalContents pcContent">--}}
{{--                                                        <x-searchBox.modal.modalListJob :fEntSearchAxisData="$fEntSearchAxisData" />--}}
{{--                                                    </div>--}}
{{--                                                    <div class="modalContents spContent">--}}
{{--                                                        <x-searchBox.modal.modalListJobSp :fEntSearchAxisData="$fEntSearchAxisData" />--}}
{{--                                                    </div>--}}
{{--                                                    <div id="closeModal" class="closeModal">--}}
{{--                                                        ×--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <div id="modal-3" class="modalAxis">--}}
{{--                                                    <h2 class="axisTitle">こだわりを選択</h2>--}}
{{--                                                    <div class="modalContents pcContent">--}}
{{--                                                        <x-searchBox.modal.modalListKodawari :fEntSearchAxisData="$fEntSearchAxisData" />--}}
{{--                                                    </div>--}}
{{--                                                    <div class="modalContents spContent">--}}
{{--                                                        <x-searchBox.modal.modalListKodawariSp :fEntSearchAxisData="$fEntSearchAxisData" />--}}
{{--                                                    </div>--}}
{{--                                                    <div id="closeModal" class="closeModal">--}}
{{--                                                        ×--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <div id="modal-4" class="modalAxis">--}}
{{--                                                    <h2 class="axisTitle">給料を選択</h2>--}}
{{--                                                    <div class="modalContents pcContent">--}}
{{--                                                        <x-searchBox.modal.modalListSalary />--}}
{{--                                                    </div>--}}
{{--                                                    <div class="modalContents spContent">--}}
{{--                                                        <x-searchBox.modal.modalListSalarySp />--}}
{{--                                                    </div>--}}
{{--                                                    <div id="closeModal" class="closeModal">--}}
{{--                                                        ×--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <div class="searchBtns">--}}
{{--                                                    <button class="reset-all"><span>すべての条件をクリア</span></button>--}}
{{--                                                    <button class="search-exec"><span>検索する</span></button>--}}
{{--                                                    <input type="hidden" id="search_url" value="{{route('search.query')}}">--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </section>--}}
                                        <!-- モーダルエリアここまで -->

                                        <div class="search-box-form">
                                            <div class="hgroup-other">
                                                <h4>フリーワード検索</h4>
                                            </div>
                                            <div class="search-box-form__inner">
                                                <label class="is-vishidden">キーワードを入力</label>
                                                <input class="search-form__search" id="topSearchWord" type="search" name="freeword" size="40" required="required" placeholder="キーワードを入力" />
                                                <input type="hidden" id="word_search_url" value="{{route('search.query')}}" />
                                                <button type="submit" value="検 索" class="searchWordBtn search-form__submit">検 索</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    @endif
@endif
