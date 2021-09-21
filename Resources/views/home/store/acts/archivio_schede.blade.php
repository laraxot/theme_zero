@if (isset($rows))


    <table class="table table-hover table-striped">

        <tr>
            {{-- <th>Id</th> --}}
            {{-- <th>Titolo</th> --}}
            <th>Regione</th>
            <th>Provincia</th>
            <th>Club</th>
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
                    {!! $_panel->btnItemAction('scarica_file', ['query_params' => ['upload_id' => $row->upload_id]]) !!}
                </td>
            </tr>


            {{-- @endcan --}}
        @endforeach

    </table>

@endif
