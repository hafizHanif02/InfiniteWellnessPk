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
    <link rel="icon" href="https://app.infinitewellnesspk.com/logo.png" type="image/png">
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
    <style>
        .myBtnPrimary{
            background-color: #0000ff;
            border-color: #6571ff;
            border: 1px solid transparent;
            color: #fff;
            border-radius: 0.313rem;
            cursor: pointer;
            display: inline-block;
            font-size: .875rem;
            font-weight: 400;
            line-height: 1.5;
            padding: 0.563rem 1.563rem;
            text-align: center;
            text-decoration: none;
            transition: color .15s ease-in-out,
            background-color .15s ease-in-out,
            border-color .15s ease-in-out,
            box-shadow .15s ease-in-out;
        }

        .myBtnPrimary:hover {
            background-color: #6571ff;
            color: #fff;
            border-color: #6571ff;
        }
        .myBtnDanger{
            background-color: #f62947;
            border-color: #f62947;
            border: 1px solid transparent;
            color: #fff;
            border-radius: 0.313rem;
            cursor: pointer;
            display: inline-block;
            font-size: .875rem;
            font-weight: 400;
            line-height: 1.5;
            padding: 0.563rem 1.563rem;
            text-align: center;
            text-decoration: none;
            transition: color .15s ease-in-out,
            background-color .15s ease-in-out,
            border-color .15s ease-in-out,
            box-shadow .15s ease-in-out;
        }

        .myBtnDanger:hover {
            background-color: #d1233c;
            border-color: #b91f35;
            color: #fff;
        }
        .myBtnSecondary{
            background-color: #adb5bd;
            border-color: #adb5bd;
            border: 1px solid transparent;
            color: #080808;
            border-radius: 0.313rem;
            cursor: pointer;
            display: inline-block;
            font-size: .875rem;
            font-weight: 400;
            line-height: 1.5;
            padding: 0.563rem 1.563rem;
            text-align: center;
            text-decoration: none;
            transition: color .15s ease-in-out,
            background-color .15s ease-in-out,
            border-color .15s ease-in-out,
            box-shadow .15s ease-in-out;
        }

        .myBtnSecondary:hover {
            background-color: #b9c0c7;
            border-color: #b5bcc4;
            color: #000000;
        }
        .myBtnSuccess{
            background-color: #0ac074;
            border-color: #0ac074;
            border: 1px solid transparent;
            color: #ffffff;
            border-radius: 0.313rem;
            cursor: pointer;
            display: inline-block;
            font-size: .875rem;
            font-weight: 400;
            line-height: 1.5;
            padding: 0.563rem 1.563rem;
            text-align: center;
            text-decoration: none;
            transition: color .15s ease-in-out,
            background-color .15s ease-in-out,
            border-color .15s ease-in-out,
            box-shadow .15s ease-in-out;
        }

        .myBtnSuccess:hover {
            background-color: #2fc989;
            border-color: #23c682;
            color: #ffffff;
        }
        .myBtnWarning{
            background-color: #ffb821;
            border-color: #ffb821;
            border: 1px solid transparent;
            color: #000000;
            border-radius: 0.313rem;
            cursor: pointer;
            display: inline-block;
            font-size: .875rem;
            font-weight: 400;
            line-height: 1.5;
            padding: 0.563rem 1.563rem;
            text-align: center;
            text-decoration: none;
            transition: color .15s ease-in-out,
            background-color .15s ease-in-out,
            border-color .15s ease-in-out,
            box-shadow .15s ease-in-out;
        }

        .myBtnWarning:hover {
            background-color: #ffc342;
            border-color: #ffbf37;
            color: #000000;
        }
    </style>
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
        $(document).ready(function() {
            $('.alert').delay(5000).slideUp(300)
        })

        $('.alert').delay(5000).slideUp(300, function() {
            $('.alert').attr('style', 'display:none')
        })
    </script>
    @yield('scripts')
    <style>
        .myBtnPrimary{
            background-color: #0000ff;
            border-color: #6571ff;
            border: 1px solid transparent;
            color: #fff;
            border-radius: 0.313rem;
            cursor: pointer;
            display: inline-block;
            font-size: .875rem;
            font-weight: 400;
            line-height: 1.5;
            padding: 0.563rem 1.563rem;
            text-align: center;
            text-decoration: none;
            transition: color .15s ease-in-out,
            background-color .15s ease-in-out,
            border-color .15s ease-in-out,
            box-shadow .15s ease-in-out;
        }

        .myBtnPrimary:hover {
            background-color: #6571ff;
            color: #fff;
            border-color: #6571ff;
        }
        .myBtnDanger{
            background-color: #f62947;
            border-color: #f62947;
            border: 1px solid transparent;
            color: #fff;
            border-radius: 0.313rem;
            cursor: pointer;
            display: inline-block;
            font-size: .875rem;
            font-weight: 400;
            line-height: 1.5;
            padding: 0.563rem 1.563rem;
            text-align: center;
            text-decoration: none;
            transition: color .15s ease-in-out,
            background-color .15s ease-in-out,
            border-color .15s ease-in-out,
            box-shadow .15s ease-in-out;
        }

        .myBtnDanger:hover {
            background-color: #d1233c;
            border-color: #b91f35;
            color: #fff;
        }
        .myBtnSecondary{
            background-color: #adb5bd;
            border-color: #adb5bd;
            border: 1px solid transparent;
            color: #080808;
            border-radius: 0.313rem;
            cursor: pointer;
            display: inline-block;
            font-size: .875rem;
            font-weight: 400;
            line-height: 1.5;
            padding: 0.563rem 1.563rem;
            text-align: center;
            text-decoration: none;
            transition: color .15s ease-in-out,
            background-color .15s ease-in-out,
            border-color .15s ease-in-out,
            box-shadow .15s ease-in-out;
        }

        .myBtnSecondary:hover {
            background-color: #b9c0c7;
            border-color: #b5bcc4;
            color: #000000;
        }
        .myBtnSuccess{
            background-color: #0ac074;
            border-color: #0ac074;
            border: 1px solid transparent;
            color: #ffffff;
            border-radius: 0.313rem;
            cursor: pointer;
            display: inline-block;
            font-size: .875rem;
            font-weight: 400;
            line-height: 1.5;
            padding: 0.563rem 1.563rem;
            text-align: center;
            text-decoration: none;
            transition: color .15s ease-in-out,
            background-color .15s ease-in-out,
            border-color .15s ease-in-out,
            box-shadow .15s ease-in-out;
        }

        .myBtnSuccess:hover {
            background-color: #2fc989;
            border-color: #23c682;
            color: #ffffff;
        }
        .myBtnWarning{
            background-color: #ffb821;
            border-color: #ffb821;
            border: 1px solid transparent;
            color: #000000;
            border-radius: 0.313rem;
            cursor: pointer;
            display: inline-block;
            font-size: .875rem;
            font-weight: 400;
            line-height: 1.5;
            padding: 0.563rem 1.563rem;
            text-align: center;
            text-decoration: none;
            transition: color .15s ease-in-out,
            background-color .15s ease-in-out,
            border-color .15s ease-in-out,
            box-shadow .15s ease-in-out;
        }

        .myBtnWarning:hover {
            background-color: #ffc342;
            border-color: #ffbf37;
            color: #000000;
        }
    </style>
