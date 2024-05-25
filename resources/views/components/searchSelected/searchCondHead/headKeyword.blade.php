@props(['fEntSearchAxisData','criteria'])

@php
    $arrayKeywordHead = array();
    $keywordText = '';

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

        $arrayKeywordHead = array_diff($arrayCriteriaKeyword, $arrayCustomJobKeyword);

    }


    if($arrayKeywordHead) {
        foreach($arrayKeywordHead As $keyword) {
            $keywordText .= "「" . $keyword . "」";
        }
    }
@endphp

<div class="searchCondHeadKeyword">
    <div class="searchHeadLabel">キーワード</div>
    <div class="searchHeadContent">
        {{($keywordText)}}
    </div>
</div>