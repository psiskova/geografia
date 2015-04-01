@extends('layouts.master')

@section('content') 
<div class="row">
    <div class="col-md-2">
        @yield('left')
    </div>
    <div class="col-md-7">
        @yield('middle')
    </div>
    <div class="col-md-3">
        @yield('right')
    </div>   
</div>
@stop
