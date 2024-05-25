@props(['fEntSearchAxisData','criteria'])

@php

    $arrayKeyword = array();
    $textKeyword = '';

    if($criteria->keyword) {

        $arrayCriteriaKeyword = explode(" ", $criteria->keyword);

        $arrayCustomJobKeyword = array();

        if($fEntSearchAxisData->isCustomJob) {
            $axisType = null;

            if($fEntSearchAxisData->fEntSearchAxis->job) {
                $axisType = 'job';
            }
            if($fEntSearchAxisData->fEntSearchAxis->jobbc) {
                $axisType = 'jobbc';
            }

            if($axisType) {
                foreach($fEntSearchAxisData->fEntSearchAxis->$axisType As $index => $customAxis) {
                    if($customAxis->children??null) {
                        foreach($customAxis->children As $children) {
                            if((($children->type??null) == 'kw') && ($children->value??null)) {
                                $arrayCustomJobKeyword[] = $children->value;
                            }
                        }
                    }
                }
            }
        }

        $arrayKeyword = array_diff($arrayCriteriaKeyword, $arrayCustomJobKeyword);
    }

    if($arrayKeyword) {
        $textKeyword = implode(" ", $arrayKeyword);
    }

@endphp

<div class="searchCondListKeyword">
    <div class="formHead">キーワード</div>
    <div class="formtBody">
        <ul>
            <li class="parent">
                <ul>
                    <li class="child">
                        <input type="text" class="searchInput" value="{{($textKeyword)}}" name="kw" id="sb-kw" placeholder="キーワードを入力">
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>