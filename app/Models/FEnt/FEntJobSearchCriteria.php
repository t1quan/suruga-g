<?php

namespace App\Models\FEnt;

class FEntJobSearchCriteria extends FEntAbstract
{
    public $jobIds;
    public $exceptJobIds;
    public $jobNos;
    public $isMatchFullJobNo;
    public $isAndSearchFeature;
    public $isAndSearchKeyword;
    public $isAndSearchBiko;

    public $areaCodes;
    public $prefCodes;
    public $cityCodes;
    public $jobGroupCodes;
    public $jobCodes;
    public $koyKeitaiCodes;
    public $tokuchoCodes;
    public $rosenCodes;
    public $salaryCode;
    public $salaryMin;
    public $salaryMax;
    public $keyword;
    public $biko;
    public $searchType;
    public $corpCode;
    public $isSetVideo;
    public $isSetImage;
    public $termFrom;
    public $termTo;

    public $pageLimit;
    public $pageNo;
    /**
     * @var array
     */
    public $sort;
}
