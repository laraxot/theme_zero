@php

session()->put('timestamp_caricamento_schede', microtime(true));
//session()->getId()
//session('timestamp_caricamento_schede'));

if (!empty(request()->input('upload_id'))) {
    //$current_upload_data
}

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

@extends ('pub_theme::layouts.app')

@section('content')


    <div class="container-large">

        {!! Form::model(null, ['url' => Request::fullUrl(), 'id' => 'mainForm' /*, 'class' => 'form-inline'*/]) !!}
        @method('post')

        <div class="row">
            <div class="col-md-4">
                {{ Form::bsDate('upload_date', \Carbon\Carbon::now(), ['label' => 'Data di Inserimento *', 'style' => 'width:100%', 'class' => 'control-label']) }}
            </div>

            <div class="col-md-4">
                {{ Form::bsText('description', '', ['style' => 'width:100%', 'placeholder' => 'Descrizione', 'label' => 'Descrizione *']) }}
            </div>

            <div class="col-md-4">
                {{ Form::bsSelect(
    'territorial_level',
    [],
    [
        'style' => 'width:100%',
        'label' => 'Seleziona Territorio *',
        'placeholder' => 'Seleziona Territorio',
        'options' => $territorial_level_options,
    ],
) }}
            </div>
        </div>

        <div class="row">
            @if (Auth::user()->profile->getAttribute('region_id'))

                <div class="col-md-4">
                    <div class="form-group col-sm-12">

                        {{ Form::label('region_id', 'Regione: ' . Auth::user()->profile->region->name, ['name' => 'region_id', 'value' => Auth::user()->profile->region->id, 'class' => 'control-label']) }}
                        {{ Form::hidden('region_id', Auth::user()->profile->region->id, ['name' => 'region_id', 'value' => Auth::user()->profile->region->id, 'class' => 'control-label']) }}

                    </div>

                </div>

            @else
                <div class="col-md-4 territory_1 d-none" id="region_id">
                    {{ Form::bsSelect(
    'region_id',
    [],
    [
        'style' => 'width:100%',
        'label' => 'Regione',
        'placeholder' => 'Regione',
        'options' => xotModel('region')
            ::orderBy('name', 'asc')->get(['name', 'id'])->pluck('name', 'id')->toArray(),
    ],
) }}
                </div>
            @endif

            </span>



            @if (Auth::user()->profile->getAttribute('province_id'))
                <div class="col-md-4">
                    <div class="form-group col-sm-12">

                        {{ Form::label('province_id', 'Provincia: ' . Auth::user()->profile->province->name, ['name' => 'province_id', 'value' => Auth::user()->profile->province->id, 'class' => 'control-label']) }}
                        {{ Form::hidden('province_id', Auth::user()->profile->province->id, ['name' => 'province_id', 'value' => Auth::user()->profile->province->id, 'class' => 'control-label']) }}

                    </div>
                </div>
            @else

                <div class="col-md-4 territory_2 d-none" id="province_id">



                    @if (Auth::user()->profile->getAttribute('region_id'))



                        {{ Form::bsSelect(
    'province_id',
    [],
    [
        'style' => 'width:100%',
        'label' => 'Provincia',
        'placeholder' => 'Provincia',
        'options' => xotModel('province')->where('region_id', Auth::user()->profile->region->id)->orderBy('name', 'asc')->get(['name', 'id'])->pluck('name', 'id')->toArray(),
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
                <div class="col-md-4">
                    <div class="form-group col-sm-12">

                        {{ Form::label('club_id', 'Categoria: ' . Auth::user()->profile->club->name, ['name' => 'club_id', 'value' => Auth::user()->profile->club->id, 'class' => 'control-label']) }}

                        {{ Form::hidden('club_id', Auth::user()->profile->club->id, ['name' => 'club_id', 'value' => Auth::user()->profile->club->id, 'class' => 'control-label']) }}

                    </div>
                </div>
            @else
                <div class="col-md-4">
                    {{ Form::bsSelect(
    'club_id',
    [],
    [
        'style' => 'width:100%',
        'label' => 'Categoria',
        'placeholder' => 'Categoria',
        'options' => xotModel('club')->where('territorial_only', '!=', '1')->orderBy('name', 'asc')->get(['name', 'id'])->pluck('name', 'id')->toArray(),
    ],
) }}


                </div>
            @endif
        </div>

        <div id="upload_progress" class="col-md-12 mt-3 mb-3 d-none">
            <h2 class="text-center">Caricamento in corso...</h2>
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
                    aria-valuemax="100">0%</div>
            </div>
        </div>

        <div id="upload_tab" class="col-md-12 mt-3">
            <table class="table table-hover table-striped">

                <tr>
                    <th class="col-md-9">Tipo</th>
                    <th class="col-md-1">File</th>
                    <th class="col-md-2">Flag</th>
                </tr>

                @php
                    //dddx($rows);
                @endphp

                @foreach ($rows as $row)

                    @can('viewRow', Panel::get($row))





                        {{-- $table->integer('report_type_id');
                    $table->text('path');
                    $table->text('title');
                    $table->text('description') --}}

                        <tr>
                            <td>{{ Form::hidden('report_type_id[]', $row->id) }}
                                <div class="text-left"><strong>{{ Str::upper($row->title) }}</strong></div>
                                <div>
                                    {{ Form::label('filelist_' . $row->id, 'File non selezionato', ['name' => 'filelist_' . $row->id, 'id' => 'filelist_' . $row->id, 'value' => '', 'class' => 'control-label font-italic', 'style' => 'display:block']) }}
                                </div>
                            </td>

                            <td> {{ Form::bsPlupload($row->id, [], ['class' => 'btn btn-danger']) }}{{-- Form::bsPdf($row->id) --}}
                            </td>
                            <td>{{ $row->id != 14 ? Form::bsCheckbox('purposal_flag[]', '', ['label' => 'Nessuna Proposta&nbsp;']) : '' }}
                            </td>
                        </tr>




                    @endcan
                @endforeach

            </table>
        </div>

        <div class="col-md-12 text-right">

            {{ Form::bsSubmitRightBigShowHide('Invia') }}
        </div>

        {!! Form::close() !!}


    </div>
    <!--</div>-->


    @php

    //dddx(Auth::user()->profile->region->name);
    /*dddx(
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       );*/
    @endphp

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

        function rewriteDescription() {
            let upload_data = $("#mainForm [name='upload_date']").val();

            let territorial_level = $("#mainForm [name='territorial_level']:visible option:selected").text();


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
            let club = $("#mainForm [name='club_id'] option:selected").text();
            if (club === '') {
                @isset(Auth::user()->profile->club->name)
                    club = '{{ Auth::user()->profile->club->name }}';
                @endisset
            }

            let temp_description = '';

            if (upload_data) {
                temp_description += upload_data;
            }

            if (territorial_level.toUpperCase() === "NAZIONALE") {
                temp_description += "_NAZIONALE";
            }

            if (region !== "" && region.toUpperCase() !== "REGIONE") {
                temp_description += "_" + region;
            }

            if (province !== "" && province.toUpperCase() !== "PROVINCIA") {
                temp_description += "_" + province;
            }

            if (club.toUpperCase() !== "CATEGORIA") {
                temp_description += "_" + club;
            }


            let description = convertToSlug(temp_description);

            $("#mainForm [name='description']").val(description.toUpperCase());

            $("#mainForm [name='description']").trigger('change');
        }

        function convertToSlug(Text) {
            return Text
                .toLowerCase()
                .replace(/ /g, '-')
                .replace(/[^\w-]+/g, '');
        }

        document.addEventListener("DOMContentLoaded", function() {


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

            $('select#territorial_level').change(() => {

                let territory_level = $('select#territorial_level').val();

                $('.territory_1').addClass('d-none');
                $('.territory_2').addClass('d-none');

                if (territory_level === '2') {
                    $('.territory_1').removeClass('d-none');
                } else if (territory_level === '3') {
                    $('.territory_1').removeClass('d-none');
                    $('.territory_2').removeClass('d-none');
                } else {
                    //$('#region_id select').html();
                }

                rewriteDescription();

            });

            $("#mainForm [name='upload_date'],#mainForm [name='region_id'],#mainForm [name='province_id'],#mainForm [name='club_id'],#mainForm [name='territorial_level']")
                .change(() => {
                    rewriteDescription();
                });

            $("#mainForm [name='region_id'],#mainForm [name='province_id'],#mainForm [name='territorial_level']")
                .change(() => {
                    rewriteClub($('[name="club_id"]').val());
                });

            rewriteDescription();

        });

        //--- fine sostituzione --//
    </script>

@endsection
