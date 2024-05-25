<?php

namespace App\Models\FEnt;

/**
 * Class FEntPage
 * @package App\Models\FEnt
 */
class FEntPage extends FEntAbstract
{

    // header
    /** @var string */
    public $id;
    /** @var string */
    public $title;
    /** @var string */
    public $description;
    /** @var string */
    public $keywords;
    /** @var bool */
    public $noindex;
    /** @var bool */
    public $notruck;

    /** @var string */
    public $version;

    // body
    /** @var string */
    public $action;
    /** @var string */
    public $class;
    /** @var string */
    public $addStyleId;

    /** @var FEntConfig */
    public $fEntConfig;

    /** @var FEntJobSearchCriteria */
    public $criteria;

    /** @var integer */
    public $favoriteJobCnt;
}
