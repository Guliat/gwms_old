@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row padding-top50">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading calibri20">ВИДЕОНАБЛЮДЕНИЕ - ОБЕКТИ</div>
                <div class="panel-body">
                  <?php 
                       $g = new App\Http\Controllers\GeneralController();
                       $g->confirmModal(
				     $buttonstyle = "gwms",
				     $buttonsize = "s",
                       $modalbuttontext = \Illuminate\Support\Facades\Lang::get('general.button_storevideosurveillance'), 
                       $bodytext = " ",
                       $action = "/storevideosurveillance",
					$confirmid = ""
                        );
                  ?>
                    <!-- SEARCH -->
                    <script type="text/javascript">
                    $j(function() {
                        var availableTags = <?php $projects = new App\AutoComplete(); $projects->vsprojects(); ?>;
                        $j("#vsprojects").autocomplete({
                            source: availableTags,
                            autoFocus:true,
                            minLength: 2
                        });
                    });
                    </script>
                    <form class="form-inline" method="post" action="{{url('/gotovsproject')}}">
                        {!! csrf_field() !!}
                        <div class="col-lg-12 padding-bottom10 text-center">
                            <span class="calibri15"> {!! Lang::get('customers.fast_search') !!}</span><br />
                            <input class="form-control" style="width: 600px;" autocomplete="off" placeholder="име на DVR, описание " type="text" name="vsprojectid" id="vsprojects" />
                            <button class="btn btn-gwms ladda-button" data-style="expand-left" type="submit"><i class="fa fa-arrow-right"></i></button>
                        </div>
                    </form>
                    <!-- SEARCH END -->
                    <table class="table table-bordered table-striped text-center">
                        <tr class="info">
                            <td>ОБЩО: {!! $getProjects->total() !!}</td>
                            <td>КЛИЕНТ / ФИРМА</td>
                            <td>ИМЕ НА DVR</td>
                            <td>ПАРОЛА</td>
                            <td>IP / ДОМЕЙН</td>
                            <td>ОПИСАНИЕ</td>
                            <td>КOОРДИНАТИ</td>
                            <td>ЗАПОЧНАТ</td>
                            <td>ЗАВЪРШЕН</td>
                        </tr>
                        @foreach($getProjects as $getProjectsRows)
                        <tr>
                            <td>
                                <a class="btn btn-gwms" href="{{url('/videosurveillance/project')}}/{{$getProjectsRows->videosurveillance_project_id}}">
                                    <i class="fa fa-folder-open"></i>
                                </a>
                            </td>
                            <td>
                                @if(!empty($getProjectsRows->general_customer_names && $getProjectsRows->general_company_name))
                                {{$getProjectsRows->general_customer_names}}
                                <br />
                                {{$getProjectsRows->general_company_name}}
                                @elseif(!empty($getProjectsRows->general_customer_names))
                                    {{$getProjectsRows->general_customer_names}}
                                @else
                                    {{$getProjectsRows->general_company_name}}
                                @endif
                            </td>
                            <td>{{$getProjectsRows->videosurveillance_project_dvr_name}}</td>
                            <td>{{$getProjectsRows->videosurveillance_project_dvr_password}}</td>
                            <td>{{$getProjectsRows->videosurveillance_project_ip_domain}}</td>
                            <td>{{$getProjectsRows->videosurveillance_project_description}}</td>
                            <td><a target="top" href="http://maps.apple.com/maps?q={{$getProjectsRows->videosurveillance_project_coordinates}}">{{$getProjectsRows->videosurveillance_project_coordinates}}</a></td>
                            <td>{{App\Http\Controllers\showDate($getProjectsRows->videosurveillance_project_startdate)}}</td>
                            <td>{{App\Http\Controllers\showDate($getProjectsRows->videosurveillance_project_enddate)}}</td>
                        </tr>
                        @endforeach
                    </table>
                    <center>{!! $getProjects->links() !!}</center>
                </div>
            </div>
	</div>
    </div>
</div>
@endsection
