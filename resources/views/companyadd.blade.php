@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading text-center">ДОБАВЯНЕ НА ФИРМА - КЛИЕНТ</div>
                <div class="panel-body">
                    <form role="form" method="POST" action="{{url('storecompany')}}">
                        {!! csrf_field() !!}
                        <label class="control-label">ИМЕ:</label>
                        <input class="form-control" placeholder="въведете името на фирмата ..." type="text" value="" name="general_company_name" />
                        <label class="control-label">ЕИК:</label>
                        <input class="form-control" placeholder="въведете номера на фирмата ..." type="text" value="" name="general_company_number" />
                        <label class="control-label">ИН ПО ДДС:</label>
                        <input class="form-control" placeholder="(ако има) въведете номера на фирмата по ДДС ..." type="text" value="" name="general_company_taxnumber" />
                        <label class="control-label">АДРЕС:</label>
                        <input class="form-control" placeholder="въведете адреса на фирмата ..." type="text" value="" name="general_company_address" />
                        <label class="control-label">МОЛ:</label>
                        <input class="form-control" placeholder="въведете МОЛ на фирмата ..." type="text" value="" name="general_company_owner" />
                        <label class="control-label">ТЕЛЕФОН:</label>
                        <input class="form-control" placeholder="въведете номер за връзка с фирмата ..." type="text" value="" name="general_company_phone" />
                        <label class="control-label">БАНКА:</label>
                        <input class="form-control" placeholder="въведете банката в която е сметката на фирмата ..." type="text" value="" name="general_company_bank" />
                        <label class="control-label">IBAN:</label>
                        <input class="form-control" placeholder="въведете IBAN номера за сметката на фирмата ..."type="text" value="" name="general_company_iban" />
                        <label class="control-label">BIC:</label>
                        <input class="form-control" placeholder="въведете BIC номера за сметката на фирмата ..." type="text" value="" name="general_company_bic" />
                        <br />ДОСТАВЧИК (ако фирмата ще е и доставчик, за вас, отбележете го)
                        <div class="slideTwo">	
                            <input type="checkbox" value="1" id="slideTwo" name="general_company_isprovider" />
                            <label for="slideTwo"></label>
                        </div>
                        <br />
                        <a href="{{URL::previous()}}" type="button" class="btn btn-danger">{!! Lang::get('general.button_back') !!}</a>
                        <button type="submit" class="btn btn-success ladda-button" data-style="expand-left">{!! Lang::get('general.button_add') !!}</button>
                        <br /><br />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
