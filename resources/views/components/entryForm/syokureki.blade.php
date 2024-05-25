@php
    // 一つでも値が取得できればデータが存在するものとして初期表示する
    $open = 1;
    /** @var \App\Models\FEnt\FEntUserApplyInfo $fEntUserApplyInfo */
    if($fEntUserApplyInfo){
        $names = ['corpMei','kinmStrYymm','kinmEndYymm','koyKeitaiKbn','syokumuNaiyo'];
        $keys = ['companyName','startYear','startMonth','endYear','endMonth','employmentStatus','jobDescription'];
        $alphabets = ['A','B','C','D','E',];
        $openList = [true,false,false,false,false];

        for($i = 1;$i <= 5; $i++){
            for($j = 0;$j < count($names); $j++){
                $fieldName = $names[$j] . $i; // corpMei1
                if($fEntUserApplyInfo->$fieldName){
                    $open = $i;
                    $openList[$i - 1] = true;
                    break;
                }
            }
            //validationエラー後の再表示用処理
            if(!$openList[$i - 1]) {
                for($j = 0;$j < count($keys); $j++) {
                    $keyName = $keys[$j] . $alphabets[$i - 1];
                    if(old($keyName)) {
                        $open = $i;
                        $openList[$i - 1] = true;
                        break;
                    }
                }
            }
        }
    }
@endphp

