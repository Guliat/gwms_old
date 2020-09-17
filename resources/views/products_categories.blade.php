@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default text-left">
                <div class="panel-heading text-center calibri20">КАТЕГОРИИ</div>
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
                        <button class="btn btn-gwms" data-toggle="modal" data-target="#insertCategory">ДОБАВИ КАТЕГОРИЯ</button>
                        <br /><br />
                        <!-- Insert Category Modal -->
                        <div id="insertCategory" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{url('storeproductcategory')}}">
                                        {!! csrf_field() !!}
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title text-center">ДОБАВЯНЕ НА КАТЕГОРИЯ</h4>
                                        </div>
                                        <div class="modal-body">
                                            <input class="form-control text-center" type="text" placeholder=" името на категорията ..." value="" name="product_category" />
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
                            <td>ДОБАВЕНА ОТ</td>
                            <td>ДОБАВЕНА НА</td>
                        </tr>
                        @foreach(\App\getCategories() as $getCategoriesRows)
                        <tr>
                            <td class="calibri20">{{$getCategoriesRows->product_category}}</td>
                            <td>{{$getCategoriesRows->name}}</td>
                            <td>{{\App\showDate($getCategoriesRows->product_category_added)}}</td>
                            <td>
                                <button class="btn btn-info btn-sm tooltip-g" data-toggle="modal" data-target="#updateCategory{{$getCategoriesRows->product_category_id}}">
                                    <i class="fa fa-pencil fa-wrap"></i>
                                    <div class="tooltiptext-g calibri15">РЕДАКТИРАНЕ</div>
                                </button>
                            </td>
                        </tr>
                        <!-- Update Category Modal -->
                        <div id="updateCategory{{$getCategoriesRows->product_category_id}}" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{url('updatecategory')}}">
                                        {!! csrf_field() !!}
                                        <input type="hidden" value="{{$getCategoriesRows->product_category_id}}" name="update_id" />
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title text-center">РЕДАКТИРАНЕ</h4>
                                        </div>
                                        <div class="modal-body">
                                            <input class="form-control text-center" type="text" value="{{$getCategoriesRows->product_category}}" name="product_category" />
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection