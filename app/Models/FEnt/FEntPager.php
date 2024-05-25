<?php

namespace App\Models\FEnt;

/**
 * Class FEntPager
 * @package App\Models\FEnt
 */
class FEntPager extends FEntAbstract
{
    public $action;
    public $pageLimit;
    public $maxLinkCount;
    public $totalCnt;
    public $currentPage;

    public $prevPage;
    public $nextPage;
    public $pageSt;
    public $pageEnd;
    public $pageLast;

    public $listStNo;
    public $listEdNo;

}
