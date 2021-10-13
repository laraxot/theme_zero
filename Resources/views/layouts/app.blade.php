{{-- pagina copiata da layouts.app di sbadmin24 --}}

@php
/*dddx(
    Panel::getHomePanel()
        ->itemAction('caricamento_schede')
        ->url(),
); */
@endphp

@extends('pub_theme::layouts.plane')

@section('css')
    <style>
        .container-large {
            /*background-color: white;*/
        }

        .container {
            position: relative;
            text-align: center;
            color: white;
        }

        /* Bottom left text */
        .bottom-left {
            position: absolute;
            bottom: 8px;
            left: 16px;
        }

        /* Top left text */
        .top-left {
            position: absolute;
            top: 8px;
            left: 16px;
        }

        /* Top right text */
        .top-right {
            position: absolute;
            top: 8px;
            right: 16px;
        }

        /* Bottom right text */
        .bottom-right {
            position: absolute;
            bottom: 8px;
            right: 16px;
        }

        /* Centered text */
        .centered {
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        /*@import url('https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700&display=swap');

                                                                                                                            * {
                                                                                                                                margin: 0;
                                                                                                                                padding: 0;
                                                                                                                                outline: none;
                                                                                                                                box-sizing: border-box;
                                                                                                                                font-family: 'Montserrat', sans-serif;
                                                                                                                            }*/


        /*div {
                                                                                                    font-family: 'Futura';
                                                                                                }*/

        @font-face {
            font-family: Futura;

            /*src: url("fonts/futura/FuturaStd-Bold.otf") format("opentype");
                                                                                            src: url("fonts/futura/FuturaStd-BoldOblique.otf") format("opentype");
                                                                                            src: url("fonts/futura/FuturaStd-Book.otf") format("opentype");
                                                                                            src: url("fonts/futura/FuturaStd-BookOblique.otf") format("opentype");
                                                                                            src: url("fonts/futura/FuturaStd-Condensed.otf") format("opentype");
                                                                                            src: url("fonts/futura/FuturaStd-CondensedBold.otf") format("opentype");
                                                                                            src: url("fonts/futura/FuturaStd-CondensedBoldObl.otf") format("opentype");
                                                                                            src: url("fonts/futura/FuturaStd-CondensedExtraBd.otf") format("opentype");
                                                                                            src: url("fonts/futura/FuturaStd-CondensedLight.otf") format("opentype");
                                                                                            src: url("fonts/futura/FuturaStd-CondensedLightObl.otf") format("opentype");
                                                                                            src: url("fonts/futura/FuturaStd-CondensedOblique.otf") format("opentype");
                                                                                            src: url("fonts/futura/FuturaStd-CondExtraBoldObl.otf") format("opentype");
                                                                                            src: url("fonts/futura/FuturaStd-ExtraBold.otf") format("opentype");
                                                                                            src: url("fonts/futura/FuturaStd-ExtraBoldOblique.otf") format("opentype");
                                                                                            src: url("fonts/futura/FuturaStd-Heavy.otf") format("opentype");
                                                                                            src: url("fonts/futura/FuturaStd-HeavyOblique.otf") format("opentype");
                                                                                            src: url("fonts/futura/FuturaStd-Light.otf") format("opentype");
                                                                                            src: url("fonts/futura/FuturaStd-LightOblique.otf") format("opentype");*/
            src: url("/fonts/futura/FuturaStd-Medium.otf") format("opentype");
            /*src: url("fonts/futura/FuturaStd-MediumOblique.otf") format("opentype");*/

        }


        body {
            background: #f2f2f2;
            font-family: 'Futura';
            font-size: 2vh;
            /* background-image: url('{{ Theme::asset('pub_theme::img/homebackground.jpg') }}');*/
        }

        nav {
            background: #e3342f;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            height: 70px;
            padding: 0 100px;
        }

        nav .logo {
            color: #fff;
            font-size: 30px;
            font-weight: 600;
            letter-spacing: -1px;
        }

        nav .nav-items {
            display: flex;
            flex: 1;
            padding: 0 0 0 40px;
        }

        nav .nav-items li {
            list-style: none;
            padding: 0 15px;
        }

        nav .nav-items li a {
            color: #fff;
            font-size: 18px;
            font-weight: 500;
            text-decoration: none;
        }

        nav .nav-items li a:hover {
            color: silver;
        }

        nav form {
            display: flex;
            height: 40px;
            padding: 2px;
            background: #fff;
            min-width: 18% !important;
            border-radius: 2px;
            border: 1px solid rgba(155, 155, 155, 0.2);
        }

        nav form .search-data {
            width: 100%;
            height: 100%;
            padding: 0 10px;
            color: #fff;
            font-size: 17px;
            border: none;
            font-weight: 500;
            background: none;
        }

        nav form button {
            padding: 0 15px;
            color: #fff;
            font-size: 17px;
            background: silver;
            border: none;
            border-radius: 2px;
            cursor: pointer;
        }

        nav form button:hover {
            background: silver;
        }

        nav .menu-icon,
        nav .cancel-icon,
        nav .search-icon {
            width: 40px;
            text-align: center;
            margin: 0 50px;
            font-size: 18px;
            color: #fff;
            cursor: pointer;
            display: none;
        }

        nav .menu-icon span,
        nav .cancel-icon,
        nav .search-icon {
            display: none;
        }

        @media (max-width: 1245px) {
            nav {
                padding: 0 50px;
            }
        }

        @media (max-width: 1140px) {
            nav {
                padding: 0px;
            }

            nav .logo {
                flex: 2;
                text-align: center;
            }

            nav .nav-items {
                position: fixed;
                z-index: 99;
                top: 70px;
                width: 100%;
                left: -100%;
                height: 100%;
                padding: 10px 50px 0 50px;
                text-align: center;
                background: #e3342f;
                display: inline-block;
                transition: left 0.3s ease;
            }

            nav .nav-items.active {
                left: 0px;
            }

            nav .nav-items li {
                line-height: 40px;
                margin: 30px 0;
            }

            nav .nav-items li a {
                font-size: 20px;
            }

            nav form {
                position: absolute;
                top: 80px;
                right: 50px;
                opacity: 0;
                pointer-events: none;
                transition: top 0.3s ease, opacity 0.1s ease;
            }

            nav form.active {
                top: 95px;
                opacity: 1;
                pointer-events: auto;
            }

            nav form:before {
                position: absolute;
                content: "";
                top: -13px;
                right: 0px;
                width: 0;
                height: 0;
                z-index: -1;
                border: 10px solid transparent;
                border-bottom-color: silver;
                margin: -20px 0 0;
            }

            nav form:after {
                position: absolute;
                content: '';
                height: 60px;
                padding: 2px;
                background: silver;
                border-radius: 2px;
                min-width: calc(100% + 20px);
                z-index: -2;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
            }

            nav .menu-icon {
                display: block;
            }

            nav .search-icon,
            nav .menu-icon span {
                display: block;
            }

            nav .menu-icon span.hide,
            nav .search-icon.hide {
                display: none;
            }

            nav .cancel-icon.show {
                display: block;
            }
        }

        .content {
            position: absolute;
            top: 50%;
            left: 50%;
            text-align: center;
            transform: translate(-50%, -50%);
        }

        .content header {
            font-size: 30px;
            font-weight: 700;
        }

        .content .text {
            font-size: 30px;
            font-weight: 700;
        }

        .space {
            margin: 10px 0;
        }

        nav .logo.space {
            color: silver;
            padding: 0 5px 0 0;
        }

        @media (max-width: 980px) {

            nav .menu-icon,
            nav .cancel-icon,
            nav .search-icon {
                margin: 0 20px;
            }

            nav form {
                right: 30px;
            }
        }

        @media (max-width: 350px) {

            nav .menu-icon,
            nav .cancel-icon,
            nav .search-icon {
                margin: 0 10px;
                font-size: 16px;
            }
        }

        .content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .content header {
            font-size: 30px;
            font-weight: 700;
        }

        .content .text {
            font-size: 30px;
            font-weight: 700;
        }

        .content .space {
            margin: 10px 0;
        }

    </style>
@endsection

@section('navbar')
    <nav>
        @if (Auth::check())
            <div class="menu-icon">
                <span class="fas fa-bars"></span>
            </div>
        @endif
        <div class="logo">
            Verbali
        </div>
        <div class="nav-items">

            @php
                //dddx(Panel::getHomePanel()->urlItemAction('caricamento_schede'));
            @endphp


            <!--<li><a href="/">Home</a>
                                                                                                                                                </li>-->

            @php
                
                //dddx(\Auth::user()->perm_type);
                /*dddx(
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    \Auth::user()
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ->rights->where('right_define_name', 'writer')
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ->count(),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                );*/
            @endphp

            @if (\Auth::check())

                @php
                    //dddx(\Auth::user()->hasRight('writer'));
                @endphp

                <li><a dusk="menu-ricerca"
                        href="{{ Panel::getHomePanel()->itemAction('archivio_schede')->url() }}">Ricerca</a>
                </li>


                @can('caricamentoSchede', Panel::getHomePanel())
                    <li><a dusk='menu-inserimento'
                            href="{{ Panel::getHomePanel()->itemAction('caricamento_schede')->url() }}">Inserimento</a>
                    </li>
                @endcan

                <li><a href="{{ Panel::getHomePanel()->itemAction('modifica_password')->url() }}">Profilo</a>
                </li>
                <li><a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a></li>
            @else
                <!--<li><a href="{{ route('login') }}">Login</a>-->
                </li>
            @endif

            <!--<li><a href="#">Contact</a></li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <li><a href="#">Feedback</a></li>-->
        </div>
        <div class="search-icon">
            <span class="fas fa-search"></span>
        </div>
        <div class="cancel-icon">
            <span class="fas fa-times"></span>
        </div>
        <!--<form action="#">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <input type="search" class="search-data" placeholder="Search" required>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <button type="submit" class="fas fa-search"></button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </form>-->
    </nav>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>

    <script>
        const menuBtn = document.querySelector(".menu-icon span");
        const searchBtn = document.querySelector(".search-icon");
        const cancelBtn = document.querySelector(".cancel-icon");
        const items = document.querySelector(".nav-items");
        const form = document.querySelector("form");
        menuBtn.onclick = () => {
            items.classList.add("active");
            menuBtn.classList.add("hide");
            searchBtn.classList.add("hide");
            cancelBtn.classList.add("show");
        }
        cancelBtn.onclick = () => {
            items.classList.remove("active");
            menuBtn.classList.remove("hide");
            searchBtn.classList.remove("hide");
            cancelBtn.classList.remove("show");
            form.classList.remove("active");
            cancelBtn.style.color = "#ff3d00";
        }
        searchBtn.onclick = () => {
            form.classList.add("active");
            searchBtn.classList.add("hide");
            cancelBtn.classList.add("show");
        }
    </script>
@endsection


@section('body')


    @yield('css')

    @yield('navbar')

    @yield('content')


@endsection
