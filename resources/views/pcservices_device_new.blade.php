@extends('layouts.app')
@section('content')                   
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4">
            <div class="panel panel-default">
                @if ($errors->has())
                    <div class="alert alert-danger text-center">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>
                        @foreach ($errors->all() as $error)
                            {{ $error }}     
                        @endforeach
                    </div>
                @endif
                <script type="text/javascript">
                    $j(function() {
                    var availableTags = <?php $PCDBrandsModels = new App\AutoComplete(); $PCDBrandsModels->PCDBrandsModels(); ?>;
                    $j("#PCDBrandsModels").autocomplete({
                        source: availableTags,
                        appendTo: "#storepcdevice",
                        autoFocus:true,
                        minLength: 2
                        });
                    });
                </script>
                <div class="panel-heading text-center">ДОБАВЯНЕ НА УСТРОЙСТВО</div>
                <form method="POST" action="{{url('storepcdevice')}}">
                    {!! csrf_field() !!}
                    <div class="panel-body">
                        <input type="hidden" value="<?php echo $_GET['c']; ?>" name="customerid" />
                        <input class="form-control" type="text" placeholder="#" name="deviceid" />
                        <label class="form-label">МАРКА И МОДЕЛ</label>
                        <input class="form-control" type="text" placeholder=" Започнете да пишете марката или модела ..." name="computers_device_brandmodel" id="PCDBrandsModels"/>
                        <span class="warning">
                            АКО В СПИСЪКА НЕ НАМИРАТЕ МАРКАТА И МОДЕЛА, 
                            <a href="{{url('/pcs/brandsmodels?c=')}}<?php echo $_GET['c']; ?>">ДОБАВЕТЕ ГИ ТУК</a>
                        </span>
                        <br />
                        <label class="form-label">ПОДМОДЕЛ</label>
                        <input class="form-control" type="text" placeholder=" Ако устройството има подмодел го напишете тук" name="computers_device_submodel" />
                        <label class="form-label">ЦВЯТ</label>
                        <input class="form-control" type="text" placeholder=" Цвят на устройството" name="computers_device_color" />
                        <label class="form-label">БЕЛЕЖКА</label>
                        <textarea class="form-control" type="text" placeholder=" Ако имате някакви забележки напишете ги тук (пр. пукнат корпус, липсва бутон)" name="computers_device_note" ></textarea>
                        <br />
                        <input class="form-control text-center" type="text" autocomplete="off" placeholder="не избирай ако устройството е ново" name="deviceadded" id="date" />
                        <script src="<?php echo asset('/js/pikaday.js')?>"></script>
                        <script>var picker = new Pikaday({field: document.getElementById('date'), numberOfMonths:1});</script>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success ladda-button" data-style="expand-left">{!! Lang::get('general.button_add') !!}</button>
                        <a href="{{ URL::previous() }}" type="button" class="btn btn-danger">{!! Lang::get('general.button_cancel') !!}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>                     
@endsection