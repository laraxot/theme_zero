@php
//se togli da themes le route di default cioè Themes/Zero/Resources/views/profiles/edit
//ti viene fuori un dddx con le route possibili per l'azione edit, cioè
//tra cui pub_theme::profiles.edit, clubreport::profile.edit e pub_theme::layouts.default.edit
@endphp

@extends('pub_theme::layouts.app')
@section('content')

    <div class="container-large">

        <div class="col-md-12">

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $k => $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @php
                if (!is_object($row)) {
                    return '';
                }
                $fields = $_panel->getFields(['act' => 'edit']);
            @endphp
            {!! Form::bsOpenPanel($_panel, 'update') !!}
            <div class="row">
                @foreach ($fields as $field)
                    {!! Theme::inputHtml(['row' => $row, 'field' => $field]) !!}
                @endforeach
            </div>
            {{ Form::bsSubmit('Modifica') }}
            {!! Form::close() !!}
        </div>


    </div>



@endsection
{{-- @include('theme::layouts.default.common.action') --}}
