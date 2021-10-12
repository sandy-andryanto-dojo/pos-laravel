
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
                    PURCHASE ORDER REPORT BY PRODUCT
                </h1>
                <hr>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Brand</th>
                            <th>Type</th>
                            <th>Supplier</th>
                            <th>SKU</th>
                            <th>Product Name</th>
                            <th>Total Items</th>
                            <th>Total Purchase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($data) > 0)
                            @foreach($data as $row)
                                <tr>
                                    <td>{{ $row->brand_name }}</td>
                                    <td>{{ $row->type_name }}</td>
                                    <td>{{ $row->supplier_name }}</td>
                                    <td>{{ $row->product_sku }}</td>
                                    <td>{{ $row->product_name }}</td>
                                    <td>{{ $row->total_buy }}</td>
                                    <td>{{ $row->total_purchase }}</td>
                                </tr>
                            @endforeach
                        @else 
                        <tr class="text-center">
                            <td colspan="7">
                                -- No Data --
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>