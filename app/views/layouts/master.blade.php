<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Interaktívna učebnica geografie</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="_token" content="{{ csrf_token() }}">
        {{HTML::style('css/bootstrap.min.css')}}
        {{HTML::script('js/jquery.min.js')}}
        {{HTML::script('js/bootstrap.min.js')}}
        <script>
            $(document).ready(function () {
                $.ajaxSetup({
                    headers: {'X-CSRF-Token': $('meta[name="_token"]').attr('content')}
                });
            });
        </script>
        @yield('header')
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    {{ HTML::linkAction('ArticleController@showHome', 'Domov', array(), array('class' => 'navbar-brand')) }}
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li>{{ HTML::linkAction('ArticleController@getCreate', 'Články', array(), array('class' => 'nav navbar-nav')) }}</li>
                        <li>{{ HTML::linkAction('TaskController@showActual', 'Zadania', array(), array('class' => 'nav navbar-nav')) }}</li>
                        <li>{{ HTML::linkAction('UserController@showTeachers', 'Užívatelia', array(), array('class' => 'nav navbar-nav')) }}</li>
                    </ul>
                    <form class="navbar-form navbar-left" role="search">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search">
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                    <ul class="nav navbar-nav navbar-right">
                        @if(Auth::check())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{{Auth::user()->fullName()}}} <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li>{{ HTML::linkAction('LoginController@getLogout', 'Odhlásiť sa') }}</li>
                            </ul>
                        </li>
                        @else
                        <li>{{ HTML::linkAction('LoginController@getRegister', 'Registrovať sa') }}</li>
                        <li>{{ HTML::linkAction('LoginController@getLogin', 'Prihlásiť sa') }}</li>
                        @endif
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <div class="container-fluid">
            @if(Session::has('error'))
                <div class="alert alert-danger" role="alert">{{ Session::get('error') }}</div>
            @endif
            @if(Session::has('message'))
                <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
            @endif
            @yield('content')
        </div>    
    </body>
</html>