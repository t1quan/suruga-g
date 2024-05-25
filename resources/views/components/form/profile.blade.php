@props(['fEntUserApplyInfo', 'fEntApplyMasters', 'items', 'isOpen'])
@php
$cityMst = array();
/** @var \App\Models\FEnt\FEntApplyMasters $fEntApplyMasters */
if($fEntApplyMasters->cityMst){
    foreach($fEntApplyMasters->cityMst as $city){
        /** @var \App\Models\FEnt\FEntUserApplyInfo $fEntUserApplyInfo */
        /** @var \App\Models\FEnt\FEntMst $city */
        if($fEntUserApplyInfo->shikuCd == $city->value and $fEntUserApplyInfo->kenCd == $city->parent){
            $cityMst[] = $city;
        }
    }
    //validationエラー後の再表示用処理
    /** @var \App\Models\FEnt\FEntUserApplyInfo $fEntUserApplyInfo */
    if((!($fEntUserApplyInfo->kenCd)) && (!($fEntUserApplyInfo->shikuCd)) && (count($cityMst)===0)) {
        foreach($fEntApplyMasters->cityMst as $city){
            if((old('city') == $city->value) and (old('prefecture') == $city->parent)){
                $cityMst[] = $city;
            }
        }
    }
}
@endphp

<section>
    <small>▼クリックで開閉</small>
    <p class="toggleSwitchApply {{$isOpen ? 'open' : 'close'}}">プロフィール</p>
    <table  class="body {{$isOpen ? 'open' : 'close'}}">
        <tbody>
        @foreach($items As $groupName => $list)
        @if($list && count($list)>0)
            @switch($groupName)
            @case('name')
            <tr class="{{($groupName)}}">
                <th>氏名@if($list['required'])<i class="required">*</i>@endif</th>
                <td class="multi">
                @foreach($list As $fieldName => $rules)
                    @switch($fieldName)

                    @case('lastName')
                    <div class="fields name">
                        <label for="lastName">姓</label>
                        <x-molecules.input autofocus type="text" name="lastName" id="lastName" :value="old('lastName', $fEntUserApplyInfo->nameSei ?? '')" maxlength="16" placeholder="姓" />
                        <x-molecules.validation-errors :errors="$errors" for="lastName" />
                    </div>
                    @break

                    @case('firstName')
                    <div class="fields name">
                        <label for="firstName">名</label>
                        <x-molecules.input type="text" name="firstName" id="firstName" :value="old('firstName', $fEntUserApplyInfo->nameMei ?? '')" maxlength="16" placeholder="名" />
                        <x-molecules.validation-errors :errors="$errors" for="firstName" />
                    </div>
                    @break

                    @default
                    @break
                    @endswitch

                @endforeach
                </td>
            </tr>
            @break

            @case('nameRuby')
            <tr class="{{($groupName)}}">
                <th>氏名（カナ）@if($list['required'])<i class="required">*</i>@endif</th>
                <td class="multi">
                @foreach($list As $fieldName => $rules)

                    @switch($fieldName)

                    @case('lastKana')
                    <div class="fields name">
                        <label for="lastKana">セイ</label>
                        <x-molecules.input type="text" name="lastKana" id="lastKana" :value="old('lastKana', $fEntUserApplyInfo->nameSeiKn ?? '')" maxlength="32" placeholder="セイ" />
                        <x-molecules.validation-errors :errors="$errors" for="lastKana" />
                    </div>
                    @break

                    @case('firstKana')
                    <div class="fields name">
                        <label for="firstKana">メイ</label>
                        <x-molecules.input type="text" name="firstKana" id="firstKana" :value="old('firstKana', $fEntUserApplyInfo->nameMeiKn ?? '')" maxlength="32" placeholder="メイ" />
                        <x-molecules.validation-errors :errors="$errors" for="firstKana" />
                    </div>
                    @break

                    @default
                    @break
                    @endswitch

                @endforeach
                </td>
            </tr>
            @break

            @case('birthday')
            <tr class="{{($groupName)}}">
                <th>生年月日@if($list['required'])<i class="required">*</i>@endif</th>
                <td class="multi">
                @foreach($list As $fieldName => $rules)
                    @switch($fieldName)

                    @case('dobYear')
                    <div class="fields">
                        <x-molecules.select for="dobYear" :list="$fEntApplyMasters->yearMst??[]" :selected="old('dobYear', $fEntUserApplyInfo->birthday ? $fEntUserApplyInfo->birthday->format('Y') : '')" />
                        <label for="dobYear">年</label>
                        <x-molecules.validation-errors :errors="$errors" for="dobYear" />
                    </div>
                    @break

                    @case('dobMonth')
                    <div class="fields">
                        <x-molecules.select for="dobMonth" :list="$fEntApplyMasters->monthMst??[]" :selected="old('dobMonth', $fEntUserApplyInfo->birthday ? $fEntUserApplyInfo->birthday->format('m') : '')" />
                        <label for="dobMonth">月</label>
                        <x-molecules.validation-errors :errors="$errors" for="dobMonth" />
                    </div>
                    @break

                    @case('dobDay')
                    <div class="fields">
                        <x-molecules.select for="dobDay" :list="$fEntApplyMasters->dayMst??[]" :selected="old('dobDay', $fEntUserApplyInfo->birthday ? $fEntUserApplyInfo->birthday->format('d') : '')" />
                        <label for="dobDay">日</label>
                        <x-molecules.validation-errors :errors="$errors" for="dobDay" />
                    </div>
                    @break

                    @default
                    @break

                    @endswitch

                @endforeach
                </td>
            </tr>
            @break

            @case('gender')
            <tr class="{{($groupName)}}">
                <th>性別@if($list['required'])<i class="required">*</i>@endif</th>
                <td>
                @foreach($list As $fieldName => $rules)

                    @switch($fieldName)

                    @case('gender')
                    <div class="fields">
                        <x-molecules.select for="gender" :kbnList="$fEntApplyMasters->genderMst??[]" :selected="old('gender', $fEntUserApplyInfo->gender ?? '')" />
                        <x-molecules.validation-errors :errors="$errors" for="gender" />
                    </div>
                    @break

                    @default
                    @break

                    @endswitch

                @endforeach
                </td>
            </tr>
            @break

            @case('address')
            <tr class="{{($groupName)}}">
                <th>現在の住所@if($list['required'])<i class="required">*</i>@endif</th>
                <td>
                    <dl>
                    @foreach($list As $fieldName => $rules)

                        @switch($fieldName)

                        @case('zipCode')
                        <div class="multi-item">
                            <dt>
                                <label for="zipCode">郵便番号</label>
                            </dt>
                            <dd>
                                <div class="fields address">
                                    <x-molecules.input type="text" id="zipCode" name="zipCode" maxlength="7" placeholder="例）1234567" :value="old('zipCode', $fEntUserApplyInfo->zipCd ?? '')" class="w-40" />
                                    <x-molecules.validation-errors :errors="$errors" for="zipCode" />
                                    <i class="indicatorZip spLayout">住所検索</i>
                                </div>
                            </dd>
                            @if($rules['required'])<i class="required pcLayout">*</i>@endif
                            <div>
                                <i class="indicatorZip pcLayout"><span>&raquo;</span>郵便番号から住所を検索</i>
                            </div>
                        </div>
                        @break

                        @case('prefecture')
                        <div class="multi-item">
                            <dt>
                                <label for="prefecture">都道府県</label>
                            </dt>
                            <dd>
                                <div class="fields address">
                                    <x-molecules.select for="prefecture" :kbnList="$fEntApplyMasters->prefMst??[]" :selected="old('prefecture', $fEntUserApplyInfo->kenCd ?? '')" />
                                    <x-molecules.validation-errors :errors="$errors" for="prefecture" />
                                </div>
                            </dd>
                            @if($rules['required'])<i class="required pcLayout">*</i>@endif
                        </div>
                        @break

                        @case('city')
                        <div class="multi-item">
                            <dt>
                                <label for="city">市区町村</label>
                            </dt>
                            <dd>
                                <div class="fields address">
                                    <x-molecules.select for="city" :kbnList="$cityMst??[]" :selected="old('city', $fEntUserApplyInfo->shikuCd ?? '')" />
                                    <x-molecules.validation-errors :errors="$errors" for="city" />
                                </div>
                            </dd>
                            @if($rules['required'])<i class="required pcLayout">*</i>@endif
                        </div>
                        @break

                        @case('street')
                        <div class="multi-item">
                            <dt>
                                <label for="street"> 以降の住所</label>
                            </dt>
                            <dd>
                                <div class="fields address">
                                    <x-molecules.input type="text" id="street" name="street" :value="old('street', $fEntUserApplyInfo->otherAddr ?? '')" />
                                    <x-molecules.validation-errors :errors="$errors" for="street" />
                                </div>
                            </dd>
                            @if($rules['required'])<i class="required pcLayout">*</i>@endif
                        </div>
                        @break

                        @default
                        @break

                        @endswitch

                    @endforeach
                    </dl>
                </td>
            </tr>
            @break

            @case('telNumber')
            <tr class="{{($groupName)}}">
                <th>電話番号@if($list['required'])<i class="required">*</i>@endif</th>
                <td>
                @foreach($list As $fieldName => $rules)

                    @switch($fieldName)

                    @case('telNumber')
                    <div class="fields">
                        <x-molecules.input type="tel" name="telNumber" id="telNumber" class="tel01" :value="old('telNumber', $fEntUserApplyInfo->telNumber ?? '')" maxlength="13" />
                        <x-molecules.validation-errors :errors="$errors" for="telNumber" />
                    </div>
                    @break

                    @default
                    @break

                    @endswitch

                @endforeach
                </td>
            </tr>
            @break

            @case('mailAddress')
            <tr class="{{($groupName)}}">
                <th>メールアドレス@if($list['required'])<i class="required">*</i>@endif</th>
                <td>
                @foreach($list As $fieldName => $rules)

                    @switch($fieldName)

                    @case('mailAddress')
                    <div class="fields">
                        <x-molecules.input type="email" name="mailAddress" id="mailAddress" class="email01" :value="old('mailAddress', $fEntUserApplyInfo->mailAddress ?? '')" />
                        <x-molecules.validation-errors :errors="$errors" for="mailAddress" />
                    </div>
                    @break

                    @default
                    @break

                    @endswitch

                @endforeach
                </td>
            </tr>
            @break

            @case('currentOccupation')
            <tr class="{{($groupName)}}">
                <th>現在の職業@if($list['required'])<i class="required">*</i>@endif</th>
                <td>
                @foreach($list As $fieldName => $rules)

                    @switch($fieldName)

                    @case('currentOccupation')
                    <div class="fields">
                        <x-molecules.select for="currentOccupation" :kbnList="$fEntApplyMasters->occupationMst??[]" :selected="old('currentOccupation', $fEntUserApplyInfo->currentSykgyKbn ?? '')" />
                        <x-molecules.validation-errors :errors="$errors" for="currentOccupation" />
                    </div>
                    @break

                    @default
                    @break

                    @endswitch

                @endforeach
                </td>
            </tr>
            @break

            @default

            <x-form.custom :fEntUserApplyInfo="$fEntUserApplyInfo" :groupName="$groupName" :list="$list" />

            @break

            @endswitch
        @endif
        @endforeach
        </tbody>
    </table>
</section>