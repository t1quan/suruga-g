<?php

// applyフォームのデフォルトセッティング

return [
    'profile' => [
        'name' => [
            'lastName' => [
                'required' => true,
                'type' => 'string',
                'rule' => 'max:16'
            ],
            'firstName' => [
                'required' => true,
                'type' => 'string',
                'rule' => 'max:16'
            ],
            'required' => true,
        ],
        'nameRuby' => [
            'lastKana' => [
                'required' => true,
                'type' => 'string',
                'rule' => 'max:32'
            ],
            'firstKana' => [
                'required' => true,
                'type' => 'string',
                'rule' => 'max:32'
            ],
            'required' => true,
        ],
        'birthday' => [
            'dobYear' => [
                'required' => true,
                'type' => 'numeric',
                'rule' => 'digits:4'
            ],
            'dobMonth' => [
                'required' => true,
                'type' => 'numeric',
                'rule' => 'digits_between:1,2'
            ],
            'dobDay' => [
                'required' => true,
                'type' => 'numeric',
                'rule' => 'digits_between:1,2'
            ],
            'required' => true,
        ],
        'gender' => [
            'gender' => [
                'required' => false,
                'type' => 'numeric',
                'rule' => 'between:0,2'
            ],
            'required' => false,
        ],
        'address' => [
            'zipCode' => [
                'required' => true,
                'type' => 'numeric',
                'rule' => 'digits_between:1,7'
            ],
            'prefecture' => [
                'required' => true,
                'type' => 'integer',
                'rule' => 'between:1,47'
            ],
            'city' => [
                'required' => true,
                'type' => 'integer',
                'rule' => 'between:101,99999' //101以上、一旦5桁までを許容
            ],
            'street' => [
                'required' => false,
                'type' => 'string',
                'rule' => null
            ],
            'required' => true,
        ],
        'telNumber' => [
            'telNumber' => [
                'required' => true,
                'type' => 'string',
                'rule' => 'max:13'
            ],
            'required' => true,
        ],
        'mailAddress' => [
            'mailAddress' => [
                'required' => true,
                'type' => 'email',
                'rule' => 'max:256'
            ],
            'required' => true,
        ],
        'currentOccupation' => [
            'currentOccupation' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:1,99'
            ],
            'required' => false,
        ],
    ],
    'skill' => [
        'language' => [
            'englishConversation' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:1,3'
            ],
            'businessEnglish' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:1,3'
            ],
            'toeicScore' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:0,999' //3桁までを許容
            ],
            'toeflScore' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:0,999' //3桁までを許容
            ],
            'stepScore' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:1,7'
            ],
            'otherLanguage' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:1,9'
            ],
            'otherConversation' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:1,3'
            ],
            'otherBusiness' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:1,3'
            ],
            'required' => false,
        ],
        'pcSkill' => [
            'wordSkill' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:1,3'
            ],
            'excelSkill' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:1,3'
            ],
            'accessSkill' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:1,3'
            ],
            'powerpointSkill' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:1,3'
            ],
            'webSkill' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:1,3'
            ],
            'otherPCSkill' => [
                'required' => false,
                'type' => 'string',
                'rule' => 'max:1000'
            ],
            'required' => false,
        ],
        'qualification' => [
            'qualification' => [
                'required' => false,
                'type' => 'string',
                'rule' => 'max:1000'
            ],
            'required' => false,
        ],
    ],
    'career' => [
        'changeNumber' => [
            'changeNumber' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:0,5'
            ],
            'required' => false,
        ],
        'occupation' => [
            'occupation1' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:1,9999'
            ],
            'period1' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:0,9'
            ],

            'occupation2' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:1,9999'
            ],
            'period2' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:0,9'
            ],

            'occupation3' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:1,9999'
            ],
            'period3' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:0,9'
            ],

            'occupation4' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:1,9999'
            ],
            'period4' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:0,9'
            ],

            'occupation5' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:1,9999'
            ],
            'period5' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:0,9'
            ],
            'required' => false,
        ],
        'industry' => [
            'industry1' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:1,99'
            ],
            'industry2' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:1,99'
            ],
            'industry3' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:1,99'
            ],
            'required' => false,
        ],
        'managementExperience' => [
            'managementExperience' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:0,1'
            ],
            'required' => false,
        ],
        'managementNumber' => [
            'managementNumber' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:0,4'
            ],
            'required' => false,
        ],
        'jobHistories' => [
            'companyNameA' => [
                'required' => false,
                'type' => 'string',
                'rule' => 'max:50'
            ],
            'startYearA' => [
                'required' => false,
                'type' => 'numeric',
                'rule' => 'digits:4'
            ],
            'startMonthA' => [
                'required' => false,
                'type' => 'numeric',
                'rule' => 'digits_between:1,2'
            ],
            'endYearA' => [
                'required' => false,
                'type' => 'numeric',
                'rule' => 'digits:4'
            ],
            'endMonthA' => [
                'required' => false,
                'type' => 'numeric',
                'rule' => 'digits_between:1,2'
            ],
            'employmentStatusA' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:1,99'
            ],
            'jobDescriptionA' => [
                'required' => false,
                'type' => 'string',
                'rule' => 'max:5000'
            ],

            'companyNameB' => [
                'required' => false,
                'type' => 'string',
                'rule' => 'max:50'
            ],
            'startYearB' => [
                'required' => false,
                'type' => 'numeric',
                'rule' => 'digits:4'
            ],
            'startMonthB' => [
                'required' => false,
                'type' => 'numeric',
                'rule' => 'digits_between:1,2'
            ],
            'endYearB' => [
                'required' => false,
                'type' => 'numeric',
                'rule' => 'digits:4'
            ],
            'endMonthB' => [
                'required' => false,
                'type' => 'numeric',
                'rule' => 'digits_between:1,2'
            ],
            'employmentStatusB' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:1,99'
            ],
            'jobDescriptionB' => [
                'required' => false,
                'type' => 'string',
                'rule' => 'max:5000'
            ],

            'companyNameC' => [
                'required' => false,
                'type' => 'string',
                'rule' => 'max:50'
            ],
            'startYearC' => [
                'required' => false,
                'type' => 'numeric',
                'rule' => 'digits:4'
            ],
            'startMonthC' => [
                'required' => false,
                'type' => 'numeric',
                'rule' => 'digits_between:1,2'
            ],
            'endYearC' => [
                'required' => false,
                'type' => 'numeric',
                'rule' => 'digits:4'
            ],
            'endMonthC' => [
                'required' => false,
                'type' => 'numeric',
                'rule' => 'digits_between:1,2'
            ],
            'employmentStatusC' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:1,99'
            ],
            'jobDescriptionC' => [
                'required' => false,
                'type' => 'string',
                'rule' => 'max:5000'
            ],

            'companyNameD' => [
                'required' => false,
                'type' => 'string',
                'rule' => 'max:50'
            ],
            'startYearD' => [
                'required' => false,
                'type' => 'numeric',
                'rule' => 'digits:4'
            ],
            'startMonthD' => [
                'required' => false,
                'type' => 'numeric',
                'rule' => 'digits_between:1,2'
            ],
            'endYearD' => [
                'required' => false,
                'type' => 'numeric',
                'rule' => 'digits:4'
            ],
            'endMonthD' => [
                'required' => false,
                'type' => 'numeric',
                'rule' => 'digits_between:1,2'
            ],
            'employmentStatusD' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:1,99'
            ],
            'jobDescriptionD' => [
                'required' => false,
                'type' => 'string',
                'rule' => 'max:5000'
            ],

            'companyNameE' => [
                'required' => false,
                'type' => 'string',
                'rule' => 'max:50'
            ],
            'startYearE' => [
                'required' => false,
                'type' => 'numeric',
                'rule' => 'digits:4'
            ],
            'startMonthE' => [
                'required' => false,
                'type' => 'numeric',
                'rule' => 'digits_between:1,2'
            ],
            'endYearE' => [
                'required' => false,
                'type' => 'numeric',
                'rule' => 'digits:4'
            ],
            'endMonthE' => [
                'required' => false,
                'type' => 'numeric',
                'rule' => 'digits_between:1,2'
            ],
            'employmentStatusE' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:1,99'
            ],
            'jobDescriptionE' => [
                'required' => false,
                'type' => 'string',
                'rule' => 'max:5000'
            ],
            'required' => false,
        ],
    ],
    'pr' => [
        'pr' => [
            'pr' => [
                'required' => false,
                'type' => 'string',
                'rule' => 'max:1000'
            ],
            'required' => false,
        ],
    ],
    'others' => [
        'maritalStatus' => [
            'maritalStatus' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:0,2'
            ],
            'required' => false,
        ],
        'currentAddress' => [
            'station' => [
                'required' => false,
                'type' => 'string',
                'rule' => null
            ],
            'required' => false,
        ],
        'educationBackground' => [
            'educationLevel' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:1,99'
            ],
            'graduationYear' => [
                'required' => false,
                'type' => 'numeric',
                'rule' => 'digits:4'
            ],
            'graduationStatus' => [
                'required' => false,
                'type' => 'integer',
                'rule' => 'between:1,4'
            ],
            'schoolName' => [
                'required' => false,
                'type' => 'string',
                'rule' => 'max:50'
            ],
            'departmentName' => [
                'required' => false,
                'type' => 'string',
                'rule' => 'max:50'
            ],
            'required' => false,
        ],
    ],
];
