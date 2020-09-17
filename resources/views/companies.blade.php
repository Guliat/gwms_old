@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default text-center">
                <div class="panel-heading">ФИРМИ</div>
                <div class="panel-body">
                    <div class="col-lg-12 text-left">
                        <a class="btn btn-gwms" href="{{url('/addcompany')}}">{!! Lang::get('general.button_addcompany') !!}</a>
                    </div>
                    <script type="text/javascript">
                    $j(function() {
                        var availableTags = <?php $companies = new App\AutoComplete(); $companies->companies(); ?>;
                        $j("#companies").autocomplete({
                            source: availableTags,
                            autoFocus:true,
                            minLength: 2
                        });
                    });
                    </script>
                    <form class="form-inline" method="post" action="{{url('/gotocompany')}}">
                        {!! csrf_field() !!}
                        <div class="col-lg-12 padding-bottom20">
                            <label class="control-label"> бързо търсене ... </label><br />
                            <input class="form-control" style="width: 500px;" placeholder="Можете да търсите по: ИМЕ, ЕИК, МОЛ и АДРЕС" type="text" name="gotocompany" id="companies" />
                            <button class="btn btn-gwms ladda-button" data-style="expand-left" type="submit"><i class="fa fa-arrow-right"></i></button>
                        </div>
                    </form>
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td>ФИРМА</td>
                            <td>ЕИК</td>
                            <td>ИН ПО ДДС</td>
                            <td>АДРЕС</td>
                            <td>МОЛ</td>
                            <td>ТЕЛЕФОН</td>
                            <td>БАНКА</td>
                            <td>IBAN</td>
                            <td>BIC</td>
                        </tr>    
                        @foreach($getAllCompanies as $getAllCompaniesRows)
                        <tr>
                            <td>{{$getAllCompaniesRows->general_company_name}}</td>
                            <td>{{$getAllCompaniesRows->general_company_number}}</td>
                            <td>{{$getAllCompaniesRows->general_company_taxnumber}}</td>
                            <td>{{$getAllCompaniesRows->general_company_address}}</td>
                            <td>{{$getAllCompaniesRows->general_company_owner}}</td>
                            <td>{{$getAllCompaniesRows->general_company_phone}}</td>
                            <td>{{$getAllCompaniesRows->general_company_bank}}</td>
                            <td>{{$getAllCompaniesRows->general_company_iban}}</td>
                            <td>{{$getAllCompaniesRows->general_company_bic}}</td>
                            <td><a class="btn btn-xs btn-info" href="{{url('/company')}}/{{$getAllCompaniesRows->general_company_id}}">ОТВОРИ</a></td>
                        </tr>
                        @endforeach
                    </table>
                     {!! $getAllCompanies->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
