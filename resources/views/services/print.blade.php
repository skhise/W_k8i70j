<html>

<head>
    <style>
        @media print {
            @page {
                margin: 1em;
            }
        }

        p {
            margin: 0px;
        }

        td {
            padding: 3px !important;
            font-size: 12px;
        }

        table {
            margin-bottom: 0px !important;
        }
        table{
            width:100%;
        }
        table th {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body style="margin:15px;">

    <!-- title row -->

    <!-- info row -->



    <div class="row invoice-info">

        <!-- call details start-->

        <table class="table table-bordered" style="width:100%;">

            <tbody>
                <tr class="center" style="text-align:center;">

                    <td colspan="2" style="font-size: 18px;"><b>Field Service Report</b></td>

                </tr>

                <tr>

                    <td style="width: 50%;">

                        <img src="../../img/user.png" alt="Logo" width="100" height="100"
                            style="float:left;margin:10px;">

                        <address style="margin:30px;">

                            <b>{{ $service->CST_Name }} </b> <br>

                            {{ $service->CST_OfficeAddress }} <br>



                        </address>

                    </td>

                    <td style="width: 50%;float:right;">

                        <p>Ticket No.:&nbsp;<b>{{ $service->service_no }}</b></p>
                        <p>Date:&nbsp;{{ $service->created_at }}</p>
                        <p>Service Type:&nbsp;{{ $service->type_name }}</p>
                        <p>Issue Type:&nbsp;{{ $service->issue_name }}</p>
                        <p>Contract
                            Type:&nbsp;{{ $service->contract_id == 0 ? 'Non-Contracted' : $contract->contract_type_name }}
                        </p>
                        <p>Contract No.:&nbsp;{{ $contract->CNRT_Number ?? 'NA' }}</p>




                    </td>

                </tr>

                <tr>

                    <td style="width: 50%;">
                        <p style="font-weight: 600;">csi india pvt ltd2</p>
                        <p>Contact Person: {{ $service->contact_person }}</p>
                        <p>Phone: {{ $service->contact_number1 }}</p>
                        <p>{{ $service->site_address }}</p>

                    </td>
                    <td style="width: 50%; float:right;">
                        <p>Ticket Staus:&nbsp;<b>{{ $service->Status_Name }}</b></p>
                        <p>Date/Time:&nbsp;{{ $service->updated_at }}</p>
                        <p>Assigned:&nbsp;{{ $service->EMP_Name }}</p>
                    </td>

                </tr>

            </tbody>
        </table>

        <!-- call details end-->

        <!-- product details start-->
        <table>
            <tr>
                <td>DC Product Information</td>
            </tr>
        </table>
        <table class="table table-striped bordered" id="tbRefClient" style="border:1 solid black;">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Service. No.</th>
                                <th>Client Name</th>
                                <th>Issue Date</th>
                                <th>Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($dc_products->count() == 0)
                                <tr>
                                    <td colspan="5" class="text-center" style="text-align:center;">No
                                        products
                                        added yet.</td>
                                </tr>
                            @endif
                            @foreach ($dc_products as $index => $dcp)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $dcp['service_no'] }}</td>
                                    <td>{{ $dcp['CST_Name'] }}</td>
                                    <td>{{ date('d-M-Y', strtotime($dcp['issue_date'])) }}</td>
                                    <td>{{ $dcp['dc_type_name'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

        <br>



        <!-- product details end-->

        <!-- Issue start -->

        <table class="table table-bordered">

            <tbody>
                <tr>

                    <td><b>Description of Issue:</b></td>

                </tr>

                <tr>

                    <td>
                        {{$service->service_note}}

                    </td>

                </tr>

            </tbody>
        </table>
        <br>
        <!-- Issue end-->

        <!--  solution start -->

        <table class="table table-bordered">

            <tbody>
                <tr>

                    <td><b>Resolution</b></td>

                </tr>

                <tr>

                    <td>

                        <br>
                    </td>

                </tr>



            </tbody>
        </table>

        <!-- solution end-->

        <!--  Customer Remark start -->
        <br>
        <table class="table table-bordered">

            <tbody>
                <tr>

                    <td><b>Customer Remark</b></td>

                </tr>

                <tr>

                    <td>

                        <br>
                        <br>
                    </td>

                </tr>



            </tbody>
        </table>

        <!-- Customer Remark end-->

        <!-- product details start-->
      
        <br>
        <!-- product details end-->

        <!--Note start-->





        <!--Note end-->

        <!--Declaration start-->

        <table class="table table-bordered">

            <tbody>
                <tr>

                    <td colspan="2"><b>Declaration</b></td>

                </tr>

                <tr>

                    <td><br>

                        Customer's Seal and Signature<br>

                        Customer Name &amp; Mobile No.<br><br>
                            {{$service->CST_Name}} & {{$service->CCP_Mobile}}<br>
                    </td>

                    <td style="float:right;margin-right:25px;">

                        Authorized Signatory

                    </td>

                </tr>

            </tbody>
        </table>

        <!--Declaration end-->



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
