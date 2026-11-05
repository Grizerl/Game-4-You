{{--
    Обкладинка з адаптивною подачею без обгортки <picture> (вона ламала розкладку hero): мобільний WebP
    (thumb_mobile / large_mobile) отримують вікна до 720 px, десктопний — решта. Це забезпечує srcset із
    w-дескрипторами та sizes: у вікнах до 720 px слот «1px» — браузер бере найменший кандидат (мобільний),
    у ширших — слот величезний, і береться найбільший (десктопний). Якщо мобільного conversion немає,
    виводиться звичайний <img>.
    Використання: <x-cover :model="$game" kind="thumb" alt="..." loading="lazy" width="300" height="450" />
--}}
@props(['model', 'kind' => 'thumb'])

@php($sources = $model->imageSources($kind))

@if ($sources['mobile'])
    <img src="{{ $sources['desktop'] }}"
         srcset="{{ $sources['mobile'] }} {{ $sources['mobile_width'] }}w, {{ $sources['desktop'] }} {{ $sources['desktop_width'] }}w"
         sizes="(max-width: 720px) 1px, 100000px"
         {{ $attributes }}>
@else
    <img src="{{ $sources['desktop'] }}" {{ $attributes }}>
@endif
