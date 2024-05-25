@props(['fEntUserApplyInfo', 'fEntApplyMasters', 'items', 'isOpen'])

<section>
    <small>▼クリックで開閉</small>
    <p class="toggleSwitchApply {{$isOpen ? 'open' : 'close'}}">その他任意項目</p>
    <table  class="body {{$isOpen ? 'open' : 'close'}}">
        <tbody>
        @foreach($items As $groupName => $list)
            @if($list && count($list)>0)
                @switch($groupName)

                    @case('maritalStatus')
                    <tr>
                        <th>結婚@if($list['required'])<i class="required">*</i>@endif</th>
                        <td>
                            <x-molecules.select for="maritalStatus" :kbnList="$fEntApplyMasters->maritalMst??[]" :selected="old('maritalStatus', $fEntUserApplyInfo->marriage ?? '')" />
                            <x-molecules.validation-errors :errors="$errors" for="maritalStatus" />
                        </td>
                    </tr>
                    @break

                    @case('currentAddress')
                    <tr>
                        <th>現在の住所@if($list['required'])<i class="required">*</i>@endif</th>
                        <td>
                            <dl>
                                @foreach($list As $fieldName => $rules)
                                    @switch($fieldName)

                                        @case('station')
                                        <div class="multi-item">
                                            <dt>
                                                <label for="station">最寄駅</label>
                                            </dt>
                                            <dd>
                                                <div class="fields">
                                                    <x-molecules.input type="text" name="station" id="station" :value="old('station', $fEntUserApplyInfo->moyoriEki ?? '')" />
                                                    <x-molecules.validation-errors :errors="$errors" for="station" />
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

                    @case('educationBackground')
                    <tr class="educationalBackground">
                        <th>最終学歴@if($list['required'])<i class="required">*</i>@endif</th>
                        <td>
                            <dl>
                                @foreach($list As $fieldName => $rules)
                                    @switch($fieldName)

                                        @case('educationLevel')
                                        <div class="multi-item">
                                            <dt>
                                                <label for="educationLevel">学校区分</label>
                                            </dt>
                                            <dd>
                                                <div class="fields">
                                                    <x-molecules.select for="educationLevel" :kbnList="$fEntApplyMasters->schoolMst??[]" :selected="old('educationLevel', $fEntUserApplyInfo->gakkoKbn ?? '')" />
                                                    <x-molecules.validation-errors :errors="$errors" for="educationLevel" />
                                                </div>
                                            </dd>
                                            @if($rules['required'])<i class="required pcLayout">*</i>@endif
                                        </div>
                                        @break

                                        @case('graduationYear')
                                        <div class="multi-item">
                                            <dt>
                                                <label for="graduationYear">卒業年度</label>
                                            </dt>
                                            <dd>
                                                <div class="fields">
                                                    <x-molecules.select for="graduationYear" :list="$fEntApplyMasters->yearMst??[]" :selected="old('graduationYear', $fEntUserApplyInfo->sotsugyoYear ?? '')" />
                                                    <x-molecules.validation-errors :errors="$errors" for="graduationYear" />
                                                </div>
                                            </dd>
                                            @if($rules['required'])<i class="required pcLayout">*</i>@endif
                                        </div>
                                        @break

                                        @case('graduationStatus')
                                        <div class="multi-item">
                                            <dt>
                                                <label for="graduationStatus">状態</label>
                                            </dt>
                                            <dd>
                                                <div class="fields">
                                                    <x-molecules.select for="graduationStatus" :kbnList="$fEntApplyMasters->educationMst??[]" :selected="old('graduationStatus', $fEntUserApplyInfo->gakurekiKbn ?? '')" />
                                                    <x-molecules.validation-errors :errors="$errors" for="graduationStatus" />
                                                </div>
                                            </dd>
                                            @if($rules['required'])<i class="required pcLayout">*</i>@endif
                                        </div>
                                        @break

                                        @case('schoolName')
                                        <div class="multi-item">
                                            <dt>
                                                <label for="schoolName">学校名</label>
                                            </dt>
                                            <dd>
                                                <div class="fields">
                                                    <x-molecules.input type="text" name="schoolName" id="schoolName" :value="old('schoolName', $fEntUserApplyInfo->gakkoMei ?? '')" />
                                                    <x-molecules.validation-errors :errors="$errors" for="schoolName" />
                                                </div>
                                            </dd>
                                            @if($rules['required'])<i class="required pcLayout">*</i>@endif
                                        </div>
                                        @break

                                        @case('departmentName')
                                        <div class="multi-item">
                                            <dt>
                                                <label for="departmentName">学部／学科名</label>
                                            </dt>
                                            <dd>
                                                <div class="fields">
                                                    <x-molecules.input type="text" name="departmentName" id="departmentName" :value="old('departmentName', $fEntUserApplyInfo->gakubuGakkaMei ?? '')" />
                                                    <x-molecules.validation-errors :errors="$errors" for="departmentName" />
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

                    @default

                    <x-form.custom :fEntUserApplyInfo="$fEntUserApplyInfo" :groupName="$groupName" :list="$list" />

                    @break
                @endswitch
            @endif
        @endforeach
        </tbody>
    </table>
</section>