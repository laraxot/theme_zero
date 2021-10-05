@if (isset($rows))

    <div class="col-md-12 mt-3">
        <div class="table-responsive">
            <table style="display:table;" class="table table-hover table-striped">

                <tr>
                    {{-- <th>Id</th> --}}
                    {{-- <th>Titolo</th> --}}
                    <th>Regione</th>
                    <th>Provincia</th>
                    <th>Categoria</th>
                    <th>Descrizione</th>
                    <th>File</th>
                </tr>

                @php
                    //dddx($rows);
                @endphp

                @foreach ($rows as $row)

                    {{-- @can('viewRow', Panel::get($row)) --}}

                    <tr>
                        {{-- <td>$row->id</td> --}}

                        {{-- <td>$row->title</td> --}}


                        <td>{{ isset($row->region) ? $row->region->name : '' }}</td>

                        <td>{{ isset($row->province) ? $row->province->name : '' }}</td>

                        <td>{{ isset($row->club) ? $row->club->name : '' }}</td>

                        <td>{{ $row->description }}</td>

                        <td>
                            <a href="{!! $_panel->urlItemAction('scarica_file', ['query_params' => ['upload_id' => $row->upload_id]]) !!}" type="button" class="btn btn-danger">Scarica</a>
                        </td>
                    </tr>


                    {{-- @endcan --}}
                @endforeach

            </table>
        </div>
    </div>
@endif
