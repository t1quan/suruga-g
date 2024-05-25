@props(['fEntSearchAxisData','searchSelectedMasterList','criteria'])

@php
    $arrayAreaHead = array();
    $arrayPrefHead = array();
    $arrayCityHead = array();
    $areaText = null;
    $prefText = null;
    $cityText = null;

    $areaMaster = array();
    $prefMaster = array();
    $cityMaster = array();
    $customMaster = array();

    if($fEntSearchAxisData->isCustomArea) {

        $axisType = null;

        //表示優先順はpref > area > city としておく
        if($fEntSearchAxisData->fEntSearchAxis->city) {
            $axisType = 'city';
        }
        if($fEntSearchAxisData->fEntSearchAxis->area) {
            $axisType = 'area';
        }
        if($fEntSearchAxisData->fEntSearchAxis->pref) {
            $axisType = 'pref';
        }

        if($axisType) {
            foreach($fEntSearchAxisData->fEntSearchAxis->$axisType As $index => $customAxis) {
                $customMaster[$customAxis->value] = $customAxis;
            }
        }

        if($customMaster) {
            foreach($customMaster As $key => $kbnItems) {
                $isSearchedParent = false;

                if($kbnItems->type??null) {
                    switch($kbnItems->type) {
                        case 'bc':
                            if($criteria->areaCodes) {
                                if(strpos($criteria->areaCodes, $key) !== false) {
                                    $arrayAreaHead[] = $kbnItems->name;
                                    $isSearchedParent = true;
                                }
                            }
                            break;

                        case 'area':
                            if($criteria->prefCodes) {
                                if(strpos($criteria->prefCodes, $key) !== false) {
                                    $arrayAreaHead[] = $kbnItems->name;
                                    $isSearchedParent = true;
                                }
                            }
                            break;

                        case 'city':
                            if($criteria->cityCodes) {
                                if(strpos($criteria->cityCodes, $key) !== false) {
                                    $arrayAreaHead[] = $kbnItems->name;
                                    $isSearchedParent = true;
                                }
                            }
                            break;

                        default:
                            break;
                    }
                }

                if($kbnItems->children) {
                    foreach($kbnItems->children As $children) {

                        if($children->type??null) {
                            switch($children->type) {
                                case 'bc':
                                    if($criteria->areaCodes) {
                                        if((strpos($criteria->areaCodes, $children->value) !== false) && $isSearchedParent == false) {
                                            $arrayPrefHead[] = $children->name;
                                        }
                                    }
                                    break;

                                case 'area':
                                    if($criteria->prefCodes) {
                                        if((strpos($criteria->prefCodes, $children->value) !== false) && $isSearchedParent == false) {
                                            $arrayPrefHead[] = $children->name;
                                        }
                                    }
                                    break;

                                case 'city':
                                    if($criteria->cityCodes) {
                                        if((strpos($criteria->cityCodes, $children->value) !== false) && $isSearchedParent == false) {
                                            $arrayPrefHead[] = $children->name;
                                        }
                                    }
                                    break;

                                default:
                                    break;
                            }
                        }
                    }
                }
            }
        }
    }

    else {

        //マスタデータの整形
        foreach($searchSelectedMasterList->areaMst As $index => $areaMst) {
            $areaMaster[$areaMst->value] = $areaMst->name;
        }

        foreach($searchSelectedMasterList->prefMst As $index => $prefMst) {
            $prefMaster[$prefMst->value] =
                array(
                    'name' => $prefMst->name,
                    'parent'=> $prefMst->parent
                );
        }

        foreach($searchSelectedMasterList->cityMst As $index => $cityMst) {
            $cityMaster[$cityMst->value] =
                array(
                    'name' => $cityMst->name,
                    'parent'=> $cityMst->parent
                );
        }

        if($criteria->areaCodes) {
            foreach(explode("[]", $criteria->areaCodes) As $areaCodesCriteria) {
                if($areaMaster[$areaCodesCriteria]??null) {
                    $arrayAreaHead[] = $areaMaster[$areaCodesCriteria];
                }
            }
        }

        if($criteria->prefCodes) {
            foreach(explode("[]", $criteria->prefCodes) As $prefCodesCriteria) {
                $isSearchedParent = false;
                if($criteria->areaCodes) {
                    foreach(explode("[]", $criteria->areaCodes) As $areaCodesCriteria) {
                        if(($prefMaster[$prefCodesCriteria]['parent']??null) == $areaCodesCriteria) {
                            $isSearchedParent = true;
                            break;
                        }
                    }
                }
                if(($prefMaster[$prefCodesCriteria]['name']??null) && $isSearchedParent == false) {
                    $arrayPrefHead[] = $prefMaster[$prefCodesCriteria]['name'];
                }
            }
        }

        if($criteria->cityCodes) {
            foreach(explode("[]", $criteria->cityCodes) As $cityCodesCriteria) {
                $isSearchedParent = false;
                if($criteria->prefCodes) {
                    foreach(explode("[]", $criteria->prefCodes) As $prefCodesCriteria) {
                        if(($cityMaster[$cityCodesCriteria]['parent']??null) == $prefCodesCriteria) {
                            $isSearchedParent = true;
                            break;
                        }
                    }
                }
                if(($cityMaster[$cityCodesCriteria]['name']??null) && $isSearchedParent == false) {
                    $arrayCityHead[] = $cityMaster[$cityCodesCriteria]['name'];
                }
            }
        }
    }

    if($arrayAreaHead) {
        $areaText = implode(" , ", $arrayAreaHead);
    }
    if($arrayPrefHead) {
        $prefText = implode(" , ", $arrayPrefHead);
    }
    if($arrayCityHead) {
        $cityText = implode(" , ", $arrayCityHead);
    }
@endphp

<div class="searchCondHeadLocation">
    <div class="searchHeadLabel">勤務地</div>
    <div class="searchHeadContent">
        @if($areaText)
            <div class="searchHeadArea">{{($areaText)}}</div>
        @endif
        @if($prefText)
            <div class="searchHeadPref">{{($prefText)}}</div>
        @endif
        @if($cityText)
            <div class="searchHeadCity">{{($cityText)}}</div>
        @endif
    </div>
</div>