@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4">
            <div class="panel panel-default text-center">
                <div class="panel-heading calibri20">
                    КАКВО ДА СЕ ФАКТУРИРА ?
                </div>
                <div class="panel-body">
                    <span class="calibri15">ОТВОРЕНИ ПРОТОКОЛИ</span>
                    <table class="table table-bordered">
                        @foreach($getOrders as $getOrder)
                        <tr>
                            <td class="text-left">
                                <input type="checkbox" value="{{$getOrder->order_id}}" name="order_id" />
                                #{{$getOrder->order_id}} - <a href="{{url('/order/')}}/{{$getOrder->order_id}}"> ВИЖ ПРОТОКОЛА </a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    <button class="btn btn-gwms">НАПРЕД</button>
                    <br />или<br />
                    <form class="form-horizontal" role="form" method="POST" action="{{url('/storeneworder')}}">
                        {!! csrf_field() !!}
                        <input type="hidden" value="{{$companyid}}" name="general_company_id" />
                        <button type="submit" class="btn btn-gwms ladda-button" data-style="expand-left">НОВ ПРОТОКОЛ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection