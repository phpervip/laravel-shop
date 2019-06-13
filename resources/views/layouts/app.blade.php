<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Laravel Shop') - Laravel 电商教程</title>

	<!-- 样式 -->
	<link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">
</head>
<body>
	<div id="app" class="{{ route_class() }}-page">
	 	@include('layouts._header')
	 	<div class="container">
	 		@yield('content')
	 	</div>	
	 	@include('layouts._footer')
	</div>
	<!-- JS脚本 -->
	<script src="{{ mix('js/app.js')}}" type="text/javascript"></script>
</body>
</html>
