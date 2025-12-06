<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>View Defective/Repair Inward</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('repairinwards.edit', $repairinward->id) }}" class="btn btn-icon icon-left btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="{{ route('repairinwards.index') }}" class="btn btn-icon icon-left btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Back
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>Defective No.:</strong></label>
                                            <p>{{ $repairinward->defective_no }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>Defective Date:</strong></label>
                                            <p>{{ $repairinward->defective_date ? date('d M Y', strtotime($repairinward->defective_date)) : 'N/A' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>Customer Name:</strong></label>
                                            <p>{{ $repairinward->customer->CST_Name ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>Ticket No.:</strong></label>
                                            <p>{{ $repairinward->ticket_no ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>Status:</strong></label>
                                            <p style="display: flex; align-items: center;">
                                                <span class="badge badge-{{ $repairinward->repairStatus && $repairinward->repairStatus->id == 1 ? 'primary' : 'success' }}">
                                                    {{ $repairinward->repairStatus->status_name ?? 'N/A' }}
                                                </span>
                                                <button type="button" class="btn btn-sm btn-info ml-2" data-toggle="modal" data-target="#changeStatusModal">
                                                    <i class="fas fa-edit"></i> Change Status
                                                </button>
                                            </p>
                                        </div>
                                    </div>
                                    @if($repairinward->remark)
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><strong>Remark:</strong></label>
                                            <p>{{ $repairinward->remark }}</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                <hr>
                                <h5>Product/Spare Details</h5>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>Spare Type:</strong></label>
                                            <p>{{ $repairinward->spareType->type_name ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>Part/Model Name:</strong></label>
                                            <p>{{ $repairinward->part_model_name ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>Alternate S/N:</strong></label>
                                            <p>{{ $repairinward->alternate_sn ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>Spare Description:</strong></label>
                                            <p>{{ $repairinward->spare_description ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>Product Remark:</strong></label>
                                            <p>{{ $repairinward->product_remark ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>Current Product Location:</strong></label>
                                            <p>{{ $repairinward->current_product_location ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <h5>Status Change History</h5>
                                <div class="table-responsive mt-3">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Date & Time</th>
                                                <th>Old Status</th>
                                                <th>New Status</th>
                                                <th>Changed By</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($repairinward->statusHistory->count() > 0)
                                                @foreach($repairinward->statusHistory as $history)
                                                    <tr>
                                                        <td>{{ $history->created_at ? date('d M Y H:i', strtotime($history->created_at)) : 'N/A' }}</td>
                                                        <td>{{ $history->oldStatus->status_name ?? 'N/A' }}</td>
                                                        <td>{{ $history->newStatus->status_name ?? 'N/A' }}</td>
                                                        <td>{{ $history->changedBy->name ?? 'N/A' }}</td>
                                                        <td>{{ $history->remarks ?? 'N/A' }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5" class="text-center">No status history available</td>
                                                </tr>
                                            @endif
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

    <!-- Change Status Modal -->
    <div class="modal fade" id="changeStatusModal" tabindex="-1" role="dialog" aria-labelledby="changeStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeStatusModalLabel">Change Status</h5>
                    <button type="button" class="close" id="close-modal-btn" data-dismiss="modal" onclick="document.getElementById('changeStatusModal').style.display='none'; document.body.classList.remove('modal-open'); document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="change-status-form">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Current Status</label>
                            <input type="text" class="form-control" value="{{ $repairinward->repairStatus->status_name ?? 'N/A' }}" disabled>
                        </div>
                        <div class="form-group">
                            <label>New Status <span class="text-danger">*</span></label>
                            <select class="form-control select2" name="status_id" id="modal_status_id" required>
                                <option value="">Select Status</option>
                                @foreach($repairStatuses as $status)
                                    <option value="{{ $status->id }}" {{ $repairinward->status_id == $status->id ? 'selected' : '' }}>
                                        {{ $status->status_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Remarks</label>
                            <textarea class="form-control" name="remarks" id="modal_remarks" rows="3" placeholder="Enter remarks for status change"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="cancel-modal-btn" data-dismiss="modal" onclick="document.getElementById('changeStatusModal').style.display='none'; document.body.classList.remove('modal-open'); document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="update-status-btn">
                            <span class="btn-text">Update Status</span>
                            <span class="btn-loader" style="display: none;">
                                <i class="fas fa-spinner fa-spin"></i> Updating...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @section('script')
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            // Close modal handlers - simple and direct approach
            function closeModal() {
                const modal = $('#changeStatusModal');
                // Remove show class and hide
                modal.removeClass('show');
                modal.css('display', 'none');
                // Remove backdrop
                $('.modal-backdrop').remove();
                // Remove body classes
                $('body').removeClass('modal-open');
                $('body').css('padding-right', '');
                // Try Bootstrap method if available
                if (typeof modal.modal === 'function') {
                    modal.modal('hide');
                }
            }

            // Attach handlers
            $(document).on('click', '#close-modal-btn', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closeModal();
            });

            $(document).on('click', '#cancel-modal-btn', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closeModal();
            });

            // Handle status change form submission
            $('#change-status-form').on('submit', function(e) {
                e.preventDefault();
                
                const statusId = $('#modal_status_id').val();
                const remarks = $('#modal_remarks').val();
                const updateBtn = $('#update-status-btn');
                const btnText = updateBtn.find('.btn-text');
                const btnLoader = updateBtn.find('.btn-loader');

                if (!statusId) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please select a status',
                        icon: 'warning',
                        confirmButtonColor: '#d33',
                    });
                    return false;
                }

                // Show loader
                updateBtn.prop('disabled', true);
                btnText.hide();
                btnLoader.show();

                $.ajax({
                    url: '{{ route("repairinwards.update-status", $repairinward->id) }}',
                    type: 'POST',
                    data: {
                        status_id: statusId,
                        remarks: remarks,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message || 'Status updated successfully',
                                icon: 'success',
                                confirmButtonColor: '#28a745',
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message || 'Failed to update status',
                                icon: 'error',
                                confirmButtonColor: '#d33',
                            });
                            updateBtn.prop('disabled', false);
                            btnText.show();
                            btnLoader.hide();
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = 'Failed to update status';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            title: 'Error!',
                            text: errorMsg,
                            icon: 'error',
                            confirmButtonColor: '#d33',
                        });
                        updateBtn.prop('disabled', false);
                        btnText.show();
                        btnLoader.hide();
                    }
                });
            });

            // Reset form when modal is closed
            $('#changeStatusModal').on('hidden.bs.modal', function() {
                $('#change-status-form')[0].reset();
                $('#modal_status_id').val('{{ $repairinward->status_id }}').trigger('change');
                $('#update-status-btn').prop('disabled', false);
                $('#update-status-btn .btn-text').show();
                $('#update-status-btn .btn-loader').hide();
            });
        });
    </script>
    @stop
</x-app-layout>

