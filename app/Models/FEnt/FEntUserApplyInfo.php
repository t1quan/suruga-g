<?php

namespace App\Models\FEnt;

class FEntUserApplyInfo extends FEntAbstract
{
    public $nameSei; //応募者(姓)
    public $nameMei; //応募者(名)

    public $nameSeiKn; //応募者(姓カナ)
    public $nameMeiKn; //応募者(名カナ)

    public $mailAddress; //メールアドレス
    public $telNumber; //電話番号

    public $gender; //性別コード
    public $zipCd; //郵便番号(ハイフンなし)

    public $kenCd; //都道府県コード
    public $shikuCd; //市区町村コード
    public $otherAddr; //その他住所

    public $birthday; //生年月日(YYYY/MM/DD)

    public $marriage; //結婚ステータスコード
    public $currentSykgyKbn; //現在の職業コード
    public $jikoPr; //自己PR

    public $moyoriEki; //最寄り駅名称

    public $changeJobCount; //転職回数コード

    //職歴情報(最大5件)
    public $corpMei1; //企業名
    public $corpMei2;
    public $corpMei3;
    public $corpMei4;
    public $corpMei5;

    public $kinmStrYymm1; //就業期間開始日(YYYY/MM/DD)
    public $kinmStrYymm2;
    public $kinmStrYymm3;
    public $kinmStrYymm4;
    public $kinmStrYymm5;

    public $kinmEndYymm1; //就業期間終了日(YYYY/MM/DD)
    public $kinmEndYymm2;
    public $kinmEndYymm3;
    public $kinmEndYymm4;
    public $kinmEndYymm5;

    public $koyKeitaiKbn1; //雇用形態コード
    public $koyKeitaiKbn2;
    public $koyKeitaiKbn3;
    public $koyKeitaiKbn4;
    public $koyKeitaiKbn5;

    public $syokumuNaiyo1; //職務内容
    public $syokumuNaiyo2;
    public $syokumuNaiyo3;
    public $syokumuNaiyo4;
    public $syokumuNaiyo5;

    public $keiknSyksyCd1; //経験職種
    public $keiknSyksyCd2;
    public $keiknSyksyCd3;
    public $keiknSyksyCd4;
    public $keiknSyksyCd5;

    public $keiknSyksyNensuKbn1; //経験年数
    public $keiknSyksyNensuKbn2;
    public $keiknSyksyNensuKbn3;
    public $keiknSyksyNensuKbn4;
    public $keiknSyksyNensuKbn5;

    public $keiknGyokaiCd1; //経験業種
    public $keiknGyokaiCd2;
    public $keiknGyokaiCd3;
    public $keiknGyokaiCd4;
    public $keiknGyokaiCd5;

    public $managementExperience; //マネジメント経験コード
    public $numberOfManagement; //マネジメント人数コード

    public $gakkoKbn; //学校区分コード
    public $sotsugyoYear; //卒業年度(YYYY)
    public $gakurekiKbn; //学歴状態コード
    public $gakkoMei; //学校名
    public $gakubuGakkaMei; //学部学科名

    public $eigoKaiwaLevelKbn; //英語の会話レベルコード
    public $eigoGyomLevelKbn; //英語の業務レベルコード
    public $toeic; //TOEIC点数
    public $toefl; //TOEFL点数
    public $eikenKbn; //英検の取得等級コード
    public $etcLanguageKbn; //その他言語コード
    public $etcLanguageKaiwaLevelKbn; //その他言語の会話レベルコード
    public $etcLanguageGyomLevelKbn; //その他言語の業務レベルコード
    public $wordLevelKbn; //Word技能等級コード
    public $excelLevelKbn; //Excel技能等級コード
    public $accessLevelKbn; //Access技能等級コード
    public $powerpointLevelKbn; //Powerpoint技能等級コード
    public $webKnrnLevelKbn; //WEB関連技能等級コード
    public $etcPcSkill; //その他のPCスキル
    public $sikak; //取得資格

    public $biko; //備考


    /**
     * @var array
     */
    public $free; //フリー項目の配列

}
