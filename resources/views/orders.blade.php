@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default text-center">
                <div class="panel-heading calibri20">ОТВОРЕНИ ПРОТОКОЛИ</div>
                    <div class="panel-body">
                    <div class="text-left">
                        <button type="button" class="btn btn-gwms" data-toggle="modal" data-target="#confirm">НОВ ПРОТОКОЛ</button>
                        <div id="confirm" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content text-left">
                                    <form method="POST" action="{{url('/storeneworder')}}">
                                        {!! csrf_field() !!}
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title text-center">{{Lang::get('general.usuretitle')}}</h4>
                                        </div>
                                        <div class="modal-body">
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
                    </div>
                    <br />
                    <table class="table table-striped table-bordered calibri15">
                        <tr class="info">
                            <td>НОМЕР</td>
                            <td>КЛИЕНТ</td>
                            <td>БЕЛЕЖКА</td>
                            <td>ЗАПОЧНАТ НА</td>
                            <td>СТОЙНОСТ</td>
                        </tr>
                        @foreach(\App\getOrderContent() as $getOrderContentRows)
                        <tr>
                            <td>{{$getOrderContentRows->order_id}}</td>
                            <td>
                                @if($getOrderContentRows->general_customer_id != 0)
                                {{$getOrderContentRows->general_customer_names}}
                                @endif
                                @if($getOrderContentRows->general_company_id != 0)
                                {{$getOrderContentRows->general_company_name}} 
                                @endif
                            </td>
                            <td>{{$getOrderContentRows->order_note}}
                            <td>{{\App\showDate($getOrderContentRows->order_added)}}</td>
                            <td>
                            <?php
                            $totalproducts = null;
                            $totalservices = null;
                            $products = null;
                            $services = null;
                            $productprice = null;
                            $serviceprice = null;
                            $sumproducts = null;
                            $sumservices = null
                            ?>
                            @foreach(\App\getOrderProducts($getOrderContentRows->order_id) as $getOrderProductsRows)
                            <?php
                            if($getOrderProductsRows->orders_products_soldprice == 0) {
                                $productprice = $getOrderProductsRows->product_sellprice;
                            } else {
                                $productprice = $getOrderProductsRows->orders_products_soldprice;
                            }
                            $products[] = $getOrderProductsRows->orders_products_soldquantity*$productprice;
                            ?>
                            @endforeach
                            @foreach(\App\getOrderServices($getOrderContentRows->order_id) as $getOrderServicesRows)
                            <?php
                            if($getOrderServicesRows->orders_service_soldprice == 0) {
                                $serviceprice = $getOrderServicesRows->service_price;
                            } else {
                                $serviceprice = $getOrderServicesRows->orders_service_soldprice;
                            }
                            $services[] = $getOrderServicesRows->orders_service_soldquantity*$serviceprice;
                            ?>
                            @endforeach
                            <?php 
                            if(!empty($products)){
                            $sumproducts = array_sum($products);
                            }
                            if(!empty($services)) {
                            $sumservices = array_sum($services);
                            }
                            ?>
                            {{$sumproducts+$sumservices}} лв.
                                
                            </td>
                            <td><a href="{{url('/order')}}/{{$getOrderContentRows->order_id}}" class="btn btn-info btn-xs"> ОТВОРИ </a></td>
                        </tr>

                        @endforeach
                        <tr class="text-rihgt">
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection