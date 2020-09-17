<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@if (!empty($title)) {{$title}} @else Guliat's WMS @endif</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    
    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo asset('css/gwms.css')?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('css/sidebarmenu.css')?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('css/pikaday.css')?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('lada/ladda-themeless.min.css')?>" type="text/css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link href="https://fonts.googleapis.com/css?family=Exo+2" rel="stylesheet">
    
    <!-- Java Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js"></script>
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
    <?php
    $gwmsurl = 'http://guliat.gwms.eu';
    $version = "Guliat's WMS 3.104.83";
    $url = Request::url();
    ?>
    @if (Auth::guest())
        <div style="padding-top: 20px;"></div>
    @else
        <div class="container-fluid hidden-print" style='background: #88c101;padding-left: 100px;'>
            <?php if($gwmsurl.'/pcs/active' == $url) { ?>   
                <a class='btn btn-gwms sharp col-xs-12 col-lg-2' href='{{url('/customers')}}'>КЛИЕНТИ</a>
                <a class='btn btn-gwms sharp col-xs-12 col-lg-2' href='{{url('/pcs/active')}}'>УСЛУГИ</a>
                <a class='btn btn-gwms sharp col-xs-12 col-lg-2' href='{{url('/pcs/devices')}}'>УСТРОЙСТВА</a>
            <?php } ?>
            <?php if($gwmsurl.'/pcs/devices' == $url) { ?>
                <a class='btn btn-gwms sharp col-xs-12 col-lg-2' href='{{url('/pcs/active')}}'>УСЛУГИ</a>
                <a class='btn btn-gwms sharp col-xs-12 col-lg-2' href='{{url('/pcs/brandsmodels')}}'>МАРКИ И МОДЕЛИ</a>
                <a class='btn btn-gwms sharp col-xs-12 col-lg-2' href='{{url('/pcs/categories')}}'>КАТЕГОРИИ</a>
            <?php } ?>
            <?php
            if(!empty($title)) {
            $string = $title;
            $pieces = explode(' ', $string);
            $removenum = array_pop($pieces);
            $titleid = ltrim($removenum, '#');
            } else {
                $titleid = null;
            }
            if($gwmsurl.'/pcs/device/'.$titleid == $url) { ?>
                <a class='btn btn-gwms sharp col-xs-12 col-lg-2' href='{{url('/pcs/active')}}'>УСЛУГИ</a>
            <?php } ?>
            <!-- STORE/PRODUCTS MENU -->
            <?php if($gwmsurl.'/store' == $url || $gwmsurl.'/products/bmd' == $url || $gwmsurl.'/products/categories' == $url || $gwmsurl.'/storeservices' == $url) { ?>
                <a class='btn btn-gwms sharp col-xs-12 col-lg-2' href='{{url('/store')}}'>СКЛАД</a>
                <a class='btn btn-gwms sharp col-xs-12 col-lg-2' href='{{url('/storeservices')}}'>УСЛУГИ</a>
                <a class='btn btn-gwms sharp col-xs-12 col-lg-2' href='{{url('/products/bmd')}}'>МАРКИ И МОДЕЛИ</a>
                <a class='btn btn-gwms sharp col-xs-12 col-lg-2' href='{{url('/products/categories')}}'>КАТЕГОРИИ</a>
            <?php } ?>
            <?php if($gwmsurl.'/costs' == $url) { ?>
                <a class='btn btn-gwms sharp col-xs-12 col-lg-2' href='{{url('/costs/add')}}'>СРОЧЕН ПРИХОД</a>
                <a class='btn btn-gwms sharp col-xs-12 col-lg-2' href='{{url('/costs/add')}}'>СРОЧЕН РАЗХОД</a>
                <a class='btn btn-gwms sharp col-xs-12 col-lg-2' href='{{url('/costs/add/profit')}}'>ТЕКУЩ ПРИХОД</a>
                <a class='btn btn-gwms sharp col-xs-12 col-lg-2' href='{{url('/costs/add/cost')}}'>ТЕКУЩ РАЗХОД</a>
                <a class='btn btn-gwms sharp col-xs-12 col-lg-2' href='#'>СТАТИСТИКА</a>
                <a class='btn btn-gwms sharp col-xs-12 col-lg-1' href='#'>ИСТОРИЯ</a>
            <?php } ?>
            <?php if($gwmsurl.'/orders' == $url || $gwmsurl.'/order/'.$titleid == $url) { ?>
                <a class='btn btn-gwms sharp col-xs-12 col-lg-2' href='{{url('/orders')}}'>ПРОТОКОЛИ</a>
                <a class='btn btn-gwms sharp col-xs-12 col-lg-2' href='#'>НЕПЛАТЕНИ ПРОТОКОЛИ</a>
                <a class='btn btn-gwms sharp col-xs-12 col-lg-2' href='#'>ФАКТУРИРАНИ ПРОТОКОЛИ</a>
                <a class='btn btn-gwms sharp col-xs-12 col-lg-2' href='#'>НЕФАКТУРИРАНИ ПРОТОКОЛИ</a>
            <?php } ?>
        </div>
        <?php $uml = Auth::user()['user_module_level']; ?>
        <!-- SIDE MENU -->
        <div id="sidebar" class="hidden-print">
            <div id="sidebar-btn"><i class='fa fa-bars fa-2x'></i></div>
            <ul>
                <li><a href='{{url('/')}}' class='<?php if($gwmsurl == $url){ echo "activelink"; } ?>'><i class='fa fa-home fa-lg'></i> {!! Lang::get('general.menu_home') !!} </a></li>
                @if($uml == 1)
                <li><a href='{{url('/pcs/active')}}' class='<?php if($gwmsurl.'/pcs/active' == $url){ echo "activelink"; } ?>'><i class='fa fa-laptop fa-lg'></i> {!! Lang::get('general.menu_service') !!} </a></li>
                @endif
                @if($uml == 1)
                <li><a href='{{url('/videosurveillance')}}' class='<?php if($gwmsurl.'/videosurveillance' == $url){ echo "activelink"; } ?>' style='font-size: 2.1vh;'><i class='fa fa-video-camera fa-lg'></i> {!! Lang::get('general.menu_videosurveillance') !!} </a></li>
                @endif
                @if($uml == 1 || $uml == 74 || $uml == 4)
                <li><a href='{{url('/customers')}}' class='<?php if($gwmsurl.'/customers' == $url){ echo "activelink"; } ?>'><i class='fa fa-user fa-lg'></i> {!! Lang::get('general.menu_customers') !!} </a></li>
                @endif
                @if($uml == 1 || $uml == 74  || $uml == 4)
                <li><a href='{{url('/companies')}}' class='<?php if($gwmsurl.'/companies' == $url){ echo "activelink"; } ?>'><i class='fa fa-users fa-lg'></i> {!! Lang::get('general.menu_companies') !!} </a></li>
                @endif
                @if($uml == 1 || $uml == 74)
                <li><a href='{{url('/store')}}' class='<?php if($gwmsurl.'/store' == $url){ echo "activelink"; } ?>'><i class='fa fa-truck fa-lg'></i> {!! Lang::get('general.menu_store') !!} </a></li>
                @endif
                @if($uml == 1 || $uml == 74)
                <li><a href='{{url('/orders')}}' class='<?php if($gwmsurl.'/orders' == $url){ echo "activelink"; } ?>'><i class='fa fa-file-text fa-lg'></i> {!! Lang::get('general.menu_orders') !!} </a></li>
                @endif
                @if($uml == 1 || $uml == 74  || $uml == 4)
                <li><a href='{{url('/invoices')}}' class='<?php if($gwmsurl.'/invoices' == $url){ echo "activelink"; } ?>'><i class='fa fa-file-text fa-lg'></i> {!! Lang::get('general.menu_invoices') !!} </a></li>
                @endif
                @if($uml == 1)
                <li><a href='#'><i class='fa fa-file-text fa-lg'></i> {!! Lang::get('general.menu_offers') !!} </a></li>
                @endif
                @if($uml == 1 || $uml == 7 || $uml == 74)
                <li><a href='{{url('/costs')}}' class='<?php if($gwmsurl.'/costs' == $url){ echo "activelink"; } ?>' style='font-size: 2.1vh;'><i class='fa fa-line-chart fa-lg'></i> {!! Lang::get('general.menu_costs') !!} </a></li>
                @endif
                <li><a href='{{url('/settings')}}' class='<?php if($gwmsurl.'/settings' == $url){ echo "activelink"; } ?>'><i class='fa fa-cog fa-lg'></i> {!! Lang::get('general.menu_settings') !!} </a></li>
                <li><a href='{{url('logout')}}'> <i class="fa fa-power-off"></i></a></li>
            </ul>
        </div>
        <script>
            $(document).ready(function(){ 
                $('#sidebar-btn').click(function(){ 
                    $('#sidebar').toggleClass('visible');
                }); 
            });
           
            $(document).ready(function(){ 
                $('#sidebar-btn').click(function(){ 
                    $('#sidebar-btn').toggleClass('active');
                }); 
            });
        </script>
    <div class='footer hidden-print'>{{$version}}</div>
    <!-- <div class="hidden-print"><a href="{{url('/feedback')}}"><div class="feedback"> ПРЕДЛОЖЕНИЯ </div></a></div> -->
    @endif
    @yield('content')
    <!-- JavaScripts -->
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    <script> Ladda.bind( 'button[type=submit]' ); </script>
</body>
</html>
