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
        <!-- INVOICES FILTERS -->
        <div class="panel panel-default shadow-all">
            <div class="panel-body">
                <form method="POST" action="{{url('searchinvoices')}}">
                    {!! csrf_field() !!}
                    <div class="col-lg-3">
                        НОМЕР НА ФАКТУРА
                        <input type="text" class="form-control" placeholder="НОМЕР НА ФАКТУРА" name="invoice_id" />
                    </div>
                    <div class="col-lg-3">
                        ДАТА
                        <input type="text" class="form-control" placeholder="ДАТА НА ИЗДАВАНЕ" autocomplete="off" name="date" id="date" />
                        <script src="<?php echo asset('/js/pikaday.js')?>"></script>
                        <script>var picker = new Pikaday({field: document.getElementById('date'), numberOfMonths:1});</script>
                    </div> 
                    <div class="col-lg-3">
                        ПОЛУЧАТЕЛ (ФИРМА)
                        <script type="text/javascript">
                            $j(function() {
                            var availableTags = <?php $Companies = new App\AutoComplete(); $Companies->companies(); ?>;
                            $j("#company").autocomplete({
                                source: availableTags,
                                autoFocus:true,
                                minLength: 2
                                });
                            });
                        </script>
                        <input type="text" class="form-control" placeholder="ФИРМАТА ПОЛУЧИЛА ФАКТУРАТА" name="company_id" id="company" />
                    </div>
                    <div class="col-lg-3">
                        ПОЛУЧАТЕЛ (КЛИЕНТ)
                        <script type="text/javascript">
                            $j(function() {
                            var availableTags = <?php $invoicesCustomers = new App\AutoComplete(); $invoicesCustomers->customers(); ?>;
                            $j("#customer").autocomplete({
                                source: availableTags,
                                autoFocus:true,
                                minLength: 2
                                });
                            });
                        </script>
                        <input type="text" class="form-control" placeholder="КЛИЕНТА ПОЛУЧИЛ ФАКТУРАТА" name="customer_id" id="customer"/>
                    </div>
                    <div class="col-lg-12 text-left">
                        <button type="submit" class="btn btn-gwms ladda-button form-control margin-top10" data-style="zoom-in">ТЪРСИ</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- RESULT CONTENT -->
        <div class="panel panel-default text-center>"
            <div class="panel-body">
                <table class="table table-striped table-bordered calibri15 text-left" style="margin-bottom: 0;">
                    @if(!empty($data1))
                    @foreach($data1 as $data)
                    <tr class="text-center">
                        <td>
                            <div class="col-lg-1 col-xs-12 col-sm-4 left-border text-left">
                                <a href="{{url('')}}/num2bgmoney.php?invoiceid={{$data->orders_invoice_id}}&translate={{$data->orders_invoice_total}}" class="btn btn-xs btn-default">ОТВОРИ</a>
                                @if($data->orders_invoice_ispaid == 0)
                                <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#confirm{{$data->orders_invoice_id}}">НЕПЛАТЕНА</button>
                                <div id="confirm{{$data->orders_invoice_id}}" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content text-left">
                                            <form method="POST" action="{{url('/updateinvoicepaid')}}">
                                                {!! csrf_field() !!}
                                                <div class="modal-header">
                                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                  <h4 class="modal-title text-center">{{Lang::get('general.usuretitle')}}</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" value="{{$data->orders_invoice_id}}" name="invoiceid" /> 
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
                            <div class="col-lg-2 col-xs-12 col-sm-4 left-border text-left">{{$data->general_owncompany_name}}</div>
                            <div class="col-lg-2 col-xs-12 col-sm-4 left-border text-left">{{$data->orders_invoices_prefix}}{{str_pad($data->orders_invoice_number, 9, "0", STR_PAD_LEFT)}}</div>
                            @if(!empty($customer_id) && $customer_id >= 0)
                            <?php $customerContent = \App\Customers::getCustomerContent($customer_id); ?>
                            @foreach($customerContent as $customerRows)
                                <div class="col-lg-2 col-xs-12 col-sm-4 left-border text-left">{{$customerRows->general_customer_names}}</div>
                            @endforeach
                            @else
                            @endif
                            @if(!empty($company_id) && $company_id >= 0)
                            <?php $companyContent = \App\Companies::getCompanyContent($company_id); ?>
                            @foreach($companyContent as $companyRows)
                                <div class="col-lg-2 col-xs-12 col-sm-4 left-border text-left">{{$companyRows->general_company_name}}</div>
                            @endforeach
                            @else
                            @endif
                            <div class="col-lg-2 col-xs-12 col-sm-3 left-border text-left">{{\App\General::showDate($data->orders_invoice_date)}}</div>
                            <div class="col-lg-1 col-xs-12 col-sm-3 left-border text-left">@if($data->orders_invoice_isbank == 1) БАНКА @else КЕШ @endif</div>
                            <div class="col-lg-2 col-xs-12 col-sm-3 left-border text-left">{{(float)$data->orders_invoice_total}}лв.</div>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr><td class="text-center">НЯМА РЕЗУЛТАТИ</td></tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>
@endsection