@extends ('pub_theme::layouts.app')

@php
//dddx(Auth::user());
//dddx(Auth::id());

/*dddx(
xotModel('club')
::get(['name', 'id'])
->toArray(),
);

dddx(
xotModel('club')
::get()
->pluck('name', 'id')
->toArray(),
);*/

//dddx(env('APP_URL'));
@endphp

@php
session()->put('timestamp_caricamento_schede', microtime(true));
//session()->getId()
//session('timestamp_caricamento_schede'));

$territorial_level_options = [];

if (Auth::user()->profile->getAttribute('province_id')) {
    //$territorial_level_options = [3 => 'Territoriale'];
    $territorial_level_options = xotModel('territorial_level')
        ->where('id', '>=', '3')
        ->get()
        ->pluck('name', 'id')
        ->toArray();
} elseif (Auth::user()->profile->getAttribute('region_id')) {
    //$territorial_level_options = [2 => 'Regionale', 3 => 'Territoriale'];
    $territorial_level_options = xotModel('territorial_level')
        ->where('id', '>=', '2')
        ->get()
        ->pluck('name', 'id')
        ->toArray();
} else {
    //$territorial_level_options = [1 => 'Nazionale', 2 => 'Regionale', 3 => 'Territoriale'];
    $territorial_level_options = xotModel('territorial_level')
        ->where('id', '>=', '1')
        ->get()
        ->pluck('name', 'id')
        ->toArray();
}

@endphp

