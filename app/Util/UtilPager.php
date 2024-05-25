<?php

namespace App\Util;


use App\Models\FEnt\FEntPager;

/**
 * Class UtilPager
 * @package App\Util
 */
class UtilPager
{

    /**
     * @param FEntPager $fEntPager
     * @return FEntPager
     */
    public static function createFEntPager(FEntPager $fEntPager): FEntPager
    {

        $totalCnt = $fEntPager->totalCnt;
        $currentPage = $fEntPager->currentPage;
        $pageLimit = $fEntPager->pageLimit;
        $maxLinkCount = $fEntPager->maxLinkCount;

        $prevPage = $currentPage > 1 ? $currentPage - 1 : null;

        $pageLast = ceil($totalCnt / $pageLimit);
        if(($pageLast / 2) > $currentPage){
            $pageSt = (($currentPage - floor($maxLinkCount / 2)) > 0) ? ($currentPage - floor($maxLinkCount / 2)) : 1;
            $pageEnd = (($pageSt + ($maxLinkCount - 1)) < $pageLast) ? ($pageSt + ($maxLinkCount - 1)) : $pageLast;
        }else{
            $pageEnd = (($currentPage + floor($maxLinkCount / 2)) < $pageLast) ? ($currentPage + floor($maxLinkCount / 2)) : $pageLast;
            $pageSt = (($pageEnd - ($maxLinkCount - 1)) > 0) ? ($pageEnd - ($maxLinkCount - 1)) : 1;
        }
        $nextPage = ($currentPage + 1 <= $pageEnd) ? $currentPage + 1 : null;
        $listStNo = ($currentPage - 1) * $pageLimit + 1;
        $listEdNo = $totalCnt;
        // 最後のページでない場合はページの表示上限件数で区切った件数表示にする
        if($currentPage != $pageLast){
            $listEdNo = $pageLimit * $currentPage;
        }

        $fEntPager->totalCnt = number_format($totalCnt);
        $fEntPager->currentPage = $currentPage;
        $fEntPager->prevPage = $prevPage;
        $fEntPager->nextPage = $nextPage;
        $fEntPager->pageSt = $pageSt;
        $fEntPager->pageEnd = $pageEnd;
        $fEntPager->pageLast = $pageLast;
        $fEntPager->listStNo = $listStNo;
        $fEntPager->listEdNo = $listEdNo;

        return $fEntPager;
    }

}
