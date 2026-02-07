<x-app-layout>
    <div class="main-content">
        <style>
            /* Uniform height for Add Product Line row - overrides Bootstrap/Select2 */
            .add-product-line-row input.form-control,
            .add-product-line-row select.form-control,
            .add-product-line-row .form-control {
                height: 34px !important;
                min-height: 34px !important;
                max-height: 34px !important;
                line-height: 1.2 !important;
                padding: 0.35rem 0.5rem !important;
                box-sizing: border-box !important;
            }
            .add-product-line-row .select2-container--default .select2-selection--single,
            .add-product-line-row .select2-container .select2-selection--single {
                height: 34px !important;
                min-height: 34px !important;
                padding: 0 !important;
                border-radius: 0.2rem !important;
            }
            .add-product-line-row .select2-container--default .select2-selection--single .select2-selection__rendered,
            .add-product-line-row .select2-container .select2-selection--single .select2-selection__rendered {
                line-height: 32px !important;
                padding-left: 0.5rem !important;
            }
            .add-product-line-row .select2-container--default .select2-selection--single .select2-selection__arrow,
            .add-product-line-row .select2-container .select2-selection--single .select2-selection__arrow {
                height: 32px !important;
            }
            .add-product-line-row #product_add.btn {
                height: 34px !important;
                min-height: 34px !important;
                padding: 0.35rem 0.75rem !important;
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                line-height: 1 !important;
            }
        </style>
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Add DC Product</h4>
                                <a href="{{ route('services.view', $service->id) }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-arrow-left"></i> Back to Service
                                </a>
                            </div>
                            <div class="card-body">
                                <form id="myForm" onsubmit="return false;">
                                    {{-- DC details --}}
                                    <div class="mb-4 p-3 rounded" style="background-color: #f8f9fa;">
                                        <h6 class="text-muted mb-3">DC Details</h6>
                                        <div class="row">
                                            <div class="col-md-3 col-lg-2 form-group">
                                                <label class="mb-1">Issue Date <span class="text-danger">*</span></label>
                                                <input id="standby_date" type="date" name="standby_date" value="{{ date('Y-m-d') }}" class="required form-control">
                                            </div>
                                            @if (empty($service->id))
                                                <div class="col-md-3 col-lg-2 form-group">
                                                    <label class="mb-1">Customer <span class="text-danger">*</span></label>
                                                    <select id="standby_customer" name="standby_customer" class="required form-control" onchange="getCustomerCall()"></select>
                                                </div>
                                                <div class="col-md-3 col-lg-2 form-group">
                                                    <label class="mb-1">Call Ref.No. <span class="text-danger">*</span></label>
                                                    <select id="call_ref_no" name="call_ref_no" class="required form-control"></select>
                                                </div>
                                            @endif
                                            <div class="col-md-3 col-lg-2 form-group">
                                                <label class="mb-1">DC Type <span class="text-danger">*</span></label>
                                                <select id="standbyType" name="standbyType" class="required form-control">
                                                    <option value="">Select Type</option>
                                                    @foreach ($dctype as $dc)
                                                        <option value="{{ $dc->id }}">{{ $dc->dc_type_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 col-lg-4 form-group">
                                                <label class="mb-1">Remark</label>
                                                <textarea id="dc_remark" name="dc_remark" class="form-control" rows="1" placeholder="Optional"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Add product line --}}
                                    <div class="mb-4 p-3 rounded border">
                                        <h6 class="text-muted mb-3">Add Product Line</h6>
                                        <div class="row align-items-end add-product-line-row">
                                            <div class="col-md-6 col-lg-2 form-group mb-2 mb-lg-0">
                                                <label class="mb-1 small">Product Type</label>
                                                <select id="product_type" name="product_type" class="required form-control form-control-sm">
                                                    <option value="">Select Type</option>
                                                    @foreach ($productType as $ptype)
                                                        <option value="{{ $ptype->id }}" data-product="{{ $ptype->products }}">{{ $ptype->type_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 col-lg-2 form-group mb-2 mb-lg-0">
                                                <label class="mb-1 small">Product</label>
                                                <select id="standby_product" name="standby_product" class="required form-control form-control-sm">
                                                    <option value="">Select Product</option>
                                                </select>
                                                <span class="text-danger small hide" id="error_bill_product">Select product</span>
                                            </div>
                                            <div class="col-md-4 col-lg-2 form-group mb-2 mb-lg-0">
                                                <label class="mb-1 small">Serial No.</label>
                                                <select id="productSerialNo" name="productSerialNo" class="form-control form-control-sm">
                                                    <option value="">—</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 col-lg-1 form-group mb-2 mb-lg-0">
                                                <label class="mb-1 small">Qty</label>
                                                <input type="number" id="product_quantity" name="product_quantity" value="1" min="1" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-md-4 col-lg-1 form-group mb-2 mb-lg-0">
                                                <label class="mb-1 small">Amount</label>
                                                <input type="number" id="product_amount" name="product_amount" value="0" class="required form-control form-control-sm" step="0.01" min="0">
                                            </div>
                                            <div class="col-md-8 col-lg-2 form-group mb-2 mb-lg-0">
                                                <label class="mb-1 small">Note</label>
                                                <input type="text" id="other_details" name="other_details" class="form-control form-control-sm" placeholder="Optional">
                                            </div>
                                            <div class="col-md-4 col-lg-1 form-group mb-2 mb-lg-0">
                                                <button type="submit" id="product_add" class="btn btn-primary btn-sm w-100">
                                                    <i class="fas fa-plus"></i> Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                {{-- Table toolbar (footer at top) --}}
                                <div id="tableToolbar" class="d-flex flex-wrap align-items-center justify-content-between mb-2 py-2 px-3 rounded border bg-light">
                                    <div class="d-flex align-items-center">
                                        <span class="text-muted mr-2">Total DC Cost:</span>
                                        <span id="dc_total_cost" class="h5 mb-0 font-weight-bold text-dark">0</span>
                                    </div>
                                    <div class="mt-2 mt-md-0 d-flex align-items-center">
                                        <button type="button" id="btn_save_data" class="btn btn-primary btn-sm px-3" disabled title="Save delivery challan">
                                            <i class="fas fa-save mr-1"></i> Save DC
                                        </button>
                                        <button type="button" id="btn_clear_data" class="btn btn-sm px-3 ml-2" title="Clear all lines" style="background-color: #fff; border: 1px solid #ddd; color: #555;">
                                            <i class="fas fa-eraser mr-1"></i> Reset
                                        </button>
                                    </div>
                                </div>

                                {{-- Product lines table --}}
                                <div class="table-responsive">
                                    <table id="myTable" class="table table-bordered table-hover table-sm">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Date</th>
                                                <th>Type</th>
                                                <th>Product Type</th>
                                                <th>Product</th>
                                                <th>Serial No.</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-right">Amount</th>
                                                <th>Details</th>
                                                <th width="60" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr id="tableEmptyRow" class="text-center text-muted">
                                                <td colspan="9" class="py-4">No product lines added yet. Use the form above to add products.</td>
                                            </tr>
                                        </tbody>
                                    </table>
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
        function updateTableUI() {
            var rowCount = $('#myTable tbody tr').not('#tableEmptyRow').length;
            $('#tableEmptyRow').toggle(rowCount === 0);
            $('#btn_save_data').prop('disabled', rowCount === 0);
        }

        $('#btn_save_data').click(function() {
            if ($(this).prop('disabled')) return;
            var rowData = [];
            var issue_date = $("#standby_date").val();
            var dc_remark = $("#dc_remark").val();
            var dc_type = $("#standbyType option:selected").val();
            $('#myTable tbody tr').not('#tableEmptyRow').each(function() {
                var rowObj = {};
                $(this).find('td').each(function() {
                    var columnName = $(this).data('key');
                    var columnValue = $(this).data('value');
                    if (columnName) rowObj[columnName] = columnValue;
                });
                rowData.push(rowObj);
            });

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
                        Swal.fire({
                            title: 'Success!',
                            text: 'DC saved successfully.',
                            icon: 'success',
                            confirmButtonColor: '#3085d6'
                        }).then(function() {
                            window.location.href = "{{ route('services.view', $service->id) }}";
                        });
                    } else {
                        showErrorSwal(response.message || "Something went wrong, try again.");
                    }
                },
                error: function(xhr) {
                    var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : "Something went wrong, try again.";
                    showErrorSwal(msg);
                }
            });
        });

        $('#btn_clear_data').click(function() {
            var dataRows = $('#myTable tbody tr').not('#tableEmptyRow');
            if (!dataRows.length) return;
            Swal.fire({
                title: 'Are you sure?',
                text: 'Clear all product lines?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33'
            }).then(function(result) {
                if (result.isConfirmed) {
                    dataRows.remove();
                    $("#dc_total_cost").text('0');
                    updateTableUI();
                }
            });
        });

        $(document).on('click', '.deleteRow', function() {
            var row = $(this).closest('tr');
            var amount = parseInt(row.find('td:eq(6)').text(), 10) || 0;
            var dctotal = parseInt($("#dc_total_cost").text(), 10) || 0;
            $("#dc_total_cost").text(dctotal - amount);
            row.remove();
            updateTableUI();
        });

        $(document).on("change", "#product_type", function() {
            var selectedOption = $(this).find('option:selected');
            var products = selectedOption.data('product') || [];
            $('#standby_product').empty().append($('<option>', { value: '', text: 'Select Product' }));
            $.each(products, function(i, option) {
                $('#standby_product').append($('<option>', { value: option.Product_ID, text: option.Product_Name }).data("serialnumbers", option.serial_numbers || []));
            });
        });

        $(document).on("change", "#standby_product", function() {
            var selectedOption = $(this).find('option:selected');
            var serials = selectedOption.data('serialnumbers') || [];
            $('#productSerialNo').empty().append($('<option>', { value: '', text: '—' }));
            $.each(serials, function(i, option) {
                $('#productSerialNo').append($('<option>', { value: option.id, text: option.sr_number }));
            });
        });

        $(function() {
            var form = document.getElementById("myForm");
            var tableBody = document.querySelector("#myTable tbody");

            form.addEventListener("submit", function(event) {
                event.preventDefault();

                var standby_date = $("#standby_date").val();
                var standbyType = $("#standbyType option:selected").val();
                var standbyType_text = $("#standbyType option:selected").text();
                var product_type = $("#product_type option:selected").val();
                var product_type_text = $("#product_type option:selected").text();
                var standby_product = $("#standby_product option:selected").val();
                var standby_product_text = $("#standby_product option:selected").text();
                var productSerialNo = $("#productSerialNo option:selected").val();
                var productSerialNo_text = $("#productSerialNo option:selected").text() || '—';
                var product_quantity = $("#product_quantity").val() || "1";
                var product_amount = $("#product_amount").val();
                var other_details = $("#other_details").val() || '';

                var isValid = true;
                $('#myForm .required').each(function() {
                    var $el = $(this);
                    if (!$el.val() || $el.val().toString().trim() === '') {
                        $el.addClass('is-invalid');
                        isValid = false;
                    } else {
                        $el.removeClass('is-invalid');
                    }
                });

                if (!isValid) return;

                var newRow = document.createElement("tr");
                newRow.innerHTML = '<td data-key="issue_date" data-value="' + standby_date + '">' + standby_date + '</td>' +
                    '<td data-key="type" data-value="' + standbyType + '">' + standbyType_text + '</td>' +
                    '<td data-key="product_type" data-value="' + product_type + '">' + product_type_text + '</td>' +
                    '<td data-key="product_id" data-value="' + standby_product + '">' + standby_product_text + '</td>' +
                    '<td data-key="serial_no" data-value="' + (productSerialNo || '') + '">' + productSerialNo_text + '</td>' +
                    '<td class="text-center" data-key="quantity" data-value="' + product_quantity + '">' + product_quantity + '</td>' +
                    '<td class="text-right" data-key="amount" data-value="' + product_amount + '">' + product_amount + '</td>' +
                    '<td data-key="description" data-value="' + other_details.replace(/"/g, '&quot;') + '">' + other_details + '</td>' +
                    '<td class="text-center"><button type="button" class="btn btn-outline-danger btn-sm deleteRow" title="Remove line"><i class="fas fa-trash-alt"></i></button></td>';
                tableBody.appendChild(newRow);

                var dctotal = parseInt($("#dc_total_cost").text(), 10) || 0;
                $("#dc_total_cost").text(dctotal + parseInt(product_amount, 10));

                $("#standby_product").empty().append($('<option>', { value: '', text: 'Select Product' }));
                $("#productSerialNo").empty().append($('<option>', { value: '', text: '—' }));
                $("#product_type").val("");
                $("#product_quantity").val(1);
                $("#product_amount").val(0);
                $("#other_details").val("");
                updateTableUI();
            });

            updateTableUI();
        });
    </script>
    @stop
</x-app-layout>
