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
    @php
    //dddx(get_defined_vars());
    if ($rows_err != null) {
        exit('<h3><pre>' . $rows_err->getMessage() . '</pre></h3>');
        return;
    }
    @endphp

    @foreach ($rows as $key => $row)

        @if ($loop->first)
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        @foreach ($fields as $field)
                            <td>{{ str_replace('_', ' ', $field->name) }}</td>
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
                {!! Form::bsBtnCrud(['row' => $row]) !!}
            </td>
        </tr>
        @if ($loop->last)
            </tbody>
            </table>
        @endif
    @endforeach

@endsection
