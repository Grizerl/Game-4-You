<footer>
    <div style="padding: 40px 0px;">
        <div class="container">
            <div class="footer-top">
                <div class="footer-item">
                    <a class="footer-brand" href="{{route('home.page')}}">Games 4 <span class="footer-brand-aside">You</span></a>
                    <p class="footer-lead">{{ __('footer.description') }}</p>
                    <ul class="lang-switcher">
                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <li>
                                <a class="lang-link" 
                                rel="alternate" 
                                hreflang="{{ $localeCode }}" 
                                href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                    {{ $properties['native'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="footer-item">
                    <h5 class="footer-title">{{ __('footer.quick_links') }}</h5>
                    <ul class="footer-list">
                        <li class="footer-nav-item">
                            <a class="footer-nav-link" href="{{ route('games.page') }}">{{ __('footer.gaming') }}</a>
                        </li>
                        <li class="footer-nav-item">
                            <a class="footer-nav-link" href="{{ route('company.page') }}">{{ __('footer.company') }}</a>
                        </li>
                        <li class="footer-nav-item">
                            <a class="footer-nav-link" href="#">{{ __('footer.social') }}</a>
                        </li>
                        <li class="footer-nav-item">
                            <a class="footer-nav-link" href="#">{{ __('footer.community') }}</a>
                        </li>
                    </ul>
                </div>
                <div class="footer-item">
                    <h5 class="footer-title">{{ __('footer.supports') }}</h5>
                    <ul class="footer-list">
                        <li class="footer-nav-item">
                            <a class="footer-nav-link" href="#">{{ __('footer.settings') }}</a>
                        </li>
                        <li class="footer-nav-item">
                            <a class="footer-nav-link" href="#">{{ __('footer.help') }}</a>
                        </li>
                        <li class="footer-nav-item">
                            <a class="footer-nav-link" href="#">{{ __('footer.live') }}</a>
                        </li>
                        <li class="footer-nav-item">
                            <a class="footer-nav-link" href="#">{{ __('footer.news') }}</a>
                        </li>
                    </ul>
                </div>
                <div class="footer-item">
                    <h5 class="footer-title">{{ __('footer.newsletter') }}</h5>
                    <p class="footer-lead">  {{ __('footer.subscribe_text') }}</p>
                    <div class="pole-container">
                        <input class="input-email" name="email" type="email" placeholder="Your email address">
                        <button class="svg-btn">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" style="enable-background:new 0 0 24 24;" height="24" width="24" version="1.1" viewBox="0 0 24 24" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <g id="info"/><g id="icons"><path d="M21.5,11.1l-17.9-9C2.7,1.7,1.7,2.5,2.1,3.4l2.5,6.7L16,12L4.6,13.9l-2.5,6.7c-0.3,0.9,0.6,1.7,1.5,1.2l17.9-9   C22.2,12.5,22.2,11.5,21.5,11.1z" id="send"/>
                                </g>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>