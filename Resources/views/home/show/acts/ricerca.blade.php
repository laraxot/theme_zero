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
@endphp

@section('content')

    <!--<div>
                                                                                                                    <livewire:clubreport::tendina />
                                                                                                                </div>-->


    <div class="container-large">

        <div class="row clearfix">

            <div class="col-md-12 p-3">

                @php
                    //dddx($row->region_id);
                @endphp

                {!! Form::model($row, ['url' => Request::fullUrl(), 'id' => 'mainForm', 'class' => 'form-inline']) !!}
                @method('post')

                <div class="col-md-3">
                    {{ Form::bsDate('upload_date', isset($row->upload_date) ? $row->upload_date : (object) ['year' => 0], ['value' => $row->upload_date, 'label' => 'Data di Inserimento', 'style' => 'width:100%', 'class' => 'control-label']) }}
                </div>

                @php
                    // dddx($row);
                @endphp
                <div class="col-md-3">
                    {{ Form::bsText('description', $row->description, ['style' => 'width:100%', 'placeholder' => 'Descrizione', 'label' => 'Descrizione']) }}
                </div>

                <div class="col-md-6"> &nbsp;</div>

                @if (Auth::user()->profile->getAttribute('region_id'))

                    <div class="col-md-3">
                        <div class="form-group col-sm-12">

                            {{ Form::label('region_id', 'Regione: ' . Auth::user()->profile->region->name, ['name' => 'region_id', 'value' => Auth::user()->profile->region->id, 'class' => 'control-label']) }}

                        </div>

                    </div>

                @else
                    <div class="col-md-3" id="region_id">
                        {{ Form::bsSelect(
    'region_id',
    [],
    [
        /*per mettere il valore inviato dal form precedente */
        'value' => $row->region_id,
        'style' => 'width:100%',
        'label' => ' ',
        'placeholder' => 'Regione',
        'options' => xotModel('region')
            ::get(['name', 'id'])->pluck('name', 'id')->toArray(),
    ],
) }}
                    </div>
                @endif

                @if (Auth::user()->profile->getAttribute('province_id'))
                    <div class="col-md-3">
                        <div class="form-group col-sm-12">

                            {{ Form::label('province_id', 'Provincia: ' . Auth::user()->profile->province->id, ['name' => 'province_id', 'value' => Auth::user()->profile->province->id, 'class' => 'control-label']) }}

                        </div>
                    </div>
                @else

                    <div class="col-md-3" id="province_id">



                        @if (Auth::user()->profile->getAttribute('region_id'))



                            {{ Form::bsSelect(
    'province_id',
    [],
    [
        'value' => $row->province_id,
        'style' => 'width:100%',
        'label' => ' ',
        'placeholder' => 'Provincia',
        'options' => xotModel('province')
            ::where('region_id', Auth::user()->profile->region->id)->get(['name', 'id'])->pluck('name', 'id')->toArray(),
    ],
) }}
                        @else


                            {{ Form::bsSelect(
    'province_id',
    [],
    [
        'style' => 'width:100%',
        'label' => ' ',
        'placeholder' => 'Provincia',
        'options' => [] /*xotModel('province')->get(['name', 'id'])->pluck('name', 'id')->toArray()*/,
    ],
) }}
                        @endif
                    </div>
                @endif



                @if (Auth::user()->profile->getAttribute('club_id'))
                    <div class="col-md-3">
                        <div class="form-group col-sm-12">

                            {{ Form::label('club_id', 'Categoria: ' . Auth::user()->profile->club->name, ['name' => 'club_id', 'value' => Auth::user()->profile->club->id, 'class' => 'control-label']) }}


                        </div>
                    </div>
                @else
                    <div class="col-md-3">
                        {{ Form::bsSelect(
    'club_id',
    [],
    [
        'value' => $row->club_id,
        'style' => 'width:100%',
        'label' => ' ',
        'placeholder' => 'Categoria',
        'options' => xotModel('club')
            ::get(['name', 'id'])->pluck('name', 'id')->toArray(),
    ],
) }}
                    </div>
                @endif




                {{ Form::bsSubmit('Cerca', [], ['class' => 'btn btn-danger']) }}

                {!! Form::close() !!}
            </div>
        </div>
    </div>


    @include('pub_theme::home.store.acts.archivio_schede')


    <script>
        //sostituire con livewire
        function provinceInput(region_id) {


            const table = {!! xotModel('province')->get(['name', 'id', 'region_id'])->toJson() !!};

            const filtered_results = table.filter((v) => {
                if (v.region_id == region_id) {
                    return v;
                }
            });



            return filtered_results;

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
        });

        //--- fine sostituzione --//
    </script>
@endsection
