@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- CATEGORIES -->
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading text-center calibri20">КАТЕГОРИИ</div>
                <div class="panel-body">
                    <button class="btn btn-gwms" data-toggle="modal" data-target="#storeservicescategory">НОВА КАТЕГОРИЯ</button><br /><br />
                    <!-- STORE Service Category Modal -->
                    <div id="storeservicescategory" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form role="form" method="POST" action="{{url('storestoreservicescategory')}}">
                                    {!! csrf_field() !!}
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      <h4 class="modal-title">ДОБАВЯНЕ НА КАТЕГОРИЯ</h4>
                                    </div>
                                    <div class="modal-body form-group">
                                        <label class="control-label">КАТЕГОРИЯ</label>
                                        <input class="form-control" autocomplete="off" placeholder=" името на категорията" type="text"name="category" />
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success ladda-button" data-style="expand-left">{!! Lang::get('general.button_add') !!}</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">{!! Lang::get('general.button_cancel') !!}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered text-center">
                        <tr class="info calibri15">
                            <td>КАТЕГОРИЯ</td>
                        </tr>
                        <?php $g = new App\StoreServices; ?>
                        @foreach($g->getStoreServicesCategories() as $getCategories)
                        <tr>
                            <td class="col-lg-10">{{$getCategories->services_category}}</td>
                            <td class="col-lg-2"><div class='tooltip-g'><button data-toggle="modal" data-target="#updatestorecategory{{$getCategories->services_category_id}}" class="btn btn-default gray"><i class="fa fa-pencil fa-lg"></i><div class='tooltiptext-g'>РЕДАКТИРАНЕ</div></button></div></td>
                            <!-- UPDATE Service Category Modal -->
                            <div id="updatestorecategory{{$getCategories->services_category_id}}" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form role="form" method="POST" action="{{url('updatestoreservicescategory')}}">
                                            {!! csrf_field() !!}
                                            <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              <h4 class="modal-title">РЕДАКТИРАНЕ НА КАТЕГОРИЯ</h4>
                                            </div>
                                            <div class="modal-body form-group">
                                                <input type="hidden" value="{{$getCategories->services_category_id}}" name="categoryid"
                                                <label class="control-label">КАТЕГОРИЯ</label>
                                                <input class="form-control" autocomplete="off" value="{{$getCategories->services_category}}" placeholder=" името на категорията" type="text"name="category" />
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success ladda-button" data-style="expand-left">{!! Lang::get('general.button_update') !!}</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">{!! Lang::get('general.button_cancel') !!}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <!-- SERVICES -->
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading text-center calibri20">УСЛУГИ</div>
                <div class="panel-body">
                    <button class="btn btn-gwms" data-toggle="modal" data-target="#storeservice">НОВА УСЛУГА</button><br /><br />
                    <!-- STORE Service Modal -->
                    <div id="storeservice" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form role="form" method="POST" action="{{url('storestoreservice')}}">
                                    {!! csrf_field() !!}
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      <h4 class="modal-title">ДОБАВЯНЕ НА УСЛУГА</h4>
                                    </div>
                                    <div class="modal-body form-group">
                                        <label class="control-label">КАТЕГОРИЯ</label>
                                        <select class="form-control" name="categoryid">
                                            @foreach($g->getStoreServicesCategories() as $getCategories)
                                            <option value="{{$getCategories->services_category_id}}">{{$getCategories->services_category}}</option>
                                            @endforeach
                                        </select>
                                        <label class="control-label">УСЛУГА</label>
                                        <input class="form-control" type="text" name="service" />
                                        <label class="control-label" >ЦЕНА</label>
                                        <input class="form-control" autocomplete="off" type="text"name="price" />
                                        <input class="form-control" type="hidden"name="quantitytype" value='1'/>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success ladda-button" data-style="expand-left">{!! Lang::get('general.button_add') !!}</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">{!! Lang::get('general.button_cancel') !!}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered text-center">
                        <tr class="info calibri15">
                            <td>КАТЕГОРИЯ</td>
                            <td>УСЛУГА</td>
                            <td>ЦЕНА</td>
                        </tr>
                        @foreach($g->getStoreServices() as $getServices)
                        <tr>
                            <td class="col-lg-3">{{$getServices->services_category}}</td>
                            <td class="col-lg-6 text-left">{{$getServices->service}}</td>
                            <td class="col-lg-2">{{$getServices->service_price}} лв.</td>
                            <td class="col-lg-1"><div class='tooltip-g'><button data-toggle="modal" data-target="#updatestoreservice{{$getServices->service_id}}" class="btn btn-default gray"><i class="fa fa-pencil fa-lg"></i><div class='tooltiptext-g'>РЕДАКТИРАНЕ</div></button></div></td>
                            <!-- UPDATE Service Modal -->
                            <div id="updatestoreservice{{$getServices->service_id}}" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form role="form" method="POST" action="{{url('updatestoreservice')}}">
                                            {!! csrf_field() !!}
                                            <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              <h4 class="modal-title">РЕДАКТИРАНЕ НА УСЛУГА</h4>
                                            </div>
                                            <div class="modal-body form-group">
                                                <input type="hidden" value="{{$getServices->service_id}}" name="serviceid" />
                                                <label class="control-label">КАТЕГОРИЯ</label>
                                                <select class="form-control" name="categoryid">
                                                    @foreach($g->getStoreServicesCategories() as $getCategories)
                                                    <option <?php if($getCategories->services_category_id == $getServices->services_category_id) { echo "selected"; } ?> value="{{$getCategories->services_category_id}}">{{$getCategories->services_category}}</option>
                                                    @endforeach
                                                </select>
                                                <label class="control-label">УСЛУГА</label>
                                                <input class="form-control" type="text" value="{{$getServices->service}}" name="service" />
                                                <label class="control-label" >ЦЕНА</label>
                                                <input class="form-control" autocomplete="off" value="{{$getServices->service_price}}" type="text" name="price" />
                                                <input class="form-control" type="hidden"name="quantitytype" value='1'/>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success ladda-button" data-style="expand-left">{!! Lang::get('general.button_add') !!}</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">{!! Lang::get('general.button_cancel') !!}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        @endforeach
                    </table>
                    <center>{!! $g->getStoreServices()->links(); !!}</center>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
