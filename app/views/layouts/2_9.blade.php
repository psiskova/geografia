@extends('layouts.master')

@section('content') 
<div class="row">
    <div class="col-md-2">
        @yield('left')
    </div>
    <div class="col-md-9">
        @yield('middle')
    </div> 
</div>
@stop
