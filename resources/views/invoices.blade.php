@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default text-center">
                <div class="panel-heading calibri20">ПОСЛЕДНИТЕ 10 ФАКТУРИ ЗА ВСЯКА СОБСТВЕНА ФИРМА И ПОРЕДИЦА</div>
                <div class="panel-body">
                    <?php $oc = new App\OwnCompanies; ?>
                    @foreach($oc->getOwnCompanies() as $getOwnCompanies)
                    <table class="table table-striped table-bordered calibri15 text-left">
                        <tr>
                            <td colspan="5" class="calibri25">{{$getOwnCompanies->general_owncompany_name}}</td>
                            <?php $inv = new App\Invoices; ?>
                            @foreach($inv->getPrefixes($getOwnCompanies->general_owncompany_id) as $getPrefixes)
                            <tr><td colspan="4" class="warning calibri15">ПОРЕДИЦА - {{$getPrefixes->orders_invoices_prefix}}</td></tr>
                            <tr class="text-center info">
                                <td>КЛИЕНТ / ФИРМА</td>
						 <td>НОМЕР</td>
                                <td>ДАТА НА ФАКТУРА</td>
                                <td>СТОЙНОСТ</td>
                            </tr>
                            @foreach($inv->getInvoiceContentByPrefix($getPrefixes->orders_invoices_prefix_id) as $getInvoiceContentRows)
                            <tr class="text-center">
						 <td>
                                    @if($getInvoiceContentRows->general_customer_id != 0)
                                    {{$getInvoiceContentRows->general_customer_names}}
                                    @endif
                                    @if($getInvoiceContentRows->general_company_id != 0)
                                    {{$getInvoiceContentRows->general_company_name}} 
                                    @endif
                                </td>
                                <td>{{$getInvoiceContentRows->orders_invoices_prefix}}{{str_pad($getInvoiceContentRows->orders_invoice_number, 9, "0", STR_PAD_LEFT)}}</td>
                                <td>{{\App\General::showDate($getInvoiceContentRows->orders_invoice_date)}}</td>
                                <td>{{(float)$getInvoiceContentRows->orders_invoice_total}} лв.</td>
                                <td class="col-lg-2">
                                    <a href="{{url('')}}/num2.php?invoiceid={{$getInvoiceContentRows->orders_invoice_id}}&translate={{$getInvoiceContentRows->orders_invoice_total}}" class="btn btn-default tooltip-g"><i class="fa fa-eye fa-lg gray"></i><div class="tooltiptext-g">ОТВОРИ</div></a>
                                    <a href="{{url('/snapshot')}}/{{$getInvoiceContentRows->orders_invoice_id}}" class="btn btn-default tooltip-g"><i class="fa fa-lg fa-archive gray"></i><div class="tooltiptext-g">ОТВОРИ АРХИВИРАНАТА</div></a>
                                </td>
                            </tr>
                            @endforeach
                            @endforeach
                        </tr>
                    </table>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection