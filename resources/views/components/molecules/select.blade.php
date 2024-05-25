
@props([
    'defaultKey' => '--',
    'defaultValue' => '',
    'selected' => '',
    'list' => [],
    'groupList' => [],
    'kbnList' => [],
    'for',
])

@php
// 以下の考慮のためリスト別に選択状態の制御を加える
// マスタの値が0のものがある場合に未選択の空文字と評価を分けるために型一致で評価する
// option valueがリクエストを跨ぐとstringにキャストされることで型一致しなくなる
if(isset($selected)){
    $isSelected = '';
    $optionHtml = '';
    $options = array();
    if(isset($groupList) && count($groupList) > 0){
        foreach($groupList as $k => $list){
            $options[] = "<optgroup label='$k'>";
            foreach($list as $key => $value){
                $option = $key;
                switch(gettype($option)){
                    case 'integer':
                        $isSelected = ((int)$selected === (int)$option and $selected !== '')  ? 'selected="selected"' : '';
                        break;
                    case 'string':
                        $isSelected = ((string)$selected === (string)$option and $selected !== '') ? 'selected="selected"' : '';
                        break;
                    default:
                        break;
                }
                $options[] = '<option value="'.$key.'" '. $isSelected. '>'.$value.'</option>';
            }
            $options[] = "</optgroup>";
        }
    }elseif(isset($kbnList) && count($kbnList) > 0){
        foreach($kbnList as $fEntMst){
            $option = $fEntMst->value;
            switch(gettype($option)){
                case 'integer':
                        $isSelected = ((int)$selected === (int)$option and $selected !== '')  ? 'selected="selected"' : '';
                    break;
                case 'string':
                    $isSelected = ((string)$selected === (string)$option and $selected !== '') ? 'selected="selected"' : '';
                    break;
                default:
                    break;
            }
            $options[] = '<option value="'.$fEntMst->value.'" '. $isSelected. '>'.$fEntMst->name.'</option>';
        }
    }elseif(isset($list) && count($list) > 0){
        foreach($list as $key => $value){
            $option = $key;
            switch(gettype($option)){
                case 'integer':
                        $isSelected = ((int)$selected === (int)$option and $selected !== '')  ? 'selected="selected"' : '';
                    break;
                case 'string':
                    $isSelected = ((string)$selected === (string)$option and $selected !== '') ? 'selected="selected"' : '';
                    break;
                default:
                    break;
            }
            $options[] = '<option value="'.$key.'" '. $isSelected. '>'.$value.'</option>';
        }
    }
    if(count($options) > 0){
        $optionHtml = implode("", $options);
    }
}
@endphp

<select {{ $attributes->merge(['class' => 'form-control']) }} id="{{ $for }}" name="{{ $for }}">
    @if($defaultValue === '' and isset($defaultKey))
    <option value="">{{$defaultKey}}</option>
    @endif
    {!! $optionHtml ?? '' !!}
</select>
