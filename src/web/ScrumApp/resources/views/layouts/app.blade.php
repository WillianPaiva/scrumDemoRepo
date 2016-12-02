<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
      <meta id="token" name="token" value="{{ csrf_token() }}">
      <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Scrumk') }}</title>

        <!-- Styles -->
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <!-- Latest compiled and minified CSS -->
        <link href="/css/app.css" rel="stylesheet">

        <!-- Scripts -->
        <script>
         window.Laravel = <?php echo json_encode([
             'csrfToken' => csrf_token(),
         ]); ?>
        </script>
    </head>
    <body>
<passport-clients></passport-clients>
<passport-authorized-clients></passport-authorized-clients>
<passport-personal-access-tokens></passport-personal-access-tokens>
        <div id="app">
            <nav class="navbar navbar-default navbar-static-top">
                <div class="container-fluid">
                    <div class="navbar-header">

                        <!-- Collapsed Hamburger -->
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <!-- Branding Image -->
                        <ul class="nav navbar-nav navbar-right">
                            <a class="nav navbar-brand navbar-left" href="{{ url('/') }}">
                                <img alt="Brand" class="img-circle" src="/images/logo.svg" width="30" height="30">
                            </a>
                            <a class="navbar-brand " href="{{ url('/') }}">
                                {{ config('app.name', 'Scrumk') }}
                            </a>
                        </ul>
                    </div>

                    <div class="collapse navbar-collapse" id="app-navbar-collapse">
                        <!-- Left Side Of Navbar -->
                        @if (!Auth::guest())
                        <ul class="nav navbar-nav navbar-left">

                            @if (!Auth::guest())


                                @if (Route::currentRouteName() == 'projects')
                                    <li class="active"><a style="left:10px" href="{{ url('/project/list') }}"><span class="fa fa-home"></span></a></li>
                                @else
                                    <li><a style="left:10px" href="{{ url('/project/list') }}"><span class="fa fa-home"></span></a></li>
                                @endif
                            @endif
                        @if (Route::currentRouteName() == 'backlog')
                            <? php $id = {{Session::get('backlogActiv')}} ?>
                            <li class="active"><a class="btn btn-project navbar-btn" href="{{route('backlog', ['id' => Session::get('backlogActiv')])}}" role="button" style="left:10px;margin-bottom: 0px;
    margin-top: 0px;">{{Session::get('titleProject')}}</a></li>
                        @endif
                            @if (Session::get('backlogActiv') != '' && Route::currentRouteName() != 'backlog')
                            <li><a href="{{route('backlog', ['id' => Session::get('backlogActiv')])}}" role="button" style="left:10px;margin-bottom: 0px;
    margin-top: 0px;">{{Session::get('titleProject')}}</a></li>
                        @endif
                        </ul>
                        @endif
                        <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav navbar-right">
                            <!-- Authentication Links -->
                            @if (Auth::guest())
                                <li><a href="{{ url('/login') }}">Login</a></li>
                                <li><a href="{{ url('/register') }}">Register</a></li>
                            @else
                                <li class="dropdown">
                                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="position:relative; padding-left:50px;">
                                <img src="/uploads/avatars/{{ Auth::user()->avatar }}" style="width:32px; height:32px; position:absolute; top:10px; left:10px; border-radius:50%">
                                {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="{{ url('/logout') }}"
                                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                     <i class="fa fa-btn fa-sign-out"></i>
                                                Logout
                                            </a>

                                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>
                                        <li>
                                            <a href="{{ url('/profile')}}" ><i class="fa fa-btn fa-user"></i> Profile</a>

                                        </li>
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>

            @yield('content')
        </div>

        <script src="/js/app.js"></script>
        <!-- Scripts -->
        <script src="https://use.fontawesome.com/9444f23a15.js"></script>
    </body>
</html>

