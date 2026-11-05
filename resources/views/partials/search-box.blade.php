{{-- Поле глобального пошуку з випадаючим списком (public/assets/js/search/search.js). Окремої сторінки результатів немає. Приховане, якщо пошук вимкнено. --}}
@if (config('search.enabled'))
    @php
        $searchTexts = [
            'types' => [
                'game' => __('search.type_game'),
                'creator' => __('search.type_creator'),
                'company' => __('search.type_company'),
                'news' => __('search.type_news'),
                'category' => __('search.type_category'),
            ],
            'notFound' => __('search.not_found'),
            'enterQuery' => __('search.enter_query'),
            'tooShort' => __('search.too_short', ['count' => \App\Http\Requests\Pages\SearchRequest::MIN_LENGTH]),
            'unavailable' => __('search.unavailable'),
        ];
    @endphp
    <form class="hs-search" role="search" novalidate data-hs-search data-suggest-url="{{ route('search.suggest') }}" data-texts="{{ json_encode($searchTexts, JSON_UNESCAPED_UNICODE) }}">
        <label class="hs-sr" for="hs-q-{{ $suffix ?? 'd' }}">{{ __('search.input_label') }}</label>
        <input id="hs-q-{{ $suffix ?? 'd' }}" type="search" name="q" maxlength="{{ config('search.max_query_length') }}" autocomplete="off"
               placeholder="{{ __('search.placeholder') }}" aria-autocomplete="list" aria-expanded="false" aria-describedby="hs-msg-{{ $suffix ?? 'd' }}">
        <button type="submit" class="hs-search__btn" aria-label="{{ __('search.button') }}">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
        </button>
        <ul class="hs-search__list" id="hs-msg-{{ $suffix ?? 'd' }}" role="listbox" hidden></ul>
    </form>
@endif
