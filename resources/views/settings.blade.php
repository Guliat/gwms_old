@extends('layouts.app')@section('content')<div class="container-fluid padding-top50">    <div class="row">        <!-- OWN COMPANIES -->        <div class="col-lg-12">            <div class="panel panel-default">                <div class="panel-heading text-center calibri20">СОБСТВЕНИ ФИРМИ</div>                <div class="panel-body">                    <button class="btn btn-gwms" data-toggle="modal" data-target="#storeowncompany">{!! Lang::get('general.button_addcompany') !!}</button><br /><br />                    <!-- Store Own Company Modal -->                    <div id="storeowncompany" class="modal fade" role="dialog">                        <div class="modal-dialog">                            <div class="modal-content">                                <form role="form" method="POST" action="{{url('storeowncompany')}}">                                    {!! csrf_field() !!}                                    <div class="modal-header">                                      <button type="button" class="close" data-dismiss="modal">&times;</button>                                      <h4 class="modal-title">ДОБАВЯНЕ НА СОБСТВЕНА ФИРМА</h4>                                    </div>                                    <div class="modal-body form-group">                                        <label class="control-label">ИМЕ</label>                                        <input class="form-control" type="text" name="general_owncompany_name" />                                        <label class="control-label">ЕИК</label>                                        <input class="form-control" type="text" name="general_owncompany_number" />                                        <label class="control-label">ИН ПО ДДС</label>                                        <input class="form-control" type="text"name="general_owncompany_taxnumber" />                                        <label class="control-label">АДРЕС</label>                                        <input class="form-control" type="text" name="general_owncompany_address" />                                        <label class="control-label">МОЛ</label>                                         <input class="form-control" type="text" name="general_owncompany_owner" />                                        <label class="control-label">БАНКА</label>                                        <input class="form-control" type="text" name="general_owncompany_bank" />                                        <label class="control-label">IBAN</label>                                        <input class="form-control" type="text" name="general_owncompany_iban" />                                        <label class="control-label">BIC</label>                                        <input class="form-control" type="text" name="general_owncompany_bic" />                                    </div>                                    <div class="modal-footer">                                        <button type="submit" class="btn btn-gwms ladda-button" data-style="expand-left">{!! Lang::get('general.button_add') !!}</button>                                        <button type="button" class="btn btn-danger" data-dismiss="modal">{!! Lang::get('general.button_cancel') !!}</button>                                    </div>                                </form>                            </div>                        </div>                    </div>                    <table class="table table-striped table-bordered text-center">                        <tr>                            <td>ФИРМА</td>                            <td>ЕИК</td>                            <td class='hidden-xs'>ИН ПО ДДС</td>                            <td class='hidden-xs'>АДРЕС</td>                            <td class='hidden-xs'>МОЛ</td>                            <td class='hidden-xs'>БАНКА</td>                            <td class='hidden-xs'>IBAN</td>                            <td class='hidden-xs'>BIC</td>                        </tr>                            @foreach(\App\OwnCompanies::getOwnCompanies() as $getOwnCompaniesRows)                        <tr>                            <td>{{$getOwnCompaniesRows->general_owncompany_name}}</td>                            <td>{{$getOwnCompaniesRows->general_owncompany_number}}</td>                            <td class='hidden-xs'>{{$getOwnCompaniesRows->general_owncompany_taxnumber}}</td>                            <td class='hidden-xs'>{{$getOwnCompaniesRows->general_owncompany_address}}</td>                            <td class='hidden-xs'>{{$getOwnCompaniesRows->general_owncompany_owner}}</td>                            <td class='hidden-xs'>{{$getOwnCompaniesRows->general_owncompany_bank}}</td>                            <td class='hidden-xs'>{{$getOwnCompaniesRows->general_owncompany_iban}}</td>                            <td class='hidden-xs'>{{$getOwnCompaniesRows->general_owncompany_bic}}</td>                            @if($getOwnCompaniesRows->general_owncompany_isactive == 0)                            <td><span class="danger tooltip-g">ЗАКРИТА</span></td>                            @else                            <td><button class="btn btn-info" data-toggle="modal" data-target="#updateowncompany{{$getOwnCompaniesRows->general_owncompany_id}}"><i class="fa fa-pencil"></i></button></td>                            @endif                        </tr>                            <!-- Update Own Company Modal -->                            <div id="updateowncompany{{$getOwnCompaniesRows->general_owncompany_id}}" class="modal fade" role="dialog">                                <div class="modal-dialog">                                    <div class="modal-content">                                        <form role="form" method="POST" action="{{url('updateowncompany')}}">                                            {!! csrf_field() !!}                                            <div class="modal-header text-left">                                                <button type="button" class="close" data-dismiss="modal">&times;</button>                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#removeowncompany{{$getOwnCompaniesRows->general_owncompany_id}}"><i class="fa fa-ban"></i> ЗАКРИЙ ФИРМАТА</button>                                                <br /><br />                                                <h4 class="modal-title text-center">                                                    РЕДАКЦИЯ НА {{$getOwnCompaniesRows->general_owncompany_name}}                                                </h4>                                            </div>                                            <div class="modal-body form-group">                                                <input type="hidden" name="update_id" value="{{$getOwnCompaniesRows->general_owncompany_id}}" />                                                <input type="hidden" name="remove_id" value="{{$getOwnCompaniesRows->general_owncompany_id}}" />                                                                                        <label class="control-label">ИМЕ</label>                                                <input class="form-control" type="text" value="{{$getOwnCompaniesRows->general_owncompany_name}}" name="general_owncompany_name" />                                                <label class="control-label">ЕИК</label>                                                <input class="form-control" type="text" value="{{$getOwnCompaniesRows->general_owncompany_number}}" name="general_owncompany_number" />                                                <label class="control-label">ИН ПО ДДС</label>                                                <input class="form-control" type="text" value="{{$getOwnCompaniesRows->general_owncompany_taxnumber}}" name="general_owncompany_taxnumber" />                                                <label class="control-label">АДРЕС</label>                                                <input class="form-control" type="text" value="{{$getOwnCompaniesRows->general_owncompany_address}}" name="general_owncompany_address" />                                                <label class="control-label">МОЛ</label>                                                <input class="form-control" type="text" value="{{$getOwnCompaniesRows->general_owncompany_owner}}" name="general_owncompany_owner" />                                                <label class="control-label">БАНКА</label>                                                <input class="form-control" type="text" value="{{$getOwnCompaniesRows->general_owncompany_bank}}" name="general_owncompany_bank" />                                                <label class="control-label">IBAN</label>                                                <input class="form-control" type="text" value="{{$getOwnCompaniesRows->general_owncompany_iban}}" name="general_owncompany_iban" />                                                <label class="control-label">BIC</label>                                                <input class="form-control" type="text" value="{{$getOwnCompaniesRows->general_owncompany_bic}}" name="general_owncompany_bic" />                                            </div>                                            <div class="modal-footer">                                                <button type="submit" class="btn btn-gwms ladda-button" data-style="expand-left">{!! Lang::get('general.button_update') !!}</button>                                                <button type="button" class="btn btn-danger" data-dismiss="modal">{!! Lang::get('general.button_cancel') !!}</button>                                            </div>                                        </form>                                    </div>                                </div>                            </div>                            <!-- Remove Own Company Modal -->                            <div id="removeowncompany{{$getOwnCompaniesRows->general_owncompany_id}}" class="modal fade" role="dialog">                                <div class="modal-dialog">                                    <div class="modal-content">                                        <form role="form" method="POST" action="{{url('removeowncompany')}}">                                            {!! csrf_field() !!}                                            <div class="modal-header">                                              <button type="button" class="close" data-dismiss="modal">&times;</button>                                              <h4 class="modal-title text-center">МОЛЯ ПОТВЪРДЕТЕ !!!</h4>                                            </div>                                            <div class="modal-body form-group text-center">                                                <input type="hidden" name="remove_id" value="{{$getOwnCompaniesRows->general_owncompany_id}}" />                                                <br /><br />СИГУРНИ ЛИ СТЕ, ЧЕ ИСКАТЕ ДА ЗАКРИЕТЕ: {{$getOwnCompaniesRows->general_owncompany_name}} ? <br /><br />                                            </div>                                            <div class="modal-footer">                                                <button type="submit" class="btn btn-gwms ladda-button" data-style="expand-left"><i class="fa fa-thumbs-up"></i> ПОТВЪРЖДАВАМ</button>                                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> ОТКАЗ</button>                                            </div>                                        </form>                                    </div>                                </div>                            </div>                        @endforeach                    </table>                </div>            </div>        </div>        <!-- OWN COMPANIES END -->        <!-- EMPLOYEES -->        <div class="col-lg-12">            <div class="panel panel-default">                <div class="panel-heading text-center calibri20">СЛУЖИТЕЛИ</div>                <div class="panel-body">                    <button class="btn btn-gwms" data-toggle="modal" data-target="#newEmployee">{!! Lang::get('general.button_addemployee') !!}</button><br /><br />                    <!-- STORE EMPLOYEE MODAL -->                    <div id="newEmployee" class="modal fade" role="dialog">                        <div class="modal-dialog">                            <div class="modal-content">                                <form role="form" method="POST" action="{{ url('/storeemployee') }}">                                    {!! csrf_field() !!}                                    <div class="modal-header">                                      <button type="button" class="close" data-dismiss="modal">&times;</button>                                      <h4 class="modal-title">ДОБАВЯНЕ НА НОВ СЛУЖИТЕЛ</h4>                                    </div>                                    <div class="modal-body form-group">                                        <label class="control-label">ФИРМА</label>                                        <select class="form-control" name="general_owncompany_id">                                            @foreach(\App\OwnCompanies::getOwnCompanies() as $getOwnCompanies)                                            <option value="{{$getOwnCompanies->general_owncompany_id}}">{{$getOwnCompanies->general_owncompany_name}}</option>                                            @endforeach                                        </select>                                        <label class="control-label">ПОТРЕБИТЕЛСКО ИМЕ (за достъп до системата)</label>                                        <input class="form-control" type="text" name="login" />                                        <label class="control-label">ИМЕНА НА СЛУЖИТЕЛЯ</label>                                        <input class="form-control" type="text" name="name" />                                        <label class="control-label">СЛУЖЕБЕН ТЕЛЕФОН</label>                                        <input class="form-control" type="text" name="phone" />                                        <label class="control-label">СЛУЖЕБЕН E-MAIL</label>                                        <input class="form-control" type="text" name="email" />                                        <label class="control-label">ПАРОЛА ЗА ДОСТЪП</label>                                        <input class="form-control" type="password" name="password" />                                    </div>                                    <div class="modal-footer">                                        <button type="submit" class="btn btn-gwms ladda-button" data-style="expand-left">{!! Lang::get('general.button_add') !!}</button>                                        <button type="button" class="btn btn-danger" data-dismiss="modal">{!! Lang::get('general.button_cancel') !!}</button>                                    </div>                                </form>                            </div>                        </div>                    </div>                    <!-- STORE EMPLOYEE MODAL END -->                    <!-- CONTENT EMPLOYEES -->                    <table class="table table-striped table-bordered text-center">                        <tr>                            <td>Потребителско име</td>                            <td>Имена</td>                            <td class='hidden-xs'>Служебен телефон</td>                            <td class='hidden-xs'>Личен телефон</td>                            <td class='hidden-xs'>Служебен Email</td>                            <td class='hidden-xs'>Личен Email</td>                            <td class='hidden-xs'>СЛУЖИТЕЛ В</td>                            <td class='hidden-xs'>НАЕТ НА</td>                        </tr>                            @foreach(\App\OwnCompanies::getEmployees() as $getEmployeesRows)                        @if($getEmployeesRows->general_employee_isactive == 0)                        <tr class="danger">                        @else                        <tr>                        @endif                            <td>{{$getEmployeesRows->login}}</td>                            <td>{{$getEmployeesRows->name}}</td>                            <td class='hidden-xs'>{{$getEmployeesRows->phone}}</td>                            <td class='hidden-xs'>{{$getEmployeesRows->personal_phone}}</td>                            <td class='hidden-xs'>{{$getEmployeesRows->email}}</td>                            <td class='hidden-xs'>{{$getEmployeesRows->personal_email}}</td>                            <td class='hidden-xs'>{{$getEmployeesRows->general_owncompany_name}}</td>                            <td class='hidden-xs'>{{\App\General::showDate($getEmployeesRows->created_at)}}г.</td>                            <td>                                @if($getEmployeesRows->general_employee_isactive == 0)                                ТОЗИ СЛУЖИТЕЛ Е УВОЛНЕН <br />                                на {{\App\showDate($getEmployeesRows->general_employee_firedat)}}г.<br />                                @else                                <button class="btn btn-info" data-toggle="modal" data-target="#updateEmployee{{$getEmployeesRows->id}}"><i class="fa fa-pencil"></i></button>                                <button class="btn btn-danger tooltip-g" data-toggle="modal" data-target="#fireEmployee{{$getEmployeesRows->id}}"><i class="fa fa-thumbs-down"></i><div class="tooltiptext-g">УВОЛНИ ТОЗИ СЛУЖИТЕЛ</div></button>                                @endif                            </td>                        </tr>                        <!-- FIRE EMPLOYEE MODAL -->                        <div id="fireEmployee{{$getEmployeesRows->id}}" class="modal fade" role="dialog">                            <div class="modal-dialog">                                <div class="modal-content">                                    <form role="form" method="POST" action="{{url('removeemployee')}}">                                        {!! csrf_field() !!}                                        <div class="modal-header">                                          <button type="button" class="close" data-dismiss="modal">&times;</button>                                          <h4 class="modal-title text-center">МОЛЯ ПОТВЪРДЕТЕ !!!</h4>                                        </div>                                        <div class="modal-body form-group text-center">                                            <input type="hidden" name="update_id" value="{{$getEmployeesRows->id}}" />                                            <br /><br />СИГУРНИ ЛИ СТЕ, ЧЕ ИСКАТЕ ДА УВОЛНИТЕ: {{$getEmployeesRows->name}} ? <br /><br />                                        </div>                                        <div class="modal-footer">                                            <button type="submit" class="btn btn-gwms ladda-button" data-style="expand-left">{!! Lang::get('general.button_confirm') !!}</button>                                            <button type="button" class="btn btn-danger" data-dismiss="modal">{!! Lang::get('general.button_cancel') !!}</button>                                        </div>                                    </form>                                </div>                            </div>                        </div>                        <!-- FIRE EMPLOYEE MODAL END -->                        <!-- UPDATE EMPLOYEE MODAL -->                        <div id="updateEmployee{{$getEmployeesRows->id}}" class="modal fade" role="dialog">                            <div class="modal-dialog">                                <div class="modal-content">                                    <form role="form" method="POST" action="{{url('updateemployee')}}">                                        {!! csrf_field() !!}                                        <div class="modal-header">                                          <button type="button" class="close" data-dismiss="modal">&times;</button>                                          <h4 class="modal-title">РЕДАКЦИЯ НА {{$getEmployeesRows->name}}</h4>                                        </div>                                        <div class="modal-body form-group">                                            <input type="hidden" name="update_id" value="{{$getEmployeesRows->id}}" />                                            <label class="control-label">ПОТРЕБИТЕЛСКО ИМЕ</label>                                            <input class="form-control" type="text" value="{{$getEmployeesRows->login}}" name="login" />                                            <label class="control-label">ИМЕНА</label>                                            <input class="form-control" type="text" value="{{$getEmployeesRows->name}}" name="name" />                                            <label class="control-label">ТЕЛЕФОН</label>                                            <input class="form-control" type="text" value="{{$getEmployeesRows->phone}}" name="phone" />                                            <label class="control-label">ЛИЧЕН ТЕЛЕФОН</label>                                            <input class="form-control" type="text" value="{{$getEmployeesRows->personal_phone}}" name="personal_phone" />                                            <label class="control-label">EMAIL</label>                                            <input class="form-control" type="text" value="{{$getEmployeesRows->email}}" name="email" />                                            <label class="control-label">ЛИЧЕН EMAIL</label>                                            <input class="form-control" type="text" value="{{$getEmployeesRows->personal_email}}" name="personal_email" />                                        </div>                                        <div class="modal-footer">                                            <button type="submit" class="btn btn-gwms ladda-button" data-style="expand-left">{!! Lang::get('general.button_update') !!}</button>                                            <button type="button" class="btn btn-danger" data-dismiss="modal">{!! Lang::get('general.button_cancel') !!}</button>                                        </div>                                    </form>                                </div>                            </div>                        </div>                        <!-- UPDATE EMPLOYEE MODAL END -->                        @endforeach                    </table>                    <!-- CONTENT EMPLOYEES END -->                    <center>{!! \App\OwnCompanies::getEmployees()->links() !!}</center>                </div>            </div>        </div>        <!-- EMPLOYEES END -->        <!-- LANGUAGES -->        <div class="col-lg-6">            <div class="panel panel-default">                <div class="panel-heading text-center calibri20">{!! Lang::get('general.languages') !!}</div>                <div class="panel-body">                    <table class="table table-striped table-bordered">                        @foreach (Config::get('languages') as $lang => $language)                        <tr>                            <td class="calibri25 text-center">{{$language}}                                @if ($lang == App::getLocale())                                    <i class="fa fa-check gwmsgreen"></i>                                @endif                            </td>                            <td>                                <button class="btn btn-info disabled">{!! Lang::get('general.button_edit') !!}</button>                                @if ($lang != App::getLocale())                                    <a class="btn btn-warning" href="{{ route('lang.switch', $lang) }}">{!! Lang::get('general.button_lang_make_default') !!}</a>                                @endif                            </td>                        </tr>                        @endforeach                    </table>                </div>              </div>        </div>        <!-- LANGUAGES END -->        <!-- QUANTITY TYPES -->        <div class="col-lg-6">            <div class="panel panel-default">                <div class="panel-heading text-center calibri20">МЕРНИ ЕДИНИЦИ</div>                <div class="panel-body text-center">                    <table class="table table-striped table-bordered text-center">                        <tr>                            <td>Кратко изписване</td>                            <td>Пълно изписване</td>                        </tr>                        @foreach(App\Settings::getQuantityTypes() as $getQuantityType)                        <tr>                            <td>{{$getQuantityType->store_quantity_type_short}}</td>                            <td>{{$getQuantityType->store_quantity_type_long}}</td>                            <td><button class="btn btn-info disabled" ><i class="fa fa-pencil"></i></button></td>                        </tr>                        @endforeach                    </table>                    <button class="btn btn-gwms disabled" >{!! Lang::get('general.button_add') !!}</button>                </div>            </div>        </div>        <!-- QUANTITY TYPES END -->    </div></div>@endsection