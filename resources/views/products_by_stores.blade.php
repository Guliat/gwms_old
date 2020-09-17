@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row" style="font-size: 1.2vw;">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <?php $g = \App\Products::getStoreContent($storeid); ?>
                    @foreach($g as $storeContent)
                        {{$storeContent->store_name}}
                    @endforeach
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered">
                        <tr class="info text-center" style="font-size: 1vw;">
                            <td>КАТЕГОРИЯ</td>
                            <td>ПРОДУКТОВ КОД <br /> <u>СЕРИЕН НОМЕР</u></td>
                            <td>МОДЕЛ</td>
                            <td>ЦЕНА <br /> (без ДДС)</td>
                            <td>НАЛИЧНОСТ</td>
                        </tr>
                        @foreach($data as $getProduct)
                        <!-- CONTENT -->
                        <tr>
                            <td class="col-lg-2 text-center" style="vertical-align: middle;">
                                {{$getProduct->product_category}}
                            </td>
                            <td class="col-lg-2 text-center" style="vertical-align: middle;">
                                {{$getProduct->product_number}} <br />
                                <u>{{$getProduct->product_serialnumber}} </u>
                            </td>
                            <td class="col-lg-5" style="vertical-align: middle;">
                                <div class="tooltip-w padding-right10">
                                    <i class="fa fa-info warning fa-lg"></i>
                                    <span class="tooltiptext-w">{{$getProduct->product_description}}</span>
                                </div>
                                {{$getProduct->product_brandmodel}}
                            </td>
                            <td class="col-lg-1 text-right" style="vertical-align: middle;">
                                <?php echo round(($getProduct->product_sellprice), 2); ?>лв.
                                <div class="tooltip-g">
                                    <i class="fa fa-calculator success fa-lg"></i>
                                    <div class="tooltiptext-g">с 20% <br /><?php echo round(($getProduct->product_sellprice*1.2),2); ?>лв.</div>
                                </div>
                            </td>
                            <td class="col-lg-1 text-right" style="vertical-align: middle;" >
                                <?php $ava = \App\Products::avaliableProductsByStores($getProduct->product_id, $storeid); echo $ava; ?>
                                <div class="tooltip-g">
                                    <i class="fa fa-shopping-cart warning fa-lg"></i> 
                                    <div class="tooltiptext-g">@if($ava == $getProduct->product_quantity)НЯМА РЕГИСТРИРАНИ ПРОДАЖБИ @else ДОСТАВЕНИ {{round($getProduct->product_quantity)}}<br />ПРОДАДЕНИ <?php echo $getProduct->product_quantity - $ava; ?> @endif</div>                                </div>
                                <div class="tooltip-g">
                                    <i class="fa fa-truck danger fa-lg"></i>
                                    <div class="tooltiptext-g">ДОСТАВНА ЦЕНА {{round($getProduct->product_buyprice, 2)}}лв. (без ДДС)</div>
                                </div>
                            </td>
                            <td class="col-lg-1" style="vertical-align: middle;">
                                <div class="tooltip-g"><button class="btn btn-xs btn-info " data-toggle="modal" data-target="#updateProduct{{$getProduct->product_id}}"><i class="fa fa-pencil fa-wrap"></i><div class="tooltiptext-g">РЕДАКТИРАНЕ</div></button></div>
                                <div class="tooltip-g"><button class="btn btn-xs btn-success" data-toggle="modal" data-target="#sell{{$getProduct->product_id}}"><i class="fa fa-shopping-cart fa-wrap"></i><div class="tooltiptext-g">ПРОДАЖБА</div></button></div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    <center>{!! $data->links() !!}</center>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection