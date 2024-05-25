@props(['fEntUserApplyInfo', 'groupName', 'list'])

@php
    $isGroupHidden = false;
    /* @var $list */
    foreach($list As $fieldName => $rules) {
        if(isset($rules['fieldType']) && ($rules['fieldType'] === 'input')) {
            if(isset($rules['hidden']) && $rules['hidden']) {
                 $isGroupHidden = true;
                 break;
            }
        }
    }
@endphp

<tr class="{{($groupName)}} @if($isGroupHidden)hidden @endif">
    <th>{{($list['label'])}}@if($list['required'])<i class="required">*</i>@endif</th>
    <td>
    @foreach($list As $fieldName => $rules)

    @php
        /* @var $rules */
        $maxLength = null;
        if(isset($rules['rule']) && $rules['rule']) {
            if(strpos($rules['rule'],'max') !== false) {
                preg_match('/max:(\d+)/', $rules['rule'], $ary);
                $maxLength = $ary[1];
            }
        }
    @endphp

        @switch($fieldName)

            @case('label')
            @case('required')
            @break

            @default
            @if(isset($rules['fieldType']))
                <div class="fields @if($rules['fieldType'] === 'input' && isset($rules['hidden']) && $rules['hidden'])hidden @endif">
                    @if($rules['fieldType'] === 'input')
                        @if(isset($rules['hidden']) && $rules['hidden'])
                            <x-molecules.input type="hidden" name="{{($fieldName)}}" id="{{($fieldName)}}" :value="old($fieldName, ($rules['value']) ?? '')" />
                        @else

                            @if($maxLength)
                                <x-molecules.input type="text" name="{{($fieldName)}}" id="{{($fieldName)}}" :value="old($fieldName, ($fEntUserApplyInfo->free[$fieldName]) ?? '')" maxlength="{{($maxLength)}}" />
                            @else
                                <x-molecules.input type="text" name="{{($fieldName)}}" id="{{($fieldName)}}" :value="old($fieldName, ($fEntUserApplyInfo->free[$fieldName]) ?? '')" />
                            @endif

                        @endif
                    @endif
                    @if($rules['fieldType'] === 'select')
                        <x-molecules.select for="{{($fieldName)}}" :list="$rules['master']??[]" :selected="old($fieldName, ($fEntUserApplyInfo->free[$fieldName]) ?? '')" />
                    @endif
                    <x-molecules.validation-errors :errors="$errors" for="{{($fieldName)}}" />
                </div>
            @endif
            @break
        @endswitch
    @endforeach
    </td>
</tr>