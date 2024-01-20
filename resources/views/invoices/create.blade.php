<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{$update ? 'Update Invoice' : 'Create Invoice'}}</h4>
                            </div>
                            <div class="card-body">
                                @if($errors->any())
                                {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                                @endif
                                @if($update)
                                <form id="project_invoice" method="post"
                                    action="{{route('invoices.update',$invoice->id)}}?flag={{$flag}}"
                                    name="project_invoice">
                                    @else
                                    <form id="project_invoice" onsubmit="return false;" name="project_invoice">
                                        @endif
                                        <div class="form-group">
                                            @csrf
                                            @if($update)
                                            <input type="hidden" id="invoice_id" value="{{$invoice->id}}"
                                                name="invoice_id" />
                                            @endif
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <label for="invoice_date">Invoice Date </label>
                                                    <input type="date" value="{{$invoice_date}}" class="form-control"
                                                        id="invoice_date" name="invoice_date" required>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label for="invoice_number">RECHNUNG NR. (Invoice Number)</label>
                                                    <input type="text" value="{{$invoice_number}}"
                                                        class="disabled form-control" id="invoice_number"
                                                        name="invoice_number" required {{$update ? 'disabled' :''}}>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label for="project_id">Select Project</label>
                                                    <select class="form-control select2" id="project_id"
                                                        name="project_id" {{$update ? 'disabled' :''}}
                                                        {{$invoice_project->id >0 ? 'disabled' : ''}}>
                                                        <option value="">Select Project</option>
                                                        @foreach($projects as $project)
                                                        <option value="{{$project->id}}" {{ $update ? $project->
                                                            id==$invoice->project_id ?
                                                            'selected':'':''}} {{$invoice_project->id == $project->
                                                            id ? 'selected' : ''}}>{{$project->number}} /
                                                            {{$project->name}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @if(!empty($invoice_project) &&
                                                    !empty($invoice_project['project_name']))
                                                    <input type="hidden" name="project_id" class="project_id"
                                                        value="{{$invoice_project->id}}" />
                                                    @endif
                                                    <input type="hidden" name="invoice_type"
                                                        value="{{$invoice_project->category_id}}" id="invoice_type" />
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <label for="project_number">Project Number</label>
                                                    <p><span id="project_number">{{$invoice_project->number ??
                                                            ''}}</span></p>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label for="project_details">Project Name & Address</label>
                                                    <p> <span id="project_details">{{$invoice_project->number ?? ''}}
                                                            {{$invoice_project->full_address ?? ''}}</span></p>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label for="client_name">Client Name & Address</label>
                                                    <p><span id="client_name">{{$client->client_name ?? ''}}
                                                            {{$client->client_full_address ?? ''}}</span></p>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <label for="">Auftragsdatum (Order Date)</label>
                                                    <input type="text" class="form-control"
                                                        value="{{$invoice->invoice_order_date}}" id="invoice_order_date"
                                                        name="invoice_order_date" required>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label for="project_status">Status</label>
                                                    <input type="text" class="form-control"
                                                        value="{{$invoice->project_status}}" id="project_status"
                                                        name="project_status" required>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label for="onsite_appointments_on">Ortstermine am (On-site
                                                        appointments
                                                        on)</label>
                                                    <input type="text" class="form-control"
                                                        value="{{$invoice->onsite_appointments_on}}"
                                                        id="onsite_appointments_on" name="onsite_appointments_on"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <label for="processing_period">Bearbeitungszeitraum bis(Processing
                                                        Period)</label>
                                                    <input type="text" class="form-control"
                                                        value="{{$invoice->processing_period}}" id="processing_period"
                                                        name="processing_period" required>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label for="processing_period">Due In</label>
                                                    <select class="select2 form-control" name="due_in" id="due_in">
                                                        <option>Due In</option>
                                                        <option value="">None</option>
                                                        @foreach($payment_duein as $duein)
                                                        <option value="{{$duein['due_in']}}" {{$invoice->
                                                            due_in == $duein['due_in'] ? 'selected':'' }}
                                                            >{{$duein['due_in']}} days
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label for="processing_period">Payment Status</label>
                                                    <select class="select2 form-control" name="payment_status"
                                                        id="payment_status">
                                                        <option>Status</option>
                                                        @foreach($payment_status as $paymentstatus)
                                                        <option value="{{$paymentstatus['id']}}" {{$invoice->
                                                            payment_status == $paymentstatus['id'] ? 'selected':'' }}
                                                            {{$invoice->
                                                            payment_status == $paymentstatus['id'] ? 'selected':'' }}>
                                                            {{$paymentstatus['payment_status']}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <label for="">Payment Note</label>
                                                    <textarea row="2" name="payment_note" id="payment_note"
                                                        class="form-control">{{$invoice->payment_note}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>

                                        <div>
                                            <h5>Invoice Items</h5>
                                            <div class="form-row mb-2">
                                                <table class="table" id="invoiceItems">
                                                    @if($update && !empty($invoice_items))
                                                    @foreach(json_decode($invoice->invoice_items) as $index_key
                                                    =>$item)
                                                    <tr class="form-row1">
                                                        <td>
                                                            <div class="col mb-2">
                                                                <select class="form-control invoice_items_description"
                                                                    id="invoice_items_{{$index_key}}_description"
                                                                    name="invoice_items[{{$index_key}}][description]"
                                                                    placeholder="Item Description" required>

                                                                    @foreach($invoice_items as $index =>
                                                                    $invoice_item)

                                                                    <option value="{{$invoice_item['id']}}" {{$item->
                                                                        description ==
                                                                        $invoice_item['description'] ?
                                                                        'selected':''}}>{{trim($invoice_item['description'])}}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col">
                                                                <input type="number"
                                                                    name="invoice_items[{{$index_key}}][cost]"
                                                                    value="{{$item->cost}}"
                                                                    class="project_cost form-control" placeholder="Cost"
                                                                    required>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col">
                                                                <button type="button" class="btn-sm btn btn-danger m-1"
                                                                    onclick="removeItem(this)">X</button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    @else
                                                    <tr class="form-row1">
                                                        <td>
                                                            <div class="col mb-2">
                                                                <select class="form-control invoice_items_description"
                                                                    id="invoice_items_0_description"
                                                                    name="invoice_items[0][description]"
                                                                    placeholder="Item Description" required>

                                                                    @foreach($invoice_items as $index =>
                                                                    $invoice_item)

                                                                    <option value="{{$invoice_item['id']}}">
                                                                        {{trim($invoice_item['description'])}}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col">
                                                                <input type="number" name="invoice_items[0][cost]"
                                                                    class="project_cost form-control" placeholder="Cost"
                                                                    required>
                                                            </div>
                                                        </td>
                                                        <td>

                                                        </td>
                                                    </tr>
                                                    @endif

                                                </table>




                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-success" onclick="addItem()">Add
                                            Item</button>

                                        <hr>
                                        <table class="table" style="broder:0px;">
                                            <tr>
                                                <td>zwischensumme (Subtotal)</td>
                                                <td></td>
                                                <td><input id="sub_total" name="sub_total" type="hidden"
                                                        style="display:none;" class="invoice_subtotal_value"
                                                        value="{{$invoice->sub_total}}" /><span
                                                        class="invoice_subtotal">{{$invoice->sub_total}}</span>
                                                    &euro;
                                                </td>
                                            <tr>
                                                <td>Mehrwertsteuer (VAT)</td>
                                                <td>zuzugl. 19%</td>
                                                <td><input id="taxes" name="taxes" type="hidden" style="display:none;"
                                                        class="invoice_vat_value" value="{{$invoice->taxes}}" /> <span
                                                        id="invoice_vat" class="invoice_vat"
                                                        name="invoice_vat">{{$invoice->taxes}}</span>
                                                    &euro;</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Reechnungssumme (Invoice total)</strong></td>
                                                <td></td>
                                                <td><strong><input id="total_amount" name="total_amount" type="hidden"
                                                            style="display:none;" class="invoice_total_value"
                                                            value="{{$invoice->total_amount}}" /><span
                                                            class="invoice_total">{{$invoice->total_amount}}</span>
                                                        &euro;</strong>
                                                </td>
                                            </tr>
                                        </table>
                                        <hr />
                                        <p> Bitte überweisen Sie den Rechnungsbetrag von <span
                                                class="invoice_total">{{$invoice->total_amount}}</span>
                                            €
                                            ohne Abzug bis zum <input type="text" name="value_position"
                                                id="value_position" value="{{$invoice->value_position}}" />
                                            (Wertstellung) auf eines unserer Konten unter Angabe der Rechnung
                                            Nr. {{$invoice_number}} . Bei
                                            Missachtung der Zahlungsfrist tritt automatisch ein Verzug ein.</p>
                                        <p></p>
                                        <div class="form-group">
                                            <label for="invoice_note">Note</label>
                                            <textarea id="invoice_note" name="invoice_note" class="form-control">
                                            {{$update ? trim($invoice->invoice_note) :'Diese Rechnung und die dazugehörigen Zahlungsbelege sind gem. § 14b Abs. 1 Satz 5 UStG zwei Jahre lang aufzubewahren, sofern Sie diese Leistung als Privatperson beziehen.'}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <div class="card-footer text-right">
                                                @if($update)
                                                <button type='submit' class='update-invoice btn btn-primary'>
                                                    Update Invoice</button>
                                                @else
                                                <button type='button' class='save-invoice btn btn-primary'>Save
                                                    Invoice</button>
                                                @endif
                                                <a href="{{route('invoices')}}" type="button"
                                                    class="btn btn-danger">Cancel</a>

                                            </div>
                                        </div>
                                    </form>
                            </div>

                        </div>
                    </div>

                </div>
        </section>
    </div>
    @section('script')
    <script>
        $(".invoice_items_description").editableSelect({
            effects: 'slide',
        });
        $(document).on('select', '.es-input', function () {
            $(this).val($.trim($(this).val()));
        })

        $(document).on("click", ".save-invoice", function () {

            var data = $("#project_invoice").serialize();
            var flag = "{{$flag}}";
            var route = "{{route('projects.view',$invoice_project->id ?? 0)}}";
            $.ajax({
                url: "store",
                type: "POST",
                data: data,
                success: function (responce) {
                    if (responce.success) {
                        if (flag == 1) {
                            window.location.replace(route);
                        } else {
                            window.location.replace('/invoices');
                        }

                    } else {
                        alert(responce.message);
                    }
                },
                error: function (error) {
                    alert("Something went wrong, try again");
                }
            });
        });
        $(document).on("change", ".project_cost", function () {
            var sum = 0;
            $(".project_cost").each(function () {
                sum += +$(this).val();
            });
            var final_sum = parseFloat(sum).toFixed(2);
            $(".invoice_subtotal").text(final_sum);
            $(".invoice_subtotal_value").val(final_sum);
            var vat = parseFloat((final_sum / 100) * 19).toFixed(2);
            $(".invoice_vat").text(vat);
            $(".invoice_vat_value").val(vat);
            var invoice_total = parseFloat(final_sum) + parseFloat(vat);
            $(".invoice_total").text(invoice_total.toFixed(2));
            $(".invoice_total_value").val(invoice_total.toFixed(2));
        });
        $(document).on("change", "#project_id", function () {

            var id = $(this).val();
            $(".project_id").val(id);
            if (id != "") {
                $.ajax({
                    url: "get_p_info",
                    type: "get",
                    data: {
                        id: id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function (responce) {
                        var data = responce.data;
                        $("#project_number").text(data.number);
                        $("#project_details").text(data.name + "    " + data.full_address);
                        $("#client_name").text(data.client_name);
                        $("#invoice_type").val(data.category_id);
                    },
                    error: function (error) {
                        alert("Something went wrong, try again");
                    }
                });
            } else {
                $("#project_number").text("");
                $("#project_details").text("");
                $("#client_name").text("");
                $("#invoice_type").var("");
            }


        })
        function addItem() {
            const invoiceItems = document.getElementById('invoiceItems');
            var tbodyRowCount = invoiceItems.tBodies[0].rows.length;
            var newItem = `
            <tr class="form-row1">
                                                <td>
                                                    <div class="col mb-1">
                                                    <select class="form-control invoice_items_description"
                                                    id="invoice_items_${tbodyRowCount}_description"
                                                                name="invoice_items[${tbodyRowCount}][description]"
                                                                placeholder="Item Description" required>
                                                                @foreach($invoice_items as $index => $invoice_item)
                                                                <option value="{{trim($invoice_item['id'])}}">
                                                                    {{trim($invoice_item['description'])}}</option>
                                                                @endforeach
                                                            </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="col">
                                                        <input type="number" name="invoice_items[${tbodyRowCount}][cost]" class="project_cost form-control"
                                                            placeholder="Cost" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="col">
                                                        <button type="button" class="btn-sm btn btn-danger m-1"
                                                            onclick="removeItem(this)">X</button>
                                 </div>
                                                </td>
                                            </tr>
    `;
            $("#invoiceItems tbody").append(newItem);
            $(`#invoice_items_${tbodyRowCount}_description`).editableSelect({
                effects: 'slide',
            });
        }
        function removeItem(button) {
            const rowToRemove = button.closest('.form-row1');
            rowToRemove.remove();
            $(".project_cost").trigger("change");
        }
    </script>
    @stop
</x-app-layout>