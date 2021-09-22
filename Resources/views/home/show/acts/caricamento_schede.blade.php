@extends ('pub_theme::layouts.app')

@section('content')


    <div class="container-large">

        <div class="row clearfix">

            <div class="col-md-12 mt-3">

                @php
                    //dddx(get_defined_vars());
                @endphp

                {!! Form::model(null, ['url' => Request::fullUrl(), 'id' => 'mainForm', 'class' => 'form-inline']) !!}
                @method('post')






                <div class="col-md-3">
                    {{ Form::bsDate('upload_date', \Carbon\Carbon::now(), ['label' => 'Data di Inserimento', 'style' => 'width:100%', 'class' => 'control-label']) }}
                </div>

                <div class="col-md-6">
                    {{ Form::bsText('description', '', ['style' => 'width:100%', 'placeholder' => 'Descrizione', 'label' => 'Descrizione']) }}
                </div>


                <div class="col-md-3"> &nbsp;</div>

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
        'style' => 'width:100%',
        'label' => ' ',
        'placeholder' => 'Categoria',
        'options' => xotModel('club')
            ::get(['name', 'id'])->pluck('name', 'id')->toArray(),
    ],
) }}
                    </div>
                @endif

                <div class="col-md-12 mt-3">
                    <table class="table table-hover table-striped">

                        <tr>
                            <th>Tipo</th>

                            <th>File</th>
                            <th>Flag</th>
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
                                        <div class="text-left">{{ $row->title }}</div>
                                    </td>

                                    <td>{{ Form::bsPdf($row->id) }}</td>
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
        </div>
    </div>




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

        function convertToSlug(Text) {
            return Text
                .toLowerCase()
                .replace(/ /g, '-')
                .replace(/[^\w-]+/g, '');
        }

        document.addEventListener("DOMContentLoaded", function() {

            $("#mainForm [name='upload_date'],#mainForm [name='region_id'],#mainForm [name='province_id'],#mainForm [name='club_id']")
                .change(() => {
                    let upload_data = $("#mainForm [name='upload_date']").val();
                    let region = $("#mainForm [name='region_id'] option:selected").text();
                    let province = $("#mainForm [name='province_id'] option:selected").text();
                    let club = $("#mainForm [name='club_id'] option:selected").text();

                    let description = convertToSlug(upload_data + "_" + region + "_" + province + "_" + club);

                    $("#mainForm [name='description']").val(description);
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
        });

        //--- fine sostituzione --//
    </script>

@endsection
