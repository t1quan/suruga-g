@props(['date','format' => 'Y年m月d日'])

{{date($format,strtotime($date))}}