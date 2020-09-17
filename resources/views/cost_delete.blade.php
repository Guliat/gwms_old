@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">СИГУРНИ ЛИ СТЕ?</div>
                <div class="panel-body">
                    
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/costs/destroy') }}/{{$id}}">
               		{!! csrf_field() !!}

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <input type="hidden" name="update_id" value="{{$id}}">
                                <a href="{{ URL::previous() }}" class="btn btn-default">ОТКАЗ</a>
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa fa-btn fa-remove"></i>ИЗТРИЙ
                                </button>

                            </div>
                        </div>
						


                    </form>
                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection