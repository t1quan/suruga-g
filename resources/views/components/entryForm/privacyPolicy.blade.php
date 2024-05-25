@props(['agreeId', 'fEntJobDetail', 'fEntConfig'])

@php
$agreeLabel = "個人情報の取り扱いに同意する";
$mode = 'apply';
@endphp

<aside class="applyBtns">
    <div class="rule_kojin_field">
    @if(isset($fEntConfig->frontendSettings['policy']['isSetUrl']))
        @if(!$fEntConfig->frontendSettings['policy']['isSetUrl'] && isset($fEntConfig->frontendSettings['policy']['text']))
            <div class="v_input_field">個人情報の取扱いについて<br>
                <textarea class="privacy_text" rows="8" cols="40" readonly="readonly">{{($fEntConfig->frontendSettings['policy']['text'])}}</textarea>
            </div>
        @endif
        <span class="sty_checkbox">
            <label>
                <x-molecules.input type="checkbox" name="{{($agreeId)}}" :value="$agreeLabel" id="{{($agreeId)}}" />
                <span class="checkbox-label agree">{{$agreeLabel}}</span>
            </label>
            @if($fEntConfig->frontendSettings['policy']['isSetUrl'] && isset($fEntConfig->frontendSettings['policy']['url']))
                <a class="anc_kojin_text" href="{{($fEntConfig->frontendSettings['policy']['url'])}}" target="_blank">個人情報の取り扱いについて</a>
            @endif
        </span>

    @else
        @php
            $corpIndex = 0;
            /** @var $fEntConfig */
            /** @var $fEntJobDetail */
            foreach($fEntConfig->frontendSettings['arrayCorpCd'] As $index => $corpCd) {
                if($corpCd === $fEntJobDetail->corpCd) {
                    $corpIndex = $index;
                    break;
                }
            }
        @endphp
        <div class="v_input_field">個人情報の取扱いについて<br>
        <textarea class="privacy_text" rows="8" cols="40" readonly="readonly">
【プライバシーポリシー】
{{($fEntConfig->corporations[$corpIndex]['corpFullName'])}}は、応募いただいた方の氏名や生年月日、住所、メールアドレスなど、特定の個人を識別できる情報（以下｢個人情報｣といいます）を適切に取り扱い、保護することが企業の責務であると認識し、次の取り組みを実施します。
1.個人情報の利用目的
個人情報は、商品や有用な情報のお届け、サービスの提供、その他正当な目的のためにのみ利用します。
2.個人情報の取得
個人情報は適正な方法で取得し、その利用目的を通知・公表します。
3.個人情報の適正管理
個人情報の紛失、破壊、改ざん、漏えいおよび個人情報への不正アクセス等の防止に努めます。
4.第三者提供の制限
個人情報は、法令で定める場合を除き、本人の承諾なしに第三者へ開示・提供しません。
5.委託先の管理
個人情報の処理を外部へ委託する場合は、委託先と個人情報保護に関する契約を締結し、適切な管理をします。
6.個人情報の訂正・追加・削除
個人情報について、本人から訂正、追加または削除の申し出があった場合は、速やかに対応し、必要な措置をとります。
7.教育・啓発
個人情報保護責任者を各社ごとに置き、従事者に対する教育と啓発を継続的に実施します。
8.法令遵守
個人情報の取り扱いにあたっては、個人情報保護に関する関係法令等を遵守するとともに、この基本方針を適宜見直し、改善を図っていきます。
@if(isset($fEntConfig->corporations[$corpIndex]))
【お問い合わせ】
当社の個人情報の取扱に関するお問い合せは下記までご連絡ください。

@if(isset($fEntConfig->corporations[$corpIndex]['corpFullName']))
    {{($fEntConfig->corporations[$corpIndex]['corpFullName'])}}
@endif
@if(isset($fEntConfig->corporations[$corpIndex]['zip']))
    {{($fEntConfig->corporations[$corpIndex]['zip'])}}
@endif
@if(isset($fEntConfig->corporations[$corpIndex]['address']))
    {{($fEntConfig->corporations[$corpIndex]['address'])}}
@endif
@if(isset($fEntConfig->corporations[$corpIndex]['tel']))
    TEL：{{($fEntConfig->corporations[$corpIndex]['tel'])}}
@endif
@if(isset($fEntConfig->corporations[$corpIndex]['fax']))
                    FAX：{{($fEntConfig->corporations[$corpIndex]['fax'])}}@endif</textarea></div>
@endif

    <span class="sty_checkbox">
        <label>
            <x-molecules.input type="checkbox" name="{{($agreeId)}}" :value="$agreeLabel" id="{{($agreeId)}}" />
            <span class="checkbox-label agree">{{$agreeLabel}}</span>
        </label>
    </span>

    @endif

    </div>

    <button class="confirmApply" type="submit" value="" disabled>内容を確認する</button>
</aside>