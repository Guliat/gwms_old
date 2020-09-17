@extends('layouts.app')
@section('content')
<div class="container-fluid padding-top20 padding-bottom50">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default text-left">
                <div class="panel-heading text-center calibri20">СКЛАД</div>
                <div class="panel-body">
                    <!-- STORE BUTTON -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-gwms dropdown-toggle" data-toggle="dropdown">ЗАРЕДИ СТОКА <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a data-toggle="modal" data-target="#storeproduct"> ЕДИНИЧНА БРОЙКА <br /> (със сериен номер)</a></li>
                            <li><a data-toggle="modal" data-target="#storeproducts"> МНОГО БРОЙКИ <br /> (еднакви продукти без серийни номера)</a></li>
                        </ul>
                    </div>
                    <script type="text/javascript">
                            $j(function() {
                            var availableTags = <?php $addBMDC = new App\AutoComplete(); $addBMDC->newproduct(); ?>;
                            $j("#addBMDC").autocomplete({
                                source: availableTags,
                                appendTo: "#storeproduct",
                                autoFocus:true,
                                minLength: 2
                                });
                            $j("#addBMDC2").autocomplete({
                                source: availableTags,
                                appendTo: "#storeproducts",
                                autoFocus:true,
                                minLength: 2
                                });
                            });
                        </script>
                        <!-- Autocomplete Providers -->
                        <script type="text/javascript">
                            $j(function() {
                            var availableTags = <?php $addProvider = new App\AutoComplete(); $addProvider->providertoproduct(); ?>;
                            $j("#addProvider").autocomplete({
                                source: availableTags,
                                appendTo: "#storeproduct",
                                autoFocus:true,
                                minLength: 2
                            });
                            $j("#addProvider2").autocomplete({
                                source: availableTags,
                                appendTo: "#storeproducts",
                                autoFocus:true,
                                minLength: 2
                            });
                            });
                        </script>
                        <!-- Store Product Modal -->
                        <div id="storeproduct" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{url('storeproduct')}}">
                                        {!! csrf_field() !!}
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title">ДОБАВЯНЕ НА ПРОДУКТ</h4>
                                        </div>
                                        <div class="modal-body">
                                            ДОСТАВЧИК
                                            <input class="form-control text-center" type="text" autocomplete="off" placeholder=" автоматично поле" name="providerid" id="addProvider" />
                                            ПРОДУКТ
                                            <input class="form-control text-center" type="text" autocomplete="off" placeholder=" автоматично поле" name="bmdcid" id="addBMDC" />
                                            <br />
                                            ДОСТАВНА ЦЕНА (без ДДС)
                                            <input class="form-control text-center" type="text" autocomplete="off" placeholder=" въведете доставната цена тук ..." value="" name="product_buyprice" />
                                            ПРОДАЖНА ЦЕНА (без ДДС)
                                            <input class="form-control text-center" type="text" autocomplete="off" placeholder=" въведете продажната цена тук ..." value="" name="product_sellprice" />
                                            СЕРИЕН НОМЕР
                                            <input class="form-control text-center" type="text" autocomplete="off" placeholder=" въведете серийния номер на продукта тук ..." value="" name="product_serialnumber" />
                                            <input type="hidden" value="1" name="product_quantity" />
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success ladda-button" data-style="expand-left">{!! Lang::get('general.button_add') !!}</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">{!! Lang::get('general.button_cancel') !!}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Store Products Modal -->
                        <div id="storeproducts" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{url('storeproduct')}}">
                                        {!! csrf_field() !!}
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title">ДОБАВЯНЕ НА ПРОДУКТИ</h4>
                                        </div>
                                        <div class="modal-body">
                                            ДОСТАВЧИК
                                            <input class="form-control text-center" type="text" placeholder=" Можете да търсите по ЕИК, фирма, адрес и МОЛ" name="providerid" id="addProvider2" />
                                            ПРОДУКТ
                                            <input class="form-control text-center" type="text" placeholder=" Можете да търсите по продуктов код, марка, модел и категория" name="bmdcid" id="addBMDC2" />
                                            <br />
                                            ДОСТАВНА ЦЕНА (без ДДС)
                                            <input class="form-control text-center" type="text" placeholder=" въведете доставната цена тук ..." value="" name="product_buyprice" />
                                            ПРОДАЖНА ЦЕНА (без ДДС)
                                            <input class="form-control text-center" type="text" placeholder=" въведете продажната цена тук ..." value="" name="product_sellprice" />
                                            КОЛИЧЕСТВО <div class="tooltip-g">( ? )<div class="tooltiptext-g">Внимание! Не може да се променя след добавянето.</div></div>
                                            <input class="form-control text-center" type="text" placeholder=" въведете количеството тук ..." value="" name="product_quantity" />
                                            <input type="hidden" autocomplete="off" placeholder="" value="" name="product_serialnumber" />
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success ladda-button" data-style="expand-left">{!! Lang::get('general.button_add') !!}</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">{!! Lang::get('general.button_cancel') !!}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <br /><br />
                    <table class="table table-striped table-bordered">
                        <tr class="info text-center">
                            <td>КАТЕГОРИЯ</td>
                            <td>ПРОДУКТОВ КОД <br /> <u>СЕРИЕН НОМЕР</u></td>
                            <td>МОДЕЛ</td>
                            <td>ПРОДАЖНА ЦЕНА <br /> (без ДДС)</td>
                            <td>НАЛИЧНОСТ</td>
                        </tr>
                        @foreach($getProducts as $getProduct)
                        @if($ava[$getProduct->product_id] != 0)
                        <!-- CONTENT -->
                        <tr class="calibri20">
                            <td class="col-lg-2 text-center" style="vertical-align: middle;">
                                {{$getProduct->product_category}}
                            </td>
                            <td class="col-lg-2 text-center" style="vertical-align: middle;">
                                {{$getProduct->product_number}} <br />
                                <u class="calibri15">{{$getProduct->product_serialnumber}} </u>
                            </td>
                            <td class="col-lg-5" style="vertical-align: middle;">
                                {{$getProduct->product_brandmodel}} <br />
                                <span class="calibri15">- {{$getProduct->product_description}}</span>
                            </td>
                            <td class="col-lg-1 text-center" style="vertical-align: middle;">
                                {{$getProduct->product_sellprice}} лв.
                                <br />
                                <div class="tooltip-g">
                                    <i class="fa fa-calculator success"></i>
                                    <div class="tooltiptext-g calibri15">с 20% <br /><?php echo round(($getProduct->product_sellprice*1.2),2); ?> лв.</div>
                                </div>
                            </td>
                            <td class="col-lg-1 text-center" style="vertical-align: middle;" >
                                {{$ava[$getProduct->product_id]}} бр.
                                <br />
                                <div class="tooltip-g">
                                    <i class="fa fa-shopping-cart warning"></i>
                                    <div class="tooltiptext-g calibri15">@if($ava[$getProduct->product_id] == $getProduct->product_quantity)НЯМА РЕГИСТРИРАНИ ПРОДАЖБИ @else ДОСТАВЕНИ {{$getProduct->product_quantity}}бр.<br />ПРОДАДЕНИ <?php echo $getProduct->product_quantity - $ava[$getProduct->product_id]; ?>бр. @endif</div>
                                </div>
                                <div class="tooltip-g">
                                    <i class="fa fa-truck danger"></i>
                                    <div class="tooltiptext-g calibri15">ДОСТАВНА ЦЕНА {{$getProduct->product_buyprice}}лв. (без ДДС)</div>
                                </div>
                            </td>
                            <td class="col-lg-1" style="vertical-align: middle;">
                                <div class="tooltip-g"><button class="btn btn-sm btn-info " data-toggle="modal" data-target="#updateProduct{{$getProduct->product_id}}"><i class="fa fa-pencil fa-wrap"></i><div class="tooltiptext-g">РЕДАКТИРАНЕ</div></button></div>
                                <div class="tooltip-g"><button class="btn btn-sm btn-success" data-toggle="modal" data-target="#sell{{$getProduct->product_id}}"><i class="fa fa-shopping-cart fa-wrap"></i><div class="tooltiptext-g">ПРОДАЖБА</div></button></div>
                            </td>
                        </tr>
                        @else 
                        @endif
                        <!-- Autocomplete Products -->
                        
                        <!-- Update Modal -->
                        <div id="updateProduct{{$getProduct->product_id}}" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{url('/updateproduct')}}">
                                        {!! csrf_field() !!}
                                        <input type="hidden" value="{{$getProduct->product_id}}" name="update_id" />
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title">РЕДАКЦИЯ</h4>
                                        </div>
                                        <div class="modal-body">
                                            КАТЕГОРИЯ
                                            <select class="form-control" name="product_category_id">
                                                @foreach($getCat as $getCatRows)
                                                <option <?php if($getProduct->product_category_id == $getCatRows->product_category_id) { echo "selected"; }?> value="{{$getCatRows->product_category_id}}">{{$getCatRows->product_category}}</option>
                                                @endforeach
                                            </select>
                                            МАРКА - МОДЕЛ
                                            <select class="form-control" name="product_bmd_id">
                                                @foreach($getBMD as $getBMDRows)
                                                <option value="{{$getBMDRows->product_bmd_id}}">{{$getBMDRows->product_brandmodel}}</option>
                                                @endforeach
                                            </select>
                                            ЦЕНА <input class="form-control" name="product_sellprice" value="{{$getProduct->product_sellprice}}" />
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success ladda-button" data-style="expand-left">ОБНОВИ</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">ОТКАЗ</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Sell Modal -->
                        <div id="sell{{$getProduct->product_id}}" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{url('')}}">
                                        {!! csrf_field() !!}
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title">{{$getProduct->product_brandmodel}}</h4>
                                        </div>
                                        <div class="modal-body">
                                          <p>хайде сега точно не продавай ...</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">ПРОДАЙ</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">ОТКАЗ</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </table>
                    <center>{!! $getProducts->links() !!}</center>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection