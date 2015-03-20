<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Interakttívna učebnica geografie</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="_token" content="{{ csrf_token() }}">
        {{HTML::style('css/bootstrap.min.css')}}
        {{HTML::script('js/jquery.min.js')}}
        {{HTML::script('js/bootstrap.min.js')}}
        @yield('header')
        <script>
            $(document).ready(function () {
                $.ajaxSetup({
                    headers: {'X-CSRF-Token': $('meta[name="_token"]').attr('content')}
                });
            });
        </script>
    </head>
    <body>@yield('content')</body>
</html>