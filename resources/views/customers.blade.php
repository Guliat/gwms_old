@extends('layouts.app')
@section('content')
<div class="container-fluid padding-top50 padding-bottom50">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default text-center">
               
                <!-- ERRORS -->
                @if ($errors->has())
                    <div class="alert alert-danger margin10">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br />        
                        @endforeach
                    </div>
                @endif
                <!-- ERRORS END -->
                <div class="panel-body">
                    <!-- STORE NEW CUSTOMER -->
                    <div class="col-lg-12 text-left">
                        <button class="btn btn-gwms" data-toggle="modal" data-target="#storeCustomer">{!! Lang::get('customers.button_store_customer') !!}</button>
                        <!-- STORE NEW CUSTOMER MODAL -->
                        <div id="storeCustomer" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content"> 
                                    <form method="POST" action="{{url('storecustomer')}}">
                                        {!! csrf_field() !!}
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title text-center">{!! Lang::get('customers.store_customer_title') !!}</h4>
                                        </div>
                                        <div class="modal-body">
                                            <input class="form-control text-center" type="text" autocomplete="off" placeholder=" # " name="customerid"/>
                                            <br />
                                            <input class="form-control text-center" type="text" autocomplete="off" placeholder=" {!! Lang::get('customers.customer_names') !!}" name="customernames"/>
                                            <br />
                                            <input class="form-control text-center" type="text" autocomplete="off" placeholder=" {!! Lang::get('customers.customer_nick') !!}" name="customernick"/>
                                            <br />
                                            <input class="form-control text-center" type="text" autocomplete="off" placeholder=" {!! Lang::get('customers.customer_phone') !!}" name="customerphone"/>
                                            <br />
                                            <input class="form-control text-center" type="text" autocomplete="off" placeholder=" {!! Lang::get('customers.customer_phone2') !!}" name="customerphone2"/>
                                            <br />
                                            <input class="form-control text-center" type="text" autocomplete="off" placeholder="не избирай ако клиента е нов" name="customeradded" id="date" />
                                            <script src="<?php echo asset('/js/pikaday.js')?>"></script>
                                            <script>var picker = new Pikaday({field: document.getElementById('date'), numberOfMonths:1});</script>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success ladda-button" data-style="expand-left">{!! Lang::get('general.button_add') !!}</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">{!! Lang::get('general.button_cancel') !!}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- STORE NEW CUSTOMER MODAL END -->
                    </div>
                    <!-- STORE NEW CUSTOMER END -->
                    <!-- SEARCH CUSTOMER -->
                    <script type="text/javascript">
                    $j(function() {
                        var availableTags = <?php $customers = new App\AutoComplete(); $customers->customers(); ?>;
                        $j("#customers").autocomplete({
                            source: availableTags,
                            autoFocus:true,
                            minLength: 2
                        });
                    });
                    </script>
                    <form class="form-inline" method="post" action="{{url('/gotocustomer')}}">
                        {!! csrf_field() !!}
                        <div class="col-lg-12 padding-bottom10">
                            <span class="calibri15"> {!! Lang::get('customers.fast_search') !!}</span><br />
                            <input class="form-control" style="width: 500px;" autocomplete="off" placeholder="{!! Lang::get('customers.ucansearch') !!}" type="text" name="gotocustomer" id="customers" />
                            <button class="btn btn-gwms ladda-button" data-style="expand-left" type="submit"><i class="fa fa-arrow-right"></i></button>
                        </div>
                    </form>
                    <!-- SEARCH CUSTOMER END -->
                    <!-- LIST CUSTOMERS -->
                    <table class="table table-striped table-bordered">
                        <tr class="info">
                            <td class="col-lg-1">#</td>
                            <td class="col-lg-2">{!! Lang::get('customers.customer_names_title') !!}</td>
                            <td class="col-lg-2">{!! Lang::get('customers.customer_nick_title') !!}</td>
                            <td class="col-lg-2">{!! Lang::get('customers.customer_phone_title') !!}</td>
                            <td class="col-lg-2">{!! Lang::get('customers.customer_phone2_title') !!}</td>
                            <td class="col-lg-1">{!! Lang::get('customers.customer_added_title') !!}</td>
                            <td class="col-lg-1">{!! Lang::get('customers.customer_addedby_title') !!}</td>
                            <td class="col-lg-1">
                                <div class="tooltip-g"><i class="fa fa-info fa-lg warning"></i>
                                    <div class="tooltiptext-g">{!! Lang::get('customers.added_customers') !!} <span class="calibri20">{!! $getCustomers->total() !!}</span></div>
                                </div>
                            </td>
                        </tr>    
                        @foreach($getCustomers as $getCustomersRows)
                        <tr>
                            <td>{{$getCustomersRows->general_customer_id}}</td>
                            <td>{{$getCustomersRows->general_customer_names}}</td>
                            <td>{{$getCustomersRows->general_customer_nick}}</td>
                            <td>{{$getCustomersRows->general_customer_phone}}</td>
                            <td>{{$getCustomersRows->general_customer_phone2}}</td>
                            <td>{{\App\showDate($getCustomersRows->general_customer_added)}}</td>
                            <td>{{$getCustomersRows->name}}</td>
                            <td>
                                <a class="btn btn-sm btn-info tooltip-g" href="{{url('/customer')}}/{{$getCustomersRows->general_customer_id}}">
                                    <i class="fa fa-user fa-wrap fa-lg"></i>
                                    <div class="tooltiptext-g calibri15">{{$getCustomersRows->general_customer_names}}</div>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    <!-- LIST CUSTOMERS END -->
                     {!! $getCustomers->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
