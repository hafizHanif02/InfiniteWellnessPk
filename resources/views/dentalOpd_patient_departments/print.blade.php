<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <title>@yield('title') | {{ getAppName() }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="google" content="notranslate">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="turbo-cache-control" content="no-cache">
    @php
        $settingValue = getSettingValue();
        \Carbon\Carbon::setlocale(config('app.locale'));
    @endphp
    <link rel="icon" href="{{ $settingValue['favicon']['value'] }}" type="image/png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="{{ asset('assets/css/third-party.css') }}" rel="stylesheet" type="text/css" />
    @if (getLoggedInUser()->thememode)
        <link href="{{ asset('assets/css/style.dark.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/plugins.dark.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/phone-number-dark.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
    @else
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
    @endif

    {{--    @livewireStyles --}}
    {{--    <script src="{{ asset('livewire/livewire.css') }}"></script> --}}
    @yield('css')
    @yield('page_css')
    {{--    <link href="{{ asset('css/pages.css') }}" rel="stylesheet" type="text/css"/> --}}
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />
    {{--    <link rel="stylesheet" href="{{ asset('assets/css/livewire-table.css') }}"> --}}
    @routes
    {{--        @livewireScripts --}}

    <script src="{{ asset('livewire/livewire.js') }}" data-turbolinks-eval="false" data-turbo-eval="false"></script>
    @include('livewire.livewire-turbo')
    <script src="{{ asset('js/turbo.js') }}" data-turbolinks-eval="false" data-turbo-eval="false"></script>
    <script src="{{ asset('assets/js/third-party.js') }}"></script>
    <script src="{{ asset('messages.js') }}"></script>
    <script src="{{ asset('js/pages.js') }}"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://npmcdn.com/flatpickr@4.5.2/dist/l10n"></script>

    @yield('page_scripts')
    <script>
        {{-- let defaultImage = "{{ asset('assets/img/avatar.png') }}"; --}}
            // const defaultImageUrl = '';
            (function($) {
                $.fn.button = function(action) {
                    if (action === 'loading' && this.data('loading-text')) {
                        this.data('original-text', this.html()).html(this.data('loading-text')).prop('disabled',
                            true)
                    }
                    if (action === 'reset' && this.data('original-text')) {
                        this.html(this.data('original-text')).prop('disabled', false)
                    }
                }
                $('#overlay-screen-lock').hide()
            }(jQuery))


        $('.alert').delay(5000).slideUp(300, function() {
            $('.alert').attr('style', 'display:none')
        })
    </script>
    @yield('scripts')
</head>

<body style="background: white;">


@include('dentalOpd_patient_departments.show_fields_print')
<script>

    $('.reload-page').on('click', function(event) {
        event.preventDefault();
        window.location.href = $(this).attr('href');
    });

    $(document).ready(function() {
            window.print();
            $('.alert').delay(5000).slideUp(300)
        })
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>

</body>

</html>
