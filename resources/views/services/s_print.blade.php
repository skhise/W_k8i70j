<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Field Service Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            /* width: 100%; */
            margin: auto;
            border: 1px solid #000;
            padding: 10px;
        }

        .header {
            text-align: center;
            font-weight: bold;
            font-size: 18px;
        }

        .company-details,
        .customer-details,
        .table-section,
        .footer {
            width: 100%;
            border-collapse: collapse;
        }


        .company-details td,
        .customer-details td,
        .table-section th,
        .table-section td {
            border: 1px solid black;
            padding: 5px;
        }
        .table-section,th{
            text-align: left;
        }
        .footer {
            margin-top: 20px;
        }

        .footer td {
            padding: 10px;
            border: 1px solid black;
        }
        strong {
            font-size: 14px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
             font-weight: 500;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">Field Service Report</div>
        <table class="company-details">
            <tr>
                <td>
                    <strong>{{$service->CST_Name}}</strong><br>
                    {{ $service->CST_OfficeAddress }}<br>
                </td>
                <td>
                    <strong>Ticket No.:</strong>{{ $service->service_no }}<br>
                    <strong>Date:</strong>{{ $service->created_at }}<br>
                    <strong>Service Type:</strong>{{ $service->type_name }}<br>
                    <strong>Issue Type:</strong>{{ $service->issue_name }}</br>
                    <strong>Contract
                        Type:</strong>{{ $service->contract_id == 0 ? 'Non-Contracted' : $contract->contract_type_name }}
                    <br>
                    <strong>Contract No.:</strong>{{ $contract->CNRT_Number ?? 'NA' }}


                </td>
            </tr>
            <tr>
                <td><strong>Contact Details</strong><br>
                    <strong>Contact Person: </strong>{{ $service->contact_person }}<br>
                    <strong>Phone: </strong>{{ $service->contact_number1 }}<br>
                    <p>{{ $service->site_address }}</p>
                </td>
                <td><strong>Ticket Details</strong><br>
                    <strong>Ticket Staus:</strong>{{ $service->Status_Name }}<br>
                    <strong>Date/Time:&nbsp;</strong>{{ $service->updated_at }}<br>
                    <strong>Assigned:&nbsp;</strong>{{ $service->EMP_Name }}
                </td>
            </tr>
        </table>

        <table class="customer-details">
            
        </table>
        <br>
        <table class="table-section">
            <tr>
                <td><strong>Utilized Product</strong></td>
            </tr>
        </table>
        <table class="table-section">
            <tr>
            <th>Sr. No.</th>
                    <th>Name</th>
                    <th>Srial No.</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Amount</th>
            </tr>
            @foreach ($DCProducts as $index => $product)
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
                <td colspan="5" style="text-align: right;"><strong>Total:</strong></td>
                <td>{{ number_format($DCProducts->sum(function ($product) {return $product['amount'];}),2) }}</td>
            </tr>
        </table>


        <p><strong>Description of Issue:</strong> {{$service->service_note}}</p>

        <p><strong>Resolution:</strong><br>
            Closed By:  {{ $service->ClosedBy }}<br>
            Date & Time: {{ $service->closed_at }}<br>
            Note: {{ $service->close_note }}
        </p>

        <p><strong>Customer Remark:</strong> </p>

        <table class="footer">
            <tr>
                <td><strong>Customer's Seal and Signature
                        Customer Name & Mobile No.</strong></td>
                <td><strong>Authorized Signatory</strong></td>
            </tr>
            <tr>
                <td><br><br>{{$service->CST_Name}} & {{$service->CCP_Mobile}}</td>
                <td><br><br></td>
            </tr>
        </table>
    </div>
</body>

</html>