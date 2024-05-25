<?php

namespace App\Models\FEnt;

class FEntJobDetail
{
    //JSS0001
    public $jobId; // 管理番号
    public $jisyaKoukokuNum; // 仕事番号

    //JSS0002
    public $jobTitle; // 仕事名
    public $corpMei; // 企業名
    public $catchCopy; // キャッチコピー
    public $lead; // リード文
    public $mainGazoFilePath; // メイン画像ファイルパス
    public $mainGazoCaption; // メイン画像説明文
    public $subGazo1FilePath; // サブ画像1ファイルパス
    public $subGazo1Caption; // サブ画像1説明文
    public $subGazo2FilePath; // サブ画像2ファイルパス
    public $subGazo2Caption; // サブ画像2説明文
    public $subGazo3FilePath; // サブ画像3ファイルパス
    public $subGazo3Caption; // サブ画像3説明文
    public $koyKeitaiCode;
    public $koyKeitaiName;
    public $koyKeitaiBiko; // koy_keitai
    public $bosyuHaikei;
    public $jobNaiyo;
    public $daigomi;
    public $kibishisa;
    public $ouboSikaku;
    public $katuyaku;
    public $kyuyoKbnCode;
    public $kyuyoKbnName;
    public $kyuyoMin;
    public $kyuyoMax;
    public $kyuyoBiko;
    public $salary;
    public $annualSalary;
    public $workingTimes;
    public $taiguFukurikosei;
    public $holiday;
    public $appealPoint;
    public $senkoTejun;
    public $mensetsuAddr;

    // jcm0001
    public $corpCd;

    public $biko; // 求人備考
    public $updatedAt; // 更新日付

    //JSS0002
    public $jobCategoryCode; // 職種コード
    public $jobCategoryName; // 職種名
    public $jobCategoryGroupCode; // 職種分類コード
    public $jobCategoryGroupName; // 職種分類名

    //JSS0003
    /**
     * @var FEntTokucho[]
     */
    public $arrayFEntTokucho;

    //JSS0006
    /**
     * @var FEntKinmuti[]
     */
    public $arrayFEntKinmuti;

    //JSS0010
    /**
     * @var FEntSelfParam[]
     */
    public $arrayFEntSelfParam;

    //SCM0043
    /**
     * @var FEntVideo[]
     */
    public $fEntVideo;

    //JCM0001
    public $corpLogoGazoDataFilePath; //企業ロゴ画像ファイルパス

    public $tenichiSiteUrl; //tenichi TOPページURL
}
