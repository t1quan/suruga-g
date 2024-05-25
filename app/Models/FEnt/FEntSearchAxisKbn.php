<?php

namespace App\Models\FEnt;

class FEntSearchAxisKbn
{
    public $type; //valueに対応するパラメータ名

    public $name; // 名称
    public $value; // 値
    public $cnt; // 該当件数
    public $parent; // 親要素の値

    /**
     * @var FEntSearchAxisKbn[]
     */
    public $children; //子要素
}
