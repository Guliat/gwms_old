@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4">
            <div class="panel panel-default text-center">
                <div class="panel-heading calibri20">
                    ВЪВЕЖДАНЕ НА НОВА ПОРЕДИЦА ЗА ФАКТУРИРАНЕ
                </div>
                <div class="panel-body text-left">
                <form class="form-horizontal" role="form" method="POST" action="{{url('/storenewinvoiceprefix')}}">
                    {!! csrf_field() !!}   
                    <div class="text-left">
                    Моля въведете номера на поредицата, която искате да започнете.<br />
                    НАПРИМЕР:<br />
                    0 - В КЕШ, МАГАЗИН 1, КАСОВ АПАРАТ - (0000000001)<br />
                    1 - ПО БАКОВ ПЪТ, ОНЛАЙН ПЛАЩАНИЯ - (1000000001)<br />
                    </div>
                    <br />
                    <input type="hidden" value="{{$orders_invoice_tax}}" name="orders_invoice_tax" />
                    <input type="hidden" value="{{$orderid}}" name="orderid" />
                    <input type="hidden" value="{{$companyid}}" name="general_company_id" />
                    <input type="hidden" value="{{$owncompanyid}}" name="general_owncompany_id" />
                    <input type="hidden" value="{{$invoicetotal}}" name="invoicetotal" />
                    НОМЕР НА ПОРЕДИЦА
                    <input class="form-control" type="text" value="" placeholder="въведете първата цифра от поредицата" name="orders_invoices_prefix" /><br />
                    ОПИСАНИЕ / КОМЕНТАР
                    <textarea class="form-control" placeholder="въведете описание/коментар за поредицата (до 50 символа)" name="orders_invoices_prefix_comment"></textarea><br />
                    <div class="tooltip-w">
                        <i class="fa fa-question fa-lg danger"></i>
                        <div class="tooltiptext-w">В СЛУЧАЙ ЧЕ СТЕ ПОЛЗВАЛИ ДРУГ МЕТОД ЗА ФАКТУРИРАНЕ, ВЪВЕДЕТЕ СЛЕДВАЩИЯ НОМЕР НА ФАКТУРАТА СПОРЕД ВАШАТА НОМЕРАЦИЯ. АКО ПОЧВАТЕ НОВА ПОРЕДИЦА ИЛИ НЯМАТЕ ИЗДАВАНИ ФАКТУРИ ДОСЕГА НАПИШЕТЕ 1.</div>
                    </div>
                    ПЪРВИЯ НОМЕР НА ФАКТУРАТА КЪМ ТАЗИ ПОРЕДИЦА
                    <input class="form-control" type="text" value="" placeholder="въведете първия номер на фактурата към тази поредица" name="firsttoprefix" />
                    <br />
                    ПОЛУЧАТЕЛ
                    <input class='form-control' type='text' autocomplete="off" value='' placeholder="ПОЛУЧАТЕЛ (ако е различен от МОЛа)" name='recipient' />
                    <br />
                    ДОПЪЛНИТЕЛЕН РЕД КЪМ ФАКТУРАТА
                    <input class='form-control' type='text' autocomplete="off" value='' placeholder=" например: разхода е за проект ЕС8899" name='customrow' />
                    <br />
                    НАЧИН НА ПЛАЩАНЕ
                    <select class='form-control' name='payment'>
                        <option value='0'>В БРОЙ</option>
                        <option value='1'>ПО БАНКОВ ПЪТ</option>
                    </select>
                    <br />
                    ДАТА НА ФАКТУРА
                    <input class="form-control" type="text" name="orders_invoice_date" autocomplete="off" id="date" value="{{$now}}" placeholder=" изберете дата">
                    <script src="/js/pikaday.js"></script>
                    <script>var picker = new Pikaday({field: document.getElementById('date')});</script>
                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn btn-gwms ladda-button" data-style="expand-left"> НАПРЕД </button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection