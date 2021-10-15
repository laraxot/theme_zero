{{-- @include('theme::layouts.default.common.action') --}}
@extends('pub_theme::layouts.app')
@section('content')
    @php
    /*
                                                 if(!\View::exists($view.'.form') && !\View::exists($view_default.'.form.'.$edit_type) ) {
                                                  dddx('non esiste ne ['.$view.'.form'.'] ne ['.$view_default.'.form.'.$edit_type.']');
                                                 }
                                                 */
    @endphp
    <div class="container-large">

        <div class="col-md-12 mt-3">

            <div class="text-center">
                <h1>Aggiungi Utente</h1>
            </div>

            <a onclick="window.history.back()" href="#" class="btn btn-secondary"><i class="fa fa-caret-left"></i>
                INDIETRO</a>


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
                $fields = $_panel->getFields(['act' => 'create']);
            @endphp
            {!! Form::bsOpenPanel($_panel, 'store') !!}
            <div class="row">
                @foreach ($fields as $field)
                    {!! Theme::inputHtml(['row' => $row, 'field' => $field]) !!}
                @endforeach
            </div>
            {{-- $_panel->btnSubmit() --}}
            {{ Form::bsSubmit() }}
            {!! Form::close() !!}
        </div>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            provinceChange($('#province').val());
            $("#region").change(provinceChange);
        });

        function provinceChange(selected_province) {

            let region_id = $("#region").val();

            let newOptions = provinceInput(region_id);

            let newOptionElements = "";

            newOptionElements += "<option value>Provincia</option>"

            newOptions.forEach((v) => {
                newOptionElements += "<option value='" + v["id"] + "'>" + v["name"] +
                    "</option>"
            });

            $('#province').html(newOptionElements);

            $('#province option[value="' + selected_province + '"]').prop('selected', true);

        }

        function provinceInput(region_id) {

            const table = {!! xotModel('province')->orderBy('name', 'asc')->get(['name', 'id', 'region_id'])->toJson() !!};

            const filtered_results = table.filter((v) => {
                if (v.region_id == region_id) {
                    return v;
                }
            });

            return filtered_results;

        }
    </script>

@endsection
