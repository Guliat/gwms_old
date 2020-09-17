@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default text-left">
                <div class="panel-heading text-center calibri20">АРТИКУЛИ</div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered text-center">
                        @if ($errors->has())
                            <div class="alert alert-danger margin-top5 text-center">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br />        
                                @endforeach
                            </div>
                        @endif
                        <button class="btn btn-gwms" data-toggle="modal" data-target="#storeBMD">ДОБАВИ НОВ АРТИКУЛ</button>
                        <br /><br />
                        <!-- Store Brand Model Description Modal -->
                        <div id="storeBMD" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{url('storeproductbmd')}}">
                                        {!! csrf_field() !!}
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title text-center">ДОБАВЯНЕ НА НОВ АРТИКУЛ</h4>
                                        </div>
                                        <div class="modal-body">
                                            КАТЕГОРИЯ <br />
                                            <select class="form-control" name="product_category_id">
                                                @foreach(\App\getBMDCategories() as $getCategories)
                                                <option value="{{$getCategories->product_category_id}}">{{$getCategories->product_category}}</option>
                                                @endforeach
                                            </select>
                                            <br />
                                            МАРКА И МОДЕЛ <br />
                                            <input class="form-control" type="text" placeholder="Марка и модел" value="" name="product_brandmodel" />
                                            <br />
                                            ПРОДУКТОВ КОД <br />
                                            <input class="form-control" type="text" placeholder="Продуктов код" value="" name="product_number" />
                                            <br />
                                            ОПИСАНИЕ <br />
                                            <textarea class="form-control" type="text" placeholder="Описание на продукта (незадължително)" value="" name="product_description" /></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success ladda-button" data-style="expand-left"><i class="fa fa-arrow-down"></i> ДОБАВИ</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> ОТКАЗ</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <tr class="info">
                            <td>КАТЕГОРИЯ</td>
                            <td>МАРКА - МОДЕЛ</td>
                            <td>ПРОДУКТОВ КОД</td>
                            <td>ОПИСАНИЕ</td>
                            <td>ДОБАВЕНО ОТ</td>
                            <td>ДОБАВЕНО НА</td>
                        </tr>
                        @foreach(\App\getBrandsModels() as $getAllBrandModelsRows)
                        <tr>
                            <td>{{$getAllBrandModelsRows->product_category}}</td>
                            <td class="col-lg-3 calibri20">{{$getAllBrandModelsRows->product_brandmodel}}</td>
                            <td>{{$getAllBrandModelsRows->product_number}}</td>
                            <td>{{$getAllBrandModelsRows->product_description}}</td>
                            <td>{{$getAllBrandModelsRows->name}}</td>
                            <td>{{\App\showDate($getAllBrandModelsRows->product_bmd_added)}}</td>
                            <td>
                                <button class="btn btn-info btn-sm tooltip-g" data-toggle="modal" data-target="#updateBMD{{$getAllBrandModelsRows->product_bmd_id}}">
                                    <i class="fa fa-pencil fa-wrap"></i>
                                    <div class="tooltiptext-g calibri15">РЕДАКТИРАНЕ</div>
                                </button>
                            </td>
                        </tr>
                        <!-- Update Brand Model Description Modal -->
                        <div id="updateBMD{{$getAllBrandModelsRows->product_bmd_id}}" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{url('updateproductbmd')}}">
                                        {!! csrf_field() !!}
                                        <input type="hidden" value="{{$getAllBrandModelsRows->product_bmd_id}}" name="update_id" />
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title text-center">РЕДАКТИРАНЕ</h4>
                                        </div>
                                        <div class="modal-body">
                                            КАТЕГОРИЯ <br />
                                            <select class="form-control" name="product_category_id">
                                                <?php $selected_product_category_id = $getAllBrandModelsRows->product_category_id; ?>
                                                @foreach(\App\getBMDCategories() as $getCategories)
                                                <option value="{{$getCategories->product_category_id}}" <?php if($getCategories->product_category_id == $selected_product_category_id) { echo "selected"; } ?>>{{$getCategories->product_category}}</option>
                                                @endforeach
                                            </select>
                                            <br />
                                            МАРКА И МОДЕЛ <br />
                                            <input class="form-control" type="text" value="{{$getAllBrandModelsRows->product_brandmodel}}" name="product_brandmodel" />
                                            <br />
                                            ПРОДУКТОВ КОД <br />
                                            <input class="form-control" type="text" value="{{$getAllBrandModelsRows->product_number}}" name="product_number" />
                                            <br />
                                            ОПИСАНИЕ <br />
                                            <textarea class="form-control" type="text" name="product_description" />{{$getAllBrandModelsRows->product_description}}</textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success ladda-button" data-style="expand-left"><i class="fa fa-refresh"></i> ОБНОВИ</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> ОТКАЗ</button>
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
