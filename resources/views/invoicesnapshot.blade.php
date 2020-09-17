@extends('layouts.app')
@section('content')
<?php $g = new App\Invoices; ?>
    @foreach($g->getInvoiceSnapshot($invoiceid) as $getSnapshot)
        <?php echo $getSnapshot->orders_invoice_snapshot; ?>
    @endforeach
@endsection