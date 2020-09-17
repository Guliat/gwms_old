@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">РЕДАКТИРАНЕ НА РАЗХОД</div>
                <div class="panel-body">
                @if(!empty($editCost))
                @foreach ($editCost as $editCostView)	
                    <div class="form-group">              
                        <div class="col-md-12">
                            <form role="form" method="POST" action="{{ url('/costs/update') }}/{{$editCostView->cost_id}}">
                                {!! csrf_field() !!}
                                <input type="hidden" name="update_id" value="{{ $editCostView->cost_id }}">
                                <input type="hidden" name="cost_is_paid" value="{{ $editCostView->cost_is_paid}}">
                                <label class="control-label">ИМЕ</label>
                                <input type="text" class="form-control" name="cost_name" value="{{ $editCostView->cost_name }}">
                                <label class="control-label">ОПИСАНИЕ</label>
                                <input type="text" class="form-control" name="cost_description" value="{{ $editCostView->cost_description }}">
                                <label class="control-label">СУМА</label>
                                <input type="text" class="form-control" name="cost_cost" value="{{ $editCostView->cost_cost }}">
                                <br />
                                <a href="{{ url('/costs') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i> НАЗАД</a>
                                <button type="submit" class="btn btn-success ladda-button" data-style="zoom-in"><i class="fa fa-refresh"></i> ОБНОВИ</button>
                                <a class="btn btn-danger" data-toggle="modal" data-target="#deleteCost"><i class="fa fa-remove"></i> ИЗТРИЙ РАЗХОДА</a>
                                <!-- DELETE COST MODAL -->
                                <div id="deleteCost" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>                                                                                                                                                        <!-- TODO -->
                                            <div class="modal-body"><h4>Моля потвърдете !</h4><br />Запомнете, че изтриването не е перманентно.<br />Ако някога пак имате нужда, можете да го възстановите от Разходи/Редакция.</div>
                                            <div class="modal-footer">
                                                <form class="form-horizontal" role="form" method="POST" action="{{ url('/costs/destroy') }}/{{ $editCostView->cost_id }}">
                                                    {!! csrf_field() !!}
                                                    <input type="hidden" name="update_id" value="{{ $editCostView->cost_id }}">
                                                    <button type="submit" class="btn btn-danger"><i class="fa fa-btn fa-close"></i>ИЗТРИЙ</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">ОТКАЗ</button>
                                                </form>  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- DELETE COST MODAL END -->
                            </form>
                        </div>       
                    </div>	                   
                @endforeach
                @else
                Нямате достъп до този разход. Ако не сте нинджа, моля върнете се в началната страница. <br /><br />
                <a class="btn btn-default" href="{{ url('/') }}">НАЧАЛО</a>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection