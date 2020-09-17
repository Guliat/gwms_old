@extends('layouts.app')
@section('content')
<div class="container-fluid padding-top50 padding-bottom20">
    <div class="row">
        <div class="col-lg-12">
            <!-- COMPUTERS SERVICE CONTENT -->
            @foreach($getService as $getServiceRows)
            <table border="0" cellpading="0" cellspacing="0" align="center" width="100%" class="computer_service_content">
                <tr valign="top">
                    <!-- LEFT CONTENT -->
                    <td style="padding-right: 10px;border-right: 5px solid #88c101;">
                        <table align="right" class="text-right calibri20">
                            <tr><td>УСЛУГА</td></tr>
                            <tr><td style="border-bottom: 1px solid #88c101;"></td></tr>
                            <tr><td class="calibri40 gwmsgreen">#{{$getServiceRows->computers_service_id}}</td></tr>
                            <tr><td><i class="fa fa-plus"></i> {{ \App\General::showDate($getServiceRows->computers_service_added)}}</td></tr>
                            <tr><td><i class="fa fa-refresh"></i> {{ \App\General::showDate($getServiceRows->computers_service_updated)}}</td></tr>
                            <tr><td height="20"></td></tr>
                            <tr><td>КЛИЕНТ</td></tr>
                            <tr><td style="border-bottom: 1px solid #88c101;"></td></tr>
                            <tr><td><a href="{{url('/customer')}}/{{$getServiceRows->general_customer_id}}">#{{$getServiceRows->general_customer_id}}</a></td></tr>
                            <tr><td>{{$getServiceRows->general_customer_names}}</td></tr>
                            <tr><td>{{$getServiceRows->general_customer_nick}}</td></tr>
                            <tr>
                                <td>
                                <?php
                                    echo substr($getServiceRows->general_customer_phone, 0, -6);
                                    echo " ";
                                    echo substr($getServiceRows->general_customer_phone, 4, -4);
                                    echo " ";
                                    echo substr($getServiceRows->general_customer_phone, 6, -2);
                                    echo " ";
                                    echo substr($getServiceRows->general_customer_phone, 8, 10);
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                <?php
                                    echo substr($getServiceRows->general_customer_phone2, 0, -6);
                                    echo " ";
                                    echo substr($getServiceRows->general_customer_phone2, 4, -4);
                                    echo " ";
                                    echo substr($getServiceRows->general_customer_phone2, 6, -2);
                                    echo " ";
                                    echo substr($getServiceRows->general_customer_phone2, 8, 10);
                                ?>
                                </td>
                            </tr>
                            <tr><td>{{ \App\General::showDate($getServiceRows->general_customer_added)}}</td></tr>
                            <tr><td height="20"></td></tr>
                            <tr><td>УСТРОЙСТВО</td></tr>
                            <tr><td style="border-bottom: 1px solid #88c101;"></td></tr>
                            <?php
                                $deviceC = new \App\PCServices();
                                $deviceContent = $deviceC->getDeviceContent($getServiceRows->computers_device_id);
                            ?>
                            @foreach($deviceContent as $dc)
                            <tr><td><a href="{{url('/pcs/device')}}/{{$dc->computers_device_id}}">#{{$dc->computers_device_id}}</a></td></tr>
                            <tr><td>{{$dc->computers_device_category}}</td></tr>
                            <tr><td>{{$dc->computers_device_brandmodel}}</td></tr>
                            <tr><td>{{$dc->computers_device_submodel}}</td></tr>
                            <tr><td>{{$dc->computers_device_color}}</td></tr>
                            <tr><td>{{$dc->computers_device_note}}</td></tr>
                            <tr><td>{{ \App\General::showDate($dc->computers_device_added)}}</td></tr>
                            @endforeach
                        </table>
                    </td>
                    <!-- MIDDLE CONTENT -->
                    <td style="padding-left: 10px;padding-right: 10px;border-right: 5px solid #88c101;">
                        <table width="100%">                                
                            <tr>
                                <td class="calibri25">
                                    ОПЛАКВАНЕ
                                    <button class="btn btn-xs btn-default" data-toggle="modal" data-target="#updatepccomplaint">промени</button>
                                </td>
                            </tr>
                            <tr><td style="border-bottom: 1px solid #88c101;"></td></tr>
                            <tr><td class="calibri20">{{$getServiceRows->computers_service_complaint}}</td></tr>
                            <div id="updatepccomplaint" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="{{url('updatepccomplaint')}}">
                                            {!! csrf_field() !!}
                                            <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              <h4 class="modal-title text-center">ОПЛАКВАНЕ</h4>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" value="{{$getServiceRows->computers_service_id}}" name="updateid" />
                                                <textarea class="form-control" name="updatepccomplaint">{{$getServiceRows->computers_service_complaint}}</textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success ladda-button" data-style="expand-left">{!! Lang::get('general.button_update') !!}</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">{!! Lang::get('general.button_cancel') !!}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <tr><td height="30"></td></tr>
                            <tr>
                                <td class="calibri25">
                                    ЗАБЕЛЕЖКИ
                                    <button class="btn btn-xs btn-default " data-toggle="modal" data-target="#updatepcdesc">промени</button>
                                </td>
                            </tr>
                            <tr><td style="border-bottom: 1px solid #88c101;"></td></tr>
                            <tr><td class="calibri20">{{$getServiceRows->computers_service_description}}</td></tr>
                            <div id="updatepcdesc" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="{{url('updatepcdesc')}}">
                                            {!! csrf_field() !!}
                                            <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              <h4 class="modal-title text-center">ЗАБЕЛЕЖКИ</h4>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" value="{{$getServiceRows->computers_service_id}}" name="updateid" />
                                                <textarea class="form-control" name="updatepcdesc" />{{$getServiceRows->computers_service_description}}</textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success ladda-button" data-style="expand-left">{!! Lang::get('general.button_update') !!}</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">{!! Lang::get('general.button_cancel') !!}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <tr><td height="30"></td></tr>
                            <tr>
                                <td class="calibri25">
                                    ИСТОРИЯ
                                </td>
                            </tr>
                            <div id="storepcserviceupdate" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="{{url('storepcserviceupdate')}}">
                                            {!! csrf_field() !!}
                                            <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              <h4 class="modal-title text-center">ДОБАВЯНЕ НА НОВО РЕШЕНИЕ</h4>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" value="{{$getServiceRows->computers_service_id}}" name="storeid" />
                                                <input type="text" class="form-control" placeholder=" напишете последните действия извършени към тази услуга" name="storepcserviceupdate" />
                                                <br />
                                                <input class="form-control text-center" type="text" autocomplete="off" placeholder="дата" name="serviceupdateadded" id="date" />
                                                <script src="<?php echo asset('/js/pikaday.js')?>"></script>            
                                                <script>var picker = new Pikaday({field: document.getElementById('date'), numberOfMonths:1});</script>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success ladda-button" data-style="expand-left">{!! Lang::get('general.button_add') !!}</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">{!! Lang::get('general.button_cancel') !!}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <tr><td style="border-bottom: 1px solid #88c101;"></td></tr>
                            <tr>
                                <td>
                                    <table class="table table-responsive table-hover">
                                        <?php $nsu = 1; ?>
                                        @foreach(\App\PCServices::getServiceUpdates($getServiceRows->computers_service_id) as $serviceUpdates)
                                        <tr>
                                            <td>#{{$nsu++}}</td>
                                            <td class="left-border">{{\App\General::showDateTime($serviceUpdates->computers_service_update_added)}}</td>
                                            <td class="left-border">{{$serviceUpdates->name}}</td>
                                            <td width="60%" class="left-border">{{$serviceUpdates->computers_service_update}}</td>
                                            <td><button class='btn btn-xs btn-default' data-toggle="modal" data-target="#updatepcserviceupdate{{$serviceUpdates->computers_service_update_id}}">промени</button>
                                        </tr>
                                        <div id="updatepcserviceupdate{{$serviceUpdates->computers_service_update_id}}" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="POST" action="{{url('')}}">
                                                        {!! csrf_field() !!}
                                                        <div class="modal-header">
                                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                          <h4 class="modal-title text-center">РЕДАКТИРАНЕ НА РЕШЕНИЕ КЪМ УСЛУГА</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" value="{{$serviceUpdates->computers_service_update_id}}" name="updateid" />
                                                            <input type="text" class="form-control" value="{{$serviceUpdates->computers_service_update}}" name="pcserviceupdate" />
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success ladda-button" data-style="expand-left">{!! Lang::get('general.button_update') !!}</button>
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">{!! Lang::get('general.button_cancel') !!}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        <tr><td colspan="5" class="text-center"><button class="btn btn-warning" data-toggle="modal" data-target="#storepcserviceupdate">ДОБАВИ РЕД</button></td></tr>
                                    </table>
                                </td>
                            </tr>
                            <tr><td height="20"></td></tr>
                            
                            <tr>
                                <td class="calibri25">
                                    ЗА СЕРВИЗА (НЕ СЕ ВИЖДА ОТ КЛИЕНТА)
                                    <button class="btn btn-xs btn-default " data-toggle="modal" data-target="#updatepchiddesc">промени</button>
                                </td>
                            </tr>
                            <tr><td style="border-bottom: 1px solid #88c101;"></td></tr>
                            <tr><td class="calibri20">{{$getServiceRows->computers_service_hiddendescription}}</td></tr>
                            <div id="updatepchiddesc" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="{{url('updatepchiddesc')}}">
                                            {!! csrf_field() !!}
                                            <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              <h4 class="modal-title text-center">СКРИТО ОПИСАНИЕ</h4>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" value="{{$getServiceRows->computers_service_id}}" name="updateid" />
                                                <textarea class="form-control" placeholder="НЯМА СКРИТО ОПИСАНИЕ" name="updatepchiddesc" />{{$getServiceRows->computers_service_hiddendescription}}</textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success ladda-button" data-style="expand-left">{!! Lang::get('general.button_update') !!}</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">{!! Lang::get('general.button_cancel') !!}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </table>
                    </td>
                    <!-- RIGHT CONTENT -->
                    <td style="padding-left: 10px;">
                        <table>
                            <tr><td>КРАЙНА СУМА</td></tr>
                            <tr><td style="border-bottom: 1px solid #88c101;"></td></tr>
                            <?php
                                $total = $getServiceRows->computers_service_price+$getServiceRows->computers_service_partsprice-$getServiceRows->computers_service_discountprice;
                            ?>
                            <tr><td class="calibri50">{{$total}}лв.</td></tr>
                            <tr><td height="20"></td></tr>
                            <tr><td>ПРИБЛИЗИТЕЛНА ЦЕНА</td></tr>
                            <tr><td style="border-bottom: 1px solid #88c101;"></td></tr>
                            <tr><td class="calibri30">{{round($getServiceRows->computers_service_aboutprice, 2)}}лв.</td></tr>
                            <tr><td height="15"></td></tr>
                            <tr><td>УСЛУГА</td></tr>
                            <tr><td style="border-bottom: 1px solid #88c101;"></td></tr>                     
                            <tr>
                                <td class="calibri30">{{round($getServiceRows->computers_service_price, 2)}}лв.
                                    <button class="btn btn-xs btn-default" data-toggle="modal" data-target="#updatepcsp">промени</button>  
                                </td>
                            </tr>
                            <div id="updatepcsp" class="modal fade" role="dialog">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <form method="POST" action="{{url('updatepcsp')}}">
                                            {!! csrf_field() !!}
                                            <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              <h4 class="modal-title text-center">ПРОМЯНА НА ЦЕНА</h4>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" value="{{$getServiceRows->computers_service_id}}" name="updateid" />
                                                <input class="form-control" type="text" autocomplete="off" placeholder="{{round($getServiceRows->computers_service_price, 2)}}лв." name="updatepcsp" />
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success ladda-button" data-style="expand-left">{!! Lang::get('general.button_update') !!}</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">{!! Lang::get('general.button_cancel') !!}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <tr><td height="15"></td></tr>
                            <tr><td>СТОКИ / ВЪНШНА УСЛУГА</td></tr>
                            <tr><td style="border-bottom: 1px solid #88c101;"></td></tr>                     
                            <tr>
                                <td class="calibri30">{{round($getServiceRows->computers_service_partsprice, 2)}}лв.
                                    <button class="btn btn-xs btn-default " data-toggle="modal" data-target="#updatepcpp">промени</button>
                                </td>
                            </tr>
                            <div id="updatepcpp" class="modal fade" role="dialog">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <form method="POST" action="{{url('updatepcpp')}}">
                                            {!! csrf_field() !!}
                                            <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              <h4 class="modal-title text-center">ПРОМЯНА НА ЦЕНА</h4>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" value="{{$getServiceRows->computers_service_id}}" name="updateid" />
                                                <input class="form-control" type="text" autocomplete="off" placeholder="{{round($getServiceRows->computers_service_partsprice, 2)}}лв." name="updatepcpp" />
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success ladda-button" data-style="expand-left">{!! Lang::get('general.button_update') !!}</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">{!! Lang::get('general.button_cancel') !!}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <tr><td height="15"></td></tr>
                            <tr><td>ОТСТЪПКА</td></tr>
                            <tr><td style="border-bottom: 1px solid #88c101;"></td></tr>                     
                            <tr>
                                <td class="calibri30">{{round($getServiceRows->computers_service_discountprice, 2)}}лв.
                                    <button class="btn btn-xs btn-default " data-toggle="modal" data-target="#updatepcdp">промени</button>
                                </td>
                            </tr>
                            <div id="updatepcdp" class="modal fade" role="dialog">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <form method="POST" action="{{url('updatepcdp')}}">
                                            {!! csrf_field() !!}
                                            <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              <h4 class="modal-title text-center">ПРОМЯНА НА ЦЕНА</h4>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" value="{{$getServiceRows->computers_service_id}}" name="updateid" />
                                                <input class="form-control" type="text" autocomplete="off" placeholder="{{round($getServiceRows->computers_service_discountprice, 2)}}лв." name="updatepcdp" />
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success ladda-button" data-style="expand-left">{!! Lang::get('general.button_update') !!}</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">{!! Lang::get('general.button_cancel') !!}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @if($dc->computers_device_category_id == 1)
                            <tr><td height="15"></td></tr>
                            <tr><td>ЧАНТА, ЗАРЯДНО, БАТЕРИЯ</td></tr>
                            <tr><td style="border-bottom: 1px solid #88c101;"></td></tr>
                            <tr><td height="10"></td></tr>
                            <tr><td class="padding-bottom10">@if($getServiceRows->computers_service_havebag == 1)<i class="fa fa-briefcase fa-2x gwmsgreen"></i>@else<i class="fa fa-briefcase fa-2x inactive-icon"></i>@endif</td></tr>
                            <tr><td class="padding-bottom10">@if($getServiceRows->computers_service_havepower == 1)<i class="fa fa-plug fa-2x gwmsgreen"></i>@else<i class="fa fa-plug fa-2x inactive-icon"></i>@endif</td></tr>
                            <tr><td class="padding-bottom10">@if($getServiceRows->computers_service_havebattery == 1)<i class="fa fa-battery-three-quarters fa-2x gwmsgreen"></i>@else<i class="fa fa-battery-three-quarters fa-2x inactive-icon"></i>@endif</td></tr>
                            <tr><td><button class="btn btn-xs btn-default " data-toggle="modal" data-target="#updatebagpwrbat">промени</button></td></tr>
                            <div id="updatebagpwrbat" class="modal fade" role="dialog">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <form method="POST" action="{{url('updatebagpwrbat')}}">
                                            {!! csrf_field() !!}
                                            <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              <h4 class="modal-title text-center">ЧАНТА, ЗАРЯДНО, БАТЕРИЯ</h4>
                                            </div>
                                            <div class="modal-body" style="padding-left: 30%;">
                                                <input type="hidden" value="{{$getServiceRows->computers_service_id}}" name="updateid" />
                                                <label for="bag">
                                                    <input type="checkbox" name="bag" id="bag" value="1" <?php if($getServiceRows->computers_service_havebag == 1) { echo "checked"; } ?>/>
                                                    <i></i><span> ЧАНТА</span>
                                                </label>
                                                <label for="power">
                                                    <input type="checkbox" name="power" id="power" value="1" <?php if($getServiceRows->computers_service_havepower == 1) { echo "checked"; } ?>/>
                                                    <i></i><span> ЗАРЯДНО</span>
                                                </label>
                                                <label for="battery">
                                                    <input type="checkbox" name="battery" id="battery" value="1" <?php if($getServiceRows->computers_service_havebattery == 1) { echo "checked"; } ?>/>
                                                    <i></i><span> БАТЕРИЯ</span>
                                                </label>
                                            </div>
                                            <div class="modal-footer" style="padding-right: 20%;">
                                                <button type="submit" class="btn btn-success ladda-button" data-style="expand-left">{!! Lang::get('general.button_update') !!}</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">{!! Lang::get('general.button_cancel') !!}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @else
                            @endif
                        </table>
                    </td>
                </tr>
                <tr align="center">
                    <td colspan="3" class='padding-top20'>
                        <div class="btn-group">
                            <?php
                            if($getServiceRows->computers_service_isactive == 1) {
                                \App\Http\Controllers\GeneralController::confirmModal('success', 'lg', 'ПРИКЛЮЧИ', '', '/completepcservice', $getServiceRows->computers_service_id);
                            ?>
                            <button type="button" class="btn btn-warning btn-lg">ИЗЧАКВАЩА</button>
                            <?php } ?>
                            <a href="{{url('/pcs/service/print')}}/{{$getServiceRows->computers_service_id}}" class="btn btn-info btn-lg tooltip-g"><i class="fa fa-print fa-lg"></i><div class="tooltiptext-g">ПРИНТИРАНЕ</div></a>
                        </div>
                    </td>
                </tr>
                <tr><td colspan="3" height="50"></td></tr>
            </table>  
            @endforeach
            <!-- END OF COMPUTERS SERVICE CONTENT -->
        </div>
    </div>
</div>
<?php $title = "УСЛУГА #".$getServiceRows->computers_service_id; ?>
@endsection