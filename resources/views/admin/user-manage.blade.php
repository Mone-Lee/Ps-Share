@extends('layouts.app')

@section('title')
    用户后台管理页面
@endsection

@section('stylesheet')
    @parent

    <!-- Styles -->
    @if(config('app.debugWeb'))
        <link href="http://localhost:8080/public/build/css/userManage.css" rel="stylesheet">
    @else
        <link rel="stylesheet" href="{{ elixir('build/css/userManage.css') }}">
    @endif
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.css">

@endsection

@section('script')
    @parent

    <!-- Scripts -->
    @if(config('app.debugWeb'))
        <script src="http://localhost:8080/public/build/js/userManage.js"></script>
    @else
        <script src="{{ elixir('build/js/userManage.js') }}"></script>
    @endif  
    <script src="/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(function () {
            $('#myModal').modal('hide')
        });
    </script>
@endsection

@section('app')

    <div id="usermanage">
        <Usermanage></Usermanage>
    </div>
@endsection