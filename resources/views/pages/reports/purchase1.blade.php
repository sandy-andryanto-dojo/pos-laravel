
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Hello World">
        <meta name="author" content="Sandy Andryanto">
        <title> {{ env('APP_NAME', 'Laravel') }} - Print Report Purchase Order</title>
        <!-- Bootstrap Core CSS -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="">
            <div class="container-fluid table-responsive">
                <h1 class='text-center'>
                    PURCHASE ORDER REPORT 
                </h1>
                <hr>
                @foreach($data as $model)
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">Invoice Date : {{ $model->created_at }}</th>
                                <th colspan="2">Invoice Number : {{ $model->invoice_number }}</th>
                            </tr>
                            <tr>
                                <th colspan="2">Supplier : {{ isset($model->Supplier->name) ? $model->Supplier->name : "-" }}</th>
                                <th colspan="2">Casheir : {{  isset($model->Casheir->username) ? $model->Casheir->username : "-" }}</th>
                            </tr>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                             @php $details = \App\Models\TransactionDetail::where("transaction_id", $model->id)->get(); @endphp
                             @if(count($details) > 0)
                                @foreach($details as $detail)
                                    <tr>
                                        <td>{{ isset($detail->Product->sku) ? $detail->Product->sku : null }} - {{ isset($detail->Product->name) ? $detail->Product->name : null }}</td>
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
                                <th colspan="4">Subtotal : {{ $model->subtotal }}</th>
                            </tr>
                        </tfoot>
                    </table>
                    <hr>
                @endforeach
            </div>
        </div>
    </body>
</html>