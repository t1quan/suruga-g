@props(['fEntUserApplyInfo', 'fEntApplyMasters', 'items', 'isOpen'])

<section>
    <small>▼クリックで開閉</small>
    <p class="toggleSwitchApply {{$isOpen ? 'open' : 'close'}}">キャリアシート</p>
    <table  class="body {{$isOpen ? 'open' : 'close'}}">
        <tbody>
        @foreach($items As $groupName => $list)
            @if($list && count($list)>0)
                @switch($groupName)

                    @case('changeNumber')
                    <tr>
                        <th>転職回数@if($list['required'])<i class="required">*</i>@endif</th>
                        <td>
                            <div>
                                <x-molecules.select for="changeNumber" :kbnList="$fEntApplyMasters->changeCntMst??[]" :selected="old('changeNumber', $fEntUserApplyInfo->changeJobCount ?? '')" />
                            </div>
                            <x-molecules.validation-errors :errors="$errors" for="changeNumber" />
                        </td>
                    </tr>
                    @break

                    @case('occupation')
                    <tr>
                        <th>経験職種@if($list['required'])<i class="required">*</i>@endif</th>
                        <td>
                            @foreach($list As $fieldName => $rules)
                                @switch($fieldName)

                                    @case('occupation1')
                                    <div class="multi-item">
                                        <div class="fields">
                                            <x-molecules.select for="occupation1" :groupList="$fEntApplyMasters->occupationGroupMst??[]" :selected="old('occupation1', $fEntUserApplyInfo->keiknSyksyCd1 ?? '')" />
                                            <x-molecules.validation-errors :errors="$errors" for="occupation1" />
                                        </div>
                                        <div class="fields">
                                            <x-molecules.select for="period1" :kbnList="$fEntApplyMasters->expYearMst??[]" :selected="old('period1', $fEntUserApplyInfo->keiknSyksyNensuKbn1 ?? '')" />
                                            <x-molecules.validation-errors :errors="$errors" for="period1" />
                                        </div>
                                        @if($rules['required'])<i class="required pcLayout">*</i>@endif
                                    </div>
                                    @break

                                    @case('occupation2')
                                    <div class="multi-item">
                                        <div class="fields">
                                            <x-molecules.select for="occupation2" :groupList="$fEntApplyMasters->occupationGroupMst??[]" :selected="old('occupation2', $fEntUserApplyInfo->keiknSyksyCd2 ?? '')" />
                                            <x-molecules.validation-errors :errors="$errors" for="occupation2" />
                                        </div>
                                        <div class="fields">
                                            <x-molecules.select for="period2" :kbnList="$fEntApplyMasters->expYearMst??[]" :selected="old('period2', $fEntUserApplyInfo->keiknSyksyNensuKbn2 ?? '')" />
                                            <x-molecules.validation-errors :errors="$errors" for="period2" />
                                        </div>
                                        @if($rules['required'])<i class="required pcLayout">*</i>@endif
                                    </div>
                                    @break

                                    @case('occupation3')
                                    <div class="multi-item">
                                        <div class="fields">
                                            <x-molecules.select for="occupation3" :groupList="$fEntApplyMasters->occupationGroupMst??[]" :selected="old('occupation3', $fEntUserApplyInfo->keiknSyksyCd3 ?? '')" />
                                            <x-molecules.validation-errors :errors="$errors" for="occupation3" />
                                        </div>
                                        <div class="fields">
                                            <x-molecules.select for="period3" :kbnList="$fEntApplyMasters->expYearMst??[]" :selected="old('period3', $fEntUserApplyInfo->keiknSyksyNensuKbn3 ?? '')" />
                                            <x-molecules.validation-errors :errors="$errors" for="period3" />
                                        </div>
                                        @if($rules['required'])<i class="required pcLayout">*</i>@endif
                                    </div>
                                    @break

                                    @case('occupation4')
                                    <div class="multi-item">
                                        <div class="fields">
                                            <x-molecules.select for="occupation4" :groupList="$fEntApplyMasters->occupationGroupMst??[]" :selected="old('occupation4', (int)$fEntUserApplyInfo->keiknSyksyCd4 ?? '')" />
                                            <x-molecules.validation-errors :errors="$errors" for="occupation4" />
                                        </div>
                                        <div class="fields">
                                            <x-molecules.select for="period4" :kbnList="$fEntApplyMasters->expYearMst??[]" :selected="old('period4', $fEntUserApplyInfo->keiknSyksyNensuKbn4 ?? '')" />
                                            <x-molecules.validation-errors :errors="$errors" for="period4" />
                                        </div>
                                        @if($rules['required'])<i class="required pcLayout">*</i>@endif
                                    </div>
                                    @break

                                    @case('occupation5')
                                    <div class="multi-item">
                                        <div class="fields">
                                            <x-molecules.select for="occupation5" :groupList="$fEntApplyMasters->occupationGroupMst??[]" :selected="old('occupation5', (int)$fEntUserApplyInfo->keiknSyksyCd5 ?? '')" />
                                            <x-molecules.validation-errors :errors="$errors" for="occupation5" />
                                        </div>
                                        <div class="fields">
                                            <x-molecules.select for="period5" :kbnList="$fEntApplyMasters->expYearMst??[]" :selected="old('period5', $fEntUserApplyInfo->keiknSyksyNensuKbn5 ?? '')" />
                                            <x-molecules.validation-errors :errors="$errors" for="period5" />
                                        </div>
                                        @if($rules['required'])<i class="required pcLayout">*</i>@endif
                                    </div>
                                    @break

                                    @case('period1')
                                    @case('period2')
                                    @case('period3')
                                    @case('period4')
                                    @case('period5')
                                    @default
                                    @break
                                @endswitch
                            @endforeach
                        </td>
                    </tr>
                    @break

                    @case('industry')
                    <tr>
                        <th>経験業界@if($list['required'])<i class="required">*</i>@endif</th>
                        <td>
                            @foreach($list As $fieldName => $rules)
                                @switch($fieldName)

                                    @case('industry1')
                                    <div>
                                        <x-molecules.select for="industry1" :kbnList="$fEntApplyMasters->gyokaiMst??[]" :selected="old('industry1', $fEntUserApplyInfo->keiknGyokaiCd1 ?? '')" />
                                        @if($rules['required'])<i class="required pcLayout">*</i>@endif
                                    </div>
                                    <x-molecules.validation-errors :errors="$errors" for="industry1" />
                                    @break

                                    @case('industry2')
                                    <div>
                                        <x-molecules.select for="industry2" :kbnList="$fEntApplyMasters->gyokaiMst??[]" :selected="old('industry2', $fEntUserApplyInfo->keiknGyokaiCd2 ?? '')" />
                                    </div>
                                    <x-molecules.validation-errors :errors="$errors" for="industry2" />
                                    @break

                                    @case('industry3')
                                    <div>
                                        <x-molecules.select for="industry3" :kbnList="$fEntApplyMasters->gyokaiMst??[]" :selected="old('industry3', $fEntUserApplyInfo->keiknGyokaiCd3 ?? '')" />
                                    </div>
                                    <x-molecules.validation-errors :errors="$errors" for="industry3" />
                                    @break

                                    @default
                                    @break
                                @endswitch
                            @endforeach
                        </td>
                    </tr>
                    @break

                    @case('managementExperience')
                    <tr>
                        <th>マネージメント経験@if($list['required'])<i class="required">*</i>@endif</th>
                        <td>
                            @php
                                $mngChecked = old('managementExperience', $fEntUserApplyInfo->managementExperience ?? '');
                            @endphp
                            <input type="radio" id="yes" value="1" name="managementExperience" @if($mngChecked === '1') checked @endif />
                            <label for="yes">あり</label>
                            <input type="radio" id="no" value="0" name="managementExperience" @if($mngChecked === '0') checked @endif />
                            <label for="no">なし</label>
                            <x-molecules.validation-errors :errors="$errors" for="managementExperience" />
                        </td>
                    </tr>
                    @break

                    @case('managementNumber')
                    <tr>
                        <th>マネージメント人数@if($list['required'])<i class="required">*</i>@endif</th>
                        <td>
                            <x-molecules.select for="managementNumber" :kbnList="$fEntApplyMasters->mngCntMst??[]" :selected="old('managementNumber', $fEntUserApplyInfo->numberOfManagement ?? '')" />
                            <x-molecules.validation-errors :errors="$errors" for="managementNumber" />
                        </td>
                    </tr>
                    @break

                    @case('jobHistories')
                    <x-form.syokureki :fEntUserApplyInfo="$fEntUserApplyInfo" :fEntApplyMasters="$fEntApplyMasters" />
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