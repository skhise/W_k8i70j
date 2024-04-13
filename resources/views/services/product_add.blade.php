<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Add DC Product</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <form id="myForm" onsubmit="return false;">

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <label>Issue Date<span class="error">*</span></label>
                                                        <input id="standby_date" value="{{ date('Y-m-d') }}"
                                                            type="date" name="standby_date"
                                                            class="required form-control">
                                                    </div>
                                                    @if (empty($service->id))
                                                        <div class="col-lg-3">
                                                            <label>Customer Name<span class="error">*</span></label>
                                                            <select id="standby_customer" name="standby_customer"
                                                                class="required form-control"
                                                                onchange="getCustomerCall()">
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <label>Call Ref.No.<span
                                                                    class="error">*</span>&nbsp;&nbsp;&nbsp;<a
                                                                    href="add_AddService.php">Add New</a></label>
                                                            <select class="required form-control " id="call_ref_no"
                                                                name="call_ref_no" id="call_ref_no">
                                                            </select>
                                                        </div>
                                                    @endif
                                                    <div class="col-lg-3">
                                                        <label>Type<span class="error">*</span></label>
                                                        <select id="standbyType" name="standbyType"
                                                            class="required form-control">
                                                            <option value="">Select Type</option>
                                                            @foreach ($dctype as $dc)
                                                                <option value="{{ $dc->id }}">
                                                                    {{ $dc->dc_type_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label>Remark<span class="error">*</span></label>
                                                        <textarea id="dc_remark" name="dc_remark" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-2">
                                                        <label>Product Type</label>
                                                        <select id="product_type" name="product_type"
                                                            class="required form-control">
                                                            <option value="">Select Type</option>
                                                            @foreach ($productType as $ptype)
                                                                <option value="{{ $ptype->id }}"
                                                                    data-product="{{ $ptype->products }}">
                                                                    {{ $ptype->type_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>Product</label>
                                                        <select id="standby_product" name="standby_product"
                                                            class="required form-control">
                                                            <option value="">Select Product</option>
                                                        </select>
                                                        <span class="alert text-center square hide"
                                                            id="error_bill_product">Select product</span>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>Select Serial No.</label>
                                                        <select id="productSerialNo" name="productSerialNo"
                                                            class="form-control">
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>Amount</label>
                                                        <input type="number" id="product_amount" name="product_amount"
                                                            value="0" class="required form-control numberInput"
                                                            autocomplete="off">
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label>Note</label>
                                                        <textarea id="other_details" name="other_details" value="" class="form-control"></textarea>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <label>&nbsp;</label><br>
                                                        <button type="submit" id="product_add"
                                                            class="btn btn-sm btn-primary">Add</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <table id="myTable" class="table table-striped">
                                            <thead>
                                                <tr class="mb-2">
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <div class="action-btn">Total DC Cost:<span
                                                                    id="dc_total_cost" style="font-weight:700">0</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <button id="btn_save_data"
                                                                class="action-btn btn btn-primary">Save</button>
                                                            <button id="btn_clear_data"
                                                                class="action-btn btn btn-danger">Reset</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Type</th>
                                                    <th>Product Type</th>
                                                    <th>Product</th>
                                                    <th>Serial Number</th>
                                                    <th>Amount</th>
                                                    <th>Details</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <!-- Table rows will be appended here -->
                                            </tbody>
                                        </table>
                                    </div>
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
            $('#btn_save_data').click(function() {
                var rowData = [];
                var issue_date = $("#standby_date").val();
                var dc_remark = $("#dc_remark").val();
                var dc_type = $("#standbyType option:selected").val();
                // Iterate over each row in the table body
                $('#myTable tbody tr').each(function() {
                    var rowObj = {};
                    // Iterate over each column (td) in the current row
                    $(this).find('td').each(function() {
                        var columnName = $(this).data('key');
                        var columnValue = $(this).data('value');
                        rowObj[columnName] = columnValue;
                    });

                    rowData.push(rowObj);
                });


                // Send data to PHP script using AJAX
                $.ajax({
                    url: "{{ route('services.store_product', $service->id) }}",
                    method: 'POST',
                    data: {
                        issue_date: issue_date,
                        dc_type: dc_type,
                        dc_remark: dc_remark,
                        data: rowData,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        if (response.status) {
                            alert("Saved");
                            window.location.href = "{{ route('services.view', $service->id) }}";
                        } else {
                            alert("Something went wrong, try again.");
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("Something went wrong, try again.");
                    }
                });
            });
            $(document).on('click', '.deleteRow', function() {
                var row = $(this).closest('tr');
                var amount = row.find('td:eq(5)').text();
                var dctotal = $("#dc_total_cost").text();
                var newval = parseInt(dctotal) - parseInt(amount);
                $("#dc_total_cost").text(newval);
                $(this).closest('tr').remove();
            });
            $(document).on("change", "#product_type", function() {
                var selectedOption = $(this).find('option:selected');
                var products = selectedOption.data('product');
                $('#standby_product').empty();
                $('#standby_product').append($('<option>', {
                    value: '',
                    text: "Select Product"
                }));
                $.each(products, function(index, option) {
                    var option = $('<option>', {
                        value: option.Product_ID,
                        text: option.Product_Name
                    }).data("serialnumbers", option.serial_numbers);
                    $('#standby_product').append(option);
                });
            });
            $(document).on("change", "#standby_product", function() {
                var selectedOption = $(this).find('option:selected');
                var products = selectedOption.data('serialnumbers');
                $('#productSerialNo').empty();
                $('#productSerialNo').append($('<option>', {
                    value: '',
                    text: "Select Serial No."
                }));
                $.each(products, function(index, option) {
                    var option = $('<option>', {
                        value: option.id,
                        text: option.sr_number
                    });
                    $('#productSerialNo').append(option);
                });
            });
            document.addEventListener("DOMContentLoaded", function() {
                var form = document.getElementById("myForm");
                var tableBody = document.querySelector("#myTable tbody");

                form.addEventListener("submit", function(event) {
                    event.preventDefault(); // Prevent form submission

                    var standby_date = $("#standby_date").val();
                    // var standby_customer = $("#standby_customer").val();
                    var standbyType = $("#standbyType option:selected").val();
                    var standbyType_text = $("#standbyType option:selected").text();
                    var product_type = $("#product_type option:selected").val();
                    var product_type_text = $("#product_type option:selected").text();
                    var standby_product = $("#standby_product option:selected").val();
                    var standby_product_text = $("#standby_product option:selected").text();
                    var productSerialNo = $("#productSerialNo option:selected").val();
                    var productSerialNo_text = $("#productSerialNo option:selected").text();
                    var product_amount = $("#product_amount").val();
                    var other_details = $("#other_details").val();
                    var isValid = true;

                    // Loop through each input field and validate
                    $('#myForm .required').each(function() {
                        if (!validateInput($(this))) {
                            isValid = false;
                        }
                    }).val();

                    // Create a new row
                    if (isValid) {
                        var newRow = document.createElement("tr");
                        newRow.innerHTML = `
                <td data-key="issue_date" data-value="${standby_date}">${standby_date}</td>
                <td data-key="type"  data-value="${standbyType}">${standbyType_text}</td>
                <td data-key="product_type" data-value="${product_type}">${product_type_text}</td>
                <td data-key="product_id" data-value="${standby_product}">${standby_product_text}</td>
                <td data-key="serial_no" data-value="${productSerialNo}">${productSerialNo_text}</td>
                <td data-key="amount" data-value="${product_amount}">${product_amount}</td>
                <td data-key="description" data-value="${other_details}">${other_details}</td>
                <td><button class='btn btn-danger btn-sm deleteRow'><i class='fa fa-trash'></i></button></td>
            `;
                        tableBody.appendChild(newRow);
                        var dctotal = $("#dc_total_cost").text();
                        var newval = parseInt(dctotal) + parseInt(product_amount);
                        $("#dc_total_cost").text(newval);

                        $("#standby_product").empty();
                        $("#productSerialNo").empty();
                        $("#product_type").val("");
                        $("#product_amount").val(0);
                        $("#other_details").val("");
                        // $('#myForm')[0].reset();
                    }
                });

                function validateInput(input) {
                    var value = input.val();
                    var isValid = true;
                    if (value === '') {
                        input.addClass('error_border');
                        isValid = false;
                    } else {
                        input.removeClass('error_border');
                    }
                    return isValid;
                }
            });
        </script>
    @stop
</x-app-layout>
