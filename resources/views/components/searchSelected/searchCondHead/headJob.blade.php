@props(['fEntSearchAxisData','searchSelectedMasterList','criteria'])

@php
    $arrayJobGroupHead = array();
    $arrayJobHead = array();
    $jobGroupText = null;
    $jobText = null;

    $jobGroupMaster = array();
    $jobMaster = array();
    $customMaster = array();

    if($fEntSearchAxisData->isCustomJob) {
        $axisType = null;

        //表示優先順はjobbc > job としておく
        if($fEntSearchAxisData->fEntSearchAxis->job) {
            $axisType = 'job';
        }
        if($fEntSearchAxisData->fEntSearchAxis->jobbc) {
            $axisType = 'jobbc';
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
                        case 'jobbc':
                            if($criteria->jobGroupCodes) {
                                if(strpos($criteria->jobGroupCodes, $key) !== false) {
                                    $arrayJobGroupHead[] = $kbnItems->name;
                                    $isSearchedParent = true;
                                }
                            }
                            break;

                        case 'job':
                            if($criteria->jobCodes) {
                                if(strpos($criteria->jobCodes, $key) !== false) {
                                    $arrayJobGroupHead[] = $kbnItems->name;
                                    $isSearchedParent = true;
                                }
                            }
                            break;

                        case 'kw':
                            if($criteria->keyword) {
                                if(strpos($criteria->keyword, $key) !== false) {
                                    $arrayJobGroupHead[] = $kbnItems->name;
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
                                case 'jobbc':
                                    if($criteria->jobGroupCodes) {
                                        if((strpos($criteria->jobGroupCodes, $children->value) !== false) && $isSearchedParent == false) {
                                            $arrayJobHead[] = $children->name;
                                        }
                                    }
                                    break;

                                case 'job':
                                    if($criteria->jobCodes) {
                                        if((strpos($criteria->jobCodes, $children->value) !== false) && $isSearchedParent == false) {
                                            $arrayJobHead[] = $children->name;
                                        }
                                    }
                                    break;

                                case 'kw':
                                    if($criteria->keyword) {
                                        if((strpos($criteria->keyword, $children->value) !== false) && $isSearchedParent == false) {
                                            $arrayJobHead[] = $children->name;
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
        foreach($searchSelectedMasterList->jobCategoryGroupMst As $index => $jobGroupMst) {
            $jobGroupMaster[$jobGroupMst->value] = $jobGroupMst->name;
        }

        foreach($searchSelectedMasterList->jobCategoryMst As $index => $jobMst) {
            $jobMaster[$jobMst->value] =
                array(
                    'name' => $jobMst->name,
                    'parent'=> $jobMst->parent
                );
        }

        if($criteria->jobGroupCodes) {
            foreach(explode("[]", $criteria->jobGroupCodes) As $jobGroupCodesCriteria) {
                if($jobGroupMaster[$jobGroupCodesCriteria]??null) {
                    $arrayJobGroupHead[] = $jobGroupMaster[$jobGroupCodesCriteria];
                }
            }
        }

        if($criteria->jobCodes) {
            foreach(explode("[]", $criteria->jobCodes) As $jobCodesCriteria) {
                $isSearchedParent = false;
                if($criteria->jobGroupCodes) {
                    foreach(explode("[]", $criteria->jobGroupCodes) As $jobGroupCodesCriteria) {
                        if(($jobMaster[$jobCodesCriteria]['parent']??null) == $jobGroupCodesCriteria) {
                            $isSearchedParent = true;
                            break;
                        }
                    }
                }
                if(($jobMaster[$jobCodesCriteria]['name']??null) && $isSearchedParent == false) {
                    $arrayJobHead[] = $jobMaster[$jobCodesCriteria]['name'];
                }
            }
        }
    }

    if($arrayJobGroupHead) {
        $jobGroupText = implode(" , ", $arrayJobGroupHead);
    }
    if($arrayJobHead) {
        $jobText = implode(" , ", $arrayJobHead);
    }
@endphp

<div class="searchCondHeadJob">
    <div class="searchHeadLabel">職種</div>
    <div class="searchHeadContent">
        @if($jobGroupText)
            <div class="searchHeadJobGroup">{{($jobGroupText)}}</div>
        @endif
        @if($jobText)
            <div class="searchHeadJob">{{($jobText)}}</div>
        @endif
    </div>
</div>