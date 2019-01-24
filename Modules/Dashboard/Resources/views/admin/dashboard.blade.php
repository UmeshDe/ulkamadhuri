@extends('layouts.master')

@section('content-header')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <h1 class="pull-left">
        {{ trans('dashboard::dashboard.name') }}
    </h1>
    <div class="clearfix"></div>
@stop

@push('css-stack')
    <style>
        .panel-title {
            color: white;
        }
    </style>
@endpush

@section('content')
    <style>

    </style>

@stop
