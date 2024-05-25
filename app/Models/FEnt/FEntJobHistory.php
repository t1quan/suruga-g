<?php

namespace App\Models\FEnt;

class FEntJobHistory extends FEntAbstract
{
    public $corpName; //企業名
    public $startDate; //就業期間開始日(YYYY/MM/DD)
    public $endDate; //就業期間終了日(YYYY/MM/DD)
    public $employmentStatus; //雇用形態コード
    public $jobContents; //職務内容
    public $jobCategory; //経験職種
    public $yearsOfExperience; //経験年数
    public $jobIndustry; //経験業種
}
