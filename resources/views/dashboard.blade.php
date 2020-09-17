@extends('layouts.app')

@section('content')
<div class="container-fluid padding-top50 padding-bottom20">
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
    <div class="row">
        <div class="col-lg-3 text-center">
            <div class="panel" style="box-shadow: 0px 0px 10px 3px #ccc;">
                <div class="panel-heading gwmsgreenbgr">БЪРЗ ДОСТЪП</div>
                <div class="panel-body">
                    <form role="form" method="POST" action="{{url('gotodevice')}}">
                    {!! csrf_field() !!}
                        <div class="input-group">
                            <input type="text" class="form-control" name="deviceid" placeholder="КЛИЕНТ #" />
                            <span class="input-group-btn">
                                <button tpye="submit" class="btn btn-gwms">ОТИДИ</button>
                            </span>
                        </div>
                    </form>
                    <br />
                    <form role="form" method="POST" action="{{url('gotodevice')}}">
                    {!! csrf_field() !!}
                        <div class="input-group">
                            <input type="text" class="form-control" name="deviceid" placeholder="ФИРМА #" />
                            <span class="input-group-btn">
                                <button tpye="submit" class="btn btn-gwms">ОТИДИ</button>
                            </span>
                        </div>
                    </form>
                    <br />
                    <form role="form" method="POST" action="{{url('gotoservice')}}">
                    {!! csrf_field() !!}
                        <div class="input-group">
                            <input type="text" class="form-control" name="serviceid" placeholder="УСЛУГА #" />
                            <span class="input-group-btn">
                                <button tpye="submit" class="btn btn-gwms">ОТИДИ</button>
                            </span>
                        </div>
                    </form>
                    <br />
                    <form role="form" method="POST" action="{{url('gotodevice')}}">
                    {!! csrf_field() !!}
                        <div class="input-group">
                            <input type="text" class="form-control" name="deviceid" placeholder="УСТРОЙСТВО #" />
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-gwms">ОТИДИ</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6 text-center">
            <div class="panel" style="box-shadow: 0px 0px 10px 3px #ccc;">
                <div class="panel-heading gwmsgreenbgr">ПОДРОБНО ТЪРСЕНЕ</div>
                <div class="panel-body">
                    <form role="form" method="POST" action="{{url('gotodevice')}}">
                    {!! csrf_field() !!}
                        <div class="input-group">
                            <input type="text" class="form-control" name="deviceid" placeholder="ТЪРСЕНЕ НА КЛИЕНТ ПО ИМЕНА ИЛИ ТЕЛЕФОН" />
                            <span class="input-group-btn">
                                <button tpye="submit" class="btn btn-gwms">НАМЕРИ</button>
                            </span>
                        </div>
                    </form>
                    <br />
                    <form role="form" method="POST" action="{{url('gotoservice')}}">
                    {!! csrf_field() !!}
                        <div class="input-group">
                            <input type="text" class="form-control" name="serviceid" placeholder="УСЛУГА #" />
                            <span class="input-group-btn">
                                <button tpye="submit" class="btn btn-gwms">НАМЕРИ</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3 text-center">
            <div class="panel" style="box-shadow: 0px 0px 10px 3px #ccc;">
                <div class="panel-heading calibri25 gwmsgreenbgr">Guliat's Work Management System</div>
                <div class="panel-body">
                    <div class="tooltip-g">
                        <span class="logo">G</span>
                        <div class="tooltiptext-g">ТОВА ЩЕ Е ЛОГОТО</div>
                    </div>
                    <br /><br />
                    <span class="calibri25">Здравей, {{(Auth::user()->name)}}</span> 
                    <br /><br />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
