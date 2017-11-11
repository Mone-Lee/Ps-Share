@extends('layouts.app')

@section('title')
    分享详情
@endsection

@section('stylesheet')
    @parent

    <!-- Styles -->
    @if(config('app.debugWeb'))
        <link href="http://localhost:8080/public/build/css/shareDetail.css" rel="stylesheet">
    @else
        <link rel="stylesheet" href="{{ elixir('build/css/shareDetail.css') }}">
    @endif

@endsection

@section('script')
    @parent

    <!-- Scripts -->
    @if(config('app.debugWeb'))
        <script src="http://localhost:8080/public/build/js/shareDetail.js"></script>
    @else
        <script src="{{ elixir('build/js/shareDetail.js') }}"></script>
    @endif
    

@endsection

@section('app')

    <div id="app">
    	<share-detail></share-detail>
    </div>
    <input type="hidden" name="shareId" value="{{$shareId}}" id="shareId">

@endsection