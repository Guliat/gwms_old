@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4">
            <div class="panel panel-default text-center">
                <div class="panel-heading calibri20">
                    ИЗДАВАНЕ НА НОВА ФАКТУРА
                </div>
                <div class="panel-body">
                    <span class="calibri15">ФАКТУРАТА ЩЕ БЪДЕ ИЗДАДЕНА НА:</span>
                    <table class="table table-bordered">
                        <tr>
                            <td class="text-right">ФИРМА</td>
                            <td class="text-left">{{$general_company_name}}</td>
                        </tr>
                        <tr>
                            <td class="text-right">ЕИК</td>
                            <td class="text-left">{{$general_company_number}}</td>
                        </tr>
                        <tr>
                            <td class="text-right">АДРЕС</td>
                            <td class="text-left">{{$general_company_address}}</td>
                        </tr>
                        <tr>
                            <td class="text-right">МОЛ</td>
                            <td class="text-left">{{$general_company_owner}}</td>
                        </tr>
                    </table>
                    <label class="form-label">ОТ КОЯ ФИРМА ИСКАТЕ ДА ИЗДАДЕТЕ ФАКТУРАТА</label>
                    <form class="form-horizontal" role="form" method="POST" action="{{url('/getinvoicesnumbers')}}">
                        {!! csrf_field() !!}
                        <input type="hidden" value="{{$orders_invoice_tax}}" name="orders_invoice_tax" />
                        <input type="hidden" value="{{$orderid}}" name="orderid" />
                        <input type="hidden" value="{{$invoicetotal}}" name="invoicetotal" />
                        <input type="hidden" value="{{$companyid}}" name="general_company_id" />
                        <input type="hidden" value="{{$general_company_owner}}" name="owner" />
                        <select class="form-control" name="general_owncompany_id">
                            @foreach($getOwnCompanies as $getOwnCompany)
                            <option value="{{$getOwnCompany->general_owncompany_id}}">{{$getOwnCompany->general_owncompany_number}} - {{$getOwnCompany->general_owncompany_name}}</option>
                            @endforeach
                        </select>   
                        <br />
                        <button class="btn btn-gwms ladda-button" data-style="expand-left" > НАПРЕД </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection