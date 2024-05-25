<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>{{$page->title}}</title>
    <meta name="keywords" content="{{$page->keywords}}">
    <meta name="description" content="{{$page->description}}">
    <meta name="format-detection" content="telephone=no">
    <meta name="csrf-token" content="{{csrf_token()}}">

    <?php
    $ua = $_SERVER['HTTP_USER_AGENT'];
    if ((strpos($ua, 'iPad') !== false) || (strpos($ua, 'Macintosh') !== false) || (strpos($ua, 'Android') !== false) && (strpos($ua, 'Mobile') === false) || (strpos($ua, 'A1_07') !== false) || (strpos($ua, 'SC-01C') !== false)) :
        echo '<meta name="viewport" content="width=1200px">';
    else :
        echo '<meta name="viewport" content="width=device-width">';
    endif;
    ?>

    <link rel="icon" href="{{asset('favicon.ico')}}"/>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.typekit.net/woi8xvp.css">

    <?php
    /**@var $page \App\Models\FEnt\FEntPage **/
    $sassImportFilePath = 'resources/sass/pages/page_' . $page->id . '.scss';
    $jsImportFilePath = 'resources/js/page_' . $page->id . '.js';
    ?>

    <link rel="stylesheet" type="text/css" media="all" href="{{asset('css/style.css')}}"/>
    {{--Font Awesome 5--}}
    <link rel="stylesheet" type="text/css" media="all" href="{{asset('css/all.min.css')}}"/>
    {{--Font Awesome 4--}}
{{--    <link rel="stylesheet" type="text/css" media="all" href="{{asset('css/fontawesome.min.css')}}"/>--}}

    {{--スクロールアニメーション--}}
{{--    <link rel="stylesheet" type="text/css" media="all" href="{{asset('css/aos.css')}}"/>--}}
    {{--ポップアップ表示--}}
    <link rel="stylesheet" type="text/css" media="all" href="{{asset('css/lity.min.css')}}"/>
    <link rel="stylesheet" type="text/css" media="all" href="{{asset('css/jquery.bxslider.css')}}"/>
    <link rel="stylesheet" type="text/css" media="all" href="{{asset('css/cbslideheader.css')}}"/>
    <link rel="stylesheet" type="text/css" media="all" href="{{asset('css/swiper.min.css')}}"/>

    @vite([$sassImportFilePath])

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js" type="text/javascript"></script>
{{--    <script type="text/javascript" src="{{asset('js/aos.js')}}"></script>--}}
    <script type="text/javascript" src="{{asset('js/lity.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.bxslider.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/swiper.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.flicksimple.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.cbslideheader.min.js')}}"></script>

    @vite(['resources/js/app.js', $jsImportFilePath])

    <script>
        const corp_url = '{{Route('top')}}';
    </script>

    @if(isset($page->fEntConfig->corporations[0]['ga']))
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{$page->fEntConfig->corporations[0]['ga'] ?? ''}}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{$page->fEntConfig->corporations[0]['ga'] ?? ''}}');
    </script>
    @endif

    @if(($page->id === 'job') && (isset($fEntJobDetail) ?? null))
        @php
            /* @var $fEntJobDetail \App\Models\FEnt\FEntJobDetail */
                //勤務地
                $workKinmtiKenMeiGFJ = '';
                $workKinmtiShikuMeiGFJ = '';

                $arrayWorkKinmutiTextGFJ = array();

                if(is_array($fEntJobDetail->arrayFEntKinmuti) && (count($fEntJobDetail->arrayFEntKinmuti) > 0)) {
                    $workKinmtiKenMeiGFJ = $fEntJobDetail->arrayFEntKinmuti[0]->prefName;
                    $workKinmtiShikuMeiGFJ = $fEntJobDetail->arrayFEntKinmuti[0]->cityName;
                    foreach($fEntJobDetail->arrayFEntKinmuti As $fEntKinmuti) {
                        $arrayWorkKinmutiTextGFJ[] = ($fEntKinmuti->prefName??'') . ($fEntKinmuti->cityName??''). ($fEntKinmuti->kinmutiAddress??'') . ' ' . ($fEntKinmuti->kinmutiName??'') . ' ' . ($fEntKinmuti->kotu??'');
                    }
                }

                //給与区分
                $workKyuyoKbnStrGFJ = '';
                $workKyuyoStrGFJ = '';

                if($fEntJobDetail->kyuyoKbnCode) {
                    $kyuyoMinStr = '';
                    if($fEntJobDetail->kyuyoMin ?? '') {
                        $kyuyoMinStr = $fEntJobDetail->kyuyoMin . '円';
                    }
                    switch(str($fEntJobDetail->kyuyoKbnCode)) {
                        case '1' :
                            $workKyuyoKbnStrGFJ = 'HOUR';
                            $workKyuyoStrGFJ = '【' . ($fEntJobDetail->kyuyoKbnName??'') . '】' . $kyuyoMinStr;
                            break;
                        case '2' :
                            $workKyuyoKbnStrGFJ = 'DAY';
                            $workKyuyoStrGFJ = '【' . ($fEntJobDetail->kyuyoKbnName??'') . '】' . $kyuyoMinStr;
                            break;
                        case '3' :
                            $workKyuyoKbnStrGFJ = 'MONTH';
                            $workKyuyoStrGFJ = '【' . ($fEntJobDetail->kyuyoKbnName??'') . '】' . $kyuyoMinStr;
                            break;
                        case '4' :
                        case '5' :
                            $workKyuyoKbnStrGFJ = 'YEAR';
                            $workKyuyoStrGFJ = '【' . ($fEntJobDetail->kyuyoKbnName??'') . '】' . $kyuyoMinStr;
                            break;
                        case '99' :
                            $workKyuyoKbnStrGFJ = 'OTHER';
                            $workKyuyoStrGFJ = '【' . ($fEntJobDetail->kyuyoKbnName??'') . '】' . $kyuyoMinStr;
                            break;
                        default:
                            break;
                    }
                }

                //給与MAX
                $workKyuyoMaxGFJ = '';
                if($fEntJobDetail->kyuyoMax) {
                    if($fEntJobDetail->kyuyoMax != '-1') {
                        $workKyuyoMaxGFJ = $fEntJobDetail->kyuyoMax;
                    }
                }

                //給与例
                $salaryExample = '';
                if($fEntJobDetail->salary) {
                    $salaryExample .= '【月収例】'. $fEntJobDetail->salary;
                }
                if($fEntJobDetail->annualSalary) {
                    if($fEntJobDetail->salary) {
                        $salaryExample .= '\n';
                    }
                    $salaryExample .= '【年収例】'. $fEntJobDetail->annualSalary;
                }

                //求人詳細URL
                $workJobDetailUrlGFJ = Route('top') . '/job/' . $fEntJobDetail->jobId . '/';

                //imageURL
                $workMainGazoFilePathGFJ = '';
                if($fEntJobDetail->mainGazoFilePath) {
                    $workMainGazoFilePathGFJ = ($fEntJobDetail->tenichiSiteUrl??'') . $fEntJobDetail->mainGazoFilePath;
                }

                //Description
                $workDescriptionGFJ = '';
                $workDescriptionGFJ .= ($fEntJobDetail->catchCopy??'') . '\n\n';
                $workDescriptionGFJ .= '■募集背景\n'. ($fEntJobDetail->bosyuHaikei??'') . '\n\n';
                $workDescriptionGFJ .= '■仕事内容\n'. ($fEntJobDetail->jobNaiyo??'') . '\n\n';
                $workDescriptionGFJ .= '■醍醐味\n'. ($fEntJobDetail->daigomi??'') . '\n\n';
                $workDescriptionGFJ .= '■厳しさ\n'. ($fEntJobDetail->kibishisa??'') . '\n\n';
                $workDescriptionGFJ .= '■応募資格\n'. ($fEntJobDetail->ouboSikaku??'') . '\n\n';
                $workDescriptionGFJ .= '■こんな人が活躍\n'. ($fEntJobDetail->katuyaku??'') . '\n\n';
                $workDescriptionGFJ .= '■給与\n'. $workKyuyoStrGFJ . ' '. ($fEntJobDetail->kyuyoBiko??''). '\n'. $salaryExample .'\n\n';
                $workDescriptionGFJ .= '■勤務地\n'. implode(',', $arrayWorkKinmutiTextGFJ) . '\n\n';
                $workDescriptionGFJ .= '■勤務時間\n'. ($fEntJobDetail->workingTimes??'') . '\n\n';
                $workDescriptionGFJ .= '■休日・休暇\n'. ($fEntJobDetail->holiday??'') . '\n\n';
                $workDescriptionGFJ .= '■福利厚生\n'. ($fEntJobDetail->taiguFukurikosei??'') . '\n\n';
                $workDescriptionGFJ .= '■アピールポイント\n'. ($fEntJobDetail->appealPoint??'') . '\n\n';

                $workDescriptionGFJ = str_replace(array("\r\n", "\r", "\n"), '\n', $workDescriptionGFJ);

                $workCodeGoogleForJobs = '';
                $workCodeGoogleForJobs .= '{';
                $workCodeGoogleForJobs .= '    "@context": "http://schema.org",';
                $workCodeGoogleForJobs .= '    "@type": "JobPosting",';
                $workCodeGoogleForJobs .= '    "datePosted": "'.substr($fEntJobDetail->updatedAt,0,10).'",';
                $workCodeGoogleForJobs .= '    "employmentType": "'.($fEntJobDetail->koyKeitaiName??'').'",';
                $workCodeGoogleForJobs .= '    "hiringOrganization": {';
                $workCodeGoogleForJobs .= '        "@type": "Organization",';
                $workCodeGoogleForJobs .= '        "name": "'.($fEntJobDetail->corpMei??'').'",';
                $workCodeGoogleForJobs .= '        "logo": "'.(($fEntJobDetail->corpLogoGazoDataFilePath??'') ? ($fEntJobDetail->tenichiSiteUrl??'').($fEntJobDetail->corpLogoGazoDataFilePath??'') : '').'"';
                $workCodeGoogleForJobs .= '    },';
                $workCodeGoogleForJobs .= '    "industry": "'.($fEntJobDetail->jobCategoryGroupName??'').'",';
                $workCodeGoogleForJobs .= '    "jobLocation": {';
                $workCodeGoogleForJobs .= '        "@type": "Place",';
                $workCodeGoogleForJobs .= '        "address": {';
                $workCodeGoogleForJobs .= '            "@type": "PostalAddress",';
                $workCodeGoogleForJobs .= '            "addressCountry": "JP",';
                $workCodeGoogleForJobs .= '            "addressRegion": "'.$workKinmtiKenMeiGFJ.'",';
                $workCodeGoogleForJobs .= '            "addressLocality": "'.$workKinmtiShikuMeiGFJ.'"';
                $workCodeGoogleForJobs .= '        }';
                $workCodeGoogleForJobs .= '    },';
                $workCodeGoogleForJobs .= '    "title": "'.($fEntJobDetail->jobTitle??'').'",';
                $workCodeGoogleForJobs .= '    "baseSalary":[{';
                $workCodeGoogleForJobs .= '      "@type":"MonetaryAmount",';
                $workCodeGoogleForJobs .= '      "currency":"JPY",';
                $workCodeGoogleForJobs .= '      "value":{';
                $workCodeGoogleForJobs .= '        "@type":"QuantitativeValue",';
                $workCodeGoogleForJobs .= '        "unitText":"'.$workKyuyoKbnStrGFJ.'",';
                $workCodeGoogleForJobs .= '        "minValue":"'.($fEntJobDetail->kyuyoMin??'').'",';
                $workCodeGoogleForJobs .= '        "maxValue":"'.$workKyuyoMaxGFJ.'"';
                $workCodeGoogleForJobs .= '    }}],';
                $workCodeGoogleForJobs .= '    "workHours": "'.($fEntJobDetail->workingTimes??'').'",';
                $workCodeGoogleForJobs .= '    "validThrough": "'.date("Y-m-d", strtotime("+3 month")).'",';
                $workCodeGoogleForJobs .= '    "description": "'.$workDescriptionGFJ.'",';
                $workCodeGoogleForJobs .= '    "image": "'.$workMainGazoFilePathGFJ.'",';
                $workCodeGoogleForJobs .= '    "url": "'.$workJobDetailUrlGFJ.'",';
                $workCodeGoogleForJobs .= '    "mainEntityOfPage": "'.$workJobDetailUrlGFJ.'"';

                $workCodeGoogleForJobs .= '}';

                $workCodeGoogleForJobs = str_replace(array("\r\n", "\r", "\n"),'\n',$workCodeGoogleForJobs);
        @endphp
        <script type="application/ld+json">{!! ($workCodeGoogleForJobs) !!}</script>
    @endif

</head>
