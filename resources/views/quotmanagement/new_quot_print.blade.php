<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 80%; margin: auto; border: 1px solid #000; padding: 10px; }
        .header { text-align: center; font-weight: bold; font-size: 18px; }
        .company-details, .customer-details, .table-section, .footer { width: 100%; border-collapse: collapse; }
        .company-details td, .customer-details td, .table-section th, .table-section td { border: 1px solid black; padding: 5px; }
        .footer { margin-top: 20px; }
        .footer td { padding: 10px; border: 1px solid black; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Quotation</div>
        <table class="company-details">
            <tr>
                <td>
                    <strong>{{$quotation['CST_Name']}}.</strong><br>
                    {{$quotation['CST_OfficeAddress']}}.<br>
                    PH. No. {{$quotation['CCP_Mobile']}}<br>
                    Email. {{$quotation['CCP_Email']}}<br>
                    GSTIN/UIN:  | PAN: 
                </td>
                <td>
                    <strong>Quotation No:</strong> 000{{$quotation->dcp_id}}<br>
                    <strong>Date:</strong> {{$date}}<br>
                    <strong>Ticket No:</strong> {{ $quotation->service_no }}<br>
                    <strong>Type:</strong> {{ $quotation->quot_type_name }}<br>
                    <strong>Status:</strong>{{ $quotation->status_name }}
                </td>
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
                <td colspan="5" style="text-align: right;"><strong>Total:</strong></td>
                <td>{{ number_format($products->sum(function ($product) {return $product['amount'];}),2) }}</td>
            </tr>
        </table>

        <p><strong>Remark:</strong> {{ empty($quotation->Product_Description) ? 'NA' : $quotation->Product_Description }}</p>
        <table class="footer">
            <tr>
                <td><strong>Customer's Received Signature</strong></td>
                <td><strong>Authorized Signatory</strong></td>
            </tr>
            <tr>
                <td><br><br></td>
                <td><br><br></td>
            </tr>
        </table>
    </div>
</body>
</html>