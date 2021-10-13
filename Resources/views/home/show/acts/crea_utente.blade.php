@php
//dddx(auth()->user()->perm->perm_type);
//dddx(get_defined_vars());

//dddx(get_class_methods($profile->getPanel()->out()));

//dddx($profile->getPanel()->fields());
@endphp

@foreach ($profile->getPanel()->fields() as $k => $v)

    {{ $k }}

@endforeach
