@extends('layouts.app')
@section('content')                   
<div class="container-fluid padding-top50 padding-bottom20">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center calibri20">{{$getCustomerContent['customernames']}}
                    @foreach($getCustomerContent['getCustomerContent'] as $getCustomerLevel)
                    @if($getCustomerLevel->general_customer_level == 1)
                    <div class="tooltip-d"><i class="fa fa-child gray fa-lg"></i>
                        <div class="tooltiptext-d">нормален клиент</div>
                    </div>
                    @elseif($getCustomerLevel->general_customer_level == 2)
                    <div class="tooltip-d"><i class="fa fa-child success fa-lg"></i>
                        <div class="tooltiptext-d">добър клиент</div>
                    </div>
                    @elseif($getCustomerLevel->general_customer_level == 3)
                    <div class="tooltip-d"><i class="fa fa-child danger fa-lg"></i>
                        <div class="tooltiptext-d">лош клиент</div>
                    </div>
                    @endif
                    @endforeach
                </div>
                <div class="panel-body">
                    <div class="col-lg-4">
                    @foreach($getCustomerContent['getCustomerContent'] as $getCustomerContentRows)
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td><label class="control-label">ПРЯКОР / НАПОМНЯНЕ:</label> {{$getCustomerContentRows->general_customer_nick}}</td>
                        </tr>
                        <tr>
                            <td><label class="control-label">ТЕЛЕФОН:</label> {{$getCustomerContentRows->general_customer_phone}}</td>
                        </tr>
                        <tr>
                            <td><label class="control-label">ТЕЛЕФОН 2:</label> {{$getCustomerContentRows->general_customer_phone2}}</td>
                        </tr>
                        <tr>
                            <td><label class="control-label">ДОБАВЕН НА:</label> {{$getCustomerContentRows->general_customer_added}}</td>
                        </tr>
                        <tr>
                            <td><label class="control-label">ДОБАВЕН ОТ:</label> {{$getCustomerContentRows->name}}</td>
                        </tr>
                        <tr><td><button class="btn btn-info" data-toggle="modal" data-target="#updatecustomer"><i class="fa fa-pencil fa-wrap"></i></button></td></tr>
                    </table>
                    <table class="table table-bordered">
                        <tr>
                            <td>@foreach($getCustomerContent['getCustomerOrders'] as $getCustomerOrdersRows)
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td>
                                ПРОТОКОЛ: {{$getCustomerOrdersRows->order_id}} <br />
                                ОТ: {{$getCustomerOrdersRows->order_added}}
                            </td>
                        </tr>
                    </table>
                    @endforeach
                    @foreach($getCustomerContent['getCustomerInvoices'] as $getCustomerInvoicesRows)
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td>
                                ФАКТУРА: {{$getCustomerInvoicesRows->orders_invoice_id}} <br />
                                ОТ: {{$getCustomerInvoicesRows->orders_invoice_added}}
                            </td>
                        </tr>
                    </table>
                    @endforeach
                    </td>
                        </tr>
                    </table>
                    </table>
                    @endforeach
                    </div>
                    <div class="col-lg-8">
                        <!-- UPDATE CUSTOMER CONTENT -->
                        <div id="updatecustomer" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form role="form" method="POST" action="{{url('updatecustomer')}}">
                                        {!! csrf_field() !!}
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title">РЕДАКТИРАНЕ</h4>
                                        </div>
                                        <div class="modal-body form-group">
                                            @foreach($getCustomerContent['getCustomerContent'] as $getCustomerContentRows)
                                            <input type="hidden" name="update_id" value="{{$getCustomerContentRows->general_customer_id}}" />
                                            <label class="control-label">ИМЕНА</label>
                                            <input class="form-control" type="text" value="{{$getCustomerContentRows->general_customer_names}}" name="general_customer_names" />
                                            <label class="control-label">НИК / НАПОМНЯНЕ</label>
                                            <input class="form-control" type="text" value="{{$getCustomerContentRows->general_customer_nick}}" name="general_customer_nick" />
                                            <label class="control-label">ТЕЛЕФОН</label>
                                            <input class="form-control" type="text" value="{{$getCustomerContentRows->general_customer_phone}}" name="general_customer_phone" />
                                            <label class="control-label">ТЕЛЕФОН 2</label>
                                            <input class="form-control" type="text" value="{{$getCustomerContentRows->general_customer_phone2}}" name="general_customer_phone2" />
                                            ДАТА НА ДОБАВЯНЕ
                                            <input class="form-control" type="text" name="general_customer_added" autocomplete="off" id="date" value="{{$getCustomerContentRows->general_customer_added}}" placeholder=" изберете дата">
                                            <script src="<?php echo asset('/js/pikaday.js')?>"></script>
                                            <script>var picker = new Pikaday({field: document.getElementById('date'), numberOfMonths:1});</script>
                                            <label class="control-label">СТАТУС</label>
                                            <select class="form-control" name="general_customer_level">
                                                <option value="1" <?php if($getCustomerContentRows->general_customer_level == 1) { echo "selected"; }?>>НОРМАЛЕН КЛИЕНТ</option>
                                                <option value="2" <?php if($getCustomerContentRows->general_customer_level == 2) { echo "selected"; }?>>ДОБЪР КЛИЕНТ</option>
                                                <option value="3" <?php if($getCustomerContentRows->general_customer_level == 3) { echo "selected"; }?>>ЛОШ КЛИЕНТ</option>
                                            </select>
                                            @endforeach
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success ladda-button" data-style="expand-left"><i class="fa fa-refresh"></i> ОБНОВИ</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> ОТКАЗ</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- END OF UPDATE CUSTOMER CONTENT -->
                        <div class="text-center calibri20">КОМПЮТЪРЕН СЕРВИЗ</div>
                        <hr />
                        <!-- LIST DEVICES AND SERVICES -->
                        <div class="text-left calibri25 margin5" style="border-bottom: 1px solid #88c101;">УСТРОЙСТВА</div>
                        @foreach($getCustomerContent['getCustomerDevices'] as $getCustomerDevicesRows)
                        <table class="table table-bordered calibri20 text-center">
                            <tr>
                                <td>{{$getCustomerDevicesRows->computers_device_category}} #{{$getCustomerDevicesRows->computers_device_id}}</td>
                                <td><a class="gwmsgreen" href="{{url('/pcs/device')}}/{{$getCustomerDevicesRows->computers_device_id}}">{{$getCustomerDevicesRows->computers_device_brandmodel}}</a></td>
                                <td>{{$getCustomerDevicesRows->computers_device_submodel}}</td>
                                <td>{{$getCustomerDevicesRows->computers_device_color}}</td>
                                <td>@if(!empty($getCustomerDevicesRows->computers_device_note)){{$getCustomerDevicesRows->computers_device_note}}@else<span class='calibri15'>няма забележки</span>@endif</td>
                                <td><button  class="btn btn-xs btn-warning" data-toggle="modal" data-target="#storenewpcservicetodevice{{$getCustomerDevicesRows->computers_device_id}}">ДОБАВИ УСЛУГА</button></td>
                                <div id="storenewpcservicetodevice{{$getCustomerDevicesRows->computers_device_id}}" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="POST" action="{{url('storenewpcservicetodevice')}}">
                                                {!! csrf_field() !!}
                                                <div class="modal-header">
                                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                  <h4 class="modal-title text-center">ДОБАВЯНЕ НА УСЛУГА</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" value="{{$getCustomerContentRows->general_customer_id}}" name="customerid" />
                                                    <input type="hidden" value="{{$getCustomerDevicesRows->computers_device_id}}" name="deviceid" />
                                                    <input class="form-control" type="text" placeholder="#" name="serviceid" />
                                                    <br />
                                                    <textarea class="form-control" name="complaint" placeholder="ОПЛАКВАНЕ"></textarea>
                                                    <br />
                                                    <textarea class="form-control" name="description" placeholder="ЗАБЕЛЕЖКИ"></textarea>
                                                    <br />
                                                    <input class="form-control" placeholder=" ПРИБЛИЗИТЕЛНА ЦЕНА" type="text" name="aboutprice" autocomplete="off" />
                                                    <br />
                                                    @if($getCustomerDevicesRows->computers_device_category_id == 1)
                                                    <label for="bag{{$getCustomerDevicesRows->computers_device_id}}">
                                                        <input type="checkbox" name="bag" id="bag{{$getCustomerDevicesRows->computers_device_id}}" value="1" />
                                                        <i></i><span> ЧАНТА</span>
                                                    </label>
                                                    <label for="power{{$getCustomerDevicesRows->computers_device_id}}">
                                                        <input type="checkbox" name="power" id="power{{$getCustomerDevicesRows->computers_device_id}}" value="1" />
                                                        <i></i><span> ЗАРЯДНО</span>
                                                    </label>
                                                    <label for="battery{{$getCustomerDevicesRows->computers_device_id}}">
                                                        <input type="checkbox" name="battery" id="battery{{$getCustomerDevicesRows->computers_device_id}}" value="1" />
                                                        <i></i><span> БАТЕРИЯ</span>
                                                    </label>
                                                    @endif
                                                    <input class="form-control text-center" type="text" autocomplete="off" placeholder="не избирай ако услугата е нова" name="serviceadded" id="date-service" />
                                                    <script>var picker = new Pikaday({field: document.getElementById('date-service'), numberOfMonths:1});</script>
                                                </div>
                                                <div class="modal-footer" style="padding-right: 20%;">
                                                    <button type="submit" class="btn btn-success ladda-button" data-style="expand-left">{!! Lang::get('general.button_add') !!}</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">{!! Lang::get('general.button_cancel') !!}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                            @foreach(\App\PCServices::getDeviceServices($getCustomerDevicesRows->computers_device_id) as $getDeviceServices)
                                <tr>
                                    <td><a class="gwmsgreen" href="{{url('/pcs/service/')}}/{{$getDeviceServices->computers_service_id}}">#{{$getDeviceServices->computers_service_id}}</a></td>
                                    <td colspan="5" class="text-left">{{$getDeviceServices->computers_service_complaint}}</td>
                                </tr>
                            @endforeach
                        </table>
                        @endforeach
                        <a href="{{url('/pcs/newdevice')}}?c={{$getCustomerContentRows->general_customer_id}}" class="btn btn-gwms">НОВО УСТРОЙСТВО</a>
                        <!-- END OF LIST DEVICES AND SERVICES -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $title = "КЛИЕНТ #".$getCustomerContent['customerid']; ?>
@endsection
