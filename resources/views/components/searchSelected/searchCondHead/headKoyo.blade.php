@props(['fEntSearchAxisData','searchSelectedMasterList','criteria'])

@php
    $arrayKoyoHead = array();
    $koyoText = null;

    $koyMaster = array();

    //マスタデータの整形
    foreach($searchSelectedMasterList->koyKeitaiMst As $index => $koyMst) {
        $koyMaster[$koyMst->value] = $koyMst->name;
    }

    if($criteria->koyKeitaiCodes) {
        foreach(explode("[]", $criteria->koyKeitaiCodes) As $koyKeitaiCodesCriteria) {
            if($koyMaster[$koyKeitaiCodesCriteria]??null) {
                $arrayKoyoHead[] = $koyMaster[$koyKeitaiCodesCriteria];
            }
        }
    }

    if($arrayKoyoHead) {
        $koyoText = implode(" , ", $arrayKoyoHead);
    }
@endphp

<div class="searchCondHeadKoyo">
    <div class="searchHeadLabel">雇用形態</div>
    <div class="searchHeadContent">
        @if($koyoText)
            <div class="searchHeadKoyo">{{($koyoText)}}</div>
        @endif
    </div>
</div>