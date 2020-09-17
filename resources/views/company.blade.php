@extends('layouts.app')
@section('content')
                       
<div class="container">
    <div class="row">
        <div class="col-lg-4">
            <?php $g = new \App\General; $g->backButton(); ?>
            <div class="panel panel-default">
                <div class="panel-heading text-center">ДАННИ</div>
                <div class="panel-body">
                    @foreach($getCompany as $getCompanyRows)                 
                    <form class="form-horizontal" role="form" method="POST" action="{{url('/getorders')}}">
                        {!! csrf_field() !!}
                        <input type="hidden" value="{{$getCompanyRows->general_company_id}}" name="general_company_id" />
                    </form>
                    <br />
                    <table class="table table-bordered">
                        <tr>
                            <td>
                                <label class="control-label">СТАТУС: </label>
                                @if ($getCompanyRows->general_company_level == 1)
                                <i class="fa fa-square fa-lg level-green"></i>
                                @elseif ($getCompanyRows->general_company_level == 2)
                                <i class="fa fa-square fa-lg level-yellow"></i>
                                @else ($getCompanyRows->general_company_level == 3)
                                <i class="fa fa-square fa-lg level-red"></i>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><label class="control-label">ИМЕ: </label>{{$getCompanyRows->general_company_name}}</td>
                        </tr>
                        <tr>
                            <td><label class="control-label">ЕИК: </label> {{$getCompanyRows->general_company_number}} </td>
                        </tr>
                        <tr>
                            <td><label class="control-label">ИН ПО ДДС: </label> {{$getCompanyRows->general_company_taxnumber}} </td>
                        </tr>
                        <tr>
                            <td><label class="control-label">АДРЕС: </label> {{$getCompanyRows->general_company_address}} </td>
                        </tr>
                        <tr>
                            <td><label class="control-label">МОЛ: </label> {{$getCompanyRows->general_company_owner}} </td>
                        </tr>
                        <tr>
                            <td><label class="control-label">БАНКА: </label> {{$getCompanyRows->general_company_bank}} </td>
                        </tr>
                        <tr>
                            <td><label class="control-label">IBAN: </label> {{$getCompanyRows->general_company_iban}} </td>
                        </tr>
                        <tr>
                            <td><label class="control-label">BIC: </label> {{$getCompanyRows->general_company_bic}} </td>
                        </tr>
                        <tr>
                            <td><label class="control-label">ТЕЛЕФОН: </label> {{$getCompanyRows->general_company_phone}} </td>
                        </tr>
                        <tr>
                            <td><label class="control-label">ДОСТАВЧИК: </label>
                                @if($getCompanyRows->general_company_isprovider == 0)
                                {{Lang::get('general.no')}}
                                @else
                                {{Lang::get('general.yes')}}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><label class="control-label">ДОБАВЕНА НА: </label> {{$getCompanyRows->general_company_added}} </td>
                        </tr>
                        <tr>
                            <td><label class="control-label">ДОБАВЕНА ОТ: </label> {{$getCompanyRows->name}} </td>
                        </tr>
                    </table>
                    <button class="btn btn-info" data-toggle="modal" data-target="#update">РЕДАКТИРАЙ</button>
                    <!-- Update Modal -->
                    <div id="update" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form role="form" method="POST" action="{{url('updatecompany')}}">
                                    {!! csrf_field() !!}
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      <h4 class="modal-title">РЕДАКЦИЯ НА {{$getCompanyRows->general_company_name}}</h4>
                                    </div>
                                    <div class="modal-body form-group">
                                        <input type="hidden" name="update_id" value="{{$getCompanyRows->general_company_id}}" />
                                        <label class="control-label">ИМЕ</label>
                                        <input class="form-control" type="text" value="{{$getCompanyRows->general_company_name}}" name="general_company_name" />
                                        <label class="control-label">ЕИК</label>
                                        <input class="form-control" type="text" value="{{$getCompanyRows->general_company_number}}" name="general_company_number" />
                                        <label class="control-label">ИН ПО ДДС</label>
                                        <input class="form-control" type="text" value="{{$getCompanyRows->general_company_taxnumber}}" name="general_company_taxnumber" />
                                        <label class="control-label">АДРЕС</label>
                                        <input class="form-control" type="text" value="{{$getCompanyRows->general_company_address}}" name="general_company_address" />
                                        <label class="control-label">МОЛ</label>
                                        <input class="form-control" type="text" value="{{$getCompanyRows->general_company_owner}}" name="general_company_owner" />
                                        <label class="control-label">БАНКА</label>
                                        <input class="form-control" type="text" value="{{$getCompanyRows->general_company_bank}}" name="general_company_bank" />
                                        <label class="control-label">IBAN</label>
                                        <input class="form-control" type="text" value="{{$getCompanyRows->general_company_iban}}" name="general_company_iban" />
                                        <label class="control-label">BIC</label>
                                        <input class="form-control" type="text" value="{{$getCompanyRows->general_company_bic}}" name="general_company_bic" />
                                        <label class="control-label">ТЕЛЕФОН</label>
                                        <input class="form-control" type="text" value="{{$getCompanyRows->general_company_phone}}" name="general_company_phone" />
                                        <br />ДОСТАВЧИК (ако фирмата ще е и доставчик, за вас)
                                        <div class="slideTwo">	
                                            <input type="checkbox" value="1" id="slideTwo" name="general_company_isprovider" <?php if($getCompanyRows->general_company_isprovider == 1) { echo "checked"; } ?> />
                                            <label for="slideTwo"></label>
                                        </div>
                                        <br />
                                        <label class="control-label">СТАТУС</label>
                                        <select class="form-control" name="general_company_level">
                                            <option value="1" <?php if($getCompanyRows->general_company_level == 1) { echo "selected"; }?>>ФИРМА С КОЯТО НЯМАМЕ ПРОБЛЕМИ</option>
                                            <option value="2" <?php if($getCompanyRows->general_company_level == 2) { echo "selected"; }?>>ФИРМА С КОЯТО ИМАМЕ МАЛКО ПРОБЛЕМИ</option>
                                            <option value="3" <?php if($getCompanyRows->general_company_level == 3) { echo "selected"; }?>>ФИРМА С КОЯТО ИМАМЕ МНОГО ПРОБЛЕМИ</option>
                                        </select>
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
                </div>
            </div>
        </div>
    </div>
</div>
                        
@endsection