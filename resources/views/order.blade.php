@extends('layouts.app')
@section('content')
<?php $orderidtitle = str_pad($orderid, 10, "0", STR_PAD_LEFT); ?>
<div class="container-fluid padding-top20 padding-bottom20">
    <div class="row">
        <div class="col-lg-3">
            <div class="panel panel-default text-center">
                <div class='panel-heading'>ПРОТОКОЛ</div>
                <div class="panel-body">
                <!-- ERRORS -->
                @if ($errors->has())
                    <div class="alert alert-danger margin10">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br />        
                        @endforeach
                    </div>
                @endif
                <!-- ERRORS END -->
                    <div class="text-left calibri20" style="border-left: 3px solid #ccc; padding-left: 10px;">
                        @foreach(\App\getOrderContent($orderid) as $orderContent)
                            #{{$orderidtitle}}
                            <br /><br />
                            започнат на {{ \App\General::showDate($orderContent->order_added) }}
                            <br />
                            последно обновен на: {{ \App\General::showDate($orderContent->order_updated) }}
                            <br />
                            @if($orderContent->order_finished == 0000-00-00) 
                            @else
                            {{\App\General::showDate($orderContent->order_finished)}}
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- ORDER NOTE -->
        <div class="col-lg-3 col-sm-12">
            <div class="panel panel-default text-center">
                <div class="panel-heading">БЕЛЕЖКА
                    <div class="tooltip-g">
                        <button class="btn btn-xs" data-toggle="modal" data-target="#updateorder">
                            <i class="fa fa-pencil fa-wrap"></i>
                            <span class="tooltiptext-g">РЕДАКТИРАЙ</span>
                        </button>
                    </div>
                </div>
                <div class="panel-body calibri20">
                    <div class="text-left calibri20" style="border-left: 3px solid #ccc; padding-left: 10px;">
                        {{$orderContent->order_note}}
                    </div>
                    <div id="updateorder" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content text-left">
                                <form method="POST" action="{{url('/updateorder')}}">
                                    {!! csrf_field() !!}
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      <h4 class="modal-title">БЕЛЕЖКА КЪМ ПРОТОКОЛА</h4>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="updateid" value="{{$orderid}}" />
                                        <textarea class="form-control" name="order_note">{{$orderContent->order_note}}</textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success ladda-button" data-style="expand-left">{!! Lang::get('general.button_update') !!}</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">{!! Lang::get('general.button_close') !!}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ORDER NOTE END -->
        <div class="col-lg-3">
            <div class="panel panel-default text-center">
                <div class='panel-heading'>КЛИЕНТ</div>
                <div class="panel-body">
                    <div class="text-left calibri20" style="border-left: 3px solid #ccc; padding-left: 10px;">
                        @if($orderContent->general_company_id == 0 && $orderContent->general_customer_id == 0)
                        <?php 
                            $g = new \App\Http\Controllers\GeneralController();
                            $g->addCompanyModal(
                            $modalbuttontext = \Illuminate\Support\Facades\Lang::get('general.button_addcompany'), 
                            $headertitle = \Illuminate\Support\Facades\Lang::get('general.modal_title_addcompany'), 
                            $bodytext = "",
                            $action = "/storecompanytoorder",
                            $updateid = $orderid, 
                            $buttonsize = " "
                            );
                        ?>
                        ||
                        <?php 
                            $g = new \App\Http\Controllers\GeneralController();
                            $g->addCustomerModal(
                            $modalbuttontext = \Illuminate\Support\Facades\Lang::get('general.button_addcustomer'), 
                            $headertitle = \Illuminate\Support\Facades\Lang::get('general.modal_title_addcustomer'), 
                            $bodytext = "",
                            $action = "/storecustomertoorder",
                            $updateid = $orderid, 
                            $buttonsize = " "
                            );
                        ?>
                        @elseif($orderContent->general_company_id >= 1)
                        {{$orderContent->general_company_name}} - {{$orderContent->general_company_phone}}
                        @else
                        {{$orderContent->general_customer_names}} - {{$orderContent->general_customer_nick}}, {{$orderContent->general_customer_phone}}
                        @endif
                    </div>    
                </div>
            </div>
        </div>
        <!-- PRODUCTS -->
        <div class="col-lg-12">
            <div class="panel panel-default text-center">
                <div class="panel-body">
                    <table class="table table-striped table-bordered calibri15">
                        <tr class="warning text-center"><td colspan="8" class="calibri20">СТОКИ</td></tr>
                        <tr class="info">
                            <td class="col-lg-1">#</td>
                            <td class="col-lg-1">ДОБАВЕНО НА</td>
                            <td class="col-lg-1">ПРОДУКТОВ КОД</td>
                            <td class="col-lg-1">СЕРИЕН НОМЕР</td>
                            <td class="col-lg-5">КАТЕГОРИЯ - ПРОДУКТ</td>
                            <td class="col-lg-1">КОЛИЧЕСТВО</td>
                            <td class="col-lg-1">ЕД. ЦЕНА</td>
                            <td class="col-lg-1">КР. ЦЕНА</td>
					  <td>NOTE</td>
                            <td></td>
                        </tr>
                        <?php
                        $totalproducts = null;
                        $totalservices = null;
                        $totalproductssum = null;
                        $totalservicessum = null;
                        $productsrownumber = 1;
                        $servicesrownumber = 1;
                        $products = null;
                        $services = null;
                        ?>
                        @foreach(\App\getOrderProducts($orderid) as $getOrderProduct)
                        <tr>
                            <td>{{$productsrownumber++}}</td>
                            <td>{{\App\General::showDate($getOrderProduct->orders_products_added)}}</td>
                            <td>{{$getOrderProduct->product_number}}</td>
                            <td>{{$getOrderProduct->product_serialnumber}}</td>
                            <td>{{$getOrderProduct->product_category}} - {{$getOrderProduct->product_brandmodel}}</td>
                            <td>{{$getOrderProduct->orders_products_soldquantity}}
                                @if($getOrderProduct->product_quantity_type == 1)
                                    {{Lang::get('orders.quantity_type_br')}}
                                @endif
                                @if($getOrderProduct->product_quantity_type == 2)
                                    {{Lang::get('orders.quantity_type_m')}}
                                @endif
                            </td>
                            <td class="text-right">
                                @if($getOrderProduct->orders_products_soldprice == 0)
                                {{$getOrderProduct->product_sellprice}} лв.
                                @else
                                {{$getOrderProduct->orders_products_soldprice}} лв.
                                @endif
                                @if($getOrderProduct->orders_products_soldprice != 0 && ($getOrderProduct->orders_products_soldprice < $getOrderProduct->product_sellprice) && ($getOrderProduct->orders_products_soldprice > $getOrderProduct->product_buyprice))
                                <div class="tooltip-g"><i class="fa fa-exclamation-triangle warning"></i><div class="tooltiptext-g">ВИЖ В ИНФОРМАЦИЯТА</div></div>
                                @endif
                                @if($getOrderProduct->orders_products_soldprice != 0 && ($getOrderProduct->orders_products_soldprice < $getOrderProduct->product_buyprice) || ($getOrderProduct->orders_products_soldprice == $getOrderProduct->product_buyprice))
                                <div class="tooltip-g"><i class="fa fa-exclamation-triangle danger"></i><div class="tooltiptext-g">ВИЖ В ИНФОРМАЦИЯТА</div></div>
                                @endif
                            </td>
                            <td class="text-right">
                                <?php 
                                    if($getOrderProduct->orders_products_soldprice == 0) {
                                        $products = $getOrderProduct->product_sellprice;
                                    } else {
                                        $products = $getOrderProduct->orders_products_soldprice;
                                    }
                                    $totalproducts = $getOrderProduct->orders_products_soldquantity*$products;
                                    $totalproductssum += $totalproducts;
                                ?>
                                {{number_format($totalproducts, 2)}} лв.
                            </td>
						<td> {{$getOrderProduct->note}} </td>	
                            <td>
                                <button class="btn btn-info btn-xs" data-toggle="modal" data-target="#updateorderproduct{{$getOrderProduct->orders_products_id}}"><i class="fa fa-info fa-wrap"></i></button>
                            </td>
                            <div id="updateorderproduct{{$getOrderProduct->orders_products_id}}" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content text-left">
                                        <form method="POST" action="{{url('/updateorderproduct')}}">
                                            {!! csrf_field() !!}
                                            <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              <h4 class="modal-title">ИНФОРМАЦИЯ</h4>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="orderid" value="{{$orderid}}" />
                                                <input type="hidden" name="update_id" value="{{$getOrderProduct->orders_products_id}}" />
                                                <label class="control-label">ПРОДУКТ</label><br />
                                                <span>
                                                    <b>{{$getOrderProduct->product_brandmodel}}</b><br />
                                                    {{$getOrderProduct->product_description}}
                                                </span><br /><hr />
                                                <?php
                                                    if(($getOrderProduct->orders_products_soldprice != 0 && $getOrderProduct->orders_products_soldprice < $getOrderProduct->product_sellprice) && ($getOrderProduct->orders_products_soldprice  > $getOrderProduct->product_buyprice )) {
                                                        $razlika1а = number_format($getOrderProduct->orders_products_soldprice - $getOrderProduct->product_sellprice, 2);
                                                        $razlika1 = number_format($razlika1а * $getOrderProduct->orders_products_soldquantity, 2);
                                                        if($getOrderProduct->orders_products_soldquantity > 1) {
                                                            echo "<span class='warning'>Цената е по-ниска от продажната с $razlika1 лева за цялото количество или $razlika1а лева за брой !</span>";
                                                        } else {
                                                            echo "<span class='warning'>Цената е по-ниска от продажната с $razlika1 лева !</span>";
                                                        }
                                                    }
                                                    if($getOrderProduct->orders_products_soldprice != 0 && $getOrderProduct->orders_products_soldprice == $getOrderProduct->product_buyprice) { 
                                                        echo "<span class='danger'>ВНИМАНИЕ ! Цената е равна на доставната !</span>";
                                                    }
                                                    if($getOrderProduct->orders_products_soldprice != 0 && $getOrderProduct->orders_products_soldprice < $getOrderProduct->product_buyprice) { 
                                                        $razlika2a = number_format($getOrderProduct->orders_products_soldprice - $getOrderProduct->product_buyprice, 2);
                                                        $razlika2 = number_format($razlika2a * $getOrderProduct->orders_products_soldquantity, 2);
                                                        if($getOrderProduct->orders_products_soldquantity > 1) {
                                                            echo "<span class='danger'>ВНИМАНИЕ ! Цената е по-ниска от доставната с $razlika2 лева за цялото количество или $razlika2a лева за брой !</span>";
                                                        } else {
                                                            echo "<span class='danger'>ВНИМАНИЕ ! Цената е по-ниска от доставната с $razlika2 лева !</span>";
                                                        }
                                                    }
                                                    if($getOrderProduct->orders_products_soldprice != 0 && $getOrderProduct->orders_products_soldprice > $getOrderProduct->product_sellprice) { 
                                                        $razlika3a = number_format($getOrderProduct->orders_products_soldprice - $getOrderProduct->product_sellprice, 2);
                                                        $razlika3 = number_format($razlika3a * $getOrderProduct->orders_products_soldquantity, 2);
                                                        if($getOrderProduct->orders_products_soldquantity > 1) {
                                                            echo "<span class='success'>Цената е над продажната с $razlika3 лева за цялото количество или $razlika3a лева за брой.</span>";
                                                        } else {
                                                            echo "<span class='success'>Цената е над продажната с $razlika3 лева.</span>";
                                                        }
                                                    }
                                                    ?>
                                                @if($orderContent->order_isactive !=0)
                                                <hr />
                                                <label class="control-label">ЦЕНА</label>
                                                <input class="form-control" type="text" autocomplete="off" value="<?php if($getOrderProduct->orders_products_soldprice == 0){ echo $getOrderProduct->product_sellprice; } else { echo $getOrderProduct->orders_products_soldprice;} ?>" name="orders_products_soldprice" />
                                                <label class="control-label">КОЛИЧЕСТВО</label>
                                                <input class="form-control" type="text" autocomplete="off" value="{{$getOrderProduct->orders_products_soldquantity}}" name="orders_products_soldquantity" />
                                                @else 
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                @if($orderContent->order_isactive !=0)
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#returnorderproduct{{$getOrderProduct->orders_products_id}}">{!! Lang::get('general.button_returnproduct') !!}</button>
                                                <button type="submit" class="btn btn-success ladda-button" data-style="expand-left">{!! Lang::get('general.button_update') !!}</button>
                                                @else
                                                @endif
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">{!! Lang::get('general.button_close') !!}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div id="returnorderproduct{{$getOrderProduct->orders_products_id}}" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content text-left">
                                        <form method="POST" action="{{url('/returnorderproduct')}}">
                                            {!! csrf_field() !!}
                                            <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              <h4 class="modal-title text-center">{{Lang::get('general.usuretitle')}}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="orderid" value="{{$orderid}}" />
                                                <input type="hidden" name="update_id" value="{{$getOrderProduct->orders_products_id}}" />
                                                <div class="text-center calibri20">{{Lang::get('general.pleaseconfirm')}}</div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success ladda-button" data-style="expand-left">{!! Lang::get('general.button_confirm') !!}</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">{!! Lang::get('general.button_cancel') !!}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        @endforeach
                        <tr class="warning">
                            <td colspan="5" class="text-left">
                                @if($orderContent->order_isactive !=0)
                                <button class="btn btn-gwms" data-toggle="modal" data-target="#storeproductstoorder">ДОБАВИ ПРОДУКТ</button>
                                @else
                                @endif
                            </td>
                            <td colspan="3" class="text-right calibri20">ОБЩО ПРОДУКТИ: {{number_format($totalproductssum, 2)}} лв.</td>
                        </tr>
                    </table>
                            <script type="text/javascript">
                            $j(function() {
                            var availableTags = <?php $addProductToOrder = new App\AutoComplete(); $addProductToOrder->products(); ?>;
                            $j("#addProduct").autocomplete({
                                source: availableTags,
                                appendTo: "#storeproductstoorder",
                                autoFocus:true,
                                minLength: 2
                                });
                            });
                            </script>
                            <div id="storeproductstoorder" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content text-left">
                                        <form method="POST" action="{{url('/storeproductstoorder')}}">
                                            {!! csrf_field() !!}
                                            <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              <h4 class="modal-title">ДОБАВЯНЕ НА ПРОДУКТ</h4>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="orderid" value="{{$orderid}}" />
                                                <label class="control-label">ПРОДУКТ</label>
                                                <input class="form-control text-center" type="text" autocomplete="off" placeholder="автоматично поле" name="productid" id="addProduct" />
                                                Можете да търсите по: продуктов код, категория, марка и модел, сериен номер, цена
                                                <br />
                                                <label class="control-label">КОЛИЧЕСТВО</label>
                                                <input class="form-control" type="text" autocomplete="off" placeholder="количеството, което искате да добавите в протокола" name="orders_products_soldquantity" />
                                                <label class="control-label">ЦЕНА</label>
                                                <input class="form-control" type="text" autocomplete="off" placeholder="продажна цена, АКО Е РАЗЛИЧНА ОТ ПЪРВОНАЧАЛНО ВЪВЕДЕНАТА" name="orders_products_soldprice" />
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success ladda-button" data-style="expand-left">{!! Lang::get('general.button_add') !!}</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">{!! Lang::get('general.button_cancel') !!}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                </div>
            </div>
            <div class="panel panel-default text-center">
                <div class="panel-body">
                    <!-- SERVICES -->
                    <table class="table table-striped table-bordered calibri15">
                        <tr class="warning text-center"><td colspan="7" class="calibri20">УСЛУГИ</td></tr>
                        <tr class="info">
                            <td class="col-lg-1">#</td>
                            <td class="col-lg-1">ДОБАВЕНО НА</td>
                            <td class="col-lg-2">КАТЕГОРИЯ</td>
                            <td class="col-lg-2">УСЛУГА</td>
                          <td class="col-lg-1">КОЛИЧЕСТВО</td>
                          <td class="col-lg-2">ЕД.ЦЕНА</td>
                          <td class="col-lg-2">КР.ЦЕНА</td>
					 <td class="col-lg-1">NOTE</td>
                            <td></td>
                        </tr>
                        @foreach(\App\getOrderServices($orderid) as $getOrderService)
                        <tr>
                            <td>{{$servicesrownumber++}}</td>
                            <td>{{\App\General::showDate($getOrderService->orders_service_added)}}</td>
                            <td>{{$getOrderService->services_category}}</td>
                            <td>{{$getOrderService->service}}</td>
                            <td>{{$getOrderService->orders_service_soldquantity}} бр.</td>
                            <td>
                                @if($getOrderService->orders_service_soldprice == 0)
                                {{$getOrderService->service_price}} лв.
                                @else
                                {{$getOrderService->orders_service_soldprice}} лв.
                                @endif
                            </td>
                            <td>
                                <?php 
                                    if($getOrderService->orders_service_soldprice == 0) {
                                        $services = $getOrderService->service_price;
                                    } else {
                                        $services = $getOrderService->orders_service_soldprice;
                                    }
                                    $totalservices = $getOrderService->orders_service_soldquantity*$services;
                                    $totalservicessum += $totalservices;
                                ?>
                                {{number_format($totalservices, 2)}} лв.
                            </td>
					   <td> {{$getOrderService->orders_service_note}} </td>
                            <td><button class="btn btn-info btn-xs" data-toggle="modal" data-target="#updateorderservice{{$getOrderService->orders_service_id}}"><i class="fa fa-pencil"></i></button></td>
                        </tr>
                            <div id="updateorderservice{{$getOrderService->orders_service_id}}" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content text-left">
                                        <form method="POST" action="{{url('/updateorderservice')}}">
                                            {!! csrf_field() !!}
                                            <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              <h4 class="modal-title">РЕДАКТИРАНЕ</h4>
                                            </div>
                                            <div class="modal-body">
                                                <span class="calibri20"> {{$getOrderService->service}} </span><br /><br />
                                                <input type="hidden" name="orderid" value="{{$orderid}}" />
                                                <input type="hidden" name="update_id" value="{{$getOrderService->orders_service_id}}" />
                                                <label class="control-label">КОЛИЧЕСТВО</label>
                                                <input class="form-control" type="text" value="{{$getOrderService->orders_service_soldquantity}}" name="orders_service_soldquantity" />
                                                <label class="control-label">ЦЕНА</label>
                                                <input class="form-control" type="text" value="<?php if($getOrderService->orders_service_soldprice != 0){ echo $getOrderService->orders_service_soldprice; } else { echo $getOrderService->service_price;} ?>" name="orders_service_soldprice" />
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success ladda-button" data-style="expand-left">{!! Lang::get('general.button_update') !!}</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">{!! Lang::get('general.button_cancel') !!}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <tr>
                            <td colspan="5" class="text-left">
                                @if($orderContent->order_isactive !=0)
                                <button class="btn btn-gwms" data-toggle="modal" data-target="#storeservicestoorder">ДОБАВИ УСЛУГА</button>
                                @else
                                @endif
                            </td>
                            <td colspan="2" class="text-right calibri20">ОБЩО УСЛУГИ: {{number_format($totalservicessum, 2)}} лв.</td>
                        </tr>
                        <script type="text/javascript">
                        $j(function() {
                        var availableTags = <?php $addServiceToOrder = new App\AutoComplete(); $addServiceToOrder->services(); ?>;
                        $j("#addService").autocomplete({
                            source: availableTags,
                            appendTo: "#storeservicestoorder",
                            autoFocus:true,
                            minLength: 2
                            });
                        });
                        </script>
                        <div id="storeservicestoorder" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content text-left">
                                    <form method="POST" action="{{url('/storeservicestoorder')}}">
                                        {!! csrf_field() !!}
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title">ДОБАВЯНЕ НА УСЛУГА</h4>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="orderid" value="{{$orderid}}" />
                                            <label class="control-label">УСЛУГА</label>
                                            <input class="form-control text-center" type="text" autocomplete="off" placeholder=" Започнете да пишете услугата" name="serviceid" id="addService" />
                                            <br />
                                            <label class="control-label">КОЛИЧЕСТВО</label>
                                            <input class="form-control" type="text" autocomplete="off" placeholder="количеството, което искате да добавите в протокола" name="orders_service_soldquantity" />
                                            <label class="control-label">ЦЕНА</label>
                                            <input class="form-control" type="text" autocomplete="off" placeholder="цената, АКО Е РАЗЛИЧНА ОТ ПЪРВОНАЧАЛНО ВЪВЕДЕНАТА" name="orders_service_soldprice" />
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success ladda-button" data-style="expand-left">{!! Lang::get('general.button_add') !!}</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">{!! Lang::get('general.button_cancel') !!}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </table>
                </div>
            </div>
            <div class="panel panel-default text-center">
                <div class="panel-body">
                    <?php $total = $totalproductssum + $totalservicessum; ?>
                    <div class="text-center calibri35"> ОБЩО: {{number_format($total, 2)}}лв.</div>
                    @if($orderContent->order_isactive !=0)
                    <form class="form-horizontal" role="form" method="POST" action="{{url('/newinvoice')}}">
                        {!! csrf_field() !!}
                        <input type="hidden" value="{{$orderid}}" name="orderid" /> 
                        <input type="hidden" value="{{$total}}" name="invoicetotal" />
                        <span class="danger">МОЛЯ, ИЗБЕРЕТЕ РАЗМЕРА НА ДДС КОЙТО ЩЕ СЕ ПРИБАВИ КЪМ КРАЙНАТА СТОЙНОСТ НА ФАКТУРАТА</span>
                        <div class="col-lg-6 col-lg-offset-3 padding-bottom20">
                            <select name="orders_invoice_tax" class="form-control">
                                <option value="1.00"> БЕЗ ДДС </option>
                                <option value="1.09"> 9% </option>
                                <option value="1.20"> 20% </option>
                            </select>
                        </div>
                        <input type="hidden" value="{{$orderContent->general_customer_id}}" name="general_customer_id" />
                        <input type="hidden" value="{{$orderContent->general_customer_names}}" name="general_customer_names" />
                        <input type="hidden" value="{{$orderContent->general_company_id}}" name="general_company_id" />
                        <input type="hidden" value="{{$orderContent->general_company_name}}" name="general_company_name" />
                        <input type="hidden" value="{{$orderContent->general_company_number}}" name="general_company_number" />
                        <input type="hidden" value="{{$orderContent->general_company_address}}" name="general_company_address" />
                        <input type="hidden" value="{{$orderContent->general_company_owner}}" name="general_company_owner" />
                        <button type="submit" class="btn btn-gwms btn-group-justified ladda-button" data-style="expand-left">ФАКТУРИРАЙ</button>
                    </form>
                    @else
                    <a class="btn btn-gwms btn-group-justified" href="/num2.php?invoiceid={{$orderContent->orders_invoice_id}}&translate={{$orderContent->orders_invoice_total}}" class="btn btn-info btn-xs"> ВИЖ ФАКТУРАТА </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<?php $title = "ПРОТОКОЛ #".$orderid; ?>