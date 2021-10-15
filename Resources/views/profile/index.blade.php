@extends ('pub_theme::layouts.app')

@php
//dddx(auth()->user()->perm->perm_type);
//dddx(get_defined_vars());

//dddx(get_class_methods($profile->getPanel()->out()));

//dddx($profile->getPanel()->fields());

//dddx([$profile, $profile->getPanel()->fields(), $profile->getPanel()->getFields(['act' => 'index'])]);

$panel = $profile->getPanel();

$fields = $panel->getFields(['act' => 'index']);

$rows = \Modules\ClubReport\Models\Profile::all();

@endphp

@section('content')

    <div class="row">
        <div class="col-md-12 mt-3 mb-4 text-center">

            <h1>Gestione Utenti</h1>

            @php
                //dddx(get_defined_vars());
                if ($rows_err != null) {
                    exit('<h3><pre>' . $rows_err->getMessage() . '</pre></h3>');
                    return;
                }
            @endphp

            @foreach ($rows as $key => $row)

                @if ($loop->first)
                    {!! $_panel->btnHtml(['title' => 'Crea Nuovo', 'act' => 'create']) !!}

                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                @foreach ($fields as $field)
                                    @if (!empty($field->label))
                                        <td>{{ str_replace('_', ' ', $field->label) }}</td>
                                    @else
                                        <td>{{ str_replace('_', ' ', $field->name) }}</td>
                                    @endif
                                @endforeach
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                @endif
                <tr>
                    @foreach ($fields as $field)
                        <td>
                            {!! Theme::inputFreeze(['row' => $row, 'field' => $field]) !!}
                            @if ($loop->first)
                                @foreach ($_panel->itemActions() as $act)
                                    {{-- togliere una graffa per parte --}}
                                    {{-- !!$act->btn(['row'=>$row])!! --}}
                                @endforeach
                            @endif
                        </td>
                    @endforeach
                    <td>
                        {{-- togliere una graffa per parte --}}
                        @php
                            //dddx($row);
                        @endphp
                        {!! Form::bsBtnCrud(['row' => $row], ['edit' => 'true', 'delete' => 'true']) !!}
                    </td>
                </tr>
                @if ($loop->last)
                    </tbody>
                    </table>
                @endif
            @endforeach
        </div>
    </div>
@endsection
