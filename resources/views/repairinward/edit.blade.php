<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Edit Defective/Repair Inward</h4>
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

                                <form action="{{ route('repairinwards.update', $repairInward->id) }}" method="POST" id="repair-inward-form">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Defective No.</label>
                                                <input type="text" class="form-control" value="{{ $repairInward->defective_no }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Defective Date <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" name="defective_date" value="{{ old('defective_date', $repairInward->defective_date) }}" required>
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
                                                        <option value="{{ $customer->CST_ID }}" {{ old('customer_id', $repairInward->customer_id) == $customer->CST_ID ? 'selected' : '' }}>
                                                            {{ $customer->CST_Name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Ticket No. <span class="text-muted">(Optional)</span></label>
                                                <select class="form-control select2" name="ticket_no" id="ticket_no">
                                                    <option value="">Select Ticket (Optional)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Remark</label>
                                                <textarea class="form-control" name="remark" rows="3">{{ old('remark', $repairInward->remark) }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <h5>Defective Product/Spare Inward</h5>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Spare Type</label>
                                                        <select class="form-control select2" name="spare_type_id" id="spare_type_id">
                                                            <option value="">Select an Option</option>
                                                            @foreach($productTypes as $type)
                                                                <option value="{{ $type->id }}" {{ old('spare_type_id', $repairInward->spare_type_id ?? '') == $type->id ? 'selected' : '' }}>{{ $type->type_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Name Part/Model</label>
                                                        <input type="text" class="form-control" name="part_model_name" id="part_model_name" value="{{ old('part_model_name', $repairInward->part_model_name ?? '') }}" placeholder="Part/Model Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Spare Description</label>
                                                        <input type="text" class="form-control" name="spare_description" id="spare_description" value="{{ old('spare_description', $repairInward->spare_description ?? '') }}" placeholder="Spare Description">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Current Product Location</label>
                                                        <input type="text" class="form-control" name="current_product_location" id="current_product_location" value="{{ old('current_product_location', $repairInward->current_product_location ?? '') }}" placeholder="Current Product Location">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mt-4">
                                        <button type="submit" class="btn btn-primary" id="save-btn">
                                            <span class="btn-text">Update</span>
                                            <span class="btn-loader" style="display: none;">
                                                <i class="fas fa-spinner fa-spin"></i> Updating...
                                            </span>
                                        </button>
                                        <a href="{{ route('repairinwards.index') }}" class="btn btn-secondary">Cancel</a>
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
            
            // Load tickets when customer is selected or on page load
            function loadTickets(customerId, selectedTicket = null) {
                const ticketSelect = $('#ticket_no');
                
                if (customerId) {
                    ticketSelect.prop('disabled', false);
                    ticketSelect.empty().append('<option value="">Loading...</option>').trigger('change');
                    
                    $.ajax({
                        url: '{{ route("repairinwards.get-tickets") }}',
                        type: 'GET',
                        data: { customer_id: customerId },
                        success: function(response) {
                            ticketSelect.empty();
                            ticketSelect.append('<option value="">Select Ticket (Optional)</option>');
                            
                            if (response.tickets && response.tickets.length > 0) {
                                $.each(response.tickets, function(index, ticket) {
                                    const isSelected = selectedTicket && ticket.service_no == selectedTicket;
                                    ticketSelect.append($('<option>', {
                                        value: ticket.service_no,
                                        text: ticket.service_no,
                                        selected: isSelected
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
                            console.error('Error loading tickets:', error);
                            ticketSelect.empty();
                            ticketSelect.append('<option value="">Error loading tickets</option>');
                            ticketSelect.select2('destroy').select2();
                        }
                    });
                } else {
                    ticketSelect.prop('disabled', true);
                    ticketSelect.empty().append('<option value="">Select Customer First</option>');
                    ticketSelect.select2('destroy').select2();
                }
            }
            
            // Load tickets on page load if customer is already selected
            const initialCustomerId = $('#customer_id').val();
            const initialTicketNo = '{{ old("ticket_no", $repairInward->ticket_no) }}';
            if (initialCustomerId) {
                loadTickets(initialCustomerId, initialTicketNo);
            }
            
            // Load tickets when customer changes
            $('#customer_id').on('change', function() {
                loadTickets($(this).val());
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
            if (!partModelName && !alternateSn) {
                e.preventDefault();
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter at least Part/Model Name or Alternate S/N',
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

