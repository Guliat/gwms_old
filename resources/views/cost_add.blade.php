@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Добавяне</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="./store">
                        {!! csrf_field() !!}

                        <div class="form-group">
                            <label class="col-md-4 control-label">ИМЕ</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="cost_name" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">ОПИСАНИЕ</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="cost_desc" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">СУМА</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="cost_cost" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">НАЧИН НА ПЛАЩАНЕ</label>
                            <div class="col-md-6">
                                <select class="form-control" name="cost_is_cash">
                                     <option value="1">ПЛАЩАНЕ В КЕШ</option>
                                     <option value="0">ПЛАЩАНЕ ПО БАНКОВ ПЪТ</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">ДЕН ЗА ПЛАЩАНЕ</label>
                            <div class="col-md-6">
                                <input type="text" name="cost_payday" id="datepicker" placeholder=" изберете дата">
                                <script src="/laravel/public/js/pikaday.js"></script>
                                <script>
                                var picker = new Pikaday(
                                {
                                    field: document.getElementById('datepicker'),
                                    firstDay: 1,
                                    minDate: new Date(2015, 0, 1),
                                    maxDate: new Date(2017, 11, 31),
                                    yearRange: [2015,2017],
                                                        
                                });

                                </script>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-btn fa-floppy-o"></i>ДОБАВИ</button>
                                <a href="{{ URL::previous() }}" class="btn btn-danger">ОТКАЗ</a>
                                <div id="myModal" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body"><h4>Моля потвърдете !</h4></div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success"><i class="fa fa-btn fa-floppy-o"></i>ДОБАВИ</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">ОТКАЗ</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection