<div class="d-flex justify-content-center pt-3 pt-sm-0 justify-content-sm-start">
    
    @foreach(config('app.all_locales') as $locale_name => $locale_code)
        
        @if($locale_code === session('app_locale', config('app.locale')))
            <span class="mx-2 text-secondary font-weight-bold">{{ $locale_name }}</span>
        @else
            <a class="mx-2 text-decoration-underline" href="{{ route('change.locale', $locale_code) }}">
                <span>{{ $locale_name }}</span>
            </a>
        @endif
    
    @endforeach

    {{-- <span class="ms-3">Langue actuelle : {{ session('app_locale', config('app.locale')) }} (App: {{ App::getLocale() }})</span> --}}

</div>
