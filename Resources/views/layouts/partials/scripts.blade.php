<script>
    var base_url = '{{ Theme::asset('') }}';
    var lang = '{{ \App::getLocale() }}';
    {{-- var google_maps_api='{{ config('xra.google.maps.api') }}'; --}}
    @if (\Request::has('address'))
        var address ="{{ \Request::input('address') }}";
    @endif
    @if (\Request::has('lat') && \Request::has('lng'))
        var lat ="{{ \Request::input('lat') }}";
        var lng ="{{ \Request::input('lng') }}";
    @endif
</script>
@stack('scripts_before')
@php
// Bootstrap core JavaScript
//Theme::add('/theme/pub/vendor/jquery/jquery.min.js',1);
/*
 Theme::add("/theme/bc/jquery/dist/jquery.min.js",1);

 Theme::add('/theme/vendor/bootstrap/js/bootstrap.bundle.min.js',2);
 //Core plugin JavaScript
 Theme::add('/theme/vendor/jquery-easing/jquery.easing.min.js',3);
 //Custom scripts for all pages
 Theme::add('/theme/js/sb-admin-2.min.js',4);
 Theme::add('/theme/js/xot.js');
*/
Theme::add('pub_theme::dist/js/manifest.js', 1);
Theme::add('pub_theme::dist/js/vendor.js', 2);
Theme::add('pub_theme::dist/js/app.js', 3);
@endphp

@livewireScripts
{!! Theme::showScripts(false) !!}
@stack('scripts')
