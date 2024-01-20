<?php
$status = [
    "1"=>'<div class="badge badge-success badge-shadow">Paid (Bezahlt)</div>',
    "2"=>'<div class="badge badge-danger badge-shadow">UnPaid (Offen)</div>',
    "3"=>'<div class="badge badge-info badge-shadow">Partially Paid</div>',
];
$overdue_status = [
    "1"=>'<div class="badge badge-danger badge-shadow">Overdue</div>',
];
?>
<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Invoice Report</h4>
                            </div>
                            <div class="card-body">

                                <div class="float-right">
                                    <form action="{{route('invoices')}}" id="search_form">
                                        <input type="hidden" name="search_field" value="{{$search_field}}"
                                            id="search_field" />
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="{{$search}}" id="search"
                                                name="search" placeholder="Search">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" data-toggle="dropdown"
                                                    class="btn btn-danger dropdown-toggle"><i
                                                        class="fas fa-filter"></i></button>
                                                <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                                    <li class="dropdown-title">Search By</li>
                                                    <li><a href="#" data-field=""
                                                            class="dropdown-item {{$search_field == '' ? 'active':''}}">All</a>
                                                    </li>
                                                    <li><a href="#" data-field="invoice_number"
                                                            class="dropdown-item {{$search_field=='invoice_number' ? 'active' :''}}">Invoice
                                                            Number</a>
                                                    </li>
                                                    <li><a href="#" data-field="project_name"
                                                            class="dropdown-item {{$search_field=='project_name' ? 'active' :''}}">Project
                                                            Name</a>
                                                    </li>
                                                    <li><a href="#" data-field="client_name"
                                                            class="dropdown-item {{$search_field=='client_name' ? 'active' :''}}">Client
                                                            Name</a>
                                                    </li>
                                                    <li><a href="#" data-field="clear" class="dropdown-item">Clear
                                                            Filter</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="clearfix mb-3"></div>
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Invoice Number
                                                </th>
                                                <th>Invoice Date</th>
                                                <th>Project Name</th>
                                                <th>Client Name</th>
                                                <th>Amount</th>
                                                <th>Due In</th>
                                                <th>Due Date</th>
                                                <th>Status</th>
                                                <th class="action-1">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($invoices) == 0)
                                            <tr>
                                                <td colspan="9" class="text-center">No invoices to show</td>
                                            </tr>
                                            @endif
                                            @foreach($invoices as $key=>$invoice_item)
                                            <tr>
                                                <td>
                                                    {{$invoice_item['invoice_number']}}
                                                </td>
                                                <td>
                                                    {{$invoice_item['invoice_date']}}
                                                </td>

                                                <td>{{$invoice_item['projectname']}}</td>
                                                <td>
                                                    {{$invoice_item['client_name']}}
                                                </td>
                                                <td>{{$invoice_item['total_amount']}} $</td>

                                                <td>{{$invoice_item['due_in'] == "" ? 'None': $invoice_item['due_in']."
                                                    days"}}</td>
                                                <td>
                                                    {{$invoice_item['due_date']}}
                                                </td>
                                                <td>{!!$invoice_item['payment_status']!=null ?
                                                    $status[$invoice_item['payment_status']] : '' !!}</td>
                                                <td>
                                                    <a href="{{route('invoices.view',$invoice_item['invoice_id'])}}"
                                                        class="btn btn-icon btn-sm btn-primary"><i
                                                            class="fas fa-download"></i></a>
                                                    <a href="{{route('invoices.edit',$invoice_item['invoice_id'])}}"
                                                        class="btn btn-icon btn-sm btn-primary"><i
                                                            class="far fa-edit"></i></a>

                                            </tr>
                                            @endforeach


                                        </tbody>
                                    </table>
                                    <div class="float-right">
                                        {{ $invoices->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>

    @section('script')

    <script>
        $(document).on('change', '#search', function () {
            $("#search_form")[0].submit();
        })
        $(document).on('click', ".dropdown-item", function () {
            $(".dropdown-item").removeClass("active");
            var text = $(this).text();
            if (text == "All") {
                $("#search_field").val("");
                // $("#search").val("");
                $("#search").attr("placeholder", "Search");
            } else if ($(this).data("field") == "clear") {
                $("#search_field").val("");
                $("#search").val("");
                $("#search").attr("placeholder", "Search");
            } else {
                $("#search_field").val($(this).data("field"));
                $("#search").attr("placeholder", "Search by " + text);
            }
            $(this).addClass('active');
            if ($("#search").val() != "") {
                $("#search_form")[0].submit();
            }
        });
    </script>

    @stop
</x-app-layout>