<tr class="workExperience">
    <th>職務経歴<br><span class="notice">（最大5件まで）</span></th>
    <td>
        <input type="hidden" id="open" value="{{$open}}">
        <div class="workExperienceBody">
            <div id="winA" class="{{$openList[0] ? 'open' : 'close'}}">
                <small id="delA" class="remove">
                    <a href="javascript:void(0)" style="display: none;">‐ 職務経歴を削除</a>
                </small>
                <dl>
                    <dt>
                        <label for="companyNameA">会社名</label>
                    </dt>
                    <dd>
                        <x-molecules.input type="text" id="companyNameA" name="companyNameA" :value="old('companyNameA', $fEntUserApplyInfo->corpMei1 ?? '')" />
                        <x-molecules.validation-errors :errors="$errors" for="companyNameA" />
                    </dd>
                    <dt>
                        <label for="startDateA">勤務開始年月</label>
                    </dt>
                    <dd>
                        <div class="multi-item">
                            <div class="fields">
                                <x-molecules.select for="startYearA" :list="$fEntApplyMasters->yearMst??[]" :selected="old('startYearA', $fEntUserApplyInfo->kinmStrYymm1 ? (int)$fEntUserApplyInfo->kinmStrYymm1->format('Y')??'' : '')" />
                                <label for="startYearA">年</label>
                                <x-molecules.validation-errors :errors="$errors" for="startYearA" />
                            </div>
                            <div class="fields">
                                <x-molecules.select for="startMonthA" :list="$fEntApplyMasters->monthMst??[]" :selected="old('startMonthA', $fEntUserApplyInfo->kinmStrYymm1 ? (int)$fEntUserApplyInfo->kinmStrYymm1->format('m')??'' : '')" />
                                <label for="startMonthA">月</label>
                                <x-molecules.validation-errors :errors="$errors" for="startMonthA" />
                            </div>
                        </div>
                    </dd>
                    <dt>
                        <label for="endDateA">勤務終了年月</label>
                    </dt>
                    <dd>
                        <div class="multi-item">
                            <div class="fields">
                                <x-molecules.select for="endYearA" :list="$fEntApplyMasters->yearMst??[]" :selected="old('endYearA', $fEntUserApplyInfo->kinmEndYymm1 ? (int)$fEntUserApplyInfo->kinmEndYymm1->format('Y')??'' : '')" />
                                <label for="endYearA">年</label>
                                <x-molecules.validation-errors :errors="$errors" for="endYearA" />
                            </div>
                            <div class="fields">
                                <x-molecules.select for="endMonthA" :list="$fEntApplyMasters->monthMst??[]" :selected="old('endMonthA', $fEntUserApplyInfo->kinmEndYymm1 ? (int)$fEntUserApplyInfo->kinmEndYymm1->format('m')??'' : '')" />
                                <label for="endMonthA">月</label>
                                <x-molecules.validation-errors :errors="$errors" for="endMonthA" />
                            </div>
                        </div>
                    </dd>
                    <dt>
                        <label for="employmentStatusA">雇用形態</label>
                    </dt>
                    <dd>
                        <x-molecules.select for="employmentStatusA" :kbnList="$fEntApplyMasters->koyKeitaiMst" :selected="old('employmentStatusA', (int)$fEntUserApplyInfo->koyKeitaiKbn1 ?? '')" />
                        <x-molecules.validation-errors :errors="$errors" for="employmentStatusA" />
                    </dd>
                    <dt>
                        <label for="jobDescriptionA">職務内容</label>
                    </dt>
                    <dd>
                        <textarea name="jobDescriptionA" id="jobDescriptionA">{{old('jobDescriptionA', $fEntUserApplyInfo->syokumuNaiyo1 ?? '')}}</textarea>
                        <small>最大5000文字まで</small>
                        <x-molecules.validation-errors :errors="$errors" for="jobDescriptionA" />
                    </dd>
                </dl>
            </div>
        </div>
        <div class="workExperienceBody">
            <div id="winB" class="{{$openList[1] ? 'open' : 'close'}}">
                <small id="delB" class="remove">
                    <a href="javascript:void(0)">‐ 職務経歴を削除</a>
                </small>
                <dl>
                    <dt>
                        <label for="companyNameB">会社名</label>
                    </dt>
                    <dd>
                        <x-molecules.input type="text" id="companyNameB" name="companyNameB" :value="old('companyNameB', $fEntUserApplyInfo->corpMei2 ?? '')" />
                        <x-molecules.validation-errors :errors="$errors" for="companyNameB" />
                    </dd>
                    <dt>
                        <label for="startDateB">勤務開始年月</label>
                    </dt>
                    <dd>
                        <div class="multi-item">
                            <div class="fields">
                                <x-molecules.select for="startYearB" :list="$fEntApplyMasters->yearMst??[]" :selected="old('startYearB', $fEntUserApplyInfo->kinmStrYymm2 ? (int)$fEntUserApplyInfo->kinmStrYymm2->format('Y')??'' : '')" />
                                <label for="startYearB">年</label>
                                <x-molecules.validation-errors :errors="$errors" for="startYearB" />
                            </div>
                            <div class="fields">
                                <x-molecules.select for="startMonthB" :list="$fEntApplyMasters->monthMst??[]" :selected="old('startMonthB', $fEntUserApplyInfo->kinmStrYymm2 ? (int)$fEntUserApplyInfo->kinmStrYymm2->format('m')??'' : '')" />
                                <label for="startMonthB">月</label>
                                <x-molecules.validation-errors :errors="$errors" for="startMonthB" />
                            </div>
                        </div>
                    </dd>
                    <dt>
                        <label for="endDateB">勤務終了年月</label>
                    </dt>
                    <dd>
                        <div class="multi-item">
                            <div class="fields">
                                <x-molecules.select for="endYearB" :list="$fEntApplyMasters->yearMst??[]" :selected="old('endYearB', $fEntUserApplyInfo->kinmEndYymm2 ? (int)$fEntUserApplyInfo->kinmEndYymm2->format('Y')??'' : '')" />
                                <label for="endYearB">年</label>
                                <x-molecules.validation-errors :errors="$errors" for="endYearB" />
                            </div>
                            <div class="fields">
                                <x-molecules.select for="endMonthB" :list="$fEntApplyMasters->monthMst??[]" :selected="old('endMonthB', $fEntUserApplyInfo->kinmEndYymm2 ? (int)$fEntUserApplyInfo->kinmEndYymm2->format('m')??'' : '')" />
                                <label for="endMonthB">月</label>
                                <x-molecules.validation-errors :errors="$errors" for="endMonthB" />
                            </div>
                        </div>
                    </dd>
                    <dt>
                        <label for="employmentStatusB">雇用形態</label>
                    </dt>
                    <dd>
                        <x-molecules.select for="employmentStatusB" :kbnList="$fEntApplyMasters->koyKeitaiMst" :selected="old('employmentStatusB', (int)$fEntUserApplyInfo->koyKeitaiKbn2 ?? '')" />
                        <x-molecules.validation-errors :errors="$errors" for="employmentStatusB" />
                    </dd>
                    <dt>
                        <label for="jobDescriptionB">職務内容</label>
                    </dt>
                    <dd>
                        <textarea name="jobDescriptionB" id="jobDescriptionB">{{old('jobDescriptionB', $fEntUserApplyInfo->syokumuNaiyo2 ?? '')}}</textarea>
                        <small>最大5000文字まで</small>
                        <x-molecules.validation-errors :errors="$errors" for="jobDescriptionB" />
                    </dd>
                </dl>
            </div>
        </div>
        <div class="workExperienceBody">
            <div id="winC" class="{{$openList[2] ? 'open' : 'close'}}">
                <small id="delC" class="remove">
                    <a href="javascript:void(0)">‐ 職務経歴を削除</a>
                </small>
                <dl>
                    <dt>
                        <label for="companyNameC">会社名</label>
                    </dt>
                    <dd>
                        <x-molecules.input type="text" id="companyNameC" name="companyNameC" :value="old('companyNameC', $fEntUserApplyInfo->corpMei3 ?? '')" />
                        <x-molecules.validation-errors :errors="$errors" for="companyNameC" />
                    </dd>
                    <dt>
                        <label for="startDateC">勤務開始年月</label>
                    </dt>
                    <dd>
                        <div class="multi-item">
                            <div class="fields">
                                <x-molecules.select for="startYearC" :list="$fEntApplyMasters->yearMst??[]" :selected="old('startYearC', $fEntUserApplyInfo->kinmStrYymm3 ? (int)$fEntUserApplyInfo->kinmStrYymm3->format('Y')??'' : '')" />
                                <label for="startYearC">年</label>
                                <x-molecules.validation-errors :errors="$errors" for="startYearC" />
                            </div>
                            <div class="fields">
                                <x-molecules.select for="startMonthC" :list="$fEntApplyMasters->monthMst??[]" :selected="old('startMonthC', $fEntUserApplyInfo->kinmStrYymm3 ? (int)$fEntUserApplyInfo->kinmStrYymm3->format('m')??'' : '')" />
                                <label for="startMonthC">月</label>
                                <x-molecules.validation-errors :errors="$errors" for="startMonthC" />
                            </div>
                        </div>
                    </dd>
                    <dt>
                        <label for="endDateC">勤務終了年月</label>
                    </dt>
                    <dd>
                        <div class="multi-item">
                            <div class="fields">
                                <x-molecules.select for="endYearC" :list="$fEntApplyMasters->yearMst??[]" :selected="old('endYearC', $fEntUserApplyInfo->kinmEndYymm3 ? (int)$fEntUserApplyInfo->kinmEndYymm3->format('Y')??'' : '')" />
                                <label for="endYearC">年</label>
                                <x-molecules.validation-errors :errors="$errors" for="endYearC" />
                            </div>
                            <div class="fields">
                                <x-molecules.select for="endMonthC" :list="$fEntApplyMasters->monthMst??[]" :selected="old('endMonthC', $fEntUserApplyInfo->kinmEndYymm3 ? (int)$fEntUserApplyInfo->kinmEndYymm3->format('m')??'' : '')" />
                                <label for="endMonthC">月</label>
                                <x-molecules.validation-errors :errors="$errors" for="endMonthC" />
                            </div>
                        </div>
                    </dd>
                    <dt>
                        <label for="employmentStatusC">雇用形態</label>
                    </dt>
                    <dd>
                        <x-molecules.select for="employmentStatusC" :kbnList="$fEntApplyMasters->koyKeitaiMst" :selected="old('employmentStatusC', (int)$fEntUserApplyInfo->koyKeitaiKbn3 ?? '')" />
                        <x-molecules.validation-errors :errors="$errors" for="employmentStatusC" />
                    </dd>
                    <dt>
                        <label for="jobDescriptionC">職務内容</label>
                    </dt>
                    <dd>
                        <textarea name="jobDescriptionC" id="jobDescriptionC">{{old('jobDescriptionC', $fEntUserApplyInfo->syokumuNaiyo3 ?? '')}}</textarea>
                        <small>最大5000文字まで</small>
                        <x-molecules.validation-errors :errors="$errors" for="jobDescriptionC" />
                    </dd>
                </dl>
            </div>
        </div>
        <div class="workExperienceBody">
            <div id="winD" class="{{$openList[3] ? 'open' : 'close'}}">
                <small id="delD" class="remove">
                    <a href="javascript:void(0)">‐ 職務経歴を削除</a>
                </small>
                <dl>
                    <dt>
                        <label for="companyNameD">会社名</label>
                    </dt>
                    <dd>
                        <x-molecules.input type="text" id="companyNameD" name="companyNameD" :value="old('companyNameD', $fEntUserApplyInfo->corpMei4 ?? '')" />
                        <x-molecules.validation-errors :errors="$errors" for="companyNameD" />
                    </dd>
                    <dt>
                        <label for="startDateD">勤務開始年月</label>
                    </dt>
                    <dd>
                        <div class="multi-item">
                            <div class="fields">
                                <x-molecules.select for="startYearD" :list="$fEntApplyMasters->yearMst??[]" :selected="old('startYearD', $fEntUserApplyInfo->kinmStrYymm4 ? (int)$fEntUserApplyInfo->kinmStrYymm4->format('Y')??'' : '')" />
                                <label for="startYearD">年</label>
                                <x-molecules.validation-errors :errors="$errors" for="startYearD" />
                            </div>
                            <div class="fields">
                                <x-molecules.select for="startMonthD" :list="$fEntApplyMasters->monthMst??[]" :selected="old('startMonthD', $fEntUserApplyInfo->kinmStrYymm4 ? (int)$fEntUserApplyInfo->kinmStrYymm4->format('m')??'' : '')" />
                                <label for="startMonthD">月</label>
                                <x-molecules.validation-errors :errors="$errors" for="startMonthD" />
                            </div>
                        </div>
                    </dd>
                    <dt>
                        <label for="endDateD">勤務終了年月</label>
                    </dt>
                    <dd>
                        <div class="multi-item">
                            <div class="fields">
                                <x-molecules.select for="endYearD" :list="$fEntApplyMasters->yearMst??[]" :selected="old('endYearD', $fEntUserApplyInfo->kinmEndYymm4 ? (int)$fEntUserApplyInfo->kinmEndYymm4->format('Y')??'' : '')" />
                                <label for="endYearD">年</label>
                                <x-molecules.validation-errors :errors="$errors" for="endYearD" />
                            </div>
                            <div class="fields">
                                <x-molecules.select for="endMonthD" :list="$fEntApplyMasters->monthMst??[]" :selected="old('endMonthD', $fEntUserApplyInfo->kinmEndYymm4 ? (int)$fEntUserApplyInfo->kinmEndYymm4->format('m')??'' : '')" />
                                <label for="endMonthD">月</label>
                                <x-molecules.validation-errors :errors="$errors" for="endMonthD" />
                            </div>
                        </div>
                    </dd>
                    <dt>
                        <label for="employmentStatusD">雇用形態</label>
                    </dt>
                    <dd>
                        <x-molecules.select for="employmentStatusD" :kbnList="$fEntApplyMasters->koyKeitaiMst" :selected="old('employmentStatusD', (int)$fEntUserApplyInfo->koyKeitaiKbn4 ?? '')" />
                        <x-molecules.validation-errors :errors="$errors" for="employmentStatusD" />
                    </dd>
                    <dt>
                        <label for="jobDescriptionD">職務内容</label>
                    </dt>
                    <dd>
                        <textarea name="jobDescriptionD" id="jobDescriptionD">{{old('jobDescriptionD', $fEntUserApplyInfo->syokumuNaiyo4 ?? '')}}</textarea>
                        <small>最大5000文字まで</small>
                        <x-molecules.validation-errors :errors="$errors" for="jobDescriptionD" />
                    </dd>
                </dl>
            </div>
        </div>
        <div class="workExperienceBody">
            <div id="winE" class="{{$openList[4] ? 'open' : 'close'}}">
                <small id="delE" class="remove">
                    <a href="javascript:void(0)">‐ 職務経歴を削除</a>
                </small>
                <dl>
                    <dt>
                        <label for="companyNameE">会社名</label>
                    </dt>
                    <dd>
                        <x-molecules.input type="text" id="companyNameE" name="companyNameE" :value="old('companyNameE', $fEntUserApplyInfo->corpMei5 ?? '')" />
                        <x-molecules.validation-errors :errors="$errors" for="companyNameE" />
                    </dd>
                    <dt>
                        <label for="startDateE">勤務開始年月</label>
                    </dt>
                    <dd>
                        <div class="multi-item">
                            <div class="fields">
                                <x-molecules.select for="startYearE" :list="$fEntApplyMasters->yearMst??[]" :selected="old('startYearE', $fEntUserApplyInfo->kinmStrYymm5 ? (int)$fEntUserApplyInfo->kinmStrYymm5->format('Y')??'' : '')" />
                                <label for="startYearE">年</label>
                                <x-molecules.validation-errors :errors="$errors" for="startYearE" />
                            </div>
                            <div class="fields">
                                <x-molecules.select for="startMonthE" :list="$fEntApplyMasters->monthMst??[]" :selected="old('startMonthE', $fEntUserApplyInfo->kinmStrYymm5 ? (int)$fEntUserApplyInfo->kinmStrYymm5->format('m')??'' : '')" />
                                <label for="startMonthE">月</label>
                                <x-molecules.validation-errors :errors="$errors" for="startMonthE" />
                            </div>
                        </div>
                    </dd>
                    <dt>
                        <label for="endDateE">勤務終了年月</label>
                    </dt>
                    <dd>
                        <div class="multi-item">
                            <div class="fields">
                                <x-molecules.select for="endYearE" :list="$fEntApplyMasters->yearMst??[]" :selected="old('endYearE', $fEntUserApplyInfo->kinmEndYymm5 ? (int)$fEntUserApplyInfo->kinmEndYymm5->format('Y')??'' : '')" />
                                <label for="endYearE">年</label>
                                <x-molecules.validation-errors :errors="$errors" for="endYearE" />
                            </div>
                            <div class="fields">
                                <x-molecules.select for="endMonthE" :list="$fEntApplyMasters->monthMst??[]" :selected="old('endMonthE', $fEntUserApplyInfo->kinmEndYymm5 ? (int)$fEntUserApplyInfo->kinmEndYymm5->format('m')??'' : '')" />
                                <label for="endMonthE">月</label>
                                <x-molecules.validation-errors :errors="$errors" for="endMonthE" />
                            </div>
                        </div>
                    </dd>
                    <dt>
                        <label for="employmentStatusE">雇用形態</label>
                    </dt>
                    <dd>
                        <x-molecules.select for="employmentStatusE" :kbnList="$fEntApplyMasters->koyKeitaiMst" :selected="old('employmentStatusE', (int)$fEntUserApplyInfo->koyKeitaiKbn5 ?? '')" />
                        <x-molecules.validation-errors :errors="$errors" for="employmentStatusE" />
                    </dd>
                    <dt>
                        <label for="jobDescriptionE">職務内容</label>
                    </dt>
                    <dd>
                        <textarea name="jobDescriptionE" id="jobDescriptionE">{{old('jobDescriptionE', $fEntUserApplyInfo->syokumuNaiyo5 ?? '')}}</textarea>
                        <small>最大5000文字まで</small>
                        <x-molecules.validation-errors :errors="$errors" for="jobDescriptionE" />
                    </dd>
                </dl>
            </div>
        </div>
        <div>
            <small class="add"><a href="javascript:void(0)">＋ 職務経歴を追加</a></small>
        </div>
    </td>
</tr>
