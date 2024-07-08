<!DOCTYPE html>
<html>

<head>
    <title>DC Statement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .quotation-header,
        .quotation-details {
            margin-bottom: 20px;
        }

        .quotation-header h1 {
            margin: 0;
            text-align: center;
        }

        .customer-info {
            width: 30%;
        }

        .customer-info,
        .product-info {
            margin-bottom: 20px;
        }

        .product-info table {
            width: 100%;
            border-collapse: collapse;
        }

        .product-info table,
        .product-info th,
        .product-info td {
            border: 1px solid black;
        }

        .product-info th,
        .product-info td {
            padding: 8px;
            text-align: left;
        }

        .quotation-date {
            float: right;
        }
    </style>
</head>

<body>

    <div class="quotation-header">
        <h1>DC Summary</h1>
    </div>
    <div class="quotation-date">
        <p>DC No.: <strong>000{{ $serviceDc->dcp_id }}</strong></p>
        <p>Date: <strong>{{ $date }}</strong></p>
    </div>

    <div class="customer-info">
        <h2>To,</h2>
        <p>{{ $serviceDc['CST_Name'] }}</p>
        <p>{{ $serviceDc['CST_OfficeAddress'] }}</p>
        <p>{{ $serviceDc['CCP_Mobile'] }}</p>
        <p>{{ $serviceDc['CCP_Email'] }}</p>
    </div>
    <div class="quotation-info">
        <h2>DC Details,</h2>
        <p>Type:&nbsp;&nbsp;&nbsp;{{ $serviceDc->dc_type_name }}</p>
        <p>Service No.:&nbsp;&nbsp;&nbsp;{{ $serviceDc->service_no }}</p>
        <h4>Note</h4>
        <p>{{ empty($serviceDc->Product_Description) ? 'NA' : $serviceDc->Product_Description }}</p>
    </div>
    <br />
    <div class="product-info">
        <h2>Product Information</h2>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Srial No.</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $product['Product_Name'] }}</td>
                        <td>{{ $product['sr_number'] }}</td>
                        <td>{{ $product['type_name'] }}</td>
                        <td>{{ $product['description'] }}</td>
                        <td>{{ $product['amount'] }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="5">
                        <span style="float:right;">Total</span>
                    </td>
                    <td><strong>
                            {{ number_format($products->sum(function ($product) {return $product['amount'];}),2) }}
                        </strong></td>
                </tr>
            </tbody>
        </table>
    </div>
    <script>
        window.onload = function() {
            window.print();
        };

        window.onafterprint = function() {
            window.close();
        };
    </script>
</body>

</html>
