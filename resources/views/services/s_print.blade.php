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
            text-align: left;
            font-weight: 500;
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
        @media print {
            @page {
                size: A4;
                margin: 5mm;
                /* Set custom margin */
            }

            body {
                margin: 0;
                /* Ensure no extra margins from the body */
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">Field Service Report</div>
        <table class="company-details">
            <tr>
                <td style="width:50%">
                    <strong>{{$service->CST_Name}}</strong><br>
                    {{ $service->CST_OfficeAddress }}<br>
                </td>
                <td style="width:50%">
                    <strong>Ticket No.:&nbsp;&nbsp;</strong>{{ $service->service_no }}<br>
                    <strong>Date:&nbsp;&nbsp;</strong>{{ $service->created_at }}<br>
                    <strong>Service Type:&nbsp;&nbsp;</strong>{{ $service->type_name }}<br>
                    <strong>Contract
                        Type:&nbsp;&nbsp;</strong>{{ $service->contract_id == 0 ? 'Non-Contracted' : $contract->contract_type_name }}
                    <br>
                    <strong>Contract No.:&nbsp;&nbsp;</strong>{{ $contract->CNRT_Number ?? 'NA' }}


                </td>
            </tr>
            <tr>
                <td><strong>Contact Details</strong><br>
                    <strong>Contact Person:&nbsp;&nbsp; </strong>{{ $service->contact_person }}<br>
                    <strong>Phone: &nbsp;&nbsp;</strong>{{ $service->contact_number1 }}<br>
                    <p>{{ $service->site_address }}</p>
                </td>
                <td><strong>Ticket Details</strong><br>
                    <strong>Ticket Staus:&nbsp;&nbsp;</strong>{{ $service->Status_Name }}<br>
                    <strong>Date/Time:&nbsp;&nbsp;</strong>{{ $service->updated_at }}<br>
                    <strong>Assigned:&nbsp;&nbsp;</strong>{{ $service->EMP_Name }}
                </td>
            </tr>
        </table>

                
        <p><strong>Issue Type:&nbsp;&nbsp;</strong>{{ $service->issue_name }}</p>
        <p><strong>Description of Issue:&nbsp;&nbsp;</strong> {{$service->service_note}}</p>

        <p><strong>Resolution:&nbsp;</strong><br><br>
        
            Note:&nbsp;&nbsp;{{ $service->close_note }}<br><br>
            Closed By:&nbsp;&nbsp;  {{ $service->ClosedBy }}<br><br>
            Date & Time:&nbsp;&nbsp; {{ $service->closed_at }}<br><br>
        </p>

        <p><strong>Customer Remark:</strong> </p>
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


        <table class="footer">
            <tr>
                <td style="width:50%"><strong>Customer's Seal and Signature
                        Customer Name & Mobile No.</strong></td>
                <td style="width:50%"><strong>Authorized Signatory</strong></td>
            </tr>
            <tr>
                <td><br><br>{{$service->CST_Name}} & {{$service->CCP_Mobile}}</td>
                <td><br><br></td>
            </tr>
        </table>
    </div>
</body>

</html>