@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <!-- COMPUTERS DEVICES CATEGORIES CONTENT -->
            <div class="panel panel-default text-left">
                <div class="panel-heading text-center">КАТЕГОРИИ</div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered text-center">
                        <button class="btn btn-gwms" data-toggle="modal" data-target="#storepcdcat">ДОБАВИ КАТЕГОРИЯ</button>
                        <br /><br />
                        <!-- Store Computers Devices Category Modal -->
                        <div id="storepcdcat" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{url('storepcdcat')}}">
                                        {!! csrf_field() !!}
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title">ДОБАВЯНЕ НА КАТЕГОРИЯ</h4>
                                        </div>
                                        <div class="modal-body">
                                            <input class="form-control text-center" type="text" placeholder=" Mоля напишете името на категорията тук ..." name="computers_device_category" />
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
                            <div class="alert alert-success calibri20 text-center">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>
                                {{$errors->first()}}
                            </div>
                        @endif
                        <tr class="info">
                            <td>ИКОНА</td>
                            <td>КАТЕГОРИЯ</td>
                            <td>ДОБАВЕНО ОТ</td>
                            <td>ДОБАВЕНО НА</td>
                            <td>
                                <div class="tooltip-g"><i class="fa fa-info fa-lg warning"></i>
                                    <div class="tooltiptext-g">Добавени категории <span class="calibri20">{!! $getCategories->total() !!}</span></div>
                                </div>
                            </td>
                        </tr>
                        @foreach($getCategories as $getCategoriesRows)
                        <tr>
                            <td clas="col-lg-1"><?php echo htmlspecialchars_decode($getCategoriesRows->computers_device_category_icon); ?></td>
                            <td class="col-lg-6 calibri20">{{$getCategoriesRows->computers_device_category}}</td>
                            <td class="col-lg-2">{{$getCategoriesRows->name}}</td>
                            <td class="col-lg-2">{{\App\showDate($getCategoriesRows->computers_device_category_added)}}</td>
                            <td class="col-lg-1">
                                <div class="tooltip-g">
                                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#updatepcdcat{{$getCategoriesRows->computers_device_category_id}}">
                                        <i class="fa fa-pencil fa-wrap"></i>
                                        <div class="tooltiptext-g calibri15">РЕДАКТИРАНЕ</div>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <!-- Update Computers Devices Category Modal -->
                        <div id="updatepcdcat{{$getCategoriesRows->computers_device_category_id}}" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{url('updatepcdcat')}}">
                                        {!! csrf_field() !!}
                                        <input type="hidden" value="{{$getCategoriesRows->computers_device_category_id}}" name="update_id" />
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title">РЕДАКТИРАНЕ НА КАТЕГОРИЯ</h4>
                                        </div>
                                        <div class="modal-body">
                                            <input class="form-control text-center" type="text" value="{{$getCategoriesRows->computers_device_category}}" name="computers_device_category" />
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
                    <center>{!! $getCategories->links() !!}</center>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection