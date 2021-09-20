@extends ('pub_theme::layouts.app')
@section('content')



    <div class="container-large">
        <div class="col-md-12 p-0 text-center">
            <img style="width:100vw;height:100vh;opacity:0.6" class="img-fluid"
                src="{{ Theme::asset('pub_theme::img/homebackground.jpg') }}" alt="portale dei sindacati" />
            <div class="centered" style="width:100vw;background: rgba(0,0,0,0.5);
                                        padding-left: 2vw;
                                        padding-right: 2vw;"><span
                    style="color:white;font-size:7vh;font-weight:bold;text-shadow:2px 2px rgb(39, 39, 39);">BENVENUTO</span>
            </div>
        </div>
    </div>


@endsection
