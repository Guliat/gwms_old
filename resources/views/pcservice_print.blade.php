@extends('layouts.app')
@section('content')
<style>@page { 
    size:210mm 270mm; 
    margin: 20px;
    size: landscape;
}</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <!-- COMPUTERS SERVICE CONTENT -->
            <div style="padding-top: 50px;"></div>
            @foreach($getService as $getServiceRows)
            <table border="0" cellpading="0" cellspacing="0" align="left" width="100%" style="border-left: 5px solid #999;">
                <tr valign="bottom" style="border-bottom: 5px solid #999;">
                    <td>
                        <table style="">
                            <tr><td class="calibri20">&nbsp;УСЛУГА</td></tr>
                            <tr><td style="border-bottom: 2px solid #999;"></td></tr>
                            <tr><td class="calibri30">&nbsp;#{{$getServiceRows->computers_service_id}}</td></tr>
                            <tr><td>&nbsp;&nbsp;OT:&nbsp;{{ \App\General::showDateTime($getServiceRows->computers_service_added)}}</td></tr>
                            <tr><td>&nbsp;&nbsp;ДО:&nbsp;{{ \App\General::showDateTime($getServiceRows->computers_service_completed)}}</td></tr>
                        </table>
                    </td>
                    <td>
                        <table style="border-left: 4px solid #999;">
                            <tr><td class="calibri20">&nbsp;КЛИЕНТ</td></tr>
                            <tr><td style="border-bottom: 2px solid #999;"></td></tr>
                            <tr><td>&nbsp;#{{$getServiceRows->general_customer_id}}</td></tr>
                            @if(!empty($getServiceRows->general_customer_names))
                            <tr><td>&nbsp;{{$getServiceRows->general_customer_names}}</td></tr>
                            @else @endif
                            @if(!empty($getServiceRows->general_customer_nick))
                            <tr><td>&nbsp;{{$getServiceRows->general_customer_nick}}</td></tr>
                            @else @endif
                            @if(!empty($getServiceRows->general_customer_phone))
                            <tr>
                                <td>
                                <?php
                                    echo "&nbsp;";
                                    echo substr($getServiceRows->general_customer_phone, 0, -6);
                                    echo " ";
                                    echo substr($getServiceRows->general_customer_phone, 4, -4);
                                    echo " ";
                                    echo substr($getServiceRows->general_customer_phone, 6, -2);
                                    echo " ";
                                    echo substr($getServiceRows->general_customer_phone, 8, 10);
                                ?>
                                </td>
                            </tr>
                            @else @endif
                            @if(!empty($getServiceRows->general_customer_phone2))
                            <tr>
                                <td>
                                <?php
                                    echo "&nbsp;";
                                    echo substr($getServiceRows->general_customer_phone2, 0, -6);
                                    echo " ";
                                    echo substr($getServiceRows->general_customer_phone2, 4, -4);
                                    echo " ";
                                    echo substr($getServiceRows->general_customer_phone2, 6, -2);
                                    echo " ";
                                    echo substr($getServiceRows->general_customer_phone2, 8, 10);
                                ?>
                                </td>
                            </tr>
                            @else @endif
                            <tr><td>&nbsp;{{ \App\General::showDate($getServiceRows->general_customer_added)}}</td></tr>
                        </table>
                    </td>
                    <td>
                        <table style="border-left: 3px solid #999;">
                            <tr><td class="calibri20">&nbsp;УСТРОЙСТВО</td></tr>
                            <tr><td style="border-bottom: 2px solid #999;"></td></tr>
                            <?php $deviceC = new \App\PCServices(); $deviceContent = $deviceC->getDeviceContent($getServiceRows->computers_device_id); ?>
                            @foreach($deviceContent as $dc)
                            <tr><td>&nbsp;#{{$dc->computers_device_id}}</td></tr>
                            <tr><td>&nbsp;{{$dc->computers_device_category}}</td></tr>
                            <tr><td>&nbsp;{{$dc->computers_device_brandmodel}}</td></tr>
                            @if(!empty($dc->computers_device_submodel))
                            <tr><td>&nbsp;{{$dc->computers_device_submodel}}</td></tr>
                            @else @endif
                            <tr><td>&nbsp;{{$dc->computers_device_color}}</td></tr>
                            @if(!empty($dc->computers_device_note))
                            <tr><td>&nbsp;{{$dc->computers_device_note}}</td></tr>
                            @else @endif
                            <tr><td>&nbsp;{{ \App\General::showDate($dc->computers_device_added)}}</td></tr>
                            @endforeach
                        </table>
                    </td>
                    <td>
                        <table style="border-left: 2px solid #999;">
                            <tr><td class="calibri20">&nbsp;ЦЕНИ</td></tr>
                            <tr><td style="border-bottom: 2px solid #999;"></td></tr>
                            <tr><td>&nbsp;ПРИБЛИЗИТЕЛНА ЦЕНА: {{round($getServiceRows->computers_service_aboutprice, 2)}}лв.</td></tr>
                            <tr><td>&nbsp;УСЛУГА: {{round($getServiceRows->computers_service_price, 2)}}лв.</td></tr>
                            <tr><td>&nbsp;СТОКИ / ДРУГИ: {{round($getServiceRows->computers_service_partsprice, 2)}}лв.</td></tr>
                            <tr><td>&nbsp;ОТСТЪПКА: {{round($getServiceRows->computers_service_discountprice, 2)}}лв.</td></tr>
                            <?php $total = $getServiceRows->computers_service_price+$getServiceRows->computers_service_partsprice-$getServiceRows->computers_service_discountprice; ?>
                            <tr><td class="calibri20">&nbsp;КРАЙНА СУМА: {{$total}}лв.</td></tr>
                        </table>
                    </td>
                    @if($dc->computers_device_category_id == 1)
                    <td>
                        <table style="border-left: 2px solid #999;">
                            <tr><td class="calibri20">&nbsp;ДРУГИ</td></tr>
                            <tr><td style="border-bottom: 2px solid #999;"></td></tr>
                            @if($dc->computers_device_category_id == 1)
                                <tr><td>@if($getServiceRows->computers_service_havebag == 1) &nbsp;ЧАНТА: ДА @else &nbsp;ЧАНТА: НЕ @endif</td></tr>
                                <tr><td>@if($getServiceRows->computers_service_havepower == 1) &nbsp;ЗАХРАНВАНЕ: ДА @else &nbsp;ЗАХРАНВАНЕ: НЕ @endif</td></tr>
                                <tr><td>@if($getServiceRows->computers_service_havebattery == 1) &nbsp;БАТЕРИЯ: ДА @else &nbsp;БАТЕРИЯ: НЕ @endif</td></tr>
                            @else
                            @endif
                        </table>
                    </td>
                    @endif
                </tr>
                <tr><td height="30"></td></tr>
                <tr>
                    <td colspan="5">
                        <table width="100%">                                
                            <tr><td class="calibri20">&nbsp;ПРОБЛЕМ/И</td></tr>
                            <tr><td style="border-bottom: 1px solid #999;"></td></tr>
                            <tr><td class="">&nbsp;&nbsp;{{$getServiceRows->computers_service_complaint}}</td></tr>
                            <tr><td height="30"></td></tr>
                            <tr><td class="calibri20">&nbsp;ЗАБЕЛЕЖКИ</td></tr>
                            <tr><td style="border-bottom: 1px solid #999;"></td></tr>
                            <tr><td class="">
                                    @if(!empty($getServiceRows->computers_service_description))&nbsp;&nbsp;{{$getServiceRows->computers_service_description}}
                                    @else &nbsp;&nbsp;няма забележки
                                    @endif
                            </td></tr>
                            <tr><td height="30"></td></tr>
                            <tr><td class="calibri20">&nbsp;ИСТОРИЯ</td></tr>
                            <tr><td style="border-bottom: 1px solid #999;"></td></tr>
                            <tr><td height="10"></td></tr>
                            <div id="storepcserviceupdate" class="modal fade" role="dialog">
                            <tr>
                                <td>
                                    <table class="table table-bordered" style="border: 3px solid #fff;">
                                        <?php $nsu = 1; ?>
                                        @foreach(\App\PCServices::getServiceUpdates($getServiceRows->computers_service_id) as $serviceUpdates)
                                        <tr>
                                            <td>#{{$nsu++}}</td>
                                            <td>{{\App\General::showDateTime($serviceUpdates->computers_service_update_added)}}</td>
                                            <!--<td>{{$serviceUpdates->name}}</td>-->
                                            <td width="60%">{{$serviceUpdates->computers_service_update}}</td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr align="center">
                    <td colspan="5">
                        <a class="btn btn-info noPrint" id="autoprint" href="javascript:window.print()"> ПРИНТИРАЙ </a>
                        <a class="btn btn-warning noPrint" href="{{url('/pcs/active')}}"> АКТИВНИ УСЛУГИ </a>
                        <a class="btn btn-danger noPrint" href="{{ URL::previous() }}"> НАЗАД </a>
                    </td>
                </tr>
                <tr><td colspan="5" height="50" style="border-bottom: 1px solid #999;"></td></tr>
                <tr><td class="text-center">www.gstore.bg</td><td colspan="3" class="text-center">www.guliatgroup.com</td><td class="text-left">www.poluchi.me</td></tr>
            </table>  
            @endforeach
            <!-- END OF COMPUTERS SERVICE CONTENT -->
        </div>
    </div>
</div>
    <script type="text/javascript">
<!--
window.print();
//-->
</script>
@endsection