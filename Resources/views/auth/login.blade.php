@extends ('pub_theme::layouts.app')

@section('content')

    <style>
        html,
        body {
            height: 100%;
            width: 100%;
            margin: 0;
        }

        body {
            background-image: url('{{ Theme::asset('pub_theme::img/homebackground.jpg') }}');
            display: flex;
        }

        .center {
            margin: auto;
        }

        nav {
            position: fixed;
            width: 100vw;
        }

    </style>

    <div class="col-11 col-md-7 center p-0">


        <div class="card" style="background-color: rgb(255 255 255 / 90%);">
            <div class=" card-body">
                <h4 class="card-title text-center">Login</h4>
                <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                    {!! csrf_field() !!}

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label"><strong>Indirizzo E-Mail</strong></label>

                        <div class="col-md-12">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="form-text text-muted">
                                    {{ $errors->first('email') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label"><strong>Password</strong></label>

                        <div class="col-md-12">
                            <!--<input type="password" class="form-control" name="password" required>-->

                            <div class="form-group">
                                <div class="input-group" id="show_hide_password_0">
                                    <input class="form-control" type="password" name="password" required>
                                    <div class="btn btn-secondary input-group-addon">
                                        <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>

                            @if ($errors->has('password'))
                                <span class="form-text text-muted">
                                    {{ $errors->first('password') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember">Ricordami
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-danger">
                                <i class="fa fa-btn fa-sign-in"></i>Accedi
                            </button>

                            <a class="btn text-danger" href="{{ url('/auth/password/reset') }}">Hai
                                Dimenticato La
                                Password?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!--BANDA DI PRESENTAZIONE -->
        <div class="text-center mt-3"
            style="position:fixed;left:0;width:100vw;background: rgba(0,0,0,0.5);padding-left: 2vw;padding-right: 2vw;">
            <span style="color:white;font-size:3vh;font-weight:bold;text-shadow:2px 2px rgb(39, 39, 39);">Piattaforma
                Verbali
                <br>Assemblea di Organizzazione 2021</span>
        </div>

    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $("#show_hide_password_0 .input-group-addon").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password_0 input').attr("type") == "text") {
                    $('#show_hide_password_0 input').attr('type', 'password');
                    $('#show_hide_password_0 i').addClass("fa-eye-slash");
                    $('#show_hide_password_0 i').removeClass("fa-eye");
                } else if ($('#show_hide_password_0 input').attr("type") == "password") {
                    $('#show_hide_password_0 input').attr('type', 'text');
                    $('#show_hide_password_0 i').removeClass("fa-eye-slash");
                    $('#show_hide_password_0 i').addClass("fa-eye");
                }
            });
        });
    </script>

@endsection
