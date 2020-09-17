@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        @if ($errors->has())
            <div class="alert alert-danger text-center">
                <a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>
                @foreach ($errors->all() as $error)
                    {{ $error }}     
                @endforeach
            </div>
        @endif
        <div class="col-lg-12 padding-top20">
            <table class="table table-bordered table-striped text-center">
                <tr class="calibri30">
                    <td class="col-lg-1 col-md-1 col-xs-12">УСЛУГА</td>
                    <td class="col-lg-2 col-md-2 col-xs-12">КЛИЕНТ</td>
                    <td class="col-lg-3 col-md-3 col-xs-12" colspan="3"># / УСТРОЙСТВО / ЦВЯТ</td>
                    <td class="col-lg-3 col-md-3 col-xs-12">ОПЛАКВАНЕ</td>
                    <td class="col-lg-3 col-md-3 col-xs-12">ПОСЛЕДНО РЕШЕНИЕ</td>
                </tr>
                @foreach($content as $getServicesRows)
                    <tr>
                        <td style="vertical-align: middle;"><div class="computer_services_id tooltip-d"><a href="{{url('/pcs/service')}}/{{$getServicesRows->computers_service_id}}">{{$getServicesRows->computers_service_id}}</a><div class="tooltiptext-d">ОТВОРИ</div></div></td>
                        <td style="vertical-align: middle;" class="computer_services_customer"><a href="{{url('/customer')}}/{{$getServicesRows->general_customer_id}}">{{$getServicesRows->general_customer_names}}</a></td>
                        <td style="vertical-align: middle;"><a href="{{url('/pcs/device')}}/{{$getServicesRows->computers_device_id}}"><div class="tooltip-g calibri25"><?php echo htmlspecialchars_decode($getServicesRows->computers_device_category_icon); ?><div class="tooltiptext-g calibri15">УСТРОЙСТВО {{$getServicesRows->computers_device_id}}</div></div></a></td>
                        <td style="vertical-align: middle;" class="calibri25">{{$getServicesRows->computers_device_brandmodel}}</td>
                        <td style="vertical-align: middle;">{{$getServicesRows->computers_device_color}}</td>
                        <td style="vertical-align: middle;">{{$getServicesRows->computers_service_complaint}}</td>
                        <td style="vertical-align: middle;">@if (!empty(\App\PCServices::getLastServiceUpdate($getServicesRows->computers_service_id))){{\App\PCServices::getLastServiceUpdate($getServicesRows->computers_service_id)}}@else <span class="warning"> ВСЕ ОЩЕ НЕ Е ЗАПИСАНО РЕШЕНИЕ ЗА ТАЗИ УСЛУГА </span> @endif </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection