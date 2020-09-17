@extends('layouts.app')
@section('content')
<div class="container-fluid padding-top50 padding-bottom20">
    <div class="row">
        <!-- ERRORS -->
        @if ($errors->has())
            <div class="alert alert-danger margin10">
                <a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>
                @foreach ($errors->all() as $error)
                    {{ $error }}<br />        
                @endforeach
            </div>
        @endif
        <!-- INVOICES CONTENT -->
        <?php $oc = new App\OwnCompanies; ?>
        @foreach($oc->getOwnCompanies() as $getOwnCompanies)
        <div class="panel panel-default text-center shadow-all">
            <div class="panel-body">
                <table class="table table-striped table-bordered calibri15 text-left">
                    <tr>
                        <td class="calibri25">{{$getOwnCompanies->general_owncompany_name}}</td>
                    </tr>
                    <?php $inv = new App\Invoices; ?>
                    @foreach($inv->getPrefixes($getOwnCompanies->general_owncompany_id) as $getPrefixes)
                    @foreach($inv->getInvoiceContentByPrefixNonPaid($getPrefixes->orders_invoices_prefix_id) as $getInvoiceContentRows)
                    <tr class="text-left">
                        <td>
                            <div class="col-lg-2 col-xs-12 col-sm-4 left-border">
                                <a href="{{url('')}}/num2bgmoney.php?invoiceid={{$getInvoiceContentRows->orders_invoice_id}}&translate={{$getInvoiceContentRows->orders_invoice_total}}" class="btn btn-xs btn-default">ОТВОРИ</a>
                                @if($getInvoiceContentRows->orders_invoice_ispaid == 0)
                                <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#confirm{{$getInvoiceContentRows->orders_invoice_id}}">НЕПЛАТЕНА</button>
                                <div id="confirm{{$getInvoiceContentRows->orders_invoice_id}}" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content text-left">
                                            <form method="POST" action="{{url('/updateinvoicepaid')}}">
                                                {!! csrf_field() !!}
                                                <div class="modal-header">
                                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                  <h4 class="modal-title text-center">{{Lang::get('general.usuretitle')}}</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" value="{{$getInvoiceContentRows->orders_invoice_id}}" name="invoiceid" /> 
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
                                @else
                                @endif
                            </div>
                            <div class="col-lg-2 col-xs-12 col-sm-2 left-border">{{$getInvoiceContentRows->orders_invoices_prefix}}{{str_pad($getInvoiceContentRows->orders_invoice_number, 9, "0", STR_PAD_LEFT)}}</div>
                            <div class="col-lg-2 col-xs-12 col-sm-3 left-border">{{\App\General::showDate($getInvoiceContentRows->orders_invoice_date)}}</div>
                            <div class="col-lg-4 col-xs-12 col-sm-3 left-border">
                                @if($getInvoiceContentRows->general_customer_id != 0)
                                {{$getInvoiceContentRows->general_customer_names}}
                                @endif
                                @if($getInvoiceContentRows->general_company_id != 0)
                                {{$getInvoiceContentRows->general_company_name}} 
                                @endif
                            </div>
                            <div class="col-lg-2 col-xs-12 col-sm-3 left-border">{{(float)$getInvoiceContentRows->orders_invoice_total}}лв.</div>
                        </td>
                    </tr>
                    @endforeach
                    @endforeach
                </table>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection