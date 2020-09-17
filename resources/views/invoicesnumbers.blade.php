@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4">
            <div class="panel panel-default text-center">
                <?php $inv = new App\Invoices; ?>
                @if(!empty($inv->getPrefixes($owncompanyid)))
                <div class="panel-heading calibri20">
                    ПОСЛЕДНИ СТЪПКИ
                </div>
                <div class="panel-body text-left">
                <form class="form-horizontal" role="form" method="POST" action="{{url('/storenewinvoice')}}">
                    {!! csrf_field() !!}
                    <input type="hidden" value="{{$general_customer_id}}" name="general_customer_id" />
                    <input type="hidden" value="{{$orders_invoice_tax}}" name="orders_invoice_tax" />
                    <input type="hidden" value="{{$orderid}}" name="orderid" />
                    <input type="hidden" value="{{$companyid}}" name="general_company_id" />
                    <input type="hidden" value="{{$owncompanyid}}" name="general_owncompany_id" />
                    <input type="hidden" value="{{$invoicetotal}}" name="invoicetotal" />
                    <input type="hidden" value="{{$owner}}" name="owner" />
                    <div class="tooltip-w">
                        <i class="fa fa-question fa-lg danger"></i>
                        <span class="tooltiptext-w">ИЗБЕРЕТЕ КЪМ КОЯ ПОРЕДИЦА ДА БЪДЕ ИЗДАДЕНА ФАКТУРАТА, НОМЕРАТА СА ПОСЛЕДНИТЕ КЪМ СЪОТВЕТНАТА ПОРЕДИЦА</span>
                    </div>
                    <select class="form-control" name="fullnumber">
                    @foreach($inv->getPrefixes($owncompanyid) as $prefixes)
                    @foreach($inv->getNumbersByPrefix($prefixes->orders_invoices_prefix_id) as $getNumberByPrefix)
                    <?php $invoicenumber = str_pad($getNumberByPrefix->orders_invoice_number, 9, "0", STR_PAD_LEFT); ?>
                    <option value="{{$prefixes->orders_invoices_prefix_id}}{{$invoicenumber}}">
                            ПОРЕДИЦА #{{$prefixes->orders_invoices_prefix}} / {{$prefixes->orders_invoices_prefix_comment}} / - {{$prefixes->orders_invoices_prefix}}{{$invoicenumber}}
                    </option>
                    @endforeach
                    @endforeach
                    </select>
                    <br />
                    ПОЛУЧАТЕЛ
                    <input class='form-control' type='text' autocomplete="off" value='{{$owner}}' placeholder="ПОЛУЧАТЕЛ (ако е различен от МОЛа)" name='recipient' />
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
                    <script src="js/pikaday.js"></script>
                    <script>var picker = new Pikaday({field: document.getElementById('date')});</script>
                </div>
                <div class="text-center">
                    <input name='next' type="submit" value="НАПРЕД" class="btn btn-gwms ladda-button" data-style="expand-left"><br /><br />
                </div>
                </form>
                <div class="panel-body text-center">
                <form class="form-horizontal" role="form" method="POST" action="{{url('/newinvoiceprefix')}}">
                    {!! csrf_field() !!}       
                    <input type="hidden" value="{{$orders_invoice_tax}}" name="orders_invoice_tax" />
                    <input type="hidden" value="{{$orderid}}" name="orderid" />
                    <input type="hidden" value="{{$companyid}}" name="general_company_id" />
                    <input type="hidden" value="{{$owncompanyid}}" name="general_owncompany_id" />
                    <input type="hidden" value="{{$invoicetotal}}" name="invoicetotal" />
                    <input name='newprefix' value="НОВА ПОРЕДИЦА" type="submit" class="btn btn-gwms text-center ladda-button" data-style="expand-left">
                </div>
                </form>
                @else
                <div class="panel-body text-center">
                ВСЕ ОЩЕ НЯМАТЕ ДОБАВЕНИ ПОРЕДИЦИ И НОМЕРА НА ФАКТУРИ.<br /><br />
                <form class="form-horizontal" role="form" method="POST" action="{{url('/newinvoiceprefix')}}">
                    {!! csrf_field() !!}       
                    <input type="hidden" value="{{$orders_invoice_tax}}" name="orders_invoice_tax" />
                    <input type="hidden" value="{{$orderid}}" name="orderid" />
                    <input type="hidden" value="{{$companyid}}" name="general_company_id" />
                    <input type="hidden" value="{{$owncompanyid}}" name="general_owncompany_id" />
                    <input type="hidden" value="{{$invoicetotal}}" name="invoicetotal" />
                    <input name='newprefix' value="НОВА ПОРЕДИЦА" type="submit" class="btn btn-gwms text-center ladda-button" data-style="expand-left">
                </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection