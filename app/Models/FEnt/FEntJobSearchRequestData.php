<?php

namespace App\Models\FEnt;

class FEntJobSearchRequestData extends FEntAbstract
{
    /**
     * @var array
     */
    public $jobIds;
    /**
     * @var array
     */
    public $exceptJobIds;
    /**
     * @var array
     */
    public $jobNos;
    /**
     * @var boolean
     */
    public $isMatchFullJobNo;
    /**
     * @var boolean
     */
    public $isAndSearchFeature;
    /**
     * @var boolean
     */
    public $isAndSearchKeyword;
    /**
     * @var boolean
     */
    public $isAndSearchBiko;
    /**
     * @var array
     */
    public $area;
    /**
     * @var array
     */
    public $pref;
    /**
     * @var array
     */
    public $city;
    /**
     * @var array
     */
    public $jobbc;
    /**
     * @var array
     */
    public $job;
    /**
     * @var array
     */
    public $koy;
    /**
     * @var array
     */
    public $tokucho;
    /**
     * @var array
     */
    public $eki;
    /**
     * @var integer
     */
    public $salaryClassCode;
    /**
     * @var integer
     */
    public $salaryMin;
    /**
     * @var integer
     */
    public $salaryMax;
    /**
     * @var array
     */
    public $kw;
    /**
     * @var array
     */
    public $biko;
    /**
     * @var integer
     */
    public $searchType;
    /**
     * @var array
     */
    public $corp;
    /**
     * @var boolean
     */
    public $video;
    /**
     * @var boolean
     */
    public $image;
    /**
     * @var string
     */
    public $termFrom;
    /**
     * @var string
     */
    public $termTo;
    /**
     * @var integer
     */
    public $pageLimit;
    /**
     * @var integer
     */
    public $pageNo;
    /**
     * @var array
     */
    public $sort;
}
