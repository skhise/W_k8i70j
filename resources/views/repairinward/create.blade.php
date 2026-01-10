<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Defective/Repair Inward</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('repairinwards.index') }}" class="btn btn-icon icon-left btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Back
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible show fade">
                                        <div class="alert-body">
                                            <button class="close" data-dismiss="alert">
                                                <span>&times;</span>
                                            </button>
                                            {{ session('success') }}
                                        </div>
                                    </div>
                                @endif

                                @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible show fade">
                                        <div class="alert-body">
                                            <button class="close" data-dismiss="alert">
                                                <span>&times;</span>
                                            </button>
                                            {{ session('error') }}
                                        </div>
                                    </div>
                                @endif

                                @if($errors->any())
                                    <div class="alert alert-danger alert-dismissible show fade">
                                        <div class="alert-body">
                                            <button class="close" data-dismiss="alert">
                                                <span>&times;</span>
                                            </button>
                                            <ul class="mb-0">
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif

                                <form action="{{ route('repairinwards.store') }}" method="POST" id="repair-inward-form">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Ref. C <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" name="defective_date" value="{{ old('defective_date', date('Y-m-d')) }}" required>
                                                @error('defective_date')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Customer</label>
                                                <select class="form-control select2" name="customer_id" id="customer_id">
                                                    <option value="">Select Customer</option>
                                                    @foreach($customers as $customer)
                                                        <option value="{{ $customer->CST_ID }}" {{ old('customer_id') == $customer->CST_ID ? 'selected' : '' }}>
                                                            {{ $customer->CST_Name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Ticket No. <span class="text-muted">(Optional)</span></label>
                                                <select class="form-control select2" name="ticket_no" id="ticket_no" disabled>
                                                    <option value="">Select Customer First</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Status <span class="text-danger">*</span></label>
                                                <select class="form-control select2" name="status_id" id="status_id" required>
                                                    <option value="">Select Status</option>
                                                    @foreach($repairStatuses as $status)
                                                        <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>{{ $status->status_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <h5>Product/Spare</h5>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Spare Type</label>
                                                        <select class="form-control select2" name="spare_type_id" id="spare_type_id">
                                                            <option value="">Select an Option</option>
                                                            @foreach($productTypes as $type)
                                                                <option value="{{ $type->id }}" {{ old('spare_type_id') == $type->id ? 'selected' : '' }}>{{ $type->type_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Spare / Model Name</label>
                                                        <input type="text" class="form-control" name="part_model_name" id="part_model_name" value="{{ old('part_model_name') }}" placeholder="Part/Model Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Spare Description</label>
                                                        <input type="text" class="form-control" name="spare_description" id="spare_description" value="{{ old('spare_description') }}" placeholder="Spare Description">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Current Product Location</label>
                                                        <input type="text" class="form-control" name="current_product_location" id="current_product_location" value="{{ old('current_product_location') }}" placeholder="Current Product Location">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Remark</label>
                                                <textarea class="form-control" name="remark" rows="3">{{ old('remark') }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mt-4">
                                        <button type="submit" class="btn btn-primary" id="save-btn">
                                            <span class="btn-text">Save</span>
                                            <span class="btn-loader" style="display: none;">
                                                <i class="fas fa-spinner fa-spin"></i> Saving...
                                            </span>
                                        </button>
                                        <a href="{{ route('repairinwards.index') }}" class="btn btn-danger float-right mr-2">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @section('script')
    <script>
        $(document).ready(function() {
            $('.select2').select2();
            
            // Load tickets when customer is selected
            $('#customer_id').on('change', function() {
                const customerId = $(this).val();
                const ticketSelect = $('#ticket_no');
                
                if (customerId) {
                    ticketSelect.prop('disabled', false);
                    ticketSelect.empty().append('<option value="">Loading...</option>').trigger('change');
                    
                    $.ajax({
                        url: '{{ route("repairinwards.get-tickets") }}',
                        type: 'GET',
                        data: { customer_id: customerId },
                        dataType: 'json',
                        success: function(response) {
                            ticketSelect.empty();
                            ticketSelect.append('<option value="">Select Ticket (Optional)</option>');
                            
                            if (response.tickets && response.tickets.length > 0) {
                                $.each(response.tickets, function(index, ticket) {
                                    ticketSelect.append($('<option>', {
                                        value: ticket.service_no,
                                        text: ticket.service_no
                                    }));
                                });
                            } else {
                                ticketSelect.append($('<option>', {
                                    value: '',
                                    text: 'No tickets found'
                                }));
                            }
                            
                            // Reinitialize select2 after updating options
                            ticketSelect.select2('destroy').select2();
                        },
                        error: function(xhr, status, error) {
                            console.error('Error loading tickets:', {
                                status: xhr.status,
                                statusText: xhr.statusText,
                                responseText: xhr.responseText,
                                error: error
                            });
                            ticketSelect.empty();
                            let errorMsg = 'Error loading tickets';
                            if (xhr.responseJSON && xhr.responseJSON.error) {
                                errorMsg += ': ' + xhr.responseJSON.error;
                            }
                            ticketSelect.append('<option value="">' + errorMsg + '</option>');
                            ticketSelect.select2('destroy').select2();
                        }
                    });
                } else {
                    ticketSelect.prop('disabled', true);
                    ticketSelect.empty().append('<option value="">Select Customer First</option>');
                    ticketSelect.select2('destroy').select2();
                }
            });
        });

        // Form validation and submission
        $('#repair-inward-form').on('submit', function(e) {
            const partModelName = $('#part_model_name').val();
            const alternateSn = $('#alternate_sn').val();
            const saveBtn = $('#save-btn');
            const btnText = saveBtn.find('.btn-text');
            const btnLoader = saveBtn.find('.btn-loader');

            // Client-side validation
            if (!partModelName) {
                e.preventDefault();
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter at least Spare / Model Name',
                    icon: 'warning',
                    confirmButtonColor: '#d33',
                });
                return false;
            }

            // Show loader
            saveBtn.prop('disabled', true);
            btnText.hide();
            btnLoader.show();
        });
    </script>
    @stop
</x-app-layout>

