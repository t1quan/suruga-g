@props(['fEntUserApplyInfo', 'fEntApplyMasters', 'items', 'isOpen'])

<section>
    <small>▼クリックで開閉</small>
    <p class="toggleSwitchApply {{$isOpen ? 'open' : 'close'}}">スキルシート</p>
    <table class="body {{$isOpen ? 'open' : 'close'}}">
        <tbody>
        @foreach($items As $groupName => $list)
            @if($list && count($list)>0)
            @switch($groupName)
            @case('language')
            <tr class="language">
                <th>語学@if($list['required'])<i class="required">*</i>@endif</th>
                <td>
                    <dl>
                    @foreach($list As $fieldName => $rules)
                    @switch($fieldName)

                        @case('englishConversation')
                        <div class="multi-item">
                            <dt>
                                <label for="englishConversation">英語会話</label>
                            </dt>
                            <dd>
                                <div class="fields">
                                    <x-molecules.select for="englishConversation" :kbnList="$fEntApplyMasters->kaiwaLvMst??[]" :selected="old('englishConversation', $fEntUserApplyInfo->eigoKaiwaLevelKbn ?? '')" />
                                    <x-molecules.validation-errors :errors="$errors" for="englishConversation" />
                                </div>
                            </dd>
                            @if($rules['required'])<i class="required pcLayout">*</i>@endif
                        </div>
                        @break

                        @case('businessEnglish')
                        <div class="multi-item">
                            <dt>
                                <label for="businessEnglish">英語業務</label>
                            </dt>
                            <dd>
                                <div class="fields">
                                    <x-molecules.select for="businessEnglish" :kbnList="$fEntApplyMasters->gyomLvMst??[]" :selected="old('businessEnglish', $fEntUserApplyInfo->eigoGyomLevelKbn ?? '')" />
                                    <x-molecules.validation-errors :errors="$errors" for="businessEnglish" />
                                </div>
                            </dd>
                            @if($rules['required'])<i class="required pcLayout">*</i>@endif
                        </div>
                        @break

                        @case('toeicScore')
                        <div class="multi-item">
                            <dt>
                                <label for="toeicScore">TOEIC</label>
                            </dt>
                            <dd>
                                <div class="fields">
                                    <x-molecules.input type="number" name="toeicScore" id="toeicScore" maxlength="3" :value="old('toeicScore', $fEntUserApplyInfo->toeic ?? '')" />
                                    <span>点</span>
                                    <x-molecules.validation-errors :errors="$errors" for="toeicScore" />
                                </div>
                            </dd>
                            @if($rules['required'])<i class="required pcLayout">*</i>@endif
                        </div>
                        @break

                        @case('toeflScore')
                        <div class="multi-item">
                            <dt>
                                <label for="toeflScore">TOEFL</label>
                            </dt>
                            <dd>
                                <div class="fields">
                                    <x-molecules.input type="number" name="toeflScore" id="toeflScore" maxlength="3" :value="old('toeflScore', $fEntUserApplyInfo->toefl ?? '')" />
                                    <span>点</span>
                                    <x-molecules.validation-errors :errors="$errors" for="toeflScore" />
                                </div>
                            </dd>
                            @if($rules['required'])<i class="required pcLayout">*</i>@endif
                        </div>
                        @break

                        @case('stepScore')
                        <div class="multi-item">
                            <dt>
                                <label for="stepScore">英検</label>
                            </dt>
                            <dd>
                                <div class="fields">
                                    <x-molecules.select for="stepScore" :kbnList="$fEntApplyMasters->eikenRankMst??[]" :selected="old('stepScore', $fEntUserApplyInfo->eikenKbn ?? '')" />
                                    <x-molecules.validation-errors :errors="$errors" for="stepScore" />
                                </div>
                            </dd>
                            @if($rules['required'])<i class="required pcLayout">*</i>@endif
                        </div>
                        @break

                        @case('otherLanguage')
                        <div class="multi-item">
                            <dt>
                                <label for="otherLanguage">その他言語</label>
                            </dt>
                            <dd>
                                <div class="fields">
                                    <x-molecules.select for="otherLanguage" :kbnList="$fEntApplyMasters->langMst??[]" :selected="old('otherLanguage', $fEntUserApplyInfo->etcLanguageKbn ?? '')" />
                                    <x-molecules.validation-errors :errors="$errors" for="otherLanguage" />
                                </div>
                            </dd>
                            @if($rules['required'])<i class="required pcLayout">*</i>@endif
                        </div>
                        @break

                        @case('otherConversation')
                        <div class="multi-item">
                            <dt>
                                <label for="otherConversation">その他会話</label>
                            </dt>
                            <dd>
                                <div class="fields">
                                    <x-molecules.select for="otherConversation" :kbnList="$fEntApplyMasters->kaiwaLvMst??[]" :selected="old('otherConversation', $fEntUserApplyInfo->etcLanguageKaiwaLevelKbn ?? '')" />
                                    <x-molecules.validation-errors :errors="$errors" for="otherConversation" />
                                </div>
                            </dd>
                            @if($rules['required'])<i class="required pcLayout">*</i>@endif
                        </div>
                        @break

                        @case('otherBusiness')
                        <div class="multi-item">
                            <dt>
                                <label for="otherBusiness">その他業務</label>
                            </dt>
                            <dd>
                                <div class="fields">
                                    <x-molecules.select for="otherBusiness" :kbnList="$fEntApplyMasters->gyomLvMst??[]" :selected="old('otherBusiness', $fEntUserApplyInfo->etcLanguageGyomLevelKbn ?? '')" />
                                    <x-molecules.validation-errors :errors="$errors" for="otherBusiness" />
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

            @case('pcSkill')
            <tr class="pcSkill">
                <th>PCスキル@if($list['required'])<i class="required">*</i>@endif</th>
                <td>
                    <dl>
                    @foreach($list As $fieldName => $rules)
                    @switch($fieldName)

                        @case('wordSkill')
                        <div class="multi-item">
                            <dt>
                                <label for="wordSkill">Word</label>
                            </dt>
                            <dd>
                                <div class="fields">
                                    <x-molecules.select for="wordSkill" :kbnList="$fEntApplyMasters->skillRankMst??[]" :selected="old('wordSkill', $fEntUserApplyInfo->wordLevelKbn ?? '')" />
                                    <x-molecules.validation-errors :errors="$errors" for="wordSkill" />
                                </div>
                            </dd>
                            @if($rules['required'])<i class="required pcLayout">*</i>@endif
                        </div>
                        @break

                        @case('excelSkill')
                        <div class="multi-item">
                            <dt>
                                <label for="excelSkill">Excel</label>
                            </dt>
                            <dd>
                                <div class="fields">
                                    <x-molecules.select for="excelSkill" :kbnList="$fEntApplyMasters->skillRankMst??[]" :selected="old('excelSkill', $fEntUserApplyInfo->excelLevelKbn ?? '')" />
                                    <x-molecules.validation-errors :errors="$errors" for="excelSkill" />
                                </div>
                            </dd>
                            @if($rules['required'])<i class="required pcLayout">*</i>@endif
                        </div>
                        @break

                        @case('accessSkill')
                        <div class="multi-item">
                            <dt>
                                <label for="accessSkill">Access</label>
                            </dt>
                            <dd>
                                <div class="fields">
                                    <x-molecules.select for="accessSkill" :kbnList="$fEntApplyMasters->skillRankMst??[]" :selected="old('accessSkill', $fEntUserApplyInfo->accessLevelKbn ?? '')" />
                                    <x-molecules.validation-errors :errors="$errors" for="accessSkill" />
                                </div>
                            </dd>
                            @if($rules['required'])<i class="required pcLayout">*</i>@endif
                        </div>
                        @break

                        @case('powerpointSkill')
                        <div class="multi-item">
                            <dt>
                                <label for="powerpointSkill">PowerPoint</label>
                            </dt>
                            <dd>
                                <div class="fields">
                                    <x-molecules.select for="powerpointSkill" :kbnList="$fEntApplyMasters->skillRankMst??[]" :selected="old('powerpointSkill', $fEntUserApplyInfo->powerpointLevelKbn ?? '')" />
                                    <x-molecules.validation-errors :errors="$errors" for="powerpointSkill" />
                                </div>
                            </dd>
                            @if($rules['required'])<i class="required pcLayout">*</i>@endif
                        </div>
                        @break

                        @case('webSkill')
                        <div class="multi-item">
                            <dt>
                                <label for="webSkill">WEB関連</label>
                            </dt>
                            <dd>
                                <div class="fields">
                                    <x-molecules.select for="webSkill" :kbnList="$fEntApplyMasters->skillRankMst??[]" :selected="old('webSkill', $fEntUserApplyInfo->webKnrnLevelKbn ?? '')" />
                                    <x-molecules.validation-errors :errors="$errors" for="webSkill" />
                                </div>
                            </dd>
                            @if($rules['required'])<i class="required pcLayout">*</i>@endif
                        </div>
                        @break

                        @case('otherPCSkill')
                        <dt>
                            <label for="otherPCSkill">その他PCスキル</label>
                            @if($rules['required'])<i class="required pcLayout">*</i>@endif
                        </dt>
                        <dd>
                            <textarea name="otherPCSkill" id="otherPCSkill" placeholder="">{{old('otherPCSkill', $fEntUserApplyInfo->etcPcSkill ?? '')}}</textarea>
                            <small>最大1000文字まで</small>
                            <x-molecules.validation-errors :errors="$errors" for="otherPCSkill" />
                        </dd>
                        @break

                        @default
                        @break
                    @endswitch
                    @endforeach
                    </dl>
                </td>
            </tr>
            @break

            @case('qualification')
            <tr>
                <th>資格@if($list['required'])<i class="required">*</i>@endif</th>
                <td>
                @foreach($list As $fieldName => $rules)
                @switch($fieldName)
                    @case('qualification')
                    <textarea name="qualification" id="qualification" placeholder="">{{old('qualification', $fEntUserApplyInfo->sikak ?? '')}}</textarea>
                    <small>最大1000文字まで</small>
                    <x-molecules.validation-errors :errors="$errors" for="qualification" />
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