@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading text-center">ДОБАВЯНЕ НА КОМПЮТЪРНА УСЛУГА</div>
                <div class="panel-body form-group">
                    <form role="form" method="POST" action="{{url('/storenewpcservice')}}">
                        {!! csrf_field() !!}
                        <input type="hidden" value="{{$customerid}}" name="general_customer_id" />
                        <input type="hidden" value="{{$deviceid}}" name="computers_device_id" />
                        
                        <label class="control-label">ОПЛАКВАНЕ</label>
                        <textarea class="form-control" name="computers_service_complaint"></textarea>
                        <label class="control-label">ЗАБЕЛЕЖКИ</label>
                        <textarea class="form-control" name="computers_service_description"></textarea>
                        <label class="control-label">ПРИБЛИЗИТЕЛНА ЦЕНА</label>
                        <input class="form-control"type="text" placeholder="приблизителна цена" name="computers_service_aboutprice" />
                        @if($categoryid == 1)
                        <div class="calibri20">
                        <input type="checkbox" value="1" name="computers_service_havebag" />
                        <label class="control-label">ЧАНТА</label><br />
                        <input type="checkbox" value="1" name="computers_service_havepower" />
                        <label class="control-label">ЗАРЯДНО</label><br />
                        <input type="checkbox" value="1" name="computers_service_havebattery" />
                        <label class="control-label">БАТЕРИЯ</label><br />
                        </div>
                        @endif
                        <br /><br />
                        <a href="{{URL::previous()}}" type="button" class="btn btn-danger"><i class="fa fa-arrow-left"></i> НАЗАД</a>
                        <button type="submit" class="btn btn-success ladda-button" data-style="expand-left"><i class="fa fa-arrow-down"></i> ДОБАВИ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
