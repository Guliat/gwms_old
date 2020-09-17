@extends('layouts.app')
@section('content')
<div class="container-fluid padding-top20 padding-bottom20">
    <div class="row">
        <div class="col-xl-8 col-md-12 col-xl-offset-2">
            <!-- COMPUTERS DEVICE CONTENT -->
            <div class="panel panel-default text-left">
                <div class="panel-body">
                    @foreach(\App\getDeviceContent($deviceid) as $getDeviceRows)
                    <div class="col-lg-12 margin-bottom20">
                        <button class="btn btn-gwms" data-toggle="modal" data-target="#newpcservice">ДОБАВИ УСЛУГА </button>
                        <?php $g = new App\Http\Controllers\GeneralController(); $g->addCustomerModal('ДОБАВИ КЛИЕНТ', 'ДОБАВЯНЕ НА КЛИЕНТ КЪМ УСТРОЙСТВО', '', '/storecustomertodevice', $getDeviceRows->computers_device_id, '') ?>
                        <button class="btn btn-info">ДОБАВИ ФИРМА</button>
                    </div>
                    <div class="col-lg-12 calibri50 text-center gwmsgreen" style="border-bottom: 1px solid #88c101;">#{{$getDeviceRows->computers_device_id}} </div>
                    <div class="col-lg-6" style="border-right: 1px solid #88c101;">
                        <table class="table text-center calibri20">
                            <tr><td class="bottom-border">КАТЕГОРИЯ</td><td class="bottom-border">{{$getDeviceRows->computers_device_category}}</td></tr>
                            <tr><td class="bottom-border">МАРКА / МОДЕЛ</td><td class="bottom-border">{{$getDeviceRows->computers_device_brandmodel}}</td></tr>
                            <tr><td class="bottom-border">ПОДМОДЕЛ</td><td class="bottom-border">{{$getDeviceRows->computers_device_submodel}}</td></tr>
                            <tr><td class="bottom-border">ЦВЯТ</td><td class="bottom-border">{{$getDeviceRows->computers_device_color}}</td></tr>
                            <tr><td class="bottom-border">ЗАБЕЛЕЖКА</td><td class="bottom-border">{{$getDeviceRows->computers_device_note}}</td></tr>
                            <tr><td class="bottom-border">ДОБАВЕНО ОТ</td><td class="bottom-border">{{$getDeviceRows->name}}</td></tr>
                            <tr><td class="bottom-border">ДОБАВЕНО НА</td><td class="bottom-border">{{\App\showDate($getDeviceRows->computers_device_added)}}</td></tr>
                            <tr><td>ПОСЛЕДНО ОБНОВЕНО</td><td>{{\App\showDate($getDeviceRows->computers_device_updated)}}</td></tr>
                        </table>
                    </div>
                    <div class="col-lg-6 col-xs-12 calibri20 padding-top20">
                    <div class="padding-bottom10"><u>Клиенти и услуги свързани с това устройство</u></div>
                    @foreach(\App\getDeviceCustomers($deviceid) as $getDeviceCustomersRows)
                    <a href="{{url('/customer')}}/{{$getDeviceCustomersRows->general_customer_id}}">{{$getDeviceCustomersRows->general_customer_names}}</a>
                    <br />
                    УСЛУГИ:
                        @foreach(\App\getDeviceServices($deviceid, $getDeviceCustomersRows->general_customer_id) as $serviceslist)
                            <a href="{{url('/pcs/service')}}/{{$serviceslist->computers_service_id}}">#{{$serviceslist->computers_service_id}}</a> |
                        @endforeach
                        <hr />
                    @endforeach    
                    </div>                
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- MODALS -->
<!-- MODAL NEW PC SERVICE -->
<div id="newpcservice" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" method="POST" action="{{url('storenewpcservice')}}">
                {!! csrf_field() !!}
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">ДОБАВЯНЕ НА КОМПЮТЪРНА УСЛУГА КЪМ УСТРОЙСТВО #{{$deviceid}}</h4>
                </div>
                <div class="modal-body form-group">
                    <input type="hidden" value="{{$deviceid}}" name="computers_device_id" />
                    <label class="form-label">ИЗБЕРЕТЕ КЛИЕНТ</label>
                    <select class="form-control" name="general_customer_id">
                        @foreach(\App\getDeviceCustomers($deviceid) as $getDeviceCustomersRows)
                            <option value="{{$getDeviceCustomersRows->general_customer_id}}">{{$getDeviceCustomersRows->general_customer_names}}</option>
                        @endforeach
                    </select>
                    <br />
                    <label class="form-label">ОПЛАКВАНЕ</label>
                    <textarea class="form-control" type="text" placeholder="Напишете описанието тук" name="computers_service_complaint"></textarea>
                    <br />
                    <label class="form-label">ЗАБЕЛЕЖКА</label>
                    <textarea class="form-control" type="text" placeholder="Ако има забележки напишете ги тук" name="computers_service_description"></textarea>
                    <br />
                    <label class="form-label">ПРИБЛИЗИТЕЛНА ЦЕНА</label>
                    <input class="form-control" type="text" placeholder="Напишете прибизителната цена за услугата тук" name="computers_service_aboutprice" />
                    <br />
                    @foreach(\App\getDeviceContent($deviceid) as $getDeviceRows)
                    @if($getDeviceRows->computers_device_category_id == 1)
                    <label class="form-label">ЧАНТА, ЗАРЯДНО, БАТЕРИЯ</label>
                    <br />
                    <label for="bag">
                        <input type="checkbox" name="bag" id="bag" value="1"/>
                        <i></i><span> ЧАНТА</span>
                    </label>
                    <label for="power">
                        <input type="checkbox" name="power" id="power" value="1"/>
                        <i></i><span> ЗАРЯДНО</span>
                    </label>
                    <label for="battery">
                        <input type="checkbox" name="battery" id="battery" value="1"/>
                        <i></i><span> БАТЕРИЯ</span>
                    </label>
                    @else
                    @endif
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success ladda-button" data-style="expand-left"><i class="fa fa-arrow-down"></i> ДОБАВИ</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> ОТКАЗ</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $title = "УСТРОЙСТВО #".$deviceid ?>
@endsection