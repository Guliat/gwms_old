@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center">ПРЕДЛОЖЕНИЯ</div>
                <div class="panel-body">
                    <form role="form" method="POST" action="{{url('storefeedback')}}">
                        {!! csrf_field() !!}
                        &nbsp;ДОБАВЯНЕ НА ПРЕДЛОЖЕНИЕ (максимум 500 символа):
                        <textarea class="form-control" rows="5" maxlength="500" placeholder="Въведете вашето предложение тук, Благодарим !" name="general_feedback">{{ old('general_feedback') }}</textarea>
                        @if ($errors->has())
                            <div class="alert alert-danger margin-top5">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br />        
                                @endforeach
                            </div>
                        @endif
                        @if (Session::has('feedbackadded'))
                            <div class="alert alert-success text-center margin-top5">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>
                                {{ Session::get('feedbackadded') }}
                                </a>
                            </div>
                        @endif
                        <button type="submit" class="btn btn-success ladda-button margin-top5" data-style="expand-left"><i class="fa fa-arrow-down"></i> ДОБАВИ</button>
                        <br /><br />
                    </form>
                    <table class="table table-bordered table-striped text-center">
                        <tr class="info">
                            <td class="col-lg-1">СТАТУС</td>
                            <td class="col-lg-1">НОМЕР</td>
                            <td class="col-lg-6">ПРЕДЛОЖЕНИЕ</td>
                            <td class="col-lg-2">ДОБАВЕН ОТ</td>
                            <td class="col-lg-1">ДОБАВЕНО</td>
                            <td class="col-lg-1">ОБНОВЕНО</td>
                        </tr>
                        @foreach($getAllFeedbacks as $getFeedback)
                        <tr>
                            <td>
                                @if($getFeedback->general_feedback_status == 1)
                                <div class="tooltip-g"><a data-toggle="modal" data-target="#updateFeedback{{$getFeedback->general_feedback_id}}"><i class="fa fa-pause fa-lg neutral"></i></a><div class="tooltiptext-g">ЧАКАЩО</div></div>
                                @elseif($getFeedback->general_feedback_status == 2)
                                <div class="tooltip-g"><a data-toggle="modal" data-target="#updateFeedback{{$getFeedback->general_feedback_id}}"><i class="fa fa-cog fa-spin fa-lg warning"></i></a><div class="tooltiptext-g">ОДОБРЕНО</div></div>
                                @elseif($getFeedback->general_feedback_status == 3)
                                <div class="tooltip-g"><a data-toggle="modal" data-target="#updateFeedback{{$getFeedback->general_feedback_id}}"><i class="fa fa-check fa-lg success"></i></a><div class="tooltiptext-g">ЗАВЪРШЕНО</div></div>
                                @elseif($getFeedback->general_feedback_status == 4)
                                <div class="tooltip-g"><a data-toggle="modal" data-target="#updateFeedback{{$getFeedback->general_feedback_id}}"><i class="fa fa-trash fa-lg danger"></i></a><div class="tooltiptext-g">ОТХВЪРЛЕНО</div></div>
                                @endif
                            </td>
                            <td>{{$getFeedback->general_feedback_id}}</td>
                            <td>{{$getFeedback->general_feedback}}</td>
                            <td>{{$getFeedback->name}}</td>
                            <td>{{date('d-m-Y', strtotime($getFeedback->general_feedback_added))}}</td>
                            <td>{{date('d-m-Y', strtotime($getFeedback->general_feedback_updated))}}</td>
                        </tr>
                        @if(Auth::id() == 1)
                        <!-- Update Feedback Modal -->
                        <div id="updateFeedback{{$getFeedback->general_feedback_id}}" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form role="form" method="POST" action="{{url('updatefeedback')}}">
                                        {!! csrf_field() !!}
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title">РЕДАКЦИЯ НА ПРЕДЛОЖЕНИЕ #{{$getFeedback->general_feedback_id}}</h4>
                                        </div>
                                        <div class="modal-body form-group">
                                            <input type="hidden" name="update_id" value="{{$getFeedback->general_feedback_id}}" />
                                            <select class="form-control" name="general_feedback_status">
                                                <option value="1" <?php if($getFeedback->general_feedback_status == 1) { echo "selected"; }?>>ИЗЧАКВАЩО</option>
                                                <option value="2" <?php if($getFeedback->general_feedback_status == 2) { echo "selected"; }?>>ОДОБРЕНО</option>
                                                <option value="3" <?php if($getFeedback->general_feedback_status == 3) { echo "selected"; }?>>ЗАВЪРШЕНО</option>
                                                <option value="4" <?php if($getFeedback->general_feedback_status == 4) { echo "selected"; }?>>ОТХВЪРЛЕНО</option>
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success ladda-button" data-style="expand-left"><i class="fa fa-refresh"></i> ОБНОВИ</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i>  ОТКАЗ</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </table>
                    <div class="text-center">{!! $getAllFeedbacks->links() !!}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
