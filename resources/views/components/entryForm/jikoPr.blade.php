@props(['fEntUserApplyInfo', 'items', 'isOpen'])

<section>
    <small>▼クリックで開閉</small>
    <p class="toggleSwitchApply {{$isOpen ? 'open' : 'close'}}">自己PR</p>
    <div  class="body {{$isOpen ? 'open' : 'close'}}">
        @if($items['pr']['pr']['required'])<i class="required">*</i>@endif
        <textarea name="pr" placeholder="" id="pr">{{old('pr', $fEntUserApplyInfo->jikoPr ?? '')}}</textarea>
        <small>最大1000文字まで</small>
        <x-molecules.validation-errors :errors="$errors" for="pr" />
    </div>
</section>