@section('content')




    <div class="container-large">

        {!! Form::model($row, ['url' => Request::fullUrl(), 'id' => 'mainForm' /*, 'class' => 'form-inline'*/]) !!}
        @method('post')

        <div class="row">

            <div class="col-md-4">
                {{ Form::bsDate('upload_date', isset($row->upload_date) ? $row->upload_date : (object) ['year' => 0], ['value' => $row->upload_date, 'label' => 'Data di Inserimento', 'style' => 'width:100%', 'class' => 'control-label']) }}
            </div>

            <div class="col-md-4">
                {{ Form::bsText('description', $row->description, ['style' => 'width:100%', 'placeholder' => 'Descrizione', 'label' => 'Descrizione']) }}
            </div>

            <div dusk="select-territorio" class="col-md-4">
                {{ Form::bsSelect(
    'territorial_level',
    [],
    [
        'style' => 'width:100%',
        'label' => 'Livello',
        'placeholder' => 'Seleziona Territorio',
        'options' => $territorial_level_options,
    ],
) }}
            </div>
        </div>



        <div class="row">
            @if (Auth::user()->profile->getAttribute('region_id'))

                <div class="col-md-4" dusk="select-regione">
                    <div class="form-group col-sm-12">
                        {{ Form::label('region_id', 'Regione: ' . Auth::user()->profile->region->name, ['class' => 'control-label']) }}

                        {{ Form::hidden('region_id', Auth::user()->profile->region->id, ['name' => 'region_id', 'value' => Auth::user()->profile->region->id, 'class' => 'control-label']) }}

                    </div>

                </div>

            @else
                <div dusk="select-regione" class=" col-md-4 territory_1 d-none" id="region_id">
                    {{ Form::bsSelect(
    'region_id',
    [],
    [
        /*per mettere il valore inviato dal form precedente */

        'value' => $row->region_id,
        'style' => 'width:100%',
        'label' => 'Regione',
        'placeholder' => 'Regione',
        'options' => xotModel('region')
            ::orderBy('name', 'asc')->get(['name', 'id'])->pluck('name', 'id')->toArray(),
    ],
) }}
                </div>
            @endif

            @if (Auth::user()->profile->getAttribute('province_id'))
                <div class="col-md-4" dusk="select-provincia">
                    <div class="form-group col-sm-12">
                        {{ Form::label('province_id', 'Provincia: ' . Auth::user()->profile->province->name, ['class' => 'control-label']) }}

                        {{ Form::hidden('province_id', Auth::user()->profile->province->id, ['name' => 'province_id', 'value' => Auth::user()->profile->province->id, 'class' => 'control-label']) }}

                    </div>
                </div>
            @else

                <div dusk="select-provincia" class="col-md-4 territory_2 d-none" id="province_id">



                    @if (Auth::user()->profile->getAttribute('region_id'))



                        {{ Form::bsSelect(
    'province_id',
    [],
    [
        'value' => $row->province_id,
        'style' => 'width:100%',
        'label' => 'Provincia',
        'placeholder' => 'Provincia',
        'options' => xotModel('province')
            ::where('region_id', Auth::user()->profile->region->id)->orderBy('name', 'asc')->get(['name', 'id'])->pluck('name', 'id')->toArray(),
    ],
) }}


                    @else


                        {{ Form::bsSelect(
    'province_id',
    [],
    [
        'style' => 'width:100%',
        'label' => 'Provincia',
        'placeholder' => 'Provincia',
        'options' => [] /*xotModel('province')->get(['name', 'id'])->pluck('name', 'id')->toArray()*/,
    ],
) }}
                    @endif
                </div>
            @endif



            @if (Auth::user()->profile->getAttribute('club_id'))
                <div class="col-md-4" dusk="select-categoria">
                    <div class="form-group col-sm-12">
                        {{ Form::label('club_id', 'Categoria: ' . Auth::user()->profile->club->name, ['class' => 'control-label']) }}

                        {{ Form::hidden('club_id', Auth::user()->profile->club->id, ['name' => 'club_id', 'value' => Auth::user()->profile->club->id, 'class' => 'control-label']) }}


                    </div>
                </div>
            @else
                <div class="col-md-4" dusk="select-categoria">
                    {{ Form::bsSelect(
    'club_id',
    [],
    [
        'value' => $row->club_id,
        'style' => 'width:100%',
        'label' => 'Categoria',
        'placeholder' => 'Categoria',
        'options' => xotModel('club')
            ::where('territorial_only', '!=', '1')->orderBy('name', 'asc')->get(['name', 'id'])->pluck('name', 'id')->toArray(),
    ],
) }}
                </div>
            @endif
        </div>

        <div class="row">
            <div class="col-md-4">
                {{ Form::bsSelect(
    'archivio_schede_report_type_id',
    [],
    [
        'value' => $row->id,
        'style' => 'width:100%',
        'label' => 'Tipo Scheda',
        'placeholder' => 'File Raggruppati',
        'options' => xotModel('report_types')->where('parent_id', '!=', '0')->orderBy('position', 'asc')->get(['title', 'id'])->pluck('title', 'id')->toArray(),
    ],
) }}
            </div>

            <div class="col-md-2">
                {{ Form::bsSubmit('Cerca', [], ['dusk' => 'tasto-cerca', 'class' => 'form-control btn btn-danger', 'label' => 'Ricerca']) }}
            </div>

        </div>
        {!! Form::close() !!}




        @include('pub_theme::home.store.acts.archivio_schede')

    </div>
    <!--</div>-->

    <script>
        //sostituire con livewire
        function provinceInput(region_id) {


            const table = {!! xotModel('province')->orderBy('name', 'asc')->get(['name', 'id', 'region_id'])->toJson() !!};

            const filtered_results = table.filter((v) => {
                if (v.region_id == region_id) {
                    return v;
                }
            });



            return filtered_results;

        }


        function clubInput(bool_centro_regolatore) {

            let table = [];

            if (bool_centro_regolatore === true) {
                table = {!! xotModel('club')->orderBy('name', 'asc')->get(['name', 'id', 'region_id'])->toJson() !!};
            } else {
                table = {!! xotModel('club')->where('territorial_only', '!=', '1')->orderBy('name', 'asc')->get(['name', 'id', 'region_id'])->toJson() !!};
            }

            return table;

        }

        function rewriteClub(current_club_id) {

            let bool_centro_regolatore = false;

            let region = $("#mainForm [name='region_id']:visible option:selected").text();
            if (region === '') {
                @isset(Auth::user()->profile->region->name)
                    region = '{{ Auth::user()->profile->region->name }}';
                @endisset
            }
            let province = $("#mainForm [name='province_id']:visible option:selected").text();
            if (province === '') {
                @isset(Auth::user()->profile->province->name)
                    province = '{{ Auth::user()->profile->province->name }}';
                @endisset
            }

            if (region !== "" && region.toUpperCase() !== "REGIONE") {
                bool_centro_regolatore = true;
            }

            if (province !== "" && province.toUpperCase() !== "PROVINCIA") {
                bool_centro_regolatore = true;
            }


            let newOptions = clubInput(bool_centro_regolatore);

            let newOptionElements = "";

            newOptionElements += "<option value>Categoria</option>"

            newOptions.forEach((v) => {
                newOptionElements += "<option value='" + v["id"] + "'>" + v["name"] +
                    "</option>"
            });

            $('select#club_id').html(newOptionElements);

            $('select#club_id option[value="' + current_club_id + '"]').prop('selected', true);
        }



        document.addEventListener("DOMContentLoaded", function() {

            $("#mainForm [name='region_id'],#mainForm [name='province_id'],#mainForm [name='territorial_level']")
                .change(() => {
                    rewriteClub($('[name="club_id"]').val());
                });


            $('#region_id select').change(() => {

                let region_id = $('#region_id select').val();

                let newOptions = provinceInput(region_id);

                let newOptionElements = "";

                newOptionElements += "<option value>Provincia</option>"

                newOptions.forEach((v) => {
                    newOptionElements += "<option value='" + v["id"] + "'>" + v["name"] +
                        "</option>"
                });

                $('#province_id select').html(newOptionElements);

            });

            let region_id = $('[name="region_id"]').val();

            if (region_id) {

                let newOptions = provinceInput(region_id);

                let newOptionElements = "";

                newOptionElements += "<option value>Provincia</option>"

                newOptions.forEach((v) => {
                    newOptionElements += "<option value='" + v["id"] + "'>" + v["name"] +
                        "</option>"
                });

                $('#province_id select').html(newOptionElements);

                @isset($row->province_id)
                    $('#province_id select option[value="{{ $row->province_id }}"]').prop('selected',true);
                @endisset

            }

            $('select#territorial_level').change(() => {

                let territory_level = $('select#territorial_level').val();

                $('.territory_1').addClass('d-none');
                $('.territory_2').addClass('d-none');

                if (territory_level === '2') {
                    $('.territory_1').removeClass('d-none');
                    $('select#province_id').val("");
                } else if (territory_level === '3') {
                    $('.territory_1').removeClass('d-none');
                    $('.territory_2').removeClass('d-none');
                } else {
                    $('select#region_id').val("");
                    $('select#province_id').val("");
                }

            });

            @isset($row->territorial_level)
                $('select#territorial_level option[value="{{ $row->territorial_level }}"]').prop('selected',true);
                $('select#territorial_level').trigger('change');
            @endisset


            @if (isset($row->club_id))
                rewriteClub("{{ $row->club_id }}");
            @else
                rewriteClub();
            @endif

        });

        //--- fine sostituzione --//
    </script>
@endsection
