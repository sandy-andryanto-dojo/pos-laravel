
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Hello World">
        <meta name="author" content="Sandy Andryanto">
        <title> {{ env('APP_NAME', 'Laravel') }} - Print Invoice Sale</title>
        <!-- Bootstrap Core CSS -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    </head>
    <body onload="window.print()">
        <div class="">
            <div class="container-fluid table-responsive">
                <h1 class='text-center'>
                    SALE INVOICE 
                </h1>
                <hr>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th colspan="2">Invoice Date : {{ $model->created_at }}</th>
                            <th colspan="2">Invoice Number : {{ $model->invoice_number }}</th>
                        </tr>
                        <tr>
                            <th colspan="2">Customer : {{ isset($model->Customer->name) ? $model->Customer->name : null }}</th>
                            <th colspan="2">Casheir : {{ isset($model->Casheir->username) ? $model->Casheir->username : null }}</th>
                        </tr>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($details) > 0)
                            @foreach($details as $detail)
                                <tr>
                                    <td>{{ $detail->Product->sku }} - {{ $detail->Product->name }}</td>
                                    <td>{{ $detail->price }}</td>
                                    <td>{{ $detail->qty }}</td>
                                    <td>{{ $detail->total }}</td>
                                </tr>
                            @endforeach
                        @else
                        <tr class='text-center'>
                            <td colspan='4'>
                                -- No Items --
                            </td>
                        </tr>
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2">Discount : {{ $model->discount }}</th>
                            <th colspan="2">Tax : {{ $model->tax }}</th>
                        </tr>
                        <tr>
                            <th colspan="2">Subtotal : {{ $model->subtotal }}</th>
                            <th colspan="2">Grand Total : {{ $model->grandtotal }}</th>
                        </tr>
                        <tr>
                            <th colspan="2">Petty Cash : {{ $model->cash }}</th>
                            <th colspan="2">Change : {{ $model->change }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </body>
</html>