<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') | {{getAppName()}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="google" content="notranslate">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="turbo-cache-control" content="no-cache">
    @php
        $settingValue = getSettingValue();
        \Carbon\Carbon::setlocale(config('app.locale'));
    @endphp
    <link rel="icon" href="{{ $settingValue['favicon']['value'] }}" type="image/png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>
    <link href="{{ asset('assets/css/third-party.css') }}" rel="stylesheet" type="text/css"/>
    @if(getLoggedInUser()->thememode)
        <link href="{{ asset('assets/css/style.dark.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/css/plugins.dark.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/css/phone-number-dark.css') }}" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
    @else
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet" type="text/css"/>

    @endif

{{--    @livewireStyles--}}

    @yield('css')
    @yield('page_css')
{{--    <link href="{{ asset('css/pages.css') }}" rel="stylesheet" type="text/css"/>--}}
        <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css"/>
    {{--    <link rel="stylesheet" href="{{ asset('assets/css/livewire-table.css') }}">--}}
    @routes
<!--{{--        @livewireScripts--}}-->
    
<!--    @include('livewire.livewire-turbo')-->


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
    {{Form::hidden('defaultImage',asset('assets/img/avatar.png'),['class'=>'defaultImage'])}}
    {{Form::hidden('defaultImageUrl','',['class'=>'defaultImageUrl'])}}
    {{Form::hidden('profileUrl',url('profile'),['class'=>'profileUrl'])}}
    {{Form::hidden('profileUpdateUrl',url('profile-update'),['class'=>'profileUpdateUrl'])}}
    {{Form::hidden('changePasswordUrl',url('change-password'),['class'=>'changePasswordUrl'])}}
    {{Form::hidden('loggedInUserId',getLoggedInUserId(),['class'=>'loggedInUserId'])}}
    {{Form::hidden('updateLanguageURL', url('update-language'),['class'=>'updateLanguageURL'])}}
    {{Form::hidden('currentCurrency',getCurrencySymbol(),['class'=>'currentCurrency'])}}
    {{Form::hidden('getCurrentCurrency',getCurrentCurrency(),['class'=>'getCurrentCurrency'])}}
    {{Form::hidden('getISOCode',getISOCode(),['class'=>'getISOCode'])}}
    {{Form::hidden('getCountryCode',getCountryCode(),['class'=>'getCountryCode'])}}
    {{Form::hidden('pdfDocumentImageUrl',url('assets/img/pdf.png'),['class'=>'pdfDocumentImageUrl'])}}
    {{Form::hidden('docxDocumentImageUrl',url('assets/img/doc.png'),['class'=>'docxDocumentImageUrl'])}}
    {{Form::hidden('audioDocumentImageUrl',url('assets/img/audio.png'),['class'=>'audioDocumentImageUrl'])}}
    {{Form::hidden('videoDocumentImageUrl',url('assets/img/video.png'),['class'=>'videoDocumentImageUrl'])}}
    {{Form::hidden('ajaxCallIsRunning',false,['class'=>'ajaxCallIsRunning'])}}
    {{Form::hidden('userCurrentLanguage',getLoggedInUser()->language,['class'=>'userCurrentLanguage'])}}
    {{Form::hidden('sweetAlertIcon',asset('assets/images/remove.png'),['class'=>'sweetAlertIcon'])}}
    {{ Form::hidden('deleteVariable', __('messages.common.delete'), ['class' => 'deleteVariable']) }}
    {{ Form::hidden('yesVariable', __('messages.common.yes'), ['class' => 'yesVariable']) }}
    {{ Form::hidden('noVariable', __('messages.common.no'), ['class' => 'noVariable']) }}
    {{ Form::hidden('cancelVariable', __('messages.common.cancel'), ['class' => 'cancelVariable']) }}
    {{ Form::hidden('confirmVariable', __('messages.common.are_you_sure_want_to_delete_this'), ['class' => 'confirmVariable']) }}
    {{ Form::hidden('deletedVariable', __('messages.common.deleted'), ['class' => 'deletedVariable']) }}
    {{ Form::hidden('hasBeenDeletedVariable', __('messages.common.has_been_deleted'), ['class' => 'hasBeenDeletedVariable']) }}
    {{ Form::hidden('okVariable', __('messages.common.ok'), ['class' => 'okVariable']) }}
</div>
</body>
</html>
