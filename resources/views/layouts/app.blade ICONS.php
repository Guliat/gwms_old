<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Guliat's WMS</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    
    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo asset('css/gwms.css')?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('css/pikaday.css')?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('lada/ladda-themeless.min.css')?>" type="text/css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    
    <!-- Java Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script>var $j = jQuery.noConflict(true);</script>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script>
      $(document).ready(function(){
       console.log($().jquery); // 
       console.log($j().jquery); //
      });
    </script>
    <script src="<?php echo asset('lada/spin.min.js')?>"></script>
    <script src="<?php echo asset('lada/ladda.min.js')?>"></script>
</head>
<body id="app-layout">
    @if (Auth::guest())
        <div style="padding-top: 150px;"></div>
    @else
    <div class="noPrint"><a href="{{url('/feedback')}}"><div class="feedback"> ПРЕДЛОЖЕНИЯ </div></a></div>
    
    <div class="container-fluid padding-bottom50 noPrint">
        <div class="row shadow-down">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#spark-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="btn-group btn-group-justified" id="spark-navbar-collapse">
                <a class="btn btn-gwms tooltip-d" href="{{url('/')}}"><i class="fa fa-home fa-2x"></i><div class="tooltiptext-d">НАЧАЛО</div></a>
                <div class="btn-group">
                    <button type="button" class="btn btn-gwms dropdown-toggle tooltip-d" data-toggle="dropdown">
                        <i class="fa fa-laptop fa-2x"></i><div class="tooltiptext-d">СЕРВИЗ</div>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li class="calibri20"><a href="{{url('/pcs/active')}}"> УСЛУГИ</a></li>
                        <li class="calibri20"><a href="{{url('/pcs/devices')}}"> УСТРОЙСТВА</a></li>
                        <hr />
                        <li><a href="{{url('/pcs/categories')}}"><i class="fa fa-bars"></i> КАТЕГОРИИ</a></li>
                        <li><a href="{{url('/pcs/brandsmodels')}}"><i class="fa fa-bars"></i> МАРКИ И МОДЕЛИ</a></li>
                    </ul>
                </div>
                <a class="btn btn-gwms tooltip-d" href="{{url('/videosurveillance')}}"><i class="fa fa-video-camera fa-2x"></i><div class="tooltiptext-d">ВИДЕОНАБЛЮДЕНИЕ</div></a>
                <div class="btn-group">
                    <button type="button" class="btn btn-gwms dropdown-toggle tooltip-d" data-toggle="dropdown">
                        <i class="fa fa-shopping-cart fa-2x"></i><div class="tooltiptext-d">СКЛАД</div>  
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{url('/products')}}"><i class="fa fa-list"></i> ПРОДУКТИ</a></li>
                        <li><a href="{{url('/products/settings')}}"><i class="fa fa-gear"></i> НАСТРОЙКИ</a></li>
                    </ul>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-gwms dropdown-toggle tooltip-d" data-toggle="dropdown">
                        <i class="fa fa-user-secret fa-2x"></i><div class="tooltiptext-d">ФИРМИ</div>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{url('/addcompany')}}"><i class="fa fa-plus"></i> ДОБАВИ</a></li>
                        <li><a href="{{url('/companies')}}"><i class="fa fa-list"></i> КЛИЕНТСКИ ФИРМИ</a></li>
                        <li><a href="{{url('/owncompanies')}}"><i class="fa fa-users"></i> СОБСТВЕНИ ФИРМИ И СЛУЖИТЕЛИ</a></li>
                    </ul>
                </div>
                <a class="btn btn-gwms tooltip-d" href="{{url('/customers')}}"><i class="fa fa-user fa-2x"></i><div class="tooltiptext-d">КЛИЕНТИ</div></a>
                <div class="btn-group">
                    <button type="button" class="btn btn-gwms dropdown-toggle tooltip-d" data-toggle="dropdown">
                        <i class="fa fa-file-text fa-2x"></i><div class="tooltiptext-d">ПРОТОКОЛИ</div>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{url('/orders')}}"><i class="fa fa-list"></i> ВСИЧКИ</a></li>
                        <li><a href="{{url('/orders/np')}}"><i class="fa fa-ban danger"></i> ВСИЧКИ НЕПЛАТЕНИ</a></li>
                        <li><a href="{{url('/orders/incash')}}"><i class="fa fa-money"></i> В БРОЙ</a></li>
                        <li><a href="{{url('/orders/npincash')}}"><i class="fa fa-money danger"></i> НЕПЛАТЕНИ В БРОЙ</a></li>
                        <li><a href="{{url('/orders/inbank')}}"><i class="fa fa-credit-card"></i> БАНКОВИ</a></li>
                        <li><a href="{{url('/orders/npinbank')}}"><i class="fa fa-credit-card danger"></i> НЕПЛАТЕНИ БАНКОВИ</a></li>
                    </ul>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-gwms dropdown-toggle tooltip-d" data-toggle="dropdown">
                        <i class="fa fa-copy fa-2x"></i><div class="tooltiptext-d">ФАКТУРИ</div>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{url('/invoices')}}"><i class="fa fa-list"></i> ВСИЧКИ</a></li>
                        <li><a href="{{url('/invoices/np')}}"><i class="fa fa-ban danger"></i> ВСИЧКИ НЕПЛАТЕНИ</a></li>
                        <li><a href="{{url('/invoices/incash')}}"><i class="fa fa-money"></i> В БРОЙ</a></li>
                        <li><a href="{{url('/invoices/npincash')}}"><i class="fa fa-money danger"></i> НЕПЛАТЕНИ В БРОЙ</a></li>
                        <li><a href="{{url('/invoices/inbank')}}"><i class="fa fa-credit-card"></i> БАНКОВИ</a></li>
                        <li><a href="{{url('/invoices/npinbank')}}"><i class="fa fa-credit-card danger"></i> НЕПЛАТЕНИ БАНКОВИ</a></li>
                    </ul>
                </div>
                <a class="btn btn-danger tooltip-d" href="{{url('logout')}}"><i class="fa fa-power-off fa-lg"></i><div class="tooltiptext-d">ИЗХОД</div></a>
            </div>
        </div>
    </div>
    @endif
    @yield('content')
    <!-- JavaScripts -->
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    <script> Ladda.bind( 'button[type=submit]', { timeout: 3000 } ); </script>
</body>
</html>
