@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center calibri20">ОБЕКТ #{{$projectid}}</div>
                <div class="panel-body">
                    <?php $g = new \App\Http\Controllers\GeneralController(); ?>
                    <div class="text-left calibri20">
                        ИНФОРМАЦИЯ ЗА ОБЕКТА <br />
                        <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#updateProject{{$projectid}}">РЕДАКТИРАНЕ</button>
                        @foreach(App\getProject($projectid) as $getProjectRows)
                        @if(empty($getProjectRows->general_customer_names))
                        <?php 
                            $g->addCustomerModal(
                            $modalbuttontext = \Illuminate\Support\Facades\Lang::get('general.button_addcustomer'), 
                            $headertitle = \Illuminate\Support\Facades\Lang::get('general.modal_title_addcustomer'), 
                            $bodytext = "",
                            $action = "/storecustomertoproject",
                            $updateid = $projectid, 
                            $buttonsize = "xs"
                            );
                        ?>
                        @endif
                        @if(empty($getProjectRows->general_company_name))
                        <?php 
                            $g->addCompanyModal(
                            $modalbuttontext = \Illuminate\Support\Facades\Lang::get('general.button_addcompany'), 
                            $headertitle = \Illuminate\Support\Facades\Lang::get('general.modal_title_addcompany'), 
                            $bodytext = "",
                            $action = "/storecompanytoproject",
                            $updateid = $projectid,
                            $buttonsize = "xs"
                            );
                        ?>
                        @endif
                        @endforeach
                    </div>
                    <div id="updateProject{{$projectid}}" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form role="form" method="POST" action="{{url('updatevideosurveillance')}}">
                                    {!! csrf_field() !!}
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      <h4 class="modal-title">РЕДАКТИРАНЕ</h4>
                                    </div>
                                    <div class="modal-body form-group">
                                        <input type="hidden" name="update_id" value="{{$projectid}}" />
                                        @foreach(App\getProject($projectid) as $getProjectRows)
                                        <br /><br />
                                        ИМЕ НА DVR
                                        <input class="form-control" type="text" name="videosurveillance_project_dvr_name" value="{{$getProjectRows->videosurveillance_project_dvr_name}}" />
                                        ПАРОЛА НА DVR
                                        <input class="form-control" type="text" name="videosurveillance_project_dvr_password" value="{{$getProjectRows->videosurveillance_project_dvr_password}}" />
                                        IP / ДОМЕЙН
                                        <input class="form-control" type="text" name="videosurveillance_project_ip_domain" value="{{$getProjectRows->videosurveillance_project_ip_domain}}" />
                                        МАК АДРЕС
                                        <input class="form-control" type="text" name="videosurveillance_project_mac_address" value="{{$getProjectRows->videosurveillance_project_mac_address}}" />
                                        ОПИСАНИЕ
                                        <textarea class="form-control" type="text" name="videosurveillance_project_description" />{{$getProjectRows->videosurveillance_project_description}}</textarea>
                                        КОРДИНАТИ
                                        <input class="form-control" type="text" name="videosurveillance_project_coordinates" value="{{$getProjectRows->videosurveillance_project_coordinates}}" />
                                        СТАРТИРАН НА
                                        <input class="form-control" type="text" name="videosurveillance_project_startdate" autocomplete="off" id="startdate" value="{{$getProjectRows->videosurveillance_project_startdate}}" placeholder=" изберете дата">
                                            <script src="/js/pikaday.js"></script>
                                            <script>
                                            var picker = new Pikaday(
                                            {
                                                field: document.getElementById('startdate'),
                                                firstDay: 1,
                                                //minDate: new Date(2015, 0, 1),
                                                //maxDate: new Date(2017, 11, 31),
                                                //yearRange: [2007,2017],

                                            });

                                            </script>
                                         ЗАВЪРШЕН НА
                                         <input class="form-control" type="text" name="videosurveillance_project_enddate" autocomplete="off" id="enddate" value="{{$getProjectRows->videosurveillance_project_enddate}}" placeholder=" изберете дата">
                                            <script src="/js/pikaday.js"></script>
                                            <script>
                                            var picker = new Pikaday(
                                            {
                                                field: document.getElementById('enddate'),
                                                firstDay: 1,
                                                //minDate: new Date(2015, 0, 1),
                                                //maxDate: new Date(2017, 11, 31),
                                                //yearRange: [2007, 2017],

                                            });

                                            </script>
                                        @endforeach
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success ladda-button" data-style="expand-left">{!! Lang::get('general.button_update') !!}</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">{!! Lang::get('general.button_cancel') !!}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped text-center">
                        <tr class="info">
                            <td>КЛИЕНТ / ФИРМА</td>
                            <td>ИМЕ НА DVR</td>
                            <td>ПАРОЛА</td>
                            <td>IP / ДОМЕЙН</td>
                            <td>МАК АДРЕС</td>
                            <td>ОПИСАНИЕ</td>
                            <td>КООРДИНАТИ</td>
                            <td>ЗАПОЧНАТ</td>
                            <td>ЗАВЪРШЕН</td>
                            <td>ДОБАВЕН НА </td>
                            <td>ДОБАВЕН ОТ </td>
                        </tr>

                        @foreach(App\getProject($projectid) as $getProjectRows)
                        <tr>
                            <td>
  
                                @if(!empty($getProjectRows->general_customer_names && $getProjectRows->general_company_name))
                                {{$getProjectRows->general_customer_names}}
                                <br />
                                {{$getProjectRows->general_company_name}}
                                @elseif(!empty($getProjectRows->general_customer_names))
                                    {{$getProjectRows->general_customer_names}}
                                @else
                                    {{$getProjectRows->general_company_name}}
                                @endif
                            </td>
                            <td>{{$getProjectRows->videosurveillance_project_dvr_name}}</td>
                            <td>{{$getProjectRows->videosurveillance_project_dvr_password}}</td>
                            <td>{{$getProjectRows->videosurveillance_project_ip_domain}}</td>
                            <td>{{$getProjectRows->videosurveillance_project_mac_address}}</td>
                            <td>{{$getProjectRows->videosurveillance_project_description}}</td>
                            <td><a target="top" href="http://maps.apple.com/maps?q={{$getProjectRows->videosurveillance_project_coordinates}}">{{$getProjectRows->videosurveillance_project_coordinates}}</a></td>
                            <td><?php \App\General::showDate($getProjectRows->videosurveillance_project_startdate); ?></td>
                            <td><?php \App\General::showDate($getProjectRows->videosurveillance_project_enddate); ?></td>
                            <td><?php \App\General::showDate($getProjectRows->videosurveillance_project_added); ?></td>
                            <td>{{$getProjectRows->name}}</td>
                        </tr>
                    </table>
                    <div class="text-left calibri15">ПРОДУКТИ И УСЛУГИ ПОЛЗВАНИ В НАЧАЛНИЯ ПРОЕКТ</div>
                    <table class="table table-striped text-center">
                        <tr class="info">
                            <td>Категория</td>
                            <td>Марка - модел</td>
                            <td>Описание</td>
                            <td>Сериен номер</td>
                            <td>Количество</td>
                            <td>Продажна цена</td>
                            <td>Добавен на</td>
                        </tr>
                        @if($getProjectRows->orders_order_id == 0)
                        <form method="post" action="{{url('/storenewordertovideosurveillance')}}" >
                            {!! csrf_field() !!}
                            <input type="hidden" name="project_id" value="{{$projectid}}" />
                            <tr><td colspan="7"><button class="btn btn-gwms">ДОБАВИ ПРОДУКТИ И УСЛУГИ</button></td></tr>
                        </form>
                        @else
                        @foreach(\App\getProducts($getProjectRows->orders_order_id) as $getProductsRows)
                        <tr style="border-bottom: 1px solid #ccc;"> 
                            <td>{{$getProductsRows->product_category}}</td>
                            <td>{{$getProductsRows->product_brandmodel}}</td>
                            <td>{{$getProductsRows->product_description}}</td>
                            <td>{{$getProductsRows->product_serialnumber}}</td>
                            <td>{{$getProductsRows->orders_products_soldquantity}}</td>
                            <td>
                                @if($getProductsRows->orders_products_soldprice == 0)
                                    {{$getProductsRows->product_sellprice}} лв.
                                @else
                                    {{$getProductsRows->orders_products_soldprice}} лв.
                                @endif
                            </td>
                            <td>
                                <?php
                                    
                                    \App\General::showDate($getProductsRows->orders_products_added);
                                ?>
                            </td>
                        </tr>
                        @endforeach
                        <tr><td colspan='7'>УСЛУГИ</td></tr>
                        @foreach(\App\getServices($getProjectRows->orders_order_id) as $getServicesRows)
                        <tr style="border-bottom: 1px solid #ccc;">
                            <td>{{$getServicesRows->services_category}}</td>
                            <td colspan='3'>{{$getServicesRows->service}}</td>
                            <td>{{$getServicesRows->orders_service_soldquantity}}</td>
                            <td>
                                @if($getServicesRows->orders_service_soldprice == 0)
                                    {{$getServicesRows->service_price}} лв.
                                @else
                                    {{$getServicesRows->orders_service_soldprice}} лв.
                                @endif
                            </td>
                            <td><?php \App\General::showDate($getServicesRows->orders_service_added); ?></td>
                        </tr>
                        @endforeach
                        <tr><td colspan="7"><a class="btn btn-warning btn-xs" href="{{url('/order/')}}/{{$getProjectRows->orders_order_id}}" >ВИЖ ПРОТОКОЛА</a></td></tr>
                        @endif
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading calibri20 text-center">ОБНОВЛЕНИЯ</div>
                <div class="panel-body">
                    <!-- STORE PROJECT UPGRADE MODAL -->
                    <button class="btn btn-gwms" data-toggle="modal" data-target="#storeprojectupgrade">{!! \Illuminate\Support\Facades\Lang::get('general.button_storevideosurveillanceupgrade') !!}</button>
                    <div id="storeprojectupgrade" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form role="form" method="POST" action="{{url('storevideosurveillanceupgrade')}}">
                                    {!! csrf_field() !!}
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      <h4 class="modal-title">ДОБАВЯНЕ НА ОБНОВЛЕНИЕ КЪМ ОБЕКТ #{{$projectid}}</h4>
                                    </div>
                                    <div class="modal-body form-group">
                                        <input type="hidden" name="project_id" value="{{$projectid}}" />
                                        ОПИСАНИЕ
                                        <textarea class="form-control" name="videosurveillance_upgrade_description" ></textarea>
                                        СТАРТИРАНО НА
                                        <input class="form-control" type="text" name="videosurveillance_upgrade_startdate" autocomplete="off" id="startdateupgrade" placeholder=" изберете дата">
                                        <script src="/js/pikaday.js"></script>
                                        <script>
                                        var picker = new Pikaday(
                                        {
                                            field: document.getElementById('startdateupgrade'),
                                            firstDay: 1,
                                            //minDate: new Date(2015, 0, 1),
                                            //maxDate: new Date(2017, 11, 31),
                                            //yearRange: [2007,2017],

                                        });

                                        </script>
                                         ЗАВЪРШЕНО НА
                                         <input class="form-control" type="text" name="videosurveillance_upgrade_enddate" autocomplete="off" id="enddateupgrade" placeholder=" изберете дата">
                                        <script src="/js/pikaday.js"></script>
                                        <script>
                                        var picker = new Pikaday(
                                        {
                                            field: document.getElementById('enddateupgrade'),
                                            firstDay: 1,
                                            //minDate: new Date(2015, 0, 1),
                                            //maxDate: new Date(2017, 11, 31),
                                            //yearRange: [2007, 2017],

                                        });

                                        </script>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success ladda-button" data-style="expand-left">{!! Lang::get('general.button_add') !!}</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">{!! Lang::get('general.button_cancel') !!}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- STORE PROJECT UPGRADE MODAL END -->
                    <br /><br />
                    <?php $num = 1; ?>
                    @foreach(App\getUpgrades($projectid) as $getUpgradesRows)
                    <div class="calibri35" style="color: #666;">{{$num++}}</div>
                    <div class="text-left calibri20" style="border-bottom: 3px solid #999;"></div>
                    <table class="table text-center">
                        <div>Започнато на <?php \App\General::showDate($getUpgradesRows->videosurveillance_upgrade_startdate); ?></div>
                        <div>Завършено на <?php \App\General::showDate($getUpgradesRows->videosurveillance_upgrade_enddate); ?></div>
                        <div>ОПИСАНИЕ НА ОБНОВЛЕНИЕТО: {{$getUpgradesRows->videosurveillance_upgrade_description}}</div>
                        <!-- UPDATE PROJECT UPGRADE MODAL -->
                        <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#updateprojectupgrade{{$getUpgradesRows->videosurveillance_upgrade_id}}">{!! \Illuminate\Support\Facades\Lang::get('general.button_edit') !!}</button>
                        <br /><br />
                        <div id="updateprojectupgrade{{$getUpgradesRows->videosurveillance_upgrade_id}}" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form role="form" method="POST" action="{{url('updatevideosurveillanceupgrade')}}">
                                        {!! csrf_field() !!}
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title">РЕДАКТИРАНЕ НА ОБНОВЛЕНИЕ</h4>
                                        </div>
                                        <div class="modal-body form-group">
                                            <input type="hidden" name="project_id" value="{{$projectid}}" />
                                            <input type="hidden" name="update_id" value="{{$getUpgradesRows->videosurveillance_upgrade_id}}" />
                                            ОПИСАНИЕ
                                            <textarea class="form-control" type="text" name="videosurveillance_upgrade_description" />{{$getUpgradesRows->videosurveillance_upgrade_description}}</textarea>
                                            СТАРТИРАН НА
                                            <input class="form-control" type="text" name="videosurveillance_upgrade_startdate" autocomplete="off" id="startdateupgradeproject{{$getUpgradesRows->videosurveillance_upgrade_id}}" value="{{$getUpgradesRows->videosurveillance_upgrade_startdate}}" placeholder=" изберете дата">
                                            <script src="/js/pikaday.js"></script>
                                            <script>
                                            var picker = new Pikaday(
                                            {
                                                field: document.getElementById('startdateupgradeproject<?php echo $getUpgradesRows->videosurveillance_upgrade_id; ?>'),
                                                firstDay: 1,
                                                //minDate: new Date(2015, 0, 1),
                                                //maxDate: new Date(2017, 11, 31),
                                                //yearRange: [2007,2017],

                                            });

                                            </script>
                                            ЗАВЪРШЕН НА
                                            <input class="form-control" type="text" name="videosurveillance_upgrade_enddate" autocomplete="off" id="enddateupgradeproject{{$getUpgradesRows->videosurveillance_upgrade_id}}" value="{{$getUpgradesRows->videosurveillance_upgrade_enddate}}" placeholder=" изберете дата">
                                            <script src="/js/pikaday.js"></script>
                                            <script>
                                            var picker = new Pikaday(
                                            {
                                                field: document.getElementById('enddateupgradeproject<?php echo $getUpgradesRows->videosurveillance_upgrade_id; ?>'),
                                                firstDay: 1,
                                                //minDate: new Date(2015, 0, 1),
                                                //maxDate: new Date(2017, 11, 31),
                                                //yearRange: [2007, 2017],

                                            });

                                            </script>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success ladda-button" data-style="expand-left">{!! Lang::get('general.button_update') !!}</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">{!! Lang::get('general.button_cancel') !!}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- UPDATE PROJECT UPGRADE MODAL END -->
                        <div style="border-bottom: 1px solid #ccc;" class="calibri15">ПРОДУКТИ И УСЛУГИ КЪМ ОБНОВЛЕНИТО</div>
                        @if($getUpgradesRows->orders_order_id == 0)
                        <form method="post" action="{{url('/storenewordertovideosurveillanceupgrade')}}" >
                            {!! csrf_field() !!}
                            <input type="hidden" name="upgrade_id" value="{{$getUpgradesRows->videosurveillance_upgrade_id}}" />
                            <tr><td colspan="8"><button class="btn btn-gwms">ДОБАВИ ПРОДУКТИ</button></td></tr>
                        </form>
                        @else
                        <tr><td colspan="7">СТОКИ</td></tr>
                        @foreach(App\getProducts($getUpgradesRows->orders_order_id) as $getUpgradesProductsRows)
                        <tr>
                            <td>{{$getUpgradesProductsRows->product_category}}</td>
                            <td>{{$getUpgradesProductsRows->product_brandmodel}}</td>
                            <td>{{$getUpgradesProductsRows->product_description}}</td>
                            <td>{{$getUpgradesProductsRows->product_number}}</td>
                            <td>{{$getUpgradesProductsRows->product_serialnumber}}</td>
                            <td>{{$getUpgradesProductsRows->orders_products_soldquantity}} x
                                @if($getUpgradesProductsRows->orders_products_soldprice == 0)
                                    {{$getUpgradesProductsRows->product_sellprice}} лв.
                                @else
                                    {{$getUpgradesProductsRows->orders_products_soldprice}} лв.
                                @endif
                            </td>
                            <td><?php \App\General::showDate($getUpgradesProductsRows->orders_products_added);?></td>
                        </tr>  
                        @endforeach
                        <tr><td colspan="7">УСЛУГИ</td></tr>
                        @foreach(\App\getServices($getUpgradesRows->orders_order_id) as $getServicesRows)
                        <tr style="border-bottom: 1px solid #ccc;">
                            <td>{{$getServicesRows->services_category}}</td>
                            <td colspan='4'>{{$getServicesRows->service}}</td>
                            <td>{{$getServicesRows->orders_service_soldquantity}}
                                x
                                @if($getServicesRows->orders_service_soldprice == 0)
                                    {{$getServicesRows->service_price}} лв.
                                @else
                                    {{$getServicesRows->orders_service_soldprice}} лв.
                                @endif
                            </td>
                            <td><?php \App\General::showDate($getServicesRows->orders_service_added); ?></td>
                        </tr>
                        @endforeach
                        <tr><td colspan="8"><a class="btn btn-warning btn-xs" href="{{url('/order/')}}/{{$getUpgradesRows->orders_order_id}}" >ВИЖ ПРОТОКОЛА</a></td></tr>
                        @endif
                    </table>
                    
                    @endforeach
                </div>
            </div>
	</div>
    </div>
</div>
@endsection
