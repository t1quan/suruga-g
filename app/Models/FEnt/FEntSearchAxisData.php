<?php

namespace App\Models\FEnt;

class FEntSearchAxisData
{
    /**
     * @var FEntSearchAxis
     */
    public $fEntSearchAxis; // 検索軸データ

    /**
     * @var boolean
     */
    public $isSuccessGetAxis; // 検索軸取得可否

    /**
     * @var boolean
     */
    public $isCustomSearch; // カスタム検索かどうか

    /**
     * @var boolean
     */
    public $isCustomArea; // カスタムエリアかどうか

    /**
     * @var boolean
     */
    public $isCustomJob; // カスタム職種かどうか

}
