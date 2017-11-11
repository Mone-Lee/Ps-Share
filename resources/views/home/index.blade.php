@extends('layouts.app')

@section('title')
    首页
@endsection

@section('stylesheet')
    @parent

    <!-- Styles -->
    @if(config('app.debugWeb'))
        <link href="http://localhost:8080/public/build/css/index.css" rel="stylesheet">
        
    @else
        <link rel="stylesheet" href="{{ elixir('build/css/index.css') }}">
    @endif
        <link href="http://localhost:8080/public/fonts/css/font-awesome.min.css" rel="stylesheet">

@endsection

@section('script')
    @parent

    <!-- Scripts -->
    @if(config('app.debugWeb'))
        <script src="http://localhost:8080/public/build/js/index.js"></script>
    @else
        <script src="{{ elixir('build/js/index.js') }}"></script>
    @endif
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.3/velocity.min.js"></script>
@endsection

@section('app')

    <div id="app">
    	<index></index>
    </div>

@endsection