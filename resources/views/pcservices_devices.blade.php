@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <!-- COMPUTERS DEVICES CONTENT -->
            <div class="panel panel-default text-left">
                <div class="panel-heading text-center">УСТРОЙСТВА</div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered text-center">
                        <a href="{{url('/pcs/newdevice')}}?c=0" class="btn btn-gwms">НОВО УСТРОЙСТВО</a>
                        <br /><br />
                        @if (Session::has('nondevice'))
                            <div class="alert alert-danger calibri20 text-center">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>
                                {{ Session::get('nondevice') }}
                                </a>
                            </div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-success calibri20 text-center">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>
                                {{$errors->first()}}
                            </div>
                        @endif
                        <tr class="default">
                            <td>НОМЕР</td>
                            <td>КАТЕГОРИЯ</td>
                            <td>МАРКА И МОДЕЛ</td>
                            <td>ПОДМОДЕЛ</td>
                            <td>ЦВЯТ</td>
                            <td>БЕЛЕЖКА</td>
                            <td>
                                <div class="tooltip-g"><i class="fa fa-info fa-lg warning"></i>
                                    <div class="tooltiptext-g">Добавени устройства <span class="calibri20">{!! $getDevices->total() !!}</span></div>
                                </div>
                            </td>
                        </tr>
                        @foreach($getDevices as $getDevicesRows)
                        <tr class="calibri20">
                            <td class="calibri25">{{$getDevicesRows->computers_device_id}}</td>
                            <td>
                                <div class="tooltip-g">                                    
                                <?php echo htmlspecialchars_decode($getDevicesRows->computers_device_category_icon);?>
                                <div class="tooltiptext-g">{{$getDevicesRows->computers_device_category}}</div></div>
                            </td>
                            <td>{{$getDevicesRows->computers_device_brandmodel}}</td>
                            <td>{{$getDevicesRows->computers_device_submodel}}</td>
                            <td>{{$getDevicesRows->computers_device_color}}</td>
                            <td class="calibri15">{{$getDevicesRows->computers_device_note}}</td>
                            <td>
                                <div class="tooltip-g">
                                    <a class="btn btn-gwms btn-xs" href="{{url('/pcs/device')}}/{{$getDevicesRows->computers_device_id}}">
                                        <i class="fa fa-folder-open fa-wrap"></i>
                                        <div class="tooltiptext-g calibri15">ПЪЛНА ИНФОРМАЦИЯ</div>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    <center>{!! $getDevices->links() !!}</center>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection