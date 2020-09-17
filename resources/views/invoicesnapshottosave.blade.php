<?php 
$translate = Session::get('translated'); 
?>
<form method="POST" id='snapshotform' action="{{url('/storeinvoicesnapshot')}}">
    {!! csrf_field() !!}
    <input type="hidden" value="{{$invoiceid}}" name="invoiceid" />
    <textarea name="invoice_snapshot" style="display:none;">
<div class="container">
    <div class="row breakpage">
        <div class="col-lg-12">
        <?php $g = new App\Invoices; ?>
        @foreach($g->getInvoiceContent($invoiceid) as $getInvoiceContent)
            @foreach($g->getInvoiceOrder($getInvoiceContent->orders_order_id) as $getInvoiceOrderRows)
                <?php
                $invoicenum = $getInvoiceContent->orders_invoice_number;
                $invoicenumber = str_pad($invoicenum, 9, "0", STR_PAD_LEFT);
                
                $productsrownumber = 1;
                $totalproducts = null;
                $totalservices = null;
                ?>
                <div class="panel-body panel shadow-all">
                    <div class="col-lg-12 padding-bottom10 text-right" style="border-bottom: 1px solid #aaa;">
                        <img src='../logo-invoices.jpg' width="500"/>
                    </div>
                    <!-- INVOICE AND COMPANIES -->
                    <table width="100%" border="0" rowspace="0" colspace="0">
                        <!-- INVOICE -->
                        <tr>
                            <td valign="top" align="left" class="calibri30">ФАКТУРА <span class="calibri15">(архивирана)</span></td>
                        </tr>
                        <!-- NUMBER AND DATE -->
                        <tr>
                            <td height="40" class="calibri15">№ {{$getInvoiceContent->orders_invoices_prefix}}{{$invoicenumber}} от {{ \App\General::showDate($getInvoiceContent->orders_invoice_date) }}</td>
                        </tr>
                        <!-- COMPANIES -->
                        <tr>
                            <td width="49%" valign="top">
                                <span class="calibri20">ПОЛУЧАТЕЛ</span>
                                <div style="border-top: 4px solid #f77901;padding-bottom: 10px;"></div>
                                <div>
                                    @if($getInvoiceContent->general_company_id != 0)
                                    @foreach($g->getCompany($getInvoiceContent->general_company_id) as $getCompanyRows)
                                        <span class="calibri20">{{$getCompanyRows->general_company_name}}</span><br />
                                        ЕИК: {{$getCompanyRows->general_company_number}} <br />
                                        ИН ПО ДДС: {{$getCompanyRows->general_company_taxnumber}} <br />
                                        АДРЕС: {{$getCompanyRows->general_company_address}} <br />
                                        МОЛ: {{$getCompanyRows->general_company_owner}} <br />
                                        БАНКА: {{$getCompanyRows->general_company_bank}} <br />
                                        BIC: {{$getCompanyRows->general_company_bic}} <br />
                                        IBAN: {{$getCompanyRows->general_company_iban}} <br />
                                    @endforeach
                                    @endif
                                    @if($getInvoiceContent->general_customer_id != 0)
                                    @foreach($g->getCustomer($getInvoiceContent->general_customer_id) as $getCustomerRows)
                                        <span class="calibri20">{{$getCustomerRows->general_customer_names}}</span><br />
                                    @endforeach
                                    @endif
                                </div>
                            </td>
                            <td width="49%" valign="top">
                                <span class="calibri20">ИЗДАТЕЛ</span>
                                <div style="border-top: 2px solid #f77901;padding-bottom: 10px;"></div>
                                <div>
                                    @foreach($g->getOwnCompany($getInvoiceContent->general_owncompany_id) as $getOwnCompanyRows)
                                        <span class="calibri20">{{$getOwnCompanyRows->general_owncompany_name}}</span><br />
                                        ЕИК: {{$getOwnCompanyRows->general_owncompany_number}} <br />
                                        ИН ПО ДДС: {{$getOwnCompanyRows->general_owncompany_taxnumber}} <br />
                                        АДРЕС: {{$getOwnCompanyRows->general_owncompany_address}} <br />
                                        МОЛ: {{$getOwnCompanyRows->general_owncompany_owner}} <br />
                                        БАНКА: {{$getOwnCompanyRows->general_owncompany_bank}} <br />
                                        BIC: {{$getOwnCompanyRows->general_owncompany_bic}} <br />
                                        IBAN: {{$getOwnCompanyRows->general_owncompany_iban}} <br />
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                        <!-- BLANK LINE -->
                        <tr>
                            <td height="20"></td>
                        </tr>
                    </table>
                    <!-- INVOICE CONTENT -->
                    <table class="table table-striped text-center">
                        <!-- CONTENT TITLE LINE -->
                        <tr style="border-bottom: 2px solid #f77901;border-top: 2px solid #f77901;">
                            <td>#</td>
                            <td>НАИМЕНОВАНИЕ НА СТОКИТЕ И УСЛУГИТЕ</td>
                            <td>МЯРКА</td>
                            <td>КОЛИЧЕСТВО</td>
                            <td>ЕД. ЦЕНА</td>
                            <td>СТОЙНОСТ</td>
                        </tr>
                        <!-- CONTENT PRODUCTS -->
                        @foreach($g->getOrderProducts($getInvoiceOrderRows->order_id) as $getOrderProduct)
                        <tr>
                            <td>{{$productsrownumber++}}</td>
                            <td>{{$getOrderProduct->product_brandmodel}}</td>
                            <td>
                            @if($getOrderProduct->product_quantity_type == 1)
                                    {{Lang::get('orders.quantity_type_br')}}
                                @endif
                                @if($getOrderProduct->product_quantity_type == 2)
                                    {{Lang::get('orders.quantity_type_m')}}
                                @endif
                            </td>
                            <td style="min-width: 100px;">{{$getOrderProduct->orders_products_soldquantity}}</td>
                            <td style="min-width: 100px;">
                                @if($getOrderProduct->orders_products_soldprice == 0)
                                    {{$getOrderProduct->product_sellprice}} лв.
                                @else
                                    {{$getOrderProduct->orders_products_soldprice}} лв.
                                @endif
                            </td>
                            <td style="min-width: 100px;">
                                <?php
                                    if($getOrderProduct->orders_products_soldprice == 0) {
                                        $totalproducts += $getOrderProduct->orders_products_soldquantity*$getOrderProduct->product_sellprice;
                                    } else {
                                        $totalproducts += $getOrderProduct->orders_products_soldquantity*$getOrderProduct->orders_products_soldprice;
                                    }
                                ?>
                                @if($getOrderProduct->orders_products_soldprice == 0)
                                    {{number_format(($getOrderProduct->orders_products_soldquantity*$getOrderProduct->product_sellprice), 2)}} лв.
                                @else 
                                    {{number_format(($getOrderProduct->orders_products_soldquantity*$getOrderProduct->orders_products_soldprice), 2)}} лв.
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        <?php $servicesrownumber = $productsrownumber; ?>
                        <!-- CONTENT SERVICES -->
                        @foreach($g->getOrderServices($getInvoiceOrderRows->order_id) as $getOrderService)
                        <tr>
                            <td>{{$servicesrownumber++}}</td>
                            <td>{{$getOrderService->service}}</td>
                            <td style="min-width: 100px;">
                                @if($getOrderService->service_quantity_type == 1)
                                    {{Lang::get('orders.quantity_type_br')}}
                                @endif
                                @if($getOrderService->service_quantity_type == 2)
                                    {{Lang::get('orders.quantity_type_m')}}
                                @endif
                            </td>
                            <td> {{$getOrderService->orders_service_soldquantity}}</td>
                            <td style="min-width: 100px;">   
                                @if($getOrderService->orders_service_soldprice == 0)
                                    {{$getOrderService->service_price}} лв.
                                @else
                                    {{$getOrderService->orders_service_soldprice}} лв.
                                @endif
                            </td>
                            <td style="min-width: 100px;">
                                <?php
                                    if($getOrderService->orders_service_soldprice == 0) {
                                        $totalservices += $getOrderService->orders_service_soldquantity*$getOrderService->service_price;
                                    } else {
                                        $totalservices += $getOrderService->orders_service_soldquantity*$getOrderService->orders_service_soldprice;
                                    }
                                ?>
                                @if($getOrderService->orders_service_soldprice == 0)
                                    {{number_format(($getOrderService->orders_service_soldquantity*$getOrderService->service_price), 2)}} лв.
                                @else 
                                    {{number_format(($getOrderService->orders_service_soldquantity*$getOrderService->orders_service_soldprice), 2)}} лв.
                                @endif    
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    <?php $total = ($totalproducts + $totalservices)*$getInvoiceContent->orders_invoice_tax; ?>
                    <!-- INVOICE FOOTER -->
                    <table width="100%" border="0" rowspace="0" colspace="0" style="border-top: 2px solid #f77901;">
                        <tr><td height="30" colspan="5"></td></tr>
                        <tr>
                            <td width="70%">СЛОВОМ: {{$translate}}</td>
                            <td width="30%" class="calibri15 text-right">ВСИЧКО: {{number_format($totalproducts + $totalservices, 2)}}лв.</td>
                        <tr>
                        <tr>
                            <td class="text-left">ПЛАЩАНЕ: <?php if($getInvoiceContent->orders_invoice_isbank == 1) { echo "по банков път"; } else { echo "в брой"; } ?> </td>
                            <td class="calibri15 text-right">
                                <?php $tax = $total - ($totalproducts + $totalservices); ?>
                                @if($getInvoiceContent->orders_invoice_tax == 1.00)
                                ДДС (0%): 0.00лв.
                                @elseif($getInvoiceContent->orders_invoice_tax == 1.09)
                                ДДС (9%): {{number_format($tax, 2)}}лв.
                                @elseif($getInvoiceContent->orders_invoice_tax == 1.20)
                                ДДС (20%): {{number_format($tax, 2)}}лв.
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @if($getInvoiceContent->orders_invoice_tax <= 1.00)
                                Основание на сделката: за неначисляване на данък чл.113, ал.9
                                @else
                                <br />
                                @endif
                            </td>
                            <td class="calibri15 text-right">ОБЩО: {{number_format($total, 2)}}лв.</td>
                        </tr>
                        <tr>
                            <td colspan="2" height="100">@if(!empty($getInvoiceContent->orders_invoice_customrow)) {{$getInvoiceContent->orders_invoice_customrow}} @else @endif</td>
                        </tr>
                    </table>
                    <table width="100%" border="0" rowspace="0" colspace="0">
                        <tr>
                            <td width="50%" align="left">
                                Получател: ______________
                                @if(!empty($getInvoiceContent->orders_invoice_recipient))
                                    {{$getInvoiceContent->orders_invoice_recipient}}
                                @elseif(!empty($getInvoiceContent->general_customer_id))
                                    {{$getCustomerRows->general_customer_names}}
                                @else
                                    @foreach($g->getCompany($getInvoiceContent->general_company_id) as $getCompanyRows)
                                        {{$getCompanyRows->general_company_owner}}
                                    @endforeach
                                @endif
                            </td>
                            <td width="50%" align="right">
                                Съставил: ______________ 
                                @foreach($g->getOwnCompany($getInvoiceContent->general_owncompany_id) as $getOwnCompanyRows)
                                    {{$getOwnCompanyRows->general_owncompany_owner}}
                                @endforeach
                            </td>
                        </tr>
                        <tr><td height="30"></td></tr>
                    </table>
                </div>
            @endforeach
        @endforeach
        </div>
    </div>
</div>
    </textarea>
    <input type="hidden" name="invoicetotal" value="{{$total}}" />
    <input type="hidden" name="invoicetax" value="{{$getInvoiceContent->orders_invoice_tax}}" />
    <script type="text/javascript">document.getElementById('snapshotform').submit(); // SUBMIT FORM</script>
</form>
<?php
Session::forget('translated');
?>