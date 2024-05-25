<?php

namespace App\Models\FEnt;

class FEntApplicant extends FEntAbstract
{
    public $lastName; //応募者(姓)
    public $firstName; //応募者(名)

    public $lastNameKana; //応募者(姓カナ)
    public $firstNameKana; //応募者(名カナ)

    public $email; //メールアドレス
    public $tel; //電話番号

    public $gender; //性別コード
    public $zip; //郵便番号(ハイフンなし)

    public $pref; //都道府県コード
    public $city; //市区町村コード
    public $otherAddr; //その他住所

    public $birthDay; //生年月日(YYYY/MM/DD)

    public $married; //結婚ステータスコード
    public $occupation; //現在の職業コード
    public $aboutMySelf; //自己PR

    public $station; //最寄り駅名称

    public $changeJobCount; //転職回数コード

    //職歴情報(最大5件)
    /**
     * @var FEntJobHistory[]
     */
    public $jobHistories;

    public $managementExperience; //マネジメント経験コード
    public $numberOfManagement; //マネジメント人数コード

    public $schoolType; //学校区分コード
    public $graduationYear; //卒業年度(YYYY)
    public $educationStatus; //学歴状態コード
    public $schoolName; //学校名
    public $schoolFaculty; //学部学科名

    public $toeic; //TOEIC点数
    public $toefl; //TOEFL点数
    public $eiken; //英検の取得等級コード
    public $conversationEnglish; //英語の会話レベルコード
    public $businessEnglish; //英語の業務レベルコード
    public $otherLanguage; //その他言語コード
    public $conversationOtherLanguage; //その他言語の会話レベルコード
    public $businessOtherLanguage; //その他言語の業務レベルコード
    public $wordSkill; //Word技能等級コード
    public $excelSkill; //Excel技能等級コード
    public $accessSkill; //Access技能等級コード
    public $powerpointSkill; //Powerpoint技能等級コード
    public $webSkill; //WEB関連技能等級コード
    public $pcSkill; //その他のPCスキル
    public $otherSkill; //取得資格

    public $remarks; //備考

}
