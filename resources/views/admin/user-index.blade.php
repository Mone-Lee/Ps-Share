@extends('layouts.app')

@section('title')
    用户个人空间
@endsection

@section('stylesheet')
    @parent

    <!-- Styles -->
    @if(config('app.debugWeb'))
        <link href="http://localhost:8080/public/build/css/userIndex.css" rel="stylesheet">
    @else
        <link rel="stylesheet" href="{{ elixir('build/css/userIndex.css') }}">
    @endif
    
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">


@endsection

@section('script')
    @parent

    <!-- Scripts -->
    @if(config('app.debugWeb'))
        <script src="http://localhost:8080/public/build/js/userIndex.js"></script>
    @else
        <script src="{{ elixir('build/js/userIndex.js') }}"></script>
    @endif
    <script src="https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.3/velocity.min.js"></script>


@endsection

@section('app')
    <div id="userindex">
        <Userindex></Userindex>
    </div>
@endsection