</head>

<body>
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-row flex-column-fluid">
            @include('layouts.sidebar')
            <div class="wrapper d-flex flex-column flex-row-fluid">
                <div class='container-fluid d-flex align-items-stretch justify-content-between px-0'>
                    @include('layouts.header')
                </div>
                <div class='content d-flex flex-column flex-column-fluid pt-7'>
                    @yield('header_toolbar')
                    <div class='d-flex flex-column-fluid'>
                        @yield('content')
                    </div>
                </div>
                <div class='container-fluid'>
                    @include('layouts.footer')
                </div>
            </div>

            @include('user_profile.edit_profile_modal')
            @include('user_profile.change_password_modal')
        </div>
        {{ Form::hidden('defaultImage', asset('assets/img/avatar.png'), ['class' => 'defaultImage']) }}
        {{ Form::hidden('defaultImageUrl', '', ['class' => 'defaultImageUrl']) }}
        {{ Form::hidden('profileUrl', url('profile'), ['class' => 'profileUrl']) }}
        {{ Form::hidden('profileUpdateUrl', url('profile-update'), ['class' => 'profileUpdateUrl']) }}
        {{ Form::hidden('changePasswordUrl', url('change-password'), ['class' => 'changePasswordUrl']) }}
        {{ Form::hidden('loggedInUserId', getLoggedInUserId(), ['class' => 'loggedInUserId']) }}
        {{ Form::hidden('updateLanguageURL', url('update-language'), ['class' => 'updateLanguageURL']) }}
        {{ Form::hidden('currentCurrency', getCurrencySymbol(), ['class' => 'currentCurrency']) }}
        {{ Form::hidden('getCurrentCurrency', getCurrentCurrency(), ['class' => 'getCurrentCurrency']) }}
        {{ Form::hidden('getISOCode', getISOCode(), ['class' => 'getISOCode']) }}
        {{ Form::hidden('getCountryCode', getCountryCode(), ['class' => 'getCountryCode']) }}
        {{ Form::hidden('pdfDocumentImageUrl', url('assets/img/pdf.png'), ['class' => 'pdfDocumentImageUrl']) }}
        {{ Form::hidden('docxDocumentImageUrl', url('assets/img/doc.png'), ['class' => 'docxDocumentImageUrl']) }}
        {{ Form::hidden('audioDocumentImageUrl', url('assets/img/audio.png'), ['class' => 'audioDocumentImageUrl']) }}
        {{ Form::hidden('videoDocumentImageUrl', url('assets/img/video.png'), ['class' => 'videoDocumentImageUrl']) }}
        {{ Form::hidden('ajaxCallIsRunning', false, ['class' => 'ajaxCallIsRunning']) }}
        {{ Form::hidden('userCurrentLanguage', getLoggedInUser()->language, ['class' => 'userCurrentLanguage']) }}
        {{ Form::hidden('sweetAlertIcon', asset('assets/images/remove.png'), ['class' => 'sweetAlertIcon']) }}
        {{ Form::hidden('deleteVariable', __('messages.common.delete'), ['class' => 'deleteVariable']) }}
        {{ Form::hidden('yesVariable', __('messages.common.yes'), ['class' => 'yesVariable']) }}
        {{ Form::hidden('noVariable', __('messages.common.no'), ['class' => 'noVariable']) }}
        {{ Form::hidden('cancelVariable', __('messages.common.cancel'), ['class' => 'cancelVariable']) }}
        {{ Form::hidden('confirmVariable', __('messages.common.are_you_sure_want_to_delete_this'), ['class' => 'confirmVariable']) }}
        {{ Form::hidden('deletedVariable', __('messages.common.deleted'), ['class' => 'deletedVariable']) }}
        {{ Form::hidden('hasBeenDeletedVariable', __('messages.common.has_been_deleted'), ['class' => 'hasBeenDeletedVariable']) }}
        {{ Form::hidden('okVariable', __('messages.common.ok'), ['class' => 'okVariable']) }}
    </div>
    <script>

        // $('.reload-page').on('click', function(event) {
        //     event.preventDefault();
        //     window.location.href = $(this).attr('href');
        // });

    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>

</body>

</html>
