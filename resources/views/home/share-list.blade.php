@extends('layouts.app')

@section('title')
    分享列表页
@endsection

@section('stylesheet')
    @parent

    <!-- Styles -->
    <link rel="stylesheet" href="{{ elixir('css/share-list.css') }}">

@endsection

@section('script')
    @parent

    <!-- Scripts -->
    <script src="{{ elixir('js/shareList.js') }}"></script>

@endsection

@section('app')

    <div id="app">
    	<h1>hello</h1>
    </div>
@endsection