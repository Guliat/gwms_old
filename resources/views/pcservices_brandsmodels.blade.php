@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <!-- COMPUTERS DEVICES BRANDS MODELS CONTENT -->
            <div class="panel panel-default text-left">
                <div class="panel-heading text-center">МАРКИ И МОДЕЛИ</div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered text-center">
                        <button class="btn btn-gwms" data-toggle="modal" data-target="#storepcdbm">ДОБАВИ МАРКА И МОДЕЛ</button>
                        <br /><br />
                        <!-- Store Computers Devices Brands Models Modal -->
                        <script type="text/javascript">
                        $j(function() {
                        var availableTags = <?php $computersdevicesbrandmodel = new App\AutoComplete(); $computersdevicesbrandmodel->computersdevicesbrandmodel(); ?>;
                        $j("#computersdevicesbrandmodel").autocomplete({
                            source: availableTags,
                            appendTo: "#storepcdbm",
                            autoFocus:true,
                            minLength: 2
                            });
                        });
                        </script>
                        <div id="storepcdbm" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{url('storepcdbm')}}">
                                        {!! csrf_field() !!}
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title">ДОБАВЯНЕ НА МАРКА И МОДЕЛ</h4>
                                        </div>
                                        <div class="modal-body">
                                            КАТЕГОРИЯ
                                            <select class="form-control" name="computers_device_category_id">
                                                @foreach(\App\getBMCategories() as $getBMCategories)
                                                <option value="{{$getBMCategories->computers_device_category_id}}">{{$getBMCategories->computers_device_category}}</option>
                                                @endforeach
                                            </select>
                                            <br />
                                            МАРКА И МОДЕЛ
                                            <input class="form-control text-center" type="text" placeholder=" Моля напишете марката и модела тук ..." name="computers_device_brandmodel" id="computersdevicesbrandmodel"/>
                                            <br />
                                            Ако марката и модела се покажат в автоматичния списък означава, че вече съществува този запис.
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success ladda-button" data-style="expand-left">{!! Lang::get('general.button_add') !!}</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">{!! Lang::get('general.button_cancle') !!}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @if($errors->any())
                            <div class="alert alert-danger calibri20 text-center">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>
                                {{$errors->first()}}
                            </div>
                        @endif
                        @if (Session::has('updated'))
                            <div class="alert alert-success calibri20 text-center">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>
                                {{ Session::get('updated') }}
                                </a>
                            </div>
                        @endif
                        @if (Session::has('added'))
                            <div class="alert alert-success calibri20 text-center">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>
                                {{ Session::get('added') }}
                                </a>
                            </div>
                        @endif
                        <tr class="info">
                            <td>КАТЕГОРИЯ</td>
                            <td>МАРКА - МОДЕЛ</td>
                            <td>ДОБАВЕНО ОТ</td>
                            <td>ДОБАВЕНО НА</td>
                            <td>
                                <div class="tooltip-g"><i class="fa fa-info fa-lg warning"></i>
                                    <div class="tooltiptext-g">Добавени марки и модели <span class="calibri20">{!! \App\getBrandsModels()->total() !!}</span></div>
                                </div>
                            </td>
                        </tr>
                        @foreach(\App\getBrandsModels() as $getBrandsModelsRows)
                        <tr>
                            <td class='col-lg-2 calibri20'>{{$getBrandsModelsRows->computers_device_category}}</td>
                            <td class="col-lg-5 calibri20">{{$getBrandsModelsRows->computers_device_brandmodel}}</td>
                            <td class="col-lg-2">{{$getBrandsModelsRows->name}}</td>
                            <td class="col-lg-2">{{\App\showDate($getBrandsModelsRows->computers_device_bm_added)}}</td>
                            <td class="col-lg-1">
                                <div class="tooltip-g">
                                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#updatepcdbm{{$getBrandsModelsRows->computers_device_bm_id}}">
                                        <i class="fa fa-pencil fa-wrap"></i>
                                        <div class="tooltiptext-g calibri15">РЕДАКТИРАНЕ</div>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <!-- Update Computers Devices AllBrands Models Modal -->
                        <div id="updatepcdbm{{$getBrandsModelsRows->computers_device_bm_id}}" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{url('updatepcdbm')}}">
                                        {!! csrf_field() !!}
                                        <input type="hidden" value="{{$getBrandsModelsRows->computers_device_bm_id}}" name="update_id" />
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title">РЕДАКТИРАНЕ НА МАРКА И МОДЕЛ</h4>
                                        </div>
                                        <div class="modal-body">
                                            КАТЕГОРИЯ
                                            <?php $selected_category_id = $getBrandsModelsRows->computers_device_category_id; ?>
                                            <select class="form-control">
                                                @foreach(\App\getBMCategories() as $getBMCategories)
                                                <option value="{{$getBMCategories->computers_device_category_id}}" <?php if($getBMCategories->computers_device_category_id == $selected_category_id) { echo "selected"; } ?>>{{$getBMCategories->computers_device_category}}</option>
                                                @endforeach
                                            </select>
                                            <br />
                                            МАРКА И МОДЕЛ
                                            <input class="form-control text-center" type="text" value="{{$getBrandsModelsRows->computers_device_brandmodel}}" name="computers_device_brandmodel" />
                                            <br />
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success ladda-button" data-style="expand-left">{!! Lang::get('general.button_update') !!}</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">{!! Lang::get('general.button_cancle') !!}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </table>
                    <center>{!! \App\getBrandsModels()->links() !!}</center>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection