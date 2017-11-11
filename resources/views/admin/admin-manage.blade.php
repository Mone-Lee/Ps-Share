@extends('layouts.app')

@section('title')
    管理员后台管理页面
@endsection

@section('stylesheet')
    @parent

    <!-- Styles -->
    @if(config('app.debugWeb'))
        <link href="http://localhost:8080/public/build/css/adminManage.css" rel="stylesheet">
    @else
        <link rel="stylesheet" href="{{ elixir('build/css/adminManage.css') }}">
    @endif

@endsection

@section('script')
    @parent

    <script type="text/javascript">
        window.isAdmin = {{\Illuminate\Support\Facades\Auth::user()->name == 'admin'? 'true':'false'}} ;
    </script>

    <!-- Scripts -->
    @if(config('app.debugWeb'))
        <script src="http://localhost:8080/public/build/js/adminManage.js"></script>
    @else
        <script src="{{ elixir('build/js/adminManage.js') }}"></script>
    @endif

@endsection

@section('app')

<div id="app">
    <admin-manage></admin-manage>
</div>

@endsection