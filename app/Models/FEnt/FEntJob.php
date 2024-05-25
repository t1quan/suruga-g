<?php

namespace App\Models\FEnt;

class FEntJob
{
    //JSS0001
    public $jobId; // 管理番号
    public $jisyaKoukokuNum; // 仕事番号
    public $updatedAt; // 更新日
    public $biko; //備考

    //JSS0002
    public $jobTitle; // 仕事名
    public $corpMei; // 企業名
    public $catchCopy; // キャッチコピー
    public $mainGazoFilePath; // メイン画像ファイルパス
    public $mainGazoCaption; // メイン画像説明文
    public $koyKeitaiCode;
    public $koyKeitaiName;
    public $koyKeitaiBiko; // 雇用形態備考
    public $jobNaiyo;
    public $kyuyoKbnCode;
    public $kyuyoKbnName;
    public $kyuyoMin;
    public $kyuyoMax;
    public $workingTimes;

    // jcm0001
    public $corpCd;


    //JSS0002
    public $jobCategoryCode; // 職種コード
    public $jobCategoryName; // 職種名
    public $jobCategoryGroupCode; // 職種分類コード
    public $jobCategoryGroupName; // 職種分類名

    //JSS0006
    /**
     * @var FEntKinmuti[]
     */
    public $arrayFEntKinmuti;
}
