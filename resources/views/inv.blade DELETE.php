@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="panel">
                <?php $orderidtitle = str_pad($orderid, 10, "0", STR_PAD_LEFT); ?>
                <div class="panel-body">
                    <button class="btn btn-warning noPrint" onclick="window.print()"><i class="fa fa-print fa-lg"></i> ПРИНТИРАЙ </button>
                    <div class="col-lg-12 padding-bottom10 text-right" style="border-bottom: 1px solid #aaa;">
                        <img src="<?php echo asset('/logo.png'); ?>" width="300"/></div>
                    <table width="100%" height="300" border="0" rowspace="0" colspace="0">
                        <tr>
                            <td width="30%" valign="top" height="80" align="left" class="calibri25">
                            @foreach($getOrderContent as $orderContent)
                            ФАКТУРА <span class="calibri15">(оригинал) </span>
                                <br />
                                <span class="calibri15">№ {{$orderidtitle}} от {{date('d-m-Y', strtotime($orderContent->order_added)) }} </span>
                            @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td width="49%" valign="top">
                                <span class="calibri20">ПОЛУЧАТЕЛ</span>
                                <div style="border-top: 4px solid #f77901;padding-bottom: 10px;"></div>
                                <div>
                                    blalbal blala lblal bllal lblbl <br />
                                    blalbal blala lblal bllal lblbl <br />
                                    blalbal blala lblal bllal lblbl <br />
                                    blalbal blala lblal bllal lblbl <br />
                                    blalbal blala lblal bllal lblbl <br />
                                    blalbal blala lblal bllal lblbl <br />
                                </div>
                            </td>
                            <td width="49%" valign="top">
                                <span class="calibri20">ИЗДАТЕЛ</span>
                                <div style="border-top: 2px solid #f77901;padding-bottom: 10px;"></div>
                                <div>
                                    blalbal blala lblal bllal lblbl <br />
                                    blalbal blala lblal bllal lblbl <br />
                                    blalbal blala lblal bllal lblbl <br />
                                    blalbal blala lblal bllal lblbl <br />
                                    blalbal blala lblal bllal lblbl <br />
                                    blalbal blala lblal bllal lblbl <br />
                                </div>
                            </td>
                        </tr>
                    </table>
                    <table class="table table-striped text-center">
                        <tr style="border-bottom: 2px solid #f77901;border-top: 2px solid #f77901;">
                            <td>#</td>
                            <td>НАИМЕНОВАНИЕ НА СТОКИТЕ И УСЛУГИТЕ</td>
                            <td>КОЛИЧЕСТВО</td>
                            <td>ЕД. ЦЕНА</td>
                            <td>СТОЙНОСТ</td>
                        </tr>
                        <?php $productsrownumber = 1; ?>
                        @foreach($getOrderProducts as $getOrderProduct)
                        <tr>
                            <td>{{$productsrownumber++}}</td>
                            <td>{{$getOrderProduct->product_brandmodel}}</td>
                            <td style="min-width: 100px;">{{$getOrderProduct->orders_products_soldquantity}} бр.</td>
                            <td style="min-width: 100px;">{{$getOrderProduct->orders_products_soldprice}} лв.</td>
                            <td style="min-width: 100px;"> </td>
                        </tr>
                        @endforeach
                        <?php $servicesrownumber = $productsrownumber; ?>
                        @foreach($getOrderServices as $getOrderService)
                        <tr>
                            <td>{{$servicesrownumber++}}</td>
                            <td>{{$getOrderService->computers_service_solution}}</td>
                            <td> 1 бр.</td>
                            <td> 20.00 лв.</td>
                            <td> </td>
                        </tr>
                        
                        @endforeach
                    </table>
                    <table width="100%" border="0" rowspace="0" colspace="0" style="border-top: 2px solid #f77901;">
                        <tr><td height="10" colspan="5"></td></tr>
                        <tr>
                            <td width="70%">СЛОВОМ: 
                               
                               
                                {{$translate}} </td>
                            <td width="30%" class="calibri15 text-right">ВСИЧКО: <!-- {{number_format(1, 2)}}--> лв.</td>
                        <tr>
                        <tr>
                            <td class="text-left">ПЛАЩАНЕ: <?php if($orderContent->order_isbank == 1) { echo "по банков път"; } else { echo "в брой"; } ?> </td>
                            <td class="calibri15 text-right">ДДС (0%): 0.00 лв.</td>
                        </tr>
                        <tr>
                            <td>Основание на сделката: за неначисляване на данък чл.113, ал.9</td>
                            <td class="calibri15 text-right">ОБЩО: <!-- {{number_format(1, 2)}}--> лв.</td>
                        </tr>
                        <tr>
                            <td style="height:50px;"></td>
                            <td></td>
                        </tr>
                    </table>
                    <table width="100%" border="0" rowspace="0" colspace="0">
                        <tr>
                            <td width="50%" align="left">Получател: ______________ Някой Банан</td>
                            <td width="50%" align="right">Съставил: ______________ Някой Банан</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection